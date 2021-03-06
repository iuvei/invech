<?php

return [

    //"pusher", "log"
    'driver' => \think\Env::get('broadcast.driver', 'pusher'),
    'configs' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => \think\Env::get('broadcast.pusher_app_key'),
            'secret' => \think\Env::get('broadcast.pusher_app_secret'),
            'app_id' => \think\Env::get('broadcast.pusher_app_id'),
            'options' => [                
                'cluster' => \think\Env::get('broadcast.pusher_cluster'),
                //'encrypted' => true            
            ],
        ],

        'jpush' => [
            'driver' => 'jpush',
            'key' => \think\Env::get('broadcast.jpush_app_key'),
            'secret' => \think\Env::get('broadcast.jpush_app_secret'),
            'options' => [                
      
            ],
        ],

        'redis' => [

        ],

        'log' => [
            'driver' => 'log',
        ],
    ],

];
