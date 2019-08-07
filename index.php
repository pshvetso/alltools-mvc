<?php
/**
 * Created by PhpStorm.
 * User: Pub
 * Date: 07.08.2019
 * Time: 5:17
 */

/**
 * Front controller
 *
 * 
 */

use Core\App;

require_once './vendor/autoload.php';

$app = new App();
$app->dispatch();
