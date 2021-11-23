<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
   <div class="TitleHead">
    <h3>All Visits History</h3>
      
   </div> 
  <?php //pr($data); ?>
      
   <div class="form_fild_content row">
	 
	  <table>
      <thead>
        <th>SN</th>
        <th>Visit Reason</th>
        <th>Specialization</th>
        <th>Clinic Name</th>
      </thead>
        <tbody>	

          <?php if(!empty($data) && count($data)){ 
              $i= 1;
            foreach ($data as $key => $value) {              
           
            ?>

          <tr>
            <td><?php echo $i;//$value['id']; ?></td>
          <td><?php if(!empty($value['current_step_id']) && is_object($value['current_step_id'])){ echo $value['current_step_id']['step_name']; } ?></td>

          <td><?php if(!empty($value['appointment']) && !empty($value['appointment']['specialization'])){ echo $value['appointment']['specialization']['name']; } ?></td>

          <td><?php if(!empty($value['appointment']) && !empty($value['appointment']['organization'])){ echo $value['appointment']['organization']['organization_name']; } ?></td>
        </tr>
  			
      <?php $i++; }  }?>
		</tbody>
		</table>
   
   </div>
  </div> 
   </div> 
  </div> 
 </div>
</div>

