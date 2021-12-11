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
<html>
<head>
    <style>
        body {
            background: white;
        }

        table {
            margin-top: 200px;
            background: lightgray;
        }
    </style>
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
</head>
<body>
<table width="550" align="center">
    <tr>
        <td align="center">
            <h2 align="center">Welcome to Image Converter :)</h2>
        </td>
    </tr>
    <tr>
        <td align="center">
            <h4 align="center">Make sure the size file maximize  1MB</h4>
        </td>
    </tr>
    <?php if (isset($upload) && !is_array($upload))
    echo '<tr>
        <td align="center">
            <h4 style="color: red" id="error">Error :' . $upload .'</h4>
        </td>
    </tr>';
    ?>
    <?php if (isset($_GET['error']))
    echo '<tr>
        <td align="center">
            <h4 style="color: red" id="error">Error :' . $_GET['error'] .'</h4>
        </td>
    </tr>';
    ?>
    <tr>
        <td align="center">
            <form action="" enctype="multipart/form-data" method="post" onsubmit="return checkEmpty()"/>
            <input type="file" name="fileToUpload" id="fileToUpload"/>
            <input type="submit" value="Upload"/>
            </form>
        </td>
    </tr>
    <tr>
        <td align="center">
            <h4>Developed by Mr.Muath / Eng.Khalid</h4>
        </td>
    </tr>
</table>
</body>
</html>