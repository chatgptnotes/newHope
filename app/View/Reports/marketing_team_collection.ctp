<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css','tooltipster.css'));  
 echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js','jquery.autocomplete.js','jquery.tooltipster.min.js')); ?>

 <style>
 .tabularForm {
	    background: none repeat scroll 0 0 #c3ecff !important;
		}
	.tabularForm td {
		background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 3px 8px;
	}
 </style>
 <html moznomarginboxes mozdisallowselectionprint>
 <div class="inner_title">
	<h3><?php echo __('Marketing Team Collection Report', true); ?></h3>
    <div style="float:right;"><span style="float:right;">
	<?php	/* echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',		
				'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));	 */	
	?>
	</span>
	</div>
</div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('teamCollectionForm',array('type' => 'get','url'=>array('controller'=>'Reports','action'=>'marketing_team_collection','admin'=>false),'id'=>'teamCollectionForm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			)); ?>
<?php if(empty($this->params->query['print'])){?>			  
<table border="0"  cellpadding="0" valign="top" cellspacing="0" width="40%" align="center">
	<tr>
		<td> 
		<?php  echo $this->Form->input('Consultant.market_team',array('empty'=>__('Please Select'),'options' =>$marketing_teams,'label'=>false ,'class'=>'textBoxExpnd','id'=>'team' ,'value'=>$this->params->query['market_team'],'style'=>'width:50%'));?>
		</td>
		<td>
		<?php echo $this->Form->input('dateFrom1',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom1",'autocomplete'=>'off','label'=>false,'div'=>false,'value'=>$this->params->query['dateFrom1'],'name'=>'dateFrom1','placeholder'=>'Date from'));?>
		</td>
		<td>
		<?php echo $this->Form->input('dateTo1',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo1",'autocomplete'=>'off','label'=>false,'div'=>false,'value'=>$this->params->query['dateTo1'],'name'=>'dateTo1','placeholder'=>'Date To'));?>
		</td>
		<td>
		<div style="text-align:center;"><?php echo $this->Form->submit(__('Search'), array('id'=>'submit','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));?></div>
        </td>
        <td>
        <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action'=>'marketing_team_collection'),array('escape'=>false, 'title' => 'refresh'));?> 
        </td> 
        <td>
        <?php if($this->params->query){
					$this->params->query['print']='yes';
				} else{
					$this->params->query['print']='yes';
				} 
				echo $this->Html->link($this->Html->image('icons/printer.png',array('title'=>'Print Service Wise Collection')),'#',
						array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Reports','action'=>'marketing_team_collection','?'=>$this->params->query))."', '_blank',
						'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200');  return false;")); ?>
        </td>
	</tr>
</table> 
<?php }?>

<?php echo $this->Form->end(); ?>

<div class="clr ht5"></div>
<div style="float: left;max-height:500px;width:100%;overflow:scroll;"> 
<table width="80%" cellpadding="0" cellspacing="2" border="0" 	class="tabularForm"  align = "center">
 <?php if($billData>0){?>
 	<tr class="light fixed">
 	<th colspan="4" style="text-align: center;font-size:large;">
 	<?php 
 		if($this->params->query['dateFrom1'] || $this->params->query['dateTo1']){
	 		$fromDate = $this->params->query['dateFrom1'];
	 		$toDate = $this->params->query['dateTo1'];
	 	}else{
			$fromDate = $this->DateFormat->formatDate2Local(date("Y-m-d",strtotime(date( "Y-m-d", strtotime(date("Y-m-d"))). "-1 month" )),Configure::read('date_format'));
			$toDate = $this->DateFormat->formatDate2Local(date("Y-m-d"),Configure::read('date_format'));
		}
 		echo ("From  ".$fromDate."   To  ".$toDate);?>
 	</th>
 	</tr>
 	<tr class="light fixed"> 
		<th width="12%" align="center" valign="top" style="text-align: center;">Marketing Team </th>
		<th width="12%" align="center" valign="top" style="text-align: center;">Discharge Date </th>
		<th width="12%" align="center" valign="top" style="text-align: center;">Patient Name</th>
		<th width="12%" align="center" valign="top" style="text-align: center;">Amount Paid</th>
	</tr> 
	
	<?php  $toggle =0 ; $totalPaid = 0;$totalAmount = 0;
	foreach($team as $mTeam){
	foreach($payment_details as $patientDetail){ ?>
		<?php if($billData[$mTeam][$patientDetail['Patient']['id']]['team']){
			if($toggle == 0) {
				echo "<tr class='row_gray'>";
				$toggle = 1;
			}else{
				echo "<tr>";
				$toggle = 0;
			}
		?>
		<td align="center" >
   	    	<?php echo $billData[$mTeam][$patientDetail['Patient']['id']]['team'];?>
   		</td>
		<td align="center" >
   	    	<?php echo $this->DateFormat->formatDate2Local($billData[$mTeam][$patientDetail['Patient']['id']]['discharge_date'],Configure::read('date_format'));?>
   		</td>
		<td align="left">
			<?php echo $billData[$mTeam][$patientDetail['Patient']['id']]['patient_name'];?>
		</td>
   		<td align="right">
   		<?php if(!empty($billData[$mTeam][$patientDetail['Patient']['id']]['divided'])){
   				 $totalPaid = $billData[$mTeam][$patientDetail['Patient']['id']]['divided'];
   				echo number_format($billData[$mTeam][$patientDetail['Patient']['id']]['divided']);
			}else{
				echo '--';
			}
			$totalAmount = $totalAmount+$totalPaid;
   		?>
   		</td>
	  </tr>
	 		
	 <?php }
		}?>
<?php } ?>
	<tr class="" > 
		<th colspan="2"></th>
		<th style="text-align: right;font-size: medium;"><?php echo __("Total:");?></th>
		<th style="text-align: right;font-size:medium; " ><?php echo number_format(round($totalAmount));?></th>
	</tr> 
<?php } else{ ?>
  <tr>
  	<TD colspan="4" align="center"><?php echo __('No record available', true); ?>.</TD>
  </tr>
  <?php }?>
</table>

  <div id="printButton" style="float: right">
  	<?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
  </div>

  
<script>
jQuery(document).ready(function(){
	
$("#dateFrom1").datepicker
({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});	
		
 $("#dateTo1").datepicker
 ({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	}); 


$('.filter').change(function()	//.checkMe is the class of select having patient's id as the id
	{
		var team = $('#team').val(); 
		//alert(team);
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Reports', "action" => "profit_referral_doctor", "admin" => false));?>";
		$.ajax({
		url : ajaxUrl + '?market_team=' + team,
		beforeSend:function(data){
		$('#busy-indicator').show();
		},
		success: function(data){
			$("#container").html(data).fadeIn('slow');
			$('#busy-indicator').hide();
		}
		});
	});

function hidePrint(){
	$('#printButton').show();
}

});
</script>