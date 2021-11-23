<!DOCTYPE html>
<html>

<head>
<style>
</style>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Allevia | Your Personal AI-powered Medical Assistant</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo  WEBROOT."img/".$allsettings['logo_image']  ;  ?>" type="image/x-icon">
    <link href="<?php echo WEBROOT ?>backend/css/custom.css" rel="stylesheet">
    <!-- data-table -->

    <link href="<?php echo WEBROOT ?>provider/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>provider/css/style.css" rel="stylesheet"/>

    <script type="text/javascript" src="<?php echo WEBROOT ?>provider/js/jquery-3.3.1.min.js"></script>  
    <script type="text/javascript" src="<?php echo WEBROOT ?>provider/js/bootstrap.min.js"></script>
</head>
<body>
     <?= $this->fetch('content') ?>

</body>
</html>

