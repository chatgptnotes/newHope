<?php
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>
<style>
.row_action img{
float:inherit;
}
</style>
<div class="inner_title">
<h3>&nbsp; <?php echo __('SMS Group', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Add Group'),array('action' => 'groupAdd'),array('escape' => false,'class'=>'blueBtn'));
echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'menu','admin'=>true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px'));
?>
</span>
</div>
<?php   echo $this->Form->create('',array('url'=>array('action'=>'groupIndex'),'type'=>'get','id'=>'servicefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
		)));?>

<table border="0" class=" " cellpadding="2" cellspacing="0" align="center">
	<tbody>
		<tr class="row_title">		
		<td class=" " align="center" style="padding-left: 5px;">
				<?php echo __('Group') ?> :
		</td>
		<td align="left"><?php echo $this->Form->input('', array('name'=>'first_name_search','type'=>'text','value'=>$this->params->query['first_name_search'],'id' => 'first_name_search','style'=>'width:150px;','autocomplete'=>'off')); ?>
		<?php echo $this->Form->hidden('',array('id'=>'groupServiceSubId','name'=>'groupServiceSubId'));?>
		</td>
		
		<td align="left"><?php echo $this->Form->submit('Search', array('id'=>'reffSearch','div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?>
		</td>
		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'groupIndex','admin'=>false),array('escape'=>false, 'title' => 'refresh'));?>
		</td>
		<td><?php 
    $qryStr=$this->request->data;

          echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel','?'=>$qryStr),array('escape'=>false,'title' => 'Export To Excel','style'=>"float:right !important;"));?>
		</td>
		
		<td id="printButton" style="float: right;">
		<?php echo $this->Html->link($this->Html->image('icons/print.png'),'#',
				array('style'=>'width:20px','name'=>'print','title' => 'Print','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>$this->params->action,'print',
				'?'=>$qryStr))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
		</td>		
	</tr>
	</tbody>
</table>
<?php echo $this->Form->end();?>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr class="row_title">
    <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></strong></td>
	<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('is_active', __('Active', true)); ?></strong></td>
    <td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
      $cnt =0;	
      if(count($data) > 0) {
       foreach($data as $datas): 
        $cnt++;
	  
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format" align="left"><?php echo $datas['GroupSms']['name']; ?> </td>
    <td class="row_format" align="left">
	 <?php if($datas['GroupSms']['is_active'] == 1) {          
	           $imgSrc = 'active.png';
	           $activeTitle = 'Active';
	           $status = 0;
          } else {           
	           $imgSrc = 'inactive.jpg';
	           $activeTitle = 'InActive';
	           $status = 1;
          }
    echo $this->Html->link($this->Html->image('icons/'.$imgSrc), array('action' => 'change_status', $datas['GroupSms']['id'],$status), array('admin'=>false,'escape' => false,'title' => $activeTitle, 'alt'=>$activeTitle)); ?></td>
   <td class="row_action" align="left">
   <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'groupView', $datas['GroupSms']['id']), array('escape' => false,'title' => 'View', 'alt'=>'View'));
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => __('Edit', true), 'alt' => __('Edit', true))), array('action' => 'groupEdit', $datas['GroupSms']['id']), array('escape' => false));  
   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title' => __('Delete', true), 'alt' => __('Delete', true))), array('action' => 'groupDelete', $datas['GroupSms']['id']), array('escape' => false),__('Are you sure?', true));   
   ?>
   <?php 
    $qryStr=$this->request->data;

          echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',$datas['GroupSms']['id'],'?'=>$qryStr),array('escape'=>false,'title' => 'Export To Excel','style'=>"float:left !important;"));?>
		
		
		<span id="printButton" style="float: left;">
		<?php echo $this->Html->link($this->Html->image('icons/print.png'),'#',
				array('style'=>'width:20px','name'=>'print','title' => 'Print','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>$this->params->action,'print',$datas['GroupSms']['id'],
				'?'=>$qryStr))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
		</span>	
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
$(function() {
		/*$("#first_name_search").autocomplete("<?php echo $this->Html->url(array("controller" => "tariffs", "action" => "autocomplete","TariffList","name",'null','null','null', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });*/
		$("#first_name_search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","GroupSms","id",'name','null','null','null','null','null', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			loadId : 'name,groupServiceSubId',
			showNoId:true,
			valueSelected:true,
		});
 });
</script>
