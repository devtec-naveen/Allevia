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
    <link rel="icon" href="<?php echo  WEBROOT."img/".$allsettings['logo_image']  ;  ?>" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo WEBROOT ?>backend/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo WEBROOT ?>backend/plugins/node-waves/waves.css" rel="stylesheet" />

     <!-- JQuery DataTable Css -->
    <link href="<?php echo WEBROOT ?>backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

     <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo WEBROOT ?>backend/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo WEBROOT ?>backend/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Main Css -->
    <link href="<?php echo WEBROOT ?>backend/css/style.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="<?php echo WEBROOT ?>backend/css/custom.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="<?php echo WEBROOT ?>backend/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
   

  <!-- Jquery Core Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/node-waves/waves.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo WEBROOT ?>backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/jquery-validation/jquery.validate.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    <!-- Custom Js -->
    <script src="<?php echo WEBROOT ?>backend/js/admin.js"></script>
    <!-- <script src="<?php echo WEBROOT ?>backend/js/validate.js"></script> -->
    <script src="<?php echo WEBROOT ?>backend/js/pages/examples/sign-in.js"></script>

     <!-- Autosize Plugin Js -->
    <script src="<?php echo WEBROOT ?>backendbackend/plugins/autosize/autosize.js"></script>

     <!-- Moment Plugin Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/momentjs/moment.js"></script>

    <!-- Ckeditor -->
    <script src="<?php echo WEBROOT ?>backend/plugins/ckeditor/ckeditor.js"></script>

     <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo WEBROOT ?>backend/plugins/bootstrap-select/js/bootstrap-select.js"></script>

     <!-- Bootstrap Notify Plugin Js -->
     <script src="<?php echo WEBROOT ?>backend/plugins/bootstrap-notify/bootstrap-notify.js"></script>

     <script type="text/javascript" src="<?php echo WEBROOT ?>backend/js/jquery.cookie.js"></script>

   

    <!-- adminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo WEBROOT ?>backend/css/themes/all-themes.css" rel="stylesheet" />
    <style>.headingpro {}.copypro{float: right;margin-left: -50%;margin-top: -2em;}</style>
</head>
<body class="theme-light-blue">
 <?= $this->Flash->render(); ?>
    <!-- Page Loader -->
    <!-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div> -->
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
     <?= $this->element('admin/header') ?>
    <?= $this->element('admin/sidebar') ?>
     <?= $this->fetch('content') ?>
    
  

     <script type="text/javascript">
     $(function () {
        $('.js-basic-example').DataTable({
        responsive: true
        });
     });
     $('#checkAll').change(function(){
         $('input:checkbox').not(this).prop('checked', this.checked);
       });

     //

     function copyToClipboard(copyTextarea,model_name){        
                try{     
                  $(".message").css('display','block');       
                  $(copyTextarea).find('pre').css('background-color','#fff');
                  $(copyTextarea).find('pre').css('border','none');         
                  var $temp = $("<div>");         
                  $('.theme-light-blue #exampleModal .modal-content').append($temp);          
                  $temp.attr("contenteditable", true)
                       .html($(copyTextarea).html())
                       .select()
                       .focus()               
                       document.execCommand("copy");
                       document.execCommand('selectAll',false,null)                          
                       var successful = document.execCommand("copy");           
                       var msg = successful ? 'successfully' : 'unsuccessfully'; 
                       $(".message").text('Copied '+msg); 
                       setTimeout(function(){
                          $('.message').css('display','none');
                        },5000);                                                          
                       $temp.remove();                                           
                }
                catch (err) {         
                  console.log('Oops, unable to copy');
                }
      } 
  
    </script>

</body>
</html>
