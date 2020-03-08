<?php
namespace WormOfTime\WechatTools\weixin\tools;

use WormOfTime\WechatTools\entities\Coupon\CardListResultEntity;
use WormOfTime\WechatTools\entities\Coupon\CodeCardEntity;
use WormOfTime\WechatTools\entities\Coupon\CodeEntity;
use WormOfTime\WechatTools\weixin\Wechat;

class CardCoupon extends Wechat
{

    /**
     * 查询Code接口
     * @param string $code
     * @param string $card_id
     * @param bool $check_consume
     * @return bool|CodeEntity
     */
    public function get_code($code = '', $card_id = '', $check_consume = true)
    {
        try {
            $access_token = $this->get_access_token();
            if (! $access_token) return false;

            if ($code == '') {
                $this->err_code = 40002;
                $this->err_msg = '参数错误: code';
                return false;
            }

            $uri = '/card/code/get?access_token=' . $access_token;
            $response = $this->getHttpClient()->post($uri, [
                'json' => [
                    'code' => $code,
                    'card_id' => $card_id,
                    'check_consume' => $check_consume
                ]
            ]);

            $result = $this->decodeResponse($response, self::RETURN_ARRAY);
            if (! $result) return false;

            $codeEntity = new CodeEntity();
            $codeCartEntity = new CodeCardEntity();

            $codeCartEntity->setCardId($result['card']['card_id'])
                ->setBeginTime($result['card']['begin_time'])
                ->setEndTime($result['card']['end_time']);

            $codeEntity->setCanConsume($result['can_consume'])
                ->setOpenid($result['openid'])
                ->setOuterStr($result['outer_str'])
                ->setUserCardStatus($result['user_card_status'])
                ->setCard($codeCartEntity);

            return $codeEntity;
        } catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }

    /**
     * 获取用户已领取卡券接口
     * @param string $openid
     * @param string $card_id
     * @return CardListResultEntity[]|bool
     */
    public function get_card_list($openid = '', $card_id = '')
    {
        try {
            $access_token = $this->get_access_token();
            if (! $access_token) return false;

            if ($openid == '' || $card_id == '') {
                $this->err_code = 40002;
                $this->err_msg = '参数错误';
                return false;
            }

            $uri = '/card/user/getcardlist?access_token=';
            $response = $this->getHttpClient()->post($uri, array(
                'json' => [
                    'openid' => $openid,
                    'card_id' => $card_id
                ]
            ));

            $result = $this->decodeResponse($response, self::RETURN_ARRAY);
            if (! $result) return false;
            $cardListResultEntities = array();

            foreach ($result['card_list'] as $item) {
                $cardListResultEntity = new CardListResultEntity();
                $cardListResultEntity->setCardId($item['card_id'])
                    ->setCode($item['code']);
                array_push($cardListResultEntities, $cardListResultEntity);
            }

            return $cardListResultEntities;
        } catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }

    /**
     * 卡券详情
     * @param string $card_id
     * @return bool|mixed|array
     */
    public function get($card_id = '')
    {
        try {
            $access_token = $this->get_access_token();
            if (! $access_token) return false;

            $uri = '/card/get?access_token=' . $access_token;

            $response = $this->getHttpClient()->post($uri, array(
                'json' => ['card_id' => $card_id]
            ));

            $result = $this->decodeResponse($response, self::RETURN_ARRAY);
            if (! $result) return false;

            return $result['card'];
        } catch (\Exception $exception) {
            $this->err_code = $exception->getCode();
            $this->err_msg = $exception->getMessage();
            return false;
        }
    }
}