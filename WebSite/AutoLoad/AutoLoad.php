<?php


function autoLoad($classname)
{
    echo "inicio: $classname<br>";
    $path = __DIR__ . "/..";
    $classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);

    $filepath =  "$path/$classname.php";

    if (file_exists($filepath)) {

        $includedFiles = get_included_files();
        $includedFiles = array_map('strtolower', $includedFiles);

        if (!in_array(strtolower($filepath), $includedFiles)) {
            require_once $filepath;
        }
    }
}


spl_autoload_register('autoLoad', true, true);
