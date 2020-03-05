<?php
/**
 * Created by PhpStorm.
 * User: cota
 * Date: 2020-03-04
 * Time: 11:25
 */

namespace WormOfTime\WechatTools\weixin;

use WormOfTime\WechatTools\entities\SessionEntity;
use WormOfTime\WechatTools\entities\WxUserInfoEntity;
use WormOfTime\WechatTools\libraries\WXBizDataCrypt;

/**
 * 小程序
 * Class MiniProgram
 * @package weixin
 */
class MiniProgram extends Wechat
{
    /**
     * 获取服务器session
     * @param $js_code
     * @return bool|SessionEntity
     */
    public function getSession($js_code)
    {
        try {
            if (!$js_code) {
                $this->err_code = 40001;
                $this->err_msg = '缺少必要参数：js_code';
                return false;
            }

            $response = $this->getHttpClient()->get('/sns/jscode2session', array(
                'grant_type' => 'authorization_code',
                'appid' => $this->getAppId(),
                'secret' => $this->getAppSecret(),
                'js_code' => $js_code
            ));

            if($response->getStatusCode() == 200) {
                $json_string = $response->getBody()->getContents();
                $json_array = \GuzzleHttp\json_decode($json_string, true);

                if (!$json_array || $json_array['errcode'] > 0) {
                    $this->err_code = $this->element('errcode', $json_array);
                    $this->err_msg = $this->element('errmsg', $json_array);
                    return false;
                }

                $session_key = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . time() . $this->random_string());
                $unionid = null;
                if (isset($json_array['unionid'])) {
                    $unionid = $json_array['unionid'];
                }

                $sessionEntity = new SessionEntity();
                $sessionEntity->setSessionKey($session_key)
                    ->setOpenid($this->element('openid', $json_array))
                    ->setUnionid($unionid);


                return $sessionEntity;
            } else {
                $this->err_code = 40002;
                $this->err_msg = '访问接口出错:/sns/jscode2session';
                return false;
            }
        } catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }

    /**
     * 获取微信用户信息
     * @param $session_key
     * @param $encrypted_data
     * @param $iv
     * @param $raw_data
     * @param $signature
     * @return bool|WxUserInfoEntity
     */
    public function getUserInfo($session_key, $encrypted_data, $iv, $raw_data, $signature)
    {
        try {
            if (sha1($raw_data . $session_key) != $signature) {
                $this->err_code = '50001';
                $this->err_msg = '签名不正确';
                return false;
            }

            $pc = new WXBizDataCrypt($this->getAppId(), $session_key);
            $decrypt_data = '';
            $errCode = $pc->decryptData($encrypted_data, $iv, $decrypt_data);

            if ($errCode !== 0) {
                $this->err_code = $errCode;
                $this->err_msg = '加密数据错误';
                return false;
            }

            $decrypt_data = \GuzzleHttp\json_decode($decrypt_data, true);
            $nickname = $decrypt_data['nickName'];
            $avatar_url = $decrypt_data['avatarUrl'];
            $gender = $decrypt_data['gender'];
            $province = $decrypt_data['province'];
            $city = $decrypt_data['city'];
            $country = $decrypt_data['country'];
            $openid = $decrypt_data['openId'];

            $unionid = null;
            if (isset($decrypt_data['unionId'])) {
                $unionid = $decrypt_data['unionId'];
            }

            $wxUserInfoEntity = new WxUserInfoEntity();
            $wxUserInfoEntity->setNickname($nickname)
                ->setAvatarUrl($avatar_url)
                ->setGender($gender)
                ->setProvince($province)
                ->setCity($city)
                ->setCountry($country)
                ->setOpenid($openid)
                ->setUnionid($unionid);

            return $wxUserInfoEntity;
        } catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }
}