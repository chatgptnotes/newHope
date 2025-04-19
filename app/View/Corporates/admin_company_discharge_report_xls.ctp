<?php
$website= $this->Session->read('website.instance');

	//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
	//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	//header ("Content-Disposition: attachment; filename=\"TOR_report_".date('d-m-Y').".xls");
	header ("Content-Disposition: attachment; filename=\"comany Discharge Report ".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
	header ("Content-Description: Company-Discharge Report" );
	ob_clean();
	flush();
?>


<table width="100%" cellpadding="0" cellspacing="1" border="1"
	class="tabularForm top-header">
	 <tr class='row_title'> 
		   <td colspan="11" width="100%" height='30px' align='center' valign='middle'><h2><?php echo __('Company Discharge Report'); ?></h2></td>
	 </tr>
	  
	<tr>
	<thead>
		<th width="5px" valign="top" align="center" style="text-align:center;">#</th>
		<th width="60	" valign="top" align="center"
			style="text-align: center; min-width: 60px;">DISCHARGE DATE/</br>
			<?php 
		    if($website == 'kanpur')
              {?>DISCHARGED BY
              <?php }?></th>
		<th width="70" valign="top" align="center"
			style="text-align: center; min-width: 70px;">PATIENT NAME</th>
	    <th width="72px" valign="top" align="center"
			style="text-align: center;">PAYER</th>	
		<th width="50" valign="top" align="center"
			style="text-align: center; min-width: 50px;">BILL AMOUNT</th>
<!-- 	<th width="50" valign="top" align="center"
			style="text-align: center; min-width: 50px;">AMOUNT <br>SANCTIONED</th> -->
		<?php 
		
		if($website == 'kanpur')
        {?>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">LAB</th>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">RADIOLOGY</th>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">PHARMACY</th>
		<!-- <th width="82px;" valign="top" align="center" style="text-align:center; ">IMPLANT</th> -->
		<?php } else {?>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">LAB<br>PHARMACY<br>IMPLANT<br>INSTRUMENTS</th>
		<?php }?>
		<th width="55" valign="top" align="center"
			style="text-align: center; min-width: 55px;">HOSPITAL <br>REVENUE</th>
		<th width="50" valign="top" align="center"
			style="text-align: center; min-width: 50px;">REFFERED BY</th>
		<th width="50" valign="top" align="center"
			style="text-align: center; min-width: 50px;">BILL <br>SUBMISSION <br>DATE</th>
<!-- 	<th width="50" valign="top" align="center"
			style="text-align: center; min-width: 50px;">AMOUNT <br>RECIEVED</th> -->
		<th width="60" valign="top" align="center"
			style="text-align: center; min-width: 60px;">STATUS</th>
		<th width="80" valign="top" align="center"
			style="text-align: center; min-width: 80px;">REMARKS</th>

		<!-- <th width="25" valign="top" align="center" style="text-align:center; min-width:25px;">PRINT</th> -->

	</thead>
	</tr>
</table>




<table width="100%" cellpadding="0" cellspacing="1" border="1"
	class="tabularForm">
	<?php 
	$patient_id=$result[Patient][id];
	$i=0;
	foreach($results as $result)
     {
     	$bill_id = $result['FinalBilling']['id'];
     	$i++;
     	 ?>
	<TR>
	
		<td width="8px" valign="top" align="center" style="text-align:center;">
    			<?php 
    				echo $i;
    			?>
    	</td>
		<td width="40" align="center">
			<?php echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format'),true);?> </br>
			<?php if($website == 'kanpur')
                   { 	echo $userName;
	     	        }?> 
		</td>
		<td width="70" align="center"><?php echo $result['Patient']['lookup_name']; ?>
		</td>
		<td width="50px" align="center">
			<?php echo $result['TariffStandard']['name']; ?>
		</td>
		<td width="50" align="right" min-width: 50px;><?php 
		echo $this->Number->currency(ceil($bill_amt=$result['FinalBilling']['total_amount']));?>
		</td>

<!-- 	<td width="50" align="center"><?php  

		foreach($advancePayment as $pay)
		{
			if($result['Patient']['id'] == $pay['Billing']['patient_id'])
			{
				$pay_amount = $pay_amount+$pay['Billing']['amount'];
			}
		}
		echo $this->Number->currency(ceil($pay_amount));
		unset($pay_amount);?>
		</td> -->

		<?php 
		$website= $this->Session->read('website.instance');
		if($website == 'kanpur')
        {?>	
        <td width="97px;"align="right"><?php echo $this->Number->currency(ceil($lab=$result['LaboratoryTestOrder']['total'])); ?></td>
        <td width="97px;"align="right"><?php echo $this->Number->currency(ceil($rad=$result['RadiologyTestOrder']['total'])); ?></td>
        <td width="97px;"align="right"><?php echo $this->Number->currency(ceil($pharm=$result['PharmacySalesBill']['total']));?></td>
		<!-- <td></td> -->
		<?php }else{?>	
		<td width="97px;"align="right"><?php echo $this->Number->currency(ceil($lab=$result['LaboratoryTestOrder']['total']));
		echo "/"."<br>";
		echo $this->Number->currency(ceil($pharm=$result['PharmacySalesBill']['total']));
		echo "/"."<br>";
		 //echo$this->Number->currency(ceil($lab=$result['LabTestPayment']['total_amount']+ $result['RadiologyTestPayment']['total_amount'])); 
		?>
		</td>
		<?php }?>
		
		<td width="74px;" align="right"><?php echo $this->Number->currency(ceil($bill_amt-($pharm+$lab+$rad)))?> </td>

		<td width="75px" align="center">
			<?php echo $result['Initial']['name']." ".$result[0]['name']; ?> </td>	
		</td>
		<td width="50" align="center">
		<?php 
			
				echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
			
		?>
	
<!-- 	<td width="50" align="center">
			<?php 
				echo $result['FinalBilling']['amount_paid']; 
			?>
		</td> -->
		
		<td width="60" align="center"
			style="text-align: center; min-width: 77px;">
			 <?php
			 if(isset($result['Patient']['discharge_status_company']))
			 {
			 	echo $result['Patient']['discharge_status_company'];
			 }
			 else
			 {
			 	echo "";
			 }
			 	
			?>
		</td>
		<td width="80`" align="center"min-width: 80px;>
		<?php 
			
	 			if(isset($result['Patient']['remark']))
	 			{
					echo $result['Patient']['remark'];
				}
				else
				{
	 				echo "";
	 			}
	 	?>
		</td>

		<!-- <td width="25"  align="center"  min-width:25px;"><?php
		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Invoice')),'#',
						     		array('escape' => false,'onclick'=>"var openWin = window.open('".html_entity_decode($this->Html->url(array('action'=>'printReceipt',
						     		$result['Patient']['id'],$mode),true))."',
						           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
	?>	</td>-->
	</TR>
	
	<?php } ?>

</table>


