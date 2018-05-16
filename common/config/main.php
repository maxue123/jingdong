<?php
// return [
//     'aliases' => [
//         '@bower' => '@vendor/bower-asset',
//         '@npm'   => '@vendor/npm-asset',
//     ],
//     'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
//     'components' => [
//         'cache' => [
//             'class' => 'yii\caching\FileCache',
//         ],
//     ],
// ];
return [ 
'defaultRoute' = 'index';
'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
'modules' => [ 
    'gii' => [ 
        'class' => 'yii\gii\Module', 
        'allowedIPs' => ['::1','127.0.0.1','192.168.0.222'], //只允许本地访问gii 
        'generators'=> [ 
            'module'=> [ 
            'class' => 'yii\gii\generators\module\Generator', 
            'templates'=> [ 
                'backend'=>'@common/gii/generators/module/default' 
                ] 
            ], 
            'model'=> [ 
                'class' => 'yii\gii\generators\model\Generator', 
                'baseClass'=> 'base\BaseActiveRecord', 
                'ns'=> 'common\models', 
                'templates'=> [ 
                'common'=>'@common/gii/generators/model/default', 
                'backend'=>'@common/gii/generators/model/backend' 
                ] 
            ], 
            'crud'=> [ 
                'class' => 'yii\gii\generators\crud\Generator', 
                'templates'=> [ 
                    'backend'=>'@common/gii/generators/crud/default' 
                ], 
                'baseControllerClass' => 'BaseBackendController', 
                'messageCategory'=> 'backend' 
            ] 
        ] 
    ] 
    ] 
];