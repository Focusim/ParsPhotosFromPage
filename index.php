<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/index.css" type="text/css">
</head>
<body>

    <div class="container">

        <form class="form" id="form" action="assets/function/function.php" method="POST">
            <input class="input text" type="text" id="url" name="url" placeholder="Ссылка на страницу" required>
            <input class="input text" type="text" id="dirname" name="dirname" placeholder="Как назовём архив?" required>
            <input class="input btn" type="button" id="btn" value="Загрузить">
            <div class="loader" id="loader"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
        </form>

        <a class="input download" id="download" href="" download>Скачать архив</a>
    </div>

</body>
<script src="assets/js/index.js"></script>
</html>

<!-- Придумать как удалять файлы по запросу
     Поправить нейминг
     Поправить появление/исчезновение кнопок
     Поправить gitignore + storage/.gitkeep
     -->
