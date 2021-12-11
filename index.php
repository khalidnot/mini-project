<?php

//import the converter class
require('image_converter.php');

if ($_FILES) {
    $obj = new Image_converter();
    //call upload function and send the $_FILES, target folder and input name
    $upload = $obj->upload_image($_FILES, 'fileToUpload');

    if (is_array($upload)) {
        $imageName = urlencode($upload[0]);
        $imageType = urlencode($upload[1]);

        if ($imageType == 'jpeg') {
            $imageType = 'jpg';
        }

        header('Location: convert.php?imageName=' . $imageName . '&imageType=' . $imageType);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Converter</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="text-center">

<main class="form-signin">
    <form action="" enctype="multipart/form-data" method="post"
          onsubmit="return checkEmpty()"/>
    <img class="mb-4" src="https://cti.edu.sa/img/tvtclogo1.svg">
    <h1 class="h4 mb-4 fw-normal">Welcome to Image Converter</h1>
    <?php if (isset($upload) && !is_array($upload))
        echo '<div class="alert alert-danger" role="alert">
  <p>' . $upload . '</p>
</div>';
    ?>
    <?php if (isset($_GET['error']))
        echo '<div class="alert alert-danger" role="alert">
  <p>' . $_GET['error'] . '</p>
</div>';

    ?>

    <div class="alert alert-primary" role="alert">
        <h4  class="h6 mb-4 fw-normal">Before you upload the file make sure it's under there's requirement :</h4>
    <ul style="text-align: left">
        <li>Size file maximize 1MB</li>
        <li>Allowed image types in : jpg, png, jpeg</li>
    </ul>
    </div>
    <div class="form-group">
        <input type="file" class="form-control" id="fileToUpload" name="fileToUpload">
    </div>
    <br/>
    <button class="w-100 btn btn-lg btn-primary" type="submit" value="Upload">Upload</button>
    <p class="mt-5 mb-3 text-muted">Developed by
    <a href="https://twitter.com/MoathDev" target="_blank">@Moathdev</a>
    & <a href="https://twitter.com/khalidTurkai" target="_blank">@Khalid Turkai</a>
    </p>
    </form>
</main>
</body>
<script>
    function checkEmpty() {
        var img = document.getElementById('fileToUpload').value;
        if (img == '') {
            alert('Error : Please upload an image')
            return false;
        }
        return true;
    }
</script>
</html>

