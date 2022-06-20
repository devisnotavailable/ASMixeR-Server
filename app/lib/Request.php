<?php

declare(strict_types=1);

namespace App;

/**
 * Class Request
 * @package App
 */
class Request
{
    protected static ?Request $instance = null;

    protected const METHOD_GET  = 1;
    protected const METHOD_POST = 2;

    /**
     * @return Request
     */
    public static function i(): Request
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return bool|mixed
     */
    public function isPost(): bool
    {
        return \Yii::$app->request->isPost;
    }

    /**
     * @return bool|mixed
     */
    public function isAjax(): bool
    {
        return \Yii::$app->request->isAjax;
    }

    /**
     * @param null $key
     * @param null $default_value
     *
     * @return array|mixed
     */
    public function post($key = null, $default_value = null)
    {
        return \Yii::$app->request->post($key, $default_value);
    }

    /**
     * @param null $key
     *
     * @return array|mixed
     */
    public function get($key = null)
    {
        if (!$key) {
            return \Yii::$app->request->get();
        }

        return \Yii::$app->request->get($key);
    }

    /**
     * @param     $key
     * @param int $method
     *
     * @return array|mixed
     */
    protected function getParam($key, int $method = self::METHOD_GET)
    {
        if ($method === self::METHOD_GET) {
            return $this->get($key);
        }

        return $this->post($key);
    }

    /**
     * @param      $key
     * @param int  $method
     * @param null $default_value
     *
     * @return array|int|mixed|null
     */
    protected function getIntParam($key, int $method, $default_value = null)
    {
        $value = $this->getParam($key, $method);

        if (!is_numeric($value)) {
            return $default_value;
        }

        $value = (int)$this->getParam($key, $method);

        return $value;
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return array|int|mixed|null
     */
    public function postInt($key, $default_value = null)
    {
        return $this->getIntParam($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return array|int|mixed|null
     */
    public function getInt($key, $default_value = null)
    {
        return $this->getIntParam($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param      $key
     * @param int  $method
     * @param null $default_value
     *
     * @return array|float|mixed|null
     */
    protected function getFloatParam($key, int $method, $default_value = null)
    {
        $value = $this->getParam($key, $method);

        if (!is_float($value)) {
            return $default_value;
        }

        $value = (float)$this->getParam($key, $method);

        return $value;
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return array|float|mixed|null
     */
    public function getFloat($key, $default_value = null)
    {
        return $this->getFloatParam($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return array|float|mixed|null
     */
    public function postFloat($key, $default_value = null)
    {
        return $this->getFloatParam($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param      $key
     * @param      $method
     * @param null $default_value
     *
     * @return array|mixed|null
     */
    protected function getStrParam($key, $method, $default_value = null)
    {
        $value = $this->getParam($key, $method);

        if (!is_string($value)) {
            return $default_value;
        }

        return $value;
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return array|mixed|null
     */
    public function postStr($key, $default_value = null)
    {
        return $this->getStrParam($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param      $key
     * @param null $default_value
     *
     * @return array|mixed|null
     */
    public function getStr($key, $default_value = null)
    {
        return $this->getStrParam($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param       $key
     * @param       $method
     * @param array $default_value
     *
     * @return array|mixed
     */
    protected function getArrayParam($key, $method, array $default_value = [])
    {
        $value = $this->getParam($key, $method);

        if (!is_array($value)) {
            return $default_value;
        }

        return $value;
    }

    /**
     * @param       $key
     * @param array $default_value
     *
     * @return array|mixed
     */
    public function postArray($key, array $default_value = [])
    {
        return $this->getArrayParam($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param       $key
     * @param array $default_value
     *
     * @return array|mixed
     */
    public function getArray($key, array $default_value = [])
    {
        return $this->getArrayParam($key, self::METHOD_GET, $default_value);
    }

    /**
     * @return mixed|string|null
     */
    public function getHost(): ?string
    {
        return \Yii::$app->request->hostInfo;
    }

    /**
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return \Yii::$app->request->getUserAgent();
    }

    /**
     * @return mixed|string|null
     */
    public function getReferrer(): ?string
    {
        return \Yii::$app->request->referrer;
    }

    /**
     * @return string|null
     */
    public function getIP(): ?string
    {
        return \Yii::$app->request->getUserIP();

    }

    /**
     * @param $ip
     *
     * @return float|int
     */
    public function ipToInt($ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return 0;
        }

        return hexdec(dechex(ip2long($ip)));
    }

    /**
     * @param $int_ip
     *
     * @return string
     */
    public function intToIp($int_ip): ?string
    {
        if (!is_numeric($int_ip)) {
            return '0.0.0.0';
        }

        $value = (float)$int_ip;
        if (is_string($int_ip) && $int_ip !== (string)$value) {
            return '0.0.0.0';
        }

        return long2ip($int_ip);
    }
}
