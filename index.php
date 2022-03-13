<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<? ?>
<form action="post.php" class="form" method="POST" id="form">
    <input class="input" type="text" name="url" placeholder="URL" value="" required>
    <input class="input" type="text" id="dirname" name="dirname" placeholder="Dirname" value="" required>
    <input class="input btn" type="button" value="Button">
    <a class="download" id="download" href="" download>Download</a>
</form>

<script>
    const btn = document.querySelector('.btn')

    btn.addEventListener('click', ev => {

        fetch('post.php', {
            method: 'POST',
            body: new FormData( document.getElementById('form')),
        });

        const dirnameValue = document.querySelector('#dirname').value
        const downloadBtn = document.querySelector('#download')
        downloadBtn.setAttribute('href', dirnameValue  + '.zip')
    })

</script>

<style>
    * {
        box-sizing: border-box;
        letter-spacing: 0.3em;
        font-weight: 700;
        font-size: 17px;
    }

    body {
        max-width: 600px;
        width: 100%;
        margin: 0 auto;
        padding: 100px 0;
    }

    .form {
        display: flex;
        flex-direction: column;
        gap: 40px;
    }

    .input {
        color: #ffffff;
        background: darkslategrey;
        height: 40px;
        width: 100%;
        padding: 0 20px;
    }

    .btn {
        cursor: pointer;
    }

    .btn:active {
        transform: scale(0.97);
    }

    .download {
        color: #ffffff;
        text-align: center;
        text-decoration: none;
        background: darkslategrey;
        width: 100%;
        padding: 10px 20px;
    }
</style>

</body>
</html>
