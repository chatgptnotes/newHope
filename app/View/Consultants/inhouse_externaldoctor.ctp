<?php
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#consultantsearchfrm").validationEngine();
	});
	
</script>

<div class="inner_title">
	<h3>	
		<div style="float:left"><?php echo __('In-House & External Doctor');?></div>			
			
	</h3>
	<div class="clr"></div>
</div>

<form name="consultantsearchfrm" id="consultantsearchfrm" action="<?php echo $this->Html->url(array("action" => "inhouse_externaldoctor")); ?>" method="post" onSubmit="return Validate(this);" >
<table border="0" class="table_format"  cellpadding="3" cellspacing="0" width="100%" align="center">
  <tr class="row_title">				 
   <td class=" " align="left" width="12%"><?php echo __('First Name') ?> :</td>								
   <td class=" ">
    <?php 
        echo $this->Form->input('consultant_first_name_search', array('id' => 'customFirstName', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
    ?>
   </td>
<td class=" " align="left" width="12%"><?php echo __('Last Name') ?> :</td>								
   <td class=" ">
    <?php 
        echo $this->Form->input('consultant_last_name_search', array( 'id' => 'customLastName', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
    //'class' => 'validate[required,custom[customname]]',
        ?>
   </td>
	<td>
   <?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?>
   <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'inhouse_externaldoctor'),array('escape'=>false, 'title' => 'refresh'));?>
   </td>
  </tr>	
</table>	
 <?php echo $this->Form->end();?>
<div class="inner_title" style=" text-align:right;">
  <?php //echo $this->Html->link('Add Consultant',array("action" => "add"), array('class' => 'blueBtn','escape' => false)); ?>
</div>
<div id="listcontent">
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
   <tr class="row_title">
    
   <td class="table_cell"><strong><?php echo __('First Name', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Last Name', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('NPI No', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('CAQH Provider ID', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Email', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Mobile', true); ?></strong></td>
   <td class="table_cell" ><strong><?php echo  __('Type', true); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $consultant):
         $cnt++
  ?>
   <tr <?php if($cnt%2 ==0) { echo "class='row_gray'"; }?> >
   
   <td class="row_format"><?php echo $consultant['Initial']['name']." ".$consultant['Consultant']['first_name']; ?> </td>
   <td class="row_format"><?php echo $consultant['Consultant']['last_name']; ?> </td>
   <td class="row_format"><?php echo $consultant['Consultant']['npi_no']; ?> </td>
   <td class="row_format"><?php echo $consultant['Consultant']['caqh_provider_id']; ?> </td>
   <td class="row_format"><?php echo $consultant['Consultant']['email']; ?> </td>
   <td class="row_format"><?php echo $consultant['Consultant']['mobile']; ?> </td>
   <td class="row_format"> <?php echo $consultant['ReffererDoctor']['name']; ?></td>
   <td>
   <?php 
   		echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'external_consultant_view', $consultant['Consultant']['id'], 'admin'=> false), array('escape' => false,'title' => 'View', 'alt'=>'View'));
   ?>
      <?php 
   		//echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $consultant['Consultant']['id']), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
   ?>
   <?php 
   		//echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $consultant['Consultant']['id']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));
     ?>
  </tr>
  <?php endforeach;  ?>
  <?php
  
      } else { $consultantzero = true;
      }
  ?>
   <?php $treatingconsultantzero = false;
      $treatingconsultcnt =$cnt;
      if(count($treatingconsultdata) > 0) {
       foreach($treatingconsultdata as $treatingconsultant):
         $cnt++
  ?>
   <tr <?php if($cnt%2 ==0) { echo "class='row_gray'"; }?> >
   
   <td class="row_format"><?php echo $treatingconsultant['Initial']['name']." ".$treatingconsultant['Doctor']['first_name']; ?> </td>
   <td class="row_format"><?php echo $treatingconsultant['Doctor']['last_name']; ?> </td>
   <td class="row_format"><?php echo $treatingconsultant['DoctorProfile']['npi_no']; ?> </td>
   <td class="row_format"><?php echo $treatingconsultant['Doctor']['caqh_provider_id']; ?> </td>
   <td class="row_format"><?php echo $treatingconsultant['Doctor']['email']; ?> </td>
   <td class="row_format"><?php echo $treatingconsultant['Doctor']['mobile']; ?> </td>
   <td class="row_format"> <?php if( $treatingconsultant['DoctorProfile']['is_registrar'] == 1) echo __('Registrar'); else echo __(Configure::read('doctor'));; ?></td>
   <td>
   <?php 
   		echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'treatingconsultant_view', $treatingconsultant['Doctor']['id'], 'admin'=> false), array('escape' => false,'title' => 'View', 'alt'=>'View'));
   ?>
      <?php 
   		//echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $consultant['Consultant']['id']), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
   ?>
   <?php 
   		//echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $consultant['Consultant']['id']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));
   ?>
  </tr>
  <?php endforeach;  ?>
  <?php
  
      } else { $treatingconsultantzero = true;
      }
  ?>
<?php if($treatingconsultantzero == true && $consultantzero == true) { ?>
<tr>
   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
</tr>
<?php } ?>
 </table>
</div>
<script>
  $(document).ready(function(){
    	 
			$("#customFirstName").autocomplete("<?php echo $this->Html->url(array("controller" => "consultants", "action" => "autocompelete_inhouseconsultant",'first_name', "admin" => false,"plugin"=>false, 'superadmin' => false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#customLastName").autocomplete("<?php echo $this->Html->url(array("controller" => "consultants", "action" => "autocompelete_inhouseconsultant",'last_name', "admin" => false,"plugin"=>false, 'superadmin' => false)); ?>", {
				width: 250,
				selectFirst: true
			});
			
	 	});
  </script>
