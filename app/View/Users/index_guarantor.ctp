<?php
echo $this->Html->script(array('jquery.autocomplete','jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.autocomplete.css','jquery.fancybox-1.3.4.css'));
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Guarantor Management', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Add Guarantor'), array('controller' => 'users','action' => 'addGuarantor'), array('escape' => false,'class'=>'blueBtn'));
	
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
	</span>
</div>
<?php echo $this->Form->create('',array('action'=>'indexGuarantor'));?>
	<table border="0" class="table_format" cellpadding="3" cellspacing="0"
		width="100%" align="center">
		<tr class="row_title">
			<td class=" " align="left" width="12%"><?php echo __('First Name') ?>
				:</td>
			<td class=" "><?php 
			echo $this->Form->input('first_name', array( 'id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
			?>
			</td>
			<td class=" " align="left" width="12%"><?php echo __('Last Name') ?>
				:</td>
			<td class=" ">
			<?php 
				echo $this->Form->input('last_name', array( 'id' => 'last_name', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
			?>
			</td>
			<td><?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?></td>
			<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'indexGuarantor'),array('escape'=>false, 'title' => 'refresh'));?></td>
		</tr>	  
	</table>
	<?php echo $this->Form->end();?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
		<tr class="row_title">			
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('PatientGaurantor.first_name', __('First Name', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('PatientGaurantor.last_name', __('Last Name', true)); ?>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('PatientGaurantor.sex', __('Gender', true)); ?>
			
			<td class="table_cell"><strong><?php echo __('Action', true); ?>
			
			</td>
		</tr>
		<?php //debug($activeFlag);
		$cnt =0;
		if(count($data) > 0) {

       foreach($data as $patientGaurantorData):
       $cnt++;
       
      
       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>	
		<td class="row_format"><?php echo $patientGaurantorData['PatientGaurantor']['first_name']; ?>
			</td>
			<td class="row_format"><?php echo $patientGaurantorData['PatientGaurantor']['last_name']; ?>
			</td>		
			<td class="row_format"><?php if(($patientGaurantorData['PatientGaurantor']['sex'])=='M'){
								echo $this->Html->image('/img/icons/male.png');
								}else if(($patientGaurantorData['PatientGaurantor']['sex'])=='F'){
							echo $this->Html->image('/img/icons/female.png');
						} 	?>				
			<td><?php 
		//	echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view',  $patientGaurantorData['PatientGaurantor']['id']), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));
			echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'addGuarantor', $patientGaurantorData['PatientGaurantor']['id']), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
		 	echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'deleteGuarantor', $patientGaurantorData['PatientGaurantor']['id']), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));
			?></td>
		</tr>
		<?php endforeach;  ?>
		<tr>
			<TD colspan="10" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
			</span>
			</TD>
		</tr>
		<?php
         } else {
  ?>
		<tr>
			<TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
      }
      ?>
	</table>

	<script>	
	$(function() {
		$("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PatientGaurantor","first_name",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
		$("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","PatientGaurantor","last_name",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
	});	
</script>