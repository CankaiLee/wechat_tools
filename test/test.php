<?php

require '../vendor/autoload.php';

use WormOfTime\WechatTools\weixin\MiniProgram;

$wechat = new MiniProgram;

$wechat->setAppId('wxc081988305e3d1a0')
    ->setAppSecret('c3fbab33f6b4aa528d3e610fafe3734b');

$result = $wechat->msgSecCheck("你个");
if ($result === false) {
    echo $wechat->getErrMsg();
} else {
    var_dump($result);
}

$result = $wechat->mediaCheck('https://cdn.shop.chjchina.com/upload/7b3c876c6bf1f5cf9b2cee848c0b7650.jpg');
if ($result === false) {
    echo $wechat->getErrMsg();
} else {
    var_dump($result);
}