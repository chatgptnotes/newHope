<div class="inner_title">
<h3><?php echo __('Cashier Approve', true); ?></h3>
</div>
<?php echo $this->Form->create('Voucher',array('id'=>'voucher','url'=>array('controller'=>'Accounting','action'=>'cashier_approve','admin'=>false),));?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
		<td>
			<div id="container">
				<table width="50%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center">
					<thead>
						<tr> 
							<th style= "text-align: center;" width="20%" align="center" valign="top">Cashier Name</th> 
							<th style= "text-align: center;" width="20%" align="center" valign="top">Allow To Login</th> 
						</tr> 
					</thead>
					
					<tbody>
					<?php foreach ($userName as $key=>$name){?>
						<tr>
							<td align="center" valign="top" style= "text-align: center;">
								<?php echo $name; ?>
								<?php echo $this->Form->hidden("cashier.$key.name",array('id'=>"cashierName_$key",'type'=>'text','value'=>$name));?>
							</td>
							<td align="center" valign="top" style= "text-align: center;">
								<?php echo $this->Form->input("cashier.$key.is_radio", array('class'=>'radio','id'=>"radio_$key",'div'=>false,'label'=>false,"hiddenField"=>false,'type'=>'radio','legend'=>false,'options'=>array(''),'autocomplete'=>"off"));?>
								<?php echo $this->Form->hidden("cashier.$key.id",array('id'=>"cashierId_$key",'type'=>'text','value'=>$key));?>
							</td>
					  	</tr>
					  <?php } ?>
					  <tr>
						  <td colspan="2" style= "text-align: center;">
						  <?php echo $this->Html->link(__('Cancel'), array('controller' => 'Accounting', 'action' => 'index'), array('title'=>'Cancel','class'=>'blueBtn'));?>
						  	<?php echo $this->Form->submit('Save',array('class'=>'blueBtn','title'=>'Save','style'=>'text-align:right;','id'=>'save','div' => false)) ; ?>	
						</td>
					</tr>
					</tbody>
				<?php echo $this->Form->end();?>
				</table>
			</div>
		</td>
	</tr>
</table>
<script>
$(document).ready(function(){
$('#save').hide();

$('.radio').click(function() {
	$('#save').show();
	
		var id = $(this).attr('id');
		 id = id.split("Radio");

		 if($(this).is(':checked',true)){
			$("#cashierName_"+id[1]).attr('disabled',false);
			$("#cashierId_"+id[1]).attr('disabled',false);
			$("#radio_"+id[1]).val('1');
		 }else{
			 $("#cashierName_"+id[1]).attr('disabled',true);
			 $("#cashierId_"+id[1]).attr('disabled',true);
		}
	});
});


</script>