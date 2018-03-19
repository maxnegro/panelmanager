<?php

/**
 * Setting path aliases
 */
Yii::setAlias('root', realpath(__DIR__ . '/../../'));
Yii::setAlias('common', realpath(__DIR__ . '/../../common'));
Yii::setAlias('frontend', realpath(__DIR__ . '/../../frontend'));
Yii::setAlias('backend', realpath(__DIR__ . '/../../backend'));
Yii::setAlias('console', realpath(__DIR__ . '/../../console'));
Yii::setAlias('storage', realpath(__DIR__ . '/../../storage'));

/**
 * Setting url aliases
 */
Yii::setAlias('frontendUrl', env('FRONTEND_URL'));
Yii::setAlias('backendUrl', env('BACKEND_URL'));
Yii::setAlias('storageUrl', env('STORAGE_URL'));

/**
 * Setting proxy aliases
 */
Yii::setAlias('httpProxyHost', env('HTTPPROXY_HOST'));
Yii::setAlias('httpProxyPort', env('HTTPPROXY_PORT'));
Yii::setAlias('httpProxyPath', env('HTTPPROXY_PATH'));

Yii::setAlias('websocketProxyHost', env('WEBSOCKETPROXY_HOST'));
Yii::setAlias('websocketProxyPort', env('WEBSOCKETPROXY_PORT'));
Yii::setAlias('websocketProxyPath', env('WEBSOCKETPROXY_PATH'));
