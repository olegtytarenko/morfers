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
use Kind\Kind;
echo Kind::init('Ukranian', 56)->numberToText(), '<br>';
echo Kind::init('Ukranian', 456878)->numberToText(), '<br>';
echo Kind::init('Russian', 5456)->numberToText(), '<br>';