
<div id="content_vat">
	<div class="inner_title">
		<h3>
			<?php echo __($title_for_layout, true); ?>
		</h3>
		<span> <?php
		if($this->params['pass'][1]!="edit"){
			echo $this->Html->link(__('Add', true),"javascript:void(0);", array('escape' => false,'class'=>'blueBtn','id'=>'add_vat'));
		}
		echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master'),'admin'=>true), array('escape' => false,'class'=>'blueBtn'));
		?>
		</span>
	</div>
	<?php echo $this->Form->create('vatClas',array('id'=>'containVatFrm'));?>
	<?php /*echo $this->Form->create('vatClas',array('url'=>array('controller'=>'Pharmacy','action'=>'vat'),'id'=>'containVatFrm', 'inputDefaults' => array('label' => false,'div' => false)));*/
	echo $this->Form->hidden('VatClass.id',array('id'=>'vat-id')); 
	if($this->params['pass'][1]=='edit') $display  = '' ;
	else $display = 'none';
	?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="500px" align="right"  id="vatAddForm" style="display:<?php echo $display ?>;">
		<tr>
			<td><label style="width: 99px;"><?php echo __('Class Of Vat');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input('VatClass.vat_of_class', array('style'=>'width:157px;','type'=>'text','class' => 'validate[required,custom[mandatory-enter]] classOfVat','label'=>false,'id' => 'vatOfClass','value'=>$vatEditData['VatClass']['vat_of_class'])); ?>
			</td>
		</tr>
		
		<tr>
			<td><label style="width: 99px;"><?php echo __('Vat %');?>:</label>
			</td>
			<td><?php echo $this->Form->input('VatClass.vat_percent', array('style'=>'width:157px;','type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','label'=>false,'id' => 'vat_percent','readonly'=>false,'value'=>$vatEditData['VatClass']['vat_percent'])); ?>
			
			</td>
		</tr>
		
		<tr>
			<td><label style="width: 99px;"><?php echo __('Sat %');?>:</label>
			</td>
			<td><?php echo $this->Form->input('VatClass.sat_percent', array('style'=>'width:157px;','type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','label'=>false,'id' => 'sat_percent','readonly'=>false, 'value'=>$vatEditData['VatClass']['sat_percent'])); ?>
			
			</td>
		</tr>
		
		<tr>
			<td><label style="width: 99px;"><?php echo __('Effective From');?>: </label>
			</td>
			<td><span><?php echo $this->Form->input('VatClass.effective_from', array('id' => 'effective_from','type'=>'text','label'=>false,'style'=>'width:150px','class'=>'textBoxExpnd','value'=>$vatEditData['VatClass']['effective_from'])); 
			?></span>
			</td>
		</tr>
		
		<tr>
			<td class="row_format" align="right" colspan="2"><?php 
			
			echo $this->Form->submit(__('Submit'), array('label'=> false,'id'=>'submit','div' => false,'error' => false,'class'=>'blueBtn'));
			
			if($this->params['pass'][1]=="edit"){
				
				echo $this->Html->link('Cancel',array('controller'=>'pharmacy','action'=>'vat','inventory'=>false),array('escape' => false,'id'=>'edit-cancel','class'=>'blueBtn'));
			}else{
				echo $this->Html->link('Cancel','javascript:void(0);',array('escape' => false,'id'=>'note-cancel','class'=>'blueBtn'));
			}
			
			?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
	<div>&nbsp;</div>
	<?php echo $this->Form->create('StoreLocation',array('url'=>array('controller'=>'Locations','action'=>'storeLocation'),'type'=>'Get','id'=>'storeLocationfrmsearch', 'inputDefaults' => array('label' => false,'div' => false)));?>
	<!--<table border="0" cellpadding="0" cellspacing="0" width="500px;"
		style="padding-left: 19px; padding-right: 20px;">
		<tbody>
			<tr class="row_title">
				<td width="30%" class=""
					style="border: none !important; font-size: 13px;"><?php echo __('class of Vat  :') ?>
				</td>
				<td width="30%" style="border: none !important;"><?php  echo $this->Form->input('name', array('type'=>'text','id' => 'name_search', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;'));?>
				</td>
				<td width="40%" style="border: none !important;"><?php echo $this->Form->submit(__('Search'),array('label'=> false,'div' => false, 'error' => false,'class'=>'blueBtn','title'=>'Search','style'=>'margin-left:10px;'));	?>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Locations','action'=>'storeLocation'),array('escape'=>false, 'title' => 'refresh'));?>
				</td>
			</tr>
		</tbody>-->
	</table>
	<?php echo $this->Form->end();?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		<tr class="row_title">
			<td class="table_cell"><strong><?php echo __('Class of Vat', true); ?>
			</strong>
			</td>
			<td class="table_cell"><strong><?php echo __('Vat Percent', true); ?>
			</strong>
			</td>
			<td class="table_cell"><strong><?php echo __('Sat Percent', true); ?>
			</strong>
			<td class="table_cell"><strong><?php echo __('Effective From', true); ?>
			</strong>
			</td>
			<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
			</td>
		</tr>
		<?php 
		$cnt =0;
		if(count($data) > 0) {
		       foreach($data as $vatData):
		       $cnt++;
		       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"><?php echo $vatData['VatClass']['vat_of_class']; ?>
			</td>
			<td class="row_format"><?php echo $vatData['VatClass']['vat_percent']; ?>
			</td>
			<td class="row_format"><?php echo $vatData['VatClass']['sat_percent']; ?>
			</td>
			<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($vatData['VatClass']['effective_from'],Configure::read('date_format')); ?>
			</td>
			
			<td><?php
			echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
		   			 					'alt'=> __('View', true))), array('controller'=>'Pharmacy','action' => 'view_vat_class', $vatData['VatClass']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),'id'=>'editVat',
		   			 					'alt'=> __('Edit', true))), array('controller'=>'Pharmacy','action' => 'vat',$vatData['VatClass']['id'],"edit"), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('controller'=>'Pharmacy','action' => 'deleteVatOfClass', $vatData['VatClass']['id']), array('escape' => false ),"Are you sure ?");
			?>
		
		</tr>
		<?php endforeach;  ?>
		
		<?php
 			} else {
		  	?>
		<tr>
			<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php }
		 	
		?>
	</table>
</div>
<script>
jQuery(document).ready(function(){
	//code name could not be editable in edit case
	//by swapnil G.Sharma
	var code_name = $("#code_name").val();
	if(code_name !=''){
		$("#code_name").attr('readonly',true);
	}else{
		$("#code_name").attr('readonly',false);
	}
	
	jQuery("#storeLocationfrm").validationEngine();						 

	
	/* $(".classOfVat").blur(function(){ 
		var vatVal = $(this).val(); 
		  $.ajax({
			 url:"<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "valid_vat_name","inventory" => false)); ?>"+"/"+vatVal,
			 data: "vatVal="+vatVal, 
			 success:function(data){
		    	//$("#div1").html(result);
		  	 }
		  });
		});*/
 	
	$("#add_vat").click(function(){
		$( "#containVatFrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) {
			$(this).val('');
		});
		$("#vatAddForm").show() ;
	});

	$("#note-cancel").click(function(){
		$( "#containVatFrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) { //reset current form
			$(this).val('');
		});
		$("#vatAddForm").hide('slow');
	});
	
	
	$("#editVat").click(function(){
		$("#vatAddForm").show('slow');	
	});
	
	jQuery(document).ready(function() {
			$("#effective_from").datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			dateFormat:'<?php echo $this->General->GeneralDate("");?>',
			maxDate: new Date(),
			onSelect : function() {
				$(this).focus();
			} 
		});
	});
	
	
});
</script>
