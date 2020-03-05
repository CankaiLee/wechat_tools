<?php
/**
 * Created by PhpStorm.
 * User: cota
 * Date: 2020-03-04
 * Time: 11:08
 */

namespace entities;


class UserInfoResultEntity
{
    protected $openid = '';
    protected $nickname = '';
    protected $sex = 0;
    protected $province = '';
    protected $city = '';
    protected $country = '';
    protected $headimgurl = '';
    protected $privilege = '';
    protected $unionid = null;

    /**
     * @return string
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     * @param string $openid
     * @return UserInfoResultEntity
     */
    public function setOpenid($openid)
    {
        $this->openid = $openid;
        return $this;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     * @return UserInfoResultEntity
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param int $sex
     * @return UserInfoResultEntity
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     * @return UserInfoResultEntity
     */
    public function setProvince($province)
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return UserInfoResultEntity
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return UserInfoResultEntity
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeadimgurl()
    {
        return $this->headimgurl;
    }

    /**
     * @param string $headimgurl
     * @return UserInfoResultEntity
     */
    public function setHeadimgurl($headimgurl)
    {
        $this->headimgurl = $headimgurl;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * @param string $privilege
     * @return UserInfoResultEntity
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
        return $this;
    }

    /**
     * @return null
     */
    public function getUnionid()
    {
        return $this->unionid;
    }

    /**
     * @param null $unionid
     * @return UserInfoResultEntity
     */
    public function setUnionid($unionid)
    {
        $this->unionid = $unionid;
        return $this;
    }
}