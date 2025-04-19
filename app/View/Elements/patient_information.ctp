<?php 
echo $this->Html->css(array('prettyPhoto.css','jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));
echo $this->Html->script(array('jquery.ui.accordion.js','jquery.prettyPhoto','bsa.js','jquery.fancybox-1.3.4','jquery.autocomplete')); 
$complete_name  = ucfirst($patient['Person']['first_name'].' '.$patient['Person']['last_name']) ;
if(trim($complete_name) == '') $complete_name  = ucfirst($patient['Patient']['lookup_name']) ;
//pr($patient['Person']) ;exit;
$b_string=implode(",",$b);
$c_string=implode(",",$c);
$p_string=implode(",",$p);
?>
<style>
.focus {
	border: 2px solid #AA88FF;
	background-color: #FFEEAA;
}

#lookup_name {
	width: 100px;
}

#searchDoctorsPatient {
	color: #E7EEEF;
	float: right;
	font-size: 13px;
	float:left;
	/*margin-left: 40px;
	margin-right: -12px;
	margin-top: -30px;
	text-align: right;*/
	width:29px !important;
}

#patientSearchDiv {
    float: left;
}
#patient_search {
    float: left;
}
#searchDoctorsPatient img {
	float: none;
}
.link a {
color: #FFFFFF important!;
}

</style>
<script type="text/javascript" charset="utf-8">
	var api_gallery = [<?php echo $b_string?>];
	var	api_descriptions=[<?php echo $c_string?>];
	var api_gallery_pt = [<?php echo $p_string?>];
</script>

<?php echo $this->Form->create('',array('url'=>array('controller'=>'PatientDocuments','action'=>'add',$patient['Patient']['id']),'id'=>'patientDocForm','type' => 'file','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
)); 
?>
<?php 
echo $this->Form->hidden('PatientDocuments.flag',array('value'=>'1'));
if($patient['Patient']['admission_type'] == "IPD" && $patient['Patient']['is_emergency']==0){
		$type =  '(Inpatient)';
	}else if($patient['Patient']['admission_type'] == "IPD" && $patient['Patient']['is_emergency']==1){
		$type =  '(Emergency)';
	}else{
		//$type =  '(Outpatient)';
	}
	?>
<?php //if(strtolower($this->Session->read('role'))==strtolower(Configure::read('doctorLabel'))){?>
<div class="clr">&nbsp;</div>
<!-- Recent Patients list-->
<!-- <div id="recentPatients" >
<table >
	<tr >
		<?php foreach($patientListArray as $list){?>
		<td id="<?php echo 'tddelete'.$list['Patient']['id']; ?>">
		<span style="cursor: pointer;" title='<?php echo $list['Patient']['patient_id']; ?>' id= "<?php echo $list['Patient']['id'].'search'?>" class="recentSearch">
			<?php echo $list['Patient']['lookup_name'];?>
		</span> 
		<span class="delete" style="cursor: pointer;" title="Remove this patient" id="<?php echo "delete".$list['Patient']['id']; ?>">
		X </span>
		</td>
		<?php } ?>
	</tr>
</table>
</div> -->
<div id="patient-info-acc" class="accordionCust">
	<h3 style="font-weight: bold;">
		<a href="#"><font color="#53859C"><?php echo __("Visit Information"); ?></font></a>
	</h3>
	<!-- <div class="patient_info section"> -->
	<table width="100%" cellpadding="0" cellspacing="0" border="0"
		class="patient_info section">
		<tr>
			<td valign="top">
				<table width="100%" cellpadding="0" cellspacing="0" border="0"
					class="patientHub ">

					<tr>
						<td>
							<table width="100%" cellpadding="0" cellspacing="0" border="0">

								<tr>
									<?php if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$photo) && !empty($photo)){ ?>
									<td width="111" valign="top"><?php echo $this->Html->link($this->Html->image("/uploads/patient_images/thumbnail/".$photo, array('style'=>'color:#fff','alt' => $complete_name,'title'=>$complete_name,'width'=>'100','height'=>100,'title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$patient['Patient']['person_id']), array('escape' => false)); ?>
									</td>
									<?php }else {
											if(strtolower($patient['Person']['sex']) == 'male'){ ?>
									<td width="111" valign="top"><?php echo $this->Html->link($this->Html->image("/img/icons/male-thumb.gif", array('style'=>'color:#fff','alt' => $complete_name,'title'=>$complete_name,'title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$patient['Patient']['person_id']), array('escape' => false)); ?>
									</td>
									<?php } else {  ?>
									<td width="111" valign="top"><?php echo $this->Html->link($this->Html->image("/img/icons/female-thumb.gif", array('style'=>'color:#fff','alt' => $complete_name,'title'=>$complete_name ,'title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$patient['Patient']['person_id']), array('escape' => false)); ?>
									</td>
									<?php } 
									} ?>

									<td width="15">&nbsp;</td>
									<td width="230" valign="top">
										<p class="name"><?php echo $complete_name;?>
											<?php //echo $this->Html->link($complete_name,array('controller'=>'Patients','action'=>'patient_information',$patient['Patient']['id']),
													//array('style'=>"color:#fff !important;font-weight:normal;font-size:18px;")) ;?>
										</p>
										
										<p class="name"> <?php echo $type ; ?> </p>
										<p class="address"> <?php echo $patient['Person']['plot_no'] ; if(!empty($patient['Person']['landmark'])){echo ",".$patient['Person']['landmark'];}?><br/><?php echo $patientstate;if(!empty($patient['Person']['city'])){echo ",".$patient['Person']['city'];}?><br/><?php echo $patient['Person']['pin_code']?></p>
 										<p><?php 
											//debug($b_string);
											//debug($k);
											$imagesCount = count($data1);
											if(empty($imagesCount)){
						              	  			//echo 'Hello'; 
						              	  			echo $this->Html->image('pathologyradiologyicons/RADIOLOGY 3.png');
						              	  	}else{
				              	  				//echo 'Welcome';
				              	  				echo $this->Html->image('pathologyradiologyicons/RADIOLOGY 3 tick.png');
				              	  				//echo $this->Html->link($this->Html->image('pathologyradiologyicons/RADIOLOGY 3 tick.png'),'/uploads/radiology/'.$data1[0]['RadiologyReport']['file_name'],array('escape'=>false,'target'=>'__blank','style'=>'text-decoration:underline;'));
				              	  			}?>
										</p> <?php 
										//debug($b_string);
										//debug($k);
										if(empty($imagesCount)){

						              	 }else{?>
										<p><a href="#" onclick="$.prettyPhoto.open(api_gallery,api_descriptions);"  return false
												style='text-decoration: none'>&nbsp;&nbsp;<font color="#fff">View Images</font></a>
										</p> <?php }?>
									</td>
									<td width="20">&nbsp;</td>
									<td valign="middle">
										<table width="100%" cellpadding="0" cellspacing="1" border="0"
											class="patientInfo">
											<tr class="darkRow">
												<td width="270" style="min-width: 270px;">
													<div class="heading">
														<strong>Patient ID</strong>
													</div>
													<div class="content">
														<?php echo $patient['Patient']['patient_id'] ;?>
													</div>
												</td>
												<td width="270" style="min-width: 270px;">
													<div class="heading">
														<strong><?php echo __("Visit ID");?> </strong>
													</div>
													<div class="content">
														<?php echo $patient['Patient']['admission_id'] ;?>
													</div>
												</td>
											</tr>
											<tr class="darkRow">
												<td>
													<div class="heading">
														<strong><?php echo __('Gender'); ?> </strong>
													</div>
													<div class="content">
														<?php if(!empty($sex)){
															echo ucfirst($sex);
														}else{
															echo $patient['Patient']['sex'];
														}
														
														?>
													</div>
												</td>
												<td>
													<div class="heading">
														<strong><?php echo __("Visit Date");?> </strong>
													</div>
													<div class="content">
														<?php $splitDate = explode(' ',$patient['Patient']['form_received_on']);
														if(!empty($splitDate[1])){
															$date=$this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);
															echo $date ;
                                                        } ?>
													</div>
												</td>
											</tr>
											<tr class="darkRow">
												<td>
													<div class="heading">
														<strong>Birth Date</strong>
													</div>
													<div class="content">
														<?php echo $getdob['Person']['dob'] ;
															if($patient['Person']['dob'] == '0000-00-00' || $patient['Person']['dob'] == ''){
																echo "";
															}
															else{
																echo date("F d Y", strtotime($patient['Person']['dob'])) ;
																if(!empty($age)){
																	?>&nbsp;(<?php echo $age;?>)<?php 
																}else{
																	?>&nbsp;(<?php echo $patient['Patient']['age'];?>)<?php
																}
															}
														?>
													</div>
												</td>
											
											
												
												<td>
													<div class="heading">
														<strong><?php echo __("Physician Assigned");?> </strong>
													</div>
													<div class="content">
														<?php echo ucfirst($treating_consultant[0]['fullname']) ;?>
													</div>
												</td>
											</tr>
											<tr class="darkRow">
												
												<?php if(!empty($causeofdeath['0']['death_cause'])){ ?>
												<td>
													<div class="heading">
														<strong>Death Reason</strong>
													</div>
													<div class="content">
														<?php  echo $causeofdeath['0']['death_cause'] ; ?>
													</div>
												</td>
												<?php }?>
											</tr>
											<?php if($patient['Patient']['admission_type'] == 'IPD'){?>
											<!-- <tr class="darkRow">
													<td>
														<div class="heading">
															<strong>Birth Date</strong>
														</div>
														<div class="content">
															<?php echo $getdob['Person']['dob'] ;
                                                        if($patient['Person']['dob'] == '0000-00-00' || $patient['Person']['dob'] == ''){
															echo "Unkown";
														} 
														else{
															echo date("F d Y", strtotime($patient['Person']['dob'])) ;
														}
                                                        ?>
														</div>
													</td>
													<?php if(!empty($causeofdeath['0']['death_cause'])){ ?>
													<td>
														<div class="heading">
															<strong>Death Reason</strong>
														</div>
														<div class="content">
															<?php  echo $causeofdeath['0']['death_cause'] ; ?>
														</div>
													</td>
													<?php }?>
												</tr> -->
											<tr class="darkRow">
												<td>
													<div class="heading">
														<strong>Room</strong>
													</div>
													<div class="content">
														<?php echo ucfirst($wardInfo['Ward']['name']) ;?>
														&nbsp;
														<?php echo ucfirst($wardInfo['Room']['name']) ;?>

													</div>
												</td>
												<td>
													<div class="heading">
														<strong>Bed No</strong>
													</div>
													<div class="content">
														<?php echo $wardInfo['Room']['bed_prefix'].$wardInfo['Bed']['bedno'] ;?>
													</div>
												</td>

											</tr>
											<!-- <tr class="darkRow"> -->
												<?php }  
													 if(isset($diagnosis) && !empty($diagnosis)){?>
												<!-- <td>            // Commented by gulshan
													<div class="heading">
														<strong>Diagnosis</strong>
													</div>
													<div class="content">
														<?php // echo $diagnosis ;?>
													</div>
												</td> -->

												<?php if(!empty($patient['TariffStandard']['name'])){?>

												<!-- <td>
													<div class="heading">
														<strong>Tariff Std.</strong>
													</div>
													<div class="content">
														<?php echo $patient['TariffStandard']['name'] ;?>
													</div>
												</td>  

											</tr> -->
											<?php } 
													}else if(!empty($patient['TariffStandard']['name'])){?>
											<!-- <tr class="darkRow">
												<td>
													<div class="heading">
														<strong>Tariff Std.</strong>
													</div>
													<div class="content">
														<?php echo $patient['TariffStandard']['name'] ;?>
													</div>
												</td>
												<td>&nbsp;</td>
											</tr>  -->
											<?php } ?>

											<?php 
                                                 if(!empty($patient['Patient']['status'])){?>
											<tr class="darkRow">
												<td><?php //echo "<pre>";print_r($patient);exit;?>
													<div class="heading">
														<strong>Status</strong>
													</div>
													<div class="content">
														<?php echo ucfirst($patient['Patient']['status']) ;?>
													</div>
												</td>
												<td>
													<div class="heading">
														<strong>Remark</strong>
													</div>
													<div class="content">
														<?php echo $patient['Patient']['remark'] ;?>
													</div>
												</td>
											</tr>
											<?php } ?>
											<?php  if(!empty($patient['Person']['race'])){ ?>
											<tr class="darkRow">
												<?php  
												$exp = explode(",",$patient['Person']['race']);
													
													if(!empty($exp) && count($exp) >= 1){ ?>
												<td>
													<div class="heading">
														<strong>Race</strong>
													</div>
													<div class="content">
														<?php //echo ucfirst($patient['Race']['race_name']) ;
														$raceString = '';
														foreach($exp as $expRace){
                                                    		$raceString[]  = $data_race[$expRace] ;
                                                    	}
                                                    	
                                                    	echo $ss= implode(", ",$raceString);

                                                    	?>
													</div>
												</td>
												<?php }else{ echo $patient['Person']['race'];
												} ?>
												<?php  if(!empty($patient['Person']['ethnicity'])){ ?>
												<td>
													<div class="heading">
														<strong>Ethnicity</strong>
													</div>
													<div class="content">
														<?php echo $patient['Person']['ethnicity']?>
													</div>
												</td>
												<?php } ?>
											</tr>
											<?php } ?>
											<?php  if(!empty($patient['Person']['preferred_language'])){ ?>
											<tr class="darkRow">
												<td>
													<div class="heading">
														<strong>Pref. Language</strong>
													</div>
													<div class="content">
														<?php 
														echo ucfirst($languages[$patient['Person']['preferred_language']]) ;?>
													</div>
												</td>
												<td>
													<div class="heading">Telephone</div>
													<div class="content">
														<?php echo $patient['Person']['person_lindline_no'] ;?>
													</div>
												</td>
											</tr>
											<?php }?>
											<!-- ------------------Preferred Communication-------------------- -->
											<?php if(!empty($pcomm)){?>
											<tr class="darkRow">
												<td>
													<div class="heading">
														<strong>Pref. Communication</strong>
													</div> <?php //echo $pcomm;
														if($pcomm=='0'){
														echo " Email";
																}
																elseif($pcomm=='1'){
																	echo " Telephone";
															}elseif($pcomm=='2'){
																					echo " Fax";
																			}
																			elseif($pcomm=='3'){
																				echo " Snail Mail";
																			}
																			elseif($pcomm=='4'){
																	echo "SMS";
																}
																else{
																	echo " ";
																}
																?>
												</td>

											</tr>
											<?php } ?>
											<!-- ------------------Preferred Communication-------------------- -->
											<?php if(!empty($corporate)){?>
											<tr class="lightRow">
												<td>
													<div class="heading">
														<strong>Corporate</strong>
													</div> <?php echo $corporate;?>
												</td>

											</tr>
											<?php }?>
										</table>
									</td>
								</tr>
							</table>
				<!-- 	<?php /*if($this->Session->read('role')!='Nurse' && $this->Session->read('role')!='Primary Care Provider'){?>	
							<table  cellpadding="1" cellspacing="1" border="0">	
								<!-- Commented on requirement gaurav
								<tr>
									<td><div id="patientSearchDiv">
											<div id="patient_search" >
												<input type="text" id="lookup_name" style="width:280px" name="data[lookup_name]" autocomplete="off"
													placeholder="Search Patient" class="ac_input">
												<input type="hidden" id="patient_id" name="data[patient_id]">
											</div>

											<label id="searchDoctorsPatient"><?php echo $this->Html->image('icons/search_icon.png');?></label>
										</div>
									</td>
								</tr> ->
								
									<tr>
										<td><?php echo $this->Form->input('', array('name'=>'data[PatientDocument][filename]','id'=>'document_up','label'=> false,'class'=>'', 'div' => false, 'error' => false,'type'=>"file"));?>
										<?php echo $this->Form->submit(__('Save'), array('id'=>'add_doc','title'=>'Save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false,'style'=>'display:none'));?></td>
									</tr>
								
							</table>
						<?php if($this->Session->read('role')!='Nurse'){?>
							<?php if(isset($data2) && !empty($data2)){?>
							<table  cellpadding="1" cellspacing="1" border="0">
								<tr>
									<?php /*if(isset($data2) && !empty($data2)){
													if(count($data2)<=6){
						               				$count  = count($data2) ;
						               				}else{
						               				$count  = 6 ;
						               				}
											}
											for($i=0;$i<$count;$i++){
												$j=$i+1;?>
											<td>
											<a href="#" id="<?php echo $i;?>" class="view-large" style='text-decoration: none'>
												<?php echo $this->Html->image("/uploads/user_images/thumbnail/".$data2[$i]['PatientDocument']['filename'], array('title'=>'patient_image_'.$j,'width'=>'50','height'=>'50'));?>
												</a>
												
											<!-- 
											<a href="../../uploads/user_images/<?php echo $data2[$i]['PatientDocument']['filename'] ?>" rel="prettyPhoto" title="This is the description">
											<?php  //echo $this->Html->image("/uploads/user_images/thumbnail/".$data2[$i]['PatientDocument']['filename'], array('title'=>'patient_image_'.$j,'width'=>'50','height'=>'50'));?>
											</a>  	 --> 
											
											</td>
											<?php } ?>
								</tr>
							</table>
							<?php }?>
						<?php } ?>
					<?php }*/ ?> -->
						</td>

					</tr>

				</table>
			</td>
			<!-- <td valign="top">
	    					<table>
	    						<?php if(file_exists(WWW_ROOT."uploads/qrcodes/".$patient['Patient']['admission_id'].".png")){ ?>
			    				<tr>			    					
			    					<td width="100px" valign="top" align="center" rowspan="6">
			    						<?php echo $this->Html->image("/uploads/qrcodes/".$patient['Patient']['admission_id'].".png", array('alt' => $complete_name,'title'=>$complete_name,'width'=>'100')); ?>
			    					</td>
			 					</tr>
			 					<?php  } ?>
			 				</table>
	    				</td> -->
		</tr>
	</table>
	<!-- </div> -->
<?php echo $this->Form->end(); ?>
</div>
<?php
$pass = $this->request->params['pass'];
unset($pass['0']);
$paramData = implode('/',$pass);
$quertString = implode('&', array_map(function ($value, $key) { return $key .'='. $value; }, $this->request->query, array_keys($this->request->query)));
?>
<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$("area[rel^='prettyPhoto']").prettyPhoto();
				$("a[rel^='prettyPhoto']").prettyPhoto();
				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: true});
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _
					.exec(); }
				});
			});
			</script>

<!-- BuySellAds.com Ad Code -->
<style type="text/css" media="screen">
.bsap a {
	float: left;
}

</style>
<script type="text/javascript">
			
			(function(){
			  var bsa = document.createElement('script');
			     bsa.type = 'text/javascript';
			     bsa.async = true;
			     //bsa.src = '//s3.buysellads.com/ac/bsa.js';
			  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);


			   $(".view-large").click(function(){
					var items = api_gallery_pt.slice(0); 
					var removedItems = [];
					removedItems.push(items.splice($(this).attr('id') - removedItems.length, 1)[0]);
					items.splice.apply(items, [0, 0].concat(removedItems));
					//alert(items);
					//alert(api_descriptions);
					$.prettyPhoto.open(items,api_descriptions);
					return false ;
				}); 
			})();
  
			$(document).ready(function(){
				var instance = "<?php echo ($this->Session->read('website.instance'));?>";
				if(instance=='kanpur'){
					$('#patient-info-acc .ui-accordion-content').show(); // added for to expand accordion on page load only for kanpur -Atul
				} else {
			    	$( "#patient-info-acc" ).accordion({
					collapsible: true,
					autoHeight: false,
					clearStyle :true,	 
					navigation: true, 
					active:false
				     }); 
				}
			
			
//----------------------HTML commented COde is working gaurav
			$( "#searchDoctorsPatient" ).click(function(){ 
				var action = '<?php echo $this->params->action ?>';
				var patientID = $('#patient_id').val();
				if(patientID == ""){
					$('#lookup_name').focus(function() {
					$("#lookup_name").css( 'borderColor' , 'red' );});
					return false;
				}else{ 
					
					if(action == 'index'){
						var URL = "<?php echo $this->Html->url(array('controller'=>$this->params->controller)); ?>";
						URL = URL+"/"+action+"/"+patientID+"/"+"<?php echo $paramData?>"+"?"+"<?php echo $quertString?>";
					}else{
						var URL = "<?php echo $this->Html->url(array('controller'=>$this->params->controller,'action' => $this->params->action)); ?>";
						URL = URL+"/"+patientID+"/"+"<?php echo $paramData?>"+"?"+"<?php echo $quertString?>";
					}
					window.location.href = URL;
				}
			});
			 
			$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","Patient",'id',"lookup_name",'admission_type='.$patient['Patient']['admission_type'].'&is_discharge=0',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				valueSelected:true,
				showNoId:true,
				loadId : 'lookup_name,patient_id'
			});
//----------------------------------------------------------------- 
		});
			
</script>
<script>

	$(".delete").click(function(){
		 var element = $(this);
		 var I = $(this).attr("id");
		 $('#td'+I).fadeOut('slow', function() {$(this).remove();});
		        return false; 
	});

	$( ".recentSearch" ).click(function(){ 
	
		var patient_Id = $(this).attr('id').replace("search","");
		var URL = "<?php echo $this->Html->url(array('controller'=>$this->params->controller,'action' => $this->params->action)); ?>"+"/"+patient_Id;
			URL = URL+'?type=<?php echo $patient['Patient']['admission_type'] ?>';
			window.location.href = URL;
	});

	
	$("#document_up").change(function(){
		$("#add_doc").show();
	});
</script>