<?php
namespace WormOfTime\WechatTools\weixin\tools;

use WormOfTime\WechatTools\weixin\Wechat;

/**
 * 公众号菜单类
 * Class Menu
 * @package WormOfTime\WechatTools\weixin\tools
 */
class Menu extends Wechat
{
    /**
     * 创建菜单
     * @param array $post
     * @return bool
     */
    public function create($post = array())
    {
        try {
            if (! is_array($post)) {
                $this->err_code = 40003;
                $this->err_msg = '参数格式错误';
                return false;
            }

            $access_token = $this->get_access_token();
            if ($access_token === false) {
                return false;
            }
            $uri = '/cgi-bin/menu/create?access_token=' . $access_token;

            $response = $this->getHttpClient()->post($uri, array(
                'json' => $post
            ));

            if ($response->getStatusCode() == 200) {
                $json_string = $response->getBody()->getContents();
                $json_array = \GuzzleHttp\json_decode($json_string, true);
                if (!$json_array || $json_array['errcode'] > 0) {
                    $this->err_code = $this->element('errcode', $json_array);
                    $this->err_msg = $this->element('errmsg', $json_array);
                    return false;
                }
            } else {
                $this->err_code = 40002;
                $this->err_msg = '访问接口出错'.$uri;
                return false;
            }

            return true;
        } catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }
}