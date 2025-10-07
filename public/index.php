<?php

declare(strict_types=1);
session_start();

const BASE_PATH = __DIR__ . '/../';

require_once BASE_PATH . 'core/define.php';
require_once BASE_PATH . 'core/app.php';

date_default_timezone_set(DATE_ZONE);


# FIRST RUN
if (file_exists(BASE_PATH . 'first-run.php')) {
  require_once BASE_PATH . 'first-run.php';
  exit;
}


$view = new View();
$view->render('page.home');

exit;