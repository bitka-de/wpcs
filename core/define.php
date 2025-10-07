<?php

declare(strict_types=1);

const APP_NAME = "Bitka";
const APP_URL = "http://blog.test";

# Paths
const DATA_PATH = __DIR__ . '/../data/';
const INC_PATH = __DIR__ . '/../inc/';
const VIEW_PATH = __DIR__ . '/../app/views/';
const ASSET_PATH = __DIR__ . '/../app/assets/';
const LAYOUT_PATH = __DIR__ . '/../app/layouts/';
const COMPONENT_PATH = __DIR__ . '/../app/components/';

# Timezone
const DATE_ZONE = 'Europe/Berlin';
const HTML_LANG = 'de';

date_default_timezone_set(DATE_ZONE);

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  define('EDIT_MODE', true);
} else {
  define('EDIT_MODE', false);
}

const DEV_MODE = true;