    
<div class="wraper">
 <div class="inner_page_content">
  <div class="about_top_des">
   <div class="container">
    <div class="about_top_head animated zoomIn">
     <h2><?php echo $aboutus_data->title ?></h2> 
    </div> 
   
    <div class="about_ger_des animated zoomIn">
     <div class="row">
      <div class="col-md-8">
       <div class="about_ger">
        <a href="javascript:;"><img src="<?= WEBROOT ?>img/<?php echo $aboutus_data->image ?>"/></a>
       </div>
      </div> 
      
      <div class="col-md-4">
       <div class="about_des">
        <?php echo $aboutus_data->content ?>
       </div> 
      </div>
     </div>   
    </div>
   </div>
  </div> 

   <div class="about_video_des"> 
    <div class="container">
      <?php if(!empty($aboutus_data->video_url) && (filter_var($aboutus_data->video_url, FILTER_VALIDATE_URL) !== FALSE)) { ?>
     <div class="about_video_box animated zoomIn">
      <div class="about_video">
       <iframe src="<?php echo $aboutus_data->video_url ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>     
      </div>
     </div> 
   <?php } ?>
     
     <div class="video_des animated zoomIn">
      <?php echo $aboutus_data->bottom_content ?>
     </div>
    </div>
   </div>
  </div>
</div>
