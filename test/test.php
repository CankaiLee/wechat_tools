<?php

require '../vendor/autoload.php';

use WormOfTime\WechatTools\weixin\MiniProgram;

$wechat = new MiniProgram;

$wechat->setAppId('wxc081988305e3d1a0')
    ->setAppSecret('c3fbab33f6b4aa528d3e610fafe3734b');

$result = $wechat->get_access_token();
if ($result === false) {
    echo $wechat->getErrMsg();
} else {
    print_r($result);
}
