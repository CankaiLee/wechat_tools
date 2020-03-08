<?php
namespace WormOfTime\WechatTools\entities\Coupon;

class CardListResultEntity
{
    protected $code = '';
    protected $card_id = '';

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return CardListResultEntity
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardId()
    {
        return $this->card_id;
    }

    /**
     * @param string $card_id
     * @return CardListResultEntity
     */
    public function setCardId($card_id)
    {
        $this->card_id = $card_id;
        return $this;
    }
}