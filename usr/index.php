<?php
/**
 * Created by PhpStorm.
 * User: olegtytarenko
 * Date: 22.02.17
 * Time: 10:43
 */

define('EXT','.php');

$dirSrc = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload'.EXT;
if(is_file($dirSrc)) {
    require_once $dirSrc;
}
var_dump( (4784 / 1000) % 1000 );
use Kind\Kind;
echo Kind::init('Russian', 1784)->numberToText();