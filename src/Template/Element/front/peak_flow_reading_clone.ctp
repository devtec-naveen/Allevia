<?php 
$peakflow_reading_timing_arr = array(

	          "" => "Reading timing",
	          'morning' => 'Morning',
	          'afternoon' => 'Afternoon'
	        );
?>
<div class="row clone_purpose_peak_flow_reading_field_display_none">
	<div class="col-md-4">
		<input type="text" class="form-control peak_flow_reading_date" name="reading_date[]" placeholder="Enter Reading Date" required="true" />
	</div>
	<div class="col-md-4">
		<select name="reading_timing[]" class="form-control" required="true" style="background: rgb(236, 236, 236);">
						
		<?php if(!empty($peakflow_reading_timing_arr)){
				foreach ($peakflow_reading_timing_arr as $reading_key => $reading_value) { ?>


					<option value="<?php echo $reading_key; ?>"><?php echo $reading_value; ?></option>	
				<?php } 
				}
			?>
		</select>
	</div>
				
	<div class="col-md-3">															
			<input type="number" pattern="[0-9]*" inputmode="numeric" name="reading_val[]" class="form-control" placeholder="Enter Reading" required="true"/>
	</div>															
	<div class="col-md-1">
     	<div class="row">
	  		<div class=" currentpeakflowreadingfldtimes">
	   			<div class="crose_year">
	    			<button  type="button" class="btn btn-icon-round"><i class="fas fa-times"></i></button>
	   			</div>
	  		</div>
	 	</div>
	</div>
</div>