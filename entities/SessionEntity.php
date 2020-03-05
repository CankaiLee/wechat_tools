<?php
/**
 * Created by PhpStorm.
 * User: cota
 * Date: 2020-03-04
 * Time: 11:50
 */

namespace entities;


class SessionEntity
{
    private $session_key = '';
    private $openid = '';
    private $unionid = '';

    /**
     * @return string
     */
    public function getSessionKey()
    {
        return $this->session_key;
    }

    /**
     * @param string $session_key
     * @return SessionEntity
     */
    public function setSessionKey($session_key)
    {
        $this->session_key = $session_key;
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
     * @return SessionEntity
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
     * @return SessionEntity
     */
    public function setUnionid($unionid)
    {
        $this->unionid = $unionid;
        return $this;
    }
}