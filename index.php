<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <form action="./img_submit.php" method="POST" enctype="multipart/form-data">
        <div class="drag">
            <div class="drag-zone">
                <i class="fa-solid fa-upload"></i>
                <p>Arraste suas imagens para esta área</p>
            </div>
        </div>
        <div class="input">

        </div>
        <label for="imgs">Imagens: </label>
        <input type="file" name="imgs[]" id="imgs" multiple>
        <br>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>