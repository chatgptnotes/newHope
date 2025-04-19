
<table width="100%" cellpadding="0" cellspacing="2" border="0" 	class="tabularForm" id="container-table">
	<thead>
	<tr> 
	    <th width="2%" align="center" valign="top" style="text-align: center;"><input type="checkbox" class="checked_all" id="checked_all" checked="checked"/>All</th>
	    <th width="6%" align="center" valign="top" style="text-align: center;"><?php echo __("Company Name");?></th>
		<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __("Date");?></th>
		<th width="30%" align="center" valign="top"><?php echo __("Particulars");?></th> 
		<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __("Voucher Type");?></th>
		<th width="7%" align="center" valign="top" style="text-align: center;"><?php echo __("Mode Of Payment");?></th>
		<th width="8%" align="center" valign="top" style="text-align: center; "><?php echo __("Voucher No.");?></th> 
		<th width="13%" align="center" valign="top" style="text-align: center;"><?php echo __("Debit");?></th>
		<th width="13%" align="center" valign="top" style="text-align: center; "><?php echo __("Credit");?></th> 
		<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __("View Details");?></th>
	</tr> 
	</thead>
	<tbody>
	<?php echo $this->Form->create('Tally',array('id'=>'post_to_tally_form','method'=>'post'));?>
<?php 
	foreach($data as $key=> $journalData){
?>
<?php $checked = "checked"; 
	if($journalData['VoucherLog']['is_posted'] == 1) {
		echo "<tr class = 'green'>";
		$checked = "";
	}else if($journalData['VoucherLog']['is_posted'] == 2) {
		echo "<tr class = 'red'>";
	}else{
		echo "<tr class='row_gray'>";
}?>
		<td align="center" valign="top" style= "text-align: center;">
			<?php echo $this->Form->input("test.", array('id'=>'voucherUserId_'.$key,"type" => "checkbox","checked"=>$checked,"class"=>"checkbox1 selectCheck",'legend'=>false,
					'name'=>"data[user_id][$key]",'value'=>$journalData['VoucherLog']['id'],"hiddenField"=>false));?>
			<?php echo $this->Form->hidden('',array('disbled'=>'disabled','id'=>'voucherTypeId_'.$key,'name'=>"data[voucher_type][$key]",'value'=>$journalData['VoucherLog']['voucher_type'],'div'=>false,'label'=>false));
                  echo $this->Form->hidden('',array('disbled'=>'disabled','id'=>'voucherId_'.$key,'name'=>"data[voucher_id][$key]",'value'=>$journalData['VoucherLog']['voucher_id'],'div'=>false,'label'=>false));
                  echo $this->Form->hidden('',array('disbled'=>'disabled','id'=>'patientId_'.$key,'name'=>"data[patientId][$key]",'value'=>$journalData['VoucherLog']['patient_id'],'div'=>false,'label'=>false));
                  echo $this->Form->hidden('',array('disbled'=>'disabled','id'=>'postedId_'.$key,'name'=>"data[postedId][$key]",'value'=>$journalData['VoucherLog']['is_posted'],'div'=>false,'label'=>false));?>
		</td>
		<td align="left" valign="top" style= "text-align: left;">
			<?php echo $this->Form->input('',array('name'=>"data[companyName][$key]",'default'=>$this->Session->read('location_name'),'options'=>$location,//$locationArray,
				'id'=>'companyId_'.$key,'label'=>false,'div'=>false,'style'=>'width: 150px;')); ?>
		</td>
		<td align="left" valign="top" style= "text-align: left;">
		<?php $date = $this->DateFormat->formatDate2Local($journalData['VoucherLog']['create_time'],Configure::read('date_format'),true) ;
			echo $date ?>
		</td>
		<td align="left" valign="top" style= "text-align: left;">
			<div style="padding-left:0px;padding-bottom:3px;">
				<?php echo $journalData['Account']['name']; ?>
			</div>
		</td>
		<td align="left" valign="top" style= "text-align: left;">
			<?php echo $journalData['VoucherLog']['voucher_type'] ;?>
		</td>
		<?php if($journalData['VoucherLog']['voucher_type']=='Receipt' || $journalData['VoucherLog']['voucher_type']=='Payment'){?>
		<td align="left" valign="top" style= "text-align: left;">
				<?php echo $journalData['AccountAlias']['name']; ?>
		</td>
		<?php } else {?>
		<td align="left" valign="top" style= "text-align: left;">
				<?php echo " "; ?>
		</td>
		<?php } ?>
		<?php if($this->Session->read('website.instance')=='kanpur' && $journalData['VoucherLog']['voucher_type']=='Receipt' && !empty($journalData['VoucherLog']['patient_id'])){?>
		<td align="left" valign="top" style= "text-align: left;">
			<?php echo $journalData['VoucherLog']['billing_id'] ;?>
		</td>
		<?php }else {?>
		<td align="left" valign="top" style= "text-align: left;">
			<?php echo $journalData['VoucherLog']['voucher_no'] ;?>
		</td>
		<?php }?>
		<?php if($journalData['VoucherLog']['voucher_type']=='Receipt'){ ?>
		<td class="tdLabel"><?php echo " ";?></td>
		<td class="tdLabel">
		<?php 
			echo $this->Number->currency($journalData['VoucherLog']['paid_amount']);
			$viewLink=$this->Html->link($this->Html->image('icons/view-icon.png'),
			array('action' =>'account_receipt',$journalData['VoucherLog']['voucher_id']),
			array('escape' => false,'title' => 'View', 'alt'=>'View','admin'=>false));
		?>
		</td><?php }
		elseif($journalData['VoucherLog']['voucher_type']=='Payment'){?>
		<td class="tdLabel">
		<?php 
			echo $this->Number->currency($journalData['VoucherLog']['paid_amount']);
			$viewLink=$this->Html->link($this->Html->image('icons/view-icon.png'),
			array('action' =>'payment_voucher',$journalData['VoucherLog']['voucher_id']),
			array('escape' => false,'title' => 'View', 'alt'=>'View','admin'=>false));
		?>
		</td>
		<td class="tdLabel"><?php echo " ";?></td>
		<?php }
		elseif($journalData['VoucherLog']['voucher_type']=='Journal' && $journalData['VoucherLog']['type']!='FinalDischarge'){?>
		<td class="tdLabel">
		<?php 
			echo $this->Number->currency($journalData['VoucherLog']['debit_amount']);
			$viewLink=$this->Html->link($this->Html->image('icons/view-icon.png'),
			array('action' =>'journal_entry',$journalData['VoucherLog']['voucher_id']),
			array('escape' => false,'title' => 'View', 'alt'=>'View','admin'=>false));
		?>
		</td>
		<td class="tdLabel"><?php echo " ";?></td>
		<?php } 
		elseif($journalData['VoucherLog']['voucher_type']=='Contra' || $journalData['VoucherLog']['voucher_type']=='Purchase'){?>
		<td class="tdLabel"><?php echo " ";?></td>
		<td class="tdLabel">
		<?php 
			echo $this->Number->currency($journalData['VoucherLog']['debit_amount']);
			$viewLink=$this->Html->link($this->Html->image('icons/view-icon.png'),
			array('action' =>'contra_entry',$journalData['VoucherLog']['voucher_id']),
			array('escape' => false,'title' => 'View', 'alt'=>'View','admin'=>false));
		?>
		</td>
		<?php } 
		elseif($journalData['VoucherLog']['voucher_type']=='Journal' && $journalData['VoucherLog']['type']=='FinalDischarge'){?>
		<td class="tdLabel">
		<?php 
			echo $this->Number->currency($journalData['VoucherLog']['debit_amount']);
			$viewLink=$this->Html->link($this->Html->image('icons/view-icon.png'),
			array('action' =>'patient_journal_voucher',$journalData['VoucherLog']['patient_id']),
			array('escape' => false,'title' => 'View', 'alt'=>'View','admin'=>false));
		?>
		</td>
		<td class="tdLabel"><?php echo " ";?></td>
		<?php } ?>
		<td class="tdLabel">
		 <?php if($journalData['VoucherLog']['voucher_type']=='Journal'){?>
			<?php //echo $viewLink;?>
			<?php }?>
    			<?php //echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'patient_journal_voucher', $journalData['Patient']['id']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete','admin'=>false),__('Are you sure?', true)); ?>
  		<?php echo $this->Form->input("entryPosted.", array('id'=>'entryPosted_'.$key,"type" => "checkbox","checked"=>$checkedPosted,"class"=>"checkboxPosted",'legend'=>false,
					'name'=>"data[entry_posted][$key]",'value'=>$journalData['VoucherLog']['id'],"hiddenField"=>false));?><span id='<?php echo "mgs_".$key;?>'></span>
  		</td>

<?php } ?>
<?php if(empty($data)){ ?>
			    <!-- <tr>			
					<td align="right" valign="top" style= "text-align: left;"  colspan="1">&nbsp;</td>			
					<td align="right" valign="top" style= "text-align: left;"  colspan="1">&nbsp;</td>
					<td align="left" valign="top" style= "text-align: left;"  colspan="1">&nbsp;</td>
					<td align="right" valign="top" style= "text-align: left;"  colspan="1">&nbsp;</td>	
					<td align="right" valign="top" style= "text-align: left;"  colspan="1">&nbsp;</td>	
					<td align="left" valign="top" style= "text-align: right;"  colspan="1"><?php echo $this->Number->currency($totalDebitAmount);?></td>
					<td align="left" valign="top" style= "text-align: right;"  colspan="1"><?php echo $this->Number->currency($totalCreditAmount);?></td>
					<td align="right" valign="top" style= "text-align: left;"  colspan="1">&nbsp;</td>	
				</tr> -->
				<?php } ?>
				<?php echo $this->Form->end();?>
			</tbody>
	</table>
<script>
$(document).ready(function(){
	$("#container-table").freezeHeader({ 'height': '500px' });
});
$(".checkboxPosted").click(function () {
	 var voucherId = $(this).val();
	 var counter=$(this).attr('id').split('_');
	 if (!$(this).is(":checked")){
		 var postedId = 0;
	 }else{
		 var postedId = 1;
	 }
	 $.ajax({
			method : 'Post' ,
			url : "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "setIsPosted", "admin" => false));?>",
			data:"is_posted="+postedId+"&id="+voucherId,
			 context: document.body,
 		success: function(data){  
                $('#mgs_'+counter[1]).html('Successfully Updated');
                setTimeout(function(){
                   $('#mgs_'+counter[1]).hide();        
                }, 1500);
	   		}
		});
});
</script>