<?php

$config = include '../config.php';

$isUpload = false;

if (file_exists($config['folder'])) {
    $isUpload = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Console</title>
    <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>
    <script>
        var apiPath = '<?=strtr($_SERVER['REQUEST_URI'], ['console.php' => ''])?>api/';
    </script>
</head>

<body>

<div class="console pref-box">

    <? if ($isUpload) { ?>
        <div class="console__content">
            <div class="start-text">
                Создаем задание...
            </div>
            <div class="start-statement">
                <div>Объектов в задании: <span style="font-weight: bold;" class="js_countFilesInTask">0</span></div>
            </div>

            <div class="loader">
                <div class="loader-line"></div>
            </div>
            <div class="fileHandledSize"></div>
            <div class="fileHandledSizeCompression"></div>
            <div class="fileHandled"></div>


        </div>
        <div class="pref-button pref-button_detailSave pref-button-action pref-button_primary js_start">
            <span class="pref-button-icon pref-button-icon_isLoad">

            <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="images" role="img"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                 class="svg-inline--fa fa-images fa-w-18 fa-3x">
                <path fill="currentColor"
                      d="M528 32H112c-26.51 0-48 21.49-48 48v16H48c-26.51 0-48 21.49-48 48v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48v-16h16c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm-48 400c0 8.822-7.178 16-16 16H48c-8.822 0-16-7.178-16-16V144c0-8.822 7.178-16 16-16h16v240c0 26.51 21.49 48 48 48h368v16zm64-64c0 8.822-7.178 16-16 16H112c-8.822 0-16-7.178-16-16V80c0-8.822 7.178-16 16-16h416c8.822 0 16 7.178 16 16v288zM176 200c30.928 0 56-25.072 56-56s-25.072-56-56-56-56 25.072-56 56 25.072 56 56 56zm0-80c13.234 0 24 10.766 24 24s-10.766 24-24 24-24-10.766-24-24 10.766-24 24-24zm240.971 23.029c-9.373-9.373-24.568-9.373-33.941 0L288 238.059l-31.029-31.03c-9.373-9.373-24.569-9.373-33.941 0l-88 88A24.002 24.002 0 0 0 128 312v28c0 6.627 5.373 12 12 12h360c6.627 0 12-5.373 12-12v-92c0-6.365-2.529-12.47-7.029-16.971l-88-88zM480 320H160v-4.686l80-80 48 48 112-112 80 80V320z"
                      class=""></path></svg>
            </span>
            <span class="pref-button-text">
               Запустить оптимизацию
            </span>
        </div>
        <div class="preload">
            <img src="img/preload.svg">
        </div>
        <div class="preview">
            <img src="img/preload.svg">
        </div>
        <input type="hidden" value="0" class="js_startSize">
        <input type="hidden" value="0" class="js_endSize">
    <? } else { ?>
        <div class="error" style="margin-top: 80px;">Директория с диском не найдена!</div>
    <? } ?>

</div>

<style>
    .console {
        max-width: 700px;
        width: calc(100% - 38px);
        margin: 0 auto;
        min-height: 315px !important;
        text-align: center;
    }

    .error {
        background: #f7dcda;
        padding: 20px;
        border-radius: 4px;
        border: 1px solid #ebaaa5;
    }

    .preview {
        display: none;
    }

    .preview img {
        width: 100px;
        height: 100px;
        display: block;
        margin: 0 auto;
        border-radius: 50%;
        margin-top: 16px;
        border: 1px solid #b2b2b2;
        object-fit: cover;
    }

    .pref-box {
        border: 1px solid #eee;
        background: #fdfdfd;
        padding: 15px;
        border-radius: 8px;
        min-height: 250px;
        margin-bottom: 20px;
        position: relative;
    }

    .fileHandledSize {
        margin-top: 10px;
        font-size: 14px;
        color: #555;
    }

    .fileHandled {
        font-size: 11px;
        width: 404px;
        overflow: hidden;
        margin-top: 5px;
        color: #b2b2b2;
        text-align: center;
        margin: 0 auto;
    }

    .fileHandledSizeCompression {
        font-size: 12px;
        color: #555;
        margin-top: 5px;
    }

    .start-statement {
        display: none;
        font-size: 14px;
        margin-top: 20px;
    }

    .console__content {
        min-height: 100px;
    }

    .preload {
        display: none;
        margin-top: 50px;
    }

    .preload img {
        width: 22px;
    }

    .start-text {
        font-size: 22px;
        display: none;
        padding-top: 50px;
    }

    .pref-button {
        background: #e0e9ec;
        background-image: linear-gradient(to bottom, #f7fdff, #e0e9ec);
        background-repeat: repeat-x;
        padding: 5px 10px 5px 10px;
        display: inline-block;
        cursor: pointer;
        border: 1px solid #c6d2d6;
        border-radius: 4px;
        margin: 0 5px 0 0;
        transition: 0.1s;
    }

    .pref-button_primary {
        color: #fff;
        box-shadow: none !important;
        border: 1px solid #8a0;
        background: #8cad0a;
        background-image: linear-gradient(to bottom, #aed610, #8cad0a);
        background-repeat: repeat-x;
        transition: 0.4s;
    }

    .pref-button-icon {
        width: 20px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 3px;
    }

    .pref-button-text {
        font-size: 14px;
        vertical-align: middle;
    }

    .loader {
        display: none;
        width: 380px;
        padding: 5px;
        border: 1px solid #b2b2b2;
        border-radius: 4px;
        margin: 0 auto;
        margin-top: 20px;
    }

    .loader-line {
        background: #a8cb80;
        padding: 8px;
        border-radius: 4px;
        width: 1%;
        font-size: 11px;
        color: #fff;
        min-width: 20px;
        text-align: center;
        max-width: calc(100% - 17px);
    }
</style>

<script>
    $(function () {

        $(document).on('click', '.js_start', function () {
            start($(this));
        });

        var startSize = 0;

        function start(button) {

            button.css(
                {
                    'pointer-events': 'none',
                    'opacity': '0.6',
                }
            );
            $('.start-text').show();
            $('.preload').show();
            $.ajax({
                url: apiPath + 'start.php',
                type: 'get',
                dataType: 'json',
                data: {},
                success: function (res) {

                    setTimeout(function () {

                        button.remove();

                        $('.start-text').hide();
                        $('.preload').hide();

                        $('.start-statement').show();
                        $('.js_countFilesInTask').text(res.count);
                        $('.loader').show();

                        $('.js_startSize').val(res.sizeNative);

                        startSize = res.size;

                        handle(res);

                    }, 1000);

                }
            });

        }

        function handle(res) {

            var allCount = res.count;
            var percent = 0.1;
            var isGetSize = 0;
            var getSize = 0;

            sendRequest(res.count, 0);

            function sendRequest(count, pos) {
                if (count > pos) {
                    pos++;
                    allCount--;

                    getSize = 0;

                    if (isGetSize === 0) {
                        getSize = 1;
                    }

                    if (isGetSize === 50) {
                        isGetSize = -1;
                    }

                    isGetSize++;

                    if (allCount === 0) {
                        getSize = 1;
                    }

                    $.ajax({
                        url: apiPath + 'handle.php',
                        type: 'get',
                        dataType: 'json',
                        data: {
                            'id': pos,
                            'getSize': getSize
                        },
                        success: function (handleRes) {
                            sendRequest(count, pos);
                            $('.js_countFilesInTask').text(allCount);

                            percent = 100 / (count / pos);

                            $('.loader-line').css(
                                {
                                    'width': percent + '%'
                                }
                            );

                            $('.preview img').attr('src', handleRes.file);
                            $('.preview').show();

                            $('.fileHandled').text(handleRes.file);

                            if (percent) {
                                $('.loader-line').text(Math.round(percent) + '%');
                            }

                            if (Math.round(percent) === 100) {
                                setTimeout(function () {
                                    var html = '<div>';

                                    html += '<div style="font-size: 22px; margin: 40px 0 20px 0;">Оптимизация успешно проведена!</div>';

                                    html += '<div style="color: #555;">' + $('.fileHandledSizeCompression').text() + '</div>';
                                    html += '<div style="color: #555;">' + $('.fileHandledSize').text() + '</div>';
                                    html += '<img style="width: 30px; margin-top: 20px;" src="img/success.svg">';
                                    html += '<div>';
                                    $('.console__content').html(html);

                                }, 1000);
                            }

                            if (handleRes.size) {
                                $('.fileHandledSize').text('Занятое место: ' + handleRes.size.sizeFormat);
                                $('.js_endSize').val(handleRes.size.size);

                                if (handleRes.size.size && startSize) {
                                    percent = 100 - 100 / (Number($('.js_startSize').val()) / Number(handleRes.size.size));
                                } else {
                                    percent = 1;
                                }

                                percent = Math.round(percent);

                                if (percent === 0 || percent >= 100) {
                                    percent = 1;
                                }

                                $('.fileHandledSizeCompression').text('Сжатие: ' + percent + '%');
                            }

                        }
                    });
                }
            }

        }

    });
</script>
</body>
</html>

