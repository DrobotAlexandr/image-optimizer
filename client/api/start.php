<?php

$config = include '../../config.php';

if (!file_exists($config['folder']) OR !$config['folder']) {
    res(
        [
            'status' => 'error',
            'errorData' => 'folderNotExists',
        ]
    );
}

removeDir(['path' => 'tmp/queue/']);

if (!file_exists('tmp/')) {
    mkdir('tmp/');
}

if (!file_exists('tmp/queue/')) {
    mkdir('tmp/queue/');
}

$GLOBALS['data'] = [
    'files' => [],
    'count' => 0,
    'size' => 0
];

function scan($path)
{
    if ($structure = glob($path . '/*')) {
        foreach ($structure as $object) {
            if (is_dir($object)) {
                scan($object);
            } else {
                $file = strtr($object, ['//' => '/']);
                $fileStrToLower = mb_strtolower($file);
                if (strstr($fileStrToLower, '.png') OR strstr($fileStrToLower, '.jpg') OR strstr($fileStrToLower, '.jpeg')) {
                    $GLOBALS['data']['files'][] = $file;
                    $GLOBALS['data']['count']++;
                    $task = $file;
                    $dataQueue = "<? return ['task' => '$task'];";
                    file_put_contents('tmp/queue/' . $GLOBALS['data']['count'] . '.php', $dataQueue);
                    $GLOBALS['data']['size'] = (filesize($file) + $GLOBALS['data']['size']);
                }
            }
        }
    }
    return true;
}

function FBytes($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . ' ' . $units[$pow];
}

function removeDir($params)
{

    if ($params['path'] == $_SERVER['DOCUMENT_ROOT']) {
        $params['path'] = false;
    }

    if (strtr($_SERVER['DOCUMENT_ROOT'], ['/' => '']) == strtr($params['path'], ['/' => ''])) {
        $params['path'] = false;
    }

    if ($params['path']) {
        $params['path'] = trim($params['path']);
    }

    if (!$params['path']) {
        return false;
    }

    if ($content_del_cat = glob($params['path'] . '/*')) {

        foreach ($content_del_cat as $object) {
            if (is_dir($object)) {
                removeDir(['path' => $object]);
            } else {
                @chmod($object, 0777);
                @unlink($object);
            }
        }
    }
    @chmod($object, 0777);
    @rmdir($params['path']);

    return true;
}

scan($config['folder']);

$sizeNative = $GLOBALS['data']['size'];

$GLOBALS['data']['size'] = FBytes($GLOBALS['data']['size']);

function res($data)
{
    header('Content-type: application/json;');
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
    print $json;
    exit();
}

res(
    [
        'status' => 'ok',
        'count' => $GLOBALS['data']['count'],
        'size' => $GLOBALS['data']['size'],
        'sizeNative' => round($sizeNative / 1000000),
    ]
);
