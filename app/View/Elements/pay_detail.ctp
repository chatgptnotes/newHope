<style>
.preLink {
	color: indigo !important;
}
</style>

<?php 
$count = count($payDetailDate);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	
	<tr>
		<th style="padding-left: 10px;" colspan="4"><?php echo __('Pay Detail');?>
		</th>
	</tr>
	<tr>
	  <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	
					<tr>
			<td class="tdLabel">Applicable From</td>
			<?php $currentDate =  $this->DateFormat->formatDate2Local($earnindAndDeduction[0]['EmployeePayDetail']['pay_application_date'],Configure::read('date_format'),false);?>
			<td><?php 
			$date = $currentDate ? $currentDate : $this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false);
			echo $this->Form->input('HrDetail.pay_application_date',array('type'=>'text','value'=>$date,'class'=>'textBoxExpnd','id'=>'pay_application_date','readonly' => 'readonly' ));?>
				<span align=left> <?php if($count){
					echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
								'alt'=> __('Add', true),'class'=>'hideRow','id'=>'addMore','style'=>"float:none;",'onClick'=>"add();"));
	                    } ?>
			</span></td>
			<?php if($count){ ?>
			<td>	<div style="background-color: #DDDDDD; max-width: 65%;overflow-x: scroll; overflow-y:hidden;white-space: nowrap; ">
		<?php  foreach($payDetailDate as $payDate){
								  	 $date = $this->DateFormat->formatDate2Local($payDate['EmployeePayDetail']['pay_application_date'],Configure::read('date_format'),false);
								  	 echo $this->Html->link($date,'#',array('onClick'=>"showData('".$date."','".$payDate['EmployeePayDetail']['pay_application_date']."','".$payDate['EmployeePayDetail']['user_salary']."');" ,'id'=>'payDetailDate_'.$date,'escape' => false,'label'=>false,'div'=>false)).'&nbsp';
	 						    }
			}
			?></div> </td>
			</tr>
			<tr><td class="tdLabel">Salary</td>
			<td>
			<?php echo $this->Form->input('HrDetail.user_salary',array('type'=>'text','value'=>$payDetailDate[0]['EmployeePayDetail']['user_salary'],'class'=>'textBoxExpnd','id'=>'amount','style'=>"width:150px;"));?>
			</td></tr>
		</table>
     </td>
	</tr>
<!-- 	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				class="forDoctor" style='display: none;' class="formFull">

				<tr>
					<td width="21%" class="tdLabel">&nbsp;</td>
					<td width="30%">
						<table width="189%" cellspacing="0" cellpadding="0" border="0"
							style="margin-left: 16px;">
							<tr>
								<th style="padding-left: 10px;">Type of payment</th>
								<th style="padding-left: 10px;">Amount-Day time</th>
								<th style="padding-left: 10px;">Amount - Night time</th>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="21%" class="tdLabel"><i style="font-weight: Bold">Earnings</i>
					</td>
					<td width="30%">&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td width="21%" class="tdLabel">
						<table width="197%" border="0" cellspacing="0" cellpadding="0"
							class="formFull">
							<?php $recordEarningDoctor = false;?>
							<?php foreach($earnindAndDeduction as $earning){?>
							<?php $eraningId = $earning['EarningDeduction']['id'];?>

							<?php if(strtolower($earning['EarningDeduction']['type']) != 'earning' || !$earning['EarningDeduction']['is_doctor']) continue;
							//if($earning['EmployeePayDetail']['pay_application_date'] == $earnindAndDeduction[0]['EmployeePayDetail']['pay_application_date']) continue;?>
							<?php $recordEarningDoctor = true;?>
							<?php echo $this->Form->hidden("EmployeePayDetail.$eraningId.id",array('value'=>$earning['EmployeePayDetail']['id'],'class'=>'DoctorPayDetail DoctorPayDetails'));?>
							<?php echo $this->Form->input("EmployeePayDetail.$eraningId.is_applicable",array('type'=>'hidden','value'=>'1','class'=>'DoctorPayDetail')); ?>
							<?php if($earning['EarningDeduction']['is_ward_service']){?>
							<tr>
								<td width="21%" class="tdLabel"><?php echo $earning['EarningDeduction']['name'];
								echo $this->Form->hidden("EmployeePayDetail.$eraningId.earning_deduction_id",array('value'=>$earning['EarningDeduction']['id'],'class'=>'DoctorPayDetail'));?>
								</td>
								<td width="21%" class="tdLabel"><?php echo $this->Form->hidden("EmployeePayDetail.$eraningId.service_category_id",array('value'=>$earning['EarningDeduction']['service_category_id'],'class'=>'DoctorPayDetail'));?>&nbsp;</td>
								<td width="21%" class="tdLabel">&nbsp;</td>
							</tr>
							<?php $earningWard  = unserialize($earning['EmployeePayDetail']['ward_charges']);?>
							<?php foreach($wards as $key => $wardList){?>
							<tr>
								<td width="21%" class="tdLabel">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $wardList?>
								</td>
								<td width="21%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$eraningId.ward_charges.$key.day_amount",
										array('type'=>'text','class'=>'textBoxExpnd DoctorPayDetail DoctorPayDetails','value'=>$earningWard[$key]['day_amount'] ));?>
								</td>
								<td width="21%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$eraningId.ward_charges.$key.night_amount",
										array('type'=>'text','class'=>'textBoxExpnd DoctorPayDetail DoctorPayDetails','value'=>$earningWard[$key]['night_amount'] ));?>
								</td>
							</tr>
							<?php }?>
							<?php }else{?>
							<tr>
								<td width="21%" class="tdLabel"><?php echo $earning['EarningDeduction']['name'];
								echo $this->Form->hidden("EmployeePayDetail.$eraningId.service_category_id",array('value'=>$earning['EarningDeduction']['service_category_id'],'class'=>'DoctorPayDetail'));
								echo $this->Form->hidden("EmployeePayDetail.$eraningId.earning_deduction_id",array('value'=>$earning['EarningDeduction']['id'],'class'=>'DoctorPayDetail'));?>
								</td>
								<td width="21%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$eraningId.day_amount",
										array('type'=>'text','class'=>'textBoxExpnd DoctorPayDetail DoctorPayDetails','value'=>$earning['EmployeePayDetail']['day_amount'] ));?>
								</td>
								<td width="21%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$eraningId.night_amount",
										array('type'=>'text','class'=>'textBoxExpnd DoctorPayDetail DoctorPayDetails','value'=>$earning['EmployeePayDetail']['night_amount'] ));?>
								</td>
							</tr>
							<?php }?>
							<?php }?>
							<?php if(!$recordEarningDoctor){ ?>
							<tr>
								<td width="21%" class="tdLabel" colspan="2"><?php echo __('No Records Found.'); ?>
								</td>
							</tr>
							<?php } ?>
						</table>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="21%" class="tdLabel"><i style="font-weight: Bold">Deductions</i>
					</td>
					<td width="30%">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td width="21%" class="tdLabel">
						<table width="197%" border="0" cellspacing="0" cellpadding="0"
							class="formFull">
							<?php  $recordDeductionDoctor = false;?>
							<?php foreach($earnindAndDeduction as $deduction){ ?>
							<?php $deductionId = $deduction['EarningDeduction']['id'];?>

							<?php if(strtolower($deduction['EarningDeduction']['type']) != 'deduction' || !$deduction['EarningDeduction']['is_doctor']) continue;
							//if($deduction['EmployeePayDetail']['pay_application_date'] == $earnindAndDeduction[0]['EmployeePayDetail']['pay_application_date']) continue;?>
							
							<?php $recordDeductionDoctor = true;?>
							<?php echo $this->Form->input("EmployeePayDetail.$deductionId.is_applicable",array('type'=>'hidden','value'=>'1','class'=>'DoctorPayDetail')); ?>
							<?php echo $this->Form->hidden("EmployeePayDetail.$deductionId.id",array('value'=>$deduction['EmployeePayDetail']['id'],'class'=>'DoctorPayDetail DoctorPayDetails'));?>
							<tr>
								<td width="21%" class="tdLabel"><?php echo $deduction['EarningDeduction']['name'];
								echo $this->Form->hidden("EmployeePayDetail.$deductionId.service_category_id",array('value'=>$deduction['EarningDeduction']['service_category_id'],'class'=>'DoctorPayDetail'));
								echo $this->Form->hidden("EmployeePayDetail.$deductionId.earning_deduction_id",array('value'=>$deduction['EarningDeduction']['id'],'class'=>'DoctorPayDetail'));?>
								</td>
								<td width="21%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$deductionId.day_amount",
										array('type'=>'text','class'=>'textBoxExpnd DoctorPayDetail DoctorPayDetails','value'=>$deduction['EmployeePayDetail']['day_amount'] ));?>
								</td>
								<td width="21%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$deductionId.night_amount",
										array('type'=>'text','class'=>'textBoxExpnd DoctorPayDetail DoctorPayDetails','value'=>$deduction['EmployeePayDetail']['night_amount'] ));?>
								</td>
							</tr>
							<?php }?>
							<?php if(!$recordDeductionDoctor){ ?>
							<tr>
								<td width="21%" class="tdLabel" colspan="2"><?php echo __('No Records Found.'); ?>
								</td>
							</tr>
							<?php } ?>
						</table>
					</td>
					<td>&nbsp;</td>
				</tr>  -->
				<tr><td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0"
				class="forOthers" class="formFull">
				<tr>
					<td width="21%" class="tdLabel">&nbsp;</td>
					<td width="30%">
						<table width="189%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<th style="padding-left: 10px;">Component</th>
								<th style="padding-left: 10px;">Applicable</th>
								<th style="padding-left: 10px;">Amount / Percent</th>
								<th style="padding-left: 10px;">Print in Pay Slip</th>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="21%" class="tdLabel"><i style="font-weight: Bold">Earnings</i>
					</td>
					<td width="30%">&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<table width="190%" border="0" cellspacing="0" cellpadding="0"
							class="formFull">
							<tr>
								<?php $recordFoundearning = false; ?>
								<?php foreach($earnindAndDeduction as $earning){?>
								<?php $earningId = $earning['EarningDeduction']['id'];?>
								<?php if(strtolower($earning['EarningDeduction']['type']) != 'earning' || $earning['EarningDeduction']['is_doctor']) continue;?>
								<?php $recordFoundearning = true;?>
							
							
							<tr>
								<td width="17%" class="tdLabel"><?php echo $earning['EarningDeduction']['name'];
								echo $this->Form->hidden("EmployeePayDetail.$earningId.id",array('value'=>$earning['EmployeePayDetail']['id'],'class'=>'otherPayDetail DoctorPayDetails'));
								echo $this->Form->hidden("EmployeePayDetail.$earningId.service_category_id",array('value'=>$earning['EarningDeduction']['service_category_id'],'class'=>'otherPayDetail'));
								echo $this->Form->hidden("EmployeePayDetail.$earningId.earning_deduction_id",array('value'=>$earning['EarningDeduction']['id'],'class'=>'otherPayDetail'));?>
								</td>
								<td width="11%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$earningId.is_applicable",array('type'=>'checkBox',
										'id'=>"empEarningDed-$earningId",'class'=>'isApplicable otherPayDetail',//'hiddenField'=>false,
										'checked'=>($earning['EmployeePayDetail']['id']) ? $earning['EmployeePayDetail']['is_applicable'] : true)); ?>
								</td>
								<?php $var = ($earning['EmployeePayDetail']['id']) ? $earning['EmployeePayDetail']['is_applicable'] : true;?>
								<?php $display = $var ? 'block' : 'none';?>
								<td width="29%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$earningId.day_amount",array('type'=>'text',
                                    'value'=>$earning['EmployeePayDetail']['day_amount'],'class'=>"textBoxExpnd empEarningDed-$earningId otherPayDetail DoctorPayDetails",'style'=>"display : $display" ));?>
								</td>
								<td width="22%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$earningId.print_in_pay_slip",
										array('type'=>'checkBox','checked'=>$earning['EmployeePayDetail']['print_in_pay_slip'],'hiddenField'=>false,
                                            'class'=>"empEarningDed-$earningId otherPayDetail DoctorPayDetailsChkBox",'style'=>"display : $display"));?>
								</td>
							</tr>
							<?php }?>
							<?php if(!$recordFoundearning){ ?>
							<tr>
								<td width="21%" class="tdLabel" colspan="2"><?php echo __('No Records Found.'); ?>
								</td>
							</tr>
							<?php } ?>
						</table>
					</td>
				</tr>
				<tr>
					<td width="21%" class="tdLabel"><i style="font-weight: Bold">Deductions</i>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<table width="190%" border="0" cellspacing="0" cellpadding="0"
							class="formFull">
							<?php $recordFoundDeduction = false;?>
							<?php foreach($earnindAndDeduction as $earning){?>
							<?php if(strtolower($earning['EarningDeduction']['type']) != 'deduction' || $earning['EarningDeduction']['is_doctor']) continue;?>
							<?php $recordFoundDeduction = true; ?>
							<?php $earningId = $earning['EarningDeduction']['id']; ?>
							<tr>
								<td width="17%" class="tdLabel"><?php echo $earning['EarningDeduction']['name'];
								echo $this->Form->hidden("EmployeePayDetail.$earningId.id",array('value'=>$earning['EmployeePayDetail']['id'],'class'=>'otherPayDetail DoctorPayDetails'));
								echo $this->Form->hidden("EmployeePayDetail.$earningId.service_category_id",array('value'=>$earning['EarningDeduction']['service_category_id'],'class'=>'otherPayDetail'));
								echo $this->Form->hidden("EmployeePayDetail.$earningId.earning_deduction_id",array('value'=>$earning['EarningDeduction']['id'],'class'=>'otherPayDetail'));?>
								</td>
								<td width="11%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$earningId.is_applicable",array('type'=>'checkBox',
										'id'=>"empEarningDed-$earningId",'class'=>'isApplicable otherPayDetail',//'hiddenField'=>false,
                                    'checked'=>($earning['EmployeePayDetail']['id']) ? $earning['EmployeePayDetail']['is_applicable'] : true)); ?>
								</td>
								<?php $var = ($earning['EmployeePayDetail']['id']) ? $earning['EmployeePayDetail']['is_applicable'] : true;?>
								<?php $display = $var ? 'block' : 'none';?>
								<td width="29%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$earningId.day_amount",
										array('type'=>'text','class'=>"textBoxExpnd empEarningDed-$earningId otherPayDetail DoctorPayDetails",'value'=>$earning['EmployeePayDetail']['day_amount'],
                                                'style'=>"display : $display" ));?>
								</td>
								<td width="22%" class="tdLabel"><?php echo $this->Form->input("EmployeePayDetail.$earningId.print_in_pay_slip",array('type'=>'checkBox',
										'checked'=>$earning['EmployeePayDetail']['print_in_pay_slip'],'class'=>"empEarningDed-$earningId otherPayDetail DoctorPayDetailsChkBox",'hiddenField'=>false,
										'style'=>"display : $display"));?>
								</td>
							</tr>
							<?php }?>
							<?php if(!$recordFoundDeduction){ ?>
							<tr>
								<td width="21%" class="tdLabel" colspan="2"><?php echo __('No Records Found.'); ?>
								</td>
							</tr>
							<?php } ?>
						</table>
					</td>
				</tr>
			</table> 
			</td></tr>
			</table>
			<!--  <table>
                <tr>
                    <td width="229" valign="left" id="boxSpace" class="tdLabel"><?php echo __('Signature'); ?></td>
                    <td align="left">
                        <?php /* if($this->data['User']['sign'] != "") {
                                echo $this->Html->image('/signpad/'.$this->data['User']['sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            }  else { ?>
			<div class="sigPad">
				<ul class="sigNav">
					<li class="drawIt"><a href="#draw-it"><font color="#3d3d3d">Draw It</font>
					</a></li>
					<li class="clearButton"><a href="#clear"><font color="#3d3d3d">Clear</font>
					</a></li>
				</ul>
				<div>
                                    <div class="typed"></div>
                                    <canvas class="pad" width="300" height="150"></canvas>
                                    <?php echo $this->Form->input('User.sign', array('type' =>'hidden', 'id' => 'output', 'class' => 'output')); ?>
				</div>
			</div>
                        <?php } */?>
                    </td>
                </tr>
            </table> -->
		</td>
	</tr>
</table>
<script> 
       function add(){ 
             //$("input[type=text], textBox").val("");
             $(".DoctorPayDetails").val("");
             $(".DoctorPayDetailsChkBox").attr('checked',false); 
             $("#pay_application_date").val("");
             $("#amount").val("");
        }
       function showData(date,date1,amt){
    	   $('#pay_application_date').val(date); 
    	   $("#amount").val(amt);
    	   
         var userID = '<?php echo $data['User']['id']?>';
       	$.ajax({
   				  url: "<?php echo $this->Html->url(array("controller" => 'users', "action" => "showEmployeePayDetailData", "admin" => false)); ?>"+"/"+date1+"/"+userID,
   				  context: document.body,	
   				  beforeSend:function(){
   				    // this is where we append a loading image
   				   // $('#busy-indicator').show('fast');
   					}, 	  		  
   				  success: function(data){ 
	   		   			var earningData = jQuery.parseJSON(data);
						$('#busy-indicator').hide();
						$.each(earningData,function(key , value ){
							 $("input[name='data[EmployeePayDetail]["+value.EarningDeduction.id+"][id]']").val(value.EmployeePayDetail.id);         
				             $("input[name='data[EmployeePayDetail]["+value.EarningDeduction.id+"][day_amount]']").val(value.EmployeePayDetail.day_amount);
				             $("input[name='data[EmployeePayDetail]["+value.EarningDeduction.id+"][night_amount]']").val(value.EmployeePayDetail.night_amount);
				             //$("input[name='data[EmployeePayDetail]["+value.EarningDeduction.id+"][day_amount]']").attr('disabled',true);
				             //$("input[name='data[EmployeePayDetail]["+value.EarningDeduction.id+"][night_amount]']").attr('disabled',true);
				             $("input[name='data[EmployeePayDetail]["+value.EarningDeduction.id+"][print_in_pay_slip]']").val(value.EmployeePayDetail.print_in_pay_slip);
				             //$("input[name='data[EmployeePayDetail]["+value.EarningDeduction.id+"][print_in_pay_slip]']").attr('disabled',true);
									$.each(value.EmployeePayDetail.ward_charges,function(wardKey , wardData){
										$("input[name='data[EmployeePayDetail]["+value.EarningDeduction.id+"][ward_charges]["+wardKey+"][day_amount]']").val(wardData.day_amount);
							             $("input[name='data[EmployeePayDetail]["+value.EarningDeduction.id+"][ward_charges]["+wardKey+"][night_amount]']").val(wardData.night_amount);
								});    
						});
   				   }
              });
          }  
$(document).ready(function() {
	 if('<?php echo $count?>' >= 1){ 
    $("#pay_application_date").datepicker({
            showOn: "both",
            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
            buttonImageOnly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1950',
            //maxDate: new Date(),
            dateFormat:'<?php echo $this->General->GeneralDate();?>',		
    });
  }else{ 
    	 $("#pay_application_date").datepicker({
             showOn: "both",
             buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
             buttonImageOnly: true,
             changeMonth: true,
             changeYear: true,
             yearRange: '1950',
             maxDate: new Date(),
             dateFormat:'<?php echo $this->General->GeneralDate();?>',		
     });
 } 
    $('.isApplicable').click(function(){
        var thisId = $(this).attr('id');
        if($(this).is(':checked'))
            $('.'+thisId).show();
        else
            $('.'+thisId).hide();
    });    
});

</script>
