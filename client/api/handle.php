<?php

$config = include '../../config.php';

include '../../src/SimpleImage.php';
include '../../src/ImageOptimizer.php';
include '../../src/ImageNormalize.php';

include 'size.php';

$task = include 'tmp/queue/' . ($_GET['id']) . '.php';

$noHandle = false;

if ($config['exceptionMasks']) {
    foreach ($config['exceptionMasks'] as $exception) {
        if (strstr($task['task'], $exception)) {
            $noHandle = true;
        }
    }
}

if (!$noHandle) {
    $res = ImageNormalize::normalize(
        [
            'src' => $task['task'],
            'mode' => 'lite',
        ]
    );
}

$file = strtr($res['src']['local'], ['/upload/' => '']);

$size = false;

if ($_GET['getSize']) {

    $size = getSize(
        [
            'path' => $config['folder']
        ]
    );

}

if ($size['size']) {
    $size['size'] = round($size['size'] / 1000000);
}

$res = [
    'status' => 'ok',
    'file' => $file,
    'size' => $size
];

header('Content-type: application/json;');
$json = json_encode($res, JSON_UNESCAPED_UNICODE);
print $json;
exit();
