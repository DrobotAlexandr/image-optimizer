<?php


Class ImageNormalize
{
    public static function normalize($params)
    {
        $params['src'] = self::normalize__getPath($params['src']);

        $validate = self::normalize__validate($params);

        if ($validate) {
            return $validate;
        }

        $config = '../../config.php';

        if (file_exists($config)) {
            $params['config'] = include $config;
        } else {
            $params['config']['qualityOptimizations'] = true;
        }


        self::normalize__createImage($params);

        self::normalize__optimize($params);

        return [
            'status' => 'ok',
            'src' => self::normalize__getSrc($params)
        ];

    }

    private static function normalize__getSrc($params)
    {
        $file = file_get_contents($params['src']);

        $ver = round(mb_strlen($file, '8bit') / 1000);

        $local = strtr($params['src'], [$_SERVER['DOCUMENT_ROOT'] => '']);

        $isHttps = !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);

        if ($isHttps) {
            $http = 'https://';
        } else {
            $http = 'http://';
        }

        $http = $http . $_SERVER['SERVER_NAME'] . $local . '?ver=' . $ver;

        $bin = base64_encode($file);

        return [
            'local' => $local,
            'http' => $http,
            'server' => $params['src'],
            'bin' => $bin
        ];
    }

    private static function normalize__validate($params)
    {
        if (!file_exists($params['src']) OR !$params['src']) {
            return [
                'status' => 'error',
                'errorData' => 'fileNotExists',
            ];
        }

        if (!self::normalize__validate__checkFile($params)) {
            return [
                'status' => 'error',
                'errorData' => 'theFileIsNotImage',
            ];
        }
    }

    private static function normalize__optimize($params)
    {
        if (!$params['config']['qualityOptimizations']) {
            return false;
        }

        $optimizer = new ImageOptimizer;

        $optimizer->cached_image_directory = $params['config']['folder'];

        $optimizer->optimize($params['src']);
    }

    private static function normalize__getPath($path)
    {

        return trim(strtr($_SERVER['DOCUMENT_ROOT'] . '/' . strtr($path, [$_SERVER['DOCUMENT_ROOT'] => '']), ['//' => '/']));

    }

    private static function normalize__createImage($params)
    {

        $size = 1920;

        if ($params['config']['maxImageSizePx']) {
            $size = $params['config']['maxImageSizePx'];
        } else if ($params['mode'] == 'lite') {
            $size = 700;
        }

        try {

            $image = new SimpleImage;

            $image
                ->fromFile($params['src'])
                ->bestFit($size, $size)
                ->toFile($params['src']);

        } catch (\Exception $err) {
            echo $err->getMessage();
        }

        return $params['src'];
    }

    private static function normalize__validate__checkFile($params)
    {

        $arEx = [
            'jpg' => true,
            'jpeg' => true,
            'png' => true,
        ];

        $fileInfo = new SplFileInfo($params['src']);

        $extension = mb_strtolower(
            $fileInfo->getExtension()
        );

        if (!$arEx[$extension]) {
            return false;
        }

        return true;
    }
}
