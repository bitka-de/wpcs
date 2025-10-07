<?php
// Include the configuration to get constants
require_once __DIR__ . '/../../core/define.php';

header('Content-Type: text/css; charset=UTF-8');

// Check if the file exists before trying to read it
$cssFile = ASSET_PATH . '/styles.css';
if (file_exists($cssFile)) {
    echo file_get_contents($cssFile);
} else {
    echo '/* Stylesheet not found: ' . $cssFile . ' */';
}