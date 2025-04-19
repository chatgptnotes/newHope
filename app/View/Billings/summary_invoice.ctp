<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
	xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset();
$website=$this->Session->read("website.instance");
if($website=='kanpur')
	$marginLeft="0px";
else
	$marginLeft="0px";
?>
<title></title>
<?php echo $this->Html->css(array('internal_style.css')); ?>
<style>
body {
	margin: 10px 0 0 0;
	padding: 0;
	font-family: Bookman Old Style;
	font-size: 12px;
	color: #E7EEEF;
}

.boxBorder {
	border: 1px solid #3E474A;
}

.boxBorderBot {
	border-bottom: 1px solid #3E474A;
}

.boxBorderRight {
	border-right: 1px solid #3E474A;
}

.tdBorderRtBt {
	border-right: 1px solid #3E474A;
	border-bottom: 1px solid #3E474A;
}

.tdBorderBt {
	border-bottom: 1px solid #3E474A;
}

.tdBorderTp {
	border-top: 1px solid #3E474A;
}

.tdBorderRt {
	border-right: 1px solid #3E474A;
}

.tdBorderTpBt {
	border-bottom: 1px solid #3E474A;
	border-top: 1px solid #3E474A;
}

.tdBorderTpRt {
	border-top: 1px solid #3E474A;
	border-right: 1px solid #3E474A;
}

.columnPad {
	padding: 5px;
}

.columnLeftPad {
	padding-left: 5px;
}

.tbl {
	background: #CCCCCC;
}

.tbl td {
	background: #FFFFFF;
}

.totalPrice {
	font-size: 14px;
}

.adPrice {
	border: 1px solid #CCCCCC;
	border-top: 0px;
	padding: 3px;
}

@page {
	size: auto;
	margin-top: 37mm;
}

@page :last { @bottom { content:element(tblFooter);
	
}
}
</style>
<style>
.print_form {
	background: none;
	font-color: black;
	color: #000000;
	min-height: 800px;
}

.formFull td {
	color: #000000;
}

.tabularForm {
	background: #000;
}

.tabularForm td {
	background: #ffffff;
	color: #333333;
	font-size: 13px;
	padding: 5px 8px;
}

@media print {
	#printButton {
		display: none;
	}
}
</style>
</head>
<!-- onload="javascript:window.print();" -->
<body class="print_form">
	<?php echo $this->Html->script('jquery-1.5.1.min.js'); ;
	?>
	<!-- <div>&nbsp;</div> -->


	<table width="200" style="float: right">
		<tr>
			<td align="right">
				<div id="printButton">
					<?php 
					//echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();'));
					
					echo $this->Html->link(__('Print'),'#',
					array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'summaryInvoice',$this->params->pass[0],'print'))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=900');  return false;"));
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<?php
	$website  = $this->Session->read('website.instance');
	
?>

	<!-- Do not remove this table as it is used to separate header print page by pankaj w :) -->
	<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" id="fullTbl" class="boxBorder headerInfo" style="margin-left: <?php echo $marginLeft;?>">
		<thead>
			<tr>
				<td>
					<table style="" width="800" border="0" cellspacing="0"
						cellpadding="0" align="center">

						<tr>
							<td height="20" colspan="2" style="text-align: center; background-color: gray;"></td>
						</tr>
						<tr>
							<td colspan="2" align="center" valign="top" class="heading" id="tblHead"><strong><?php echo 'SUMMARY INVOICE';?> </strong></td>
						</tr>
						<tr>
							<td height="20" colspan="2" style="text-align: center; background-color: gray;"></td>
						</tr>
						<tr>
						 <td width="50%" align="left" valign="top" class="boxBorderBot">
						   <table width="100%" border="1" cellspacing="0" cellpadding="3" class="tdBorderTp">
						    	<tr>
									<td width="40%" align="left" valign="top">Name Of Patient</td>
									<td valign="top"><?php echo $patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'];
									if($patient['Patient']['vip_chk']=='1'){
										echo __("  ( VIP )");
									} ?>
									</td>
								</tr>
								<!--  <tr>
									<td align="left" valign="top">Address</td>
									<td valign="top"><?php 
									if(strlen($address)<=32){ echo $address;
								      	}
								      	else
								      	{
								      		$addressWrap=substr($address,0,32) .'...';
								      		echo $addressWrap;
								      	}?></td>
								</tr>-->
								<tr>
									<td align="left" valign="top">Primary Consultant</td>
									<td valign="top"><?php echo $primaryConsultant[0]['fullname']; 
									?>
									</td>
								</tr>
								<?php if($patient['Patient']['admission_type']=='IPD'){?>
								<tr>
									<td align="left" valign="top">Ward Name/Bed No.</td>
									<td valign="top"><?php echo $patient['Ward']['name']."/".$patient['Room']['bed_prefix'].$patient['Bed']['bedno'];
									?>
									</td>
								</tr>
								<?php }?>
								<tr>
									<td align="left" valign="top">Admission Date & Time</td>
									<td valign="top"><?php $admissionDate = explode(" ",$patient['Patient']['form_received_on']);
									echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?>
									</td>
								</tr>
								<tr>
									<td align="left" valign="top">Registration No.</td>
									<td valign="top"><?php echo $patient['Patient']['admission_id'];?>
									</td>
								</tr>
						   </table>
						</td>
						
						<td width="50%" align="Right" valign="top" class="boxBorderBot">
						<table width="100%" border="1" cellspacing="0" cellpadding="3" class="tdBorderTp">
								<tr>
									<td width="40%" align="left" valign="top">Age/Sex</td>
									<td valign="top"><?php echo $patient['Person']['age']."/".ucfirst($patient['Person']['sex']);?></td>
								</tr>
								<tr>
									<td width="30%" align="left" valign="top">Contact No.</td>
									<td valign="top"><?php echo $patient['Person']['mobile'];?></td>
								</tr>
								<tr>
									<td align="left" valign="top">Case Type</td>
									<td valign="top"><?php //echo $patient['TariffStandard']['name'];
							  		echo $tariffData[$patient['Patient']['tariff_standard_id']];?>
									</td>
								</tr>
								<?php if($patient['Patient']['admission_type']=='IPD'){?>
							<!-- 	<tr>
									<td align="left" valign="top">Bed No</td>
									<td valign="top"><?php echo $patient['Room']['bed_prefix'].$patient['Bed']['bedno'] ;
									?>
									</td>
								</tr> -->
							   <?php }?>
							   <tr>
									<td align="left" valign="top">Discharge Date & Time</td>
									<td valign="top"><?php echo $finalBillingData['FinalBilling']['discharge_date'] ;
									?>
									</td>
								</tr>
								<tr>
									<td align="left" valign="top">Invoice No.</td>
									<td valign="top"><?php echo $billNumber;?></td>
								</tr>
						   </table>
						</td>
						</tr>
						<tr><td colspan="4">
							<table border="1"  style="width: 100%" >
							 <tr> <td> &nbsp; Address :   <?php echo "&nbsp &nbsp &nbsp &nbsp".$address;?></td></tr>
							</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td width="100%" align="left" valign="top">
							 <?php 
							 echo $this->Form->create('',array('controller'=>'Billing','action'=>'summaryInvoice','type' => 'POST','id'=>'summaryInvoice','inputDefaults' => array(
							 		'label' => false,'div' => false,'error' => false )));
                              echo $this->Form->hidden('patientID', array('value'=>$this->params->pass[0]));
							?>
								<table width="100%" border="0" cellspacing="0" cellpadding="5"
									class="tdBorderTpBt">
									<tr>
										<td width="2%"  align="center" class="tdBorderRtBt"><strong>Sr. No.</strong></td>
										<td width="42%" align="center" class="tdBorderRtBt" ><strong>Particulars</strong></td>
									    <td width="2%" 	align="center" class="tdBorderRtBt"><strong>Unit</strong></td>
										<td width="10%" align="center" class="tdBorderRtBt"><strong>Rate</strong></td>
										<td width="8%" 	align="center" class="tdBorderRtBt"><strong>Discount</strong></td>
										<td width="14%" align="center" class="tdBorderBt "><strong>Total Amount</strong></td>
									</tr>
									<?php
										$srNoHead=1;
										$totalAmount = 0;
										$summaryInvData=unserialize($patient['Patient']['summary_invoice_discount']);
									?>
									
								<?php 
								foreach($finalBillArray as $head => $services){ 
											if(!empty($summaryInvData)){
												if($summaryInvData[$head]['headsTotal'] < $services['Amount']){
													$textColor="red !important";
												}else if($summaryInvData[$head]['headsTotal']> $services['Amount']){
													$textColor="green !important";
												}else{
													$textColor="";
												}
									 		}?>
							         <?php if($head != Configure::read('surgeryservices')){?>
									<tr>
										<td align="center" class="tdBorderRt"><?php echo $srNoHead;?></td>
										<td class="tdBorderRt" style="font-size: 12px;"><?php 
											if($head == 'Mandatory services'){
												echo "Registration Charges";
											}else{
												echo $head;
											}
											?></td>
										<td align="center" valign="top" class="tdBorderRt"><?php
										  if(($head == 'Mandatory services')|| ($head =='Room Tariff') || ( $head =='Surgery') ){
											  echo $services['NoOFTimes'];
											}else{
												echo "-";
											}
											?>
										</td>
										<td align="center" valign="top" id="rate" class="tdBorderRt rate" ><?php 
												
												if(($head == 'Mandatory services')|| ($head =='Room Tariff') || ( $head =='Surgery') ){
                                                    echo $services['Rate'];
												}else{
													echo "-";
												}
												
												if($summaryInvData[$head]['headsTotal']!=''){
													$displayTotal = $summaryInvData[$head]['headsTotal'];
												}else{
													$displayTotal = $services['Amount'];
												}
												echo $this->Form->hidden('tot',array('id'=>'tot_'.str_replace(" ","",$head),'value'=>$displayTotal));
										?>
										</td>
										<td align="center" valign="top" class="tdBorderRt"> <?php 
										        echo $this->Form->input('', array('name'=>"SummaryInvoice[".$head."][discountAmt]",'type'=>'text','class' => 'discAmt summaryDiscount','style'=>'color:'.$textColor ,'id' => 'discountAmt_'.str_replace(" ","",$head), 
	                                                      'label'=> false, 'div' => false, 'error' => false ,'autocomplete'=>'off','value'=>$summaryInvData[$head]['discountAmt'])  );
										        echo "<span style='float:left'>";
										        echo $this->Html->image('icons/plus.png',array('title'=>'Add','alt'=>'Add','class'=>'add imgButton','id'=>str_replace(" ","",$head),'onclick'=>"getType('".str_replace(' ', '', $head)."','plus')"));
										        echo "</span>";
										        echo "<span style='float:right'>";
										        echo $this->Html->image('icons/minus_red.png',array('class'=>'sub imgButton','title'=>'Subtract','alt'=>'Subtract','id'=>str_replace(" ","",$head),'onclick'=>"getType('".str_replace(' ', '', $head)."','minus')"));
										        echo "</span>";
										        echo $this->Form->hidden('man_type',array('id'=>'manipulationType_'.str_replace(" ", "", $head),'value'=>''));
	     									 ?>
     									</td>
     									
										 <td align="right" valign="top" class=" amount totalAmt" id="totalHead_<?php echo str_replace(" ","",$head);?>"><?php 
		                                         echo $displayTotal;
		                                         $totalAmount = $totalAmount + $displayTotal;
										?>
										</td> 
										<input id ="totalAmount_<?php echo str_replace(" ","",$head);?>" class="totalAmount" value="<?php echo $displayTotal;?>" type="hidden" name="SummaryInvoice[<?php echo $head;?>][headsTotal]"/> 
										
									
									</tr>
							<?php }?>
						<?php if($head == Configure::read('surgeryservices')){ ?>
							<?php  
									unset($services['NoOFTimes']);
									unset($services['Rate']);
									unset($services['Amount']);
									$i=1; 
							 	$surgeryPrevCharge=unserialize($patient['OptAppointment']['ot_charges_for_summary_invoice']);
							 	
							   foreach($services as $head=>$service){  
										$otService = $service['ServiceName']; 
										$fieldname = $service['field_name'];
										$serviceId = $service['id'];
										$serName =  str_replace("&nbsp;","",$service['ServiceName']);
										
										if(!empty($surgeryPrevCharge)){

											if($surgeryPrevCharge[$fieldname][$serName]['headsTotal'] < $surgeryPrevCharge[$fieldname][$serName]['surgery_rate']){
												$textColor="red !important";
											}else if($surgeryPrevCharge[$fieldname][$serName]['headsTotal']> $surgeryPrevCharge[$fieldname][$serName]['surgery_rate']){
												$textColor="green !important";
											}else if($surgeryPrevCharge[$fieldname][$serName]['headsTotal'] == $surgeryPrevCharge[$fieldname][$serName]['surgery_rate']){
												$textColor="black !important";
											}
										}
									?>
									<tr>
										<td align="center" class="tdBorderRt"><?php echo $srNoHead++;?>&nbsp;</td>
										<td class="tdBorderRt" style="font-size: 12px;"><?php  echo $serName;?></td>
										<td align="center" valign="top" class="tdBorderRt"><?php 
										
											if($summaryInvData[$head]['headsTotal']!='0' && $service['Amount']!='0'){
											echo $service['NoOFTimes'];
											}
										?>
										</td>
										<td align="center" valign="top" id="rate" class="tdBorderRt rate" value="<?php echo $service['Rate'];?>"><?php
										
											if($surgeryPrevCharge[$fieldname][$serName]['headsTotal']!=''){
												$displayTotal = $surgeryPrevCharge[$fieldname][$serName]['headsTotal'];
											}else{
												$displayTotal = $service['Amount'];
											}
											if(!empty($surgeryPrevCharge[$fieldname][$serName]['surgery_rate']) && $service['Amount']!='0'){
												echo $prevSurRate=$surgeryPrevCharge[$fieldname][$serName]['surgery_rate'];
                                                echo $this->Form->hidden('',array('id'=>'tot_'.$i,'value'=>$prevSurRate,'name'=>"SummaryInvoice[Surgery][$serviceId][$fieldname][$serName][surgery_rate]"));
											}else if($service['Amount']!='0'){
												echo $service['Rate'];
												echo $this->Form->hidden('',array('id'=>'tot_'.$i,'value'=>$displayTotal,'name'=>"SummaryInvoice[Surgery][$serviceId][$fieldname][$serName][surgery_rate]"));
											}
											
										?>
										</td>
										<td align="center" valign="top" class="tdBorderRt"> <?php 
										if($surgeryPrevCharge[$fieldname][$serName]['headsTotal']!='0' && $service['Amount']!='0'){
										        echo $this->Form->input('', array('name'=>"SummaryInvoice[Surgery][$serviceId][$fieldname][$serName][discountAmt]",'type'=>'text','class' => 'discAmt summaryDiscount','style'=>'color:'.$textColor ,'id' => 'discountAmt_'.$i, 
	                                           'label'=> false, 'div' => false, 'autocomplete'=>'off','error' => false,'value'=>$summaryInvData[Surgery][$serviceId][$fieldname][$serName]['discountAmt'])  );
										       	echo "<span style='float:left'>";
												echo $this->Html->image('icons/plus.png',array('title'=>'Add','alt'=>'Add','class'=>'add imgButton','id'=>$i,'onclick'=>"getType('".$i."','plus')"));
												echo "</span>";
												echo "<span style='float:right'>";
												echo $this->Html->image('icons/minus_red.png',array('class'=>'sub imgButton','title'=>'Subtract','alt'=>'Subtract','id'=>$i,'onclick'=>"getType('".$i."','minus')"));
												echo "</span>";
												echo $this->Form->hidden('man_type',array('id'=>'manipulationType_'.$i,'value'=>''));
									      } ?>
								        </td>
										<td align="right" valign="top" class=" amount totalAmt"  id="totalHead_<?php echo $i;?>"><?php 
										if($surgeryPrevCharge[$fieldname][$serName]['headsTotal']!='0' && $service['Amount']!='0'){
												echo $displayTotal;
												$totalAmount = $totalAmount + $displayTotal;
										}?>
										</td>
										<input id ="totalAmount_<?php echo $i ;?>" class="totalAmount" value="<?php echo $displayTotal;?>" type="hidden"
										 name="SummaryInvoice[Surgery][<?php echo $serviceId; ?>][<?php echo $fieldname;?>][<?php echo $serName; ?>][headsTotal]"/> 
									</tr>
									<?php $i++ ;}?>
									<?php }?>
					
								
									<?php $srNoHead++;?>
									<?php }?>
									<?php $finalRefundAndDiscount['TotalAmount'] = $totalAmount;?>
									<?php /* -------------------------------------------------------------------------------------------*/?>
									<tr>
										<td align="right" valign="top" class="tdBorderTpRt tdBorderTpBt">&nbsp;</td>
										<td align="right" valign="top" class="tdBorderTpRt tdBorderTpBt"><strong>Total</strong>
										</td>
										<td align="right" valign="top" class="tdBorderTpRt tdBorderTpBt">&nbsp;</td>
										<td align="right" valign="top" class="tdBorderTpRt tdBorderTpBt">&nbsp;</td>
										<td align="right" valign="top" class="tdBorderTpRt tdBorderTpBt">&nbsp;
										<input id ="finalAmnt" class="finalAmnt"  type="hidden" value="<?php echo $finalRefundAndDiscount['TotalAmount'];?>" name="SummaryInvoice[finalTotal]" /></td>
										<td align="right" valign="top"class="tdBorderTp totalPrice  tdBorderTpBt">
										<strong> <span class="WebRupee"></span> 
										<?php  echo $this->Number->currency(ceil($finalRefundAndDiscount['TotalAmount'])); ?></strong>
										 </td>
									</tr>
									<tr> 
									<td colspan="5"></td>
									<td style="float: right;"><input type="submit" value="Submit" class="blueBtn"></td></tr>
								</table>
							
							</td>
						</tr>
						
						
					</table>
				</td>
			</tr>
		</tbody>

		<!-- <tfoot> -->
		<tr>
			<td width="100%" align="left" valign="top" class="tblFooter"
				id="tblFooter">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					
						<td valign="top" class="boxBorderRight columnPad"> <?php if($summaryInvData!=''){?>Amount in words<?php }?><br /> 
						<strong><?php 
						if($summaryInvData!=''){
						echo $this->RupeesToWords->no_to_words(ceil($finalRefundAndDiscount['TotalAmount']));
						}?>
						</strong>
						</td>
						<td width="292" class="tdBorderRt">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="140" height="20" valign="top" class="tdBorderRtBt">&nbsp;Amount Paid</td>
									<td align="right" valign="top" class="tdBorderBt totalPaidAmnt"><?php 
									echo $this->Number->currency(ceil($finalRefundAndDiscount['TotalPaid']));
									?>
									</td>
									<input id ="paidAmnt" class="paidAmnt"  type="hidden" value="<?php echo $finalRefundAndDiscount['TotalPaid'];?>"/>
								</tr>

								<?php 

								if($totalDiscountGiven[0]['sumDiscount']){
									$discountAmount=$totalDiscountGiven[0]['sumDiscount'];
								}else{
									$discountAmount='';
								}
			                    if($discountAmount != '' && $discountAmount!=0){?>
								<tr>
									<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Discounted Amount</td>
									<td align="right" valign="top" class="tdBorderBt"><?php  
									echo $this->Number->currency(ceil($discountAmount));
									?>
									</td>
									<input id ="discount" class="discount"  type="hidden" value="<?php echo $discountAmount;?>"/>
								</tr>
								<?php }else { $discountAmount='0';?>
								<input id ="discount" class="discount"  type="hidden" value="<?php echo $discountAmount;?>"/>
								<?php }?>
								<?php 
								if($totalRefundGiven[0]['sumRefund']){
									$totalRefund=$totalRefundGiven[0]['sumRefund'];
								}else{
									$totalRefund='';
								}
			                    if($totalRefund != '' && $totalRefund!=0){?>
								<tr>
									<td height="20" valign="top" class="tdBorderRtBt">&nbsp; <?php  echo 'Refunded Amount';?>
									</td>
									<td align="right" class="tdBorderBt"><?php 
									echo $this->Number->currency(ceil($totalRefund));
									?>
									</td>
									<input id ="refund" class="refund"  type="hidden" value="<?php echo $totalRefund;?>"/>
								</tr>
								<?php }else{$totalRefund='0';?>
								<input id ="refund" class="refund"  type="hidden" value="<?php echo $totalRefund;?>"/>
                                 <?php }?>


								<tr>
									<td height="20" valign="top" class="tdBorderRtBt">&nbsp; <?php if($invoiceMode=='direct') echo 'To Pay on '.$dynamicText;
	    						    else echo 'Balance';?>
									</td>
									<td align="right" valign="top" class="tdBorderBt balance"><?php 
									echo $this->Number->currency(ceil($finalRefundAndDiscount['TotalAmount'] - $finalRefundAndDiscount['TotalPaid'] - $discountAmount+$totalRefund));
									?>
									</td>
								</tr>

								<tr>
									<td height="20" valign="top" class="tdBorderRtBt">&nbsp; <?php echo 'Summary Discount';?>
									</td>
									<td align="right" valign="top" class="tdBorderBt summaryDisc"><?php
									 if($summaryInvData!=''){
									echo $this->Number->currency(ceil($summaryInvData['summDiscount']));
								 }?>
									</td>
									<input id ="summDiscount" class="summDiscount"  type="hidden" value="<?php echo $summaryInvData['summDiscount'];?>" name="SummaryInvoice[summDiscount]" /></td>
								</tr>
								

							</table>
						</td>
					</tr>
				</table>
				
			</td>
		</tr>
			<?php echo $this->Form->end();?>
		<tr>
			<td width="100%" align="left" valign="top" class="columnPad ">
				<table width="" cellpadding="0" cellspacing="0" border="0">
					<?php if($this->Session->read('website.instance')=='hope'){?>
					<tr>
						<td height="18" align="left" valign="top">Hospital Service Tax No.</td>
						<td width="15" align="center" valign="top">:</td>
						<td align="left" valign="top"><strong><?php echo $this->Session->read('hospital_service_tax_no');?>
						</strong></td>
					</tr>
					<tr>
						<td height="20" align="left" valign="top">Hospitals PAN</td>
						<td align="center" valign="top">:</td>
						<td align="left" valign="top"><strong><?php echo $this->Session->read('hospital_pan_no');?>
						</strong></td>
					</tr>
					<?php }else{?>
					<tr>
						<td height="18" align="left" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td height="20" align="left" valign="top">&nbsp;</td>
					</tr>
					<?php }?>
					<tr>
						<td height="20" align="left" valign="top"><strong>Signature of
								Patient :</strong></td>
						<td align="center" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="100%" align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="55%" class="columnPad boxBorderRight">&nbsp;</td>
						<td width="45%" align="right" valign="bottom"
							class="columnPad tdBorderTp tdBorderRt"><strong><?php echo $this->Session->read('billing_footer_name');?>
						</strong><br /> <br /> <br />
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="85">Bill Manager</td>
									<td width="65">Cashier</td>
									<td width="80">Med.Supdt.</td>
									<td align="right">Authorised Signatory</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!--   </tfoot> -->
	</table>
</body>
</html>
 <script type="text/javascript">
      jQuery(document).ready(function(){
    	  $('.add').click(function(){
        	  var discountHeads = $(this).attr('id');
	    	  var FirstNumber= ($("#tot_"+discountHeads).val()!="") ? $("#tot_"+discountHeads).val() :0;
	    	  var SecondNumber = ($("#discountAmt_"+discountHeads).val()!='') ? $("#discountAmt_"+discountHeads).val() :0;
	    	  var sum = parseInt(FirstNumber) + parseInt(SecondNumber);	
	    	  $("#totalHead_"+discountHeads).html(sum);
	    	  $("#totalAmount_"+discountHeads).val(sum);
	    	  $("#discountAmt_"+discountHeads).attr('style','color:green !important');
	    	  getTotal();
    	}); 

    	  $('.sub').click(function(){
        	  var discountHeads = $(this).attr('id');
        	  var FirstNumber= ($("#tot_"+discountHeads).val()!="") ? $("#tot_"+discountHeads).val() :0;
	    	  var SecondNumber = ($("#discountAmt_"+discountHeads).val()!='') ? $("#discountAmt_"+discountHeads).val() :0;
	    	  var substract = parseInt(FirstNumber) - parseInt(SecondNumber);	
	    	  $("#totalHead_"+discountHeads).html(substract);
	    	  $("#totalAmount_"+discountHeads).val(substract);
	    	  $("#discountAmt_"+discountHeads).attr('style','color:red !important');
	    	  getTotal();
    	 });  

      });
       function getTotal(){
          		var total=0;
				$.each($('.amount'),function(){
					var thisAmt = parseInt($(this).text());
					if(!isNaN(thisAmt)){
						total+=thisAmt;
					}
				});
				$('.totalPrice').html(total.toFixed(2));
				$("#finalAmnt").val(total);
	
				var paidAmnt= ($('#paidAmnt').val()!='' ? $('#paidAmnt').val() :0);  
				var totalFinalAmount= $("#finalAmnt").val();
				var discount= ($('#discount').val()!='' ? $('#discount').val() :0); 
				var refund= ($('#refund').val()!='' ? $('#refund').val() :0); 
				var balance = parseInt(totalFinalAmount)-parseInt(paidAmnt)-parseInt(discount)+parseInt(refund); 
				$(".balance").html(balance.toFixed(2));

				
           }
        
      function getType(id,type){
          //console.log(id+"=>"+type);
      	$("#manipulationType_"+id).val(type);		   
      }

      $(".discAmt").keyup(function(){
		var id = $(this).attr('id').split("_")[1];
		var rate = parseInt($("#tot_"+id).val()!='' ? $("#tot_"+id).val(): 0);
		var val = parseInt($(this).val()!='' ? $(this).val(): 0);
		var total = parseInt($("#totalAmount_"+id).val()!='' ? $("#totalAmount_"+id).val() : 0); 
		var type = $("#manipulationType_"+id).val();
		
		if(type === "plus"){
			total = rate + val;	
			this.style.setProperty( 'color', 'green', 'important' );	
		}else if(type === "minus"){
	    	 total = rate - val;
			 this.style.setProperty( 'color', 'red', 'important' );	
		}
		$("#totalAmount_"+id).val(total);
		$("#totalHead_"+id).html(total);
		getTotal();
		calculateSummary();
      });

      function calculateSummary(){
    	  	var getConTotal=0;
  			$.each($('.summaryDiscount'),function(){
  			var key= $(this).attr('id').split("_")[1];
  			var man= $("#manipulationType_"+key).val();
  			var val = parseInt($("#discountAmt_"+key).val()!=''?$("#discountAmt_"+key).val():0);
  			console.log(key+"=>"+man+"=>"+$("#discountAmt_"+key).val());
  			if(man==='plus'){
  				if(!isNaN(val)){
  					getConTotal+=val;
				}
  			}else if(man==="minus"){
  				if(!isNaN(val)){
  					getConTotal-=val;
				}
  				
  			}
  		}); 
  		$(".summaryDisc").html(parseInt(getConTotal));
  		$(".summDiscount").val(parseInt(getConTotal));
      }

      $(".imgButton").click(function(){
    	  calculateSummary();
      });
    </script>