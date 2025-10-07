<?php
// Include the configuration to get constants
require_once __DIR__ . '/../../core/define.php';

header('Content-Type: application/javascript');

// Check if the file exists before trying to read it
$jsFile = ASSET_PATH . '/tw-script.js';
if (file_exists($jsFile)) {
    echo file_get_contents($jsFile);
} else {
    echo '// Tailwind script file not found: ' . $jsFile;
}