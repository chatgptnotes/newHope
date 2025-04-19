<?php
echo $this->Html->script(array('jquery.autocomplete','jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.autocomplete.css','jquery.fancybox-1.3.4.css'));
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('User Management', true); ?>
	</h3>
	<span> <?php
	if($this->Session->read('website.instance')=='vadodara'){
		echo $this->Html->link(__('Import User'), array('action' => 'admin_import_data'), array('escape' => false,'class'=>'blueBtn'));
	}
		
  if($this->params->query['newUser']=='ls'){	
		echo $this->Html->link(__('Add User'), array('action' => 'employee_add'), array('escape' => false,'class'=>'blueBtn'));
	}else{ 
		echo $this->Html->link(__('Add User'), array('action' => 'add','admin'=>true), array('escape' => false,'class'=>'blueBtn')); 	
	}echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'admin_menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px'));
	//debug() ?>
	</span> 
</div>
<form name="usersearchfrm" id="consultantsearchfrm"
	action="<?php echo $this->Html->url(array("action" => "index")); ?>"
	method="get">
	<table border="0" class="table_format" cellpadding="3" cellspacing="0"
		width="100%" align="center" style="padding-bottom:0px!important;">
		<tr class="row_title">
			<td class=" " align="left" width="2%"><?php echo __('First Name') ?>
				:</td>
			<td class="row_title" width="1%"><?php 
			echo $this->Form->input('', array('name' => 'newUser', 'id' => 'newUser','type'=> 'hidden','value'=>$this->params->query['newUser']));
			echo $this->Form->input('', array('name' => 'first_name', 'id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
			?>
			</td>
			<td class=" row_title" align="left" width="2%"><?php echo __('Last Name') ?>
				:</td>
			<td class="row_title" width="1%"><?php 
			echo $this->Form->input('', array('name' => 'last_name', 'id' => 'last_name', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));

			?>
			</td>
			<td class=" row_title" align="left" width="2%"><?php echo __('Rol') ?>:</td>
			<td class="row_title" width="1%"><?php 
			echo $this->Form->input('', array('name' => 'role', 'id' => 'role', 'label'=> false, 'div' => false, 'error' => false, 'options'=>$roles ,'autocomplete'=>false,'empty'=>'Please Select'));
			?>
			</td>
			<td width="1%"><?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?></td>
			<td width="20%"><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'index'),array('escape'=>false, 'title' => 'refresh'));?></td>
		</tr>
	    <tr >
	    
	    <td width="80%" colspan="11" style="padding-right:0px !important;"><div style="float:right;">
	    
	    
	    <?php echo $this->Html->link(__('Guarantor', true),array('controller'=>'Users','action' => 'admin_index/3'), array('escape' => false,'class'=>'blueBtn','style'=>'float:right;height:15px!important;')); ?>
			
			
			<?php echo $this->Html->link(__('Authorized User', true),array('controller'=>'Users','action' => 'admin_index/2'), array('escape' => false,'class'=>'blueBtn','style'=>'float:right;height:15px!important; margin:0 10px;')); ?>
	
			
			<?php echo $this->Html->link(__('Active Users', true),array('controller'=>'Users','action' => 'admin_index/1'), array('escape' => false,'class'=>'blueBtn','style'=>'float:right;height:15px!important;margin-left:10px;'));
			
			///echo $this->Form->button(__('Active Users'),array('class'=>'blueBtn','div'=>false,'label'=>false,'style'=>'float:right;','id'=>'active')); ?>
			<?php echo $this->Html->link(__('Inactive Users', true),array('controller'=>'Users','action' => 'admin_index/0'), array('escape' => false,'class'=>'blueBtn','style'=>'float:left;height:15px!important;')); ?>
			</div>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
	<?php
     if($data){
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			}
			?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="padding-top:0px!important;">
		<tr class="row_title">
			<!--  <td class="table_cell"><strong><?php echo $this->Paginator->sort('User.id', __('Id', true)); ?></td>-->
			
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.username', __('Username', true)); ?></td>
			
			<td class="table_cell">&nbsp;</td>
			<td class="table_cell"><?php echo $this->Paginator->sort('User.hr_code', __('Hr Code', true)); ?></td>
			
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.first_name', __('First Name', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.last_name', __('Last Name', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.email', __('Email', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.mobile', __('Mobile', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('Role.name', __('Role', true)); ?>
			
			</td>
			 <td class="table_cell"><strong><?php echo $this->Paginator->sort('User.location_id', __('Location', true)); ?></td>
			 <td class="table_cell"><strong><?php echo $this->Paginator->sort('User.is_active', __('Active', true)); ?></td>
   
			<td class="table_cell"><strong><?php echo __('Action', true); ?>
			
			</td>
		</tr>
		<?php //debug($activeFlag);
		$cnt =0;
		if(count($data) > 0) {
       foreach($data as $user):
       $cnt++;
       
      
       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<!-- <td class="row_format"><?php echo $user['User']['id']; ?></td>
    -->
			<td class="row_format"><?php echo $user['User']['username']; ?>
			</td>
			<td class="row_format"><?php if(($user['User']['gender'])=='M'){
								echo $this->Html->image('/img/icons/male.png');
								}else if(($user['User']['gender'])=='F'){
							echo $this->Html->image('/img/icons/female.png');
						}  	?>
					</td>
			<td class="row_format"><?php echo $user['User']['hr_code']; ?>
			</td>
			<td class="row_format"><?php echo $user['User']['first_name']; ?>
			</td>
			<td class="row_format"><?php echo $user['User']['last_name']; ?>
			</td>
			<td class="row_format"><?php echo $user['User']['email']; ?>
			</td>
			<td class="row_format"><?php echo $user['User']['mobile']; ?>
			</td>
			<td class="row_format"><?php echo $user['Role']['name']; ?>
			</td>
			<td class="row_format"><?php echo $user['Location']['name']; ?>
			</td>
			<td class="row_format"> <?php if($user['User']['is_active'] == 1) {
								           echo __('Yes', true); 
								          } else { 
								           echo __('No', true);
								          }?> 
		   </td>
   
			<td><?php 
			echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view',  $user['User']['id'],'?'=>array('activeFlag'=>$activeFlag)), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));
			?> <?php if($this->params->query['newUser']=='ls'){
				//if((strtolower($user['Role']['name']) == strtolower(Configure::read("doctorLabel")))){
					echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'employee_add', $user['User']['id'],'?'=>array('activeFlag'=>$activeFlag)), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
				//}
			}else{
				echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'edit', $user['User']['id'],'?'=>array('activeFlag'=>$activeFlag)), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
			}
			?> <?php if($this->params->query['newUser'] != 'ls'){ 
				echo $this->Html->link($this->Html->image('icons/id_card.png'),'#',
   				array('id'=>'userIdCard','onclick'=>'javascript:userIdCard('.$user['User']['id'].')','escape' => false,'title' => __('ID Card', true), 'alt'=>__('ID Card', true)));
  		 }?><?php
   
   if($isfingerPrintSupportEnable=="1")
   {   
   if($this->params->query['newUser']=='ls'){
			echo $this->Html->link($this->Html->image('icons/edit_claims.png'),array('action' => 'finger_print', $user['User']['id'],'?'=>$user['User']['id'].'&newUser=ls','admin'=>false), array('escape' => false,'title' => __('Finger Print', true), 'alt'=>__('Finger Print', true)));
	}else{
		echo $this->Html->link($this->Html->image('icons/edit_claims.png'),array('action' => 'finger_print', $user['User']['id'],'?'=>$user['User']['id'],'admin'=>false), array('escape' => false,'title' => __('Finger Print', true), 'alt'=>__('Finger Print', true)));
	}
   }

			?>  <?php
   if(($user['Role']['name'] != "admin" || $user['User']['created_by'] == $this->Session->read('userid')) && $user['User']['id'] != $this->Session->read('userid')) {
    echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $user['User']['id']), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));
   }


   ?></td>
		</tr>
		<?php endforeach;  ?>
		<tr>
		
			<TD colspan="11" align="center">
			<?php
           if($user){
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			}
			?>
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
			<TD colspan="11" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
      }
      ?>
	</table>

	<script>

	function userIdCard(id) {

	$.fancybox({
							'width' : '16%',
							'height' : '47%',
							'autoScale' : true,
							'transitionIn' : 'fade',
							'transitionOut' : 'fade',
							'type' : 'iframe',
							'href' : "<?php echo $this->Html->url(array("action" => "userIdCard", )); ?>"+ '/' + id
						});

			};
			
	
	$(function() {
		$("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","User","first_name",'null','null','no', 'null','null','first_name',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
		$("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","User","last_name",'null','null','no','null','null','last_name', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
	});


	$('#active').click(function (){
		currentId = $(this).attr('id') ;
		splittedVar = currentId.split("_");
		recordId = splittedVar[1];
		var active="yes";
		//var editInsuranceAuthorizationURL = "<?php //echo $this->Html->url(array("controller" => 'Insurances', "action" => "newInsuranceAuthorization","admin" => false)); ?>"+"/"+recordId+"/"+flag ;
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => 'Users', "action" => "ajaxActiveUser","admin" => false)); ?>"+"/"+active,
			  context: document.body,	
			  //data : formData, 	  		  
			  success: function(data){
				 // parent.location.reload(true);
				 $("#user_report").html(data);
			  }
		});	
	});
</script>