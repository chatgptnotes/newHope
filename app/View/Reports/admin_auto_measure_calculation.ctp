<?php
	echo $this->Html->script('jquery.autocomplete');
	echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
<h3> &nbsp; <?php echo __('Measure Calculation', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),array('action' => 'all_report'), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<form name="measurecalfrm" id="measurecalfrm" action="<?php echo $this->Html->url(array("action" => "auto_measure_calculation")); ?>" method="get"  >
<table border="0" class="table_format"  cellpadding="3" cellspacing="0" width="100%" align="center">
  
   <tr class="row_title">
  	<td class=" " align="left" width="12%"><?php echo __('From') ?><font color="red">*</font>
				:</td>
			<td class=" "><?php 
			echo $this->Form->input('', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','name' => 'from', 'id' => 'from', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
			?>
			</td>
			<td class=" " align="left" width="12%"><?php echo __('To') ?><font color="red">*</font>
				:</td>
			<td class=" "><?php 
			echo $this->Form->input('', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','name' => 'to', 'id' => 'to', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));

			?>
			</td>
	
	<td >
	
	<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png', array('style' => 'padding-top:15px;')),array('action'=>'auto_measure_calculation'),array('escape'=>false, 'title' => 'refresh'));?>
    <?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','id'=>'search','div'=>false,'label'=>false, 'onclick' => 'return getValidate();')); ?>
    
     </td>
  </tr>	
</table>
<?php echo $this->Form->end();?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="10" align="right">
  <?php 
     echo $this->Html->link(__('Add User'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  </td>
  </tr>
 <tr class="row_title">
   <td class="table_cell"><strong><?php echo __('Sr.No.', true); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorProfile.doctor_name', __('Doctor Name', true)); ?></td>
   <td class="table_cell"><strong><?php echo __('Measure Count', true); ?></td>
   <td class="table_cell"><strong><?php echo __('Total Count', true); ?></td>
   <td class="table_cell"><strong><?php echo __('Measure Calculation', true); ?></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $user): 
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format"><?php echo $cnt; ?></td>
   <td class="row_format"><?php echo $user['Initial']['name']."&nbsp;".$user['DoctorProfile']['doctor_name']; ?> </td>
   <td class="row_format" ><?php if($firstStageNumeratorCountArray[$user['User']['id']]) echo $firstStageNumeratorCountArray[$user['User']['id']]; else echo "0"; ?> </td>
   <td class="row_format" ><?php if($firstStageDenominatorCountArray[$user['User']['id']]) echo $firstStageDenominatorCountArray[$user['User']['id']]; else echo "0"; ?> </td>
   <td >
   <?php 
        if($firstStageNumeratorCountArray[$user['User']['id']] > 0 && $firstStageDenominatorCountArray[$user['User']['id']] > 0) {
            $measureCalculation = ($firstStageNumeratorCountArray[$user['User']['id']]/$firstStageDenominatorCountArray[$user['User']['id']])*100;
            echo $this->Number->toPercentage($measureCalculation);
        } else {
            echo  "0.00%";
        }
   ?>
   </td>
   <td class="row_format">
   <?php echo $this->Html->link(__('More Details'),array('action'=>'doctor_measure_calculation',$user['User']['id']),array('escape'=>false, 'title' => 'More Details', 'alt' => 'More Details'));?>
   </td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="10" align="center">
    <?php echo $this->Paginator->options(array("url" => array("?"=>"from=$from&to=$to&first_name=$first_name&last_name=$last_name"))); ?>
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
		$("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","User","first_name",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
		$("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","User","last_name",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
			
			
		$("#from").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: '<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}			
		});	
			
	 $("#to").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: '<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}			
		});
	});
	   $( "#measurecalfrm" ).click(function(){
           var fromdate_split = $( "#from" ).val().split("/");
           var todate_split = $( "#to" ).val().split("/");
var fromdate = new Date(fromdate_split[2], fromdate_split[1], fromdate_split[0]);
           var todate = new Date(todate_split[2], todate_split[1], todate_split[0]);
           if(fromdate > todate) {
            alert("To date should be greater than from date");
            return false;
           }
           
});	
	  
	   jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#measurecalfrm").validationEngine();
			});	
	/*function getValidate(){  
		
		var SDate = document.getElementById('from').value;
		var EDate = document.getElementById('to').value;
		var from = SDate.split('/');
		var to = EDate.split('/');
		var fromDate = from[1]+'/'+from[0]+'/'+from[2];
		var toDate = to[1]+'/'+to[0]+'/'+to[2];
		var startDate = new Date(fromDate);
		var endDate = new Date(toDate);
		if (SDate == '' || EDate == '') {
		 alert("Plesae enter both the dates!");
		 return false;
		}else if((startDate) > (endDate)){
		 alert("Please ensure that the End Date is greater than to the Start Date.");
		 return false;
		}
		
	}*/
</script>
