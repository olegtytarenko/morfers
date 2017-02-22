<?php
/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 22.02.17
 * Time: 12:23
 */
define('EXT','.php');
$dirSrc = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload'.EXT;
if(is_file($dirSrc)) {
    require_once $dirSrc;
}
