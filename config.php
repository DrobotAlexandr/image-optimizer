<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/app/configuration/image-optimizer.php')) {
    return include $_SERVER['DOCUMENT_ROOT'] . '/app/configuration/image-optimizer.php';
}

return [
    'folder' => $_SERVER['DOCUMENT_ROOT'] . '/upload/',
    'maxImageSizePx' => 700,
    'qualityOptimizations' => true,
    'exceptionMasks' => [
        'upload/slider'
    ]
];