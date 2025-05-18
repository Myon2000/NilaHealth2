<?php

return [

    // Ubah tema ke `dark` jika ingin mode gelap secara default
    'theme' => env('NOTIFY_THEME', 'light'),

    // Waktu tampil notifikasi (dalam milidetik)
    'timeout' => env('NOTIFY_TIMEOUT', 5000),

    // Pesan preset yang bisa di-reuse
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
