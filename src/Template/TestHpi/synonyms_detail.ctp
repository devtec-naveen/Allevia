<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
   <div class="TitleHead">
    <h3>CC synonyms and doctor specific name</h3>
      
   </div>
   <?php //pr($data); ?>
<?php if(!empty($data) && count($data))
      { ?>
           <div class="form_fild_content row" style="padding-bottom: 30px;">
                <!-- <div class="TitleHead">
                  <h5 style="color: #384685;"><strong><?php //echo $value['name']; ?></strong></h5>
                    
                 </div> -->
                <table>
                  <thead>
                    <th>SN</th>
                    <th>CC Name</th>
                    <th>CC Synonyms</th>
                    <th>Doctor Specific Name</th>
                  </thead>
                <tbody>  
       <?php foreach ($data as $key => $value) 
        {

         
              $i= 1; ?>
              

             
                <tr>
                  <td><?php echo $value['id']; ?></td>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['synonyms']; ?></td>
                  <td><?php echo $value['doctor_specific_name']; ?></td>
                  
                </tr>
        
           

                
             
        
      <?php  } ?>

      </tbody>
              </table>
            </div>

   <?php } ?>
  
  </div> 
   </div> 
  </div> 
 </div>
</div>

