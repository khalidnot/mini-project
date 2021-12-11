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
<html>
<head>
    <style>
        img {
            max-width: 360px;
        }

        body {
            background: lightgray;
        }

    </style>
</head>
<body>
<?php if (!$download) { ?>
    <form method="post" action="">
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <table width="500" align="center">
            <tr>

                <td align="center">
                    File Uploaded, Select below option to convert!
                    <img src="<?= $obj->target_dir.'/'.$imageName; ?>"/>
                </td>
                <br/>
            </tr>
            <tr>
                <td align="center">
                    Convert To:
                    <select name="convert_type">
                        <?php foreach ($types as $key => $type) { ?>
                            <?php if ($key != $imageType) { ?>
                                <option value="<?= $key; ?>"><?= $type; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    <br/><br/>
                </td>
            </tr>
            <tr>
                <td align="center"><input type="submit" value="convert"/></td>
            </tr>
        </table>
    </form>
<?php } ?>
<?php if ($download) { ?>
    <table width="500" align="center">
        <tr>
            <td align="center">
                Image Converted to <?php echo ucwords($convert_type); ?>
                <img src="<?= $obj->target_dir . '/' . $image; ?>"/>
            </td>
        </tr>
        <td align="center">

            <a href="download.php?filepath=<?php echo $obj->target_dir . '/' . $image; ?>"/>Download Converted Image</a>
        </td>
        </tr>
        <tr>
            <td align="center"><a href="index.php">Convert Another</a></td>
        </tr>
    </table>
<?php } ?>
</body>
</html>