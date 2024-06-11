<?php

return [
    'font_dir' => public_path('font/'), // ตำแหน่งของไฟล์ฟอนต์
    'font_cache' => storage_path('font/'),
    'default_font' => 'NotoSansThai',
    'pdf_backend' => 'CPDF',
    'default_media_type' => 'print',
    'default_paper_size' => 'a4',
    'dpi' => 96,
    'default_font_size' => 12,
    'enable_php' => true,
    'enable_javascript' => true,
    'enable_remote' => true,
    'enable_html5_parser' => true,
    'enable_css_float' => true,
    'enable_font_subsetting' => true,
    'debug_png' => false,
    'debug_keep_temp' => false,

    // เพิ่ม @font-face สำหรับ Noto Sans Thai
    'font_height_ratio' => 0.95,
    'font' => [
        'NotoSansThai' => [
            'R' => 'NotoSansThai_Extra.ttf', // ชื่อไฟล์ฟอนต์ Regular
        ],
    ],
];
