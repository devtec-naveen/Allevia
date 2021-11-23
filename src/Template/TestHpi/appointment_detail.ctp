<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
   <div class="TitleHead">
    <h3>User Detail</h3>
      
   </div>

   <div class="form_fild_content row" style="padding-bottom: 30px;">
                
                <table>
                  <thead>
                    <th>SN</th>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Appointment Time</th>
                    <th>Appointment Date</th>
                    <th>Email Notification</th>
                    <th>Text Notification</th>
                  </thead>
                <tbody>
<?php if(!empty($data) && count($data))
      {   $i= 1; ?>
              

              <?php foreach ($data as $k => $v)
               { ?>

                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $v['id']; ?></td>
                  <td><?php echo $v['email']; ?></td>
                  <td><?php echo $v['phone']; ?></td>
                  <td><?php echo $v['appointment_time']; ?></td>
                  <td><?php echo $v['appointment_date']; ?></td>
                  <td><?php pr($v['notify_email_schedule']); ?></td>
                  <td><?php pr($v['notify_text_schedule']); ?></td>                  
                </tr>
  			
            <?php $i++; } ?>

                
             <?php }  ?>
      
            </tbody>
          </table>
        </div>
  </div> 
   </div> 
  </div> 
 </div>
</div>

