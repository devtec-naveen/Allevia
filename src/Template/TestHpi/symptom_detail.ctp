<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
   <div class="TitleHead">
    <h3>Symptoms CPT HPI Element</h3>
      
   </div>
<?php if(!empty($data) && count($data))
      { 
             
        foreach ($data as $key => $value) 
        {

          if(!empty($value['all_detail_questions']))
          {
              $i= 1; ?>
              <div class="form_fild_content row" style="padding-bottom: 30px;">
                <div class="TitleHead">
                  <h5 style="color: #384685;"><strong><?php echo $value['name']; ?></strong></h5>
                    
                 </div>
                <table>
                  <thead>
                    <th>SN</th>
                    <th>Question</th>
                    <th>CPT HPI Element Type</th>
                  </thead>
                <tbody>

              <?php foreach ($value['all_detail_questions'] as $k => $v)
               { ?>

                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $v['question']; ?></td>
                  <td><?php echo $v['cpt_hpi_element_type']; ?></td>
                  
                </tr>
  			
            <?php $i++; } ?>

                </tbody>
              </table>
            </div>
             <?php }  ?>
        
      <?php  } } ?>
  
  </div> 
   </div> 
  </div> 
 </div>
</div>

