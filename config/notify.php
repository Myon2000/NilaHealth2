<?php

return [

    'theme' => env('NOTIFY_THEME', 'light'),

    'timeout' => env('NOTIFY_TIMEOUT', 5000),

    'preset-messages' => [
        'jadwal-saved' => [
            'message' => 'Jadwal berhasil disimpan!',
            'type'    => 'success',
            'model'   => 'toast',
            'title'   => 'Sukses',
        ],
        'welcome-back' => [
            'message' => 'Selamat datang kembali!',
            'type'    => 'success',
            'model'   => 'smiley',
            'title'   => 'Halo!',
        ],
    ],

];
