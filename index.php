<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resizer & Compressor</title>

    <style>
        .images_preview {
            width: 60vw
        }
        .images_preview img {
            width: 100%
        }
    </style>
</head>
<body>

    <form action="resize.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="images[]" id="images" onchange="preview_image();" multiple>
        <input type="submit" value="Enviar">
        <div class="images_preview" id="images_preview"></div>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() { 
            
        });

        function preview_image() 
        {
            var total_file = document.getElementById("images").files.length;
            for(var i=0;i<total_file;i++)
            {
                $('#images_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'><br>");
            }
        }
    </script>
</body>
</html>