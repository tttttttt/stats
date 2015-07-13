<?php

if(!defined('IN_PROJECT')) {
  exit;
}

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/usr/share/php/smarty3');

define('DEBUG_TEMPLATE', false);
define('BASEDIR', getcwd());

define('DB_HOST', 'localhost');
define('DB_NAME', 'test');
define('DB_USERNAME', 'test');
define('DB_PASSWORD', 'test');

