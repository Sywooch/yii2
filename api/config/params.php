<?php
return [
    //默认分页
    'pageSize' => 20,

    //默认的缓存设置和时间
    'cache' => false,
    'cacheTime' => 1800,

    //调取API的设备对应的秘钥
    'device' =>[
        //电脑端
        'computer' => [
            'web'=>[
                'key' => '9XNNXe66zOlSassjSKD5gry9BiN61IUEi8IpJmjBwvU07RXP0J3c4GnhZR3GKhMHa1A',
                'secret' => '27e1be4fdcaa83d7f61c489994ff6ed6',
            ],
        ],
        //移动端
        'mobile' =>[
            'ios'=>[
                'key' => '9XNNXe66zOlSassjSKD5gry9BiN61IUEi8IpJmjBwvU07RXP0J3c4GnhZR3GKhMHa1A',
                'secret' => '27e1be4fdcaa83d7f61c489994ff6ed6',
            ],
            'android'=>[
                'key' => '9XNNXe66zOlSassjSKD5gry9BiN61IUEi8IpJmjBwvU07RXP0J3c4GnhZR3GKhMHa1A',
                'secret' => '27e1be4fdcaa83d7f61c489994ff6ed6',
            ],
            'html5'=>[
                'key' => '9XNNXe66zOlSassjSKD5gry9BiN61IUEi8IpJmjBwvU07RXP0J3c4GnhZR3GKhMHa1A',
                'secret' => '27e1be4fdcaa83d7f61c489994ff6ed6',
            ],
        ],
        //API系统
        'system' =>[
            'api'=>[
                'key' => '9XNNXe66zOlSassjSKD5gry9BiN61IUEi8IpJmjBwvU07RXP0J3c4GnhZR3GKhMHa1A',
                'secret' => '27e1be4fdcaa83d7f61c489994ff6ed6',
            ],
        ],
    ],

];
