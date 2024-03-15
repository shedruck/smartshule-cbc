<?php

/*
 * 
 * ###################    
 * $url = PATH_ROOT.'images/uploads/'.time()."_".$_FILES['upload']['name'];   
 * ###############################
 * 
 */

$url = BASEPATH . 'assets/uploads/ckeditor/' . time() . "_" . $_FILES['upload']['name'];

$url_aux = substr($url, strlen(BASEPATH) - 1);

if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])))
{
    $message = "No file uploaded.";
}
else if (file_exists(BASEPATH . 'assets/uploads/ckeditor/' . $_FILES['upload']['name']))
{
    $message = "File already exists";
}
else if ($_FILES['upload']["size"] == 0)
{
    $message = "The file is of zero length.";
}
else if (($_FILES['upload']["type"] != "image/pjpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png"))
{
    $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
}
else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
{
    $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
}
else
{
    $message = "Image uploaded correctly";

    move_uploaded_file($_FILES['upload']['tmp_name'], $url);
}

$funcNum = $_GET['CKEditorFuncNum'];
$url = $url_aux;
echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
?>