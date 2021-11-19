<?php

function getSize($params)
{
    $params['path'] = getSize__getPath($params);

    $data['size'] = getSize__dir_size($params['path']);
    $data['sizeFormat'] = getSize__format_size($data['size']);

    return $data;


}

function getSize__dir_size($dirName)
{
    $size = 0;
    if ($dirStream = @opendir($dirName)) {
        while (false !== ($filename = readdir($dirStream))) {
            if ($filename != "." && $filename != "..") {
                $fileStrToLower = mb_strtolower($filename);

                if (is_file($dirName . "/" . $filename)) {
                    if (strstr($fileStrToLower, '.png') OR strstr($fileStrToLower, '.jpg') OR strstr($fileStrToLower, '.jpeg')) {
                        $size += filesize($dirName . "/" . $filename);
                    }
                }

                if (is_dir($dirName . "/" . $filename)) {
                    $size += getSize__dir_size($dirName . "/" . $filename);
                }

            }
        }
        @closedir($dirStream);
    }
    return $size;
}

function getSize__format_size($size)
{
    $metrics[0] = 'байт';
    $metrics[1] = 'Кбайт';
    $metrics[2] = 'Мбайт';
    $metrics[3] = 'Гбайт';
    $metrics[4] = 'Тбайт';
    $metric = 0;
    while (floor($size / 1024) > 0) {
        ++$metric;
        $size /= 1024;
    }
    $ret = round($size, 1) . " " . (isset($metrics[$metric]) ? $metrics[$metric] : '??');
    return $ret;
}

function getSize__getPath($params)
{

    $path = $_SERVER['DOCUMENT_ROOT'] . '/' . strtr($params['path'], [$_SERVER['DOCUMENT_ROOT'] => '']);

    $path = strtr($path, ['//' => '/']);

    return $path;

}