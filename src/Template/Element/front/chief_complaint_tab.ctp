 <?php
use Cake\Utility\Security;
?>
		<label>What is the main reason you need to see your doctor for?&nbsp;<span class="required">*</span></label>
		    <div class="tab_form_fild_bg">
			   <div class="row">
				<div class="col-md-8">
				 <div class="form-group form_fild_row chief_compliant_select_div">


			<div class="custom-drop">
				<input type="text" id="main_chief_compliant_id"   class="form-control symptombox    <?php echo ($apt_id_data->specialization_id == 3 || $apt_id_data->specialization_id == 4) ? 'symptom_suggestion_ortho' : 'symptom_suggestion'; // symptom_suggestion_ortho class will be added to main chief complaint box when the specialization is orthopedics(3) or orthopedics_spine (4) otherwise symptom_suggestion class will be added ?>" name="main_chief_compliant_id" placeholder="Enter Chief Complaint" required="true" value="<?php echo  !empty($user_detail_old->chief_compliant_userdetail->chief_compliant_id->name) ? $user_detail_old->chief_compliant_userdetail->chief_compliant_id->name : '' ?>"/>

			      <ul class="<?php echo ($apt_id_data->specialization_id == 3 || $apt_id_data->specialization_id == 4) ? 'symptom_suggestion_ortho_listul' : 'symptom_suggestion_listul';  ?> custom-drop-li">
					</ul>

			</div>
			<script type="text/javascript">

	$(document).ready(function() {
		// var step_id = '<?= $step_id;?>';
 	// 	alert(step_id)
		var ccmedid = '<?= !empty($user_detail_old->chief_compliant_userdetail->chief_compliant_id->id) ? $user_detail_old->chief_compliant_userdetail->chief_compliant_id->id : '' ; ?>';
		if(ccmedid && step_id != 25)
		{
			add_medicatin_quickpick(ccmedid);
		}

	});
</script>

				 </div>
				</div>

				<div class="col-md-4">
				 <div class="row">

				  <div class="col-md-12">
				   <div class="form-group form_fild_row">
<?php  $old_compliant_length =  !empty($user_detail_old->chief_compliant_userdetail->compliant_length) ? $user_detail_old->chief_compliant_userdetail->compliant_length : '' ?>
					<select class="form-control" name="chief_compliant_length" id="chief_compliant_length" required="true">
				<option value="">How long?</option>
				<option <?php echo $old_compliant_length == '1 hour' ? 'selected' : '' ?> value="1 hour">1 hour</option>
				<option <?php echo $old_compliant_length == '2 hours' ? 'selected' : '' ?> value="2 hours">2 hours</option>
				<option <?php echo $old_compliant_length == '3 hours' ? 'selected' : '' ?> value="3 hours">3 hours</option>
				<option <?php echo $old_compliant_length == '6 hours' ? 'selected' : '' ?> value="6 hours">6 hours</option>
				<option <?php echo $old_compliant_length == '12 hours' ? 'selected' : '' ?> value="12 hours">12 hours</option>

				<?php
						for ($i=1; $i < 14 ; $i++) {
							?>
					<option <?php echo $old_compliant_length == $i. ($i>1 ?' days' : ' day') ? 'selected' : '' ?> value="<?php echo  $i. ($i>1 ?' days' : ' day') ?>"><?php echo  $i. ($i>1 ?' days' : ' day') ?></option>

							<?php

						}
						for ($i=2; $i < 7 ; $i++) {
							?>
					<option <?php echo $old_compliant_length == $i. ($i>1 ?' weeks' : ' week') ? 'selected' : '' ?> value="<?php echo  $i. ($i>1 ?' weeks' : ' week') ?>"><?php echo  $i. ($i>1 ?' weeks' : ' week') ?></option>

							<?php

						}
						for ($i=2; $i < 12 ; $i++) {
							?>
					<option <?php echo $old_compliant_length == $i. ($i>1 ?' months' : ' month') ? 'selected' : '' ?> value="<?php echo  $i. ($i>1 ?' months' : ' month') ?>"><?php echo  $i. ($i>1 ?' months' : ' month') ?></option>

							<?php

						}
						for ($i=1; $i < 11 ; $i++) {
							?>
					<option <?php echo $old_compliant_length == $i. ($i>1 ?' years' : ' year') ? 'selected' : '' ?> value="<?php echo  $i. ($i>1 ?' years' : ' year') ?>"><?php echo  $i. ($i>1 ?' years' : ' year') ?></option>

							<?php

						}
					?>
					<option <?php echo $old_compliant_length == "10+ years" ? 'selected' : '' ?> value="10+ years">10+ years</option>

					</select>
				   </div>
				  </div>
				 </div>
				</div>
			   </div>
</div>

<style type="text/css">
	.symptom_field_display_none_onload{ display: none; }
	.medicalhistoryfld { margin-bottom: 10px;  }
</style>
<script type="text/javascript">

$(document).ready(function() {
 $(document).on("click",".medicalhistoryfldadd",function() {

		var cloneob = $( ".symptom_field_display_none_onload" ).clone();

$( cloneob ).addClass('medicalhistoryfld').removeClass('symptom_field_display_none_onload');
$( cloneob ).find('input').addClass('symptombox');
// $( cloneob ).find('select').addClass('symptombox').select2(); // commented as select box is not used now
		$(cloneob).insertAfter( ".medicalhistoryfld:last" );

	});
 $(document).on("click",".medicalhistoryfldtimes button",function() {
 	$(this).parents('.medicalhistoryfld').remove();
 });


});



</script>


				
			    <?php 
			    $selected_chief_complnts = array();
			    if(!empty($user_detail_old->chief_compliant_userdetail->chief_compliant_id->name)){

				 	$selected_chief_complnts[] = $user_detail_old->chief_compliant_userdetail->chief_compliant_id->name;
				 }
				 

				 if(!empty($user_detail_old->chief_compliant_userdetail->symptom_from_tab1))
				 {
 						$old_selected_cc_data = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->symptom_from_tab1), SEC_KEY)) ;

 						$selected_chief_complnts = array_merge($selected_chief_complnts,$old_selected_cc_data );



 				}

 				if(!empty($user_detail_old->chief_compliant_userdetail->sub_chief_compliant_id)){
  						foreach ($user_detail_old->chief_compliant_userdetail->sub_chief_compliant_id as $ky => $ve) {

  							$selected_chief_complnts[] = $ve->name;
  						}
  					}


 				?>

			   <div class="common_conditions_button chief_complaint_button symptomboxdiv">
				<ul class="quick_pick_chiefcom_btn">

				<?php

				$quick_pick_chiefcom = $default_med_chiefcom;

				if(!empty($quick_pick_chiefcom)){

 					$quick_pick_chiefcom = array_keys($quick_pick_chiefcom)	;

					foreach ($chief_compliant_symptoms_tab1 as $key => $value) {

						if(!in_array($value->id, $quick_pick_chiefcom)) continue;



				?>
				 <li class="active">
				  <button type="button" class="btn <?php if(!empty($selected_chief_complnts) && in_array($value->name,$selected_chief_complnts)){ echo 'selected_chief_complaint'; } ?>" chief_cmp_attrid_val="<?=  $value->name ?>" chief_cmp_attrid="<?=  $value->id ?>">
				   <i class="fas fa-plus-circle"></i>
				   <span><?= ucfirst($value->name) ?></span>
				  </button>
				 </li>
				<?php
					}
				}
				?>



				</ul>
			   </div>


<!-- we will display here the old data start ************************** -->
<!-- <div class="tab_form_fild_bg"> -->
		    <div class="TitleHead header-sticky-tit">
			 <h3>additional symptoms</h3>
			</div>
		<!-- </div> -->
<div class="tab_form_fild_bg">


<?php



if(!empty($user_detail_old->chief_compliant_userdetail->sub_chief_compliant_id)){
  foreach ($user_detail_old->chief_compliant_userdetail->sub_chief_compliant_id as $ky => $ve) {


?>



<div class="row  medicalhistoryfld">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row">


<div class="custom-drop">
		<input type="text"  value="<?= $ve->name ?>"  class="form-control    symptom_suggestion" name="chief_compliant_id[]" placeholder="Enter Symptom"/>

	      <ul class="symptom_suggestion_listul custom-drop-li">
			</ul>

		</div>

	     </div>
		</div>

		<div class="col-md-6">
	     <div class="row">

		  <div class="col-md-5 medicalhistoryfldtimes">
		   <div class="crose_year">
		    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   </div>
		  </div>
		 </div>
		</div>
	   </div>


<?php
}
}
?>

<?php
if(!empty($user_detail_old->chief_compliant_userdetail->symptom_from_tab1)){
 $old_symptom_from_tab1 = unserialize(Security::decrypt( base64_decode($user_detail_old->chief_compliant_userdetail->symptom_from_tab1), SEC_KEY)) ;

 foreach ($old_symptom_from_tab1 as $ky => $ve) {


?>



<div class="row  medicalhistoryfld">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row">
	      <!-- <input type="text" class="form-control"  name="medical_history[]" placeholder="Mononucleosis"/>  -->

<div class="custom-drop">
		<input type="text"  value="<?= $ve ?>"  class="form-control    symptom_suggestion" name="chief_compliant_id[]" placeholder="Enter Symptom"/>

	      <ul class="symptom_suggestion_listul custom-drop-li">
			</ul>

		</div>

	     </div>
		</div>

		<div class="col-md-6">
	     <div class="row">

		  <div class="col-md-5 medicalhistoryfldtimes">
		   <div class="crose_year">
		    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   </div>
		  </div>
		 </div>
		</div>
	   </div>


<?php
}
} ?>



<!-- we will display here the old data end ************************** -->


<div class="row medicalhistoryfld">

	   </div>


	<div class="row">
		    <div class="col-md-6">
			 <div class="form-group form_fild_row">

			   <div class="crose_year">
			    <button  type="button"  class="btn medicalhistoryfldadd btn-medium">add a Symptom</button>
			   </div>


			 </div>
			</div>
		</div>
	</div>


<div class="row  symptom_field_display_none_onload">
	    <div class="col-md-6">
		 <div class="form-group form_fild_row">

<div class="custom-drop">
		<input type="text"    class="form-control    <?php echo ($apt_id_data->specialization_id == 3 || $apt_id_data->specialization_id == 4) ? 'symptom_suggestion_ortho' : 'symptom_suggestion';?>" name="chief_compliant_id[]" placeholder="Enter Symptom"/>

	      <ul class="<?php echo ($apt_id_data->specialization_id == 3 || $apt_id_data->specialization_id == 4) ? 'symptom_suggestion_ortho_listul' : 'symptom_suggestion_listul';  ?> custom-drop-li">
			</ul>

		</div>



	     </div>
		</div>

		<div class="col-md-6">
	     <div class="row">

		  <div class="col-md-5 medicalhistoryfldtimes">
		   <div class="crose_year">
		    <button  type="button"  class="btn btn-icon-round"><i class="fas fa-times"></i></button>
		   </div>
		  </div>
		 </div>
		</div>
</div>

<script type="text/javascript">




$(document).ready(function() {

 $(document).on("click","ul.quick_pick_chiefcom_btn button",function() { 
 var step_id = '<?= $step_id;?>';
 // alert(step_id)	
 	// var chief_cmp_attrid =  $(this).attr('chief_cmp_attrid');
 	var chief_cmp_attrid = $('.chief_compliant_select_div input').attr('chief_cmp_attrid');
 	if(!chief_cmp_attrid){
 		 chief_cmp_attrid =  $(this).attr('chief_cmp_attrid');
 	}

 	// if id found then call medication quick pick
 	if(chief_cmp_attrid){
 		if(step_id != 25)
 		{
 			add_medicatin_quickpick(chief_cmp_attrid);
 			
 		}	
 		$(this).addClass('selected_chief_complaint');
 	}


 });


// chief_cmp_attrid_val
 $(document).on("click",".symptomboxdiv button",function() {
 	var  index_id = $(this).attr('chief_cmp_attrid');
 	var flag = true;
 	var symptomflag = true;

var spcializationClass = '<?php echo ($apt_id_data->specialization_id == 3 || $apt_id_data->specialization_id == 4) ? 'symptom_suggestion_ortho' : 'symptom_suggestion'?>';
	// for symtom start
if(symptomflag){ // for main chief compliant , this if block will run only when the main chief compliant field is not empty
 	// var  index = $(this).attr('condval');
 	var  index = $(this).attr('chief_cmp_attrid_val');
// alert(index);
// check that option is pre existing or not start
	var ccav = index;
	var pre_exist_flg = false;
	$('.'+spcializationClass).each(function( index, element ) {
	     if(($(element).val()).indexOf(ccav) != -1) pre_exist_flg = true;
	  });

	if(pre_exist_flg){
		alert(ccav + ' is already chosen before.')
		// $(this).parents('.symptom_suggestion_listul').empty();
     	return;
	}
// check that option is pre existing or not end

//check synonyms exist or not
var pre_exist_synonyms = false;

$.ajax({
				    type: 'POST',
				    url: "<?php echo SITE_URL.'users/synonyms/' ?>",
				    data: {
				        value: ccav
				    },
				    beforeSend: function(xhr) { // Add this line
				        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				    },
				    success: function(res) {

				        var samevalue = '';
				        $.each(JSON.parse(res), function(key, value) {

				            $('.'+spcializationClass).each(function(index, element) {
				            console.log(value + '' + $(element).val().toLowerCase().trim());
				                if (value == $(element).val().toLowerCase().trim()) {

				                    pre_exist_synonyms = true;
				                    samevalue = $(element).val().toLowerCase().trim();
				                    return;
				                }
				            })
				        });
				        if(pre_exist_synonyms)
				        {
				        	alert(samevalue +' is synonyms of ' + ccav +' that already exist');
				        	return;
				        }

				        if(!pre_exist_synonyms){

						 	var flag = true;
							$('input.symptombox').each(function(i, obj) {
							    if($(obj).val()===""){
							    	flag = false;
							    	$(obj).val(index);
							    	$(obj).attr('chief_cmp_attrid', index_id ); // add the id also as input attribute

							    	return false;
							    }
							});
							if(flag){
								$( ".medicalhistoryfldadd" ).trigger( "click" );
								$('input.symptombox').each(function(i, obj) {
								    if($(obj).val()===""){
								    	$(obj).val(index);
								    	$(obj).attr('chief_cmp_attrid', index_id ); // add the id also as input attribute
								    	return false;
								    }
								});

							}
						}
				        //alert(pre_exist_synonyms);
				    },
				    error: function(e) {
				        // window.location = "<?php //echo SITE_URL.'providers/'; ?>"
				    }
				});
}
	// for symptom end
		 });
 	});



// ********************** code for main chief complaint search start (this code will work only for orhthopedics only, the class 'symptom_suggestion_ortho' will be added in orthopedics symptom ) ********************


// ajax search for add symptoms main start


searchRequest = null;
$(document).on("keyup click", ".symptom_suggestion_ortho", function () {


        value = $(this).val();


        if(!value || ($.trim(value) == '')){
        	return;
        }
        value = $.trim(value);

        if(value){
        	value = value.split(',');
        	value = value[value.length - 1] ;
        }

            if (searchRequest != null)
                searchRequest.abort();
            var curele = this;
            searchRequest = $.ajax({
                type: "GET",


                url: "<?php echo SITE_URL; ?>"+"<?php echo $apt_id_data->specialization_id == 3 ? '/users/getsymptomsuggestionortho' : '/users/getsymptomsuggestionorthospine'; // for ortho specialization id is 3 and for ortho spine id is 4 ?>", // this function get the suggestion related to orhtopedics module only
                data: {
                	// 'search_type' : 1, // 1 for searching medical  condition
                    'search_keyword' : value
                },
                dataType: "text",
                success: function(msg){
                	var msg = JSON.parse(msg);
                	var temphtml = '' ;
                	$.each(msg, function(index, element) {
                		// alert(index);
                		// alert(element);
                		temphtml += '<li  symptom_suggestion_attrid ="'+index+'"  symptom_suggestion_attr ="'+element+'" >'+element+'</li>' ;

					});
					// $(curele).next('.symptom_suggestion_listul').html(temphtml);
            $(curele).parents('.custom-drop').find('.symptom_suggestion_ortho_listul').html(temphtml);

                    //we need to check if the value is the same

                }
            });

    });


$(document).on("click", ".symptom_suggestion_ortho_listul li", function () {


    var diag_sugg_atr = $(this).attr('symptom_suggestion_attr');
	var parent_list = $(this).parent('.symptom_suggestion_ortho_listul');
	var current_index = $('.symptom_suggestion_ortho_listul').index(parent_list);

	var pre_exist_flg = false;
	$('.symptom_suggestion_ortho').each(function( index, element ) {
	if(current_index != index && ($(element).val()).indexOf(diag_sugg_atr) != -1) pre_exist_flg = true;
	});

	if(pre_exist_flg){
	alert(diag_sugg_atr + ' is already chosen before.')
	$(this).parents('.symptom_suggestion_ortho_listul').empty();
	$('.symptom_suggestion_ortho').each(function( index, element ) {
		if(current_index == index)
		{
			$(this).val('');
		}
	})
	return;
	}


	if(pre_exist_flg == false)
	{
					 checkSynonyms('symptom_suggestion_ortho' ,diag_sugg_atr, current_index);
	}


	var diag_sugg_atrid = $(this).attr('symptom_suggestion_attrid'); // get also id of the symptom


	// var tmptext = $(this).parents('.symptom_suggestion_listul').prev('.symptom_suggestion');
	var tmptext = $(this).parents('.custom-drop').find('.symptom_suggestion_ortho'); // symptom_suggestion_main class added in case of orthopedics , because in orthopedics the suggestion will be limited
	var ttext = $(tmptext).val();
	$(tmptext).attr('chief_cmp_attrid', diag_sugg_atrid );

	if(ttext){
		if(ttext.charAt(ttext.length-1) == ','){
			$(tmptext).val(ttext+' '+diag_sugg_atr);
		} else {
			ttext = ttext.substr(0, ttext.lastIndexOf(","));
			if(ttext)
				$(tmptext).val(ttext+', '+diag_sugg_atr);
			else
				$(tmptext).val(ttext+' '+diag_sugg_atr);

		}
	}else{
		$(tmptext).val(diag_sugg_atr);
	}

	$(this).parents('.symptom_suggestion_ortho_listul').empty();

	// checking if the field is for chief complaint and not symptom then call quickpicks
	if($(tmptext).attr('name') == "main_chief_compliant_id"){

		add_medicatin_quickpick(diag_sugg_atrid); // call medication quick pick
		$("#main_chief_compliant_id").valid();  // validate single element in jquery validate js
	}

});


//  ajax search for add symptoms end


// ajax search for add symptoms start


searchRequest = null;
$(document).on("keyup click", ".symptom_suggestion", function () {



        value = $(this).val();

        if(!value || ($.trim(value) == '')){
        	return;
        }
        value = $.trim(value);
        if(value){
        	value = value.split(',');
        	value = value[value.length - 1] ;
        }

            if (searchRequest != null)
                searchRequest.abort();
            var curele = this;
            searchRequest = $.ajax({
                type: "GET",
                url: "<?php echo SITE_URL; ?>"+"/users/getsymptomsuggestion",
                data: {
                	// 'search_type' : 1, // 1 for searching medical  condition
                    'search_keyword' : value
                },
                dataType: "text",
                success: function(msg){
                	var msg = JSON.parse(msg);
                	var temphtml = '' ;
                	$.each(msg, function(index, element) {
                		// alert(index);
                		// alert(element);
                		temphtml += '<li  symptom_suggestion_attrid ="'+index+'"  symptom_suggestion_attr ="'+element+'" >'+element+'</li>' ;

					});
					// $(curele).next('.symptom_suggestion_listul').html(temphtml);
            $(curele).parents('.custom-drop').find('.symptom_suggestion_listul').html(temphtml);

                    //we need to check if the value is the same

                }
            });

    });



$(document).on("click", ".symptom_suggestion_listul li", function () {

var diag_sugg_atr = $(this).attr('symptom_suggestion_attr');
var parent_list = $(this).parent('.symptom_suggestion_listul');
var current_index = $('.symptom_suggestion_listul').index(parent_list);



//console.log('gfgfgf');
// $(this).parents('.symptom_suggestion_listul').empty();
// return;
var pre_exist_flg = false;
$('.symptom_suggestion').each(function( index, element ) {
if(current_index != index && ($(element).val()).indexOf(diag_sugg_atr) != -1) pre_exist_flg = true;
});

if(pre_exist_flg){
alert(diag_sugg_atr + ' is already chosen before.')
$(this).parents('.symptom_suggestion_listul').empty();
$('.symptom_suggestion').each(function( index, element ) {
	if(current_index == index)
	{
		$(this).val('');
	}
})
return;
}


if(pre_exist_flg == false)
{
				 checkSynonyms('symptom_suggestion',diag_sugg_atr, current_index);
}



// alert(diag_sugg_atr);

var diag_sugg_atrid = $(this).attr('symptom_suggestion_attrid'); // get also id of the symptom



// var tmptext = $(this).parents('.symptom_suggestion_listul').prev('.symptom_suggestion');
var tmptext = $(this).parents('.custom-drop').find('.symptom_suggestion');
// console.log(tmptext);
var ttext = $(tmptext).val();
$(tmptext).attr('chief_cmp_attrid', diag_sugg_atrid );
if(ttext){
if(ttext.charAt(ttext.length-1) == ','){
$(tmptext).val(ttext+' '+diag_sugg_atr);
} else {
ttext = ttext.substr(0, ttext.lastIndexOf(","));
if(ttext)
$(tmptext).val(ttext+', '+diag_sugg_atr);
else
$(tmptext).val(ttext+' '+diag_sugg_atr);

}
}else{
$(tmptext).val(diag_sugg_atr);
}

$(this).parents('.symptom_suggestion_listul').empty();

// checking if the field is for chief complaint and not symptom then call quickpicks
if($(tmptext).attr('name') == "main_chief_compliant_id"){

add_medicatin_quickpick(diag_sugg_atrid); // call medication quick pick
$("#main_chief_compliant_id").valid(); // validate single element in jquery validate js
}

});


/*
  To check synonyms in cheif complaint table
*/
function checkSynonyms(spcializationClass,inpuvalue,current_index = null)
{
	$.ajax({
				    type: 'POST',
				    url: "<?php echo SITE_URL.'users/synonyms/' ?>",
				    data: {
				        value: inpuvalue
				    },
				    beforeSend: function(xhr) { // Add this line
				        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
				    },
				    success: function(res) {
				        console.log(res);
				        var pre_exist_synonyms = false;
				        var samevalue;
				        $.each(JSON.parse(res), function(key, value) {
				            $('.'+spcializationClass).each(function(index, element) {
				                if (value == $(element).val().toLowerCase().trim()) {
				                    pre_exist_synonyms = true;
				                    samevalue = $(element).val().toLowerCase().trim();
				                    return;
				                }
				            })
				        });
				        if(pre_exist_synonyms)
				        {
				        	alert(samevalue +' is synonyms of ' + inpuvalue +' that already exist');
				        	$('.'+spcializationClass).each(function( index, element ) {
								if(current_index == index)
								{
									$(this).val('');
								}
							})
				        }
				        //alert(pre_exist_synonyms);
				    },
				    error: function(e) {
				        // window.location = "<?php //echo SITE_URL.'providers/'; ?>"
				    }
				})
}


//  ajax search for add symptoms end




</script>


