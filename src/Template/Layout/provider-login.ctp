<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Allevia | Your Personal AI-powered Medical Assistant</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo WEBROOT ?>favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo WEBROOT ?>backend/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo WEBROOT ?>backend/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo WEBROOT ?>backend/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->

    <link href="<?php echo WEBROOT ?>backend/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo WEBROOT ?>css/responsive.css" rel="stylesheet"/>

   <!-- Jquery Core Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo WEBROOT ?>backend/js/admin.js"></script>
    <script src="<?php echo WEBROOT ?>backend/js/pages/examples/sign-in.js"></script>

     <!-- Bootstrap Notify Plugin Js -->
     <script src="<?php echo WEBROOT ?>backend/plugins/bootstrap-notify/bootstrap-notify.js"></script>


    
</head>
<body class="provider login-page provider-sec">
 <?= $this->Flash->render(); ?>
 <?= $this->fetch('content') ?>
 
     <script type="text/javascript">
         
    $('#forgot_password').validate({
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    });
       $('#admin_login').validate({
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    }); 
    $('#reset_password').validate({
        highlight: function (input) {
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        }
    });

     </script>
</body>
</html>
