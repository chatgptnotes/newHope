<div id="printButton">
  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn',));?>
</div>
<body class="print_form" >
<div class="ht5">&nbsp;</div>
<?php 
	//echo $this->element('patient_header') ;
?>
<div class="ht5"></div>

<!--<table width="100%" border="0" cellspacing="0" cellpadding="0" id="row" align="center">
<tr><td>&nbsp;</td></tr>
   <tr>
    <td width="35%" id=" " valign="middle" valign="top">&nbsp;Card Title&nbsp;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[Preferencecard][card_title]."</strong>";
		?>
	</td>
	 <td width="35%" id=" " valign="top">&nbsp;Procedure Name&nbsp;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[Surgery][name]."</strong>";
		?>
	</td>
  </tr>
   <tr>
    <td width="35%" id=" " valign="top">&nbsp;Primary care provider&nbsp;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[User][first_name]." ".$getprefcard[User][last_name]."</strong>";
		?>
	</td>
	<td width="35%" id=" " valign="top">&nbsp;Equipment Name&nbsp;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[Preferencecard][equipment_name]."</strong>";
		?>
	</td>

  </tr>
  
   <tr>

   <td width="35%" id=" " valign="top">&nbsp;Medications&nbsp;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[Preferencecard][medications]."</strong>";
		?>
	</td>
	<td width="35%" id=" " valign="top">&nbsp;Dressing&nbsp;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[Preferencecard][dressing]."</strong>";
		?>
	</td>
    
  </tr>
   <tr>

   <td width="35%" id=" " valign="top">&nbsp;Position;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[Preferencecard][position]."</strong>";
		?>
	</td>
	<td width="35%" id=" " valign="top">&nbsp;Notes&nbsp;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[Preferencecard][notes]."</strong>";
		?>
	</td>
    
  </tr>
</table>  -->
<div class="ht5"></div>
   
	<div>&nbsp;</div>
	<div class=""><strong>From:Sender Doctor Name</strong></div>
	 <div class="ht5"></div>
	<table width="100%" cellpadding="3" cellspacing="0" border="1" class="" id="progressNotes">
		
	<?php
		//if(count($instrument_item) > 0){
		//$cnt_i=0;
			//foreach($instrument_item as $instrumentdata){
			
			//$cnt_i++;
			?>
			 <tr>
			  <td width="100"><?php echo "Speciality"?></td>
			   <td width="185"><?php echo "Family Practice"?></td>
			                 		  
			</tr>
			<tr>
			  <td width="100"><?php echo "Phone"?></td>
			   <td width="185"><?php echo "0144-43217"?></td>
			                   		  
			</tr>
			<tr>
			  <td width="100"><?php echo "Fax"?></td>
			   <td width="185"><?php echo "(2)555-5555"?></td>
			                   		  
			</tr>
		   <?php //} 
		
		//} else {?>
		
	 <?php //} ?>
   </table>

   <div>&nbsp;</div>
	<div class=""><strong>To:Receiving Doctor Name</strong></div>
	 <div class="ht5"></div>
	<table width="100%" cellpadding="3" cellspacing="0" border="1" class="" id="progressNotes">
		 <tr>
			  <td width="100"><?php echo "Speciality"?></td>
			   <td width="185"><?php echo "Family Practice"?></td>
			                 		  
			</tr>
			<tr>
			  <td width="100"><?php echo "Phone"?></td>
			   <td width="185"><?php echo "0144-43217"?></td>
			                   		  
			</tr>
			<tr>
			  <td width="100"><?php echo "Fax"?></td>
			   <td width="185"><?php echo "(2)555-5555"?></td>
			                   		  
			</tr>
	
   </table>

   <div>&nbsp;</div>
	<div class=""><strong>Patient: Patient Name</strong></div>
	 <div class="ht5"></div>
	<table width="100%" cellpadding="3" cellspacing="0" border="1" class="" id="progressNotes">
		<tr>
			  <td width="100"><?php echo "Pages" ?></td>
			   <td width="185"><?php echo "Two pages including this cover shit" ?></td>
			                 		  
			</tr>
			<tr>
			  <td width="100"><?php echo "Date"?></td>
			   <td width="185"><?php echo "21/12/2013"?></td>
			                   		  
			</tr>
			
   </table>
   <div class="inner_title">
<h3><?php echo __('Manage Preference Card', true); ?></h3>
<span>
<?php
echo $this->Html->link(__('Send Fax', true),array('action' => 'add',$patient_id ), array('escape' => false,'class'=>'blueBtn'));
 echo $this->Html->link(__('Back'),'#',array('escape' => false,'class'=>"blueBtn",'onclick'=>"var openWin = window.close('".$this->Html->url(array('action'=>'referral_preview',$patient_id))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
 ?>
</span>
</div>
 </body>
 