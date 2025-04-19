<?php //	 debug($testOrdered);?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull" align="center" style="padding: 5px;">
	<tr>
		<td>From:</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false,'id'=>'from_date'));?></td>
		<td>To:</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false,'id'=>'to_date'));?></td>
		<td>Type:</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false));?></td>
		<td>Category</td>
		<td><?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select'),'div'=>false,'label'=>false));?></td>
		<td>Service</td>
		<td><?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select'),'div'=>false,'label'=>false));?></td>
		<td>Seacrh</td>
		<td>Brush</td>
		<td>Print</td>
		<td>Grid</td>
	</tr>
	
	<tr>
		<td>ReqNo:</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false));?></td>
		<td>Status:</td>
		<td><?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select'),'div'=>false,'label'=>false));?></td>
		<td>Consultant:</td>
		<td><?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select'),'div'=>false,'label'=>false));?></td>
		<td>Visit</td>
		<td><?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select'),'div'=>false,'label'=>false));?></td>
		<td>Ward</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false));?></td>
		<td>BedNo:</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false));?></td>
		<td colspan="2"></td>
	</tr>
</table>
<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
	<thead>	
		<tr>
			<th width="3%" align="center" valign="top" style="text-align: center;">Sr.No.</th>
			<th width="20%" align="center" valign="top" style="text-align: center;">Patient Info</th>
			<th width="3%" align="center" valign="top" style="text-align: center;">Incl. <?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'incl_master','class'=>'incl_master'));?></th>
			<th width="10%" align="center" valign="top" style="text-align: center;">ReqNo.</th>
			<th width="9%" align="center" valign="top" style="text-align: center;">Svc.Type</th>
			<th width="10%" align="center" valign="top" style="text-align: center;">Services</th>
			<th width="10%" align="center" valign="top" style="text-align: center;">Req.By</th>
			<th width="10%" align="center" valign="top" style="text-align: center;">Date</th>
			<th width="10%" align="center" valign="top" style="text-align: center;">Status</th>
			<th width="5%" align="center" valign="top" style="text-align: center;">Sample Taken <?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false));?></th>
			<th width="5%" align="center" valign="top" style="text-align: center;">Received <?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false));?></th>
			<th width="5%" align="center" valign="top" style="text-align: center;">Completed <?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false));?></th>
			<th width="5%" align="center" valign="top" style="text-align: center;">R.. <?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false));?></th>
			<th width="5%" align="center" valign="top" style="text-align: center;">PayNow <?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false));?></th>
		</tr>
	</thead>
		
	<tbody>

	<?php
	$i=1;
	 foreach($testOrdered as $key=>$value){
	 	$patientName = $value['Patient']['lookup_name'];
		foreach($value['LaboratoryTestOrder'] as $subValue){?>

		<tr>
			<td align="center"><?php echo $i;?></td>
			<td><?php 
			if($patientName){
				echo $value['Patient']['lookup_name'];
			}
			?></td>
			<td align="center"><?php echo $this->Form->input('',array('type'=>'checkbox','id'=>'checkbox','value'=>$subValue['id'],'class'=>'chk','div'=>false,'label'=>false));?></td>
			<td align="center"><?php echo __('2332')?></td>
			<td><?php echo __('LAB')?></td>
			<td><?php echo $subValue['id']?></td>
			<td><?php echo $value[0]['name']?></td>
			<td><?php echo $this->DateFormat->formatDate2Local($subValue['start_date'],Configure::read('date_format'),true)?></td>
			<td><?php echo __('Print taken')?></td>
			<td align="center"><?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>"sample_".$key,'class'=>"sample_checkbox"));?></td>
			<td align="center"><?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false));?></td>
			<td align="center"><?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false));?></td>
			<td align="center"><?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false));?></td>
			<td align="center"><?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>"payNow_".$key,'class'=>"payNow_checkbox"));?></td>
		</tr>

		<?php //}
			$patientName = '';
	 }
	 $i++;
	}?>
		

	</tbody>
</table>

<div class="clr ht5"></div>

<table align="center">
	<tr>
		<td>
			<?php
				echo $this->Html->link(__('Entry Mode'),'javascript:void(0)', array('id'=>'entryMode','escape' => false,'class'=>'blueBtn'))
				."&nbsp";
				echo $this->Html->link(__('Save'),'javascript:void(0)', array('escape' => false,'class'=>'blueBtn'))
				."&nbsp";
				echo $this->Html->link(__('Print'),'javascript:void(0)', array('escape' => false,'class'=>'blueBtn'))
				."&nbsp";
				echo $this->Html->link(__('Pay Bill'),'javascript:void(0)', array('escape' => false,'class'=>'grayBtn','id'=>'payBill'));
			?>	
		</td>
	</tr>
</table>

<?php echo $this->Form->create('NewLaboratory', array('controller'=>'new_laboratories','action'=>'none','id'=>'laboratoryFrm',
												    	'inputDefaults' => array(
												        'label' => false,
												        'div' => false,'error'=>false
												    )
			));
?>
<table>
	<tr>
		<td><?php echo $this->Form->input("labPostData",array('id'=>'labPostData','type'=>'hidden')) ?></td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<div class="clr ht5"></div>
<script>
var chk1Array=[];
$(document).ready(function(){
	
	$("#from_date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	});

	$("#to_date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	});

	$(function(){  //incl checkbox enable when sample checkbox get enables
		$(".sample_checkbox").click ( function() {
			id = $(this).attr('id');
			new_id = id.split("_");
		    if (!$(this).is(":checked")){
		      $("#incl_"+new_id[1]).attr("disabled",true);
		      $("#incl_"+new_id[1]).prop("checked",false);
		    }
		    else{
		      $("#incl_"+new_id[1]).removeAttr("disabled");
		    }
		 });
	});

	$(function(){  //enable pay bill if any pay now checkbox get checked
		$(".payNow_checkbox").click( function() {
			var checked = ''; 
			$(".payNow_checkbox").each(function(){
				if ($(this).is(":checked")){
					checked = 1;
					return false;
				}
			});
			if(checked == 1){
				$("#payBill").removeClass("grayBtn");
			    $("#payBill").addClass("blueBtn");
			}else{
				$("#payBill").removeClass("blueBtn");
			    $("#payBill").addClass("grayBtn");
			}
		 });
	});

	$(function(){	//slect/deselect all checkboxes
		$('#incl_master').click(function(event) {  		//on click
		    if(this.checked) { 							// check select status
		        $('.incl_checkbox').each(function() { 	//loop through each checkbox
	            	this.checked = true;  				//select all checkboxes with class "incl_checkbox"           
		        });
		    }else{
		        $('.incl_checkbox').each(function() { 	//loop through each checkbox
		            this.checked = false; 				//deselect all checkboxes with class "incl_checkbox"                      
		        });        
		    }
		});
	});

	$(function(){
		 $(".incl_checkbox").click(function () {
		     if (!$(this).is(":checked")){
		         $("#incl_master").prop("checked", false);
		     }else{
	         var flag = 0;
	         $(".incl_checkbox").each(function(){
	             if(!this.checked)
	             flag=1;
	         })             
		     	if(flag == 0){ 
			     	$("#incl_master").prop("checked", true);
			     }
		     }
		 });
	});

	
	$(function(){
		 $(".chk").click(function () {
			 
				 checkId=this.id;
				  if(!$(this).is(':disabled')){
				   val =$(this).val();
				   chk1Array.push(val);
				  }
		 });
		});

		$("#entryMode").click(function(){
			$("#laboratoryFrm").attr("action", "<?php echo $this->Html->url(array('controller' => 'new_laboratories', 'action' => 'entryMode'));?>");
			var str = chk1Array.join(',');
			$("#labPostData").val( str );
			$( "#laboratoryFrm" ).submit();
	});
	
});
</script>