<?php
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');?>
<div class="inner_title">
<h3>
<?php echo __('Clearance'); ?>
<span style="padding-top: 20px">
<?php
    echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'doctor_dashboard'), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</h3>
</div>
<div>&nbsp</div>

<?php echo $this->Form->create('User',array('action'=>'clearance','type'=>'get'));?>
<table border="0" class=" " cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tbody>

		<tr class="">
		
			<td class="tdLabel" id="boxSpace" align="right" width="9%"><?php echo __('Patient Name') ?>
					:</td>
			<td class=" " style="width: 12%"><?php 
			echo    $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
			?>
			</td>
			<td class=" " align="left"><?php
			echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));
			?>
			</td>
		</tr>
	</tbody>
</table>
<?php  echo $this->Form->end();?>
<div id="no_app">
	<?php
	if(empty($data)){
			echo "<span class='error'>";
			echo __('No record found.');
			echo "</span>";
		}
		?>
</div>
<table border="0" class="tabularForm" cellpadding="0" cellspacing="1" width="100%" style="text-align:center;">
  <tr class="row_title">
   
    <td style=width:25% class="table_cell" align="center"><strong>Patient Name </td>    
    <td class="table_cell" align="center"><strong>Doctor Clearance  </td>
    <td class="table_cell" align="center"><strong> Nurse Clearance</td>
    <td class="table_cell" align="center"><strong>Lab Clearance </td>
    <td class="table_cell" align="center"><strong>Radiology Clearance </td>
    <td class="table_cell" align="center"><strong>Pharmacy Clearance </td>
  <!--   <td class="table_cell" align="center"><strong>Frontoffice Clearance </td> -->
    <td class="table_cell" align="center"><strong>Action </td>
  </tr>
  <?php 
$role = $this->Session->read('role');
?>
<?php 
foreach($data as $key=>$patient): 
//
	$clear = unserialize($patient['Patient']['clearance']);
	
  $patientChkArray=$clear[$patient['Patient']['id']];//debug($patientChkArray['laboratory']);
  if($patientChkArray['doctor']=='1')$drChk=true;else$drChk='';
  if($patientChkArray['nurse']=='1')$nurseChk=true;else$nurseChk='';
  if($patientChkArray['laboratory']=='1')$labChk=true;else$labChk='';
  if($patientChkArray['radiology']=='1')$radChk=true;else$radChk='';
  if($patientChkArray['pharmacy']=='1')$pharChk=true;else$pharChk='';
 // if($patientChkArray['frontoffice']=='1')$frntofcChk=true;else$frntofcChk='';
  
  
  ?>
  
 
<!-- BOF Doctor Clearance -->	
<?php //echo $this->Form->create('',array('controller'=>'users','action'=>'clearance','id'=>'clear'))?>						      
<?php if((strtolower($role)==strtolower(Configure::read('doctorLabel')))||(strtolower($role)==strtolower(Configure::read('adminLabel')))){ ?>  
<tr>
<td align="center" class="row_format "><?php echo $patient['Patient']['lookup_name']?>
<td align="center" class="row_format ">
<table border="0"  cellpadding="0" cellspacing="1" width="100%" ><tr><td align="center">
<?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][doctor]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>$drChk,'checked'=>$drChk));?></td></tr>
<tr>
<td align="left" style="padding-left: 0px"><?php  
if($patientChkArray['doctor_username']!="" && $patientChkArray['doctor_date']!=""){
echo"</br>"; echo "Created By:" . $patientChkArray['doctor_username'];
echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['doctor_date']),Configure::read('date_format'),true); }
?></td>
</tr>
 </table >
</td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][nurse]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$nurseChk));
if($patientChkArray['nurse_username']!="" && $patientChkArray['nurse_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['nurse_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['nurse_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][laboratory]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$labChk));
if($patientChkArray['lab_username']!="" && $patientChkArray['lab_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['lab_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['lab_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][radiology]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$radChk));
if($patientChkArray['rad_username']!="" && $patientChkArray['rad_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['rad_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['rad_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][pharmacy]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$pharChk));
if($patientChkArray['pharmacy_username']!="" && $patientChkArray['pharmacy_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['pharmacy_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['pharmacy_date']),Configure::read('date_format'),true);}
?></td>
<!-- <td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][frontoffice]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$frntofcChk));
if($patientChkArray['front_username']!="" && $patientChkArray['front_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['front_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['front_date']),Configure::read('date_format'),true);}
?></td> -->
<td align="center" class="row_format "><?php echo $this->Form->button(__('Submit'),array('id'=>$patient['Patient']['id'],'escape' => false,'class'=>'blueBtn clrSubmit')); ?></td>
</tr>
<!-- -----------------------------------------------------EOF Doctor Clearance ------------------------------------------------->	
<!-- -----------------------------------------------------BOF Nurse Clearance------------------------------------------------ -->	
<?php }else if((strtolower($role)==strtolower(Configure::read('nurseLabel')))||(strtolower($role)==strtolower(Configure::read('adminLabel')))){ ?>
<tr>
<td align="center" class="row_format "><?php echo $patient['Patient']['lookup_name']?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][doctor]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$drChk));
if($patientChkArray['doctor_username']!="" && $patientChkArray['doctor_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['doctor_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['doctor_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format ">
<table border="0"  cellpadding="0" cellspacing="1" width="100%" >
<tr>
<td align="center">
<?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][nurse]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>$nurseChk,'checked'=>$nurseChk));?>
</td>
</tr>
<tr>
 <td align="left" style="padding-left: 0px">  <?php     echo $this->Html->link('Discharge Summary',array('controller'=>'billings','action'=>'discharge_summary',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));
 if($patientChkArray['nurse_username']!="" && $patientChkArray['nurse_date']!=""){
 echo"</br>";  echo "Created By:". $patientChkArray['nurse_username'];
    echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['nurse_date']),Configure::read('date_format'),true);} ?>
 </td>
</tr>
 </table >
</td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][laboratory]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$labChk));
    if($patientChkArray['lab_username']!="" && $patientChkArray['lab_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['lab_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['lab_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][radiology]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$radChk));
if($patientChkArray['rad_username']!="" && $patientChkArray['rad_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['rad_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['rad_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][pharmacy]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$pharChk));
if($patientChkArray['pharmacy_username']!="" && $patientChkArray['pharmacy_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['pharmacy_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['pharmacy_date']),Configure::read('date_format'),true);}
?></td>
<!-- <td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][frontoffice]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$frntofcChk));
if($patientChkArray['front_username']!="" && $patientChkArray['front_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['front_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['front_date']),Configure::read('date_format'),true);}
?></td> -->
<td align="center" class="row_format "><?php echo $this->Form->button(__('Submit'),array('id'=>$patient['Patient']['id'],'escape' => false,'class'=>'blueBtn clrSubmit')); ?></td>
</tr>
<!------------------------------------------EOF Nurse Clearance -------------------------------------------------------------->	

<!-- EOF Lab Clearance -->	
<?php }else if((strtolower($role)==strtolower(Configure::read('labManager')))||(strtolower($role)==strtolower(Configure::read('adminLabel')))){ ?>
<tr>
<td align="center" class="row_format "><?php echo $patient['Patient']['lookup_name']?>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][doctor]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$drChk));
if($patientChkArray['doctor_username']!="" && $patientChkArray['doctor_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['doctor_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['doctor_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][nurse]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$nurseChk));
if($patientChkArray['nurse_username']!="" && $patientChkArray['nurse_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['nurse_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['nurse_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format ">
<table border="0"  cellpadding="0" cellspacing="1" width="100%" >
<tr>
  <td align="center">
<?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][laboratory]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>$labChk,'checked'=>$labChk));?>
 </td>
</tr>
  <tr>
    <td align="left" style="padding-left: 0px">
<?php if($patientChkArray['lab_username']!="" && $patientChkArray['lab_date']!=""){  
     echo"</br>";    echo "Created By:". $patientChkArray['lab_username'];
     echo"</br>";    echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['lab_date']),Configure::read('date_format'),true);} ?>
    </td>
 </tr>   
</table>    
</td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][radiology]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$radChk));
if($patientChkArray['rad_username']!="" && $patientChkArray['rad_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['rad_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['rad_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][pharmacy]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$pharChk));
if($patientChkArray['pharmacy_username']!="" && $patientChkArray['pharmacy_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['pharmacy_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['pharmacy_date']),Configure::read('date_format'),true);}
?></td>
<!-- <td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][frontoffice]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$frntofcChk));
if($patientChkArray['front_username']!="" && $patientChkArray['front_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['front_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['front_date']),Configure::read('date_format'),true);}
?></td> -->
<td align="center" class="row_format "><?php echo $this->Form->button(__('Submit'),array('id'=>$patient['Patient']['id'],'escape' => false,'class'=>'blueBtn clrSubmit')); ?></td>
</tr>
<!-- EOF Lab Clearance -->	
<!-- BOF Rad Clearance -->	
<?php  }else if((strtolower($role)==strtolower(Configure::read('radManager')))||(strtolower($role)==strtolower(Configure::read('adminLabel')))){ ?>
<tr>
<td align="center" class="row_format "><?php echo $patient['Patient']['lookup_name']?>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][doctor]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$drChk));
if($patientChkArray['doctor_username']!="" && $patientChkArray['doctor_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['doctor_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['doctor_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][nurse]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$nurseChk));
if($patientChkArray['nurse_username']!="" && $patientChkArray['nurse_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['nurse_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['nurse_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][laboratory]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$labChk));
if($patientChkArray['lab_username']!="" && $patientChkArray['lab_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['lab_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['lab_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format ">
<table border="0"  cellpadding="0" cellspacing="1" width="100%" >
<tr>
  <td align="center">
<?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][radiology]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>$radChk,'checked'=>$radChk));?>
 </td>
 </tr>
  <tr>
    <td align="left" style="padding-left: 0px">
   <?php  if($patientChkArray['rad_username']!="" && $patientChkArray['rad_date']!=""){ 
    echo"</br>";   echo "Created By:". $patientChkArray['rad_username'];
    echo"</br>";  echo "Date:" .$this->DateFormat->formatDate2Local(trim($patientChkArray['rad_date']),Configure::read('date_format'),true);} ?>
    </td>
  </tr>   
</table>  
    </td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][pharmacy]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$pharChk));
if($patientChkArray['pharmacy_username']!="" && $patientChkArray['pharmacy_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['pharmacy_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['pharmacy_date']),Configure::read('date_format'),true);}
?></td>
<!-- <td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][frontoffice]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$frntofcChk));
if($patientChkArray['front_username']!="" && $patientChkArray['front_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['front_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['front_date']),Configure::read('date_format'),true);}
?></td> -->
<td align="center" class="row_format "><?php echo $this->Form->button(__('Submit'),array('id'=>$patient['Patient']['id'],'escape' => false,'class'=>'blueBtn clrSubmit')); ?></td>
</tr>
<!-- EOF Rad Clearance -->	
<!-- BOF Pharmacy Clearance -->	
<?php } else if((strtolower($role)==strtolower(Configure::read('pharmacyManager')))||(strtolower($role)==strtolower(Configure::read('adminLabel')))){?>
<tr>
<td align="center" class="row_format "><?php echo $patient['Patient']['lookup_name']?>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][doctor]",'hiddenField'=>false,'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$drChk));
if($patientChkArray['doctor_username']!="" && $patientChkArray['doctor_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['doctor_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['doctor_date']),Configure::read('date_format'),true);}
?></td>

<td align="center" class="row_format "><?php
echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][nurse]",'hiddenField'=>false,'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$nurseChk));
if($patientChkArray['nurse_username']!="" && $patientChkArray['nurse_username']!=""){
echo"</br>";   echo "Created By:". $patientChkArray['nurse_username'];
echo"</br>";  echo "Date:" .$this->DateFormat->formatDate2Local(trim($patientChkArray['nurse_date']),Configure::read('date_format'),true);}

?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][laboratory]",'hiddenField'=>false,'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$labChk));
if($patientChkArray['lab_username']!="" && $patientChkArray['lab_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['lab_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['lab_date']),Configure::read('date_format'),true);}
?></td>

<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][radiology]",'hiddenField'=>false,'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$radChk));
if($patientChkArray['rad_username']!="" && $patientChkArray['rad_date']!=""){ 
    echo"</br>";   echo "Created By:". $patientChkArray['rad_username'];
    echo"</br>";  echo "Date:" .$this->DateFormat->formatDate2Local(trim($patientChkArray['rad_date']),Configure::read('date_format'),true);}
?></td>

<td align="center" class="row_format ">
<table border="0"  cellpadding="0" cellspacing="1" width="100%" >
<tr>
  <td align="center">
<?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][pharmacy]",'hiddenField'=>false,'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>$pharChk,'checked'=>$pharChk));?>
</td>
 </tr>
  <tr>
    <td align="left" style="padding-left: 0px">
<?php 
    echo $this->Html->link('View Payment',array('controller'=>'Pharmacy','action'=>'pharmacy_details' ,'sales','inventory'=>true),array('style'=>'text-decoration:underline;','target'=>'_blank'));
    if($patientChkArray['pharmacy_username']!="" && $patientChkArray['pharmacy_date']!=""){
    echo"</br>";   echo "Created By:". $patientChkArray['pharmacy_username'];
    echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['pharmacy_date']),Configure::read('date_format'),true) ;     }?>
</td>
  </tr>   
</table>     
    </td>
<!-- <td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][frontoffice]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$frntofcChk));
if($patientChkArray['front_username']!="" && $patientChkArray['front_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['front_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['front_date']),Configure::read('date_format'),true);}
?></td> -->
<td align="center" class="row_format "><?php echo $this->Form->button(__('Submit'),array('id'=>$patient['Patient']['id'],'escape' => false,'class'=>'blueBtn clrSubmit')); ?></td>
</tr>
<!-- EOF Pharmacy Clearance -->	



<!-- BOF frontoffice Clearance -->	
<?php }else if((strtolower($role)==strtolower(Configure::read('frontOfficeLabel')))||(strtolower($role)==strtolower(Configure::read('adminLabel')))){?>
<tr>
<td align="center" class="row_format "><?php echo $patient['Patient']['lookup_name']?>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][doctor]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$drChk));
if($patientChkArray['doctor_username']!="" && $patientChkArray['doctor_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['doctor_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['doctor_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][nurse]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$nurseChk));
if($patientChkArray['nurse_username']!="" && $patientChkArray['nurse_username']!=""){
	echo"</br>";   echo "Created By:". $patientChkArray['nurse_username'];
	echo"</br>";  echo "Date:" .$this->DateFormat->formatDate2Local(trim($patientChkArray['nurse_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][laboratory]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$labChk));
if($patientChkArray['lab_username']!="" && $patientChkArray['lab_date']!=""){
	echo"</br>";  echo "Created By:". $patientChkArray['lab_username'];
	echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['lab_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][radiology]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$radChk));
if($patientChkArray['rad_username']!="" && $patientChkArray['rad_date']!=""){
	echo"</br>";   echo "Created By:". $patientChkArray['rad_username'];
	echo"</br>";  echo "Date:" .$this->DateFormat->formatDate2Local(trim($patientChkArray['rad_date']),Configure::read('date_format'),true);}
?></td>
<td align="center" class="row_format "><?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][pharmacy]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>'disabled','checked'=>$pharChk));
if($patientChkArray['pharmacy_username']!="" && $patientChkArray['pharmacy_date']!=""){
	echo"</br>";   echo "Created By:". $patientChkArray['pharmacy_username'];
	echo"</br>";  echo "Date:" .$this->DateFormat->formatDate2Local(trim($patientChkArray['pharmacy_date']),Configure::read('date_format'),true);}
?></td>

<!-- <td align="center" class="row_format ">
<table border="0"  cellpadding="0" cellspacing="1" width="100%" >
<tr>
  <td align="center">
<?php echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$patient[Patient][id]."][frontoffice]",'type'=>'checkbox','legend'=>false,'label'=>false,'class'=>'clr-'.$patient['Patient']['id'],'disabled'=>$frntofcChk,'checked'=>$frntofcChk));?>
   </td>
 </tr>
  <tr>
    <td align="left" style="padding-left: 0px"><?php 
echo $this->Html->link('View Payment',array('controller'=>'Billings','action'=>'multiplePaymentModeIpd',$patient['Patient']['id']),array('style'=>'text-decoration:underline;','target'=>'_blank'));
if($patientChkArray['front_username']!="" && $patientChkArray['front_date']!=""){
echo"</br>";    echo "CreatedBy:" ; echo $patientChkArray['front_username'];
echo"</br>";  echo "Date:".$this->DateFormat->formatDate2Local(trim($patientChkArray['front_date']),Configure::read('date_format'),true);}
?>
    </td>
  </tr>   
</table> 
</td> -->

<td align="center" class="row_format "><?php echo $this->Form->button(__('Submit'),array('id'=>$patient['Patient']['id'],'escape' => false,'class'=>'blueBtn clrSubmit')); ?></td>
</tr>
<!-- EOF Frontoffice Clearance -->	
<?php }?>
<?php //echo $this->Form->end();?>
<?php endforeach;  ?>
	<tr>
		<TD colspan="10" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
		</span>
		</TD>
	</tr>


 <?php //debug($clear);?>
  

 </table>
<script>

$('.clrSubmit').click(function (){
	var thisinputsClass = "clr-"+$(this).attr('id');
	formData = $('.'+thisinputsClass).serialize();
	//alert(formData);
	 $.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "clearance", "admin" => false)); ?>",
			  context: document.body,
			//  data:'id='+apptId+'&patient_id='+patId,
			  
			  data: formData+"&patientId="+$(this).attr('id'),
			  beforeSend:function(){
				  $('#busy-indicator').show('slow');
				  }, 	  		  
			  success: function(data){
				  $('#busy-indicator').hide('slow');
				  window.location.reload(true);
				  }
			  
		});
});

$(document).ready(function(){
	 $("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null','null','null','admission_type'=>'IPD',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
		
		
	});

</script>