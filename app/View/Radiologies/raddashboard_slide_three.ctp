<?php echo $this->Html->script(array('topheaderfreeze','animsition.js','animsition.min.js'));
	echo $this->Html->css(array('animsition.css','animsition.min.css'));
?>
<style>
tr.received td {
	background-color: #97BB72;
}

tr.pending td {
	background-color: #DDDDDD;
}

.tabularForm {
	background-color: none;
}

.roundClass {
	border-bottom-right-radius: 4px;
	border-bottom-left-radius: 4px;
	border-top-left-radius: 4px;
	border-top-right-radius: 4px;
	border: 1px solid #4c5e64;
	background: none repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
	width: 90% !important;
}

.inner_title1 h3 {
	background: rgba(0, 0, 0, 0) url("../img/color_strip_header.png") repeat-x scroll right bottom;
    color: #31859c;
    display: block;
    font-size: 25px;
    width: 100%;
	padding-bottom: 3px;
    padding-top: 0px !important; 
}
.tabularForm1 th {
    background: #8b8b8b none repeat scroll 0 0 !important;
    border-top: 1px solid #3e474a;
    color: white !important;
    margin-top: 0;
    padding-top: 5px;
    font-size: 25px;
    font-weight: bold;
}

.tabularForm1 td {
   /* background: #ddd none repeat scroll 0 0;*/
    color: #000;
    font-size: 25px;
    padding: 3px 8px;
    font-weight: bold;
}
.row_gray {
    background-color: silver;
    border-top: 1px solid #000;
    margin: 0;
    padding: 7px 3px;
    font-weight: bold;
}
</style>

<div class="inner_title1" >
<?php if($this->params['pass'][0]=='IPD'){
	$type = 'IPD';
}else if($this->params['pass'][0]=='OPD'){
	$type = 'OPD';
}else if($this->params['pass'][0]=='RAD'){
	$type = 'RAD';
}?>
    <h3><?php echo __('Radiology DashBoard('.$type.')', true); ?></h3>
    
</div>
<body class="animsition">
<div id="mainDiv" style="display: block;">

<!-- form elements start-->


<table border="0" class="tabularForm1" cellpadding="" cellspacing="1" width="100%" id="records">
<?php if(isset($data) && !empty($data)){ ?>
        <thead>
            <tr class="light fixed table_format1;" id="" style="overflow: auto;">
                <!--  <th style="text-align: center; width:2%">Sr.No</th>-->
                <th style="text-align: center; width:1%">Sex</th> 
                <th style="text-align: center; width:15%">PATIENT</th>
                <!--  <th style="text-align: center;width:6%">Patient ID</th>-->
                <!--  <th style="text-align: center;width:25%">Service</th>-->
                <th style="text-align: center; width:15%">PHYSICIAN</th>
                <!--  <th style="text-align: center; width:4%">Status</th>-->
                <th style="text-align: left; width:11%;">ORDER DATE</th>
           </tr>
        </thead>
        
   <?php 
       	$srno = $this->params->paging ['RadiologyTestOrder'] ['limit'] * ($this->params->paging ['RadiologyTestOrder'] ['page'] - 1);

     	$toggle =0;
     	$pendingStatistics = 1;
     	$completedStatistics = 1;
     	$i = 0;
		if(count($data) > 0) {
	     	foreach($data as $key=>$patients){//debug($patients);
            	$patientId=$patients['Patient']['id'];
              
				$backGroundColor = "";
				if($patients['RadiologyTestOrder']['status']=='Pending'){
					$backGroundColor = "pending";
					$countPending = $pendingStatistics++;
				}

				if($patients['RadiologyTestOrder']['status'] == 'Completed'){
                    $countCompleted = $completedStatistics++;
					$backGroundColor = "received";
				}
				$radImages = explode(',',$patients['Patient']['radiology_images']);	
		?>
<?php if ($lastPatientId != $patientId){ if($i%2==0){ $grayColor="row_gray";}else{$grayColor ="";} ?>							       
<tr class="<?php echo $backGroundColor." ".$grayColor; ?> radColr" id="row_<?php echo $key?>">	
    <!--  <td style="text-align: center"><?php
		if ($lastPatientId != $patientId) { echo  ++$srno;}
		?>
	</td>	--> 		      
	<td style="text-align: left">
	<?php
	if ($lastPatientId != $patientId) {
	if($patients['Patient']['sex']=='male'){ ?>
	  <span><?php echo $this->Html->image('/img/icons/male.png', array('alt' => 'Male','title'=>'Male')); ?></span>
	<?php }else{?>
	  <span><?php echo $this->Html->image('/img/icons/female.png', array('alt' => 'Female','title'=>'Female')); ?></span>
	<?php }}?>
	</td>
	<td style="text-align: left" ><?php if ($lastPatientId != $patientId) {?>
		<?php echo $patients['Patient']['lookup_name'];?>
		
		<?php }?>
	</td>
	
	<!--  <td style="text-align: left"> <?php if ($lastPatientId != $patientId) {?>
			 <span>
			<?php echo $patients['Patient']['admission_id']; ?>
			</span> 
			<?php }?>
	</td>-->
	
	<!--  <td style="text-align: left"><?php echo $patients['Radiology']['name']; ?></td>-->
	
	<td style="text-align: left">
	<?php
		$stringCut = substr($patients[0]['name'], 0, 16);
		$explodeString = explode(',', $stringCut);
		$docName = explode("(",$patients[0]['name']);
	    $patients['Initial']['name']." ".$explodeString[0]; 
	    echo 'Dr.'.$docName[0];
	?> 
	</td>	
	
	<!--  <td style="text-align: left"><?php //echo $this->Form->input('',array('options'=>Configure::read('labStatus'),'selected'=>trim($patients['RadiologyTestOrder']['status']),'id'=>"status_$key",'label'=>false,'class'=>'statusAjax'));
     if($patients['RadiologyResult']['confirm_result'] == 1){
     	echo "Completed";
     }else{
        echo "Pending";	
     }

    ?>
	</td>-->
	<?php echo $this->Form->hidden('',array('id'=>"labId_$key",'value'=>$patients['RadiologyTestOrder']['order_id']))?>
   	<td style="text-align: left"><?php echo $this->DateFormat->formatDate2Local(trim($patients['RadiologyTestOrder']['radiology_order_date']),Configure::read('date_format'),false); ?></td>	
	
</tr>
<?php }?>
<?php 	$lastPatientId = $patientId; 
		} 
	$i++;} 
} else {?>

<tr>
	<TD colspan="8" align="center" class="error"><?php echo __('No record found for current day.', true); ?>.</TD>
</tr>
<?php }
	  echo $this->Js->writeBuffer();
?>
	
</table>
</div>
 
<script>               
	
	//script to include datepicker
		$(function() {	
			$( ".dateLab" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
			});
			
		});  
		 $(function() {	
		 //$("#from").val($.datepicker.formatDate("dd/mm/yy", new Date()));
	        $("#from").datepicker({
	            //showOn: "button",
	            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	            buttonImageOnly: true,
	            changeMonth: true,
	            changeYear: true,
	            changeTime: true,
	            showTime: true,
	            yearRange: '1950',
	            dateFormat: '<?php echo $this->General->GeneralDate();?>'
	        });

	        
	       // $("#to").val($.datepicker.formatDate("dd/mm/yy", new Date()));
	      
	        $("#to").datepicker({
	            //showOn: "button",
	            buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	            buttonImageOnly: true,
	            changeMonth: true,
	            changeYear: true,
	            changeTime: true,
	            showTime: true,
	            yearRange: '1950',
	            dateFormat: '<?php echo $this->General->GeneralDate();?>'
	        });
		 });                  
		                    
		$('.statusAjax').on('change',function(){
			var statusId=$(this).attr('id');
			var keyValue =statusId.split('_');
			if(keyValue[0]=='status'){
				var labId=$("#labId_"+keyValue[1]).val();
				var dateLab=$("#dateLab_"+keyValue[1]).val();
				var dateID="dateLab_"+keyValue[1];
				if(dateLab==''){
					  inlineMsg(dateID,'Please fill');
					  return false;
				}
				var statusValue=$('#'+statusId).val()
			}else{
				var labId=$("#labId_"+keyValue[1]).val();
				var dateLab=$("#dateLab_"+keyValue[1]).val();
				var statusValue=$('#status_'+keyValue[1]).val()
			}
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Radiologies", "action" => "radDashBoardUpdate","admin" => false)); ?>";
			 var formData = $("#dateLab_"+keyValue[1]).serialize();
		         $.ajax({	
		        	 beforeSend : function() {
		        		// this is where we append a loading image
		        		 loading();
		        		},
		        		                           
		          type: 'POST',
		         url: ajaxUrl+"/"+labId+"/"+statusValue,
		         data: formData,
		          success: function(data){ 
		        	  if(statusValue=="Completed"){
		        		  inlineMsg(statusId,'Status Updated',2);
						  $("#row_"+statusId.split("_")[1]).addClass("received");
		        		  $("#row_"+statusId.split("_")[1]).removeClass("pending");
		        	  }else{
		        		  inlineMsg(statusId,'Status Updated',2);
		        		  $("#row_"+statusId.split("_")[1]).addClass("pending");
		        		  $("#row_"+statusId.split("_")[1]).removeClass("received");
		        	  }
		        	  onCompleteRequest();
			        
		          },
					error: function(message){
						alert("Error in Retrieving data");
		          }        });
		    
		    return false; 
			
		});
		
		function onCompleteRequest(){
			$('#mainDiv').unblock(); 
		}
		

		
		 $(document).ready(function(){
			$("#records").freezeHeader({ });// fixed header
			
			$('#PendingStatistic').html('<?php echo "| Pending : ";echo  ($countPending)?$countPending:'0';?>');
		    $('#RecievedStatistic').html('<?php echo " | Completed : ";echo ($countCompleted)?$countCompleted:'0'. "";?>');
		    var total = <?php echo ($countPending)?$countPending:'0'?>+<?php echo ($countCompleted)?$countCompleted:'0'?> ;
		    $('#Total').html(" | Total : " + total + " | ");
		
		    $('#lookup_name').autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "Radiologies", "action" => "autocompleteForRadPatient","admin" => false,"plugin"=>false)); ?>",
				setPlaceHolder : false,
				select: function(event,ui){	
				 $('#patient_id').val(ui.item.id);
				},
				messages: {
		         noResults: '',
		         results: function() {},
			   },
			});
		});	    


		$("#resett").click(function () {
			$("#patient_id").val(0);
		    document.getElementById("labResultfrm").reset();  
		    $("#patient_id").val('');  
		    $("#lookup_name").val('');
		    $("#from").val('');
		    $("#to").val('');
		});
		
		$("#showRadImg").click(function(){
			$('#displayImages').toggle('fast');
		});

		$(document).ready(function(){
			var type = "<?php echo $this->params->query['type']; ?>";
			var is_exist = "<?php echo $is_exist; ?>";
			if(is_exist == "1"){
				$(".animsition").animsition({
				    inClass: 'fade-in-right',
				    outClass: 'fade-in-left',
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
				    transition: function(url){ window.location.href = "<?php echo $this->Html->url(array('controller'=>'Radiologies','action'=>'raddashboard_slide_three')); ?>"; }
				});
				if(type == 'slidesix'){
					 setTimeout(function () {    
					    window.location.href = "<?php echo $this->Html->url(array("controller" => "Radiologies", "action" => "raddashboard_slide_three", '?'=>array('type'=>'slideseven'),'OPD')); ?>"; 
					},11000);
				}else if(type == 'slideseven'){
					setTimeout(function () {  
					//window.location.href = "<?php echo $this->Html->url(array("controller" => "Users", "action" => "doctor_dashboard", '?'=>array('type'=>'slideone'))); ?>"; 
					    window.location.href = "<?php echo $this->Html->url(array("controller" => "NewLaboratories", "action" => "index", '?'=>array('type'=>'slideeight'),'LAB')); ?>"; 
					},12000);
				}/* else if(type == 'slideeight'){
					setTimeout(function () {    
					    window.location.href = "<?php echo $this->Html->url(array("controller" => "NewLaboratories", "action" => "index", '?'=>array('type'=>'slidenine'))); ?>"; 
					},11000);
				}*/
			}
		});
</script>
