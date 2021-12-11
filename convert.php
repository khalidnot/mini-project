<?php

//import the converter class
require('image_converter.php');

//create object of image converter class
$obj = new Image_converter();

$imageType = '';
$download = false;

//handle get method, when page redirects
if ($_GET) {
    $imageType = urldecode($_GET['imageType']);
    $imageName = urldecode($_GET['imageName']);
} else {
    header("Location: index.php?error=You can't access the page without upload image");
}

//handle post method when the form submitted
if ($_POST) {

    $convert_type = $_POST['convert_type'];

    //convert image to the specified type
    $image = $obj->convert_image($convert_type, $imageName);

    //if converted activate download link
    if ($image) {
        $download = true;
    }
}

//convert types
$types = array(
    'png' => 'PNG',
    'jpg' => 'JPG',
);
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
    <img class="mb-4" src="https://cti.edu.sa/img/tvtclogo1.svg">
    <?php if (!$download) { ?>
        <form method="post" action="">
            <div class="alert alert-success" role="alert">
                File Uploaded, Select below option to convert!
            </div>
            <img style="max-width: 360px;" src="<?= $obj->target_dir.'/'.$imageName; ?>"/>
            <br/>
            <br/>
            <br/>
            <div class="form-group">
                <select class="form-control" id="convert_type" name="convert_type">
                    <?php foreach ($types as $key => $type) { ?>
                        <?php if ($key != $imageType) { ?>
                            <option value="<?= $key; ?>"><?= $type; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>
            <br/>
            <button class="w-100 btn btn-lg btn-primary" type="submit" value="convert">Convert</button>
        </form>
    <?php } ?>
    <?php if ($download) { ?>
    <div class="alert alert-success" role="alert">
        Image Converted to <?php echo ucwords($convert_type); ?>
    </div>
    <img style="max-width: 360px;" src="<?= $obj->target_dir . '/' . $image; ?>"/>
   <br/>
   <br/>
   <br/>
        <a class="btn btn-primary" href="download.php?filepath=<?php echo $obj->target_dir . '/' . $image; ?>" role="button">Download Converted Image</a>
        <a class="btn btn-secondary" href="index.php" role="button">Convert Another</a>
    <?php } ?>
    <p class="mt-4 text-muted">Developed by
        <a href="https://twitter.com/MoathDev" target="_blank">@Moathdev</a>
        & <a href="https://twitter.com/khalidTurkai" target="_blank">@Khalid Turkai</a>
    </p>
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
