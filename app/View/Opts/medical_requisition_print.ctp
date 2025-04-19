<?php
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');
  if(!isset($print)){

?>
<div class="inner_title">
<h3> &nbsp; <?php echo __('Medical Requisition -View', true); ?></h3>
</div>
<?php
}else{
?>

<div style="width:100%;text-align:right;cursor:pointer;" id="printButton">
<input type="button" value="Print" class="blueBtn" onclick="$('.blueBtn').hide();window.print();"/>&nbsp;&nbsp;<input name="Close" type="button" value="Close" class="blueBtn" onclick="window.close();"/>

</div>
<?php
}
?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
  <table>
   <!--<tr>
   	<td>Patient Centric Specilty: </td>
    <TD >
    	<strong> <?php echo $data['PatientCentricDepartment']['name'];?> </strong>
    </TD>
	</tr>-->
	 <?php
	//if(isset($data['MedicalRequisition']['sub_department_id']) || trim($data['MedicalRequisition']['sub_department_id'])!==''){
	//	echo " <tr> <td>Sub Specilty: </td> <TD ><strong>".$data['MedicalRequisition']['subdepartment']['name']."</strong> </TD> </tr>";
	//}

	 ?>

<td>Requisition For:</td>
<td>
<?php
			echo ucfirst($data['MedicalRequisition']['for']);
		?>

           (<?php
			echo ucfirst($data['MedicalRequisition']['requisition_for']);
		?>)

</td>
</table>
  <div class="clr ht5"></div>
<div class="clr ht5"></div>
<table   cellspacing="1" cellpadding="0" border="0" id="item-row" class="tabularForm">

<tr class="row_title">

  <th align="center" style="text-align:center;"><?php echo __('Sr.', true); ?></th>
    <th align="center" style="text-align:center;" width="20%"><?php echo   __('Item Name') ; ?> </th>
	<th align="center" style="text-align:center;" width="20%"> <?php echo  __('Date') ; ?> </th>
	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('Quantity') ; ?>  </th>
	<th align="center" style="text-align:center;" width="20%"> <?php echo  __('Recieved Date') ; ?></th>
   <th align="center" style="text-align:center;" width="2%"> <?php echo  __('Recieved Quantity') ; ?></th>
 	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('Used Quantity') ; ?></th>
	<th align="center" style="text-align:center;" width="20%"> <?php echo  __('Return Date') ; ?></th>
	<th align="center" style="text-align:center;" width="2%"> <?php echo  __('Return Quantity') ;?></th>

 </tr>
 <?php
    $cnt =0;
	 if(count($data['MedicalRequisitionDetail']) > 0) {
  	foreach($data['MedicalRequisitionDetail'] as $datum){
	$cnt++;
 ?>
	 <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
	 	<td align="center"><?php echo $cnt;?></td>

		<td align="center">
			 <?php
			 echo $datum['item']['name'];
			 ?>
 		</td>
	  	<td align="center">
			 <?php
			echo $this->DateFormat->formatDate2local($datum['date'],Configure::read('date_format'),false);
			 ?>
 		</td>
		 	<td align="center">
			 <?php
			echo  $datum['request_quantity'] ;
			 ?>
 		</td>

			<td align="center">
			 <?php
			echo $this->DateFormat->formatDate2local($datum['recieved_date'],Configure::read('date_format'),false);
			 ?>
 		</td>

				 	<td align="center">
			 <?php
			echo  $datum['recieved_quantity'] ;
			 ?>
 		</td>
		 	<td align="center">
			 <?php
			echo  $datum['used_quantity'] ;
			 ?>
 		</td>
				<td align="center">
			 <?php
			echo $this->DateFormat->formatDate2local($datum['return_date'],Configure::read('date_format'),false);
			 ?>
 		</td>


			</td>
		 	<td align="center">
			 <?php
			echo  $datum['return_quantity'] ;
			 ?>
 		</td>
	</tr>
<?php
}
}else{?>
	<tr><td colspan="4" align="center"> No Data found.</td></tr>
	<?php
}
?>
</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php
 if(!isset($print)){

?>
  <div class="btns">

 <?php  echo $this->Html->link(__('Back'), array('action' => 'medical_requisition_list'), array('escape' => false,'class'=>"blueBtn"));?>                     </div>
 <?php
 } ?>