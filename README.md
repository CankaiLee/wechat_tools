# 微信开发工具类

## 初始化

```php
$wechat = new MiniProgram;

$wechat->setAppId(APP_ID)
    ->setAppSecret(APP_SECRET);

# 获取access_token
$result = $wechat->get_access_token();
```

## 接口介绍

