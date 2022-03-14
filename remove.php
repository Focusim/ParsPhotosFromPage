<?php


// путь к папке
$path = 'C:\xampp\htdocs\ParsPhotosFromPage\storage\test';

cleanDir($path);

function cleanDir($path) {

    // находит файловый путь
    $files = glob($path."/*");

    // считаем количество файлов в папке
    $c = count($files);

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

        echo 'Удалил папку <br>';
    }
    

    if (file_exists($path . '.zip')) {

        // удаление архива
        unlink($path . '.zip');

        echo 'Удалил архив <br>';
    }
}





























