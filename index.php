<?php
ini_set('display_errors', 1);
require_once 'autoload.php';
require_once 'vendor/autoload.php';
session_start();




$controllerPath = 'blog_mvc\\controller\\';
$nameSpacePath = 'blog\\controller\\';
if( isset( $_REQUEST['controller'] ) ) {
    $controllerClassName = $nameSpacePath . ucfirst( $_REQUEST['controller'] ) . 'Controller'; 
 //   array_shift( $_REQUEST );
    $controller = new $controllerClassName();
} else {
    $controller = new blog\controller\IndexController();
}



