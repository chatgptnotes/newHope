 <?php echo $this->Html->script(array('jquery.blockUI','animsition.js','animsition.min.js','jquery.fancybox-1.3.4','jquery.tooltipster.min.js'));?>
 <?php echo $this->Html->css(array('animsition.css','animsition.min.css','jquery.fancybox-1.3.4.css','tooltipster.css'));?>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<style>
 .inner_title1 h3 {
	background: rgba(0, 0, 0, 0) url("../img/color_strip_header.png") repeat-x scroll right bottom;
    color: #31859c;
    font-size: 25px;
    margin: 0;
    padding-bottom: 3px;
    padding-top: 0px;
}
</style>  
<div class="inner_title">
<?php if($is_exist=='1'){?>
	<body class="animsition">
	<h3 style="font-size:25px;">
	<?php if($this->params->query['type'] == 'slideeight'){
		$dashType = 'LAB';
 	}else if($this->params->query['type'] == 'slidenine'){
		$dashType = 'IPD';
	}else if($this->params->query['type'] == 'slideten'){
		$dashType = 'OPD';
	}
 	?>
		<?php echo __('Laboratory Dashboard('.$dashType.')', true); ?>
	</h3>
<?php }else{?>
	<h3>
		<?php echo __('Laboratory Dashboard', true); ?>
	</h3>
	<div class="clr "></div>
<?php }?>	
</div>
<div class="clr "></div>

<?php if($is_exist!='1'){ ?>
<?php echo $this->Form->create('LaboratoryTestOrder',array('type'=>"GET",'action'=>'lab_dashboard','default'=>false,'id'=>'HeaderForm','div'=>false,'label'=>false));?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="formFull" align="center" style="padding: 5px; margin-top: 5px">
	<tr>
		<td width="7%">From:</td>
		<td width="15%"><?php echo $this->Form->input('from', array('id' => 'from_date', 'style'=>'width:110px', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd enterBtn','readonly'=>'readonly', 'div' => false,'type'=>'text'));?>
		</td>
		<td width="7%">To:</td>
		<td width="15%"><?php echo $this->Form->input('to', array('id' => 'to_date', 'style'=>'width:110px', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'textBoxExpnd enterBtn','readonly'=>'readonly', 'div' => false,'type'=>'text'));?>
		</td>
		<td width="7%">Patient:</td>
		<td width="7%"><?php
		
		echo $this->Form->input ( 'patient', array (
				'type' => 'text',
				'div' => false,
				'label' => false,
				'id' => 'patient_name',
				'class' => 'patient_name enterBtn' 
		) );
		echo $this->Form->hidden ( 'patient_id', array (
				'id' => 'patientId' 
		) );
		?></td>
		<td width="7%" style="padding-left: 5px;">Discharged?:</td>
		<td width="7%"> <?php echo $this->Form->input('is_discharge',array('type'=>'checkbox','id'=>'is_discharge','label'=>false ,'class'=>'enterBtn'));?></td>
		<td width="7%" style="padding-left: 2px;">Category</td>
		<td><?php
		
		echo $this->Form->input ( 'category', array (
				'type' => 'text',
				'div' => false,
				'label' => false,
				'id' => 'category_name',
				'class' => 'category_name enterBtn' 
		) );
		echo $this->Form->hidden ( 'category_id', array (
				'id' => 'categoryId',
				'type' => 'text' 
		) );
		?></td>
		<td width="7%" style="padding-left: 10px;">Service</td>
		<td width="7%"><?php
		
		echo $this->Form->input ( 'service', array (
				'type' => 'text',
				'div' => false,
				'label' => false,
				'id' => 'service_name',
				'class' => 'service_name enterBtn' 
		) );
		echo $this->Form->hidden ( 'service_id', array (
				'id' => 'serviceId',
				'type' => 'text' 
		) );
		?></td>
		<td width="7%">
			<table>
				<tr>
					<td>
						<?php echo $this->Html->image('icons/views_icon.png',array('id'=>'Submit','type'=>'submit','title'=>'Search'));?>			
					</td>
					<td>
						<?php echo $this->Html->image('icons/eraser.png',array('id'=>'resett','title'=>'Reset'));?>	
					</td>
					<!--  <td>
						<?php echo $this->Html->image('icons/print.png',array('id'=>'','title'=>'Print'));?>			
					</td>-->
					<td>
						<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'index'),array('escape'=>false,'title'=>'Reload current page'));?>			
					</td>
					<td>
						<?php echo $this->Html->link($this->Html->image('icons/edit-clear.png'),array('action'=>'index','clear'),array('escape'=>false,'title'=>'Clean'));?>
                    </td>
				</tr>
			</table>
		</td>
	</tr>

	<tr class="">
		<td>ReqNo:</td>
		<td><?php echo $this->Form->input('req_no',array('type'=>'text','div'=>false,'class'=>'textBoxExpnd reqNo enterBtn','id'=>'reqNo','label'=>false));?></td>
		<td>Status:</td> <?php $status = array('Pending'=>'PENDING','SampleTaken'=>'SAMPLE TAKEN','Completed'=>'COMPLETED','PrintTaken'=>'PRINT TAKEN','Provisional'=>'PROVISIONAL','Authenticated'=>'AUTHENTICATED','Recieved'=>'RECEIVED');?>
		<td><?php echo $this->Form->input('status',array('class'=>'textBoxExpnd enterBtn','type'=>'select','options'=>array('empty'=>'Please Select',$status),'div'=>false,'label'=>false));?></td>
		<td>Consultant:</td>
		<td><?php echo $this->Form->input('consultant',array('class'=>'textBoxExpnd enterBtn','type'=>'select','empty' =>"Please Select",'options'=>array($doctors),'div'=>false,'label'=>false));?></td>
		<td>Visit</td>
		<?php $type = array('IPD'=>'IPD','OPD'=>'OPD','LAB'=>'LAB'/* ,'RAD'=>'RAD' */,'EMERGENCY'=>'EMERGENCY');?>
		<td><?php echo $this->Form->input('visit',array('class'=>'textBoxExpnd enterBtn','style'=>"width:100px",'type'=>'select','empty'=>'Please Select','options'=>array($type),'div'=>false,'label'=>false));?></td>
		<td style="padding-left: 2px;">Ward</td>
		<td><?php
		
		echo $this->Form->input ( 'ward', array (
				'class' => 'textBoxExpnd enterBtn',
				'type' => 'text',
				'div' => false,
				'label' => false,
				'id' => 'ward_name',
				'class' => 'ward_name' 
		) );
		echo $this->Form->hidden ( 'ward_id', array (
				'id' => 'wardId' 
		) );
		?></td>
		<!--  
		<td style="padding-left: 10px;">BedNo:</td>
		<td><?php
// 		echo $this->Form->input ( 'bed', array (
// 				'type' => 'text',
// 				'div' => false,
// 				'label' => false,
// 				'id' => 'bed_name',
// 				'class' => 'bed_name textBoxExpnd' 
// 		) );
// 		echo $this->Form->hidden ( 'bed_id', array (
// 				'id' => 'BedId',
// 				'type' => 'text' 
// 		) );
		?></td>
		-->
		<td style="padding-left: 10px;">Bar Code:</td>
		<td><?php
		
		echo $this->Form->input ( 'bar_code', array (
				'type' => 'text',
				'div' => false,
				'label' => false,
				'id' => 'bar_code',
				'class' => 'bar_code textBoxExpnd enterBtn' 
		) );
		 
		?></td>
	</tr>
</table>
<?php }?>
<!-- for submiting the form -->
<?php if($is_exist!='1'){
$this->Js->get ( '#Submit' );
// $this->Js->get("#resett").reset();
$this->Js->event ( 'click', $this->Js->request ( array (
		'action' => 'lab_dashboard' 
), array (
		'method' => 'GET',
		'dataExpression' => true,
		'data' => $this->Js->serializeForm ( array (
				'isForm' => false,
				'inline' => true 
		) ),
		'async' => true,
		'update' => '#records',
		'before' => 'loading("formFull","class");',
		'complete' => 'onCompleteRequest("formFull","class");' 
) ) );
echo $this->Js->writeBuffer ();
?>


<!-- Header Form Ends here -->
<?php echo $this->Form->end(); ?>

<div class="clr ht5"></div>

<div id="records"></div>

<div class="clr ht5"></div>
<?php }else{?>
<div id="records"></div>
<?php } ?>
<script>
//load all records from here using ajax
$(document).ready(function(){

	var type = "<?php echo $this->params->query['type']; ?>";
	var is_exist = "<?php echo $is_exist;?>";
	if(is_exist == "1"){
		$(".animsition").animsition({ 
		    inClass: 'fade-out-left-sm',
		    outClass: 'fade-out-right-sm',
		    inDuration: 1500,
		    outDuration: 800,
		    linkElement: '.animsition-link',
		    // e.g. linkElement: 'a:not([target="_blank"]):not([href^=#])'
		    loading: true,
		    loadingParentElement: 'body', //animsition wrapper element
		    loadingClass: 'animsition-loading',
		    loadingInner: '', // e.g '<img src="loading.svg" />'
		    timeout: false,
		    timeoutCountdown: 5000,
		    onLoadEvent: true,
		    browser: [ 'animation-duration', '-webkit-animation-duration'],
		    // "browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
		    // The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
		    overlay : false,
		    overlayClass : 'animsition-overlay-slide',
		    overlayParentElement : 'body',
		    transition: function(url){ window.location.href = "<?php echo $this->Html->url(array('controller'=>'NewLaboratories','action'=>'index',)); ?>"; }
		});
		if(type=='slideeight'){
			setTimeout(function () {    
				window.location.href = "<?php echo $this->Html->url(array("controller" => "NewLaboratories", "action" => "index", '?'=>array('type'=>'slidenine'),'IPD')); ?>"; 
			},12000);
		}else if(type=='slidenine'){
			setTimeout(function () {    
			   	window.location.href = "<?php echo $this->Html->url(array("controller" => "NewLaboratories", "action" => "index", '?'=>array('type'=>'slideten'),'OPD')); ?>"; 
			},12000);
		}else if(type=='slideten'){
		 	setTimeout(function () {    
		    	window.location.href = "<?php echo $this->Html->url(array("controller" => "Users", "action" => "doctor_dashboard", '?'=>array('type'=>'slideone'))); ?>"; 
			},12000);
		}
	}
	$('#bar_code').focus();
	$(".enterBtn").keypress(function(event) {
	    if (event.which == 13) {
	        $("#Submit").trigger('click');
	        event.preventDefault();
	    }
	});
	
	$("#from_date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	});

	$("#to_date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	});

	//on load render lab_dashboard
	var type = "<?php echo $this->params->query['type']?>";
	var is_exist = "<?php echo $is_exist;?>";

	if(is_exist=='1'){ 	console.log(is_exist+'true');
		$.ajax({
			url: '<?php echo $this->Html->url(array('controller'=>'NewLaboratories','action'=>'index_slide_four',$resetFilterFlag));?>',
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success:function(data){
				$("#records").html(data).fadeIn('slow');
				$('#busy-indicator').hide();
			}
		});
	}else if(is_exist!=1){
		//check for rgjayrole
		<?php  
			if(strtolower($this->Session->read('role'))==strtolower(Configure::read('Senior_RGJAY')) ||
					strtolower($this->Session->read('role'))==strtolower('admin')
	        ){ 
		?>
			//return false ; //donot send default request 
		<?php  } ?>
		
		$.ajax({
			url: '<?php echo $this->Html->url(array('controller'=>'NewLaboratories','action'=>'lab_dashboard',$resetFilterFlag));?>',
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success:function(data){
				$("#records").html(data).fadeIn('slow');
				$('#busy-indicator').hide();
			}
		});
	}
	$("#resett").click(function(){
		$("#patientId").val(0);
		document.getElementById("HeaderForm").reset();
	});

	$('.reqNo').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "NewLaboratories", "action" => "autocompleteForReqNo","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			console.log(ui);
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }		
	});

	$('.patient_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "NewLaboratories", "action" => "autocompleteForPatient","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $("#patientId").val(ui.item.id);
			//console.log(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }		
	});

	 
	$('.ward_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "NewLaboratories", "action" => "autocompleteForWard","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $("#wardId").val(ui.item.id);
			//console.log(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }		
	});
	$('.bed_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "NewLaboratories", "action" => "autocompleteForBed","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $("#BedId").val(ui.item.id);
			//console.log(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }		
	});
	$("#service_name").autocomplete({
		source:"<?php echo $this->Html->url(array('controller'=>'NewLaboratories','action'=>'autocompleteForService','admin'=>false,"plugin"=>false))?>",
		minLength: 1,
		select: function( event, ui ){
			$("#serviceId").val(ui.item.id)
		},
		messages: {
	        noResults: '',
	        results: function() {}
	 	}
	})
	$("#category_name").autocomplete({
		source:"<?php echo $this->Html->url(array('controller'=>'NewLaboratories','action'=>'autocompleteForcategory','admin'=>false,"plugin"=>false))?>",
		minLength: 1,
		select: function( event, ui ){
			$("#categoryId").val(ui.item.id)
		},
		messages: {
	        noResults: '',
	        results: function() {}
	 	}
	});
	
});


</script>