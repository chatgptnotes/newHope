<?php 
  //echo $this->Html->script(array('jquery.fancybox-1.3.4'));//jquery-1.9.1.js
  //echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));//,'internal_style.css'
 ?>
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
		<?php echo __('Day Book', true); ?>
	</h3>
</div> 
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Voucher',array('id'=>'voucher','url'=>array('controller'=>'Accounting','action'=>'day_book','admin'=>false)));?>
<table border="0" cellpadding="2" cellspacing="0" align="center">
	<tbody>
		<tr class="row_title">
			<td>
				<?php echo $this->Form->input("Voucher.is_posted",array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>"entry_posted",'type'=>'select','label'=>false,
				'options'=>array('1'=>'Posted Entry','2'=>'Not Posted Entry','3'=>'Error Entry'),'empty'=>'All Entry'));?>
			</td>
			
			<td>
				<?php echo $this->Form->input("Voucher.type",array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>"voucher_type",'type'=>'select','label'=>false,
				'options'=>array('1'=>'Journal','2'=>'Receipt','3'=>'Payment','4'=>'Contra','5'=>'Purchase'),'empty'=>'All Voucher Type'));?>
			</td>
			
			<td>
				<?php echo $this->Form->input('Voucher.name',array('style'=>'width:120px','id'=>'patient','label'=>false,'div'=>false,'type'=>'text',
					'autocomplete'=>'off','class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]'));
					echo $this->Form->hidden('Voucher.patient_id',array('id'=>'patient_id'));?>
			</td>
			
			<td>
				<?php echo $this->Form->input('Voucher.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 
					'div' => false, 'error' => false,'readonly'=>'readonly','placeholder'=>'From','value'=>$from));?>
			</td>
			
			<td>
				<?php echo $this->Form->input('Voucher.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=>false, 
					'div'=>false,'error'=>false,'readonly'=>'readonly','placeholder'=>'To','value'=>$to));?>
			</td>
			
			<td>
				<?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false,'id'=>'search'));?>
			</td>
			
			<td>
				<?php echo $this->Html->link(__('Post to Tally'),'javascript:void(0);', array('escape' => false,'class'=>"blueBtn Back",
					'id'=>'posttally'));?>
			</td>
			
			<td>
				<?php echo $this->Html->link('Print','javascript:void(0)',array('escape' => false,'class'=>'blueBtn printButton','style'=>'margin: 0 10px;',
					'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printDayBook',
					'?'=>array('from'=>$from,'to'=>$to,'type'=>$type,'is_posted'=>$isPosted,'patient_id'=>$userid)))."', '_blank',
					'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=100');  return false;"));
				?>
			</td>
			
			<td>
				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'day_book'),array('escape'=>false));?>	
			</td>
		</tr>
	</tbody>
</table>
<?php  echo $this->Form->end();?>
<div class="clr inner_title" style="text-align: right;"></div>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-top:10px;">
	<tr>
		<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
		<td width="95%" valign="top">
<div align="center" style="display:none;" id="msg"></div>
<div id="container">
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="container-table">
	<thead>
		<tr> 
		    <th align="center" valign="top" width="5%"><input type="checkbox" class="checked_all" id="checked_all" checked="checked"/>All</th>
		    <th align="center" valign="top" width="15%"><?php echo __('Date');?></th>
			<th align="center" valign="top" width="20%"><?php echo __('Particulars');?></th> 
			<th align="center" valign="top" width="10%"><?php echo __('Voucher Type');?></th>
			<th align="center" valign="top" style="text-align: right;" width="10%"><?php echo __('Voucher Number');?></th> 
			<th align="center" valign="top" style="text-align: right;" width="15%"><?php echo __('Debit');?></th>
			<th align="center" valign="top" style="text-align: right;" width="15%"><?php echo __('Credit');?></th> 
			<th align="center" valign="top" style="text-align: center;" width="10%"><?php echo __('Update Entry Status');?></th>
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
		<td>
			<?php echo $this->Form->input("test.", array('id'=>'voucherUserId_'.$key,"type" => "checkbox","checked"=>$checked,"class"=>"checkbox1 selectCheck",'legend'=>false,
					'name'=>"data[user_id][$key]",'value'=>$journalData['VoucherLog']['id'],"hiddenField"=>false,'div'=>false,'label'=>false));?>
			<?php echo $this->Form->hidden('',array('disbled'=>'disabled','id'=>'voucherTypeId_'.$key,'name'=>"data[voucher_type][$key]",'value'=>$journalData['VoucherLog']['voucher_type'],'div'=>false,'label'=>false));
                  echo $this->Form->hidden('',array('disbled'=>'disabled','id'=>'voucherId_'.$key,'name'=>"data[voucher_id][$key]",'value'=>$journalData['VoucherLog']['voucher_id'],'div'=>false,'label'=>false));
                  echo $this->Form->hidden('',array('disbled'=>'disabled','id'=>'patientId_'.$key,'name'=>"data[patientId][$key]",'value'=>$journalData['VoucherLog']['patient_id'],'div'=>false,'label'=>false));
                  echo $this->Form->hidden('',array('disbled'=>'disabled','id'=>'postedId_'.$key,'name'=>"data[postedId][$key]",'value'=>$journalData['VoucherLog']['is_posted'],'div'=>false,'label'=>false));
                  echo $this->Form->hidden('',array('disbled'=>'disabled','id'=>'logType_'.$key,'name'=>"data[logType][$key]",'value'=>$journalData['VoucherLog']['type'],'div'=>false,'label'=>false));?>
		</td>
		
		<td>
			<?php echo $actualDate = $this->DateFormat->formatDate2Local($journalData['VoucherLog']['date'],Configure::read('date_format'),true);?>
		</td>
	
		<td>
			<?php 
				if($journalData['VoucherLog']['type']=="RefferalCharges"){
					echo "ML Enterprise"; 
				}else if($journalData['VoucherLog']['type'] == "USER"){
					echo ucwords($journalData['AccountAlias']['name']);
				}else{
					echo ucwords($journalData['Account']['name']);
				}
			?>
		</td>
		<td><?php echo $journalData['VoucherLog']['voucher_type'];?></td>
		<td style="text-align: right;"><?php echo $journalData['VoucherLog']['voucher_no'];?></td>
		<?php 
		if($journalData['VoucherLog']['voucher_type']=='Receipt'){ ?>
		<td><?php echo " ";?></td>
		<td style="text-align: right;"><?php echo $this->Number->currency($journalData['VoucherLog']['paid_amount']);?></td>
		<?php }elseif($journalData['VoucherLog']['voucher_type']=='Payment'){?>
		<td style="text-align: right;"><?php echo $this->Number->currency($journalData['VoucherLog']['paid_amount']);?></td>
		<td><?php echo " ";?></td>
		<?php }elseif($journalData['VoucherLog']['voucher_type']=='Journal' && $journalData['VoucherLog']['type']!='FinalDischarge'){?>
		<td style="text-align: right;"><?php echo $this->Number->currency($journalData['VoucherLog']['debit_amount']);?></td>
		<td><?php echo " ";?></td>
		<?php }elseif($journalData['VoucherLog']['voucher_type']=='Contra' || $journalData['VoucherLog']['voucher_type']=='Purchase'){?>
		<td><?php echo " ";?></td>
		<td style="text-align: right;"><?php echo $this->Number->currency($journalData['VoucherLog']['debit_amount']);?></td>
		<?php }elseif($journalData['VoucherLog']['voucher_type']=='Journal' && $journalData['VoucherLog']['type']=='FinalDischarge'){?>
		<td style="text-align: right;"><?php echo $this->Number->currency($journalData['VoucherLog']['debit_amount']);?></td>
		<td><?php echo " ";?></td>
		<?php } ?>
		<td style="text-align: center;">
  			<?php echo $this->Form->input("entryPosted.", array('id'=>'entryPosted_'.$key,"type" => "checkbox","checked"=>$checkedPosted,"class"=>"checkboxPosted",'legend'=>false,
					'name'=>"data[entry_posted][$key]",'value'=>$journalData['VoucherLog']['id'],"hiddenField"=>false,'div'=>false,'label'=>false));?>
			<span id='<?php echo "mgs_".$key;?>'></span>
  		</td>
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
	
	$( "#search" ).click(function(){ 
		 result  = compareDates($( '#from' ).val(),$( '#to' ).val(),'<?php echo $this->General->GeneralDate();?>') //function with dateformat 
		 if(!result){ 
		 	alert("To date should be greater than from date");
		 }
		 return result ;
	});

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
			window.location = "<?php echo $this->Html->url(array('controller' => 'Accounting', 'action' => 'day_book')); ?>";
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
 //$("#voucher_type").change(function(){
	// var type = ($(this).val()) ? $(this).val() : 'null' ;
	// var ajaxUrl = "<?php //echo $this->Html->url(array("controller" => 'Accounting', "action" => "day_book", "admin" => false));?>";
	 /*$.ajax({
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
 });*/
 
 //$("#entry_posted").change(function(){
	// var is_posted = ($(this).val()) ? $(this).val() : 'null' ;
	// var ajaxUrl = "<?php //echo $this->Html->url(array("controller" => 'Accounting', "action" => "day_book", "admin" => false));?>";
		/*$.ajax({
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
 });*/
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
	