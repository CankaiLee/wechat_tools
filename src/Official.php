<?php
/**
 * Created by PhpStorm.
 * User: cota
 * Date: 2020-03-04
 * Time: 11:17
 */

namespace WormOfTime\WechatTools\weixin;

use WormOfTime\WechatTools\entities\UserInfoResultEntity;
use WormOfTime\WechatTools\entities\OauthAccessTokenResultEntity;

/**
 * 公众号
 * Class Official
 * @package weixin
 */
class Official extends Wechat
{
    public function getCacheNameOauthAccessToken() {
        return 'wechat_access_token'.$this->getAppId();//$this->getAppId().'_oauth_access_token';
    }

    /**
     * @param string $redirect_uri
     * @param string $scope
     * @param string $state
     * @return string
     * 生成授权跳转链接
     */
    public function getRedirectUrl($redirect_uri, $scope = 'snsapi_base', $state = '') {
        //$redirect_uri = $redirect_uri.'/'.$this->getAppId();
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->getAppId()."&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
    }

    /**
     * @param string $access_token
     * @param string $openid
     * @return bool
     * @throws \Exception
     */
    public function checkOauthAccessToken($access_token,$openid){
        //https://api.weixin.qq.com/sns/auth?access_token=ACCESS_TOKEN&openid=OPENID
        try {
            $uri = 'sns/auth';

            $response = $this->getHttpClient()->get($uri,array(
                'query'=>array(
                    'access_token'=>$access_token,
                    'openid'=>$openid,
                )
            ));

            if($response->getStatusCode() == 200)
            {
                $json_string = $response->getBody()->getContents();
                $json_array = \GuzzleHttp\json_decode($json_string, TRUE);
                if (!$json_array || $json_array['errcode'] > 0)
                {
                    $this->err_code = $this->element('errcode', $json_array);
                    $this->err_msg = $this->element('errmsg', $json_array);
                    return false;
                }

                return true;
            }else {
                $this->err_code = 40002;
                $this->err_msg = '访问接口出错'.$uri;
                return false;
            }
        }catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }

    /**
     * @param $refresh_token
     * @return OauthAccessTokenResultEntity|bool
     * @throws \Exception
     * 刷新access token
     */
    public function refreshOauthAccessToken($refresh_token)
    {
        try {
            $uri = 'sns/oauth2/refresh_token';

            $response = $this->getHttpClient()->get($uri,array(
                'query'=>array(
                    'grant_type'=>'refresh_token',
                    'appid'=>$this->getAppId(),
                    'refresh_token'=>$refresh_token
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

                return $oauthAccessTokenResultEntity;
            }else {
                $this->err_code = 40002;
                $this->err_msg = '访问接口出错'.$uri;
                return false;
            }
        }catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }

    /**
     * @param string $access_token
     * @param string $openid
     * @return UserInfoResultEntity|bool
     * @throws \Exception
     */
    public function getOauthUserInfo($access_token,$openid)
    {
        try {
            $uri = 'sns/userinfo';

            $response = $this->getHttpClient()->get($uri,array(
                'query'=>array(
                    'access_token'=>$access_token,
                    'openid'=>$openid,
                    'lang'=>'zh_CN',
                )
            ));

            if($response->getStatusCode() == 200)
            {
                $json_string = $response->getBody()->getContents();
                $json_array = \GuzzleHttp\json_decode($json_string, TRUE);
                if (!$json_array || !empty($json_array['errcode']))
                {
                    $this->err_code = $this->element('errcode', $json_array);
                    $this->err_msg = '获取微信用户信息错误：'.$this->element('errmsg', $json_array);
                    return false;
                }

                $userInfoEntity = new UserInfoResultEntity();
                $userInfoEntity
                    ->setOpenid($openid)
                    ->setUnionid($this->element('unionid',$json_array))
                    ->setNickname($this->element('nickname',$json_array))
                    ->setSex($this->element('sex',$json_array))
                    ->setProvince($this->element('province',$json_array))
                    ->setCity($this->element('city',$json_array))
                    ->setCountry($this->element('country',$json_array))
                    ->setHeadimgurl($this->element('headimgurl',$json_array))
                    ->setPrivilege(\GuzzleHttp\json_decode($this->element('privilege',$json_array)));

                return $userInfoEntity;
            }else {
                $this->err_code = 40002;
                $this->err_msg = '访问接口出错'.$uri;
                return false;
            }
        }catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }
}