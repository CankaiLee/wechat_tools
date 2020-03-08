<?php
namespace WormOfTime\WechatTools\entities\Coupon;

class CodeCardEntity
{
    protected $card_id = '';
    protected $begin_time = '';
    protected $end_time = '';

    /**
     * @return string
     */
    public function getCardId()
    {
        return $this->card_id;
    }

    /**
     * @param string $card_id
     * @return CodeCardEntity
     */
    public function setCardId($card_id)
    {
        $this->card_id = $card_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getBeginTime()
    {
        return $this->begin_time;
    }

    /**
     * @param string $begin_time
     * @return CodeCardEntity
     */
    public function setBeginTime($begin_time)
    {
        $this->begin_time = $begin_time;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @param string $end_time
     * @return CodeCardEntity
     */
    public function setEndTime($end_time)
    {
        $this->end_time = $end_time;
        return $this;
    }
}