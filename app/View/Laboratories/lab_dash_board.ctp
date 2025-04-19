<style>
.row_action a {
	padding: 0px;
}

.table_format td {
	padding-right: 0px !important;
}

img {
	text-align: center;
}

.row_action img {
	float: none !important;
	text-align: center;
}
</style>
<?php
echo $this->Html->css ( array (
		'jquery.fancybox-1.3.4.css' 
) );
echo $this->Html->script ( array (
		'inline_msg',
		'jquery.blockUI' 
) );
echo $this->Html->script ( array (
		'jquery.fancybox-1.3.4' 
) );
?>

<div class="inner_title">
	<h3>
		<?php echo __('Lab DashBoard'); ?>
	</h3>

</div>
<?php
// echo $this->Form->create('Laboratories',array('action'=>'labTestHl7List',$patient_id));
echo $this->Form->create ( '', array (
		'id' => 'labResultfrm',
		'type' => 'post',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );
?>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" align="center">
	<tbody>
		<tr class="row_title ">
			<td><?php
			
			echo __ ( "Patient Name : " ) . "&nbsp;" . $this->Form->input ( 'lookup_name', array (
					'name' => 'lookup_name',
					'id' => 'lookup_name',
					'label' => false,
					'value' => $this->request->data ['lookup_name'],
					'div' => false,
					'error' => false 
			) );
			echo $this->Form->hidden ( 'id', array (
					'id' => 'patient_id' 
			) );
			?>
			</td>
			<td><?php  echo __("MRN : ")."&nbsp;".$this->Form->input('admission_id', array('type'=>'text','name'=>'admission_id','id' => 'admission_id','label'=> false,'value'=>$this->request->data['admission_id'] ,'div' => false, 'error' => false));?></td>
			<td class=" " align="right" width=" " width="30%"><?php echo __('From') ?><font
				color="red">*</font> :</td>
			<td class=" "><?php
			echo $this->Form->input ( 'from', array (
					'name' => 'from',
					'style' => 'width:120px;',
					'id' => 'from',
					'label' => false,
					'div' => false,
					'error' => false,
					'value' => $this->request->data ['from'],
					'class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd' 
			) );
			?>
			</td>
			<td class=" " align="right"><?php echo __('To') ?><font color="red">*</font>
				:</td>
			<td class=" "><?php
			echo $this->Form->input ( 'to', array (
					'name' => 'to',
					'style' => 'width:120px;',
					'id' => 'to',
					'label' => false,
					'div' => false,
					'error' => false,
					'value' => $this->request->data ['to'],
					'class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd' 
			) );
			?>
			</td>


			<td class=" " align="center"><?php
			echo $this->Form->submit ( __ ( 'Search' ), array (
					'class' => 'blueBtn',
					'div' => false,
					'label' => false,
					'id' => 'searchLab' 
			) );
			?>
			</td>
			<td><?php
			// echo $this->Html->link($this->Html->image('icons/refresh-icon.png',array('action'=>'labDashBoard'),array('alt'=>'Refresh List','title'=>'Refresh List')),
			// "javascript:void(0);",array('escape'=>false/* 'onclick'=>"load_list();" */));
			?>
            	<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'labDashBoard'),array('escape'=>false, 'title' => 'refresh'));?>
			</td>
		</tr>


	</tbody>
</table>
<?php echo $this->Form->end(); ?>
<div id="mainDiv" style="display: block;">
	<!-- form elements start-->
	<?php
	if (! empty ( $errors )) {
		?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%"
		align="center">
		<tr>
			<td colspan="2" align="left" class="error"><?php
		foreach ( $errors as $errorsval ) {
			echo $errorsval [0];
			echo "<br />";
		}
		?>
			</td>
		</tr>
	</table>
	<?php } ?>

	<div id="test-order"></div>

	<div style="text-align: right;" class="clr inner_title"></div>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		<?php if(isset($testOrdered) && !empty($testOrdered)){ ?>
		<tr class="row_title">
			<td class="table_cell" align="left"><strong><?php echo __('Status');?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo __('Date');?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo __(''); ?> </strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Patient Name'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo __("Primary care provider");?>
			</strong></td>
			<td class="table_cell" align="left" style="text-align: center;"><strong><?php  echo __("DOB");?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo __("Ordering Date");?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo __("MRN");?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo __("Ordered Test");?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo __("Action");?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo __("Enter Lab Result");?>
			</strong></td>
			<!--  	<td class="table_cell" align="left"><strong><?php echo __("Payment");?>
			</strong></td>-->
		</tr>
		<?php
			
			$toggle = 0;
			if (count ( $testOrdered ) > 0) {
				foreach ( $testOrdered as $key => $patients ) {
					if ($patients ['Billing'] ['total_amount']) {
						$labTotal = $patients ['Billing'] ['total_amount'] - $patients ['Billing'] ['amount'];
					} else {
						$labTotal = 1;
					}
					if (($patients ['Person'] ['vip_chk'] != '1' || $patients ['Patient'] ['tariff_standard_id'] != $privateId) && $labTotal != 0) {
						echo '';
					} else {
						if ($toggle == 0) {
							echo "<tr class='row_gray'>";
							$toggle = 1;
						} else {
							echo "<tr>";
							$toggle = 0;
						}
						?>
		<td class="row_format" align="left"><?php echo $this->Form->input('',array('options'=>Configure::read('labStatusLab'),'selected'=>trim($patients['LabManager']['labDash_status']),'id'=>"status_$key",'label'=>false,'class'=>'statusAjax')); ?>
		</td>

		<!--  <td class="row_format" align="left"><?php echo $this->Form->input('',array('type'=>'text','id'=>"dateLab_$key",'value'=>$this->DateFormat->formatDate2Local(trim($patients['LabManager']['labDash_date']),Configure::read('date_format'),true),'class'=>'dateLab textBoxExpnd statusAjax','readonly'=>'readonly','label'=>false))?>
	</td>-->
		<td class="row_format" align="left" style="width: 14%"><?php echo$this->Form->input('',array('type'=>'text','name'=>'Laboratory[to]','id'=>"dateLab_$key",'value'=>$this->DateFormat->formatDate2Local(trim($patients['LabManager']['labDash_date']),Configure::read('date_format'),true),'class'=>'dateLab textBoxExpnd statusAjax','readonly'=>'readonly','label'=>false))?>
		</td>
		<?php if($patients['Patient']['sex']=='male'){ ?>
		<td class="row_format" align="left"><?php echo $this->Html->image('/img/icons/male.png', array('alt' => 'Male')); ?>
		</td>
		<?php }else{?>
		<td class="row_format" align="left"><?php echo $this->Html->image('/img/icons/female.png', array('alt' => 'Female')); ?>
		</td>
		<?php }?>
		<td class="row_format" align="left"><?php
						// echo $this->Html->link($patients['Patient']['lookup_name'],array('controller'=>'PatientsTrackReports','action'=>'sbar',$patients['LabManager']['patient_id'],'admin'=>false),array('escape'=>false));
						echo $patients ['Patient'] ['lookup_name'];
						?> <?php $patientId=$patients['Patient']['id'];?>
		</td>
		<td class="row_format" align="left"><?php echo $patients['Initial']['name']." ".$patients[0]['name']; ?>
		</td>
		<td class="row_format" align="left"><?php
						
						echo $this->DateFormat->formatDate2Local ( $patients ['Person'] ['dob'], Configure::read ( 'date_format' ), true );
						?>
		</td>


		<?php echo $this->Form->hidden('',array('id'=>"labId_$key",'value'=>$patients['LabManager']['order_id']))?>

		<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local(trim($patients['LabManager']['start_date']),Configure::read('date_format'),false); ?>
		</td>

		<?php // echo $this->Html->image('icons/detailed.png',)?>
		</td>
		<td><?php echo $patients['Patient']['admission_id']?></td>
		<td><?php
						// $patientId=$patients['LabManager']['patient_id'];
						
						echo $this->Html->link ( 'View Details', 'javascript:void(0)', array (
								'onclick' => 'lab("' . $patientId . '")',
								'title' => 'test' 
						) )?>
		</td>

		<td class="row_format" align="left" style="width: 12%"><?php
						// $patientId=$patients['LabManager']['patient_id'];
						echo $this->Html->link ( 'Submit And Print', 'javascript:void(0)', array (
								'onClick' => 'barcodeSpecific("' . $patientId . '","' . $key . '")',
								'title' => 'Bar Code',
								'class' => 'blueBtn statusAjax',
								'id' => "print_$key",
								'label' => false,
								'disabled' => true 
						) );
						?>
		</td>
		<td class="row_action" align="Center"><?php
						
						if ($patients ['LabManager'] ['showEdit'] == '1') {
							$blue = 'block';
							$red = 'none';
						} else {
							$blue = 'none';
							$red = 'block';
						}
						?> <span style="display:<?php echo $blue?>" id='blue_<?php echo $key?>'><?php
						
						echo $this->Html->link ( $this->Html->image ( 'icons/edit-icon.png', array (
								'title' => 'Enter Lab',
								'alt' => 'Enter Lab Result' 
						) ), array (
								'action' => 'labTestHl7List',
								$patients ['Patient'] ['id'],
								'?' => array (
										'return' => 'laboratories' 
								) 
						), array (
								'escape' => false 
						) );
						?>
		</span> <span style="display:<?php echo $red?>" id='red_<?php echo $key?>'><?php
						
						echo $this->Html->link ( $this->Html->image ( 'icons/edit-grey.png', array (
								'title' => 'InActive',
								'alt' => 'Enter Lab Result' 
						) ), 'javascript:void(0)', array (
								'escape' => false 
						) );
						?> </span></td>
		<!--  	<td style="text-align: left;" class="tdLabel" id="boxSpace"><?php
						// payament
						
						if (! $billingData [$patientId] ['paidAmount'] || $patients ['0'] ['totalAmount'] == null) {
							echo $this->Html->link ( $this->Html->image ( 'icons/red.png', array () ), array (
									'controller' => 'Billings',
									'action' => 'multiplePaymentModeIpd',
									$patientId 
							), array (
									'escape' => false,
									'title' => 'Laboratory Payment' 
							) );
						} else if ($billingData [$patientId] ['paidAmount'] < $patients ['0'] ['totalAmount']) {
							echo $this->Html->link ( $this->Html->image ( 'icons/orange_new.png', array () ), array (
									'controller' => 'Billings',
									'action' => 'multiplePaymentModeIpd',
									$patientId 
							), array (
									'escape' => false,
									'title' => 'Laboratory Payment' 
							) );
						} else if ($billingData [$patientId] ['paidAmount'] >= $patients ['0'] ['totalAmount']) {
							echo $this->Html->link ( $this->Html->image ( 'icons/green.png', array () ), array (
									'controller' => 'Billings',
									'action' => 'multiplePaymentModeIpd',
									$patientId 
							), array (
									'escape' => false,
									'title' => 'Laboratory Payment' 
							) );
						}
						?>
		</td>
		-->
		</tr>
		<?php
					}
				}
				// set get variables to pagination url
				$this->Paginator->options ( array (
						'url' => array (
								"?" => $this->params->query 
						) 
				) );
				?>
		<tr>
			<TD colspan="8" align="Center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			
			
			
			
			
			
			
			</TD>
		</tr>
		<?php
			}
			?>
		<?php
		} else {
			?>
		<tr>
			<TD colspan="8" align="left" class="error"><?php echo __('No record found for current day.', true); ?>.</TD>
		</tr>
		<?php
		}
		echo $this->Js->writeBuffer ();
		?>
	</table>
</div>

<script>    


			$(document).ready(function(){
		$('#lookup_name').autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","lookup_name",'null','no','no',"admin" => false,"plugin"=>false)); ?>",
				minLength: 1,
				select: function( event, ui ) {
				$('#patient_id').val(ui.item.id);
				},
				messages: {
				noResults: '',
				results: function() {}
				}
				});
		$('#admission_id').autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","admission_id",'null','no','no',"admin" => false,"plugin"=>false)); ?>",
			minLength: 1,
			select: function( event, ui ) {
			$('#patient_id').val(ui.item.id);
			},
			messages: {
			noResults: '',
			results: function() {}
			}
			});

	
			});	     
	
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
			
		
			$( "#from" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
		});
	            $( "#to" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
		});
	});  

		

		
                
	//function to check search filter
		$('#patient-search').submit(function(){
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
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "labDashBoardUpdate","admin" => false)); ?>";
			 var formData = $("#dateLab_"+keyValue[1]).serialize();
		         $.ajax({	
		        	 beforeSend : function() {
		        		// this is where we append a loading image
		        		// loading();
		        		},
		        		                           
		          type: 'POST',
		         url: ajaxUrl+"/"+labId+"/"+statusValue,
		         data: formData,
		          success: function(data){ 
		        	  if(statusValue=="Sample Collected"){
		        		  inlineMsg(statusId,'Status Updated');
		        	  }else{
		        		  inlineMsg(statusId,'Appointment Scheduled');
		        	  }
		        	  
		        	 // onCompleteRequest();
			        
		          },
					error: function(message){
						alert("Error in Retrieving data");
		          }        });
		    
		    return false; 
			
		});
		$("#searchLab1").click(function(){
			 
			var from=$("#from").val();
			var from1='from';
			var to1='to';
			 var to=$("#to").val();
			<!-- if((from =='') && (to =='')){
				// inlineMsg(from1,'Please Fill');
				 //inlineMsg(to1,'Please Fill');
				 // return false;
			// }
			// else if(from ==''){
				 // inlineMsg(from1,'Please Fill');
				//  return false;
			// }
			// else if(to ==''){
				// inlineMsg(to1,'Please Fill');
				// return false;
			// }
			// else{}
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "labDashBoard","admin" => false)); ?>";
			// var formData = $("#from").serialize();
			 
		         $.ajax({	
		        	 beforeSend : function() {
		        		// this is where we append a loading image
		        		 loading('mainDiv','id');
		        		},
		        		                           
		          type: 'POST',
		         url: ajaxUrl,
		         data: $('#labResultfrm').serialize(),
		          success: function(data){
		        	    
		        		$("#mainDiv").html(data);
		        		onCompleteRequest('mainDiv','id');
			        
		          },
					error: function(message){
						alert("Error in Retrieving data");
		          }        });
		    
		    return false; 
		});
		/*function loading(){
			 $('#mainDiv').block({ 
		        message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif')?>  Please wait...</h1>', 
		        css: {            
		            padding: '5px 0px 5px 18px',
		            border: 'none', 
		            padding: '15px', 
		            backgroundColor: '#fffff', 
		            '-webkit-border-radius': '10px', 
		            '-moz-border-radius': '10px',               
		            color: '#fff',
		            'text-align':'left' 
		        },
		        overlayCSS: { backgroundColor: '#cccccc' } 
		    }); 
		}*/
	function load_list(){
			var d = new Date();
			var currentDate=(d.getMonth() + 1 ) + '/' + (d.getDate()) + '/' +  d.getFullYear();

			var currentDate= "<?php echo date(Configure::read('date_format_php'),strtotime("now")); ?>"
			$('#labResultfrm')[0].reset();
			//$('#content-form').find('form')[0].reset();
			$.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => 'Laboratories', "action" => "labDashBoard","admin" => false)); ?>",
				  context: document.body,	   
				  beforeSend:function(){
				    // this is where we append a loading image
				   loading('mainDiv','id');
				  }, 	
				  data: {'from':currentDate,'to':" "},  		  
				  success: function(data){				 
					 // $('#busy-indicator').hide('fast');
					 //$("#content-list").css("display","none");
					$('#mainDiv').html(data) ;
					//$("#mainDiv").css("display","none");
					//$("#formdisplayid").css("display","none");
					onCompleteRequest('mainDiv','id');
				  }
			});
			return false ;
	
		}
	/*function onCompleteRequest(){
		$('#mainDiv').unblock(); 
	} */

		 function lab($patientId) { 	
			$.fancybox({
			'width' : '60%',
			'height' : '80%',
			'autoScale': true,
			'transitionIn': 'fade',
			'transitionOut': 'fade',
			'type': 'iframe',
			'href': "<?php echo $this->Html->url(array("controller" => "Laboratories","action" => "labdash")); ?>"+'/'+$patientId,
			});
			}
	
		function barcodeSpecific(patientId,key){

			//var currentId=$(this).attr('id');
			//var getId=currentId.split("_");
			var currentVal=$('#status_'+key).val();
			if(currentVal=='Pending'){
				$('#status_'+key).focus();
			/*	$('#status_'+key).css({"border-color": "red", 
		             "border-weight":"50px", 
		             "border-style":"solid"});*/
				var showId='status_'+key;
				  inlineMsg(showId,'Please fill');
				return ;
			}
			else{
				$('#red_'+key).hide();
				$('#blue_'+key).show();
				window.location.href= "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "specimenBarCode")); ?>" + '/' + patientId
				
				/*$.fancybox({
			 		'autoDimensions': false, 
		        	'height': '70%',
		        	'width': '70%',
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'hideOnOverlayClick':false,
					'showCloseButton':true,
					'href' : "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "specimenBarCode")); ?>"
							 + '/' + patientId, 
					'onClosed':function(){
						$('#red_'+key).hide();
						$('#blue_'+key).show();
						
						 
					} 				
				});*/
			}
			/*
			$.ajax({
				  type : "POST",
				  url: "<?php //echo $this->Html->url(array("controller" => 'Laboratories', "action" => "specimenBarCode","admin" => false)); ?>"+"/"+patientId,
				  context: document.body,	   
				  beforeSend:function(){
				    // this is where we append a loading image
				   loading();
				  }, 		  
				  success: function(data){				 
					 // $('#busy-indicator').hide('fast');
					 //$("#content-list").css("display","none");
					onCompleteRequest();
				  }
			});*/
		}
		
</script>
