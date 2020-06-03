<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>HTML Media Capture Sample Upload</title>
</head>
<body>
<h1>HTML Media Capture Sample Upload</h1>
<?php
var_dump($_FILES["capture"]);
if (is_uploaded_file($_FILES["capture"]["tmp_name"])){
    move_uploaded_file($_FILES["capture"]["tmp_name"], $_FILES["capture"]["name"]);
    echo "upload success<br />";
    echo '<a target="_blank" href="'. $_FILES["capture"]["name"] . '">view file</a><br />';
}else{
    echo "no upload file<br />";
}
?>
</body>
</html>