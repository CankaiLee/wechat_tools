<?php
/**
 * Created by PhpStorm.
 * User: cota
 * Date: 2020-03-04
 * Time: 18:11
*/

require "../src/Wechat.php";
require "../src/MiniProgram.php";

error_reporting(E_ALL);
$wechat = new weixin\MiniProgram;
$wechat->setAppId('wxc081988305e3d1a0')
    ->setAppSecret('c3fbab33f6b4aa528d3e610fafe3734b');

print_r($wechat->get_access_token());
