<?php


$generate =  new PARSING_IMAGE();

if (isset( $_POST['url'] , $_POST['dirname'])) {
    $url = trim(htmlspecialchars($_POST['url']));
    $dirName = trim(htmlspecialchars($_POST['dirname']));

    $result = $generate->create($url, $dirName);

    echo json_encode($result);
}

if (isset($_POST['remove'])) {
    $generate->rmZip();

    return 'rerwr';
}






class PARSING_IMAGE
{
    protected $path;

    public function create($url, $dirname): array
    {
        // Директория куда будут сохранятся изображения.
        $path = dirname(__FILE__) . '../../../storage/' . $dirname;
        $this->path = $path;

        // Загружать или нет изображения с других доменов.
        $external = true;

        // находим картинки
        $html = file_get_contents($url);
        preg_match_all('/<img.*?src=["\'](.*?)["\'].*?>/i', $html, $images, PREG_SET_ORDER);

        $url = parse_url($url);
        $path = rtrim($path, '/');

        $this->sort($images, $path, $url, $external);
        $this->zip($path);

        return [
            'dirname' => $dirname . '.zip'
        ];
    }

    protected function sort($images, $path, $url, $external)
    {
        foreach ($images as $image) {
            $imgName = '/' . strrev(strstr(strrev($image[1]), '/', true));

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
    }

    protected function zip($path)
    {
        /* СОЗДАНИЕ АРХИВА */
        $rootPath = realpath($path);

        // Инициализация объекта архива
        $zip = new ZipArchive();

        $zip->open($path . '.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

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


        $this->rmDir($path);
    }

    protected function rmDir($path)
    {
        // находит файловый путь
        $files = glob($path . "/*");

        // проверяем на наличие файлов внутри
        if (count($files) > 0) {
            // перебераем файлы внутри папки
            foreach ($files as $file) {
                // проверка файла на наличие
                if (file_exists($file)) {
                    // удаление файла
                    unlink($file);
                }
            }
        }

        if (file_exists($path)) {
            // удаление пустой директории после чисткии
            rmdir($path);
        }
    }

    public function rmZip()
    {
        if (file_exists($this->path . '.zip')) {
            // удаление архива
            unlink($this->path . '.zip');
        }
    }
}














