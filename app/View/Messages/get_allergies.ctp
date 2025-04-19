<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Allergy List', true); ?>
	</h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
			</div></td>
	</tr>
</table>
<?php } ?>
 
<p class="ht5"></p>

<?php 
           	echo $this->element('patient_information');
           ?>
         
         
	<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" >
	
	<tr>
		
		<td>
			<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
				<tr class="row_title">
					<td class="table_cell"><strong>Sr. #</strong></td>
					<td class="table_cell"><strong>Allergy Id</strong></td>
					<td class="table_cell"><strong>Allergy Name</strong></td>
					
				</tr>
				<?php
				$count=0; 
				$toggle =0;

				$CountOfPrescriptionRecord=count($setAllergies);
	 							for($counter=0;$counter < $CountOfPrescriptionRecord;$counter++){
							
						if($toggle == 0) {
							echo "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							echo "<tr>";
							$toggle = 0;
						}
				$count++;	 ?>
				
			<tr class="row_gray">
					<td class="row_format">&nbsp;<?php echo $counter+1; ?>
					<td class="row_format">&nbsp;<?php echo $setAllergies[$counter][0]; ?>
					<td class="row_format">&nbsp;<?php echo $setAllergies[$counter][1];  ?></td>
				
				</tr>
				
				<tr>
					<td class="row_format" colspan="3" style="color:red; display: none; padding-left: 30px"  id='cmnt_presc<?php echo $count; ?>'><span></span></td>
				</tr>
			<?php } ?>
			</table>


</table>
<br></br>
<script>
	jQuery(document).ready(function() {

		$('#allergies').click(function() {

			parent.$.fancybox.close();

		});

	});


	 $(document).ready(function(){
   	  $("#comment").click(function(){
           var cnt_comm=0;
           $( "td span" ).each(function(){
       		  cnt_comm++;
   			  $("#cmnt_drug"+cnt_comm).toggle();
	       		});
       	    
   	  });
   	});

	 $(document).ready(function(){
	   	  $("#comment").click(function(){
	           var cnt_comm=0;
	           $( "td span" ).each(function(){
	       		  cnt_comm++;
	   			  $("#cmnt_food"+cnt_comm).toggle();
		       		});
	       	    
	   	  });
	   	});


	 $(document).ready(function(){
	   	  $("#comment").click(function(){
	           var cnt_comm=0;
	           $( "td span" ).each(function(){
	       		  cnt_comm++;
	   			  $("#cmnt_env"+cnt_comm).toggle();
		       		});
	       	    
	   	  });
	   	});
</script>
