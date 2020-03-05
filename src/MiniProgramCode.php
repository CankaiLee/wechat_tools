<?php

namespace WormOfTime\WechatTools\weixin;

/**
 * Class MiniProgramCode
 * @package App\libraries
 */
class MiniProgramCode extends Wechat
{
    /**
     * 扫码进入的小程序页面路径，最大长度 128 字节，测试环境下不能为空
     * @var string
     */
    private $page = '';

    /**
     * 参数
     * @var string
     */
    private $scene = '';

    /**
     * 生成的二维码图片宽度 默认为 430px，最小 280px，最大 1280px
     * @var int
     */
    private $width = 430;

    /**
     * 自定义宽度
     * @var int
     */
    private $original_width = 0;

    /**
     * 自动配置线条颜色，如果颜色依然是黑色，则说明不建议配置主色调
     * @var bool
     */
    private $auto_color = true;

    /**
     * auto_color 为 false 时生效，使用 rgb 设置颜色 例如 {“r”:“xxx”,“g”:“xxx”,“b”:“xxx”} 十进制表示
     * @var string
     */
    private $line_color = '';

    /**
     * 是否需要透明底色，为 true 时，生成透明底色的小程序码
     * @var bool
     */
    private $is_hyaline = false;

    /**
     * 错误码
     * @var int
     */
    private $errcode = 0;

    /**
     * 错误信息
     * @var string
     */
    private $errmsg = '';

    /**
     * @var MiniProgramCode
     */
    private static $_instance = null;

    /**
     * MiniProgramCode constructor.
     * @param $options
     */
    public function __construct($options)
    {
        $this->page = isset($options['page']) ? $options['page'] : '/';
        $this->scene = isset($options['scene']) ? $options['scene'] : '';
        $this->width = isset($options['width']) ? round($options['width']) : 430;
        $this->original_width = round($options['width']);
        if ($this->width < 280) $this->width = 280;
        if ($this->width > 1280) $this->width = 1280;
        $this->auto_color = isset($options['auto_color']) ? $options['auto_color'] : true;
        $this->line_color = isset($options['line_color']) ? $options['line_color'] : '{"r": "255", "g": "255", "b": "255"}';
        $this->is_hyaline = isset($options['is_hyaline']) ? $options['is_hyaline'] : false;
    }

    /**
     * @param $options
     * @return MiniProgramCode
     */
    public static function getInstance($options)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($options);
        }
        return self::$_instance;
    }

    /**
     * 创建小程序码
     * @return string|bool
     */
    public function create_qrcode()
    {
        $access_token = $this->get_access_token();
        if (!$access_token) return false;

        $uri = '/wxa/getwxacodeunlimit?access_token=' . $access_token;

        $response = $this->getHttpClient()->post($uri, [
            'form_params' => array(
                'width' => $this->width,
                'auto_color' => $this->auto_color,
//            'line_color' => $this->line_color,
                'is_hyaline' => $this->is_hyaline,
                'scene' => $this->scene,
                'page' => $this->page
            )
        ]);

        if ($response->getStatusCode() == 200) {
            $json_string = $response->getBody()->getContents();
            $json_array = \GuzzleHttp\json_decode($json_string, true);

            if (!$json_array || $json_array['errcode'] > 0) {
                $this->err_code = $this->element('errcode', $json_array);
                $this->err_msg = $this->element('errmsg', $json_array);
                return false;
            }

            return $json_string;
        } else {
            $this->err_code = 40002;
            $this->err_msg = '访问接口出错'.$uri;
            return false;
        }
    }

    /**
     * 获取错误码
     * @return int
     */
    public function getErrCode()
    {
        return $this->errcode;
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getErrMsg()
    {
        return $this->errmsg;
    }

    /**
     * 生成最大32个可见字符，只支持数字，大小写英文以及部分特殊字符
     * @param int $length
     * @param bool $is_special_code
     * @return string
     */
    protected function _create_scene($length = 32, $is_special_code = true)
    {
        if ($length <= 0 || $length > 32) $length = 32;

        $special_code = "!#$&'()*+,/:;=?@-._~";
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if ($is_special_code) $characters .= $special_code;
        $characters_length = strlen($characters) - 1;

        $scene = '';
        while(strlen($scene) < $length) {
            $scene .= $characters[mt_rand(0, $characters_length)];
        }

        return $scene;
    }
}