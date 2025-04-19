<?php
require __DIR__ . '/../vendor/autoload.php';

define('CLIENT_SECRET_PATH', __DIR__ . '/../Config/client_secret.json');
define('TOKEN_PATH', __DIR__ . '/../Config/token.json');

function getClient() {
    $client = new Google_Client();
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');
    $client->addScope(Google_Service_Drive::DRIVE);

    if (file_exists(TOKEN_PATH)) {
        $accessToken = json_decode(file_get_contents(TOKEN_PATH), true);
        $client->setAccessToken($accessToken);

        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                file_put_contents(TOKEN_PATH, json_encode($client->getAccessToken()));
            } else {
                echo "❌ Refresh token नहीं मिला! कृपया initGoogleDrive.php फिर से चलाएं।\n";
                exit;
            }
        }
    } else {
        echo "❌ Token फाइल नहीं मिली। पहले initGoogleDrive.php चलाएं।\n";
        exit;
    }

    return $client;
}

// ✅ Google Drive पर पहले से मौजूद फाइल्स की लिस्ट प्राप्त करें
function getUploadedFiles($service) {
    $uploadedFiles = [];
    $pageToken = null;

    do {
        $response = $service->files->listFiles([
            'q' => "'root' in parents and trashed=false",
            'fields' => 'files(name)',
            'pageToken' => $pageToken
        ]);

        foreach ($response->getFiles() as $file) {
            $uploadedFiles[] = $file->getName();
        }

        $pageToken = $response->getNextPageToken();
    } while ($pageToken);

    return $uploadedFiles;
}

// ✅ 3 दिन से पुरानी बैकअप फाइल्स को डिलीट करें
function deleteOldBackups($backupDir) {
    $files = glob($backupDir . '/*.zip');
    $now = time();

    foreach ($files as $file) {
        if (filemtime($file) < ($now - 3 * 24 * 60 * 60)) { // 3 दिन से पुरानी फाइल
            unlink($file);
            echo "🗑️ Deleted Old Backup: " . basename($file) . "\n";
        }
    }
}

try {
    $backupDir = '/home/olh9vcykd20h/public_html/app/webroot/backups'; // Backup folder
    $files = glob($backupDir . '/*.zip');

    if (empty($files)) {
        echo "📌 कोई नई बैकअप फाइल नहीं मिली।\n";
        exit;
    }

    $client = getClient();
    $service = new Google_Service_Drive($client);
    
    // ✅ Google Drive से पहले से uploaded files की लिस्ट ले रहे हैं
    $uploadedFiles = getUploadedFiles($service);

    foreach ($files as $filePath) {
        $fileName = basename($filePath);

        // ✅ अगर फाइल पहले से Google Drive पर मौजूद है, तो स्किप करें
        if (in_array($fileName, $uploadedFiles)) {
            echo "⏭️ Skipping (Already Uploaded): $fileName\n";
            continue;
        }

        echo "⬆️ Uploading: $fileName\n";

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $fileName,
            'parents' => ['root'] // इसे किसी खास फोल्डर में अपलोड करने के लिए फोल्डर ID दें
        ]);

        $content = file_get_contents($filePath);

        $file = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'application/zip',
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        echo "✅ Uploaded Successfully: $fileName (File ID: " . $file->id . ")\n";
    }

    echo "🎉 सभी नई फाइल्स सफलतापूर्वक अपलोड हो गईं।\n";

    // ✅ 3 दिन से पुरानी फाइल्स को डिलीट करें
    deleteOldBackups($backupDir);

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
