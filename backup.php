<?php
// cPanel credentials
$cpanel_username = 'olh9vcykd20h';
$cpanel_password = 'q3M1L!c8Bt4q';
$domain = 'hopesoftwares.com';

// Same Username and Password for All Databases
$db_user = 'olh9vcykd20h';
$db_password = 'q3M1L!c8Bt4q';

// List of Databases
$databases = [
    'db_hope',
    'db_Ayushman',
    'db_HopeHospital'
];

// Backup folder path
$backup_folder = '/home/olh9vcykd20h/backups/';

// Create timestamped folder
$timestamp = date('Ymd_His');
$backup_path = $backup_folder . "backup_{$timestamp}";
mkdir($backup_path, 0777, true);

// Step 1: Create a Zip Archive (Overwrite if exists)
$zip_file_path = $backup_folder . "backup.zip"; // Replacing with the same name for every new backup
$zip = new ZipArchive();

// Open the zip file (it will overwrite the old file)
if ($zip->open($zip_file_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

    // Step 2: Backup Databases and Add to Zip
    foreach ($databases as $db_name) {
        $backup_file = "{$backup_path}/{$db_name}.sql";
        $command = "mysqldump -u {$db_user} -p{$db_password} {$db_name} > {$backup_file}";
        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            echo "Error backing up database: {$db_name}\n";
        } else {
            echo "Successfully backed up database: {$db_name}\n";
            // Add the database backup file to zip
            $zip->addFile($backup_file, "{$db_name}.sql");
        }
    }

    // Step 3: Backup Project Files and Add to Zip
    $project_path = '/home/olh9vcykd20h/public_html/your_project/';
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($project_path),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $zip->addFile($filePath, substr($filePath, strlen($project_path) + 1));
        }
    }

    // Close the zip archive
    $zip->close();

    echo "Backup completed successfully. All databases and project files saved to {$zip_file_path}.\n";
} else {
    echo "Failed to create zip archive for backups.\n";
}
?>
