<!-- **********   bp reading for clone purpose display none  start ************* -->
<?php 
$reading_timing_arr = array(

	          "" => "Reading timing",
	          1 => 'Before breakfast',
	          2 => 'Before lunch',
	          3 => 'Before dinner',
	          4 => "Bedtime",
	          5 => 'After exercise',
	          6 => 'After a meal'
	        );
?>
<div class="row clone_purpose_bp_reading_field_display_none">
	<div class="col-md-2">
		<input type="text" class="form-control bp_reading_date" name="reading_date[]" placeholder="Enter Reading Date" required="true" />
	</div>
	<div class="col-md-3">
		<select name="reading_timing[]" class="form-control" required="true" style="background: rgb(236, 236, 236);">
						
		<?php if(!empty($reading_timing_arr)){
				foreach ($reading_timing_arr as $reading_key => $reading_value) { ?>


					<option value="<?php echo $reading_key; ?>"><?php echo $reading_value; ?></option>	
				<?php } 
				}
			?>
		</select>
	</div>
				
	<div class="col-md-3">															
			<input type="number" pattern="[0-9]*" inputmode="numeric" name="top_number[]" class="form-control" placeholder="Enter Top Number" required="true"/>
	</div>
	<div class="col-md-3">
			<input type="number" pattern="[0-9]*" inputmode="numeric" name="bottom_number[]" class="form-control" placeholder="Enter Bottom Number" required="true"/>
	</div>																
	<div class="col-md-1">
     	<div class="row">
	  		<div class=" currentbpreadingfldtimes">
	   			<div class="crose_year">
	    			<button  type="button" class="btn btn-icon-round"><i class="fas fa-times"></i></button>
	   			</div>
	  		</div>
	 	</div>
	</div>
</div>
<!-- ************   bp reading field for clone purpose display none end *************** -->