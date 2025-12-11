<?php
/**
 * Cache Clearer
 *
 * Upload this file to your theme root and visit it in your browser:
 * https://annejans100.sg-host.com/wp-content/themes/thom/clear-cache.php
 *
 * Delete this file after use for security!
 */

// Security: Only allow in development or with specific query parameter
$secret = 'thom2024'; // Change this to something secure
if (!isset($_GET['secret']) || $_GET['secret'] !== $secret) {
    die('Access denied. Add ?secret=thom2024 to the URL.');
}

$cacheDir = __DIR__ . '/../../../cache/acorn/framework/views/';
$clearedFiles = 0;

if (is_dir($cacheDir)) {
    $files = glob($cacheDir . '*');

    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            $clearedFiles++;
        }
    }

    echo "<h1>✅ Blade Cache Cleared!</h1>";
    echo "<p>Deleted {$clearedFiles} cached view files.</p>";
    echo "<p><strong>Remember to delete this file (clear-cache.php) for security!</strong></p>";
    echo "<hr>";
    echo "<p><a href='/'>← Back to website</a></p>";
} else {
    echo "<h1>❌ Error</h1>";
    echo "<p>Cache directory not found: {$cacheDir}</p>";
}
