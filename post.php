<?php

// URL с которого нужно скачать изображения.
$url = $_POST['url'];
$dirName = trim($_POST['dirname']);

// Директория куда будут сохранятся изображения.
$path = dirname(__FILE__) . '/' . $dirName;

// Загружать или нет изображения с других доменов.
$external = true;

// нахождение картинок
$html = file_get_contents($url);
preg_match_all('/<img.*?src=["\'](.*?)["\'].*?>/i', $html, $images, PREG_SET_ORDER);

$url = parse_url($url);
$path = rtrim($path, '/');

foreach ($images as $image) {

    $imgName = '/' . strrev(strstr(strrev($image[1]), '/', true));
    echo $imgName;

    if (strpos($image[1], 'data:image/') !== false) {
        continue;
    }

    if (substr($image[1], 0, 2) == '//') {
        $image[1] = 'http:' . $image[1];
    }

    $ext = strtolower(substr(strrchr($image[1], '.'), 1));
    if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {

        $img = parse_url($image[1]);

        // Если файл уже существует
        if (is_file($path . $img['path'])) {

            continue;
        }

        // куда?
        $path_img = $path . '/';
        if (!is_dir($path_img)) {

            mkdir($path_img, 0777, true);
        }

        // откуда и куда
        if (empty($img['host']) && !empty($img['path'])) {

            copy($url['scheme'] . '://' . $url['host'] . $img['path'], $path . $imgName);
        } elseif ($external || ($external == false && $img['host'] == $url['host'])) {

            copy($image[1], $path . $img['path']);
        }
    }
}



/* СОЗДАНИЕ АРХИВА */

//$dirName = '\' . $dirName;

$rootPath = realpath($path);

// Инициализация объекта архива
$zip = new ZipArchive();

$zip->open($dirName .'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Создание рекурсивного итератора каталогов
/** @var SplFileInfo[] $files */

$files = new RecursiveIteratorIterator(

    new RecursiveDirectoryIterator($rootPath),

    RecursiveIteratorIterator::LEAVES_ONLY

);

foreach ($files as $name => $file) {

    // Пропустите каталоги (они будут добавлены автоматически)
    if (!$file->isDir()) {

        // Получение реального и относительного пути для текущего файла
        $filePath = $file->getRealPath();

        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Добавить текущий файл в архив
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip-архив будет создан только после закрытия объекта
$zip->close();
