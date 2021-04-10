<?php

return [
    'disk' => env('FILESYSTEM_DISK', 'local'),
    'base_dir' => env('IMAGIST_BASE_DIR', 'images') . '/',
    'base_dir_file' => env('IMAGIST_BASE_DIR_FILES', 'files') . '/'
];
