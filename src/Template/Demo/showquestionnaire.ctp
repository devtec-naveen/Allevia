<div class="wraper">
 <div class="inner_page_content">
  <div class="form_bg_box">
   <div class="container">
    <div class="form_box_inner animated slideInLeft">
   <div class="TitleHead">
    <h3>All Questionnaire</h3>

   </div>
  <?php //pr($data); ?>

   <div class="form_fild_content row">

	  <table>
      <thead>
        <th>SN</th>
        <th>Layman Name</th>
        <th>Medical Name</th>

        <th>Cancer Category</th>
        <th>Questionnaire Group</th>
      </thead>
        <tbody>

          <?php if(!empty($getallQuestionData) && count($getallQuestionData)){
              $i= 1;
            foreach ($getallQuestionData as $key => $value) {

            ?>

          <tr>
            <td><?php echo $i; /*echo $value['id'];*/ ?></td>
          <td><?php if(!empty($value['questionnaire_text'])){ echo $value['questionnaire_text'];} ?></td>
          <td><?php if(!empty($value['medical_name'])){ echo $value['medical_name'];} else {echo $value['questionnaire_text'];} ?></td>
          <td><?php if(!empty($value['tab_number'])){ echo $value['tab_number'];} ?></td>
          <td><?php if(!empty($value['QuestionnaireType']['type_name']) ){ echo strtoupper(str_replace("oncology_","", $value['QuestionnaireType']['type_name'])); } ?></td>
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
