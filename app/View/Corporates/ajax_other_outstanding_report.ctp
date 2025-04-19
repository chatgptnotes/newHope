<?php //ajax page for  ?>

<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm labTable resizable sticky" id="item-row"
	style="top:0px;  overflow: scroll;"> 
		<thead>
	    <th width="2%"  align="center" style="text-align:center;">No.</th>
		<th width="10%"  align="center" style="text-align:center;">Name Of Patient</th>
		<th width="10%"  align="center" style="text-align: center;">Patient ID</th>
		<th width="10%"  align="center" style="text-align: center;">MRN ID</th>
		<th width="10%"  align="center" style="text-align: center;">Date of Addmision</th> 
		<th width="10%"  align="center" style="text-align: center;">Date of Discharge</th>
		<th width="10%"  align="center" style="text-align: center;">Total Amount</th> 
		<th width="10%"  align="center" style="text-align: center;">Amount Paid By Patient</th>
		<th width="10%"  align="center" style="text-align: center;">Hospital Invoice Amount</th> 
		<th width="10%"  align="center" style="text-align: center;">Corporate Advance Received</th>
		<th width="10%"  align="center" style="text-align: center;">TDS </th>
		<th width="10%"  align="center" style="text-align: center;">Other Deduction</th>
		<th width="10%"  align="center" style="text-align: center;">Balance</th> 
		 
	<!-- 	<th width="10%"  align="center" style="text-align: center;" >Bill due<br /> Date</th> -->
		<th width="20%" valign="center" align="center" style="text-align: center; min-width: 100px;">Action</th>
	</thead>
	<?php 
	echo $this->Form->hidden('patient_id_place_holder',array('id'=>'patient_id_place_holder')) ;
	$i=0;$val = 0;
	foreach($results as $result)
	{
		$i++;
		$patient_id = $result['Patient']['id'];
		$bill_id = $result['FinalBilling']['id'];
		//holds the id of patient
		
		/* $total_amount = $result['FinalBilling']['total_amount']-$paidByPatient[$patient_id];
		$advance_paid=$result[0]['paid_amount'];
		$tds=$TDSData[$result['Patient']['id']];
		$discount = $result[0]['total_discount'];
		$totalPaid = $advance_paid+ $tds+$discount ; 
		$color = '' ; */
		
		$total_amount = $result['FinalBilling']['total_amount']-$result[0]['patientPaid'];
		$advance_paid=$result[0]['advacnePAid'];//$result[0]['paid_amount'];
		$tds=$result[0]['TDSPAid'];
		$discount = $result[0]['total_discount'];
		$totalPaid = $advance_paid+ $tds+$discount ;
		$color = '' ;
		$showEdit='';
		$showDelete='';
		$advacneCardPAid=$patientCardData[$result['Patient']['person_id']];
		 
		if($total_amount == $totalPaid && $result['FinalBilling']['total_amount']>'0'){
			$color = 'paid_payment';
			$showEdit='none';
			if($result['FinalBilling']['amount_pending']<='0')$showDelete='';
		}else{
			$showEdit='';
			$showDelete='none';
		}
		
		if($result['FinalBilling']['amount_pending']<='0'){
			$showSettlement='none';
		}else{
			$showSettlement='';
		}
		?>
	<tr >
		<td width="21px"  align="center" style="text-align:center;" class="<?php echo $color ;?>"><?php  echo $i; ?></td>
		
		<td width="89px"  align="center" style="text-align:center;" class="<?php echo $color ;?>"><?php echo $result['Patient']['lookup_name'];  ?></td> 
		
		<td  align="center" style=" text-align:center;" class="<?php echo $color ;?>"><?php echo $result['Patient']['patient_id'];?></td>
		
		<td  align="center" style=" text-align:center;" class="<?php echo $color ;?>"><?php echo $result['Patient']['admission_id'];?></td>
		
		<td width="88px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
			<?php echo $form_received_on = $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); //date of admission ?> </td> 
			
		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
			<?php  echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')); //date of discharge ?>
		</td>
		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"> 
			<?php echo $this->Form->hidden('cmp_amt_paid', array('id'=>'amt_'.$bill_id,'type' => 'text','style'=>"width:20%",'label'=>false ,
					'div'=>false,'style'=>"width: 70%;",'class'=>'cmp_amt_paid','value'=>$result['FinalBilling']['total_amount']));
				echo $result['FinalBilling']['total_amount']; ?>
		</td> 
		
		<td width="88px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"> <?php echo $amntRecievedByPatient =$result[0]['patientPaid']; // Amount by patient ?> </td>
		
		<td width="88px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"> <?php echo $amntpending =$result['FinalBilling']['amount_pending']; // Amount pending  ?> </td>
		
		<td width="88px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"> <?php echo $amntRecieved =$result[0]['advacnePAid']+$advacneCardPAid; // Amount received form card and billing ?> </td>  
		
		<td width="85px"  align="center" style=" text-align:center;" class="<?php echo $color ;?>">  <?php   echo $tdsAmnt=$result[0]['TDSPAid']; //tds amountt  ?> </td>
		
		<td class="<?php echo $color ;?>"><?php echo $otherDeduction=$result[0]['total_discount'] ; ?></td>
		
		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"><?php echo $balAmount=$amntpending-$amntRecieved-$tdsAmnt-$otherDeduction;//bal amount?></td>
	 
		<td width="21" align="center" style="text-align: center; min-width: 21px;" class="<?php echo $color ;?>">
		   <?php 
		   		echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete Bill Settled')), 
					array('controller'=>'Corporates','action' =>'patient_delete', $result['Patient']['id'],'admin'=>false), 
					array('style'=>'display:'.$showDelete,'escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true)); 
		    
				echo '<a   class="fancybox" href="#corporateClaims" style="display:'.$showEdit.'" total_amount="'.$result['FinalBilling']['total_amount'].'"  advance_received="'.$result['FinalBilling']['package_amount'].'" patient_id="'.$result['Patient']['id'].'" patient_name="'.$result['Patient']['lookup_name'].'">';
				echo $this->Html->image('icons/edit-icon.png',array('Payment','alt'=>'Edit','title'=>'Edit'));
				echo '</a>';
				
				echo $this->Html->link($this->Html->image('icons/money.png',array('title'=>'Bill Settlement')),array('controller'=>'Billings','action'=>'full_payment','admin'=>false),array( 'patient_id'=> $result['Patient']['id'],'class'=>'corporateClaimSave final_payment','escape'=>false));
				
				if($result['Patient']['is_discharge']=='1'){
					echo $this->Html->link($this->Html->image('icons/upload-excel.png',array('alt'=>'Excel Upload','title'=>'Excel Upload')),
						array('controller'=>'billings','action'=>'uploadCorporateExcel',$result['Patient']['id'],'admin'=>false),
						array('class'=> 'uploadExcel billingServicesAction','id'=>'uploadExcel_'.$result['Patient']['id'],'escape' => false));
					
					if($result['PatientDocument']['filename']){
						echo $this->Html->link($this->Html->image('icons/download-excel.png'),array('controller'=>'Corporates','action' =>'downloadExcel',
							$result['Patient']['id'],$result['PatientDocument']['id'],'admin'=>false),
							array('escape' => false,'title' => 'Download Uploaded Excel', 'alt'=>'Download Uploaded Excel'));
					} 
				}
			?>
    	</td>
	</tr>
	<?php }  ?> 
</table>
<table align="center">
	<tr>
		<?php 
		$this->Paginator->options(array('url' => array($this->params->pass[0],"?"=>$getv)));
		?>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
		
		</TD>
	</tr>
</table> 
 
<?php

	
function add_dates($cur_date,$no_days)		//to get the day by adding no of days from cur date
		{
			$date = $cur_date;
			$date = strtotime($date);
			$date = strtotime("+$no_days day", $date);
			return date('Y-m-d', $date);
		} 
?>

<script>
$(document).ready(function(){
	$('.fancybox').click(function(){
		$('#patient_id_place_holder').val($(this).attr('patient_id')); 
		$('#patient_name').val($(this).attr('patient_name'));
		$('#advance_received').val($(this).attr('advance_received'));
		$('#total_amount').val($(this).attr('total_amount'));
		 
		 
		$('.fancybox').fancybox({ 
			'type':'ajax',
			'href':'<?php echo $this->Html->url(array('controller'=>"corporates",'action'=>"corporate_advance_payment",$tariffStandardID,'admin'=>false)) ?>/'+$("#patient_id_place_holder").val() ,
		     helpers     : { 
		    	locked     : true, 
		        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
		     }
		}); 
	});

	$(".final_payment").click(function(){ 
		$.fancybox({
			'autoDimensions':false,
	    	'width'    : '85%',
		    'height'   : '90%',
		    'autoScale': true,
		  	'transitionIn': 'fade',
		    'transitionOut': 'fade', 
		    'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200,				    
		    'type': 'iframe',
		    'helpers'   : { 
		    	   'overlay' : {closeClick: false}, // prevents closing when clicking OUTSIDE fancybox 
		    	  },
		    'href' : "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"full_payment","admin"=>false)); ?>/"+$(this).attr('patient_id')+"?corporate=corporate",
		});
	}); 

	
});	
</script>