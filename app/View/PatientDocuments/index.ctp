<?php echo $this->Html->script('topheaderfreeze') ;?>



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
<div class="inner_title">
<h3> &nbsp; <?php echo __('Manage Patient Document', true); ?>
<font font-size="20px" font-family="verdana" color="darkolivegreen"><?php echo "&nbsp;(".$patientData['Patient']['lookup_name'].' - '.$patientData['Patient']['patient_id'].")";
		if(!empty($patientData['Diagnosis']['final_diagnosis']))
			echo ",&nbsp;Diagnosis :".$patientData['Diagnosis']['final_diagnosis'];
		if(!empty($patientData['TariffStandard']['name']))
			echo ",&nbsp;Tariff :".$patientData['TariffStandard']['name'];?>
		</font></h3>
<span>
<?php
echo $this->Html->link(__('Add Patient Document'), array('action' => 'add',$patientId), array('escape' => false,'class'=>'blueBtn'));
 echo $this->Html->link(__('Back', true),array('action' => 'radiologistDashboard'), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
</br>
<?php echo $this->Form->create('PatientDocument',array('url'=>array('controller'=>'PatientDocuments','action'=>'index'),'id'=>'PatientDocIndexFrm','type'=>'get', 'inputDefaults' => array('label' => false,'div' => false)));?>
<table border="0" cellpadding="0" cellspacing="0" width="45%" style="text-align:center;" align="center" class="tabularForm">
  <tr class="row_title">
 
    <td class="table_cell" align="left" width="40%"><strong><?php echo __('Patient Name', true); ?></strong></td>
     <td class="table_cell" align="left" width="50%"><?php echo $this->Form->input('PatientDocument.lookup_name',array('id'=>'lookup_name','class'=>'textBoxExpnd','label'=>false,'div'=>false,'style'=>'width:200px;')); 
	 echo $this->Form->hidden('PatientDocument.patient_id',array('id'=>'patient_id'));?></td>
     <td class="table_cell" align="left" width="10%"><?php echo $this->Form->submit(__('Search'), array('id'=>'submit','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));?></td>
	<td class="table_cell" align="left" width="10%"><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'index',$patientId),array('escape'=>false, 'title' => 'Refresh'));?></td>
	</tr>
  </table>
  <?php echo $this->Form->end();?>
<div class="clr ht5"></div>
<?php if($patient['Patient']['id'] != 0) 
		//echo $this->element('patient_information');?>
<div class="clr ht5"></div>

<table  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;" align="center" id="container-table" class="tabularForm">
  <tr class="row_title"> 
   <td class="table_cell" align="left" width="25%"><strong><?php echo $this->Paginator->sort('PatientDocumentType.name',__('Service Name', true)); ?></strong></td>	
    <td class="table_cell" align="left" width="25%"><strong><?php echo $this->Paginator->sort('PatientDocument.filename',__('Images', true)); ?></strong></td>   
	<td class="table_cell" align="left" width="25%"><strong><?php echo $this->Paginator->sort('PatientDocument.filename_report',__('Report', true)); ?></strong></td>      
	<td class="table_cell" align="left" width="12%"><strong><?php echo $this->Paginator->sort('PatientDocument.create_time',__('Date & Time', true)); ?><?php echo (__('', true)); ?></strong></td>
	<td class="table_cell" align="left" width="8%"><strong><?php echo $this->Paginator->sort('PatientDocument.bill_amount',__('Bill Amount', true)); ?></strong></td>
    <td class="table_cell" align="left" width="5%"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
  	  $toggle =0;
	 // unset($docHtml);
	 // unset($image);
      if(count($data) > 0) {
       foreach($data as $document): 
        if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
 <td  align="left"  valign="top" style="padding-left:20px;"> 
 	<?php $serviceId=unserialize($document['PatientDocument']['document_id']);
		$file1=unserialize($document['PatientDocument']['filename']);
		   $fileType1=unserialize($document['PatientDocument']['type']);
		   $fileSize1=unserialize($document['PatientDocument']['size']);
	
	//foreach($tariffListData[$document['PatientDocument']['id']] as $tariffListDatas){
	  foreach($serviceId as $keyS=>$serviceIds){?>
			<ul>
			<li>
				<?php 
				echo $tariffListData[$document['PatientDocument']['id']][$serviceIds]; ?>
			</ul>
			</li>
			
		  <?php }
		 ?>		
 </td>
 
 <td  align="left" valign="top" ><?php //debug($document); ?>
 <table border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:left;" align="left">

 	<?php //$file1=array_reverse($file1);
		  //foreach($file1 as $key=>$files1){
			
			foreach($serviceId as $key=>$serviceIds){?>
			 <tr>
			<td valign="top">
			<?php	if(!empty($file1[$key])){
			$image1[$key]=  FULL_BASE_URL.Router::url("/").'uploads/user_images/'.$file1[$key];
			?>
			
			<?php $typeF1=$fileType1[$key];
				  $sizeF1=$fileSize1[$key];
			$files1Name=explode("_",$file1[$key]);
		  echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Document','title'=>'Download Document','width'=>'20','height'=>'18')),array('action'=>'download',$patient['Patient']['id'],$document['PatientDocument']['id'],$key),array('escape'=>false ))." ".$this->Html->link($files1Name[0],$image1[$key],array('escape'=>false,'target'=>'__blank'));
				}else{
			  echo "<span>NA</span>";
		  }?>
			</td>
			 </tr>
    	  <?php }?>	
		</table>
		
 </td>
 <td  align="left" valign="top" >
 <table border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:left;" align="left">

 	<?php  $file2=unserialize($document['PatientDocument']['filename_report']);		
		   //$file2=array_reverse($file2);
		
		   $fileType2=unserialize($document['PatientDocument']['type_report']);	
		   $fileType2=array_reverse($fileType2);
		   $fileSize2=unserialize($document['PatientDocument']['size_report']);
		   $fileSize2=array_reverse($fileSize2);
		 
		 //foreach($file1 as $key1=>$filess1){
			foreach($serviceId as $key1=>$serviceIds){
			$image2[$key1]=  FULL_BASE_URL.Router::url("/").'uploads/user_images/'.$file2[$key1];
		
		  ?>
			<tr>
			<td valign="top">
			<?php 	if(!empty($file2[$key1])){
			
			$files2Name[$key1]=explode("_",$file2[$key1]);			
			if(!empty($file2[$key1])){
			echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Document','title'=>'Download Document','width'=>'20','height'=>'18')),  		array('action'=>'download',$patient['Patient']['id'],$document['PatientDocument']['id'],$key1,'docreport2'),array('escape'=>false));
			}
			
			echo $this->Html->link($files2Name[$key1][0],$image2[$key1],array('escape'=>false,'target'=>'__blank'));
		  }else{
			  echo "<span>NA</span>";
		  }?>
		</td>
			</tr>
			
		  <?php }?>	
	</table>	
 </td>
 
  <td align="left" valign="top" style="padding-left:5px;">
	<?php
 	echo $this->DateFormat->formatDate2LocalForReport($document['PatientDocument']['date'],Configure::read('date_format'),true);
 ?>
	</td>
  <td align="left" valign="top" style="padding-left:5px;"><?php
 	echo $document['PatientDocument']['bill_amount'];
 ?></td>
   
   <td class="row_action" valign="top" style="padding-left:5px;">
   <?php 
  
  // echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Document','title'=>'Download Document','width'=>'20','height'=>'18')),  		array('action'=>'download',$patient['Patient']['id'],$document['PatientDocument']['id']),array('escape'=>false ,'style'=>'display:block;'));
   	  echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit', true), 'title' => __('Edit', true))), array('action' => 'edit', $patient['Patient']['id'],$document['PatientDocument']['id']), array('escape' => false));
     echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete', true), 'title' => __('Delete', true))), array('action' => 'delete', $patient['Patient']['id'],$document['PatientDocument']['id']), array('escape' => false),__('Are you sure?', true));
    // echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View', true), 'title' => __('View', true))), array('action' => 'view', $patient['Patient']['id'],$document['PatientDocument']['id']), array('escape' => false));
 
   ?>
   </td>
  </tr>
  <?php endforeach;  ?>
  
  <?php
  
      } else {
  ?>
  <tr>
   <TD colspan="8" align="center"><strong><font color="Red"><?php echo __('No record found', true); ?>.</font></strong></TD>
  </tr>
  <?php
      }
  ?>
 </table>
 <script>
 var patientId ='';
$(document).ready(function(){
	$("#container-table").freezeHeader({ 'height': '450px'});
	/*$( "#lookup_name" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","lookup_name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		minLength: 1,
		select: function( event, ui ) {
			patientId = ui.item.id;
			$('#patient_id').val(patientId);
		},
		messages: {
			noResults: '',
			results: function() {}
		 }
	});*/
	$('#lookup_name').autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'no',"admin" => false,"plugin"=>false)); ?>",
				select: function(event,ui){					
					$('#patient_id').val(ui.item.id);		
				},
				 messages: {
		         noResults: '',
		         results: function() {},
		   		},
			});
});
/* $('#searchDocument').click(function (){
	var URL = "<?php echo $this->Html->url(array("controller" => "PatientDocuments", "action" => "index","admin" => false,"plugin"=>false)); ?>";
	if(patientId != '')
		window.location.href = URL+'/index/'+patientId;
	else
		window.location.href = URL;
});*/
 </script>