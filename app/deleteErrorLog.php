<?php
// Error log file का सही path
$errorLogFile = '/home/olh9vcykd20h/public_html/app/Console/error_log';

// Check करें कि file exist करती है या नहीं
if (file_exists($errorLogFile)) {
    // File को delete करें
    if (unlink($errorLogFile)) {
        echo "Error log file deleted successfully.\n";
    } else {
        echo "Failed to delete error log file.\n";
    }
} else {
    echo "Error log file does not exist.\n";
}
