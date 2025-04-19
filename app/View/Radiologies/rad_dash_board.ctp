<?php echo $this->Html->script(array('topheaderfreeze','animsition.js','animsition.min.js'));
	echo $this->Html->css(array('animsition.css','animsition.min.css'));
?>
<style>

tr.received td {
	/*background-color: #83df25;
	color: white;*/
	background-color: #9ACD32;
}

tr.pending td {
	/*background-color: #ee8c75;
	  color: white; */
	background-color: #DDDDDD
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

.tabularForm th {
	padding-top: 5px;
	margin-top: 0px;
	border-top: 1px solid #3e474a;
	background: #8b8b8b none repeat scroll 0 0 !important;
	color: white !important;
}
</style>

<div class="inner_title" style="padding: 2px 8px 4px">
    <h3>
		<?php echo __('Radiology DashBoard', true); ?>
    <table width="" style="color:tomato;float:right;">
		<tr>
			<td id='PendingStatistic'>  </td>
			<td id='RecievedStatistic'> </td>
			<td id='Total'> </td>		
		</tr>
	</table>
    </h3>
    <div class="clr "></div>
</div>
<?php 
echo $this->Form->create('Radiology', array('id'=>'labResultfrm','type'=>'get','inputDefaults' => array('label' => false, 'div' => false,'error'=>false) ));
?>	

<table width="100%" cellpadding="0" cellspacing="0" border="0"
       class="formFull" align="center" style="padding: 5px; margin-top: 5px">
    <tr>
       <td width="15%">
        <?php echo $this->Form->input('lookup_name', array('id' => 'lookup_name','label'=> false, 'value'=>$this->request->data['lookup_name'],'style'=>'width:90% !important','placeholder'=>'Patient Name', 'div' => false,'class'=>'textBoxExpnd enterBtn roundClass', 'error' => false,'title'=>'Patient Name','autocomplete'=>"off"));
              echo $this->Form->hidden('patient_id',array('id' =>'patient_id')); ?>
       </td>
       <td  width="10%"> <?php echo $this->Form->input('from', array('name' => 'from','style'=>'width:90% !important','id'=>'from',  'readonly'=>'readonly','label'=> false, 'placeholder'=>'From Date','div' => false,'value'=>$this->request->data['from'], 'error' => false, 'class' => 'enterBtn roundClass textBoxExpnd','title'=>'From Date'));?></td>
       <td  width="10%"> <?php echo $this->Form->input('to',   array('name' => 'to','style'=>'width:90% !important','id'=>'to',  'readonly'=>'readonly','label'=> false,'placeholder'=>'To Date', 'div' => false,'value'=>$this->request->data['to'], 'error' => false, 'class' => 'enterBtn roundClass textBoxExpnd','title'=>'To Date'));?></td>
         <td  width="10%"> <?php
        $status=array('Pending'=>'Pending','Completed'=>'Completed');
        echo $this->Form->input('status', array('options'=>array(''=>'Please Select',$status),'type'=>'select','name' => 'status','style'=>'width:90% !important','id'=>'status', 'label'=> false, 'div' => false,'value'=>$this->request->data['status'], 'error' => false, 'class' => 'roundClass textBoxExpnd','title'=>'Status'));?></td>
        <!--  <td  width="10%"> <?php
        echo $this->Form->input('sub_group', 
		array('options'=>array(''=>'Please Select',$subCategory),
		'type'=>'select','name' => 'sub_group','style'=>'width:90% !important','id'=>'to', 'label'=> false, 'div' => false,'value'=>$this->request->data['sub_group'], 
		'error' => false, 'class' => 'enterBtn roundClass textBoxExpnd','title'=>'To Date'));?>
		</td>-->
      
       <td width="">
            <table>
                <tr>
                    <td>
						<?php 
						echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'searchRad'));
						//echo $this->Html->image('icons/views_icon.png',array('id'=>'searchRad','type'=>'submit','title'=>'Search'));?>			
                    </td>
                    <td>
						<?php echo $this->Html->image('icons/eraser.png',array('id'=>'resett','title'=>'Reset'));?>	
                    </td>
                    <!--  <td>
						<?php echo $this->Html->image('icons/print.png',array('id'=>'','title'=>'Print'));?>			
                    </td>-->
                    <td>
						<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'radDashBoard'),array('escape'=>false,'title'=>'Reload current page'));?>			
                    </td>
					<td align="right">
						<?php echo $this->Html->link('PACS',array('action'=>'pacs'),array('class'=>'blueBtn','escape'=>false,'title'=>'Pacs','style'=>'text-align:right;margin-left:680px;'));?>			
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

 <?php echo $this->Form->end();?>
<div id="mainDiv" style="display: block;">


<!-- form elements start-->
<?php
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
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
<?php } ?>

<div style="padding-top: 10px"></div>
<table border="0" class="tabularForm" cellpadding="" cellspacing="1" width="100%" id="records">
    <button id="downloadExcel"style=" background: green; color: white; ">Download as Excel</button>

<?php if(isset($data) && !empty($data)){ 
		 $website=$this->Session->read("website.instance");
		?>
        <thead>
            <tr class="light fixed;" id="" style="overflow: auto;">
                <th style="text-align: center; width:2%">Sr.No</th>
                <th style="text-align: center; width:2%">Sex</th> 
                <th style="text-align: center; width:12%">Patient Name</th>
                <th style="text-align: center;width:6%">Patient ID</th>
                <th style="text-align: center;width:25%">Service</th>
                <th style="text-align: center; width:11%">Primary care provider</th>
                <th style="text-align: center; width:4%">Status</th>
                <th style="text-align: left; width:12%;">Order Date</th>
                <th style="text-align: left; width:10%">Enter Rad Result</th>
				<th style="text-align: center;width:10%">View DICOM Image</th>
            </tr>
        </thead>
        
   <?php 
       	$srno = $this->params->paging ['RadiologyTestOrder'] ['limit'] * ($this->params->paging ['RadiologyTestOrder'] ['page'] - 1);

     	$toggle =0;
     	$pendingStatistics = 1;
     	$completedStatistics = 1;
		if(count($data) > 0) {
	     	foreach($data as $key=>$patients){//debug($patients);
            	$patientId=$patients['Patient']['id'];
              
				$backGroundColor = "";
				if($patients['RadiologyTestOrder']['status']=='Pending'){
					 $backGroundColor = "pending";
					 $countPending = $pendingStatistics++;
				}

				if($patients['RadiologyTestOrder']['status'] =='Completed'){
                     $countCompleted = $completedStatistics++;
                     $backGroundColor = "received";
					}
				$radImages = explode(',',$patients['Patient']['radiology_images']);	
		?>
							       
<tr class="<?php echo $backGroundColor; ?> radColr" id="row_<?php echo $key?>">	
     <td style="text-align: center"><?php
		if ($lastPatientId != $patientId) { echo  ++$srno;}
		?>
	</td>			      
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
		<span style="float: right;">
		<?php if(!empty($radImages[0])){
			 echo $this->Html->link($this->Html->image('icons/gallary1.png'),'#',array('escape' => false,'title'=>'Image '.$key,
					'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'xray_images_slider_version_one','?'=>'pId='.$patients['Patient']['id']))."',
					'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
		 }?>
		</span>
		<?php }?>
	</td>
	
	<td style="text-align: left"> <?php if ($lastPatientId != $patientId) {?>
			 <span>
			<?php echo $patients['Patient']['admission_id']; ?>
			</span>
			<?php }?>
	</td>
	
	<td style="text-align: left"><?php echo $patients['Radiology']['name']; ?></td>
	
	<td style="text-align: left"><?php  echo $patients['Initial']['name']." ".$patients[0]['name']; ?> </td>	
	
	<td style="text-align: left"><?php //echo $this->Form->input('',array('options'=>Configure::read('labStatus'),'selected'=>trim($patients['RadiologyTestOrder']['status']),'id'=>"status_$key",'label'=>false,'class'=>'statusAjax'));
	    if($patients['RadiologyTestOrder']['status'] =='Completed'){
	     	echo "Completed";
	     }else{
	     	echo "Pending";
	     }

    ?>
	</td>
	<?php echo $this->Form->hidden('',array('id'=>"labId_$key",'value'=>$patients['RadiologyTestOrder']['order_id']))?>
   	<td style="text-align: left"><?php echo $this->DateFormat->formatDate2Local(trim($patients['RadiologyTestOrder']['radiology_order_date']),Configure::read('date_format'),true); ?></td>	
	 <td style="text-align: left">
	<?php 
		//print result
		
		if($conditionsFilter){
			$conditionalFlag = 'conditionalFlag';
		}
		$radiologyName=trim($patients['Radiology']['name']);
		
		if ((($radiologyName=="2D Echo Charges") || ($radiologyName=="2D echocardiography")) && $patients['RadiologyTestOrder']['status'] == 'Pending'){
		
			echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Enter Result')),
					array('controller'=>'radiologies','action' => 'enterEchoServiceResult',
							$patients['RadiologyTestOrder']['patient_id'],$patients['Radiology']['id'],$patients['RadiologyTestOrder']['id'],'?'=>array('conditionalFlag'=>$conditionalFlag)), array('escape'=>false));
		
		}else if((($radiologyName=="2D Echo Charges") || ($radiologyName=="2D echocardiography")) && $patients['RadiologyTestOrder']['status'] == 'Completed'){
				echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'View/Edit Published Result')),
					array('controller'=>'radiologies','action' => 'enterEchoServiceResult',
					$patients['RadiologyTestOrder']['patient_id'],$patients['Radiology']['id'],$patients['RadiologyTestOrder']['id'],$patients['Radiology2DEchoResult']['id'],'?'=>array('conditionalFlag'=>$conditionalFlag)), array('escape'=>false));

				echo $this->Html->link($this->Html->image('icons/printer_mono.png'),'#',array('escape' => false,'title'=>'Print with Header',
					'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printEchoServiceResult',$patients['RadiologyTestOrder']['patient_id'],
							$patients['Radiology']['id'],$patients['RadiologyTestOrder']['id'],$patients['Radiology2DEchoResult']['id'],'?'=>'flag=print_with_header')).
					"', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=800');  return false;"));
	
    	}else  if((($radiologyName != "2D Echo Charges") || ($radiologyName != "2D echocardiography")) && $patients['RadiologyTestOrder']['status'] == 'Pending'){
			echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Add Result')), 
				array('controller'=>'radiologies','action' => 'ajax_radiology_manager_test_order',
				$patients['RadiologyTestOrder']['patient_id'],$patients['Radiology']['id'],$patients['RadiologyTestOrder']['id'],'?'=>array('conditionalFlag'=>$conditionalFlag)), array('escape'=>false));
		
		}else  if((($radiologyName != "2D Echo Charges") || ($radiologyName != "2D echocardiography")) && $patients['RadiologyTestOrder']['status'] == 'Completed'){
			echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit Published Result')),
				array('controller'=>'radiologies','action' => 'ajax_radiology_manager_test_order',
				$patients['RadiologyTestOrder']['patient_id'],$patients['Radiology']['id'],$patients['RadiologyTestOrder']['id'],$patients['RadiologyResult']['id'],'?'=>array('conditionalFlag'=>$conditionalFlag)), array('escape'=>false));

			echo $this->Html->link($this->Html->image('icons/view-icon.png',array('title'=>'View Result')),
						array('controller'=>'radiologies','action' => 'radiology_doctor_view',$patients['RadiologyTestOrder']['patient_id'],
						$patients['Radiology']['id'],$patients['RadiologyTestOrder']['id'],'?'=>array('conditionalFlag'=>$conditionalFlag)), array('escape'=>false));
                  
           echo $this->Html->link($this->Html->image('icons/printer_mono.png'),'#',array('escape' => false,'title'=>'Print with Header',
						'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_preview',$patients['RadiologyTestOrder']['patient_id'],
						$patients['Radiology']['id'],$patients['RadiologyTestOrder']['id'],'?'=>'flag=print_with_header')).
						"', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
         }
	?>
   </td> 
   <td>
   <?php $query_string = 'Username=' . urlencode(Configure::read('pacsusername')) . '&Password=' . urlencode(Configure::read('pacspassword')). '&studyInstanceUIDs=' . urlencode($patients['Patient']['studyuid']);
      if(!empty($patients['Patient']['studyuid']))
	  {
		$getImgFlag1="green.png";
		$title="Dicom Image Available";
	  }
	  else
	 {
		$getImgFlag1="red.png";
		$title="Dicom Image not Available";
	}
		
					?>
   
   <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/pacsone/php/displayRemotEye.php?<?php echo htmlentities($query_string)?>"><img src="<?php echo $this->webroot?>theme/Black/img/icons/<?php echo $getImgFlag1?>" title="<?php echo $title?>"></a>
                  </td>
		
</tr>

<?php 	$lastPatientId = $patientId; 
		} 
	}
} else {?>

<tr>
	<TD colspan="8" align="center" class="error"><?php echo __('No record found for current day.', true); ?>.</TD>
</tr>
<?php }
	  echo $this->Js->writeBuffer();
?>
	
</table>
<table>
		<tr>
			<td>
				<div style="font-size: 11px !important; width: 15px; height: 15px; background-color: #DDDDDD;"></div>
			</td>
			<td style="font-size: 11px !important;">Pending</td>
			<td>
				<div style="font-size: 11px !important; width: 15px; height: 15px; background-color: #9ACD32;"></div>
			</td>
			<td style="font-size: 11px !important;">Completed</td>
		</tr>
	</table>
</div>
 
 <script>
     document.getElementById('downloadExcel').addEventListener('click', function() {
    // Get the table element
    const table = document.getElementById('records');
    const rows = Array.from(table.rows);
    const csvContent = rows.map(row => {
        const cells = Array.from(row.cells);
        return cells.map(cell => cell.innerText).join(",");
    }).join("\n");
    
    // Create a Blob from the CSV content
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    
    // Create a link to download the Blob
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    link.setAttribute("href", url);
    link.setAttribute("download", "data.csv"); // Specify the file name
    document.body.appendChild(link);
    
    // Programmatically click the link to trigger the download
    link.click();
    
    // Clean up
    document.body.removeChild(link);
});

 </script>
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
			$("#records").freezeHeader({ 'height': '400px' });// fixed header
			
			// show pending, completed status 
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

	
	
</script>
