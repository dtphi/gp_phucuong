<?php

$config = [
    'id' => 'mm-server',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [],//['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'base64:A6X15ee7aZgZJ9Vy1rpOdWoD7/kXuG0+D/bVdkfSBwc=',
        ],
        /*'cache' => [
            'class' => 'yii\caching\FileCache',
        ],*/
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'api/mmedia/<action>' => 'mm/api/<action>'
            ],
        ],
        'fs' => [
            'class' => 'App\Helpers\UploadLocalFilesystem',
            'path' => '@webroot/Image/NewPicture',
        ],
    ],
    'modules' => [
        'mm' => [
            'class' => 'iutbay\yii2\mm\Module',
                   'fsComponent' => 'fs',
                   'apiOptions' => [
                       'cors' => [
                           'Origin' => ['*'],
                           'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                           'Access-Control-Request-Headers' => ['*'],
                           'Access-Control-Allow-Credentials' => null,
                           'Access-Control-Max-Age' => 86400,
                           'Access-Control-Expose-Headers' => [],
                       ],
                   ],
           'thumbsPath' => '@webroot/.tmb',
           'thumbsUrl' => '@web/.tmb',
           'thumbsSize' => 'thumb',
        ],
    ],
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1','127.0.0.1:8000','localhost:8000', '::1'],
    ];
}
return $config;
