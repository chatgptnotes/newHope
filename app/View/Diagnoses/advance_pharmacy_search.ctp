<?php echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');?>
<style>
.tddate img {
	float: inherit;
}
.pointer{
	cursor: pointer;
	}
</style>
<div class="inner_title">
	<h3 style="margin-left:10px;">
		&nbsp;
		<?php echo __('Advance Pharmacy Search', true); ?>
	</h3>
</div><?php 
if($status == "success"){?>
		<script> 
			jQuery(document).ready(function() { 
			//parent.location.reload(true);
			parent.$.fancybox.close(); 
		});
		</script>
<?php }?>

<?php 	echo $this->Form->create('PharmacyMaster',array('url'=>array('controller'=>'Diagnoses','action'=>'advancePharmacySearch'),'id'=>'AdvancePharmacySearch','type'=>'get', 'inputDefaults' => array('label' => false,'div' => false)));
//echo $this->Form->hidden('id');
//echo $this->Form->hidden('NewCropAllergies.uId',array('id'=>'uId','value'=>$uId));
?>

<div border="1" class="table_format" style="background: lightgray;float:left;border:1px solid #000;margin-left:70px;margin-top:10px;width:85%;">
	<div style="width:400px; float:left;margin-left:80px;">
		<div width="2%" style="font-size: 13px; float:left; width:110px; margin-bottom:10px;"><?php echo __('Address Line 1 :');?></div>
		<div width="30%" style="float:left;"><?php echo $this->Form->input('address',array('style'=>'width:200px','class' => 'search','id' => 'address', 'label'=> false, 'div' => false , 'error' => false , 'autocomplete'=>false));?></div>

		<div style="font-size: 13px; float:left;width:110px; margin-bottom:10px; clear:left;"><?php echo __('Zip :');?></div>
		<div width="30%" style="float:left;"><?php echo $this->Form->input('zip',array('style'=>'width:200px','placeholder'=>'6 digit','class' => 'search','id' => 'zip', 'label'=> false, 'div' => false , 'error' => false , 'autocomplete'=>false));?></div>
		
		<div style="font-size: 13px; float:left; clear:left;width:110px; margin-bottom:10px;"><?php echo __('Phone :');?></div>
		<div width="30%" style="float:left;"><?php echo $this->Form->input('phone',array('style'=>'width:200px','placeholder'=>'10 digit','class' => 'search','id' => 'phone', 'label'=> false, 'div' => false , 'error' => false , 'autocomplete'=>false));?></div>
	
    	<div style="font-size: 13px; float:left; clear:left;width:110px; margin-bottom:10px;"><?php echo __('City :');?></div>
		<div width="30%" style="float:left;"><?php echo $this->Form->input('city',array('style'=>'width:200px','class' => 'search','id' => 'city', 'label'=> false, 'div' => false , 'error' => false , 'autocomplete'=>false));?></div>
        
        <div style="font-size: 13px; float:left; clear:left;width:110px; margin-bottom:10px;"><?php echo __('State Code :');?></div>
		<div width="30%" style="float:left;"><?php echo $this->Form->input('state',array('style'=>'width:200px','class' => 'search','id' => 'state', 'label'=> false, 'div' => false , 'error' => false , 'autocomplete'=>false));?></div>
		
		<div style="font-size: 13px; float:left; clear:left;width:110px; margin-bottom:10px;"><?php echo __('fax :');?></div>
		<div width="30%" style="float:left;"><?php echo $this->Form->input('fax',array('style'=>'width:200px','class' => 'search','id' => 'fax', 'label'=> false, 'div' => false , 'error' => false , 'autocomplete'=>false));?></div>
	
		<div class="row_format" style="float:left; margin-top:40px;">
		<?php echo $this->Form->submit(__('Search'), array('id'=>'submit','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));?>
		<?php echo $this->Html->link(__('Reset'),'#', array('id'=>'reset','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn', 'style'=>'padding-bottom:4px; text-decoration:none' ));?></div>
	</div>
</div>
<div class="inner_title" style="float:left;width:100%;padding:10px 0!important;"></div>
<?php echo $this->Form->end();?>

<?php 
 
 if(count($allData)!=0) { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="margin-left: -32px">
	<tr>
		<td width='80px'></td>
		<td valign='top'></td>
	</tr>
	<!--  <tr><td width='20px'></td><td style="padding-left:17px">All Allergies</td></tr>-->
	<tr>
		<td width='20px'></td>
		<td>
			<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="97%">
				<tr>
				<td colspan="10" ><font color="red">* Please click on pharmacy name to select pharmacy.</font></td>
				</tr>
				<?php   $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				 		$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
				?>
				<tr class="row_title">
					<td class="table_cell"><strong>Sr. #</strong></td>
					<td class="table_cell"><strong><?php echo $this->Paginator->sort('PharmacyMaster.Pharmacy_StoreName', __('Pharmacy Name', true)); ?>
					</strong></td>
					<td class="table_cell"><strong>Pharmacy_NCPDP</strong></td>
					<td class="table_cell"><strong>Pharmacy Address</strong></td>
					<td class="table_cell"><strong>Telephone</strong></td>
					<td class="table_cell"><strong>Fax</strong></td>
					<td class="table_cell"><strong>City</strong></td>
					<td class="table_cell"><strong>State Code</strong></td>
					<td class="table_cell"><strong>Zip</strong></td>
				</tr>
				<?php 
				$pageCnt = $this->params['paging']['PharmacyMaster']['page'] ;
				if($pageCnt==1){
					$count = 0 ;
				}else{
					$count= ($pageCnt-1) * 10 ;
				}
				
				$toggle =0;
				$cnt_comm = 0;
				for($counter=0;$counter< count($allData);$counter++){
					if($toggle == 0) {
							echo "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							echo "<tr>";
							$toggle = 0;
						}
				$count++;$cnt_comm++;
				?>
					<td class="row_format">&nbsp;<?php echo $count; ?></td>
					<td class="row_format pharmacy pointer" id="pharmacy_<?php echo $counter?>"><?php echo $allData[$counter]['PharmacyMaster']['Pharmacy_StoreName'];?></td>
					<td class="row_format " id="pharmacy_id_<?php echo $counter?>"><?php echo $allData[$counter]['PharmacyMaster']['Pharmacy_NCPDP'];?></td>
					<?php if(!empty($allData[$counter]['PharmacyMaster']['Pharmacy_Address2'])){$space=', ';}else{$space='';}?>
					<td class="row_format" id="addr_<?php echo $counter?>"><?php echo $allData[$counter]['PharmacyMaster']['Pharmacy_Address1'].''.$space.''.	$allData[$counter]['PharmacyMaster']['Pharmacy_Address2'];?></td>
					<td class="row_format" id="phone_<?php echo $counter?>"><?php echo $allData[$counter]['PharmacyMaster']['Pharmacy_Telephone1'];  ?></td>
					<td class="row_format" id="fax_<?php echo $counter?>"><?php echo $allData[$counter]['PharmacyMaster']['Pharmacy_Fax'];  ?></td>
					<td class="row_format" id="city_<?php echo $counter?>"><?php echo $allData[$counter]['PharmacyMaster']['Pharmacy_City']; ?></td>
					<td class="row_format" id="state_<?php echo $counter?>"><?php echo $allData[$counter]['PharmacyMaster']['Pharmacy_StateAbbr']; ?></td>
					<td class="row_format" id="zip_<?php echo $counter?>"><?php echo $allData[$counter]['PharmacyMaster']['Pharmacy_Zip']; ?></td>
				</tr>
				<?php }   ?>
			</table>
		</td>
	</tr>
	<tr>
		<TD colspan="8" align="center">
				 <!-- Shows the page numbers -->
			 <?php 
			 
			 
			 echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			 <!-- Shows the next and previous links -->
			 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			 <!-- prints X of Y, where X is current page and Y is number of pages -->
			 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
			 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			 
		</TD>
	</tr>
</table>
<?php }?>
<?php if(count($allData)==0){?>
<div align="center" style="clear:both; width:100%;">
	<div>
		<div text-align="center" style="color: red; font-size:13px;background: lightgray;"><?php echo "No Record Found." ?></div>
	</div>
</div>
<?php }?>
<script>
$('.pharmacy').click(function(){
	
	currentId=$(this).attr('id');
	splittedVar = currentId.split("_");		 
	Id = splittedVar[1];
	
	pharmacy=$('#'+currentId).html();
	pharmacy_id=$('#pharmacy_id_'+Id).html();

	addr=$('#addr_'+Id).html();
	phone=$('#phone_'+Id).html();
	fax=$('#fax_'+Id).html();
	city=$('#city_'+Id).html();
	state=$('#state_'+Id).html();
	zip=$('#zip_'+Id).html();
	
	$( '#pharmacy_value', parent.document ).val(pharmacy);
	$( '#pharmacy_id', parent.document ).val(pharmacy_id);

	$( '#address', parent.document ).html(addr);
	$( '#phone', parent.document ).html(phone);
	$( '#fax', parent.document ).html(fax);
	$( '#city', parent.document ).html(city);
	$( '#state', parent.document ).html(state);
	$( '#zip', parent.document ).html(zip);
	$( '#adv_pharmacy', parent.document ).show();
	parent.$.fancybox.close();
});

$('#reset').click(function(){
	$( ".search" ).each(function() {
		$(this).val("");
	});
});

</script>
