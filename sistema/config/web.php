<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'UrMq7ehocsPNflpCsIlEYgmyfJ7aO2Bx',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuario',
            'enableAutoLogin' => true,
        ],
        // 'authManager' => [
        //     'class' => 'yii\rbac\DbManager',
        // ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        /*
        */
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key' => 'AIzaSyBTRaW15a_Fxc4im12M8ebgJ4ckj6qbRNo',
                        'language' => 'pt'
                    ]
                ],
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ]
        ],
        'formatter' => [
            'class' => 'yii\\i18n\\Formatter',
            'dateFormat' => 'd/m/Y', // Date format
            'datetimeFormat' => 'd/m/Y H:i:s', // Date and time format
            'timeFormat' => 'H:i:s', // Time format
        ]
    ],
    'modules' => [
        // 'financeiro' => [
        //     'class' => 'app\modules\financeiro\FinanceiroModule',
        // ],
        // 'markdown' => [
        //     'class' => 'kartik\markdown\Module',
        //     // the controller action route used for markdown editor preview
        //     'previewAction' => '/markdown/parse/preview',
            
        //     // the list of custom conversion patterns for post processing
        //     'customConversion' => [
        //         '<table>' => '<table class="table table-bordered table-striped">'
        //     ],
            
        //     // whether to use PHP SmartyPantsTypographer to process Markdown output
        //     'smartyPants' => false
        // ],
        'gridview' =>  [
             'class' => '\kartik\grid\Module'
         ],
        //  'googlemaps' => [
        //     'class' => 'dosamigos\google\maps\Module',
        // ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
