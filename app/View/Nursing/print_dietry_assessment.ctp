<div id="printButton">
  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
</div>
<body class="print_form" onload="window.print();">
<div class="ht5">&nbsp;</div>
<?php 
	echo $this->element('patient_header') ;
?>
<div class="ht5"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="row" align="center">
   <tr>
    <td width="35%" id=" " valign="middle">&nbsp;Date/Time of Assessment&nbsp;: 
		<?php 
			 $combineDate  = $getDietryAssessment['DietaryAssessment']['date']." ".$getDietryAssessment['DietaryAssessment']['time'];
			 echo $this->DateFormat->formatDate2Local($combineDate,Configure::read('date_format'),true)
		?>
	</td>
  </tr>
</table>
<div class="ht5"></div>
   <!-- two column table start here -->

      
   <table width="100%" border="1" cellspacing="0" cellpadding="0" class="" align="center">
	  <tr>
		<td width="35%"  valign="top" style="padding-top:7px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				<?php  if(!empty($getDietryAssessment['DietaryAssessment']['diet_specification'])){ 	  ?>
			  <tr>
				<td width="11%" height="35" valign="top" align="right" id=" ">Diet Specifications :</td>
				<td width="30%"  valign="top" id="boxSpace1"><?php echo $getDietryAssessment['DietaryAssessment']['diet_specification'];?></td>
			  </tr>
			  <?php }    	 if(!empty($getDietryAssessment['DietaryAssessment']['rt_feed'])){   ?>
			  <tr>
				<td width="11%" height="35" valign="top" align="right" id=" ">RT Feed :</td>
				<td width="30%" valign="top" id="boxSpace1"><?php echo $getDietryAssessment['DietaryAssessment']['rt_feed'];?></td>
			  </tr>   
			   <?php }   if(!empty($getDietryAssessment['DietaryAssessment']['soft'])){  	  ?>                           
			  <tr>
				<td width="11%" height="35" valign="top" align="right" id=" ">Soft :</td>
				<td width="30%" valign="top" id="boxSpace1"><?php echo $getDietryAssessment['DietaryAssessment']['soft'];?></td>
			  </tr>
			   <?php }  	 if(!empty($getDietryAssessment['DietaryAssessment']['bland'])){    ?>
			  <tr>
				<td width="11%" width="120" height="35" valign="top" align="right" id=" ">Bland :</td>
				<td width="30%" width="11%" valign="top" id="boxSpace1"><?php echo $getDietryAssessment['DietaryAssessment']['bland'];?></td>
			  </tr>
			   <?php } if(!empty($getDietryAssessment['DietaryAssessment']['liquid'])){ ?>
			  <tr>
				<td height="35" valign="top"  align="right" id=" ">Liquid :</td>
				<td  width="30%" valign="top" id="boxSpace1"><?php echo $getDietryAssessment['DietaryAssessment']['liquid'];?></td>
			  </tr>
			   <?php } ?>
		  </table>
		</td>
		<td width="50%"  valign="top" style="padding-top:7px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				<?php  if(!empty($getDietryAssessment['DietaryAssessment']['total_calories_required'])){ 	  ?>
				  <tr>
					<td width="40%" height="35" valign="top" id="" align="right">Total Calories Required Per Day :</td>
					<td valign="top" id="boxSpace1"><?php echo $getDietryAssessment['DietaryAssessment']['total_calories_required']." call/d";?></td> 
				  </tr>
				  <?php 
				   }
				  	if(!empty($getDietryAssessment['DietaryAssessment']['proteins'])){
				  ?>
				  <tr>
					<td width="40%" height="35" valign="top" align="right" id="">Proteins :</td>
					<td valign="top" id="boxSpace1"><?php echo $getDietryAssessment['DietaryAssessment']['proteins']." g/d";?></td> 
				  </tr>
				   <?php 
				   }
				  	if(!empty($getDietryAssessment['DietaryAssessment']['carbohydrates'])){
				  ?>
				  <tr>
					<td width="40%" height="35" valign="top" align="right" id="">Carbohydrates :</td>
					<td valign="top" id="boxSpace1"><?php echo $getDietryAssessment['DietaryAssessment']['carbohydrates']." g/d";?></td> 
				  </tr>
				  <?php 
				   }
				  	if(!empty($getDietryAssessment['DietaryAssessment']['lipids'])){
				  ?>
				  <tr>
					<td width="40%" height="35" valign="top" align="right" id="">Lipids :</td>
					<td valign="top" id="boxSpace1"><?php echo $getDietryAssessment['DietaryAssessment']['lipids']." g/d";?></td> 
				  </tr>
				  <?php } ?>
		  </table>					
		</td>
	  </tr>
	</table>
	<!-- two column table end here -->
	<div>&nbsp;</div>
	<div class=""><strong>DIETRY NOTES</strong></div>
	 <div class="ht5"></div>
	<table width="100%" cellpadding="3" cellspacing="0" border="1" class="" id="progressNotes">
		<tr>
			<th width="185" align="left">Date</th>
			<!-- <th width="80">Time</th> -->
			<th width="" align="left">Progress Notes</th>
		</tr>
	<?php
		if(!empty($getDietryAssessment['DietryNote'])){
			foreach($getDietryAssessment['DietryNote'] as $data){?>
			 <tr>
			  <td width=""><?php echo $this->DateFormat->formatDate2Local($data['date'],Configure::read('date_format'))." ".$data['time'];?></td>
			  <td>&nbsp;<?php echo $data['progress_note']; ?></td>                   		  
			</tr>
		   <?php } 
		
		} else {?>
		<tr>
		  <td colspan= "2" align="center">No Record found!</td>                   		  
		</tr>
	 <?php } ?>
   </table>
 </body>
 