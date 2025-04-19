<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
.panel_resizable {
	border: 2px solid #f28c38;
	margin: 0;
	overflow: hidden !important;
}
 
.violetBtn {
    border-bottom: 1px solid white !important;
    list-style: outside none none;
    margin: 0 !important;
    padding-top: 5px !important;
    width: 133px;
}
 
ul{ 
	margin:0px;padding:0px !important;
}

h3{ 
	padding:0px;
	margin: 0px;
}

 
#tab_css > ul > li.active > a::after, #tab_css > ul > li:hover > a::after, #tab_css > ul > li > a:hover::after {
    /* background: #ac47ed !important;*/
    background: #745b8d !important;
}

#tab_css {
    border-bottom: 3px solid #745b8d !important;
} 
.table_format th {
        background: #8b8b8b none repeat scroll 0 0 !important;
        border-bottom: 1px solid #3e474a;
        color: #FFFFFF !important;
        font-size: 12px;
        padding: 2px 5px;
        text-align: left;
    }
.table_format {
    padding: 0px !important;
}
.table_format tr td {
     padding: 2px 5px;
}
.theads{
 width: 20%;
 vertical-align: top;
}
.thumbnailSize{
 border-radius:9px;
 width: 50px;
 height: 50px;
}
.scrollTr {
    display: inline-block;
    max-width: 1180px;
    overflow-x: scroll;
}
.inner_title span {
    float: right;
    margin: -33px 0 !important;
    padding: 0;
}
</style>
</head>  
<body>
<?php echo $this->Html->css('tab_menu') ;
echo $this->Html->script(array('jquery.fancybox.js'));
echo $this->Html->css(array('jquery.fancybox'));
?>

<?php 
      /** sub category config variables**/
	  $intraOpPhoto = Configure::read('intraOpPhoto');
	  $onBedPhoto =Configure::read('onBedPhoto');
	  $onDischargePhoto = Configure::read('onDischargePhoto');
	  $clinicalPhoto = Configure::read('clinicalPhoto');
	  $dischargeOnBed = Configure::read('dischargeOnBed');
	  $scarPhoto =Configure::read('scarPhoto');
	  $preSurgery = Configure::read('preSurgery');
	  $postSurgery =Configure::read('postSurgery');
	  $aadharCard = Configure::read('aadharCard');
	  $panCard = Configure::read('panCard');
	  $rationCard = Configure::read('rationCard');
	  $treatmentSheet =Configure::read('treatmentSheet');
	  $programNote = Configure::read('programNote');
	  $investigation =Configure::read('investigation');
	  $otNotes = Configure::read('otNotes');
	  $anaesthesiaNotes = Configure::read('anaesthesiaNotes');
	  $deathClinicalPhoto = Configure::read('deathClinicalPhoto');
	  $deathCertificate = Configure::read('deathCertificate');
	  $deathSummary = Configure::read('deathSummary');
	  $formFour = Configure::read('formFour');
	  
	  $role =$this->Session->read('role');
	  $doctorRole = Configure::read('doctorLabel');
	  $adminRole = Configure::read('adminLabel')
?>


<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Add Patient Documents - ', true);?><font font-size="20px" font-family="verdana" color="darkolivegreen"><?php echo "&nbsp;".$patientName['Patient']['lookup_name'].' - '.$patientName['Patient']['admission_id']."";
		 ?>
		</font>
		
	</h3>	
	<span>
	<?php echo $this->Form->input('addmission_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'addmissionId', 'class'=>'','placeHolder'=>'Search Patient'));
				  echo $this->Form->hidden('patient_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'patientId', 'class'=>''));
			?>
	<?php 
	echo $this->Html->link(__('Back'), array('action' => 'getRgjayPackagePatientResult','?'=>array('conditionalFlag'=>$conditionalFlag)), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>
		<table width="100%" border="0">
		<tr>
			<td><b>Package: </b><i>
			<?php
			    if(!empty($patientData['GalleryPackageDetail']['package_category_id'])){
			    	echo $packageName = $packageCategory[$patientData['GalleryPackageDetail']['package_category_id']];
			    }else if($patientData['Patient']['tariff_standard_id']== $rgjayTariffId || $patientData['Patient']['tariff_standard_id'] == $rgjayTariffAsOnTodayId){
					echo $packageName = strtoupper($patientData['TariffList']['name']);
				}else{
					echo $packageName = "";
				}
			?>
			</i></td>
		<tr>
		<tr>
			<td><b>Diagnosis: </b><i><?php echo $patientData['Diagnosis']['final_diagnosis'];?></i></td>
		<tr>
		<?php 
		if($isPatientexistinPacs=="1")
		  $getImgFlag1="green.png";
		else
		  $getImgFlag1="red.png";
		  ?>
		<tr>
			<td><b>Patient Study:</b>&nbsp;&nbsp;<img src="<?php echo $this->webroot?>theme/Black/img/icons/<?php echo $getImgFlag1?>" title="<?php echo $title?>" alt="" title="<?php echo $title?>"  style="float: none !important;" target="_blank"  class ="showAllStudies" id="<?php echo $patientName['Patient']['admission_id']?>"></td>
		<tr>
			<tr>
				<td>
					<fieldset style="width: 95%; height: 200%;" class="panel_resizable"
						id="panel_resizable_1_0">
						<legend style="color: #0099CC">
							<h3>Photo</h3>
						</legend> 
						<table width="100%" border="0">
							<tr>
								<td width="100%" valign="top">
									<div style="float: none !important;" id="tab_css"> 
										<ul> 
									        <li id="subCatPhoto_<?php echo $intraOpPhoto;?>" class="active subCatPhoto" > <a href="javascript:void(0);">Intra Op Photo</a></li>
											<li id="subCatPhoto_<?php echo $onBedPhoto;?>"class="subCatPhoto" ><a href="javascript:void(0);">On Bed Photo</a></li>
											<li id="subCatPhoto_<?php echo $onDischargePhoto;?>"class="subCatPhoto" ><a href="javascript:void(0);">On Discharge Photo</a></li>
											<li id="subCatPhoto_<?php echo $clinicalPhoto;?>"class="subCatPhoto" ><a href="javascript:void(0);">Clinical Photo</a></li>
											<li id="subCatPhoto_<?php echo $dischargeOnBed;?>"class="subCatPhoto" ><a href="javascript:void(0);">Discharge On Bed Photo</a></li>
											<li id="subCatPhoto_<?php echo $scarPhoto;?>"class="subCatPhoto" ><a href="javascript:void(0);">Scar Photo</a></li>  
										
										</ul>
									</div>
									<!-- Intra Op Photo --> 
									<table width="100%" border="0" class="table_format photoSection" id= "photoSection_<?php echo $intraOpPhoto;?>" >
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Sub Category</th>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
									 
										<tbody id= "intraOpPhoto_<?php echo $intraOpPhoto;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('type'=>'file','url'=>array('controller'=>'radiologies','action'=>'uploadDocument',$patientData['Patient']['id']),'class'=>'upload_rgjay','id'=>"uploadDocument_".$intraOpPhoto."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'1'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$intraOpPhoto));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
												?>
													<td valign="top" class="theads"> 
														<?php 
															$subsubarray = array('Incision','Identification of Surgery Parts','Critical Steps in Surgery','Suture line') ;
															echo $this->Form->input('intraop_sub_category_id',array('type'=>'select','options'=>$subsubarray,'empty'=>'Please Select','class'=>'textBoxExpnd validate[required,custom[mandatory-select]]'));
															echo $this->Form->hidden('category_id',array('value'=>'1'));
															echo $this->Form->hidden('sub_category_id',array('value'=>$intraOpPhoto));
															echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
															echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
															echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
															
														?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));
												 			 
												 	?>
												 	<!-- <img src='' class="thumbnail thumbnailSize" id="thumbnail_<?php echo $intraOpPhoto?>_1" style="display: none;" /> -->
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										<tr>
										<td>
										<table class="scrollTr" style="width: 100%">
											<tbody>
												<tr class="appendImg" id="thumbnail_<?php echo $intraOpPhoto;?>">
													 <?php
													 if(!empty($patientDocData)) {
										  					foreach ($patientDocData as $docKey => $docValue){
										  	 				 if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $intraOpPhoto){
																$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
																	$cheked='checked';
																}else{
																	$cheked='';
																}
																?>	
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>" 
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php 
											  				    if($role == $doctorRole || $role == $adminRole){
																	echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																}
																?>
											  			  </td>
										  					<?php } 
														   } 
													 	}?>
													 		
												</tr>
												
											</tbody>  
										</table>
										</td>
									  </tr>
									  
									</table>
									<!--On Bed Photo section -->
									<table width="100%" border="0" class="table_format photoSection" id= "photoSection_<?php echo $onBedPhoto;?>" style="display: none;">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "onBedRow_<?php echo $onBedPhoto;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$onBedPhoto."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'1'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$onBedPhoto));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
											<tr>
												<td>
													<table class="scrollTr" style="width: 100%">
														<tbody>
															<tr class="appendImg" id="thumbnail_<?php echo $onBedPhoto;?>">
																 <?php if(!empty($patientDocData)) {
													  					foreach ($patientDocData as $docKey => $docValue){
													  	 				 if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $onBedPhoto){
																			$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
																			$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
																			
																			if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
																				$cheked='checked';
																			}else{
																				$cheked='';
																			}
																			
																			?>	
											  						<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  						caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  						<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  						</td>
													  					<?php } 
																	   } 
																 	}?>
																 		
															</tr>
														</tbody> 
													</table>
												</td>
											</tr>
										</table>
										
									<!--On Discharge Photo -->
									
										<table width="100%" border="0" class="table_format photoSection" id="photoSection_<?php echo $onDischargePhoto;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "onDischargePhotoRow_<?php echo $onDischargePhoto;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$onDischargePhoto."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'1'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$onDischargePhoto));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										<tr>
											<td>
											<table class="scrollTr" style="width: 100%">
													<tbody>
														<tr class="appendImg" id="thumbnail_<?php echo $onDischargePhoto;?>">
															 <?php if(!empty($patientDocData)) {
												  					foreach ($patientDocData as $docKey => $docValue){
												  	 				 if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $onDischargePhoto){
																		$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
													  					$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
													  					
																			if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
																				$cheked='checked';
																			}else{
																				$cheked='';
																			}?>	
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  					<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
												  					<?php } 
																   } 
															 	}?>
															 		
														</tr>
												   </tbody> 
											</table>
											</td>
										</tr>
										</table>
										
									
									<!--Clinical Photo -->
									<table width="100%" border="0" class="table_format photoSection" id= "photoSection_<?php  echo $clinicalPhoto;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "clinicalPhotoRow_<?php echo $clinicalPhoto;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$clinicalPhoto."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'1'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$clinicalPhoto));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										 <?php echo $this->Form->end();?>	
										</tr> 
										</tbody>
										<tr>
										  <td>
										    <table class="scrollTr" style="width: 100%">
													<tbody>
														<tr class="appendImg" id="thumbnail_<?php echo $clinicalPhoto;?>">
															 <?php if(!empty($patientDocData)) {
												  					foreach ($patientDocData as $docKey => $docValue){
												  	 				 if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $clinicalPhoto){
																		$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
																		$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
																		if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
																			$cheked='checked';
																		}else{
																			$cheked='';
																		}
																		?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>" 
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
												  					<?php } 
																   } 
															 	}?>
															 		
														</tr>
												   </tbody> 
											</table>
										  </td>
										</tr>
										</table>
										
									
									<!--Discharge On Bed Photo -->
									<table width="100%" border="0" class="table_format photoSection" id= "photoSection_<?php echo $dischargeOnBed;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "dischargeOnBedRow_<?php echo $dischargeOnBed;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$dischargeOnBed."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'1'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$dischargeOnBed));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										 <?php echo $this->Form->end();?>	
										</tr> 
										</tbody>
									<tr>
										<td>
											<table class="scrollTr" style="width: 100%">
												<tbody>
													<tr class="appendImg" id="thumbnail_<?php echo $dischargeOnBed;?>">
														<?php if(!empty($patientDocData)) {
															foreach ($patientDocData as $docKey => $docValue){
													  	 				 if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $dischargeOnBed){
																			$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
																			$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
																			if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
																				$cheked='checked';
																			}else{
																				$cheked='';
																			}
														 ?>	
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>" 
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
														<?php } 
														    }
														}?>
														
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</table>
									
									<!--Scar Photo -->
									<table width="100%" border="0" class="table_format photoSection" id= "photoSection_<?php echo $scarPhoto;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "scarPhotoRow_<?php echo $scarPhoto;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$scarPhoto."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'1'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$scarPhoto));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
											<tr>
												<td>
													<table class="scrollTr" style="width: 100%">
														<tbody>
															<tr class="appendImg" id="thumbnail_<?php echo $scarPhoto;?>">
																 <?php if(!empty($patientDocData)) {
													  					foreach ($patientDocData as $docKey => $docValue){
													  	 				 if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $scarPhoto){
																			$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
														  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
														  				    if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
														  				    	$cheked='checked';
														  				    }else{
														  				    	$cheked='';
														  				    }
														  				    
														  				    ?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
													  					<?php } 
																	   } 
																 	}?>
																 		
															</tr>
													   </tbody> 
													</table>
												</td>
											</tr>
										</table>
								</td> 
							</tr>
						</table> 
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset style="width: 95%; height: 200%;" class="panel_resizable"
						id="panel_resizable_1_0">
						<legend style="color: #0099CC">
							<h3>Investigation</h3>
						</legend> 
						
						<table width="100%" border="0">
							<tr>
								<td width="100%" valign="top">
									<div style="float: none !important;" id="tab_css"> 
										<ul >
											<li id="subCatInv_<?php echo $preSurgery;?>"  class="active subCatInv" > <a href="javascript:void(0);">Pre-Surgery</a></li>
											<li id="subCatInv_<?php echo $postSurgery?>" class="subCatInv" ><a href="javascript:void(0);">Post-Surgery</a></li>
										</ul>
									</div>
									<!--Pre-Surgery -->
									<table width="100%" border="0" class="table_format invSection" id= "invSection_<?php echo $preSurgery;?>" >
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "preSurgeryRow_<?php echo $preSurgery;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$preSurgery."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'2'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$preSurgery));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										<tr>
										 <td>
										 <table class="scrollTr" style="width: 100%">
											<tbody>
												<tr class="appendImg" id="thumbnail_<?php echo $preSurgery;?>">
													 <?php if(!empty($patientDocData)) {
										  					foreach ($patientDocData as $docKey => $docValue){
										  	 				 if($docValue['PatientDocumentDetail']['category_id']=='2' && $docValue['PatientDocumentDetail']['sub_category_id'] == $preSurgery){
																$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
											  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
																if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
																	$cheked='checked';
																}else{
																	$cheked='';
																}
															   		?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
										  					<?php } 
														   } 
													 	}?>
													 		
												</tr>
										   </tbody> 
										</table>
										 </td>
										</tr>
										</table>
										
									<!--Post-Surgery -->
									<table width="100%" border="0" class="table_format invSection" id= "invSection_<?php echo $postSurgery;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "postSurgeryRow_<?php echo $postSurgery;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$postSurgery."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'2'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$postSurgery));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										<tr>
										  <td>	
										  <table class="scrollTr" style="width: 100%">
											<tbody>
												<tr class="appendImg" id="thumbnail_<?php echo $postSurgery;?>">
													 <?php if(!empty($patientDocData)) {
										  					foreach ($patientDocData as $docKey => $docValue){
										  	 				 if($docValue['PatientDocumentDetail']['category_id']=='2' && $docValue['PatientDocumentDetail']['sub_category_id'] == $postSurgery){
																$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
											  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				    if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
											  				    	$cheked='checked';
											  				    }else{
											  				    	$cheked='';
											  				    }
											  				    ?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
										  					<?php } 
														   } 
													 	}?>
													 		
												</tr>
										   </tbody> 
										</table>
										</td>
									</tr>
								  </table>
								</td> 
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset style="width: 95%; height: 200%;" class="panel_resizable"
						id="panel_resizable_1_0">
						<legend style="color: #0099CC">
							<h3>ID Proof</h3>
						</legend> 
						<table width="100%" border="0">
							<tr>
								<td width="100%" valign="top">
									<div style="float: none !important;" id="tab_css"> 
										<ul > 
											<li id="subCatIdProof_<?php echo $aadharCard;?>" class="active subCatIdProof" > <a href="javascript:void(0);">Aadhar Card</a></li>
											<li id="subCatIdProof_<?php echo $panCard;?>"class="subCatIdProof" ><a href="javascript:void(0);">Pan Card</a></li>
											<li id="subCatIdProof_<?php echo $rationCard;?>"class="subCatIdProof" ><a href="javascript:void(0);">Ration Card</a></li>
										</ul>
									</div>
									<!--Aadhar Card -->
									<table width="100%" border="0" class="table_format idProofSection" id= "idProofSection_<?php echo $aadharCard;?>" >
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "aadharCardRow_<?php echo $aadharCard;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$aadharCard."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'3'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$aadharCard));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
											<tr>
												<td>
												<table class="scrollTr" style="width: 100%">
													<tbody>
														<tr class="appendImg" id="thumbnail_<?php echo $aadharCard;?>">
															 <?php if(!empty($patientDocData)) {
												  					foreach ($patientDocData as $docKey => $docValue){
												  	 				 if($docValue['PatientDocumentDetail']['category_id']=='3' && $docValue['PatientDocumentDetail']['sub_category_id'] == $aadharCard){
																		$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
													  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
													  				    if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
													  				    	$cheked='checked';
													  				    }else{
													  				    	$cheked='';
													  				    }
													  				    ?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
												  					<?php } 
																   } 
															 	}?>
															 		
														</tr>
												   </tbody> 
												</table>
												</td>
											</tr>
										</table>
									<!--Pan Card -->
									<table width="100%" border="0" class="table_format idProofSection" id= "idProofSection_<?php echo $panCard;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "panCardRow_<?php echo $panCard;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$panCard."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'3'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$panCard));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
											<tr>
												<td>
												<table class="scrollTr" style="width: 100%">
													<tbody>
														<tr class="appendImg" id="thumbnail_<?php echo $panCard;?>">
															 <?php if(!empty($patientDocData)) {
												  					foreach ($patientDocData as $docKey => $docValue){
												  	 				 if($docValue['PatientDocumentDetail']['category_id']=='3' && $docValue['PatientDocumentDetail']['sub_category_id'] == $panCard){
																		$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
													  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
													  				    if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
													  				    	$cheked='checked';
													  				    }else{
													  				    	$cheked='';
													  				    }
													  				    ?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
												  					<?php } 
																   } 
															 	}?>
															 		
														</tr>
												   </tbody> 
												 </table>
												</td>
											</tr>
										</table>
									<!--Ration Card -->
									<table width="100%" border="0" class="table_format idProofSection" id= "idProofSection_<?php echo $rationCard;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "rationCardRow_<?php echo $rationCard;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$rationCard."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'3'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$rationCard));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
											<tr>
											  <td>
											<table class="scrollTr" style="width: 100%">
													<tbody>
														<tr class="appendImg" id="thumbnail_<?php echo $rationCard;?>">
															 <?php if(!empty($patientDocData)) {
												  					foreach ($patientDocData as $docKey => $docValue){
												  	 				 if($docValue['PatientDocumentDetail']['category_id']=='3' && $docValue['PatientDocumentDetail']['sub_category_id'] == $rationCard){
																		$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
													  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
													  				    if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
													  				    	$cheked='checked';
													  				    }else{
													  				    	$cheked='';
													  				    }
													  				    ?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
												  					<?php } 
																   } 
															 	}?>
															 		
														</tr>
												   </tbody> 
											</table>
											 </td>
										  </tr>
										</table>
										
								</td> 
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset style="width: 95%; height: 200%;" class="panel_resizable"
						id="panel_resizable_1_0">
						<legend style="color: #0099CC">
							<h3>Notes</h3>
						</legend> 
						
						<table width="100%" border="0">
							<tr>
								<td width="100%" valign="top">
									<div style="float: none !important;" id="tab_css"> 
										<ul > 
											<li id="subCatNotes_<?php echo $treatmentSheet;?>" class="active subCatNotes" > <a href="javascript:void(0);">Treatment Sheet</a></li>
											<li id="subCatNotes_<?php echo $programNote;?>"class="subCatNotes" ><a href="javascript:void(0);">Program Notes</a></li>
											<li id="subCatNotes_<?php echo $investigation;?>"class="subCatNotes" ><a href="javascript:void(0);">Investigation</a></li>
											<li id="subCatNotes_<?php echo $otNotes;?>"class="subCatNotes" ><a href="javascript:void(0);">OT Notes</a></li>
											<li id="subCatNotes_<?php echo $anaesthesiaNotes;?>"class="subCatNotes" ><a href="javascript:void(0);">Anaesthesia Notes</a></li>
										</ul>
									</div>
									<!--Treatment Sheet -->
									<table width="100%" border="0" class="table_format noteSection" id= "noteSection_<?php echo $treatmentSheet;?>" >
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "treatmentSheetRow_<?php echo $treatmentSheet;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$treatmentSheet."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'4'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$treatmentSheet));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
											<tr>
												<td>
											     	<table class="scrollTr" style="width: 100%">
														<tbody>
															<tr class="appendImg" id="thumbnail_<?php echo $treatmentSheet;?>">
																 <?php if(!empty($patientDocData)) {
													  					foreach ($patientDocData as $docKey => $docValue){
													  	 				 if($docValue['PatientDocumentDetail']['category_id']=='4' && $docValue['PatientDocumentDetail']['sub_category_id'] == $treatmentSheet){
																			$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
														  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
														  				    if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
														  				    	$cheked='checked';
														  				    }else{
														  				    	$cheked='';
														  				    }
														  				    ?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>" 
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
													  					<?php } 
																	   } 
																 	}?>
																 		
															</tr>
													   </tbody> 
												</table> 
												</td>
											</tr>
										</table>
									
									
									<!--Program Note -->
									<table width="100%" border="0" class="table_format noteSection" id= "noteSection_<?php echo $programNote;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										
									  
										<tbody id= "programNoteRow_<?php echo $programNote;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$programNote."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'4'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$programNote));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										<tr>
										  <td>
										  <table class="scrollTr" style="width: 100%">
												<tbody>
													<tr class="appendImg" id="thumbnail_<?php echo $programNote;?>">
														 <?php if(!empty($patientDocData)) {
											  					foreach ($patientDocData as $docKey => $docValue){
											  	 				 if($docValue['PatientDocumentDetail']['category_id']=='4' && $docValue['PatientDocumentDetail']['sub_category_id'] == $programNote){
																	$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
												  					$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
												  					if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
												  						$cheked='checked';
												  					}else{
												  						$cheked='';
												  					}
												  					?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
											  					<?php } 
															   } 
														 	}?>
														 		
													</tr>
											   </tbody>
											</table>
											</td>
										</tr>
										</table>
									<!--Investigation -->
									<table width="100%" border="0" class="table_format noteSection" id= "noteSection_<?php echo $investigation;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										
										<tbody id= "investigationRow_<?php echo $investigation;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$investigation."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'4'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$investigation));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										<tr>
										 <td>
										   <table class="scrollTr" style="width: 100%">
												<tbody>
													<tr class="appendImg" id="thumbnail_<?php echo $investigation;?>">
														 <?php if(!empty($patientDocData)) {
											  					foreach ($patientDocData as $docKey => $docValue){
											  	 				 if($docValue['PatientDocumentDetail']['category_id']=='4' && $docValue['PatientDocumentDetail']['sub_category_id'] == $investigation){
																	$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
												  					$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
												  					if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
												  						$cheked='checked';
												  					}else{
												  						$cheked='';
												  					}
												  					?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>" 
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
											  					<?php } 
															   } 
														 	}?>
														 		
													</tr>
											   </tbody>  
											</table>
										</td>
										</tr>
										</table>
										
									<!--OT Notes-->
									<table width="100%" border="0" class="table_format noteSection" id= "noteSection_<?php echo $otNotes;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "otNotesRow_<?php echo $otNotes;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$otNotes."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'4'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$otNotes));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										<tr>
										  <td>
										    	<table class="scrollTr" style="width: 100%">
													<tbody>
														<tr class="appendImg" id="thumbnail_<?php echo $otNotes;?>">
															 <?php if(!empty($patientDocData)) {
												  					foreach ($patientDocData as $docKey => $docValue){
												  	 				 if($docValue['PatientDocumentDetail']['category_id']=='4' && $docValue['PatientDocumentDetail']['sub_category_id'] == $otNotes){
																		$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
													  					$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
													  					if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
													  						$cheked='checked';
													  					}else{
													  						$cheked='';
													  					}
													  					?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
												  					<?php } 
																   } 
															 	}?>
															 		
														</tr>
												   </tbody> 
											</table>
										  </td>
										</tr>
										</table>
									
									<!--Anaesthesia Notes -->
									<table width="100%" border="0" class="table_format noteSection" id= "noteSection_<?php echo $anaesthesiaNotes;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "anaesthesiaNotesRow_<?php echo $anaesthesiaNotes;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$anaesthesiaNotes."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'4'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$anaesthesiaNotes));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										 <tr>
										   <td>
										      <table class="scrollTr" style="width: 100%">
													<tbody>
														<tr class="appendImg" id="thumbnail_<?php echo $anaesthesiaNotes;?>">
															 <?php if(!empty($patientDocData)) {
												  					foreach ($patientDocData as $docKey => $docValue){
												  	 				 if($docValue['PatientDocumentDetail']['category_id']=='4' && $docValue['PatientDocumentDetail']['sub_category_id'] == $anaesthesiaNotes){
																		$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
													  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
													  				    if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
													  				    	$cheked='checked';
													  				    }else{
													  				    	$cheked='';
													  				    }
													  				    ?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
																<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
												  					<?php } 
																   } 
															 	}?>
															 		
														</tr>
												   </tbody>
											</table>
										   </td>
										 </tr>
										</table>
									
								</td> 
							</tr>
						</table>
					</fieldset>
				</td>
				</tr>
				
		  <tr>
				<td>
					<fieldset style="width: 95%; height: 200%;" class="panel_resizable"
						id="panel_resizable_1_0">
						<legend style="color: #0099CC">
							<h3>Death Related</h3>
						</legend> 
						
						<table width="100%" border="0">
							<tr>
								<td width="100%" valign="top">
									<div style="float: none !important;" id="tab_css"> 
										<ul > 
											<li id="subCatDeath_<?php echo $deathClinicalPhoto;?>" class="active subCatDeath" > <a href="javascript:void(0);">Death Clinical Photo</a></li>
											<li id="subCatDeath_<?php echo $deathCertificate?>" class="subCatDeath" ><a href="javascript:void(0);">Death Certificate</a></li>
											<li id="subCatDeath_<?php echo $deathSummary;?>" class="subCatDeath" > <a href="javascript:void(0);">Death Summary</a></li>
											<li id="subCatDeath_<?php echo $formFour?>" class="subCatDeath" ><a href="javascript:void(0);">Form 4</a></li>
										</ul>
									</div>
									<!--Death Clinical Photo -->
									<table width="100%" border="0" class="table_format deathSection" id= "deathSection_<?php echo $deathClinicalPhoto;?>" >
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "deathClinicalPhotoRow_<?php echo $deathClinicalPhoto;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$deathClinicalPhoto."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'5'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$deathClinicalPhoto));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										<tr>
										 <td>
										 <table class="scrollTr" style="width: 100%">
											<tbody>
												<tr class="appendImg" id="thumbnail_<?php echo $deathClinicalPhoto;?>">
													 <?php if(!empty($patientDocData)) {
										  					foreach ($patientDocData as $docKey => $docValue){
										  	 				 if($docValue['PatientDocumentDetail']['category_id']=='5' && $docValue['PatientDocumentDetail']['sub_category_id'] == $deathClinicalPhoto){
																$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
											  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
																if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
																	$cheked='checked';
																}else{
																	$cheked='';
																}
															   		?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
										  					<?php } 
														   } 
													 	}?>
													 		
												</tr>
										   </tbody> 
										</table>
										 </td>
										</tr>
										</table>
										
									<!--Death Certificate -->
									<table width="100%" border="0" class="table_format deathSection" id= "deathSection_<?php echo $deathCertificate;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "deathCertificateRow_<?php echo $deathCertificate;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$deathCertificate."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'5'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$deathCertificate));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										<tr>
										  <td>	
										  <table class="scrollTr" style="width: 100%">
											<tbody>
												<tr class="appendImg" id="thumbnail_<?php echo $deathCertificate;?>">
													 <?php if(!empty($patientDocData)) {
										  					foreach ($patientDocData as $docKey => $docValue){
										  	 				 if($docValue['PatientDocumentDetail']['category_id']=='5' && $docValue['PatientDocumentDetail']['sub_category_id'] == $deathCertificate){
																$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
											  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				    if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
											  				    	$cheked='checked';
											  				    }else{
											  				    	$cheked='';
											  				    }
											  				    ?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
										  					<?php } 
														   } 
													 	}?>
													 		
												</tr>
										   </tbody> 
										</table>
										</td>
									</tr>
								  </table>
								  
							<!--Death Summary -->
									<table width="100%" border="0" class="table_format deathSection" id= "deathSection_<?php echo $deathSummary;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "deathSummaryRow_<?php echo $deathSummary;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$deathSummary."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'5'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$deathSummary));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										<tr>
										  <td>	
										  <table class="scrollTr" style="width: 100%">
											<tbody>
												<tr class="appendImg" id="thumbnail_<?php echo $deathSummary;?>">
													 <?php if(!empty($patientDocData)) {
										  					foreach ($patientDocData as $docKey => $docValue){
										  	 				 if($docValue['PatientDocumentDetail']['category_id']=='5' && $docValue['PatientDocumentDetail']['sub_category_id'] == $deathSummary){
																$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
											  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				    if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
											  				    	$cheked='checked';
											  				    }else{
											  				    	$cheked='';
											  				    }
											  				    ?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
										  					<?php } 
														   } 
													 	}?>
													 		
												</tr>
										   </tbody> 
										</table>
										</td>
									</tr>
								  </table>
								  
								 <!--Form 4 -->
									<table width="100%" border="0" class="table_format deathSection" id= "deathSection_<?php echo $formFour;?>" style="display: none">
										<tr>
											<td>
											<table width="100%" border="0">
												<thead>
													<tr>
														<th class="theads">Browse Photo</th>
														<th class="theads">Description</th>
														<th class="theads">Action</th>
													</tr>
												</thead> 
											</table>
										  </td>
										</tr>
										<tbody id= "deathCertificateRow_<?php echo $formFour;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$formFour."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'5'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$formFour));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads"><?php echo $this->Form->input('',array('type'=>'file','multiple'=>true,'class'=>'validate[required,custom[mandatory-select]]','name'=>'data[PatientDocumentDetail][filename_report][]'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>
												 	</tr>
												</table>
												<?php echo $this->Form->end();?>	
										 	</td>
										</tr> 
										</tbody>
										<tr>
										  <td>	
										  <table class="scrollTr" style="width: 100%">
											<tbody>
												<tr class="appendImg" id="thumbnail_<?php echo $formFour;?>">
													 <?php if(!empty($patientDocData)) {
										  					foreach ($patientDocData as $docKey => $docValue){
										  	 				 if($docValue['PatientDocumentDetail']['category_id']=='5' && $docValue['PatientDocumentDetail']['sub_category_id'] == $formFour){
																$fullPath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/thumbnail/".$docValue['PatientDocumentDetail']['filename_report'];
											  				    $imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				    if($docValue['PatientDocumentDetail']['is_download_allow']=='1'){
											  				    	$cheked='checked';
											  				    }else{
											  				    	$cheked='';
											  				    }
											  				    ?>
											  				<td><img src='<?php echo $fullPath;?>' imagepath= "<?php echo $imagePath;?>" class="thumbnailSize imageFancy"  id="image_<?php echo $docKey;?>"  
											  				caption="<?php echo "<b>Description:</b> ".$docValue['PatientDocumentDetail']['document_description'].'<br><b> Package: </b>'.$packageName.'<br><b> Diagnosis: </b>'.$patientData['Diagnosis']['final_diagnosis']; ?>"/>
											  				<?php if($role == $doctorRole || $role == $adminRole){
																			echo $this->Form->input('', array('type' => 'checkbox','id'=>'isApproved_'.$docValue['PatientDocumentDetail']['id'],'class' => 'isApproved','title'=>'Check For Approve','label' => false,'legend' => false,'checked'=>$cheked));
																		}
																	 ?>
											  				</td>
										  					<?php } 
														   } 
													 	}?>
													 		
												</tr>
										   </tbody> 
										</table>
										</td>
									</tr>
								  </table>
								</td> 
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
		</table>

<script>
//upload image and save other details.
 $(document).ready(function (e) {
	 $(document.body).on('submit','.upload_rgjay',function(e){
		e.preventDefault(); //to prevent default form submit
		var formID = $(this).closest(this).attr("id");
		var subCatId = formID.split("_")[1];
		var id = formID.split("_")[2];
		var validateForm = $("#uploadDocument_"+subCatId+"_"+id).validationEngine('validate');
		var patientID = "<?php echo $this->params->pass['0']?>";
		if(validateForm == false){
          return false;
		}
		var formData = new FormData(this);
		$.ajax({
        	url: "<?php echo $this->Html->url(array('controller'=>"Radiologies",'action'=>'uploadDocument'))?>"+"/"+patientID,
			type: "POST",
			data:  formData,
			contentType: false,
    	    cache: false,
			processData:false,
			beforeSend:function()
			{
				$("#busy-indicator").show();
			},	
			success: function(data)
		    {
			    obj= $.parseJSON(data);
			    imgFullPath=obj.fullPath;
			    imgthumnailPath=obj.thumbnail;
			    imgDescription=obj.description;

				$("#busy-indicator").hide();
				//update thumbnail source
				
				$.each(imgFullPath, function(val, text){  
					img='<img src="'+imgthumnailPath[val]+'" imagepath="'+text+'" class="thumbnailSize imageFancy" id="image_'+id+'" caption="'+imgDescription+'" />';
					apendTd=$('<td>'+ img +'</td>'); 
					apendTd.appendTo("#thumbnail_"+subCatId);
					$("#uploadDocument_"+subCatId+"_"+id)[0].reset();//reset current form
				 });
		    },
	   });
	});
	
	// for Photo Category Tabs
	$(".subCatPhoto").click(function(){
		 var currentID = $(this).attr('id').split("_")[1]; 
	     var table = document.getElementById("photoSection_"+currentID);   
	    if (table.style.display !== 'none') { 
	        $("#subCatPhoto_"+currentID).addClass('active'); 
	    }  else {
	        $(".subCatPhoto").removeClass('active'); 
	        $(".photoSection").hide();
	        $("#subCatPhoto_"+currentID).addClass('active'); 
	    }
	    $("#photoSection_"+currentID).fadeToggle('fast');  
	});
	// for Investigation Tabs
	$(".subCatInv").click(function(){
		 var currentID = $(this).attr('id').split("_")[1]; 
	     var table = document.getElementById("invSection_"+currentID);   
	    if (table.style.display !== 'none') { 
	        $("#subCatInv_"+currentID).addClass('active'); 
	    }  else {
	        $(".subCatInv").removeClass('active'); 
	        $(".invSection").hide();
	        $("#subCatInv_"+currentID).addClass('active'); 
	    }
	    $("#invSection_"+currentID).fadeToggle('slow');  
	});
	// for ID Proof Tabs
	$(".subCatIdProof").click(function(){
		 var currentID = $(this).attr('id').split("_")[1]; 
	     var table = document.getElementById("idProofSection_"+currentID);   
	    if (table.style.display !== 'none') { 
	        $("#subCatIdProof_"+currentID).addClass('active'); 
	    }  else {
	        $(".subCatIdProof").removeClass('active'); 
	        $(".idProofSection").hide();
	        $("#subCatIdProof_"+currentID).addClass('active'); 
	    }
	    $("#idProofSection_"+currentID).fadeToggle('slow');  
	});
	// for Notes Tabs
	$(".subCatNotes").click(function(){
		 var currentID = $(this).attr('id').split("_")[1]; 
	     var table = document.getElementById("noteSection_"+currentID);   
	    if (table.style.display !== 'none') { 
	        $("#subCatNotes_"+currentID).addClass('active'); 
	    }  else {
	        $(".subCatNotes").removeClass('active'); 
	        $(".noteSection").hide();
	        $("#subCatNotes_"+currentID).addClass('active'); 
	    }
	    $("#noteSection_"+currentID).fadeToggle('slow');  
	});
  // death related tabs
	$(".subCatDeath").click(function(){
		 var currentID = $(this).attr('id').split("_")[1]; 
	     var table = document.getElementById("deathSection_"+currentID);   
	    if (table.style.display !== 'none') { 
	        $("#subCatDeath_"+currentID).addClass('active'); 
	    }  else {
	        $(".subCatDeath").removeClass('active'); 
	        $(".deathSection").hide();
	        $("#subCatDeath_"+currentID).addClass('active'); 
	    }
	    $("#deathSection_"+currentID).fadeToggle('fast');  
	});
	
$(document).on('click',".imageFancy",function(){
	var splitId = $(this).attr("id").split("_")[1];
	var imagePath = $("#image_"+splitId).attr('imagepath');
	 $.fancybox({
		'href': imagePath,
		 helpers : {
		        title: {
		            type: 'inside'
		        }
		 },
		 afterLoad: function() {
		    	this.title = $("#image_"+splitId).attr('caption');
		 }
	});
	
});

$("#addmissionId").autocomplete({
    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","no","admin" => false,"plugin"=>false)); ?>", 
    setPlaceHolder : false,
	select: function(event,ui){
		$("#patientId").val(ui.item.id);
		if($( "#addmissionId" ).val() != '')
    		var url="<?php echo $this->Html->url(array('controller'=>$this->params['controller'],'action'=>$this->params['action']));?>";
    		window.location.href = url+'/'+$( "#patientId" ).val();
},
 messages: {
     noResults: '',
     results: function() {},
}
});

}); 
 $(document).on('click',".isApproved",function(){
	 		
	 		var docuId = $(this).attr('id').split("_")[1];

	 		if($("#isApproved_"+docuId).is(":checked")){
		 		isAllowDownload = '1';
		    }else{
		    	isAllowDownload = '0';
			 }
 			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "radiologies", "action" => "approveImage","admin" => false)); ?>"+"/"+docuId+"/"+isAllowDownload;
 			$.ajax({
 				beforeSend : function() {
 					$("#busy-indicator").show();
 				},
 				type: 'POST',
 				url: ajaxUrl,
 				dataType: 'html',
 				success: function(data){
 					$("#busy-indicator").hide();
 			},
 			});
 	 });
	 
 $(".showAllStudies").click(function(){
	 
	var id = $(this).attr('id');
	var patientfk = $(this).attr('patientfk');
	$.fancybox({
		'width' : '100%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'onClosed':function(){
			//getSpecial();
			//window.location.reload();
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "radiologies", "action" => "showAllStudies")); ?>"
				 + '/' + id + '/' + patientfk,
		
	});
	$('html, body').animate({ scrollTop: 0 }, 'slow', function () {
    });
});
 		
</script>
