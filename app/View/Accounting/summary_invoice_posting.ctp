
<style>
body{
font-size:13px;
}
#msg {
    width: 180px;
    margin-left: 34%;
}
.green td{
	background-color:#A5C887 !important;
}
.red td{
	background-color:#ED978D !important;
}
</style>
<?php 
echo $this->Html->script('topheaderfreeze') ;
?>
<div class="inner_title">
	<h3>
		<?php echo __('Summary Invoice Posting', true); ?>
	</h3>
</div> 
<?php echo $this->Form->create('Voucher',array('id'=>'voucher','url'=>array('controller'=>'Accounting','action'=>'summaryInvoicePosting','admin'=>false)));?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="95%" valign="top">
			<table align="center" style="margin-top: 10px">
				<tr>
					<td align="center"><strong><?php echo __('Posted Entry')?></strong></td>
					<td><?php echo $this->Form->input("Voucher.is_posted",array('id'=>"entry_posted",'type'=>'select','label'=>false,
						'options'=>array('1'=>'Posted Entry','2'=>'Not Posted Entry','3'=>'Error Entry'),'empty'=>'All'));?></td>
					<td align="center"><strong><?php echo __('Voucher Type')?></strong></td>
					<td><?php echo $this->Form->input("Voucher.type",array('id'=>"voucher_type",'type'=>'select','label'=>false,
						'options'=>array('1'=>'Journal','2'=>'Receipt','3'=>'Payment','4'=>'Contra'),'empty'=>'All'));?></td>
					<td align="center"><strong><?php echo __('Patient Name');?></strong></td>
					<td><?php echo $this->Form->input('Voucher.name',array('id'=>'patient','label'=>false,'div'=>false,'type'=>'text',
							'autocomplete'=>'off','class' => 'validate[required,custom[mandatory-enter]]'));
							echo $this->Form->hidden('Voucher.patient_id',array('id'=>'patient_id'));?></td>
					<td><?php echo __('From');?></td>
					<td><?php echo $this->Form->input('Voucher.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 
							'div' => false, 'error' => false,'readonly'=>'readonly'));?></td>
					<td><?php echo __('To');?></td>
					<td><?php echo $this->Form->input('Voucher.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false, 
							'div' => false, 'error' => false,'readonly'=>'readonly'));?></td>
					<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false,'id'=>'search'));?></td>
					<td><?php echo $this->Html->link(__('Post to Tally'),'javascript:void(0);', array('escape' => false,'class'=>"blueBtn Back",
							'id'=>'posttally'));
						 echo $this->Form->end();?>
					</td>
				</tr>
			</table>

			<table cellspacing="0" cellpadding="0" width="98%" align="center">
				<tr>
					<td></td>
					<td align="right">
					<?php $from1=explode(' ',$from);
						  $to1=explode(' ',$to);
						  
						  if($from!=null || $to!=null)
						  echo $from1[0]."  To ".$to1[0];
						  ?>
					</td>
				</tr>
			</table>
<div align="center" style="display:none;" id="msg"></div>
<div id="container">
<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm" id="container-table">
	<thead>
		<tr> 
		    <th width="2%" align="center" valign="top" style="text-align: center;"><input type="checkbox" class="checked_all" id="checked_all" checked="checked"/><?php echo __("All");?></th>
		    <th width="6%" align="center" valign="top" style="text-align: center;"><?php echo __('Company Name');?></th>
			<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Date');?></th>
			<th width="30%" align="center" valign="top"><?php echo __('Particulars');?></th> 
			<th width="8%" align="center" valign="top" style="text-align: center; "><?php echo __('Type');?></th> 
			<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Voucher Type');?></th>
			<th width="7%" align="center" valign="top" style="text-align: center;"><?php echo __('Mode Of Payment');?></th>
			<th width="8%" align="center" valign="top" style="text-align: center; "><?php echo __('Voucher No.');?></th> 
			<th width="13%" align="center" valign="top" style="text-align: center;"><?php echo __('Debit');?></th>
			<th width="13%" align="center" valign="top" style="text-align: center;"><?php echo __('Credit');?></th> 
			<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('View Details');?></th>
		</tr> 
	</thead>
	<tbody>
	<?php echo $this->Form->create('Tally',array('id'=>'post_to_tally_form','method'=>'post'));?>
<?php foreach($data as $key=> $journalData){ ?>
<?php $checked = "checked"; 
		$checkedPosted = "";
	if($journalData['VoucherLog']['is_posted'] == '1') {
		echo "<tr class = 'green'>";
		$checked = "";
		$checkedPosted = "checked";
	}else if($journalData['VoucherLog']['is_posted'] == '2') {
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
                  echo $this->Form->hidden('',array('disbled'=>'disabled','id'=>'postedId_'.$key,'name'=>"data[postedId][$key]",'value'=>$journalData['VoucherLog']['is_posted'],'div'=>false,'label'=>false));
                  echo $this->Form->hidden('',array('disbled'=>'disabled','id'=>'logType_'.$key,'name'=>"data[logType][$key]",'value'=>$journalData['VoucherLog']['type'],'div'=>false,'label'=>false));?>
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
				<?php echo ucwords($journalData['Account']['name']); ?>
			</div>
		</td>
		<td align="left" valign="top" style= "text-align: left;">
			<?php echo ucwords($journalData['TariffStandard']['name']); ?>
		</td>
		<td align="left" valign="top" style= "text-align: left;">
			<?php echo $journalData['VoucherLog']['voucher_type'] ;?>
		</td>
		<?php if($journalData['VoucherLog']['voucher_type']=='Receipt' || $journalData['VoucherLog']['voucher_type']=='Payment'){?>
		<td align="left" valign="top" style= "text-align: left;">
				<?php echo ucwords($journalData['AccountAlias']['name']); ?>
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
		elseif($journalData['VoucherLog']['voucher_type']=='Journal' && $journalData['VoucherLog']['type']!='FinalDischarge' || $journalData['VoucherLog']['voucher_type']=='Purchase'){?>
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
		elseif($journalData['VoucherLog']['voucher_type']=='Contra'){?>
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
			<?php echo $viewLink;?>
			<?php }?>
    			<?php //echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'patient_journal_voucher', $journalData['Patient']['id']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete','admin'=>false),__('Are you sure?', true)); ?>
  		<?php echo $this->Form->input("entryPosted.", array('id'=>'entryPosted_'.$key,"type" => "checkbox","checked"=>$checkedPosted,"class"=>"checkboxPosted",'legend'=>false,
					'name'=>"data[entry_posted][$key]",'value'=>$journalData['VoucherLog']['id'],"hiddenField"=>false));?>
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
		</div>
	</td>
</tr>
</table>

<script>
$(document).ready(function(){
	$("#container-table").freezeHeader({ 'height': '500px' });
	$("#from").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	 
 	$("#to").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});
	
	//$( "#search" ).click(function(){ 
		// result  = compareDates($( '#from' ).val(),$( '#to' ).val(),'<?php //echo $this->General->GeneralDate();?>') //function with dateformat 
		 //if(!result){ 
		 	//alert("To date should be greater than from date");
		 //}
		 //return result ;
//	});

	 jQuery("#patientVoucher").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
			});	
});

$(document).on('click','.checked_all', function() {
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
});

$("#posttally").click(function()
	{
		$( ".selectCheck" ).each(function( index ) {
			var id = $(this).attr('id');
			 id = id.split("_");
			 if($(this).is(':checked',true)){
				$("#voucherTypeId_"+id[1]).attr('disabled',false);
				$("#voucherId_"+id[1]).attr('disabled',false);
				$("#patientId_"+id[1]).attr('disabled',false);
				$("#companyId_"+id[1]).attr('disabled',false);
				$("#postedId_"+id[1]).attr('disabled',false);
				$("#logType_"+id[1]).attr('disabled',false);
			 }else{
				 $("#voucherTypeId_"+id[1]).attr('disabled',true);
				 $("#voucherId_"+id[1]).attr('disabled',true);
				 $("#patientId_"+id[1]).attr('disabled',true);
				 $("#companyId_"+id[1]).attr('disabled',true);
				 $("#postedId_"+id[1]).attr('disabled',true);
				 $("#logType_"+id[1]).attr('disabled',true);
			 }
		});
	
		var textinputs = document.querySelectorAll('input[type=checkbox]'); 
		var empty = [].filter.call( textinputs, function( el ) {
		   return !el.checked
		});

		if (textinputs.length == empty.length) {
		    alert("Please select CheckBox");
		    return false;
		}
		else
		var form_value = $("#post_to_tally_form").serialize();
		//alert(form_value);return false;
		$.ajax({
		url: '<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'post_to_tallynew'));?>',
		data: form_value,
		type: "POST",
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success:function(data){
			alert(data);
			//$('#msg').show();
			$('#msg').html(data);
			$('#msg').fadeOut( 5000 );
			$('#busy-indicator').hide();
			window.location = "<?php echo $this->Html->url(array('controller' => 'Accounting', 'action' => 'summaryInvoicePosting')); ?>";
            return false;
		}
		});
	});

 $(".checkbox1").click(function () {
     if (!$(this).is(":checked")){
         $("#checked_all").prop("checked", false);
     }else{
         var flag = 0;
         $(".checkbox1").each(function(){
             if(!this.checked)
             flag=1;
         })             
         if(flag == 0){ $("#checked_all").prop("checked", true);}
     }
 });

 $( "#patient" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Account","name",'null',"null",'null',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			$('#patient_id').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	});
 $("#voucher_type").change(function(){
	 var type = ($(this).val()) ? $(this).val() : 'null' ;
	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "summaryInvoicePosting", "admin" => false));?>";
		$.ajax({
		url : ajaxUrl + '?type=' + type,
		beforeSend:function(data){
		$('#busy-indicator').show();
		},
		success: function(data){
			$("#container").html(data).fadeIn('slow');
			//alert(html);
			$('#busy-indicator').hide();
		}
	 });
 });
 $("#entry_posted").change(function(){
	 var is_posted = ($(this).val()) ? $(this).val() : 'null' ;
	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "day_book", "admin" => false));?>";
		$.ajax({
		url : ajaxUrl + '?is_posted=' + is_posted,
		beforeSend:function(data){
		$('#busy-indicator').show();
		},
		success: function(data){
			$("#container").html(data).fadeIn('slow');
			//alert(html);
			$('#busy-indicator').hide();
		}
	 });
 });
 $(".checkboxPosted").click(function () {
	 var voucherId = $(this).val();
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
                      $(this).attr('readOnly',true);
	   		}
		});
 });
</script>