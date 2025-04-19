<?php  
 	 echo $this->Html->script(array('jquery-1.5.1.min','jquery-ui-1.8.16.custom.min','ui.datetimepicker.3','jquery.ui.widget','jquery.ui.mouse','jquery.ui.core'));
	 echo $this->Html->css(array( 'jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css')); 
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4' )); ?>
	 
 <style>
 .loginContainer {
    position:relative;
    float:right;
    font-size:12px;
    margin-top:40px;
    z-index:100;
}

/* Login Button */
#loginButton { 
    display:inline-block;
    float:right;
    background:#ffffff; 
    border:1px solid #cacaca; 
    border-radius:3px;
    -moz-border-radius:3px;
    position:relative;
    z-index:30;
    cursor:pointer;
}

/* Login Button Text */
#loginButton span {
    color:#0c8dc5; 
    font-size:14px; 
    font-weight:bold; 
    text-shadow:1px 1px #fff; 
    padding:7px 25px 9px 10px;
    background:url(../img/loginArrow.png) no-repeat 60px 9px;
    display:block
}

#loginButton:hover {
    background:#ffffff;
}

/* Login Box */
/*#loginBox {
    position:absolute;
    top:34px;
    right:0;
    display:none;
    z-index:29;
}*/

/* If the Login Button has been clicked */    
#loginButton.active {
    border-radius:3px 3px 0 0;
}

#loginButton.active span {
    background-position:60px -78px;
}

/* A Line added to overlap the border */
#loginButton.active em {
    position:absolute;
    width:100%;
    height:1px;
    background:#ffffff;
    bottom:-1px;
}

/* Login Form */
.loginForm {
    width:248px; 
    border:1px solid #cacaca;
    border-radius:3px 0 3px 3px;
    -moz-border-radius:3px 0 3px 3px;
    margin-top:-1px;
    background:#ffffff;
    padding:6px;
}

.loginForm fieldset {
    margin:0 0 12px 0;
    display:block;
    border:0;
    padding:0;
}

fieldset#body {
    background:#fff;
    border-radius:3px;
    -moz-border-radius:3px;
    padding:10px 13px;
    margin:0;
}

.loginForm #checkbox {
    width:auto;
    margin:1px 9px 0 0;
    float:left;
    padding:0;
    border:0;
    *margin:-3px 9px 0 0; /* IE7 Fix */
}

#body label {
    color:#3a454d;
    margin:9px 0 0 0;
    display:block;
    float:left;
}

.loginForm #body fieldset label {
    display:block;
    float:none;
    margin:0 0 6px 0;
}

/* Default Input */
.loginForm input {
    width:92%;
    border:1px solid #899caa;
    border-radius:3px;
    -moz-border-radius:3px;
    color:#3a454d;
    font-weight:bold;
    padding:8px 8px;
    box-shadow:inset 0px 1px 3px #bbb;
    -webkit-box-shadow:inset 0px 1px 3px #bbb;
    -moz-box-shadow:inset 0px 1px 3px #bbb;
    font-size:12px;
}

/* Sign In Button */
.loginForm #login {
    width:auto;
    float:left;
    background:#339cdf;
	background-image: -ms-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -moz-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -o-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #59ACEA), color-stop(1, #0197D8));
	background-image: -webkit-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: linear-gradient(top, #59ACEA 0%, #0197D8 100%);
    color:#fff;
	font-size:13px;
    padding:7px 10px 8px 10px;
    text-shadow:0px -1px #278db8;
    border:1px solid #339cdf;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
    box-shadow:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
    margin:0 12px 0 0;
    cursor:pointer;
    *padding:7px 2px 8px 2px; /* IE7 Fix */
}

/* Forgot your password */
.loginForm span {
    text-align:center;
    display:block;
    padding:7px 0 4px 0;
}

.loginForm span a {
    color:#3a454d;
    text-shadow:1px 1px #fff;
    font-size:12px;
}

input:focus {
    outline:none;
}
.loginBox {
     display:none;
    position: absolute;
    right: 0;
    top: 34px;
    z-index: 29;
}

#WardWardId{
	margin:10px 0px 0px 20px;
}

.fancybox-inner{
		min-height: 350px !important;
}

 </style>
 <!--[if IE]>
 <style>
 	#WardWardId{
		margin:2px 0px 0px 20px;
	} 
 </style>
 <![endif]-->
 
<script>

 function checkApplyInADay(tarrifListID,standardId,tmp,apply_in_a_day){
	var count = 0;
	 if($.trim(apply_in_a_day)!="" && parseInt(apply_in_a_day)>0){
	  	if(parseInt(apply_in_a_day)>3)
	  		apply_in_a_day =3;
	  	var arr = new Array("morning"+tmp,"evening"+tmp,"night"+tmp);
		if($("#morning"+tmp).attr("checked")==true)
			count = count+1;
		if($("#evening"+tmp).attr("checked")==true)
			count = count+1;
		if($("#night"+tmp).attr("checked")==true)
			count = count+1;		
  		if(parseInt(apply_in_a_day) == count){
  			if($("#morning"+tmp).attr("checked")!=true)
  				$("#morning"+tmp).attr("disabled","disabled")
  			if($("#evening"+tmp).attr("checked")!=true)
  				$("#evening"+tmp).attr("disabled","disabled")
  			if($("#night"+tmp).attr("checked")!=true)
  				$("#night"+tmp).attr("disabled","disabled")
 		}else if(count < parseInt(apply_in_a_day)){
			if($("#morning"+tmp).attr("checked")!=true)
  				$("#morning"+tmp).removeAttr("disabled", "disabled");
  			if($("#evening"+tmp).attr("checked")!=true)
  				$("#evening"+tmp).removeAttr("disabled", "disabled");
  			if($("#night"+tmp).attr("checked")!=true)
  				$("#night"+tmp).removeAttr("disabled", "disabled");
		}			
   }
 }

 function defaultNoOfTimes(id,tariffListId){
		currentCount = Number($('#noOfTimes' + tariffListId).val()) ;		
		if($('#' + id).is(":checked")){			
			$('#noOfTimes' + tariffListId).val(currentCount+1);
		}else{
			if(currentCount > 0) 
				$('#noOfTimes' + tariffListId).val(currentCount-1);
			else
				$('#noOfTimes' + tariffListId).val('');
		}
	 }	
</script>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Patient Transfer', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?> 
 
    <p class="ht5"></p>
	      
           <?php 
           	echo $this->element('patient_information');
           ?>
              <table width="97%" cellpadding="0" cellspacing="0" border="0" align="right" style="margin-right:20px;">
              
                     <tr>
                     		<td width="250">
                     		<?php 
                     			 
			/*if($transfer=='done'){				
				echo "<script>parent.location.reload(); 
	  					parent.$.fancybox.close();</script>" ;
			}  
			
			*/
          
           if($this->params->pass[1]=='allot'){	
			    echo $this->Form->create('Ward',array('url'=>array('controller'=>'wards','action'=>'patient_transfer',$patient_id,'allot'),'id'=>'ward','inputDefaults'=>array(
									'div'=>false,'error'=>false,'label'=>false,'style'=>'')));
             }else{
             	echo $this->Form->create('Ward',array('url'=>array('controller'=>'wards','action'=>'patient_transfer',$patient_id),'id'=>'ward','inputDefaults'=>array(
		       'div'=>false,'error'=>false,'label'=>false,'style'=>'')));
             }
              ?>  
              <span style="float:left;">
              <?php //debug($wardList);?>
			<?php echo $this->Form->input('ward_id',array('type'=>'select','id'=>'wardName' ,'options'=>$wardList,'empty'=>'Please Select Room','onchange'=>'this.form.submit();'));
			
			?></span>
			
			<?php echo $this->Form->hidden('selectedBed',array('id'=>'selectedBed','div'=>false,'error'=>false,'label'=>false,'value'=>''));
			echo $this->Form->hidden('patient_id',array('value'=>$patient_id)) ;
			echo $this->Form->hidden('Ward.roomnameforSms',array('value'=>$getRoom)) ;
			echo $this->Form->hidden('Ward.bednameforSms',array('value'=>$getBed)) ;
			echo $this->Form->hidden('Ward.ward_name',array('value'=>$wardOR)) ;
			echo $this->Form->hidden('Ward.opt_appointment_id',array('value'=>$opt_appt_id,'type'=>'text')) ;
			echo $this->Form->hidden('Ward.optDashdoard',array('value'=>$optDashdoard,'type'=>'text')) ;
			if($this->request->data['Ward']['ward_id']){
				foreach($bedData as $roomKey =>$roomVal){
                     $roomArr[$roomVal['Bed']['id']] = $roomVal; 
                }	 ?>
	   				</td>
     
		   <td><?php $curentTime= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
			echo $this->Form->input('Ward.in_date', array('id'=>'in_dateqq','readonly','class'=> 'textBoxExpnd in_date','label'=> false, 'div' => false, 'error' => false, 'value'=> $curentTime));
			?></td>
			<td><?php if($this->params->pass[1]=='allot'){?>
			<input name="" type="submit" value="Allot Bed" class="blueBtn" id="transfer" style="margin:0px;"/>
			<?php }else{?>
			<input name="" type="submit" value="Transfer" class="blueBtn" id="transfer" style="margin:0px;"/>
			<?php } ?></td>
                          	<td width="33"><div class="bedAvail"></div></td>
                            <td width="65" class="tdLabel2">Available</td>
                            <td width="33"><div class="bedOcup"></div></td>
                            <td width="70" class="tdLabel2">Occupied</td>
                            <td width="33"><div class="bedWait"></div></td>
                            <td width="60" class="tdLabel2">Waiting</td>
                            <td width="33"><div class="bedMaintain"></div></td>
                            <td width="70" class="tdLabel2">Maintenance</td>
                            <td width="33"><div class="hsKeeping"></div></td>
                            <td width="70" class="tdLabel2">Housekeeping</td>
                        </tr>
          <?php if($this->Session->read("website.instance")=='lifespring'){ 	?>
   
             <tr class="approval" style="display:none;"> 
			   <td style="padding:15px;">
			    				<?php echo $this->Form->input('DiscountRequest.discount_by', array('class' => ' textBoxExpnd','style'=>'width:156px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Select User',$authPerson),'id' => 'authorize_by','style'=>"width:140px;",'readonly'=>false)); ?>
			    </td> 
			    <td style="padding:3px;" colspan="3">
			                 	<?php 
									echo $this->Html->link(__('Send request for Ward Transfer'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'send-approval'  ));
									echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-approval',"style"=>"display:none;"));
									echo $this->Form->hidden('ApproveRequest.is_approved',array('value'=>0,'id'=>'is_approved'));
			             ?>
		        </td>		
			 </tr>     
			 <tr> 
           <td colspan="2" valign="top" align="left" style="padding-top: 15px;">&nbsp;
        	<div style="float: left; margin-top: 3px;">
				   <i id="message" style="display:none;">
				   	(<font color="red">Note: </font> <span id="status-approved-message"></span> )  
				   		<span class="gif" id="image-gif" style="float: right; margin: -3px 0px 0px 7px;"> </span>
				   	</i>
			  </div> 
		</td>
     </tr>  
     <?php } ?>    
             </table>
                   
                   <div class="clr">&nbsp;</div>
             <table width="90%" cellpadding="5" cellspacing="5" border="0" style="margin:20px;">
                    	
             <?php 
                if(!empty($rooms)){
	             	foreach($rooms as $key=>$value){
	             		$endHtml = '';
		             	if(($key%2) == 0){
		             		if($key>1) echo "</tr>"; 
		             		?>
		             		<tr>
		                    <td width="300" valign="top">
		             		<?php
		             		$endHtml =  '</td><td width="30" style="min-width:30px;">';
		             		 
		             	}else{ ?>
		             		 
		                    </td>
		                    <td width="300" valign="top">
		             	<?php 
		             		$endHtml = "</td>";
		             	}	
	             ?>  
			                 <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
			                   		<tr>
			                                <th><?php  echo $value['Room']['name'];?></th>
			                        </tr>
			                        <tr>
			                            <td>
			                            	<?php 
			                            		if(is_array($value)){
	
			                            			$room_id = $value['Room']['id'];
				                            		foreach($value as $bed =>$bedArray)
				                            		{
				                            			if($bed=='Bed' && is_array($bedArray)){
					                            			 foreach($bedArray as $bedVal){
					                            			 	$class ='';
					                            			  //BOF waiting
					                            		 	     $discharge =false ;
						                            			 if(is_array($roomArr[$bedVal['id']]['WardPatient'])){
						                            			 	 foreach($roomArr[$bedVal['id']]['WardPatient'] as $wpKey){
								                            			 	if($wpKey['is_discharge']==1){ 
										                            			  //maintain the discharge status
										                            			  $discharge =true;
							                            			 	 	}else{
							                            			 	 		$discharge =false;
							                            			 	 	}
						                            			 	 } 
							                            		 }
								                            	 //EOF waiting
						                            			 if($bedVal['patient_id']==0){
						                            			 	 //BOF housekeeping
						                            			 	 //check the bed released time.
							                            		 	 //then it shud be in housekeeping state till 45 min from released time
								                             		 //calculate time diff
								                             		 $convertDate = strtotime($bedVal['released_date']);
								                             		 $currentTime = mktime();
								                             		 $minus = $currentTime - $convertDate ; 
								                             		 $intoMin = round(($minus)/60) ;
								                             		  $notAvail=  true ;
						                            			 	 //EOF housekeeping
						                            			 	 //if($intoMin<=45 && $bedVal['is_released']==0){
						                            			 	 /*if($bedVal['is_released']==0){
								                            			 	$class = 'hsKeeping';
								                            			 	 $notAvail=  false ;
					                            		 					echo "<div class=".$class."  title='".$value['Room']['bed_prefix'].$bedVal['bedno']."'></div>";
										                             }else*/
										                             /*if($bedVal['is_released']==1 && $intoMin<=45){
										                             	$class = 'bedWait';
										                             	$notAvail=  false ;
										                             	echo "<div class=".$class." id=".$bedVal['id']." title='".$value['Room']['bed_prefix'].$bedVal['bedno']."'></div>";
										                             } commented by pankaj as there is no need of 45 mins waiting time in hope hospital*/
										                             
										                             if($bedVal['under_maintenance']==1){
						                            			 		$class = 'bedMaintain';
						                            			 		echo "<div class=".$class." title='".$value['Room']['bed_prefix'].$bedVal['bedno']."'></div>";
						                            			 	 }else if($notAvail){
						                            			 		$class = 'bedAvail';
						                            			 		echo "<div class=".$class." id=".$room_id."_".$bedVal['id']." title='".$value['Room']['bed_prefix'].$bedVal['bedno']."'></div>";
						                            			 	 }
						                            			 }else{ 
						                            			 	echo "<div class='bedOcup' title='".$value['Room']['bed_prefix'].$bedVal['bedno']."'></div>"; 
						                            			} 
					                            			}
				                            			} 
				                            		}
			                            		}?>
			                                    </td>
			                              </tr>
			                   </table> 
	             <?php  echo $endHtml; }  
                 }else{ ?>
                <tr><td class="error" id="noroomfound">No Room Found.</td></tr>
                <?php } ?> 
                </table> 
               <?php }  echo $this->Form->end();    ?>  
               
<?php 
if(!$wardDates['WardPatient']['in_date']){//for first time allocation to allow back dated allocation  --yashwant
	$wardDates['WardPatient']['in_date']=$patient['Patient']['form_received_on'];
}
$splitDate = explode(' ',$patient['Patient']['form_received_on']);?>

<script>
 var viewSection="<?php echo $viewSection;?>";
 var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
 var explode = admissionDate.split('-');

	jQuery(document).ready(function(){ 
		$("#in_dateqq").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',				 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			//minDate : new Date(explode[0],explode[1] - 1,explode[2]),
			minDate:new Date(<?php echo $this->General->minDate($wardDates['WardPatient']['in_date']); ?>),
			//minDate : new Date(),
			maxDate : new Date(),
		});   
	
		
		if($('#selectedBed').val() != ''){
			  $("#"+$('#selectedBed').val()).removeClass("bedAvail").addClass("bedAvailSelected"); 
		 }
		 if($('#noroomfound').length){ 
			  $('#transfer').css('display', 'none');
		 } 
  	  	$('.bedAvail').click(function(){
  	  		$('.bedAvailSelected').each(function(index) {
  	  			$(this).removeClass("bedAvailSelected").addClass("bedAvail");
  	  		});  	
  	  		$(this).removeClass("bedAvail").addClass("bedAvailSelected"); 
		  	$('#selectedBed').val($(this).attr('id'));   	
  	  	}); 	
  	  	
 	$('#transfer').click(function(){
	  		var bed_id = $('#selectedBed').val() ;
	  		$('#transfer').hide();
			if(bed_id==''){
				alert("Please select bed to transfer patient");
				$('#transfer').show();
				return false ;
			}
		}); 
	});
 <?php if($this->Session->read('website.instance')=='lifespring' ){?>
 $(document).ready(function(){

	 if("<?php echo $wardList[$patient['Patient']['ward_id']]; ?>" != 'General Ward' && $("#wardName option:selected").text()=='General Ward'){
			  $(".approval").show();	
	  }
	 
	
	$("#send-approval").click(function(){  

		if($("#authorize_by").val() == 'empty'){
	    	alert('Please select the user for approval');
			return false;
	    }else if($("#authorize_by").val() != 'empty'){
		    patientId = '<?php echo $patient_id; ?>';
			user = $("#authorize_by").val();	//authhorized user whom we are sending approval
		    $.ajax({
				  type : "POST",
				  data: "patient_id="+patientId+"&request_to="+user,
				  url: "<?php echo $this->Html->url(array("controller" => "Wards", "action" => "requestForApproval","admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
					  $("#busy-indicator").show();
				  },	
				  success: function(data){ 
					 $("#busy-indicator").hide(); 
					 $("#message").show();
					 if(parseInt(data) == 1) 
					{
						$("#status-approved-message").html(" send apporval Request for Ward transfer has been sent, please wait for approval");
						
						 $("#image-gif").show();
						 $("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
						 $("#send-approval").hide();	//hide send approval button 
						 $("#cancel-approval").show();	//show reset button
						 $("#authorize_by").attr('disabled',true);
						 interval = setInterval("Notifications()", 10000);  // this will call Notifications() function in each 5000ms
					}
				} //end of success
			}); //end of ajax
		} //end of if else
		
	});
	
	//for cancelling the unapproved approval of bed transfer only
	 $("#cancel-approval").click(function(){

		 var conResult = confirm("Are you sure to cancel the request for Ward Transfer?");
		 if(conResult == true)
		 {
			patientId = '<?php echo $patient_id; ?>';
			user = $("#authorize_by").val();
			$.ajax({
				  type : "POST",
				  data: "patient_id="+patientId+"&request_to="+user,
				  url: "<?php echo $this->Html->url(array("controller" => "Wards", "action" => "cancelApproval","admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){ 
					  $("#busy-indicator").show();
				  },	
				  async: false,
				  success: function(data){ 
					$("#busy-indicator").hide(); 
					clearInterval(interval); // stop the interval
					$("#is_approved").val(0);
					$("#authorize_by").val('');
					$("#authorize_by").attr('disabled',false);
					$("#send-approval").show();
					$("#cancel-approval").hide();
					$("#message").hide();
				  }
			});
	 	}else{
		 	return false;
	 	}
	 }); 
		
		$('#transfer').click(function(){
	  		var bed_id = $('#selectedBed').val() ;
	  		$('#transfer').hide();
			if(bed_id==''){
				alert("Please select bed to transfer patient");
				$('#transfer').show();
				return false ;
			}
			if("<?php echo $wardList[$patient['Patient']['ward_id']]; ?>" != 'General Ward' && $.trim($("#is_approved").val()) != '1' ){		
				alert("Please Get Approval for transfer.");
				$('#transfer').show();
				return false ;
			}
		});
 });

//set request timer to check approval status 
	function Notifications()
	{
		patientId = '<?php echo $patient_id; ?>';
 	user = $("#authorize_by").val();
     $.ajax({
     	type : "POST",
			  data: "patient_id="+patientId+"&request_to="+user,
			  url: "<?php echo $this->Html->url(array("controller" => "Wards", "action" => "Resultofrequest","admin" => false)); ?>",
			  context: document.body,	
			  success: function(data){   

				  $("#message").show();	
				  $("#authorize_by").attr('disabled',true);
				  $("#send-approval").hide();
				  $("#cancel-approval").show();			//show cancel button to remove approval
				 // alert(data)
				if(parseInt(data) == 0)
				{ 
					$("#status-approved-message").html("Request for ward transfer has been sent, please wait for approval");
					$("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>');
					$("#is_approved").val(data);
					$("#send-approval").hide();
				}else
				if(data == 1)		//approved
				{				
					$("#status-approved-message").html('<font color="green">Request for ward transfer has been completed</font>');
					$("#image-gif").hide();
					$("#is_approved").val(data);  //for approval complete
					clearInterval(interval); // stop the interval
				}
				else
				if(data == 2)		// if rejected by users
				{
					$("#message").show();
					$("#status-approved-message").html('<font color="red">Request for ward transfer has been rejected</font>');
					$("#image-gif").hide();
					$("#is_approved").val(data);	// for approval reject
					clearInterval(interval); 	// stop the interval 
				}
			} //end of success
		});
	}		
	<?php }?>
</script> 
