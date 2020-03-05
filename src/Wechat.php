<?php

namespace WormOfTime\WechatTools\weixin;

use GuzzleHttp\Client;
use WormOfTime\WechatTools\entities\OauthAccessTokenResultEntity;

/**
 * 微信基类
 * Class Wechat
 * @package weixin
 * @property-read Client $http_client
 */
class Wechat
{
    protected $err_code = 0;

    protected $err_msg = '';

    protected $app_id = '';

    protected $app_secret = '';

    protected $http_client = null;

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        if (is_null($this->http_client)) {
            $this->http_client = new Client([
                'base_uri' => 'https://api.weixin.qq.com/',
                'timeout'  => 2.0,
            ]);
        }

        return $this->http_client;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     * @param string $app_id
     * @return Wechat
     */
    public function setAppId($app_id)
    {
        $this->app_id = $app_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return $this->app_secret;
    }

    /**
     * @param string $app_secret
     * @return Wechat
     */
    public function setAppSecret($app_secret)
    {
        $this->app_secret = $app_secret;
        return $this;
    }

    /**
     * @return int
     */
    public function getErrCode()
    {
        return $this->err_code;
    }

    /**
     * @param int $err_code
     * @return Wechat
     */
    public function setErrCode($err_code)
    {
        $this->err_code = $err_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getErrMsg()
    {
        return $this->err_msg;
    }

    /**
     * @param string $err_msg
     * @return Wechat
     */
    public function setErrMsg($err_msg)
    {
        $this->err_msg = $err_msg;
        return $this;
    }

    /**
     * @param $code
     * @return OauthAccessTokenResultEntity|bool
     * @throws \Exception
     */
    public function getOauthAccessToken($code)
    {
        try {
            if (!$code) {
                $this->err_code = 40001;
                $this->err_msg = '缺少必要参数：code';
                return false;
            }

            $uri = '/sns/oauth2/access_token';

            $response = $this->getHttpClient()->get($uri,array(
                'query'=>array(
                    'grant_type'=>'authorization_code',
                    'appid'=>$this->getAppId(),
                    'secret'=>$this->getAppSecret(),
                    'code'=>$code
                )
            ));

            if($response->getStatusCode() == 200)
            {
                $json_string = $response->getBody()->getContents();
                $json_array = \GuzzleHttp\json_decode($json_string, TRUE);
                if (!$json_array || !empty($json_array['errcode']))
                {
                    $this->err_code = $this->element('errcode', $json_array);
                    $this->err_msg = $this->element('errmsg', $json_array);
                    return false;
                }

                $oauthAccessTokenResultEntity = new OauthAccessTokenResultEntity();
                $oauthAccessTokenResultEntity->setAccessToken($this->element('access_token',$json_array));
                $oauthAccessTokenResultEntity->setRefreshToken($this->element('refresh_token',$json_array));
                $oauthAccessTokenResultEntity->setExpiresIn($this->element('expires_in',$json_array));
                $oauthAccessTokenResultEntity->setOpenid($this->element('openid',$json_array));
                $oauthAccessTokenResultEntity->setScope($this->element('scope',$json_array));
            }else {
                $this->err_code = 40002;
                $this->err_msg = '访问接口出错'.$uri;
                return false;
            }

            return $oauthAccessTokenResultEntity;
        } catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }

    /**
     * 检测图片，音频是否包含违法违规内容
     * @param string $media_url
     * @param int $media_type
     * @return bool
     */
    public function mediaCheck($media_url = '', $media_type = 2)
    {
        try {
            $access_token = $this->get_access_token();

            if ($access_token === false) {
                return false;
            }

            $uri = "/wxa/media_check_async?access_token=" . $access_token;

            $response = $this->getHttpClient()->post($uri, array(
                'form_params' => [
                    'media_url' => $media_url,
                    'media_type' => $media_type
                ]
            ));

            if($response->getStatusCode() == 200) {
                $json_string = $response->getBody()->getContents();
                $json_data = \GuzzleHttp\json_decode($json_string, true);
                if (!$json_data || $json_data['errcode'] > 0) {
                    $this->err_code = $this->element('errcode', $json_data);
                    $this->err_msg = $this->element('errmsg', $json_data);
                    return false;
                }

                return true;
            } else {
                $this->err_code = 40002;
                $this->err_msg = '访问接口出错'.$uri;
                return false;
            }
        } catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }

    /**
     * 检测文字是否包含违法违规内容
     * @param string $content
     * @return bool
     */
    public function msgSecCheck($content = '')
    {
        try {
            $access_token = $this->get_access_token();

            if ($access_token === false) {
                return false;
            }

            $uri = "/wxa/msg_sec_check?access_token=" . $access_token;

            $response = $this->getHttpClient()->post($uri, array(
                'form_params' => [
                    'content' => $content
                ]
            ));

            if($response->getStatusCode() == 200) {
                $json_string = $response->getBody()->getContents();
                $json_data = \GuzzleHttp\json_decode($json_string, true);
                if (!$json_data || $json_data['errcode'] > 0) {
                    $this->err_code = $this->element('errcode', $json_data);
                    $this->err_msg = $this->element('errmsg', $json_data);
                    return false;
                }

                return true;
            } else {
                $this->err_code = 40002;
                $this->err_msg = '访问接口出错'.$uri;
                return false;
            }
        } catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }

    /**
     * 获取access_token
     * @return bool|string
     */
    public function get_access_token()
    {
        $uri = "/cgi-bin/token";

        $response = $this->getHttpClient()->get($uri, array(
            'query' => [
                'grant_type' => 'client_credential',
                'appid' => $this->getAppId(),
                'secret' => $this->getAppSecret()
            ],
            'timeout' => 3.0
        ));

        if ($response->getStatusCode() == 200) {
            $json_string = $response->getBody()->getContents();
            $result = \GuzzleHttp\json_decode($json_string, true);

            if (isset($result['access_token'])) {
                return $result['access_token'];
            }
        }

        $this->err_code = 500;
        $this->err_msg = '获取access_token失败';
        return false;
    }

    /**
     * Element
     *
     * Lets you determine whether an array index is set and whether it has a value.
     * If the element is empty it returns NULL (or whatever you specify as the default value.)
     *
     * @param	string
     * @param	array
     * @param	mixed
     * @return	mixed	depends on what the array contains
     */
    protected function element($item, array $array, $default = NULL)
    {
        return array_key_exists($item, $array) ? $array[$item] : $default;
    }

    /**
     * Create a "Random" String
     *
     * @param	string	type of random string.  basic, alpha, alnum, numeric, nozero, unique, md5, encrypt and sha1
     * @param	int	number of characters
     * @return	string
     */
    protected function random_string($type = 'alnum', $len = 8)
    {
        switch ($type)
        {
            case 'basic':
                return mt_rand();
            case 'alnum':
            case 'numeric':
            case 'nozero':
            case 'alpha':
                switch ($type)
                {
                    case 'alpha':
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'alnum':
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'numeric':
                        $pool = '0123456789';
                        break;
                    case 'nozero':
                        $pool = '123456789';
                        break;
                }
                return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
            case 'unique': // todo: remove in 3.1+
            case 'md5':
                return md5(uniqid(mt_rand()));
            case 'encrypt': // todo: remove in 3.1+
            case 'sha1':
                return sha1(uniqid(mt_rand(), TRUE));
        }
    }
}