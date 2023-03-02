<?php

require_once __DIR__ . '/../../AutoLoad/AutoLoad.php';

$viewName = $_POST['view'];
if (empty($viewName)) {
    echo "";
    return;
}

$viewName = str_replace('/', '\\', $viewName);
$parts = explode('\\', $viewName);
$parts = array_map('ucfirst', $parts);
$viewName = implode('\\', $parts);

$viewClass = "View\\$viewName";

$view = new $viewClass();
echo $view->render($_POST);
