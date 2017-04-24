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
$lists =  \Declension\Declension::init('Ukranian', 'Алжир');

?>
<table>
    <tr>
        <td>И.</td>
        <td><?= $lists->getNominative() ?></td>
    </tr>
    <tr>
        <td>Р.</td>
        <td><?= $lists->getGenitive() ?></td>
    </tr>
    <tr>
        <td>Д.</td>
        <td><?= $lists->getDative() ?></td>
    </tr>
    <tr>
        <td>В.</td>
        <td><?= $lists->getAccusative() ?></td>
    </tr>
    <tr>
        <td>Т.</td>
        <td><?= $lists->getInstrumental() ?></td>
    </tr>
    <tr>
        <td>П.</td>
        <td><?= $lists->getPrepositional() ?></td>
    </tr>
</table>
