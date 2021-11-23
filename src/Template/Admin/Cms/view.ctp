<section class="content">
        <div class="container-fluid">
                 <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               View CMS
                            </h2>
                             <ol class="breadcrumb breadcrumb-col-blue header-dropdown m-r--5">
                                <li><a href="<?= ADMIN_SITE_URL.'dashboard'  ?>">Dashboard</a></li>
                                <li><a href="<?= ADMIN_SITE_URL.'cms'  ?>">CMS</a></li>
                                <li class="active">View</li>
                            </ol>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-striped results">
                              <tbody>
             
                                    <tr>
                                      <td><strong>Title</strong> </td>
                                      <td><?php echo  $Cms->title ?></td>
                                    </tr>

                                    <tr>
                                      <td><strong>Menu type</strong> </td>
                                      <td><?php 
              $menu_type = array(1 => "Header Manu", 2 => "Header Dropdown Menu Right", 3 => "Footer Menu", 5 => "Header Main Dropdown Menu 1", 4 => "Other" );
                            $temp = ''; 
                          if(!empty($Cms->menu_type)){
                            $Cms->menu_type = explode(',', $Cms->menu_type);
                            // pr($Cms->menu_type); die; 

                            foreach ($Cms->menu_type as $key => $value) {
                              $temp .= $menu_type[$value].', ';
                            }
                            $temp = rtrim($temp, ', '); 
                            echo $temp; 
                          }
                      

                                       ?></td>
                                    </tr>

                                    <tr>
                                      <td><strong>Menu display title</strong> </td>
                                      <td><?php echo  $Cms->menu_display_title ?></td>
                                    </tr>                                    
                              <!--        <tr>
                                      <td><strong>Slug</strong> </td>
                                      <td><?php echo  $Cms->slug ?></td>
                                     
                                    </tr> -->
<?php 
if($Cms->slug == 'aboutus' || $Cms->slug == 'contactus'){

?>                                       
                                     <tr>
                                      <td><strong>Top Content</strong> </td>
                                         <td><?php echo  $Cms->content ?></td>
                                    </tr>


      <tr>
    <td>Image</td>
     <td>  <img width="100px" height="100px" src="<?php echo WEBROOT.'img/'.$Cms->image; ?>"></td>
      </tr>


<?php 
}
if($Cms->slug == 'aboutus'){

?>                                    

                                    <tr>
                                      <td><strong>Video url</strong> </td>
                                         <td><?php echo  $Cms->video_url ?></td>
                                    </tr>
 
<?php } ?>
                                    <tr>
                                      <td><strong>Content</strong> </td>
                                         <td><?php echo  $Cms->bottom_content ?></td>
                                    </tr>
                                 
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
    </section>