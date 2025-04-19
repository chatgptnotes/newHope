<?php $website= $this->Session->read('website.instance');?>
<?php header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Discharge_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description:Raymond_Report" );
ob_clean();
flush();
?>


<div class="inner_title" align="center">
	<h3 style="float: left;">Discharge Report-Private</h3>

</div>


<table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm top-header">
<tr>
<thead>
		<th width="66px;" valign="top" align="center" style="text-align:center; ">DISCHARGE DATE</br>
			<?php 
		    if($website == 'kanpur')
              {?>DISCHARGED BY
              <?php }?></th>
		<th width="70px;" valign="top" align="center" style="text-align:center; ">PATIENT NAME</th>
		<th width="60px;" valign="top" align="center" style="text-align:center; ">BILL AMOUNT</th>
		<th width="60px;" valign="top" align="center" style="text-align:center; ">PATIENT PAID</th>
		<?php 
		$website= $this->Session->read('website.instance');
		if($website == 'kanpur')
        {?>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">LAB</th>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">RADIOLOGY</th>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">PHARMACY</th>
		<!-- <th width="82px;" valign="top" align="center" style="text-align:center; ">IMPLANT</th> -->
		<?php } else {?>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">LAB<br>PHARMACY<br>IMPLANT<br>INSTRUMENTS</th>
		<?php }?>
		<th width="62px;" valign="top" align="center" style="text-align:center; ">HOSPITAL REVENUE</th>
		<th width="66px;" valign="top" align="center" style="text-align:center; ">REFFERED BY</th>
		<th width="140px;" valign="top" align="center" style="text-align:center; ">REMARKS</th>
		<!-- <th width="25" valign="top" align="center" style="text-align:center; min-width:25px;">PRINT</th> -->
		
</thead>
</tr>
</table>







<table width="100%" cellpadding="0" cellspacing="1" border="1"
	class="tabularForm">
	<?php 
	$i=0;
	foreach($results as $key=>$result)
     { ?>
	<TR>
		<td width="78px;" align="center"><?php echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')).'</br>'?> 
			<?php if($website == 'kanpur')
                   { 	echo $userName;
	     	        }?> 
		</td>
		<td width="84px;" align="center"><?php echo $result['Patient']['lookup_name']; ?></td>
		<td width="72px;" align="right"><?php 
		        echo $this->Number->currency(ceil($bill_amt=$result['FinalBilling']['total_amount']));?></td>
		        
	    <td width="73px;" align="center"><?php  
	    
// 	    $this->Html->link($this->Html->image('icons/active.png'),array('controller'=>'Billings','action'=>'advancePayment',$result['Patient']['id'],'admin'=>false),
// 	    		array('escape' => false));
// 	    $pay_amount = 0;
// 	    foreach($advancePayment as $pay)
// 	    {
// 	    	if($result['Patient']['id'] == $pay['Billing']['patient_id'])
// 	    	{
// 	    		$pay_amount = $pay_amount+$pay['Billing']['amount'];
	    		
// 	    	}
// 	    }
// 	    echo $this->Number->currency(ceil($pay_amount));

	    echo $this->Number->currency(ceil($result['FinalBilling']['amount_paid']));
?>
	    </td>
				
		<?php 
		
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
		
		<td width="79px;" align="center"><?php echo $result['Initial']['name']." ".$result[0]['name'];?></td>
	
		<td width="165px;"align="center">
		<table>
		     <tr>
		     	     
		        <td>
			<?php echo $result['Patient']['remark'];?>
				</td></tr>	
		</table></td>
		
		
		<!-- <td width="25"  align="center"  min-width:25px;"><?php
		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Invoice')),'#',
						     		array('escape' => false,'onclick'=>"var openWin = window.open('".html_entity_decode($this->Html->url(array('action'=>'printReceipt',
						     		$result['Patient']['id'],$mode),true))."',
						           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
	?>	</td> -->

	</TR>
	<?php } ?>
	
</table>





