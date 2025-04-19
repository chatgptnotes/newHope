<script>
function copyStandards(){
document.copyStandard.action="<?php echo $this->Html->url('copyTariffAmount');?>";
document.copyStandard.submit();	
}
</script>
<?php
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>

<script>
	$(document).ready(function(){
		<?php if(!empty($data)) { ?>
//		var pager = new Pager('serviceGrid', 20); 
//		pager.init(); 
//		pager.showPageNav('pager', 'pageNavPosition'); 
//		pager.showPage(1);
		<?php } ?>
		
		if ($.browser.mozilla) $('#servicesSearchBtn #servicesAllBtn').attr("autocomplete", "off");

		$("#servicesAllBtn").click(function(){
			window.location.href = "<?php echo $this->Html->url(array('action'=>'editTariffAmount',$tariffStandardId)); ?>";
		});

		$(".tariff-opt").change(function(){
			$("#tariff-opt-area").toggle();
		});
	});
	
	
	   
	$(function() {
		$("#search_service_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","name",'null','null','null', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
	});
</script> 
<div class="message" id="flashMessage" style="display: none;">Updated Successfully</div>
<div class="inner_title">
		<h3>
			<?php echo __($title_for_layout, true); ?>
		</h3>  

<?php 
echo $this->Form->create('',array('name'=>'copyStandard','controller'=>'tariffs','action'=>'copyTariffAmount','type' => 'file','id'=>'tariffamount','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )));
?>
<div align="center" id='temp-busy-indicator' style="display: none;">
				&nbsp;
				<?php echo $this->Html->image('indicator.gif', array()); ?>
			</div>	
<table width="100%" cellspacing="1" cellpadding="0" border="0" style="margin-bottom:10px;border-bottom: 1px solid #4C5E64;">
<tr><td><strong><?php echo $tariffStandardsData['TariffStandard']['name'];?></strong></td>
<td>&nbsp;</td>
<td align="right">
<?php echo $this->Form->input('TariffStandard.standardName', array('onchange'=>'copyStandards()','style'=>'width:160px','empty'=>'Please Select','options'=>$tariffStandards,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'tariffstandard')); ?>
<?php //echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
</tr>
</table>
 <?php 
 echo $this->Form->hidden('TariffList.tariffStandardId', array('value'=>$tariffStandardId));
 echo $this->Form->hidden('tariffStandardId', array('value'=>$tariffStandardId));
 echo $this->Form->end();?>
 
<table width="100%" align="right" cellpadding="0" cellspacing="0"
	border="0">
	<tr>
			<td colspan="2">
				 
				<input type="radio" id="servicesSearchBtn" name="billtype" onclick='window.location.href="<?php echo $this->Html->url(array('action'=>'tariffListOptions',$tariffStandardId)) ?> " ;'   autocomplete="off" class="tariff-opt"/> 
				 
				Search Services
				<input type="radio" id="servicesAllBtn" name="billtype"   checked="checked" autocomplete="off" class="tariff-opt"/> 
				All Services
			</td>
		 
	</tr>
	<tr id="tariff-opt-area" style="display:none;">
		<?php       echo $this->Form->create('',array('url'=>array('action'=>'tariffListOptions',$tariffStandardId),'id'=>'servicefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
		)));
		?>
		<td align="left" width="100">Service:</td>
		<td align="left" width="150"><?php echo $this->Form->input('', array('name'=>'service_name','type'=>'text','id' => 'search_service_name','style'=>'width:150px;','autocomplete'=>'off')); ?></td>
		<td align="left"><?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
		<?php echo $this->Form->end();?>
	</tr>
</table>
	
<div>&nbsp;</div>
<?php 
	echo $this->Form->create('',array('controller'=>'tariffs','action'=>'updateTariffAmount','type' => 'file','id'=>'tariffamount','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )));
	echo $this->Form->hidden('tariffStandardId', array('value'=>$tariffStandardId));
																								    ?>

    <div class="btns" style="display: none;">
               		<?php 
                           	echo $this->Html->link(__('Cancel'),
					 			                       '/tariffs/viewTariffAmount',array('escape' => false,'class'=>'grayBtn')) ;
					 		echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));
					 		?>		
	</div>
<div>&nbsp;</div>

<table width="100%" cellspacing="1" cellpadding="0" border="0" class="tabularForm">
                    	<tbody><tr>
                        	<!-- <th width="30" style="text-align: center;">I.D.</th> -->
                            <th width="70%" >Name</th>
                            <th width="10%" style="text-align: center;"><?php echo $tariffStandardsData['TariffStandard']['name'];?> MOA Sr. No.</th>
                            <?php 
                            $nabhType=$this->Session->read('hospitaltype');
                            if($nabhType=='NABH'){?>
                            <th width="10%" style="text-align: center;">NABH</th>
                            <?php }else{?>
                            <th width="10%" style="text-align: center;">Non NABH</th>
                            <?php }?>
                            <th width="10%" style="text-align: center;">Validity</th>
                            <!-- <th width="100" style="text-align: center;">Apply In a day</th> -->
                        </tr>
                        
 <?php 
 
  $t=0;
 foreach($data as $tariff){

		 $tariff['TariffAmount'] = $resetAmtArray[$tariff['TariffList']['id']]['TariffAmount'] ; 
		  
  ?>                       
                   		<tr>
                   		 <!--  <td align="center">1.</td> -->
                          <td><?php 
						echo	$newtext = wordwrap($tariff['TariffList']['name'], 100, "<br />", true);
                          //echo mb_convert_encoding($newtext, 'HTML-ENTITIES', 'UTF-8');
        #echo $this->Form->hidden('', array('name'=>'data[TariffAmount][id][]','value'=>$tariff['TariffList']['id']));
                          ?></td>
                          
    <td>
    <?php 
    //echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][moa_sr_no]",'type'=>'text','value'=>$tariff['TariffAmount']['moa_sr_no'],'class' => 'validate[required,custom[mandatory-date]]'));
    ?>
    <input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][moa_sr_no]";?>" id="moa_sr_no-<?php echo $t ; ?>"
    class="cost-holder" value="<?php echo $tariff['TariffAmount']['moa_sr_no'];?>" style="width:80px;">
    </td>                      
                          
  	<?php 
		
 
	if($nabhType=='NABH'){?>
			<td align="center"><input type="hidden" id="tariff_standard-<?php echo $t ; ?>"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][tariff_standard_id]";?>"
				value="<?php echo $tariffStandardId;?>"> 
				<input type="hidden" id="tariff_amount-<?php echo $t ; ?>"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][id]";?>"
				value="<?php echo $tariff['TariffAmount']['id'];?>">
				<input class="cost-holder" id="tariff_cost-<?php echo $t ; ?>"
				type="text"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][nabh_charges]";?>"
				value="<?php echo $this->Number->format($tariff['TariffAmount']['nabh_charges'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>">
				<input type="hidden" name="" id="tariff_list-<?php echo $t ; ?>" value="<?php echo $tariff['TariffList']['id'];?>">
			</td>
			<?php }else{?>
			<td align="center">
				<input type="hidden" id="tariff_standard-<?php echo $t ; ?>"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][tariff_standard_id]";?>"
				value="<?php echo $tariffStandardId;?>"> 
				
				<input type="hidden" id="tariff_amount-<?php echo $t ; ?>"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][id]";?>"
				value="<?php echo $tariff['TariffAmount']['id'];?>"> 
				
				<input class="cost-holder" id="tariff_cost-<?php echo $t ; ?>"
				type="text"
				name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][non_nabh_charges]";?>"
				value="<?php echo $this->Number->format($tariff['TariffAmount']['non_nabh_charges'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>">
				<input type="hidden" name="" id="tariff_list-<?php echo $t ; ?>" value="<?php echo $tariff['TariffList']['id'];?>">
			</td>
			<?php }?>
     <td align="center">
     <?php 
     if($tariff['TariffAmount']['unit_days']!=''){
     	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]",'type'=>'text','value'=>$tariff['TariffAmount']['unit_days'],'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:150px;text-align:right;'));
     ?>
    <input type="text"   name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]";?>" id="unit_days-<?php echo $t ; ?>"
     value="<?php echo $tariff['TariffAmount']['unit_days'];?>" style="width:80px;" class="cost-holder"> 
     <?php 	 
     }else{
     	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]",'type'=>'text','value'=>1,'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:150px;text-align:right;'));
     ?>
     <input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]";?>"
     class="cost-holder" value="1" style="width:80px;" id="unit_days-<?php echo $t ; ?>">
     <?php 		
     }
     ?>
     </td>
     <!-- 
     <td align="center">
     <?php 
     if($tariff['TariffAmount']['apply_in_a_day']!=''){
     	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][apply_in_a_day]",'type'=>'text','value'=>$tariff['TariffAmount']['apply_in_a_day'],'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:150px;text-align:right;'));
	?>
	<input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][apply_in_a_day]";?>" value="<?php echo $tariff['TariffAmount']['apply_in_a_day'];?>" >
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
     
               		  </tr>
 <?php $t++;
 					  
					  }?>    
 
 
                   </tbody></table>
          <?php 
					 		
					 		?>		
                    <div class="btns" style="display: none;">
               		<?php 
                           	echo $this->Html->link(__('Cancel'),
					 			                       '/tariffs/viewTariffAmount',array('escape' => false,'class'=>'grayBtn')) ;
					 		echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));
					 		?>		
</div>
  <?php echo $this->Form->end();?>  
 <script>
 $(document).ready(function(){
	//for ajax update  
		$(".cost-holder").live("blur",function(){
			  
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
				 unitDays = $("#unit_days-"+selID).val() ;
				 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Tariffs", "action" => "ajaxChargeUpdate","admin" => false)); ?>";
				 $.ajax({
					  type: "POST",
					  url: ajaxUrl,
					  beforeSend:function(data){
			    			$('#busy-indicator').show('fast');
				  		  },
					  data: "unitDays="+unitDays+"&moaSrNo="+moaSrNo+"&awardAmount="+awardAmount+"&cost="+tariff+"&id="+tariff_amount_id+"&tariff_standard_id="+tariff_standard_id+"&tariff_list_id="+tariff_list_id,	
					  success: function(data){
						  $("#tariff_amount-"+selID).val(data);
						  $('#flashMessage').fadeIn();
						  $('#flashMessage').delay(2000).fadeOut('slow');
					 },
					  complete:  function(data){
						  
				    		$('#busy-indicator').hide('');
				  		  },
			 }); 
		});
 });
 </script>