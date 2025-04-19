<?php
echo $this->Html->css(array('internal_style'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?>

<style>
	body{
	font-size:13px;
	}
	.red td{
		background-color:antiquewhite !important;
	}
	.idSelectable:hover{
			cursor: pointer;
			}
	.tabularForm {
	    background: none repeat scroll 0 0 #d2ebf2 !important;
		}
	.tabularForm td {
		background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 3px 8px;
	}
	#msg {
	    width: 180px;
	    margin-left: 34%;
	}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Service Wise Collection', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div> 
<?php echo $this->Form->create('Voucher',array('type'=>'GET','id'=>'voucher','url'=>array('controller'=>'Accounting','action'=>'service_wise_collection','admin'=>false),));

	if($this->params->query['from_date']){
		$getfromFinal = str_replace("/", "-",$this->params->query['from_date']);
		$fromDate=date('jS-M-Y', strtotime($getfromFinal));
		$fdate=	$this->params->query['from_date'];
	}else{
		$fromDate=$getToFinal=date('jS-M-Y');	
	}
	
	if($this->params->query['to_date']){
		$getToFinal = str_replace("/", "-",$this->params->query['to_date']);
		$toDate=date('jS-M-Y', strtotime($getToFinal));
		$tdate=	$this->params->query['to_date'];
	}else{
		$toDate=date('jS-M-Y');
	}
	

?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<table align="center" style="margin-top: 10px">
			<tr>
				<td align="center"><strong><?php echo __('Location');?></strong></td>
				<td><?php echo $this->Form->input("Location.type",array('class'=>'location','id'=>"location_type",'type'=>'select','label'=>false,'options'=>array('All'=>'All',$locationList),'value'=>$locationid,'empty'=>'Please Select'));?></td>
				<td><?php echo $this->Form->input('Location.from_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'fdate','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From Date','value'=>$fdate));?></td>
				<td><?php echo $this->Form->input('Location.to_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'tdate','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'To Date','value'=>$tdate));?></td>
				<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?>
				<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'service_wise_collection'),array('escape'=>false));?></td>
				<?php echo $this->Form->end();?></td>
				<td><?php 
				if($this->params->query){
					$this->params->query['print']='yes';
				}else{
					$this->params->query['print']='yes';
				}
				echo $this->Html->link($this->Html->image('icons/printer.png',array('title'=>'Print Service Wise Collection')),'#',
						array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'service_wise_collection','?'=>$this->params->query))."', '_blank',
						'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200');  return false;")); ?></td>
			</tr>
			<tr>
		    	
		    	<td align="" valign="top" colspan="7" style="text-align:center;">
				  	<?php echo '<b>'.$fromDate.' To '.$toDate.'</b>'; ?>
				</td>
	    	</tr> 
		</table>

		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="25%" align="center" valign="top">SubGroup Name</th> 
						<th width="25%" align="center" valign="top" style="text-align: center; ">Net Amount</th> 
						<th width="25%" align="center" valign="top" style="text-align: center;">Discount</th>
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach ($dataDetails as $key=> $data){
					if(!empty($data['0']['total_amount']) || !empty($data['0']['total_discount'])){?>
					<tr>
						<td align="left" valign="top" style= "text-align: left;">
							<div style="padding-left:0px;padding-bottom:3px;">
								<?php  
								if($key==='Pharmacy'){
									echo 'Pharmacy' ;
								}else if($key==='OtPharmacy'){
									echo 'OtPharmacy' ;
								}else if($key==='Patient Card'){
									echo 'Patient Card' ;
								}else{
									if(strtolower($data['ServiceCategory']['alias'])=='laboratory'){
										echo $data['ServiceCategory']['alias'];
									}else
									echo !empty($data['ServiceSubCategory']['name'])?ucwords(strtolower($data['ServiceSubCategory']['name'])):ucwords(strtolower($data['ServiceCategory']['alias']));
								}?>
							</div>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo  round($data['0']['total_amount']);
							$totalRevenue +=  (int) round($data['0']['total_amount']);?>
						</td>						
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo round($data['0']['total_discount']);
							$totalDiscount +=  (int) round($data['0']['total_discount']);?>
						</td>						
						
				  	</tr>
				<?php }
					} ?>
				</tbody>
			<tr>
				<th class="tdLabel" colspan="0" style="text-align: left;"><?php echo __('Grand Total :');?></th>
					<?php if(empty($totalRevenue)){ ?>
							<th class="tdLabel"><?php echo " ";?></th><?php
						  }else{ ?>
							<th class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalRevenue)?></th>
					<?php } 
						if(empty($totalDiscount)){ ?>
							<th class="tdLabel"><?php echo " ";?></th><?php
						}else{ ?>
							<th class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalDiscount)?></th>
					<?php } ?>
						
			</tr>  
			<?php echo $this->Form->end();?>
			</table>
		</div>
	</td>
	</tr>
</table>

<script>

$("#fdate").datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	maxDate: new Date(),
	dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
});

$("#tdate").datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	maxDate: new Date(),
	dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
});
</script>