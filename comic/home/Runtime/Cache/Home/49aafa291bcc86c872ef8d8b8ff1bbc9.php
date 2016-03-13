<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test</title>

</head>
<body>
<?php if(is_array($res)): foreach($res as $key=>$v): echo ($v); endforeach; endif; ?>
</body>
</html>