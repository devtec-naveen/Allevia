<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft" style="display: inline !important;">
   <div class="TitleHead">
    <h3>Schedule Detail</h3>
      
   </div>

   <div class="form_fild_content row" style="padding-bottom: 30px;">
                
                <table>
                  <thead>
                    <th>SN</th>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>DOB</th>
                    <th>Organization Id</th> 
                    <th>Mrn</th>
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
                  <td><?php echo $v['first_name']; ?></td>
                  <td><?php echo $v['last_name']; ?></td>
                  <td><?php echo $v['dob']; ?></td>                  
                  <td><?php echo $v['organization_id']; ?></td>
                  <td><?php echo $v['mrn']; ?></td>
                  <!-- <td><?php //echo $v['gender']; ?></td> -->
                  
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

