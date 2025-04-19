<?php echo $this->Html->css('internal_style.css');
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3'));?>
<div class="inner_title">
	<h3>
		<?php echo __('New Batch'); ?>
	</h3>
</div>
<div class="clr">&nbsp;</div>

<?php echo $this->Form->create('newBatch',array('type' => 'file','id'=>'newBatch','inputDefaults' => array(
		'label' => false,'action'=> 'newBatch',	'div' => false,	'error' => false))); ?>
<table border="0" class=" " cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tbody>

		<tr class="row_title">
			<td class="tdLabel" id="boxSpace" align="right"><label>&nbsp; </label>
			</td>
			<td class="tdLabel" id="boxSpace" ><label><?php echo __('Patient Id') ?> </label>
			</td>
			<td class="tdLabel" id="boxSpace" align=><label><?php echo __('Patient Name') ?> </label>
			</td>
			<td class="tdLabel" id="boxSpace" align="right" width=" "><label><?php echo __('Patient Age') ?>
			</label></td>
			<td class="tdLabel" id="boxSpace" align="right"><label><?php echo __('Gender') ?> </label>
			</td>
			<td class="tdLabel" id="boxSpace" align="right"><label><?php echo __('Payer Name') ?> </label>
			</td>
			<td class="tdLabel" id="boxSpace" align="right"><label><?php echo __('File With') ?> </label>
			</td>
		</tr>
		<?php   if(count($dashBoard) > 0) {
			foreach($dashBoard as $key=>$patients){

							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }

							       ?>
		<td class=" " align=""><label><?php echo $this->Form->input('',array('type'=>'checkbox','name'=>'checkName[]'
				,'value'=>$patients['Patient']['id'].",1500,". $patients['NewInsurance']['tariff_standard_id']
				.",".$patients['Encounter']['id'],'class'=>'getId','id'=>$key,'label'=>false)) ?>
		</label>
		</td>
		<td id="boxSpace" align="right" style=" padding: 0 0 0 24px;"><label id=<?php echo "id$key";?>><?php echo $patients['Patient']['patient_id']; ?>
		</label>
		</td>
		<td id="boxSpace" style="padding: 0 0 0 22px;"><?php echo $patients['Patient']['lookup_name'];  ?>
		
		</td>
		<td class="tdLabel" id="boxSpace" style="text-align:center;"><?php echo $patients['Patient']['age']; ?></td>
		<td class="" id="boxSpace" style="padding: 0 0 0 74px;"><?php if(strtolower($patients['Patient']['sex'])=='male'){
			echo $this->Html->image('/img/icons/male.png');
		}else if(strtolower($patients['Patient']['sex'])=='female'){
																			echo $this->Html->image('/img/icons/female.png');
																		}  	?> 
		</td>
		<td class="" id="boxSpace" style="padding: 0 0 0 43px;"><?php if(empty($patients['NewInsurance']['tariff_standard_name']))echo __('Not Define');else echo $patients['NewInsurance']['tariff_standard_name'];  ?>
		
		</td>
		<td id="boxSpace" style="padding: 0 0 0 64px;"><?php echo $patients['Encounter']['file_with']; ?>
		</td>
		<?php }
}
 $this->Paginator->options(array('url' =>array("?"=>$this->params->query))); ?>
					    
					   <tr>
					    <TD colspan="8" align="center">
					    <!-- Shows the page numbers -->
					 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
					 <!-- Shows the next and previous links -->
					 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
					 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
					 <!-- prints X of Y, where X is current page and Y is number of pages -->
					 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
					    </TD>
					   </tr>
		<tr>
			<td class=" " align="center" style="padding: 30px 0 0;"><?php
			echo $this->Form->submit(__('Create Batch'),array('class'=>'blueBtn','id'=>'Cbatch','div'=>false,'label'=>false));
			?>
			</td>
		</tr>
	</tbody>
</table>
<?php echo $this->Form->end();?>
<script>
/*
 * 
 var ids='';
$('#Cbatch').click(function(){
$('.getId').each(function(index){
	var n=$('#'+index+':checked').length;
	if(n==1){
		 ids+=","+$('#id'+index).html();
	}
});
alert(ids);
});*/
</script>
