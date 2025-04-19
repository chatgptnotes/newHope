<div id="printButton">
  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
</div>
<body class="print_form" onload="window.print();">
<div class="ht5">&nbsp;</div>
<?php 
	//echo $this->element('patient_header') ;
?>
<div class="ht5"></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="row" align="center">
<tr><td>&nbsp;</td></tr>
   <tr>
    <td width="35%" id=" " valign="middle" valign="top">&nbsp;Card Title&nbsp;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[PreferencecardRad][card_title]."</strong>";
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
			 
			 echo "<strong>".$getprefcard[PreferencecardRad][equipment_name]."</strong>";
		?>
	</td>

  </tr>
  
   <tr>

   <td width="35%" id=" " valign="top">&nbsp;Medications&nbsp;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[PreferencecardRad][medications]."</strong>";
		?>
	</td>
	<td width="35%" id=" " valign="top">&nbsp;Dressing&nbsp;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[PreferencecardRad][dressing]."</strong>";
		?>
	</td>
    
  </tr>
   <tr>

   <td width="35%" id=" " valign="top">&nbsp;Position;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[PreferencecardRad][position]."</strong>";
		?>
	</td>
	<td width="35%" id=" " valign="top">&nbsp;Notes&nbsp;: 
		<?php 
			 
			 echo "<strong>".$getprefcard[PreferencecardRad][notes]."</strong>";
		?>
	</td>
    
  </tr>
</table>
<div class="ht5"></div>
   
	<div>&nbsp;</div>
	<div class=""><strong>Instrument set name</strong></div>
	 <div class="ht5"></div>
	<table width="100%" cellpadding="3" cellspacing="0" border="1" class="" id="progressNotes">
		<tr>
			<th width="185" align="left">Sr. No.</th>
			<!-- <th width="80">Time</th> -->
			<th width="" align="left">Instrument Name</th>
		</tr>
	<?php
		if(count($instrument_item) > 0){
		$cnt_i=0;
			foreach($instrument_item as $instrumentdata){
			
			$cnt_i++;
			?>
			 <tr>
			  <td width="185"><?php echo $cnt_i?></td>
			  <td>&nbsp;<?php echo $instrumentdata['PreferencecardRadInstrumentitem']['item_name']; ?></td>                   		  
			</tr>
		   <?php } 
		
		} else {?>
		<tr>
		  <td colspan= "2" align="center">No Record found!</td>                   		  
		</tr>
	 <?php } ?>
   </table>

   <div>&nbsp;</div>
	<div class=""><strong>SPD Items</strong></div>
	 <div class="ht5"></div>
	<table width="100%" cellpadding="3" cellspacing="0" border="1" class="" id="progressNotes">
		<tr>
			<th width="185" align="left">Sr. No.</th>
			<th width="400" align="left">Item Name</th>
			<!-- <th width="80">Time</th> -->
			<th width="" align="left">Quantity</th>
		</tr>
	<?php
		if(count($spd_item) > 0){
		$cnt_spd=0;
			foreach($spd_item as $spddata){
			$cnt_spd++;
			?>
			 <tr>
			  <td width=""><?php echo $cnt_spd?></td>
			  <td width=""><?php echo $spddata['PreferencecardRadSpditem']['item_name']; ?></td>
			  <td>&nbsp;<?php echo $spddata['PreferencecardRadSpditem']['quantity']; ?></td>                   		  
			</tr>
		   <?php } 
		
		} else {?>
		<tr>
		  <td colspan= "3" align="center">No Record found!</td>                   		  
		</tr>
	 <?php } ?>
   </table>

   <div>&nbsp;</div>
	<div class=""><strong>OR Items</strong></div>
	 <div class="ht5"></div>
	<table width="100%" cellpadding="3" cellspacing="0" border="1" class="" id="progressNotes">
		<tr>
			<th width="185" align="left">Sr. No.</th>
			<th width="400" align="left">Item Name</th>
			<!-- <th width="80">Time</th> -->
			<th width="" align="left">Quantity</th>
		</tr>
	<?php
		if(count($or_item) > 0){
		$cnt_or=0;
			foreach($or_item as $ordata){
			$cnt_or++;
			?>
			  <tr>
			  <td width=""><?php echo $cnt_or?></td>
			  <td width=""><?php echo $ordata['PreferencecardRaditem']['item_name']; ?></td>
			  <td>&nbsp;<?php echo $ordata['PreferencecardRaditem']['quantity']; ?></td>                   		  
			</tr>
		   <?php } 
		
		} else {?>
		<tr>
		  <td colspan= "3" align="center">No Record found!</td>                   		  
		</tr>
	 <?php } ?>
   </table>
 </body>
 