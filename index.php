<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resizer</title>
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
        <hr class="range">
        <section class="header-controll">
            <div class="row create-img">
                <p>Ou as selecione clicando no botão:</p>
                <button type="button" class="btn btn-primary" id="create-img-input">
                    <i class="fa-solid fa-plus"></i>
                    <div class="tooltip">
                        Adicionar mais imagem
                    </div>
                </button>
            </div>

            <button type="button" class="accordion">
                Expandir opções gerais
                <i class="fa-solid fa-caret-down"></i>
            </button>
            <div class="panel">
                <div class="general-options">
                    <div class="row">
                        <div class="option">
                            <label for="all-webp">Salvar em Webp?</label>
                            <input type="checkbox" id="all-webp">
                        </div>
                        <div class="option">
                            <label for="compress">Comprimir?</label>
                            <input type="checkbox" name="compress" id="compress">
                        </div>
                    </div>
                    <div class="row">
                        <div class="option">
                            <input type="number" name="width" id="width" placeholder="Largura">
                            X
                            <input type="number" name="height" id="height" placeholder="Altura">
                        </div>
                    </div>
                    <div class="row">
                        <div class="option">
                            <label for="px">Pixel px:</label>
                            <input type="radio" id="px" name="measure" value="mail" />
                        </div>
                        <div class="option">
                            <label for="percentage">Porcentagem %:</label>
                            <input type="radio" id="percentage" name="measure" value="mail" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="inputs" id="inputs">
            
        </section>
        <button class="btn btn-success" type="submit">Enviar</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                } 
            });
        }
    </script>
    <script>
        let inputId = 1;

        $(document).ready(function() {
            $('#create-img-input').on('click', function() {
                var div = $('<div>').addClass('input').attr('id', 'input' + inputId);

                div.html(`
                <div class="img-container">
                    <img src="img/image-file.png" id="img-preview-${inputId}">
                </div>
                <div class="input-options">
                    <div class="row">
                    <div class="option">
                        <label class="btn upload-img" for="img-input${inputId}">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <div class="tooltip">
                                Carregar imagem
                            </div>
                        </label>
                        <input type="file" name="imgs[]" id="img-input${inputId}" onchange="previewImage(this)" class="img-input" data-id="${inputId}">
                    </div>
                    <div class="option">
                        <button type="button" class="btn btn-danger del-img-btn" data-id="${inputId}" onclick="deleteImg(this)">
                        <i class="fa-solid fa-trash"></i>
                        <div class="tooltip">
                            Deletar imagem
                        </div>
                        </button>
                    </div>
                    <div class="option">
                        <label for="webp-${inputId}"><i class="fa-regular fa-file-image"></i> Salvar em Webp?</label>
                        <input type="checkbox" name="webp[]" id="webp-${inputId}">
                    </div>
                    <div class="option">
                        <label for="compress"><i class="fa-solid fa-down-left-and-up-right-to-center"></i> Comprimir?</label>
                        <input type="checkbox" name="compress" id="compress">
                    </div>
                    </div>
                    <div class="row"></div>
                    <div class="row">
                    <div class="option">
                        <input type="number" name="width" id="width" placeholder="Largura">
                        X
                        <input type="number" name="height" id="height" placeholder="Altura">
                    </div>
                    </div>
                </div>
                `);
                inputId++;
                $('#inputs').append(div);
            });
        });

        function previewImage(input) {
            console.log(input);
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                let id = $(input).data('id');
                let fileName = input.files[0].name;
                let fileSize = input.files[0].size;
                let uniqId = fileSize + "/" + fileName;
  

                $('#webp-'+id).val(uniqId)

                reader.onload = function (e) {
                    $('#img-preview-' + id).attr('src', e.target.result);
                };
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        function deleteImg(btn) {
            let id = btn.getAttribute('data-id');
            $('#input'+id).remove();
            console.log(id)
        }
    </script>
</body>
</html>