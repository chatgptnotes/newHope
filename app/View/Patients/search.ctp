<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');

if(!empty($errors)) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		     		?>
		</td>
	</tr>
</table>
<?php }
if($this->params->query['type']=='OPD'){
	$urlType= 'Ambulatory';
	$serachStr ='OPD';
	$searchStrArr = $this->params->query;
}else if($this->params->query['type']=='emergency'){
	$urlType= 'Emergency';
	$serachStr ='IPD&is_emergency=1';
	$searchStrArr = array('type'=>'IPD','is_emergency'=>1);
	}else if($this->params->query['type']=='IPD'){
		$urlType= 'Inpatient' ;
		$serachStr ='IPD&is_emergency=0' ;
		$searchStrArr = array('type'=>'IPD','is_emergency'=>0);
	}
	$queryStr =  $this->General->removePaginatorSortArg($this->params->query) ;


	?>
<style>
label {
	width: 126px;
	padding: 0px;
}

.ui-datepicker-trigger {
	padding: 0px 0 0 0;
	clear: right;
}

.tddate img {
	float: inherit;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php
		if($this->params->query['mod']=='assessment'){
			echo $urlType.' - ';?>
		<?php echo __('Assessment', true);
		}else{
			if($this->params->query['listflag'] == "appt") {
			  echo __('Set Future Appointment');
			} else {
			  echo $urlType.' - ';?>
		<?php if($this->params->query['patientstatus']=='processed') echo __('Process Done Enquiry', true); else if ($this->params->query['patientstatus']=='discharged') echo __('Discharged Patient Enquiry', true); else echo __('Patient Enquiry', true);
			}
		}
		?>
	</h3>
	<!-- <span><?php 
	/*echo $this->Html->link(__('Patient MRN'), array('action' => 'add',"?"=>array('type'=>$this->params->query['type'])), array('escape' => false,'class'=>'blueBtn'));
	if($this->Session->read('role')=='doctor'){
			if(empty($this->params->query['doctor_id'])){
				$btnLabel   = 'My Patient';
				$btnAction = array('?'=>array_merge($queryStr,array('doctor_id'=>$this->Session->read('userid'))));
			}else{
				$btnLabel   = 'All Patient' ;
				$btnAction = array('?'=>array_merge($queryStr,array('doctor_id'=>'')));
			}

			echo $this->Html->link($btnLabel,$btnAction,array('escape'=>false,'class'=>'blueBtn'));
		}
		*/	
		?></span> -->
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Patient',array('action'=>'search','type'=>'get'));?>
<table border="0" class=" " cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tbody>

		<tr class="row_title">
			<td class="tdLabel" id="boxSpace" align="left"><?php echo __('DOB') ?>
					:</td>
			<td class="tddate"><?php echo $this->Form->input('dob', array('id' => 'dob_search','label'=> false, 'type'=>'text',
					'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd','readonly'=>'readonly'));
			?>
			</td>
		 <!--   <td class="tdLabel" id="boxSpace" align="right"><?php //echo __('AADHAR NO') ?> :
			</td>
			<td class=" "><?php 
			//echo // $this->Form->input('Person.ssn_us', array('type'=>'text','class' =>'textBoxExpnd','id' => 'ssn_us_search', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:130px'));?>
			
			</td>	-->

			<td class="tdLabel" id="boxSpace" align="right" width="12%"><?php echo __('Patient Name') ?>
					:</td>
			<td class=" "><?php 
			echo $this->Form->hidden('type',array('value'=>$this->request->query['type']));
			echo $this->Form->hidden('patientstatus',array('value'=>$this->params->query['patientstatus']));
			echo $this->Form->hidden('listflag',array('value'=>$this->params->query['listflag']));
			echo    $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
			?>
			</td>
			<!-- <td class=" " align="right"><label><?php echo __('MRN') ?> :</label>
			</td>
			<td class=" "><?php 
			echo    $this->Form->input('admission_id', array('type'=>'text','id' => 'patient_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
			?>
			</td> -->
			<td class=" " align="center"><?php
			echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));
			?>
			</td>
		</tr>
	</tbody>
</table>
<?php echo $this->Form->end();?>
<div
	class="clr inner_title" style="text-align: right;"></div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<?php if(isset($data) && !empty($data)){
		//set get variables to pagination url
		$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
		?>
	<tr class="row_title">
		<td class="table_cell"><?php echo __('DOB') ?>
		</td>
	<!--  	<td class="table_cell"><?php //echo __('AADHAR NO') ?></td>-->
		<td class="table_cell"><?php echo __('Last Name') ?></td>
		<td class="table_cell"><?php echo __('First Name') ?></td>
		<?php if($this->params->query['mod']=='assessment'){ ?>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.lookup_name', __('Lookup Name', true)); ?>
		</strong></td>
		<?php } ?>
		<td class="table_cell"><?php echo __('Phone Number') ?></td>
		<td class="table_cell"><?php echo __('Primary Care Provider') ?></td>
		<td class="table_cell"><?php echo __('Department') ?></td>
		<!--  <td class="table_cell"><?php //echo __('Address') ?></td>-->
		<td class="table_cell"><?php echo __('Gender') ?></td>
		<td class="table_cell"><?php echo __('Status') ?></td>
		<td class="table_cell">&nbsp;</td>
	</tr>
	<?php 
	$toggle =0;
	if(count($data) > 0) {
      		foreach($data as $patients){

			       if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }
			       ?>
	<td class="row_format"><?php echo substr($this->DateFormat->formatDate2Local($patients['Person']['dob'],Configure::read('date_format'),true),0,10); ?>
	</td>
	<!--  <td class="row_format"><?php echo $patients['Person']['ssn_us']; ?></td>-->
	<?php if($this->params->query['listflag'] == "appt") {?>
	<td class="row_format"><?php echo  $this->Html->link(ucfirst($patients['Person']['last_name']),array('controller'=>'doctor_schedules','action' => 'doctor_event','patientid'=>$patients['Patient']['id'],'listflag' => 'appt','patientstatus' =>$this->params->query['patientstatus'],'?'=>$searchStrArr), array('escape' => false,'title'=>'Set Appointment')); ?>
	</td>
	<td class="row_format"><?php echo $this->Html->link(ucfirst($patients['Person']['first_name']),array('controller'=>'doctor_schedules','action' => 'doctor_event','patientid'=>$patients['Patient']['id'],'listflag' => 'appt','patientstatus' =>$this->params->query['patientstatus'],'?'=>$searchStrArr), array('escape' => false,'title'=>'Set Appointment')); ?>
	</td>
	<?php }else{ ?>
	<td class="row_format"><?php echo  $this->Html->link(ucfirst($patients['Person']['last_name']), array('action' => 'patient_information',$patients['Patient']['id'],'patientstatus' =>$this->params->query['patientstatus'],'?'=>$searchStrArr), array('escape' => false,'title'=>'Patient Info.')); ?>
	</td>
	<td class="row_format"><?php echo $this->Html->link(ucfirst($patients['Person']['first_name']), array('action' => 'patient_information',$patients['Patient']['id'],'patientstatus' =>$this->params->query['patientstatus'],'?'=>$searchStrArr), array('escape' => false,'title'=>'Patient Info.')); ?>
	</td>
	<?php } ?>
	<?php  	
	if($this->params->query['mod']=='assessment'){
   			 // if surfing through appointmnent //
   			 	if($this->params->query['listflag'] == "appt") {
   					echo $this->Html->link(__('Select Patient!'), array('controller'=>'doctor_schedules', 'action' => 'doctor_event', 'patientid'=> $patients['Patient']['id'], 'listflag' => 'appt', 'patientstatus'=>$this->params->query['patientstatus'],'?'=>$searchStrArr), array('escape' => false,'title'=>'Set Appointment', 'class'=>'blueBtn'));
   				} else { ?>
	<td class="row_format"><?php echo ucfirst($patients[0]['lookup_name']); ?>
	</td>
	<?php } 
		}?>
	<?php $patentFullAddress =  $patients['Person']['plot_no'].','.$patients['Person']['city'].','.$patients['State']['name'].','.$patients['Country']['name'] ;
	if($patentFullAddress == ',,,')
		$patentFullAddress = '';
	?>
	<td class="row_format"><?php echo $patients['Person']['mobile']; ?>
	</td>
	<td class="row_format"><?php echo $patients['Initial']['name']." ".$patients[0]['name']; ?>
	</td>
	<td class="row_format"><?php echo $patients['Department']['name']; ?>
	</td>
<!--	<td class="row_format"><?php echo $patentFullAddress ; ?></td>-->
	<?php //$gender=ucfirst($patients['Person']['sex'])?>
	<td class="row_format"><?php if(strtolower($patients['Person']['sex'])=='male'){
		echo $this->Html->image('/img/icons/male.png');
	}else if(strtolower($patients['Person']['sex'])=='female'){
		echo $this->Html->image('/img/icons/female.png');
	}  	?>
	</td>
	<?php $status = ($this->request->query['patientstatus'] == 'discharged') ? 'Discharged' : 'Active';?>
	<td class="row_format"><?php echo $status ?></td>

	<td><?php
	//define action on the basis referer link
	if($this->params->query['mod']=='assessment'){
   				echo $this->Html->link($this->Html->image('icons/uerInfo.png',array('style'=>'height:20px;width:18px;')), array('controller'=>'diagnoses','action' => 'add', $patients['Patient']['id'],"?"=>array('return'=>'assessment')), array('escape' => false,'title'=>'Patient Info.'));
   			}else{
   				// if surfing through appointmnent //
   				if($this->params->query['listflag'] == "appt") {
   					//echo $this->Html->link(__('Select Patient!'), array('controller'=>'doctor_schedules', 'action' => 'doctor_event', 'patientid'=> $patients['Patient']['id'], 'listflag' => 'appt', 'patientstatus'=>$this->params->query['patientstatus'],'?'=>$searchStrArr), array('escape' => false,'title'=>'Set Appointment', 'class'=>'blueBtn'));
   				} else {
   			//	   //echo $this->Html->link($this->Html->image('icons/uerInfo.png',array('style'=>'height:20px;width:18px;')), array('action' => 'patient_information', $patients['Patient']['id'],'patientstatus'=>$this->params->query['patientstatus'],'?'=>$searchStrArr), array('escape' => false,'title'=>'Patient Info.'));
   				}
   			}
   			?>
	</td>
	<?php }?>
	</tr>
	<?php } 
	$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
	?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		
		</TD>
	</tr>
	<?php  ?>
	<?php					  
	} else {
			 ?>
	<tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
      }
      ?>
</table>
<script>
	//script to include datepicker
$(function() {
	$("#dob_search").datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-100:' + new Date().getFullYear(),
	maxDate : new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>', 
});
});
$('#PatientSearchForm').submit(function(){
	var msg = false ; 
	$("form input:text").each(function(){
	       //access to form element via $(this)
	       if($(this).val() !=''){
	       		msg = true  ;
	       }
	    }
	);
	if(!msg){
		alert("Please fill atleast one field .");
		return false ;
	}		
});
 $(document).ready(function(){
    	 $("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null','null','null','admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#dob_search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","dob",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
	 	});
  </script>
