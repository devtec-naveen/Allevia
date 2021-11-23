<?php
use Cake\Core\Configure; 
/*$iframe_api_data = null;
$session = $this->request->getSession();
if ($session->check('iframe_api_data')) {

    $iframe_api_data  = $session->read('iframe_api_data');
}*/
$iframe_prefix = Configure::read('iframe_prefix');

?>

<html>
<head>
    <meta charset="utf-8">

    <title><?= $allsettings['meta_title'] ?></title>
    <meta name="title" content="<?= $allsettings['meta_title'] ?>"/>
    <meta name="description" content="<?= $allsettings['meta_description'] ?>"/>

    <meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0,width=device-width, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link href="<?php echo WEBROOT ?>css/bootstrap.min.css" rel="stylesheet" /> 
    <link href="<?php echo WEBROOT ?>css/fontawesome-all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900" rel="stylesheet"> 
    <link rel="stylesheet" href="<?php echo WEBROOT ?>css/mdb.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>css/fontawesome-all.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>css/fontawesome.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>css/aos.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>css/owl.carousel.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>css/style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>css/developer.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo WEBROOT ?>css/responsive.css" rel="stylesheet"/>
   

    <script type="text/javascript" src="<?php echo WEBROOT ?>js/jquery-3.3.1.min.js"></script> 
    <script type="text/javascript" src="<?php echo WEBROOT ?>js/popper.min.js"></script>   
    <script type="text/javascript" src="<?php echo WEBROOT ?>js/bootstrap.min.js"></script>  
    <script type="text/javascript" src="<?php echo WEBROOT ?>js/jquery.loading-indicator.js"></script>      
    
    <script type="text/javascript" src="<?php echo WEBROOT ?>js/owl.carousel.min.js"></script>
     <script type="text/javascript" src="<?php echo WEBROOT ?>js/jquery.validate.min.js"></script>
     <script type="text/javascript" src="<?php echo WEBROOT ?>js/aos.js"></script>      

    
    

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>

<style type="text/css">
<?php if(!empty($iframe_prefix)){ ?>
    .inner_page_content {
       padding-top: 0px !important; 
    }
<?php } ?>
.appointments_box:hover .appointments_button a {
    background: #384685 !important; 
    cursor: auto;
}

    <?php 
        $session = $this->request->session();
        $clinic_color_scheme = $session->read('clinic_color_scheme');  

if(!empty($clinic_color_scheme['heading_color'])) $heading_color = '#'.$clinic_color_scheme['heading_color']; 

// show Text And Title Color
if(!empty($clinic_color_scheme['general_title_color'])) $general_title_color = '#'.$clinic_color_scheme['general_title_color']; 
if(!empty($clinic_color_scheme['general_text_color'])) $general_text_color = '#'.$clinic_color_scheme['general_text_color']; 
// End
if(!empty($clinic_color_scheme['background_color'])) $background_color = '#'.$clinic_color_scheme['background_color']; 
if(!empty($clinic_color_scheme['dashboard_background_color'])) $dashboard_background_color = '#'.$clinic_color_scheme['dashboard_background_color']; 


if(!empty($clinic_color_scheme['text_color'])) $text_color = '#'.$clinic_color_scheme['text_color']; 



if(!empty($clinic_color_scheme['button_gradient_color1'])) $button_gradient_color1 = '#'.$clinic_color_scheme['button_gradient_color1']; 

//echo '.button_gradient_color1 { color: '.$clinic_color_scheme['button_gradient_color1'].' !important; }' ; 
if(!empty($clinic_color_scheme['button_gradient_color2'])) $button_gradient_color2 = '#'.$clinic_color_scheme['button_gradient_color2']; 
//echo '.button_gradient_color2 { color: '.$clinic_color_scheme['button_gradient_color2'].' !important; }' ; 
if(!empty($clinic_color_scheme['button_gradient_color3']))  $button_gradient_color3 = '#'.$clinic_color_scheme['button_gradient_color3']; 
//echo '.button_gradient_color3 { color: '.$clinic_color_scheme['button_gradient_color3'].' !important; }' ; 

if(!empty($clinic_color_scheme['active_button_color']))  $active_button_color = '#'.$clinic_color_scheme['active_button_color']; 

if(!empty($clinic_color_scheme['hover_state_color']))  $hover_state_color = '#'.$clinic_color_scheme['hover_state_color']; 

if(!empty($clinic_color_scheme['active_state_color']))  $active_state_color = '#'.$clinic_color_scheme['active_state_color']; 


if(!empty($clinic_color_scheme['link_color']))  $link_color = '#'.$clinic_color_scheme['link_color']; 
if(!empty($clinic_color_scheme['link_hover_color']))  $link_hover_color = '#'.$clinic_color_scheme['link_hover_color']; 

if(!empty($clinic_color_scheme['appoint_box_bg_color']))  $appoint_box_bg_color = '#'.$clinic_color_scheme['appoint_box_bg_color']; 

if(!empty($clinic_color_scheme['appoint_box_button_color']))  $appoint_box_button_color = '#'.$clinic_color_scheme['appoint_box_button_color']; 

if(!empty($clinic_color_scheme['appoint_box_text_color']))  $appoint_box_text_color = '#'.$clinic_color_scheme['appoint_box_text_color']; 

if(!empty($clinic_color_scheme['progress_bar_graphic']))  $progress_bar_graphic = WEBROOT.'images/'.$clinic_color_scheme['progress_bar_graphic'].'.png'; 



if(!empty($heading_color)){
?>
h2, h3, figcaption h4, .AboutHeadLine h4,  h5, .appointments_box_top .appointments_left h4 {
    color: <?= $heading_color ?> !important;
}


<?php 
}

if(!empty($general_title_color)){
?>
label {
    color: <?= $general_title_color ?> !important;
}
<?php 
}

if(!empty($general_text_color)){
?>
.custom-control-label, [type="radio"]:checked + label, [type="radio"]:not(:checked) + label {
    color: <?= $general_text_color ?> !important;
}
<?php 
}


if(!empty($dashboard_background_color)){
?>
.dashboard_content_bg {
    background-color: <?= $dashboard_background_color ?> !important;
}

<?php 
}

if(!empty($background_color)){
?>
header, .FooterMain, .dashboard_content, .dashboard_menu, .tab_content_inner, .AlleviaTabel, .form_box_inner, .about_des, .ResultAccordian .card-header, .ResultAccordian .card {
    background-color: <?= $background_color ?> !important;
}

<?php 
}

if(!empty($text_color)){
?>
p, .card-body, .BullteList, th, td, .appointments_box_top .appointments_left span, .circles-text {
    color: <?= $text_color ?> !important;
}
.name_dob_header_cls_color {
    color: <?= $text_color ?> !important;
}
<?php 
}
if(!empty($link_color)){
?>

 header .navbar .nav-item .nav-link, a, .FooterMain p, .FooterMain font, .navbar .dropdown-menu a, .my_account_button span, a .alert-info {
    color: <?= $link_color ?> !important;
}
<?php 
}
if(!empty($link_hover_color)){
?>
header .navbar .nav-item .nav-link:hover, a:hover, a .alert-info:hover {
    color: <?= $link_hover_color ?> !important;
}

<?php 
}

if(!empty($button_gradient_color1) && !empty($button_gradient_color2) && !empty($button_gradient_color3))
{

    ?>
@media only screen and (min-width:0px) and (max-width:479px){
    .btn.nofillborder{
        border: 1px solid <?= $heading_color ?> !important;
        background-color: #fff !important;
        color: <?= $heading_color ?> !important;
        background-image: linear-gradient(to right, #fff 0%, #fff 51%, #fff 75%) !important;
        font-weight: 500; 
    }
}

.btn {
    /*background-image: linear-gradient(to right, #2186c7 0%, #384685 51%, #2186c7 75%);*/
    background-image: linear-gradient(to right, <?= $button_gradient_color1 ?> 0%, <?= $button_gradient_color2 ?> 51%, <?= $button_gradient_color3 ?> 75%) !important;

}
.btn span{
    color : #fff !important;
}

.common_conditions_button ul li.active button.selected_chief_complaint {
 background-image: linear-gradient(to right, <?= $button_gradient_color1 ?> 0%, <?= $button_gradient_color2 ?> 51%, <?= $button_gradient_color3 ?> 75%) !important;
}

<?php 
}
if(!empty($active_button_color))
{
    ?>
.tab_form_fild_bg .btn-group .btn.active {
    /*background-image: linear-gradient(to right, #2186c7 0%, #384685 51%, #2186c7 75%);*/
    background: <?= $active_button_color ?> !important;

}

<?php 
}
if(!empty($hover_state_color)){
    ?>
.dashboard_menu ul li:hover a, .dropdown-menu li a:hover {
    background: <?= $hover_state_color ?> !important;
    /*color: #fff;*/
}

.dashboard_menu ul li:hover::before {
    border-left: solid 10px  <?= $hover_state_color ?> !important;

}
.dashboard_menu ul li:hover {
    border-bottom: solid 1px <?= $hover_state_color ?> !important;
}


    <?php 
}

if(!empty($active_state_color)){
?>
.dashboard_menu ul li.active a, .appointments_button a, .alert-info {
    background: <?= $active_state_color ?> !important;
}
.dashboard_menu ul li.active::before {
    border-left: solid 10px <?= $active_state_color ?> !important;
}

<?php } 
if(!empty($appoint_box_bg_color)){
?>
.new_appointment_form a, .appointments_box_top {
    background: <?= $appoint_box_bg_color ?> !important;
}

<?php 
} ?>

<?php if(!empty($progress_bar_graphic)){ 

    ?>
.step_head .step_tab ul li.active a .step_number i {
        background: url(<?= $progress_bar_graphic ?>) no-repeat; }
<?php } ?>
<?php if(!empty($appoint_box_button_color)){ 
    ?>
.appointment_box_button {
    background: <?= $appoint_box_button_color ?> !important;
}
<?php } ?>

<?php if(!empty($appoint_box_text_color)){ 
    ?>
.appointment_box_button {
    color: <?= $appoint_box_text_color ?> !important;
}
<?php } ?>
</style>
</head>
<body oncontextmenu="return false;">
    
    <div class="wraper site_content">
        <?php if(empty($iframe_prefix)){ ?>
            <?= $this->element('front/header') ?>
        <?php } ?>

          <?= $this->fetch('content') ?>
        <?php if(empty($iframe_prefix)){ ?>
            <?= $this->element('front/footer') ?>
        <?php } ?>
    </div>


</body>
<script>
    $(window).scroll(function(){
        var body = $('body'),
        scroll = $(window).scrollTop();

        if (scroll >= 5) body.addClass('fixed');
        else body.removeClass('fixed');
    });
</script>

<script type="text/javascript">
    $('.OurPartnerSlider').owlCarousel({
        loop:false,
        margin:0,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });
</script>
<script type="text/javascript">
  $(window).scroll(function(){var body=$('body'),scroll=$(window).scrollTop();if(scroll>=5){body.addClass('fixed');}else{body.removeClass('fixed');}});
  </script>
  <script>
    AOS.init();
  </script>
</html>




