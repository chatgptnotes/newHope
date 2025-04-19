<?php echo $this->Html->script('topheaderfreeze');
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?> 

<?php $val=0;$val1=0;$refArray=array();
		foreach($patientData as $refKey=>$referal){//debug($referal);exit;
					$getexcludingExp=0;$getDiffFinal=0;$getDiff=0;
					if($billData['Bill'][$referal['patient_id']]['amount_paid']){
					$getDiff=$billData['Bill'][$referal['patient_id']]['amount_paid']-$billData['Bill'][$referal['patient_id']]['pharmacyCharges'];
					$getDiffFinal=$getDiff-($billData['Bill'][$referal['patient_id']]['radCharges']+
											$billData['Bill'][$referal['patient_id']]['labCharges']);
					$getexcludingExp=$getDiffFinal-$billData['Bill'][$referal['patient_id']]['BloodImplantCharges'];
					}else{
						$getexcludingExp=0;
					}					
					$totExcExp[$referal['patient_id']]=$getexcludingExp;
				 	$refArray[$referal['consultant_id']]['name']=$referal['referal'];
					$refArray[$referal['consultant_id']]['referal_percent']=$referal['referal_percent'].' %';
					$this->Number->format(round($getexcludingExp));					
					$referalAmt=0;
					$referalAmt=($getexcludingExp*$referal['referal_percent'])/100;					
					
					if($referal['type']=='S'){
						$val=$val+$referal['paid_amt'];
						$refArray[$referal['consultant_id']]['paid_amt']=$refArray[$referal['consultant_id']]['paid_amt']+$referal['paid_amt'];
					}
					if($referal['type']=='B'){
						$val1=$val1+$referal['paid_amt'];
						$refArray[$referal['consultant_id']]['paid_amt']=$refArray[$referal['consultant_id']]['paid_amt']+$referal['paid_amt'];
					}
					$bal=$referalAmt-$referal['paid_amt']; 
					$totBal[$referal['patient_id']]=$bal;
					
					if(empty($patientId[$referal['patient_id']])){
						$refArray[$referal['consultant_id']]['getexcludingExp']=$refArray[$referal['consultant_id']]['getexcludingExp']+$getexcludingExp;
						$refArray[$referal['consultant_id']]['referalAmt']=$refArray[$referal['consultant_id']]['referalAmt']+$referalAmt;
						$refArray[$referal['consultant_id']]['bal']=$refArray[$referal['consultant_id']]['bal']+$bal;
						$patientId[$referal['patient_id']]=$referal['patient_id'];
					}
					$bal=0;
					$referalAmt=0;
					$getexcludingExp=0;
						
		 }
		 
		//debug($refArray);exit;
		 ?>

<div class="inner_title">
	<h3>
		<?php echo __('Referal Collection Report', true); ?>
	</h3>
	<div style="float: right;">
		<span style="float: right;"> <?php echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>'referalExcel','excel',		
				'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));?>
		</span>
	</div>
	<div class="clr ht5"></div>
</div>
<?php echo $this->Form->create('Reports',array('action'=>'referralReport','type'=>'GET', 'id'=> 'datefilterfrm'));?>
<table border="0" cellpadding="0" cellspacing="0" width="500px" align="left">
	<tr>
		<td align="right"><?php echo __('Year') ?> :</td>
		<td class="row_format"><?php  
		$currentYear = date("Y");
		for($i=0;$i<=10;$i++) {
			$lastTenYear[$currentYear] = $currentYear;
			$currentYear--;
		}
		echo    $this->Form->input(null, array('name' => 'reportYear', 'class' => 'validate[required,custom[mandatory-select]]', 'id' => 'reportYear', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options' =>$lastTenYear, 'value' =>$reportYear));
		?></td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Month') ?> :</td>
		<td class="row_format"><?php 
		$monthArray = array('01'=> 'January','02'=> 'February','03'=> 'March','04'=> 'April','05'=> 'May','06'=> 'June','07'=> 'July','08'=> 'August','09'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December',);
		echo $this->Form->input(null, array('name' => 'reportMonth', 'class' => 'validate[required,custom[mandatory-select]]', 'id' => 'reportMonth', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options' =>$monthArray, 'empty'=> 'Select', 'value' =>$reportMonth));
		?></td>
	</tr>
	<tr>				 
			<td class="row_format" align="left" colspan="2" style="padding-left:155px;">
				<?php
					echo $this->Form->submit(__('Show Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
	</tr>
</table>
<?php echo $this->Form->end();?>
<div class="clr ht5"></div>
<?php if(!empty($refArray)){
?>
	<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm"
		style=""  align="center">
			<tr>
				<th width="15%" align="center" valign="top">Referal Name</th>
				<th width="15%" align="center" valign="top">Referal Percent</th>
				<th width="15%" align="center" valign="top">Amount Excluding Expenses</th>
				<!-- <th width="20%" align="center" valign="top" style="text-align: center;">Discount</th>-->
				<th width="15%" align="center" valign="top">Referal Amount</th>
				<th width="15%" align="center" valign="top" style="text-align: center;">Total Amount paid to Referal</th>
				<th width="15%" align="center" valign="top">Referal Balance Amount</th>				
				<!-- <th width="25%" align="center" valign="top" style="text-align: center;">Net Amount</th> -->
			</tr>
	</table>
	<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm"
		style="" id='container_table' align="center">
		<thead>
			<!--  <tr>
				<th width="15%" align="center" valign="top">Referal Name</th>
				<th width="15%" align="center" valign="top">Referal Percent</th>
				<th width="15%" align="center" valign="top">Amount Excluding Expenses</th>
				<th width="20%" align="center" valign="top" style="text-align: center;">Discount</th>
				<th width="15%" align="center" valign="top">Referal Amount</th>
				<th width="15%" align="center" valign="top" style="text-align: center;">Total Amount paid to Referal</th>
				<th width="15%" align="center" valign="top">Referal Balance Amount</th>				
				<th width="25%" align="center" valign="top" style="text-align: center;">Net Amount</th>
			</tr>-->
		</thead>
		<tbody>
		<?php 
		foreach($refArray as $refKey=>$referal){?>
				<tr id="<?php echo $refKey;?>" class="consultantDetail">
					<td width="15%" valign="top"><?php echo $referal['name'];?></td>
					<td width="15%" valign="top"><?php echo $referal['referal_percent'];?></td>
					<td width="15%" valign="top" ><?php echo $this->Number->format(round($referal['getexcludingExp']));?></td>
					<td width="15%" valign="top"><?php 
					echo $this->Number->format(round($referal['referalAmt']));?></td>
					<td width="15%"  valign="top"><?php echo $this->Number->format(round($referal['paid_amt']));?></td>
					<td width="15%" valign="top"><?php echo $this->Number->format(round($referal['bal']));
					?></td>				
				</tr>
		 	<?php }?>
		</tbody>		
	</table>
	<table width="100%" cellpadding="0" cellspacing="2" border="0" 
		style=""  align="center">
	<tr>
			<td width="15%" align="center"  valign="top" ><b>TOTAL</b></td>
			<td width="15%"  valign="top" >&nbsp;</td>
			<td width="15%"  valign="top">
			<?php foreach($totExcExp as $exp){
					$Exps=$Exps+$exp;
				}
				echo $this->Number->format(round($Exps));?></td>
				<td width="15%"  valign="top" >&nbsp;</td>
			<!-- <td width="20%"  valign="top" >&nbsp;</td>-->
			<td width="15%" valign="top" style="">
			<?php //foreach($amtPaid as $paid){
					$totAmt=$val+$val1;
				//}
				echo $this->Number->format(round($totAmt));?></td>	
				<td width="15%"  valign="top" ><?php 
				foreach($totBal as $bal){
					$tBal=$tBal+$bal;
				}
				echo $this->Number->format(round($tBal));?></td>			
		</tr>
	</table>
<?php }?>
<script>
$("#container_table").freezeHeader({ 'height': '500px','width': '1040px' });
$(".consultantDetail").click(function(){
	var url="<?php echo $this->Html->url(array("controller" => 'Services', "action" => "getExpensesDetail")); ?>" ;
	id = $(this).attr('id');
	var reportYear = $('#reportYear').val();
	var reportMonth = $('#reportMonth').val();
	$.fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'hideOnOverlayClick':false,
		'type' : 'iframe',
		'href' : url+'/'+id+'/'+reportMonth+'/'+reportYear
	});
	
});
</script>