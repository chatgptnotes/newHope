<style>
td {
	font-size: 13px;
}
.cost-holder{
   width:80%;
}

</style>

<?php
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
<?php   if(!empty($errors)) { ?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
				foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
			</div>
		</td>
	</tr>
</table>
<?php } ?>
<div class="inner_title">
	<h3>
		<?php echo $tariffStandardsData['TariffStandard']['name']; ?>
	</h3>
	<span> <?php 			
	echo $this->Html->link(__('Back'),array('action'=>'viewTariffAmount'),array('escape' => false,'class'=>'blueBtn')) ;
	?>
	</span>
</div>
<div></div>
<table width="100%" align="right" cellpadding="0" cellspacing="0"
	border="0">

	<tr>
		<td colspan="3"><input type="radio" id="servicesSearchBtn"
			name="billtype" checked="checked" autocomplete="off"
			class="tariff-opt" /> Search Services
			 <input type="radio"
			id="servicesAllBtn" name="billtype" autocomplete="off"
			class="tariff-opt" /> All Services </td>

	</tr>
	<tr id="tariff-opt-area">
		<?php echo $this->Form->create('',array('url'=>array('action'=>'tariffListOptions',$tariffStandardId), 'id'=>'servicefrm','inputDefaults' => array(
				'label' => false,
				'div' => false,
				'error' => false
		)));
		?>
		<td align="left" width="100">Service:</td>
		<td align="left" width="150"><?php echo $this->Form->input('', array('name'=>'service_name','type'=>'text','id' => 'search_service_name','style'=>'width:250px;','autocomplete'=>'off')); ?>
		</td>
		<td align="left" width="100">Service Group:</td>
		<td align="left" width="150"><?php echo $this->Form->input('', array('name'=>'service_group','type'=>'text','id' => 'search_service_group','style'=>'width:250px;','autocomplete'=>'off'));
		 echo $this->Form->hidden('',array('id'=>'groupServiceId','name'=>'groupServiceId'));?>

		</td>
		<td align="left"><?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?>
		</td>
		<?php echo $this->Form->end();?>
	</tr>
</table>
<div>&nbsp;</div>
<?php 
echo $this->Form->create('',array('controller'=>'tariffs','action'=>'updateTariffAmount','type' => 'file','id'=>'tariffamount','inputDefaults' => array(
												'label' => false,'div' => false,'error' => false )));
				echo $this->Form->hidden('tariffStandardId', array('value'=>$tariffStandardId));    ?>
				
<div style="text-align: right;padding-bottom: 5px">
<?php if(!empty($data)){ /** false for hiding cancel and submit button */ ?>
	<?php 
          echo $this->Html->link(__('Cancel'),'/tariffs/tariffListOptions',array('escape' => false,'class'=>'grayBtn')) ;
          echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));
		?>

	<?php } ?>
</div>
				
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="serviceGrid">
	<tbody>
<?php   $website=$this->Session->read('website.instance');
if($website=='vadodara'){
$display='none';
$width="8%";
}else{
$display='';
$width="14%";
}
?>
		<?php 
		if(!empty($data)){ ?>
		<tr>
			<!-- <th width="30" style="text-align: center;">I.D.</th> -->
			<th width="40%">Name</th>
		<!--	<th width='<?php echo $width;?>'>Award Amount</th> -->
			<th width='<?php echo $width;?>' style="text-align: center;"><?php echo $tariffStandardsData['TariffStandard']['name'];?>
				MOA Sr. No.</th>
			<?php 
			$nabhType=$this->Session->read('hospitaltype');
                            if($nabhType=='NABH'){?>
			<th width='<?php echo $width;?>' style="text-align: center;display: <?php //echo $display;?>">TARIFF</th>
			<?php }else{?>
			<th width=<?php echo $width;?> style="text-align: center;display: <?php //echo $display;?>">TARIFF</th>
			<?php }?>
            <?php if($website=='vadodara' /*&& $tariffStandardsData['TariffStandard']['id']==$privateID*/){ //by atul for private patietn only ?>
			<th width='<?php echo $width;?>' style="text-align: center;">OPD CHARGE</th>
			<th width='<?php echo $width;?>' style="text-align: center;">GENERAL WARD </th>
			<th width='<?php echo $width;?>' style="text-align: center;">SEMI-SPECIAL WARD </th>
			<th width='<?php echo $width;?>' style="text-align: center;">SPECIAL WARD</th>
			<th width='<?php echo $width;?>' style="text-align: center;">DELUX WARD</th>
			<th width='<?php echo $width;?>' style="text-align: center;">ISOLATION WARD</th>
			<?php }?>
			<!--	<th width='<?php echo $width;?>' style="text-align: center;">Validity</th> -->
			<th style="width: 4%">&nbsp;</th>

			<!-- <th width="100" style="text-align: center;">Apply In a day</th> -->


		</tr>
		<?php } ?>

		<?php
		$t=0;
		foreach($data as $tariff){//replace space in amount
			$t++ ;
			?>
		<tr>
			<!--  <td align="center">1.</td> -->
			<td><?php 
			$newtext = wordwrap($tariff['TariffList']['name'], 100, "<br />", true);
			echo mb_convert_encoding($newtext, 'HTML-ENTITIES', 'UTF-8');
			#echo $this->Form->hidden('', array('name'=>'data[TariffAmount][id][]','value'=>$tariff['TariffList']['id']));
			?>
			</td>

		<!-- 	<td><?php 
			//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][moa_sr_no]",'type'=>'text','value'=>$tariff['TariffAmount']['moa_sr_no'],'class' => 'validate[required,custom[mandatory-date]]'));
			?> <input type="text" id="award_amount-<?php echo $t ; ?>"
				maxlength="3"
				class="validate[optional,custom[onlyNumber]] textBoxExpnd cost-holder"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][award_amount]";?>"
				value="<?php echo $tariff['TariffAmount']['award_amount']=trim(str_replace(',', '', $tariff['TariffAmount']['award_amount']));?>">
			</td> -->
			<td><?php 
			//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][moa_sr_no]",'type'=>'text','value'=>$tariff['TariffAmount']['moa_sr_no'],'class' => 'validate[required,custom[mandatory-date]]'));
			?> <input type="text" class="cost-holder"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][moa_sr_no]";?>"
				id="moa_sr_no-<?php echo $t ; ?>"
				value="<?php echo $tariff['TariffAmount']['moa_sr_no'];?>">
			</td>

			<?php if($nabhType=='NABH'){?>
			<td align="center" style="display: <?php //echo $display;?>"><input type="hidden"
				id="tariff_standard-<?php echo $t ; ?>"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][tariff_standard_id]";?>"
				value="<?php echo $tariffStandardId;?>"> <input type="hidden"
				id="tariff_amount-<?php echo $t ; ?>"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][id]";?>"
				value="<?php echo $tariff['TariffAmount']['id'];?>"> <input
				class="cost-holder validate[optional,custom[onlyNumber]]"
				id="tariff_cost-<?php echo $t ; ?>" type="text"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][nabh_charges]";?>"
				value="<?php echo $tariff['TariffAmount']['nabh_charges']=trim(str_replace(',', '', $tariff['TariffAmount']['nabh_charges']));
			//$this->Number->format($tariff['TariffAmount']['nabh_charges']/*,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)*/);?>">
				<input type="hidden" name="" id="tariff_list-<?php echo $t ; ?>"
				value="<?php echo $tariff['TariffList']['id'];?>">
			</td>
			<?php }else{?>
			<td align="center" style="display: <?php //echo $display;?>"><input type="hidden"
				id="tariff_standard-<?php echo $t ; ?>"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][tariff_standard_id]";?>"
				value="<?php echo $tariffStandardId;?>"> <input type="hidden"
				id="tariff_amount-<?php echo $t ; ?>"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][id]";?>"
				value="<?php echo $tariff['TariffAmount']['id'];?>"> <input
				class="cost-holder" id="tariff_cost-<?php echo $t ; ?>" type="text"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][non_nabh_charges]";?>"
				value="<?php echo $tariff['TariffAmount']['nabh_charges']=trim(str_replace(',', '', $tariff['TariffAmount']['nabh_charges']));
			//$this->Number->format($tariff['TariffAmount']['non_nabh_charges']/*,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)*/);?>">
				<input type="hidden" name="" id="tariff_list-<?php echo $t ; ?>"
				value="<?php echo $tariff['TariffList']['id'];?>">
			</td>
			<?php }?>
			<?php //if($tariffStandardsData['TariffStandard']['name'] != 'Private'){
				?>
           <?php if($website=='vadodara' /*&& $tariffStandardsData['TariffStandard']['id']==$privateID*/){ ?>
				
			<td><?php  echo $this->Form->input('', array('name'=>"data[TariffAmountType][".$tariff['TariffList']['id']."][opd_charge]",'type'=>'text',
					'id' => 'opd_charge-'.$t, 'label'=> false,'class'=>'cost-holder validate[optional,custom[onlyNumber]]','value'=>$tariff['TariffAmountType']['opd_charge']));
			
			echo $this->Form->hidden('', array('name'=>"data[TariffAmountType][".$tariff['TariffList']['id']."][tariff_standard_id]",'type'=>'text',
				'value'=>$tariffStandardId));
           
            echo $this->Form->hidden('', array('name'=>"data[TariffAmountType][".$tariff['TariffList']['id']."][id]",'type'=>'text',
		     'value'=>$tariff['TariffAmountType']['id']));
			
			?></td>	
			
			<td><?php  echo $this->Form->input('', array('name'=>"data[TariffAmountType][".$tariff['TariffList']['id']."][general_ward_charge]",'type'=>'text',
					'id' => 'gen_charge-'.$t, 'label'=> false,'class'=>'cost-holder validate[optional,custom[onlyNumber]]','value'=>$tariff['TariffAmountType']['general_ward_charge']));?></td>	
					
			<td><?php  echo $this->Form->input('', array('name'=>"data[TariffAmountType][".$tariff['TariffList']['id']."][semi_special_ward_charge]",'type'=>'text',
					'id' => 'semi_charge-'.$t, 'label'=> false,'class'=>'cost-holder validate[optional,custom[onlyNumber]]','value'=>$tariff['TariffAmountType']['semi_special_ward_charge']));?></td>	
			
			<td><?php  echo $this->Form->input('', array('name'=>"data[TariffAmountType][".$tariff['TariffList']['id']."][special_ward_charge]",'type'=>'text',
					'id' => 'spcl_charge-'.$t, 'label'=> false,'class'=>'cost-holder validate[optional,custom[onlyNumber]]','value'=>$tariff['TariffAmountType']['special_ward_charge']));?></td>	
			
			<td><?php  echo $this->Form->input('', array('name'=>"data[TariffAmountType][".$tariff['TariffList']['id']."][delux_ward_charge]",'type'=>'text',
					'id' => 'dlx_charge-'.$t, 'label'=> false,'class'=>'cost-holder validate[optional,custom[onlyNumber]]','value'=>$tariff['TariffAmountType']['delux_ward_charge']));?></td>
					
			<td><?php  echo $this->Form->input('', array('name'=>"data[TariffAmountType][".$tariff['TariffList']['id']."][isolation_ward_charge]",'type'=>'text',
					'id' => 'iso_charge-'.$t, 'label'=> false,'class'=>'cost-holder validate[optional,custom[onlyNumber]]','value'=>$tariff['TariffAmountType']['isolation_ward_charge']));?></td>		
			
		 		
<?php }?>
		<td align="center"><?php 
			if($tariff['TariffAmount']['unit_days']!=''){
     	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]",'type'=>'text','value'=>$tariff['TariffAmount']['unit_days'],'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:150px;text-align:right;'));
     ?> <input type="text" id="unit_days-<?php echo $t ; ?>"
				class="cost-holder"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]";?>"
				value="<?php echo $tariff['TariffAmount']['unit_days'];?>"> <?php 	 
     }else{
     	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]",'type'=>'text','value'=>1,'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:150px;text-align:right;'));
     ?> <input type="text" id="unit_days-<?php echo $t ; ?>"
				class="cost-holder"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]";?>"
				value="1"> <?php 		
     }
     ?>
			</td>
			

			<!-- 
     <td align="center">
     <?php 
     if($tariff['TariffAmount']['apply_in_a_day']!=''){
     	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][apply_in_a_day]",'type'=>'text','value'=>$tariff['TariffAmount']['apply_in_a_day'],'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:150px;text-align:right;'));
	?>
	<input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][apply_in_a_day]";?>" value="<?php echo $tariff['TariffAmount']['apply_in_a_day'];?>">
  	<?php    	
     }else{
     	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][apply_in_a_day]",'type'=>'text','value'=>1,'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:150px;text-align:right;'));
     ?>
     <input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][apply_in_a_day]";?>" value="1">
     <?php 		
     }
     ?>
     </td>
      -->
			<!-- <td align="center">
     <?php 
   // echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][apply_in_a_day]",'type'=>'text','value'=>$tariff['TariffAmount']['apply_in_a_day'],'class' => 'validate[required,custom[mandatory-date]]'));
    ?>
     </td>-->
			<?php// }?>
			<td style="width: 4%"><?php $checkUpList = Configure::read('OPCheckUpOptions');unset($checkUpList['RegistrationCharges']);
			if(array_key_exists($tariff['TariffList']['code_name'], $checkUpList)){
				echo $this->Html->link($this->Html->image('icons/mar_icon/arm_clock.png'),array('action' => 'tariffCharges',$tariffStandardId,$tariff['TariffList']['id']), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
			}?>
			</td>

		</tr>
		<?php }?>


	</tbody>
</table>
<div id="pageNavPosition" align="center"></div>
<div>&nbsp;</div>
<?php if(!empty($data)){ /** false for hiding cancel and submit button */ ?>
<div class="btns">
	<?php 
	echo $this->Html->link(__('Cancel'),
		 			                       '/tariffs/tariffListOptions',array('escape' => false,'class'=>'grayBtn')) ;
		 		echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));
		 		?>
</div>
<?php } ?>
<?php  echo $this->Form->end(); ?>

<!-- billing activity form end here -->
<div>&nbsp;</div>
<script> 
	$(document).ready(function(){
		
		
		if ($.browser.mozilla) $('#servicesSearchBtn #servicesAllBtn').attr("autocomplete", "off");

		$("#servicesAllBtn").click(function(){
			window.location.href = "<?php echo $this->Html->url(array('action'=>'editTariffAmount',$tariffStandardId)); ?>";
		});

		$(".tariff-opt").change(function(){
			$("#tariff-opt-area").toggle();
		});
	});
	
	
	   
	$(function() {
		$("#search_service_name").autocomplete("<?php echo $this->Html->url(array("controller" => "tariffs", "action" => "autocomplete","TariffList","name",'null','null','null', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true 
			});

		$("#search_service_group").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","ServiceCategory","id",'alias','null','null', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			loadId : 'name,groupServiceId',
			showNoId:true,
			valueSelected:true,
			});
	});

	$(function(){
		var role="<?php echo  $this->Session->read('role'); ?>";

		if(role=='Front Office Executive'){
		$('#tariffamount input').attr('readonly', 'readonly');
		}

	});
	
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#tariffamount").validationEngine();
		//for ajax update  
		$(".cost-holderREMOVED").on("blur",function(){
				 /*obj = $(this); 
				 $(obj).attr("src",'<?php echo $this->Html->url("/img/ajax-loader.gif");?>');
				 var id = $(obj).attr('id');
				 $("#div_"+id).html("<img src='<?php echo $this->Html->url("/img/ajax-loader.gif");?>'>") ;*/
				 selID = $(this).attr('id').split("-")[1];
				 tariff_list_id= $("#tariff_list-"+selID).val(); 
				 tariff_standard_id= $("#tariff_standard-"+selID).val(); 
				 tariff_amount_id= $("#tariff_amount-"+selID).val();  
				 tariff = $("#tariff_cost-"+selID).val() ;

				 awardAmount = $("#award_amount-"+selID).val() ;
				 moaSrNo = $("#moa_sr_no-"+selID).val() ;
				 opdCharge = $("#opd_charge-"+selID).val() ;
				 genCharge = $("#gen_charge-"+selID).val() ;
				 spclCharge = $("#spcl_charge-"+selID).val() ;
				 dlxCharge = $("#dlx_charge-"+selID).val() ;
				 semiCharge = $("#semi_charge-"+selID).val() ;
				 isoCharge = $("#iso_charge-"+selID).val() ;
				 unitDays = $("#unit_days-"+selID).val() ;
				 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Tariffs", "action" => "ajaxChargeUpdate","admin" => false)); ?>";
				 $.ajax({
					  type: "POST",
					  url: ajaxUrl,
					  data: "unitDays="+unitDays+"&moaSrNo="+moaSrNo+"&awardAmount="+awardAmount+"&cost="+tariff+"&id="+tariff_amount_id+"&tariff_standard_id="+tariff_standard_id+
					        "&tariff_list_id="+tariff_list_id+"&opd_charge="+opdCharge+"&gen_charge="+genCharge+"&spcl_charge="+spclCharge+"&dlx_charge="+dlxCharge+"&semi_charge="+semiCharge+"&iso_charge="+isoCharge,	
					  success: function(data){
						  $("#tariff_amount-"+selID).val(data);
							/*if(data){
								inlineMsg(id,'Done');
								$("#div_"+id).html('');
							} */ 
					 }
			 }); 
		});
	});

	$('#award_amount').keyup(function(){
		var currVal=$(this).val();
		if(currVal>100){
			alert('Please enter a number between 1 - 100');
			$(this).val('');
		}  
		});

</script>
