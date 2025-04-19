<?php
App::uses('ConnectionManager', 'Model');

class BackupShell extends AppShell {
    public function main() {
        $this->backupDatabases();
    }

    public function backupDatabases() {
        $this->out('Backup process started.');

        // Backup configurations
        $backupDir = APP . 'webroot' . DS . 'backups';
        $dbHost = 'hopesoftwares.com';
        $dbUser = 'olh9vcykd20h';
        $dbPassword = 'q3M1L!c8Bt4q';
        $databases = ['hope_master', 'db_hope', 'db_Ayushman', 'db_HopeHospital'];

        // Create backup directory if not exists
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
            $this->out("Backup directory created: {$backupDir}");
        }

        foreach ($databases as $dbName) {
            $timestamp = date('Y-m-d_H-i-s');
            $backupFile = "{$backupDir}/{$dbName}_backup.sql";
            $zipFile = "{$backupDir}/{$dbName}_backup_{$timestamp}.zip";

            // Run mysqldump command
            $command = "/usr/bin/mysqldump -h {$dbHost} -u {$dbUser} -p'{$dbPassword}' {$dbName} > {$backupFile}";
            $this->out("Executing command: {$command}");
            exec($command, $output, $result);

            // Debugging output
            $this->out("Command Output: " . implode("\n", $output));
            $this->out("Command Result: {$result}");

            if ($result !== 0) {
                $this->out("Error: Failed to back up database: {$dbName}");
                continue;
            }

            // Verify SQL file creation
            if (!file_exists($backupFile)) {
                $this->out("Error: Backup file not found for database: {$dbName}");
                continue;
            }

            // Create ZIP archive
            $this->out("Creating ZIP file for: {$dbName}");
            $zip = new ZipArchive();
            if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($backupFile, basename($backupFile));
                $zip->close();
                unlink($backupFile); // Remove the SQL file after zipping
                $this->out("Backup completed and zipped for: {$dbName}");
            } else {
                $this->out("Error: Could not create ZIP file for: {$dbName}");
            }
        }

        $this->out('Backup process finished.');
    }
}
