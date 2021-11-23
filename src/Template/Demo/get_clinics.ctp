<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
   <div class="TitleHead">
    <h3>Clinics List</h3>
      
   </div> 
  <?php //pr($data); die;?>
      
   <div class="form_fild_content row">
	 
	  <table>
      <thead>
        <th>SN</th>
        <th>Clinic Name</th>
        <th>Specializations</th>
      </thead>
        <tbody>	

          <?php if(!empty($data) && count($data)){ 
              $i= 1;
            foreach ($data as $key => $value) {              
           
            ?>

          <tr>
            <td><?php echo $i; ?></td>
          <td><?php echo $value['organization_name']; ?></td>
          <td><?php echo $value['specialization']; ?></td>
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

