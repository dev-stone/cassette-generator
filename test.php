<?php

use Acg\Init;

require 'vendor/autoload.php';

$init = new Init();

$status = $init->feature() ? 'ok' : 'failure';

echo 'Project setup status: ' . $status . PHP_EOL;