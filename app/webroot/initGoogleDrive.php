<?php
require __DIR__ . '/../vendor/autoload.php';

define('CLIENT_SECRET_PATH', __DIR__ . '/../Config/client_secret.json');
define('TOKEN_PATH', __DIR__ . '/../Config/token.json');

// Google Client इनिशियलाइज़ करें
$client = new Google_Client();
$client->setAuthConfig(CLIENT_SECRET_PATH);
$client->setAccessType('offline');
$client->setPrompt('consent');

// Redirect URI को http://localhost पर सेट करें
$client->setRedirectUri('http://localhost');
$client->addScope(Google_Service_Drive::DRIVE);

// Auth URL जनरेट करें
$authUrl = $client->createAuthUrl();
echo "🔗 इस URL को ब्राउज़र में खोलें और Google से लॉगिन करें:\n$authUrl\n";
echo "📌 कृपया कोड यहां डालें (जब ब्राउज़र में रीडायरेक्ट हो जाए):\n";
$authCode = trim(fgets(STDIN));

// Access Token प्राप्त करें
$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

if (isset($accessToken['error'])) {
    echo "❌ Error: " . $accessToken['error_description'] . "\n";
    exit;
}

// ✅ Refresh Token भी Save करें
if (!isset($accessToken['refresh_token'])) {
    echo "⚠️ Warning: Refresh Token नहीं मिला! पहले टोकन फाइल डिलीट करें और फिर से रन करें।\n";
} else {
    echo "✅ Refresh Token मिला और सेव हो गया!\n";
}

// Token फाइल सेव करें
if (!file_exists(dirname(TOKEN_PATH))) {
    mkdir(dirname(TOKEN_PATH), 0700, true);
}

file_put_contents(TOKEN_PATH, json_encode($accessToken));
echo "✅ Token सेव हो गया: " . TOKEN_PATH . "\n";
?>
