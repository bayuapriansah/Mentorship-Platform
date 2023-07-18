<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable Laravel Page Speed
    |--------------------------------------------------------------------------
    |
    | Set this field to false to disable the laravel page speed service.
    | You would probably replace that in your local configuration to get a readable output.
    |
    */
    'enable' => env('LARAVEL_PAGE_SPEED_ENABLE', false),

    /*
    |--------------------------------------------------------------------------
    | Skip Routes
    |--------------------------------------------------------------------------
    |
    | Skip Routes paths to exclude.
    | You can use * as wildcard.
    |
    */
    'skip' => [
        '*.xml',
        '*.less',
        '*.pdf',
        '*.doc',
        '*.docx',
        '*.txt',
        '*.ico',
        '*.rss',
        '*.zip',
        '*.mp3',
        '*.rar',
        '*.exe',
        '*.wmv',
        '*.avi',
        '*.ppt',
        '*.mpg',
        '*.mpeg',
        '*.tif',
        '*.wav',
        '*.mov',
        '*.psd',
        '*.ai',
        '*.xls',
        '*.xlsx',
        '*.mp4',
        '*.m4a',
        '*.swf',
        '*.dat',
        '*.dmg',
        '*.iso',
        '*.flv',
        '*.m4v',
        '*.zip',
        '*.torrent'
    ],
];
