<!DOCTYPE html>

<html>
<head>
<style>
.dataTables_wrapper .myfilter .dataTables_filter {float:left}
.dataTables_wrapper .mylength .dataTables_length {float:right}
</style>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Allevia | Your Personal AI-powered Medical Assistant</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo  WEBROOT."img/".$allsettings['logo_image']  ;  ?>" type="image/x-icon">
    <link href="<?php echo WEBROOT ?>provider/css/bootstrap.css" rel="stylesheet"/>
    <link href="<?php echo WEBROOT ?>provider/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css" rel="stylesheet"/>
    <link href="<?php echo WEBROOT ?>provider/css/buttons.bootstrap4.min.css" rel="stylesheet"/>
    <link href="<?php echo WEBROOT ?>backend/css/custom.css" rel="stylesheet">
    <!-- data-table -->

    <link href="<?php echo WEBROOT ?>provider/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>provider/css/owl.carousel.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>provider/css/fontawesome-all.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>provider/css/fontawesome.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>provider/css/style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>provider/css/hopscotch.css" rel="stylesheet"/>

    <script type="text/javascript" src="<?php echo WEBROOT ?>provider/js/jquery-3.3.1.min.js"></script>

    <script type="text/javascript" src="<?php echo WEBROOT ?>provider/js/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo WEBROOT ?>provider/js/bootstrap.min.js"></script>
    <script src="<?php echo WEBROOT ?>backend/plugins/ckeditor/ckeditor.js"></script>


    <!-- data-table -->
    <script type="text/javascript" src="<?php echo WEBROOT ?>provider/js/jquery.dataTables.min.js"></script>
     <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>

    <script type="text/javascript" src="<?php echo WEBROOT ?>provider/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="<?php echo WEBROOT ?>provider/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="<?php echo WEBROOT ?>provider/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="<?php echo WEBROOT ?>provider/js/hopscotch.js"></script>
</head>
<body>
 <?= $this->Flash->render(); ?>

<div class="wraper">
<!-- #END# Search Bar -->
 <?= $this->element('provider/header') ?>
<?= $this->element('provider/sidebar') ?>
 <?= $this->fetch('content') ?>   
</div>

<script type="text/javascript">

$(".side-bar-open").click(function(){
  $(".side-bar").toggleClass("active");
  $(this).toggleClass("active");
});


$(function() {
    var table = $('.js-basic-example').DataTable({
        responsive: true,
        stateSave: true,
        pageLength: 25,
        lengthMenu: [
            [25, 50, 100],
            [25, 50, 100]
        ],
        dom: "<'myfilter'f><'mylength'l>tt<'mylength'p>",
        fixedHeader: true,
    });    
});



</script>

<script type="text/javascript">
    var closeSidebar;
jQuery(document).ready(function($) {
    var open = false;

    var openSidebar = function() {
        $('.menu--slide-right').addClass('active');
        $('.toggle-menu').addClass('active');
        open = true;
    }
     closeSidebar = function() {
        $('.menu--slide-right').removeClass('active');
        $('.toggle-menu').removeClass('active');
        open = false;
    }

    $('.toggle-menu').click(function(event) {
        event.stopPropagation();
        var toggle = open ? closeSidebar : openSidebar;
        toggle();
    });


    $(".toggle-menu").click(function(event) {
        var step = hopscotch.getCurrStepNum();

        if (step != 0 && step != 1 && step != 2 && step != 3) {
            if (open == false) {
                hopscotch.endTour();
            } else if (open == true) {
                //hopscotch.startTour(tour, stepNum)
            }
        }
    });

    var step = hopscotch.getCurrStepNum();
    if (step != 0 && step != 1 && step != 2 && step != 3) {
        if (open == false) {
            hopscotch.endTour();
        }
    }
});

    $(document).on('click','.wraper',function(event){

        var hclose = $(event.target).closest('.hopscotch-close').length;
        //alert(hclose);
         var hprev = $(event.target).closest('.hopscotch-prev').length;

         var hnext = $(event.target).closest('.hopscotch-next').length;

         if (!$(event.target).closest('.menu--slide-right').length && !hclose && !hprev && !hnext) {
             closeSidebar();             
         }
    
});





</script>

</body>
</html>
