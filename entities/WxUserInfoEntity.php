<?php
/**
 * Created by PhpStorm.
 * User: cota
 * Date: 2020-03-04
 * Time: 12:12
 */

namespace entities;


class WxUserInfoEntity
{
    protected $nickname = '';
    protected $avatar_url = '';
    protected $gender = '';
    protected $province = '';
    protected $city = '';
    protected $country = '';
    protected $openid = '';
    protected $unionid = '';

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     * @return WxUserInfoEntity
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatarUrl()
    {
        return $this->avatar_url;
    }

    /**
     * @param string $avatar_url
     * @return WxUserInfoEntity
     */
    public function setAvatarUrl($avatar_url)
    {
        $this->avatar_url = $avatar_url;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return WxUserInfoEntity
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
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
     * @return WxUserInfoEntity
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
     * @return WxUserInfoEntity
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
     * @return WxUserInfoEntity
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     * @param string $openid
     * @return WxUserInfoEntity
     */
    public function setOpenid($openid)
    {
        $this->openid = $openid;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnionid()
    {
        return $this->unionid;
    }

    /**
     * @param string $unionid
     * @return WxUserInfoEntity
     */
    public function setUnionid($unionid)
    {
        $this->unionid = $unionid;
        return $this;
    }
}