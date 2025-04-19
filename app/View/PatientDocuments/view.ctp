
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('View Patient Documents', true);?><font font-size="20px" font-family="verdana" color="darkolivegreen"><?php echo "&nbsp;(".$patientData['Patient']['lookup_name'].' - '.$patientData['Patient']['patient_id'].")"; ?>
		</font>
		
	</h3>	
	<span><?php
	echo $this->Html->link(__('Back'), array('action' => 'index',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
	?> </span>

</div>
<?php 
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

     ?></td>
	</tr>
</table>
<?php } ?>

<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#PatientDocumentEditForm").validationEngine();
	});
 
 </script>

<div class="clr ht5"></div>
<?php if($patient['Patient']['id'] != 0) 
		echo $this->element('patient_information');?>
<div class="clr ht5"></div>

<?php echo $this->Form->create('PatientDocument',array('type' => 'file'));?>
<table border="0" cellpadding="0" cellspacing="0" width="54%"
	align="center">
	<tr>
		<td class="tdLabel">Click to view document   :</td>
		<td>
		<?php 
		 
			if(!empty($data['PatientDocument']['link'])){
				$docHtml .='<a target="_blank" href="'.$data['PatientDocument']['link'].'">'.$data['PatientDocument']['link'].'</a>';
			}
			else if(!empty($data['PatientDocument']['filename'])){
				$file1=unserialize($data['PatientDocument']['filename']);
				 foreach($file1 as $key=>$files1){
			$image1[$key]=  FULL_BASE_URL.Router::url("/")."uploads/user_images/".$files1;
			//$docHtml1 .='<a  target="_blank" href="'.$image.'">'.$files1.'</a>';	
		  
			echo $this->Html->link($files1,$image1[$key],array('escape'=>false,'target'=>'__blank')).",";
			
		  }
				//$image=  FULL_BASE_URL.Router::url("/")."uploads/user_images/".$data['PatientDocument']['filename'];
				//$docHtml .='<a  target="_blank" href="'.$image.'">'.$data['PatientDocument']['filename'].'</a>';
			}
			else{
				$docHtml .='&nbps; ';
			}
			
			echo $docHtml ;
		?>
		</td>

	</tr> 
	<!--<tr>
		<td class="tdLabel">Date Of Birth :
		</td>
		<td 'style'="padding-top:5px;" class="tdLabel"><?php echo $this->DateFormat->formatDate2LocalForReport($data['PatientDocument']['dob'],Configure::read('date_format'),false);?> 
		</td>
	</tr>-->
	 <tr>
		<td class="tdLabel">Document Type   :</td>
		<td class="tdLabel">
		<?php echo $data['PatientDocumentType']['name'];
		//$this->Form->input('document_id',array('empty'=>__('Select'),'options'=>$document_list,'escape'=>false,'multiple'=>false,'value'=>$data['PatientDocument']['document_id'],			'style'=>'width:143px;','id'=>'device_detail','class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','label'=>false,'div'=>false,'empty'=> 'Please Select','disabled'=>'disabled'));?></td>
	</tr>
	
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>

	
	
	<tr>
		<td class="tdLabel">Date   :
		</td>
		<td class="tdLabel"><?php 
		echo $this->DateFormat->formatDate2LocalForReport($data['PatientDocument']['date'],Configure::read('date_format'),true);?> 
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td class="tdLabel">Document Description   :</td>
		<td class="tdLabel"><?php  echo $data['PatientDocument']['document_description'];?>
		</td>
	</tr>
	<!--<tr>
		<td  width="20%" class="tdLabel">Primary Care Provider :
		</td>
		<td class="tdLabel">
		<?php echo $this->Form->input('sb_registrar', array('options'=>$registrar,'empty'=>'Please select','id' => 'sb_registrar','style'=> 'width:143px','class'=>' textBoxExpnd','value'=>$data['PatientDocument']['sb_registrar'],'label'=>false,'disabled'=>'disabled'))						?>
										
		</td>
	</tr>-->
	
	<tr>
		<td class="tdLabel">Comments   :</td>
		<td class="tdLabel"><?php  echo $data['PatientDocument']['comment'];?></td>
	</tr>
	<!--<tr>
	<td width="220px">Sign Document:
	</td>
	<td> <?php echo $this->Form->input('sign_document',array("type"=>"checkbox",'label'=>false,'id'=>'sign_Document','value'=>$data['PatientDocument']['sign_document']));?></td>
	</tr>-->
	</table>

	<?php echo $this->Form->end();?>

<script>
  <?php if(isset($forUrl)) {?>
  	$("#link").css("display","inline");
    $("#document").css("display","none");
	$("#document_radio").attr("checked",false);
	$("#url_radio").attr("checked",true);
  
  <?php }?>

 
 </script>
