<table width="100%" border="0" cellspacing="0" cellpadding="0" id="row" align="center">
   <tr>
    <td width="7%">&nbsp;Date of Previous Assessment&nbsp;<span id="second_date"><?php echo $this->Form->input('datePrevious', array('type'=>'text','id'=>'previousDate','label'=> false, 'div' => false, 'error' => false,'style'=>'width:150px;','readonly'=>'readonly','value'=>$date,'onchange'=> $this->Js->request(array('action' => 'dietaryAssessment','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#formTable', 'data' => '{date:$("#previousDate").val(),patient_id:'.$patient_id.'}', 'dataExpression' => true, 'div'=>false))));?></span></td>

	<td width="1%" height="35" valign="middle" align="right" ><span id="dateLabel">Time of Assessment:&nbsp;</span></td>
	<td width="3%" align="left" valign="middle">
		<span id="first_date">&nbsp;<?php  
			echo $this->DateFormat->formatDate2Local($getDietryAssessment['DietaryAssessment']['time'],Configure::read('date_format'),true) ;
			?>
		</span>
	</td>
	
  </tr>
</table>
<p class="ht5"></p>
   <!-- two column table start here -->

      
   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" align="center">
	  <tr>
		<td width="35%" align="left" valign="top" style="padding-top:7px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
			  <tr>
				<td width="15%" height="35" valign="middle" align="right">Diet Specifications :</td>
				<td width="30%" align="left" ><?php echo $getDietryAssessment['DietaryAssessment']['diet_specification'];?></td>
			  </tr>
			  <tr>
				<td height="35" valign="middle" align="right">RT Feed :</td>
				<td align="left" ><?php echo $getDietryAssessment['DietaryAssessment']['rt_feed'];?></td>
			  </tr>                              
			  <tr>
				<td height="35" valign="middle" align="right">Soft :</td>
				<td align="left"><?php echo $getDietryAssessment['DietaryAssessment']['soft'];?></td>
			  </tr>
			  <tr>
				<td width="120" height="35" valign="middle" align="right">Bland :</td>
				<td align="left" ><?php echo $getDietryAssessment['DietaryAssessment']['bland'];?></td>
			  </tr>
			  <tr>
				<td height="35" valign="middle" align="right" id="boxSpace2">Liquid :</td>
				<td align="left" ><?php echo $getDietryAssessment['DietaryAssessment']['liquid'];?></td>
			  </tr>
		  </table>
		</td>
			<td width="50%" align="left" valign="top" style="padding-top:7px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
					  <tr>
						<td width="50%" height="35" valign="middle" id="boxSpace1" align="right">Total Calories Required Per Day :</td>
						<td align="left"><?php echo $getDietryAssessment['DietaryAssessment']['total_calories_required'];?></td>
						<td width="35%">call/d</td>
					  </tr>
					  <tr>
						<td height="35" valign="middle" align="right" id="boxSpace1">Proteins :</td>
						<td align="left"><?php echo $getDietryAssessment['DietaryAssessment']['proteins'];?></td>
						<td>g/d</td>
					  </tr>
					  <tr>
						<td height="35" valign="middle" align="right" id="boxSpace1">Carbohydrates :</td>
						<td align="left"><?php echo $getDietryAssessment['DietaryAssessment']['carbohydrates'];?></td>
						<td> g/d</td>
					  </tr>
					  <tr>
						<td height="35" valign="middle" align="right" id="boxSpace1">Lipids :</td>
						<td align="left"><?php echo $getDietryAssessment['DietaryAssessment']['lipids'];?></td>
						<td>g/d</td>
					  </tr>
			  </table>					
			</td>
	  </tr>
	</table>
	<!-- two column table end here -->
	<div>&nbsp;</div>
	<div class="tdLabel2"><strong>DIETRY NOTES</strong></div>
	 <p class="ht5"></p>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="progressNotes">
		<tr>
			<th width="185">Date</th>
			<!-- <th width="80">Time</th> -->
			<th width="">Progress Notes</th>
		</tr>
	<?php
		if(!empty($getDietryAssessment['DietryNote'])){
		foreach($getDietryAssessment['DietryNote'] as $data){?>
		 <tr>
		  <td width=""><?php echo $this->DateFormat->formatDate2Local($data['date'],Configure::read('date_format'),true);?></td>
		  <td>&nbsp;<?php echo $data['progress_note']; ?></td>                   		  
		</tr>
	   <?php } } else {?>
		<tr>
		  <td colspan= "2" align="center">No Record found!</td>                   		  
		</tr>
	 <?php } ?>
   </table>
   <div>&nbsp;</div>
 <div class="btns" style="">		  
			<?php if(!empty($getDietryAssessment['DietaryAssessment'])){
				echo $this->Html->link(__('Print'),'#', array('id'=>'print','escape' => false,'class'=>'blueBtn','style'=>'padding:5px;12px;','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_dietry_assessment',$patient_id,'?'=>array('date'=>$date)))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
									
			} ?>
		   <?php echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'dietaryAssessment/',$patient_id), array('escape' => false,'class'=>'grayBtn'));?>
		 
 </div>

 <script>
  var daysToEnable = <?php echo json_encode($arrayDate); ?>;	
 $(function () {	
	//alert(daysToEnable);
            $('#previousDate').datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				maxDate: new Date(),
                beforeShowDay: enableSpecificDates,
               dateFormat:'<?php echo $this->General->GeneralDate();?>',
            });
 
	//Function created to collect previous dates only. Return true if date found and false to hide date not in table
            function enableSpecificDates(date) {
                var month = date.getMonth();
                var day = date.getDate();
                var year = date.getFullYear();
                for (i = 0; i < daysToEnable.length; i++) {
                    if ($.inArray((month + 1) + '-' + day + '-' + year, daysToEnable) != -1) {
                        return [true];
                    }
                }
                return [false];
            }
        });
 </script>