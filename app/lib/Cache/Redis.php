<?php

declare(strict_types=1);

namespace App\Cache;

use yii\caching\Cache;

/**
 * Class Redis
 * @package App\Cache
 */
class Redis extends Cache
{
    public ?\Redis $redis = null;

    /** @var string */
    public string $host = 'localhost';

    /** @var int */
    public int $port = 6379;

    /** @var bool */
    public bool $persist = false;

    /** @var float */
    public float $timeout = 0.0;

    /** @var int */
    public int $database = 0;

    /** @var string */
    public string $password;

    public function init()
    {
        parent::init();

        $this->redis = new \Redis();
        if ($this->persist) {
            $hash = $this->host . $this->port . $this->timeout . $this->password . $this->database;
            $this->redis->pconnect($this->host, $this->port, $this->timeout, md5($hash));
        } else {
            $this->redis->connect($this->host, $this->port, $this->timeout);
        }

        if ($this->password) {
            $this->redis->auth($this->password);
        }

        $this->redis->select($this->database);
    }

    /**
     * @param mixed $key
     *
     * @return mixed|string
     */
    public function buildKey($key)
    {
        if (is_string($key)) {
            return $key;
        }

        return md5(json_encode($key));
    }

    /**
     * @param mixed $key
     *
     * @return bool|int
     */
    public function exists($key)
    {
        return $this->redis->exists($this->buildKey($key));
    }

    /**
     * @param $pattern
     *
     * @return array
     */
    public function keys($pattern)
    {
        return $this->redis->keys($pattern);
    }

    /**
     * @param $pattern
     *
     * @return array|bool
     */
    public function scan($pattern)
    {
        $iterator = null;
        return $this->redis->scan($iterator, $pattern, 1000000);
    }

    public function inc($key)
    {
        return $this->redis->incr($this->buildKey($key));
    }

    /**
     * Retrieves a value from cache with a specified key.
     * This method should be implemented by child classes to retrieve the data
     * from specific cache storage.
     *
     * @param string $key a unique key identifying the cached value
     *
     * @return mixed|false the value stored in cache, false if the value is not in the cache or expired. Most often
     * value is a string. If you have disabled [[serializer]], it could be something else.
     */
    protected function getValue($key)
    {
        return $this->redis->get($key);
    }

    /**
     * @param array $keys
     *
     * @return array
     */
    protected function getValues($keys)
    {
        $res = $this->redis->mget($keys);
        return array_combine($keys, $res);
    }

    /**
     * Stores a value identified by a key in cache.
     * This method should be implemented by child classes to store the data
     * in specific cache storage.
     *
     * @param string $key      the key identifying the value to be cached
     * @param mixed  $value    the value to be cached. Most often it's a string. If you have disabled [[serializer]],
     *                         it could be something else.
     * @param int    $duration the number of seconds in which the cached value will expire. 0 means never expire.
     *
     * @return bool true if the value is successfully stored into cache, false otherwise
     */
    protected function setValue($key, $value, $duration)
    {
        if ($duration === 0) {
            return $this->redis->set($key, $value);
        }

        return $this->redis->set($key, $value, $duration);
    }

    /**
     * @param array $data
     * @param int   $duration
     *
     * @return array
     */
    protected function setValues($data, $duration)
    {
        $pipe = $this->redis->multi(\Redis::PIPELINE);
        foreach ($data as $key => $value) {
            if ($duration === 0) {
                $pipe->set($key, $value);
            } else {
                $pipe->set($key, $value, $duration);
            }
        }
        $pipe->exec();

        return [];
    }

    /**
     * Stores a value identified by a key into cache if the cache does not contain this key.
     * This method should be implemented by child classes to store the data
     * in specific cache storage.
     *
     * @param string $key      the key identifying the value to be cached
     * @param mixed  $value    the value to be cached. Most often it's a string. If you have disabled [[serializer]],
     *                         it could be something else.
     * @param int    $duration the number of seconds in which the cached value will expire. 0 means never expire.
     *
     * @return bool true if the value is successfully stored into cache, false otherwise
     */
    protected function addValue($key, $value, $duration)
    {
        if ($duration == 0) {
            return $this->redis->setnx($key, $value);
        }

        if ($this->exists($key)) {
            return false;
        }

        return $this->redis->setex($key, $duration, $value);
    }

    /**
     * Deletes a value with the specified key from cache
     * This method should be implemented by child classes to delete the data from actual cache storage.
     *
     * @param string $key the key of the value to be deleted
     *
     * @return bool if no error happens during deletion
     */
    protected function deleteValue($key)
    {
        return $this->redis->del($key);
    }

    /**
     * Deletes all values from cache.
     * Child classes may implement this method to realize the flush operation.
     * @return bool whether the flush operation was successful.
     */
    protected function flushValues()
    {
        return $this->redis->flushDB();
    }
}
