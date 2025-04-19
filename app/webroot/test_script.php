<?php
// डेटाबेस बैकअप के लिए कॉन्फ़िगरेशन
$backupDir = __DIR__ . '/backups'; // बैकअप फोल्डर
$dbHost = 'hopesoftwares.com';
$dbUser = 'olh9vcykd20h';
$dbPassword = 'q3M1L!c8Bt4q';
$databases = ['hope_master', 'db_hope', 'db_Ayushman', 'db_HopeHospital']; // सभी डेटाबेस के नाम

// बैकअप फोल्डर सुनिश्चित करें
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

// डेटाबेस बैकअप प्रक्रिया
foreach ($databases as $dbName) {
    $timestamp = date('Y-m-d_H-i-s');
    $backupFile = "{$backupDir}/{$dbName}_backup.sql";
    $zipFile = "{$backupDir}/{$dbName}_backup_{$timestamp}.zip";

    // `mysqldump` कमांड चलाएं
    $command = "/usr/bin/mysqldump -h {$dbHost} -u {$dbUser} -p'{$dbPassword}' {$dbName} > {$backupFile}";
    exec($command, $output, $result);

    if ($result !== 0) {
        echo "Error: Failed to back up database: {$dbName}\n";
        continue;
    }

    // ज़िप फाइल बनाएं
    $zip = new ZipArchive();
    if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
        $zip->addFile($backupFile, basename($backupFile));
        $zip->close();
        unlink($backupFile); // बैकअप SQL फाइल को डिलीट करें
        echo "Backup completed and zipped for: {$dbName}\n";
    } else {
        echo "Error: Could not create ZIP file for: {$dbName}\n";
    }
}

echo "All backups completed.\n";
