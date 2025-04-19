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
li.dateList a:hover, li.active a {
	background-color: none !important;
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
	  	$ayushmanCard = Configure::read('ayushmanCard');
   		$dischargeSummary = Configure::read('dischargeSummary');
	    $justificationLetter = Configure::read('justificationLetter');
     	$transportation = Configure::read('transportation');
      	$satisfacoryLetter = Configure::read('satisfacoryLetter');
	  
	  $role =$this->Session->read('role');
	  $doctorRole = Configure::read('doctorLabel');
	  $adminRole = Configure::read('adminLabel')
?>


<table width="100%" border="0">
		
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$intraOpPhoto,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$intraOpPhoto));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$intraOpPhoto,'style'=>'display:none'));?>
												 	<!-- <img src='' class="thumbnail thumbnailSize" id="thumbnail_<?php echo $intraOpPhoto?>_1" style="display: none;" /> -->
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
												<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $intraOpPhoto){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
													 		
												
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


												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$onBedPhoto,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$onBedPhoto));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$onBedPhoto,'style'=>'display:none;width: 92%;height: 21px'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
															<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $onBedPhoto){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$onDischargePhoto,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$onDischargePhoto));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$onDischargePhoto,'style'=>'display:none;width: 92%;height: 21px'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
															<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $onDischargePhoto){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$clinicalPhoto,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$clinicalPhoto));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$clinicalPhoto,'style'=>'display:none;width: 92%;height: 21px'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
															<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $clinicalPhoto){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$dischargeOnBed,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$dischargeOnBed));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$dischargeOnBed,'style'=>'display:none;width: 92%;height: 21px'));?>
											 		</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
															<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $dischargeOnBed){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$scarPhoto,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$scarPhoto));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$scarPhoto,'style'=>'display:none;width: 92%;height: 21px'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
															<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='1' && $docValue['PatientDocumentDetail']['sub_category_id'] == $scarPhoto){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$preSurgery,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$preSurgery));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$preSurgery,'style'=>'display:none;width: 92%;height: 21px'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
													<?php if(!empty($patientDocData)) {
						  						foreach ($patientDocData as $docKey => $docValue){
							  	 					if($docValue['PatientDocumentDetail']['category_id']=='2' && $docValue['PatientDocumentDetail']['sub_category_id'] == $preSurgery){

							  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
														$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
									  				
														
														?>	
												<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td >
									  					<a href="<?php echo $imagePath ?>" target="_blank">
									  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
								  						</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
														?>
													</td>
								  			  	</tr>
									  			<?php }else{  ?>
								  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td>
									  					
														<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
															<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
														</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
													</td>
								  			  	</tr>
							  					<?php } ?>


							  					<?php  } 
												   } 
											 	}?>
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$postSurgery,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$postSurgery));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$postSurgery,'style'=>'display:none;width: 92%;height: 21px'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
													<?php if(!empty($patientDocData)) {
						  						foreach ($patientDocData as $docKey => $docValue){
							  	 					if($docValue['PatientDocumentDetail']['category_id']=='2' && $docValue['PatientDocumentDetail']['sub_category_id'] == $postSurgery){

							  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
														$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
									  				
														
														?>	
												<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td >
									  					<a href="<?php echo $imagePath ?>" target="_blank">
									  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
								  						</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
														?>
													</td>
								  			  	</tr>
									  			<?php }else{  ?>
								  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td>
									  					
														<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
															<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
														</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
													</td>
								  			  	</tr>
							  					<?php } ?>


							  					<?php  } 
												   } 
											 	}?>
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
											<li id="subCatIdProof_<?php echo $panCard;?>"  class="subCatIdProof" ><a href="javascript:void(0);">Pan Card</a></li>
											<li id="subCatIdProof_<?php echo $rationCard;?>" class="subCatIdProof" ><a href="javascript:void(0);">Ration Card</a></li>
											<li id="subCatIdProof_<?php echo $ayushmanCard;?>" class="subCatIdProof" ><a href="javascript:void(0);">Ayushman Card</a></li>
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$aadharCard,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$aadharCard));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$aadharCard,'style'=>'display:none;width: 92%;height: 21px'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
													<?php if(!empty($patientDocData)) {
						  						foreach ($patientDocData as $docKey => $docValue){
							  	 					if($docValue['PatientDocumentDetail']['category_id']=='3' && $docValue['PatientDocumentDetail']['sub_category_id'] == $aadharCard){

							  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
														$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
									  				
														
														?>	
												<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td >
									  					<a href="<?php echo $imagePath ?>" target="_blank">
									  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
								  						</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
														?>
													</td>
								  			  	</tr>
									  			<?php }else{  ?>
								  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td>
									  					
														<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
															<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
														</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
													</td>
								  			  	</tr>
							  					<?php } ?>


							  					<?php  } 
												   } 
											 	}?>
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$panCard,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$panCard));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$panCard,'style'=>'display:none;width: 92%;height: 21px'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
															<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='3' && $docValue['PatientDocumentDetail']['sub_category_id'] == $panCard){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
													
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
												 	<td class="theads">

												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$rationCard,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$rationCard));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$rationCard,'style'=>'display:none;width: 92%;height: 21px'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
															<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='3' && $docValue['PatientDocumentDetail']['sub_category_id'] == $rationCard){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
													
												   </tbody> 
											</table>
											 </td>
										  </tr>
										</table>
										<!-- ayushman card -->
										<table width="100%" border="0" class="table_format idProofSection" id= "idProofSection_<?php echo $ayushmanCard;?>" style="display: none">
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
										<tbody id= "ayushmanCardRow_<?php echo $ayushmanCard;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$ayushmanCard."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'3'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$ayushmanCard));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$ayushmanCard,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$ayushmanCard));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$ayushmanCard,'style'=>'display:none;width: 92%;height: 21px'));?>
												 	</td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
															<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='3' && $docValue['PatientDocumentDetail']['sub_category_id'] == $ayushmanCard){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
													
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
											<li id="subCatNotes_<?php echo $programNote;?>"class="subCatNotes" ><a href="javascript:void(0);">Progress Notes</a></li>
											<li id="subCatNotes_<?php echo $investigation;?>"class="subCatNotes" ><a href="javascript:void(0);">Investigation</a></li>
											<li id="subCatNotes_<?php echo $otNotes;?>"class="subCatNotes" ><a href="javascript:void(0);">OT Notes</a></li>
											<li id="subCatNotes_<?php echo $anaesthesiaNotes;?>"class="subCatNotes" ><a href="javascript:void(0);">Anaesthesia Notes</a></li>
											<li id="subCatNotes_<?php echo $dischargeSummary;?>"class="subCatNotes" ><a href="javascript:void(0);">Discharge Sumamry</a></li>
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$treatmentSheet,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$treatmentSheet));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$treatmentSheet,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
															<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='4' && $docValue['PatientDocumentDetail']['sub_category_id'] == $treatmentSheet){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
													
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$programNote,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$programNote));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$programNote,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
														<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='4' && $docValue['PatientDocumentDetail']['sub_category_id'] == $programNote){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
													
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$investigation,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$investigation));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$investigation,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
														<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='4' && $docValue['PatientDocumentDetail']['sub_category_id'] == $investigation){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
													
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$otNotes,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$otNotes));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$otNotes,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
														<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='4' && $docValue['PatientDocumentDetail']['sub_category_id'] == $otNotes){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
													
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$anaesthesiaNotes,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$anaesthesiaNotes));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$anaesthesiaNotes,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
														<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='4' && $docValue['PatientDocumentDetail']['sub_category_id'] == $anaesthesiaNotes){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
													
												   </tbody> 
											</table>
										   </td>
										 </tr>
										</table>
										<!--Discharge Summary -->
									<table width="100%" border="0" class="table_format noteSection" id= "noteSection_<?php echo $dischargeSummary;?>" style="display: none">
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
										
									  
										<tbody id= "dischargeSummaryRow_<?php echo $dischargeSummary;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$dischargeSummary."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'4'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$dischargeSummary));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$dischargeSummary,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$dischargeSummary));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$dischargeSummary,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
														<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='4' && $docValue['PatientDocumentDetail']['sub_category_id'] == $dischargeSummary){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
													
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
				<!-- death related -->
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$deathClinicalPhoto,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$deathClinicalPhoto));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$deathClinicalPhoto,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
														<?php if(!empty($patientDocData)) {
								  						foreach ($patientDocData as $docKey => $docValue){
									  	 					if($docValue['PatientDocumentDetail']['category_id']=='5' && $docValue['PatientDocumentDetail']['sub_category_id'] == $deathClinicalPhoto){

									  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
																$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
											  				
																
																?>	
														<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td >
											  					<a href="<?php echo $imagePath ?>" target="_blank">
											  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
										  						</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
																?>
															</td>
										  			  	</tr>
											  			<?php }else{  ?>
										  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
											  				<td>
											  					
																<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
																	<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
																</a>
											  				
											  			  	</td>
											  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
															</td>
										  			  	</tr>
									  					<?php } ?>


									  					<?php  } 
														   } 
													 	}?>
													
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$deathCertificate,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$deathCertificate));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$deathCertificate,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
												<?php if(!empty($patientDocData)) {
						  						foreach ($patientDocData as $docKey => $docValue){
							  	 					if($docValue['PatientDocumentDetail']['category_id']=='5' && $docValue['PatientDocumentDetail']['sub_category_id'] == $deathCertificate){

							  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
														$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
									  				
														
														?>	
												<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td >
									  					<a href="<?php echo $imagePath ?>" target="_blank">
									  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
								  						</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
														?>
													</td>
								  			  	</tr>
									  			<?php }else{  ?>
								  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td>
									  					
														<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
															<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
														</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
													</td>
								  			  	</tr>
							  					<?php } ?>


							  					<?php  } 
												   } 
											 	}?>
											
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$deathSummary,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$deathSummary));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$deathSummary,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
												<?php if(!empty($patientDocData)) {
						  						foreach ($patientDocData as $docKey => $docValue){
							  	 					if($docValue['PatientDocumentDetail']['category_id']=='5' && $docValue['PatientDocumentDetail']['sub_category_id'] == $deathSummary){

							  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
														$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
									  				
														
														?>	
												<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td >
									  					<a href="<?php echo $imagePath ?>" target="_blank">
									  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
								  						</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
														?>
													</td>
								  			  	</tr>
									  			<?php }else{  ?>
								  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td>
									  					
														<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
															<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
														</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
													</td>
								  			  	</tr>
							  					<?php } ?>


							  					<?php  } 
												   } 
											 	}?>
											
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
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$formFour,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$formFour));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$formFour,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
												<?php if(!empty($patientDocData)) {
						  						foreach ($patientDocData as $docKey => $docValue){
							  	 					if($docValue['PatientDocumentDetail']['category_id']=='5' && $docValue['PatientDocumentDetail']['sub_category_id'] == $formFour){

							  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
														$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
									  				
														
														?>	
												<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td >
									  					<a href="<?php echo $imagePath ?>" target="_blank">
									  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
								  						</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
														?>
													</td>
								  			  	</tr>
									  			<?php }else{  ?>
								  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td>
									  					
														<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
															<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
														</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
													</td>
								  			  	</tr>
							  					<?php } ?>


							  					<?php  } 
												   } 
											 	}?>
											
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

			<!-- other document -->
		  		<tr>
				<td>
					<fieldset style="width: 95%; height: 200%;" class="panel_resizable"
						id="panel_resizable_1_0">
						<legend style="color: #0099CC">
							<h3>Other</h3>
						</legend> 
						
						<table width="100%" border="0">
							<tr>
								<td width="100%" valign="top">
									<div style="float: none !important;" id="tab_css"> 
										<ul > 
											<li id="subCatOther_<?php echo $justificationLetter;?>" class="active subCatOther" > <a href="javascript:void(0);">Justification Letter</a></li>
											<li id="subCatOther_<?php echo $transportation; ?>" class="subCatOther" ><a href="javascript:void(0);">Transportation</a></li>
											<li id="subCatOther_<?php echo $satisfacoryLetter;?>" class="subCatOther" > <a href="javascript:void(0);">Satisfactory Letter</a></li>
											
										</ul>
									</div>
									<!--Justification letter Photo -->
									<table width="100%" border="0" class="table_format otherSection" id= "otherSection_<?php echo $justificationLetter;?>" >
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
										<tbody id= "justificationLetterRow_<?php echo $justificationLetter;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$justificationLetter."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'6'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$justificationLetter));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$justificationLetter,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$justificationLetter));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$justificationLetter,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd ','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
												<?php if(!empty($patientDocData)) {
						  						foreach ($patientDocData as $docKey => $docValue){
							  	 					if($docValue['PatientDocumentDetail']['category_id']=='6' && $docValue['PatientDocumentDetail']['sub_category_id'] == $justificationLetter){

							  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
														$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
									  				
														
														?>	
												<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td >
									  					<a href="<?php echo $imagePath ?>" target="_blank">
									  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
								  						</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
														?>
													</td>
								  			  	</tr>
									  			<?php }else{  ?>
								  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td>
									  					
														<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
															<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
														</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
													</td>
								  			  	</tr>
							  					<?php } ?>


							  					<?php  } 
												   } 
											 	}?>
											
										   </tbody> 
										</table>
										 </td>
										</tr>
										</table>
										
									<!--transportation letter Photo -->
									<table width="100%" border="0" class="table_format otherSection" id= "otherSection_<?php echo $transportation;?>" style="display: none">
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
										<tbody id= "transportationRow_<?php echo $transportation;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$transportation."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'6'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$transportation));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$transportation,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$transportation));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$transportation,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
												<?php if(!empty($patientDocData)) {
						  						foreach ($patientDocData as $docKey => $docValue){
							  	 					if($docValue['PatientDocumentDetail']['category_id']=='6' && $docValue['PatientDocumentDetail']['sub_category_id'] == $transportation){

							  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
														$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
									  				
														
														?>	
												<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td >
									  					<a href="<?php echo $imagePath ?>" target="_blank">
									  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
								  						</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
														?>
													</td>
								  			  	</tr>
									  			<?php }else{  ?>
								  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td>
									  					
														<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
															<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
														</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
													</td>
								  			  	</tr>
							  					<?php } ?>


							  					<?php  } 
												   } 
											 	}?>
											
										   </tbody> 
										</table>
										</td>
									</tr>
								  </table>
								  
							<!--Satisfactory Letter -->
									<table width="100%" border="0" class="table_format otherSection" id= "otherSection_<?php echo $satisfacoryLetter;?>" style="display: none">
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
										<tbody id= "satisfacoryLetterRow_<?php echo $satisfacoryLetter;?>">
										<tr>
											<td>
											<?php echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_rgjay','id'=>"uploadDocument_".$satisfacoryLetter."_1",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
												<table width="100%" border="0">
													<tr>
												<?php 
													  echo $this->Form->hidden('category_id',array('value'=>'6'));
													  echo $this->Form->hidden('sub_category_id',array('value'=>$satisfacoryLetter));
													  echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
													  echo $this->Form->hidden('package_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_category_id']));
													  echo $this->Form->hidden('package_sub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_sub_category_id']));
													  echo $this->Form->hidden('package_subsub_category_id',array('value'=>$galleryPackDetails['GalleryPackageDetail']['package_subsub_category_id']));
												?>
												 	<td class="theads">
												 		<span><?php echo $this->Form->input('is_link',array('type'=>"checkbox",'id'=>'isLink_'.$satisfacoryLetter,'class'=>'isLink','hiddenField'=>false));?></span>
												 		<?php echo $this->Form->input('filename_report',array('type'=>'file','class'=>'validate[required,custom[mandatory-select]]','id'=>'img_'.$satisfacoryLetter));?>

												 		<?php echo $this->Form->input('filename_report_link',array('type'=>'text','class'=>'validate[required,custom[mandatory-select]]','id'=>'link_'.$satisfacoryLetter,'style'=>'display:none;width: 92%;height: 21px'));?>
												    </td>
												 	<td class="theads"><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd','placeHolder'=>"Description","autocomplete"=>"off"))?></td>
												 	<td class="theads"><?php echo $this->Form->button('Upload',array('alt'=>'Upload Record','class'=>'uploadForm blueBtn')) ;?>
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
												<?php if(!empty($patientDocData)) {
						  						foreach ($patientDocData as $docKey => $docValue){
							  	 					if($docValue['PatientDocumentDetail']['category_id']=='6' && $docValue['PatientDocumentDetail']['sub_category_id'] == $satisfacoryLetter){

							  	 				 	if($docValue['PatientDocumentDetail']['is_link'] == '0'){
														$imagePath=  FULL_BASE_URL.Router::url("/")."/uploads/radiology_data/".$docValue['PatientDocumentDetail']['filename_report'];
									  				
														
														?>	
												<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td >
									  					<a href="<?php echo $imagePath ?>" target="_blank">
									  						<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>
								  						</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove'));
														?>
													</td>
								  			  	</tr>
									  			<?php }else{  ?>
								  				<tr id="ImgId_<?php echo $docValue['PatientDocumentDetail']['id'] ?>">
									  				<td>
									  					
														<a href="<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>" target="_blank">
															<?php echo $docValue['PatientDocumentDetail']['filename_report'] ?>		
														</a>
									  				
									  			  	</td>
									  			  	<td><?php echo $this->Html->image('/img/icons/cross.png',array('class'=>'deleteDoc','id'=>$docValue['PatientDocumentDetail']['id'],'alt' => 'Remove')); ?>
													</td>
								  			  	</tr>
							  					<?php } ?>


							  					<?php  } 
												   } 
											 	}?>
											
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
			    /*imgPath=data.split("|")[0];
			    imgDescription=data.split("|")[1];
			    imgFullPath=data.split("|")[2];*/
			    var id = Math.floor((Math.random() * 100) + 1);
				
			    var data=$.parseJSON(data);

			    imgPath=data.thumbnail;
			    imgDescription=data.description;
			    imgFullPath=data.fullPath;
			   
				$("#busy-indicator").hide();
				//update thumbnail source
				//$("#thumbnail_"+subCatId+"_"+id).attr('src',data).show();
				img='<img src="'+imgPath+'" imagepath="'+imgFullPath+'" class="thumbnailSize imageFancy" id="image_'+id+'" caption="'+imgDescription+'" />';
				/*apendTd=$('<td>'+ img +'</td>'); 
				apendTd.appendTo("#thumbnail_"+subCatId);*/
				//$("#uploadDocument_"+subCatId+"_"+id)[0].reset();//reset current form
				load_document_page();
				
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

	// other tabs
	$(".subCatOther").click(function(){
		 var currentID = $(this).attr('id').split("_")[1]; 
	     var table = document.getElementById("otherSection_"+currentID);   
	    if (table.style.display !== 'none') { 
	        $("#subCatOther_"+currentID).addClass('active'); 
	    }  else {
	        $(".subCatOther").removeClass('active'); 
	        $(".otherSection").hide();
	        $("#subCatOther_"+currentID).addClass('active'); 
	    }
	    $("#otherSection_"+currentID).fadeToggle('fast');  
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

$(document).on('click',".isLink",function(){
	var docuId = $(this).attr('id').split("_")[1];

	if($("#isLink_"+docuId).is(":checked")){
 		$('#link_'+docuId).show();
 		$('#img_'+docuId).hide();
    }else{
    	$('#link_'+docuId).hide();
    	$('#img_'+docuId).show();
	 }
});



 		
</script>
