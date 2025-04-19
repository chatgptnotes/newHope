<style>
.row_action img{
float:inherit;
}
</style>
<?php 
 echo $this->Html->script('jquery_latest');  
  echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');
  if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
  </td>
 </tr>
</table>
<?php } ?>
 <div class="inner_title">
<h3> &nbsp; <?php echo __('Role Management', true); ?></h3>
<span>
<?php
  echo $this->Html->link(__('Add Role'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
   echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<table border="0">
	<tr id="role-opt-area">
		<?php       echo $this->Form->create('',array('url'=>array('action'=>'index','admin'=>true), 'id'=>'rolefrm','inputDefaults' => array(
				'label' => false,
				'div' => false,
				'error' => false
		)));
		?>
		<td align="left"><?php echo $this->Form->input('', array('name'=>'name','type'=>'text','id' => 'role_name','style'=>'width:150px;','autocomplete'=>'off')); ?>
		</td>
		<td align="left"><?php echo $this->Form->submit('Search', array('id'=>'roleSearch','div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?>
		</td>
		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'index','admin'=>true),array('escape'=>false, 'title' => 'refresh'));?>
		</td>
		<?php echo $this->Form->end();?>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table-format">
  
</table>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr class="row_title">
   <!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></th>
    -->
    <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></th>    
    <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('hasspecility', __('Has Specialty', true)); ?></th>
   <!--   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Location', __('Location', true)); ?></th> -->
    <td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></th>
  </tr>
  <?php 
   $toggle =0;
      if(count($data) > 0) {
       foreach($data as $role): 
    
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
   <!-- <td class="row_format"><?php echo $role['Role']['id']; ?></td>
    -->
   <td class="row_format" align="left"><?php echo ucfirst($role['Role']['name']); ?> </td>
   <td class="row_format" align="left"><?php echo ($role['Role']['hasspecility']==1)?__('Yes'):__('No'); ?> </td>
  <!--  <td class="row_format" align="left"><?php echo ucfirst($role['Location']['name']); ?> </td> -->
   <td class="row_action" align="left">
   <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view', $role['Role']['id']), array('escape' => false));
   
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $role['Role']['id']), array('escape' => false));
   
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $role['Role']['id']), array('escape' => false),__('Are you sure?', true));
   
   ?>
   </td>
   </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="8" align="center">
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
   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
      
        
  ?>
  
 </table>

 <script>
  $= jQuery.noConflict();
  $(document).ready(function(){
    		var data = "Core Selectors Attributes Traversing Manipulation CSS Events Effects Ajax Utilities".split(" ");
			$("#search").autocomplete("<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "search", "admin" => true)); ?>", {
				width: 165,
				selectFirst: false
			});

			$("#role_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Role","name",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst:true });
			
	 	});
	
  </script>
