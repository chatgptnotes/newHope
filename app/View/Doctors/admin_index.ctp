<?php
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css'));
?>
<style>
.row_action img{
float:inherit;
}
</style>
<div class="inner_title">
<h3><?php echo __('In-House Doctor Enquiry', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<?php echo $this->Form->create('Doctor',array('action'=>'index','admin'=>true));?>
	<table border="0" class="table_format" cellpadding="3" cellspacing="0"
		width="100%" align="center">
		<tr class="row_title">
			<td class=" " align="left" width="12%"><?php echo __('First Name') ?>
				:</td>
			<td class=" " width="12%"><?php 
			echo $this->Form->input('first_name', array( 'id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
			?>
			</td>
			<td class=" " align="left" width="12%"><?php echo __('Last Name') ?>
				:</td>
			<td class=" " width="12%">
			<?php 
				echo $this->Form->input('last_name', array( 'id' => 'last_name', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
			?>
			</td>
			<td width="5%"><?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?></td>
			<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'index','admin'=>true),array('escape'=>false, 'title' => 'refresh'));?></td>
		</tr>	  
	</table>
	<?php echo $this->Form->end();?>
<table border="0" cellpadding="0" class="table_format" cellspacing="0" width="100%">
  <tr class="row_title">
   <!--  <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorProfile.id', __('Id', true)); ?></td>
   -->
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('DoctorProfile.doctor_name', __('Doctor Name', true)); ?></td>
  <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('DoctorProfile.gender', __('Gender', true)); ?></td>
    <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('DoctorProfile.gender', __('Mobile Number', true)); ?></td>
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('DoctorProfile.education', __('Education', true)); ?></td>
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('DoctorProfile.specility_keyword', __('speciality Keyword', true)); ?></td>
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('DoctorProfile.experience', __('Experience', true)); ?></td>
  <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('DoctorProfile.is_registrar', __('Type', true)); ?></td>
   <td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
       $cnt=0;
       if(count($data) > 0) {
       foreach($data as $doctor): 
         $cnt++;
        
  ?>
  <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?> >
   <!--  <td class="row_format"><?php echo $doctor['DoctorProfile']['id']; ?></td>
   -->
   <td class="row_format" align="left"><?php echo $doctor['Doctor']['full_name']; ?> </td>
   <td class="row_format" align="left"><?php if(($doctor['Doctor']['gender'])=='M'){
											echo $this->Html->image('/img/icons/male.png');
											}else if(($doctor['Doctor']['gender'])=='F'){
										echo $this->Html->image('/img/icons/female.png');
									}  	?>
								</td>
  <td class="row_format" align="left"><?php echo $doctor['Doctor']['phone1']; ?> </td>
   <td class="row_format" align="left"><?php echo $doctor['DoctorProfile']['education']; ?> </td>
   <td class="row_format" align="left"><?php echo $doctor['DoctorProfile']['specility_keyword']; ?> </td>
   <td class="row_format" align="left"><?php echo $doctor['DoctorProfile']['experience']; ?> </td>
   <td class="row_format" align="left"><?php if( $doctor['DoctorProfile']['is_registrar'] == 1) echo __('Registrar'); else echo __('Primary Care Provider');; ?></td>
   <td class="row_action" align="left">
   <?php 
   		echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view', $doctor['Doctor']['id']), array('escape' => false,'title' => __('View Doctor Profile', true), 'alt'=>__('View Doctor Profile', true)));
   ?>
    
   <?php 
   		echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'doctorprofile', $doctor['Doctor']['id']), array('escape' => false,'title' => __('Edit Doctor Profile', true), 'alt'=>__('Edit Doctor Profile', true)));
   ?>
  
   <?php 
   		//echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $doctor['Doctor']['id']), array('escape' => false,'title' => __('Delete Doctor Profile', true), 'alt'=>__('Delete Doctor Profile', true)),__('Are you sure?', true));
   
   ?>
   
   </td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="6" align="center">
     <!-- Shows the page numbers -->
     <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     <!-- Shows the next and previous links -->
     <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
     <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
     <!-- prints X of Y, where X is current page and Y is number of pages -->
     <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
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
		$("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Doctor","first_name",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
		$("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Doctor","last_name",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
	});	
</script>
