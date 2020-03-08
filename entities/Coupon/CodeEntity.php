<?php
namespace WormOfTime\WechatTools\entities\Coupon;

class CodeEntity
{
    protected $card;
    protected $openid = '';
    protected $can_consume = true;
    protected $outer_str = '';
    protected $user_card_status = '';

    /**
     * @return CodeCardEntity
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param CodeCardEntity $card
     * @return CodeEntity
     */
    public function setCard($card)
    {
        $this->card = $card;
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
     * @return CodeEntity
     */
    public function setOpenid($openid)
    {
        $this->openid = $openid;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCanConsume()
    {
        return $this->can_consume;
    }

    /**
     * @param bool $can_consume
     * @return CodeEntity
     */
    public function setCanConsume($can_consume)
    {
        $this->can_consume = $can_consume;
        return $this;
    }

    /**
     * @return string
     */
    public function getOuterStr()
    {
        return $this->outer_str;
    }

    /**
     * @param string $outer_str
     * @return CodeEntity
     */
    public function setOuterStr($outer_str)
    {
        $this->outer_str = $outer_str;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserCardStatus()
    {
        return $this->user_card_status;
    }

    /**
     * @param string $user_card_status
     * @return CodeEntity
     */
    public function setUserCardStatus($user_card_status)
    {
        $this->user_card_status = $user_card_status;
        return $this;
    }
}