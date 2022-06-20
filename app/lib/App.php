<?php

namespace App;

use App\Helper\File;
use App\Models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class App
 * @package App
 */
class App
{
    protected static ?App $instance = null;

    public const MODULE_ADMIN = 'admin';

    protected array $config = [];

    /**
     * @return App
     */
    public static function i(): App
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return \yii\console\Application|\yii\web\Application
     */
    public function getApp()
    {
        return \Yii::$app;
    }

    /**
     * @return \yii\web\IdentityInterface|User
     */
    public function getCurrentUser()
    {
        return \Yii::$app->user->identity;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return \Yii::$app->params;
    }

    /**
     * @return \yii\base\Module
     */
    public function getCurrentModule()
    {
        return \Yii::$app->controller->module;
    }

    /**
     * @return bool
     */
    public function isGuest(): bool
    {
        return Yii::$app->user->isGuest;
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        return Yii::$app->user->logout();
    }

    /**
     * @return \yii\db\Connection
     */
    public function getDb(): \yii\db\Connection
    {
        return Yii::$app->db;
    }

    /**
     * @param string $module_name
     *
     * @return array
     */
    public function getConfig(string $module_name = MODULE_NAME): array
    {
        if (empty($this->config[$module_name])) {
            $app_config    = require(dirname(__DIR__) . '/config/config.php');
            $module_config = $local_config = [];

            $config_file_module = dirname(__DIR__) . '/config/modules/' . $module_name . '.php';
            if (File::exist($config_file_module)) {
                $module_config = require $config_file_module;
            }

            $config_file_local = dirname(__DIR__) . '/config/config_local.php';
            if (File::exist($config_file_local)) {
                $local_config = require(dirname(__DIR__) . '/config/config_local.php');
            }

            $this->config[$module_name] = ArrayHelper::merge(
                $app_config,
                $module_config,
                $local_config
            );
        }
        return $this->config[$module_name];
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return Response::i();
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return Request::i();
    }

    /**
     * @return \yii\console\Controller|\yii\web\Controller
     */
    public function getController()
    {
        return Yii::$app->controller;
    }

    public function getAuthManager()
    {
        return \Yii::$app->getAuthManager();
    }

    public function getPathStaticFiles()
    {
        return \Yii::getAlias('@Upload');
    }

    public function getPathWeb()
    {
        return \Yii::getAlias('@webroot');
    }

    public function getApiDomain(): string
    {
        return $this->getParams()['apiDomain'] ?? '';
    }

    public function getRootPath(): string
    {
        return $this->getParams()['rootPath'];
    }
}
