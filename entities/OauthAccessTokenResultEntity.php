<?php
/**
 * Created by PhpStorm.
 * User: cota
 * Date: 2020-03-04
 * Time: 11:01
 */

namespace entities;


class OauthAccessTokenResultEntity
{
    protected $access_token = '';
    protected $expires_in = 0;
    protected $refresh_token = '';
    protected $openid = '';
    protected $scope = '';

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param string $access_token
     * @return OauthAccessTokenResultEntity
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expires_in;
    }

    /**
     * @param int $expires_in
     * @return OauthAccessTokenResultEntity
     */
    public function setExpiresIn($expires_in)
    {
        $this->expires_in = $expires_in;
        return $this;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * @param string $refresh_token
     * @return OauthAccessTokenResultEntity
     */
    public function setRefreshToken($refresh_token)
    {
        $this->refresh_token = $refresh_token;
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
     * @return OauthAccessTokenResultEntity
     */
    public function setOpenid($openid)
    {
        $this->openid = $openid;
        return $this;
    }

    /**
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     * @return OauthAccessTokenResultEntity
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
        return $this;
    }
}