<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<?php echo $this->Html->css(array('internal_style.css')); ?>
<?php echo $this->Html->script('jquery-1.5.1.min.js'); 

$website=$this->Session->read("website.instance");

?>
<title>
		<?php echo __('', true); ?>
 </title>
 <style>
 body{padding:0; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000;}
	.boxBorder{border:1px solid #3E474A;}
	.boxBorderBot{border-bottom:1px solid #3E474A;}
	.boxBorderRight{border-right:1px solid #3E474A;}
	.boxBorderLeft{border-left:1px solid #3E474A;}
	.tdBorderRtBt{border-right:1px solid #3E474A; border-bottom:1px solid #3E474A;}
	.tdBorderBt{border-bottom:1px solid #3E474A;}
	.tdBorderTp{border-top:1px solid #3E474A;}
	.tdBorderRt{border-right:1px solid #3E474A;}
	.tdBorderTpBt{border-bottom:1px solid #3E474A; border-top:1px solid #3E474A;}
	.tdBorderTpRt{border-top:1px solid #3E474A; border-right:1px solid #3E474A;}
	.bor_top_dashed{border-top:1px dashed #000;}
 </style>
</head>
<body style="background:none;width:98%;margin:auto;">
<style>
	 #printButton{ position:relative!important;}
	</style>
   <div style="float:right;" id="printButton">
		<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
	</div>

<table border="0" width="800" cellspacing="0" cellpadding="0" >
 <tr>
             <td width="20%">
           <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr><td align="left" style="font-size:22px;" ><?php echo $this->Html->image('icons/Prescription_Pad.jpg', array('width'=>'258px','height'=>'42px'));?></td></tr>
            <tr><td align="left" style="font-size:14px;"><strong>117/N/33, A-One Market, Kakadeo</strong></td></tr>
            <tr><td align="left" style="font-size:14px;"><strong>Kanpur - 208 025 Tel:</strong>(0512)2501444,2501555,</td></tr>
            <tr><td align="left" style="font-size:14px;">Mob: +91-9936333772, 9935772727</td></tr>
            <tr><td align="left" style="font-size:14px;">Website : globushospital.com, vanityindia.com</td></tr>
           </table>
      <!--     </td>
          <td width="5%"><?php
//             echo $this->Html->image($this->Session->read('header_image'),array('alt'=>$this->Session->read('facility'),'title'=>$this->Session->read('facility')))
//             //echo $this->Html->image('icons/logo.jpg',array('alt'=>__('UIDPatient Lookup'),'title'=>__('UIDPatient Lookup')));
           
//           ?>
          </td> -->
          <td width="14%">
          <table border="0" width="100%" cellspacing="0" cellpadding="0" >
            <tr><td align="right" style="font-size:22px;"><strong><?php echo "Dr. R. K. Singh";?></strong></td></tr> 
            <tr><td align="right" style="font-size:14px;"><strong>JOINT REPLACEMENT & SPINE SURGEON</strong></td></tr>
            <tr><td align="right" style="font-size:13px;">M.Ch.(Orth), M.S.(Orth), D.(Orth), M.A.M.S., M.B.B.S.</td></tr>
            <tr><td align="right" style="font-size:13px;">Fellow A.O. International (Switzerland),Fellow IGOF (Germany)</td></tr>
            <tr><td align="right" style="font-size:14px;">EMail : drrksinghindia@live.in,helpline@globushospital.com</td></tr>
          </table>
        </td>
          </tr>

</table>
	
<table width="100%"  cellspacing="1" cellpadding="0" class="" id="" border="0" style="margin-top:10px;padding-top:20px;">
   <tr>
       <td align="center" colspan="3" width="50%">
          <table border="0" width="100%"><tr>
				<td width="20%" style="font-size: 14px !important;">PATIENT NAME :<strong><?php echo strtoupper($getBasicData['Patient']['lookup_name']);?></strong></td>
				<td width="20%" style="font-size: 14px !important;">AGE / GENDER :<strong><?php echo strtoupper($this->General->getCurrentAge($getPersonBasicData['Person']['dob']))."/".strtoupper($getBasicData['Patient']['sex']);  //strtoupper($getBasicData['Patient']['age'])
							?></strong></td>
				<td width="10%" style="font-size: 14px !important;">WEIGHT :<strong><?php echo $getBasicData['Patient']['patient_weight']." KG";?></strong></td>
							
				<td width="10%" style="font-size: 14px !important;">DATE :<strong><?php echo date('m/d/Y');?></strong></td></tr>
		  </table></td>
  </tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
	<tr>
	<td width="30%" valign="top" colspan="2" style="padding-right:20px;text-align:justify">
	<table width="100%">
	<tr><td style="font-size: 14px !important;"><?php $getUpperCaseLabRadChiefCom=str_replace("\n","<p>",$getNoteData['Note']['small_text']);
	echo strtoupper($getcomplaintsData['Diagnosis']['complaints'])."</br>"."</br>".strtoupper($getUpperCaseLabRadChiefCom);?></td></tr>
	</table>
	</td>
	<td width="70%" valign="top">
			<table width="100%" height="100%" style="border-left:1px dotted #000;text-align:justify">
				
				<tr><td colspan="3"><?php //echo $getNoteData['Note']['template_full_text']?></td></tr>
			</table>
	</td>
		
	</tr>
</table><?php //debug( $getNoteData);?>
<table border="0" width="800" height="550" cellspacing="0" cellpadding="0" ><tr><td height="20%">&nbsp;</td></tr></table>
<table border="0" width="800" cellspacing="0" cellpadding="0" >

 <tr>
         <td width="20%">
           <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr><td align="left" style="font-size:14px;"><u>Consultation Chamber & Timing: (From 1:30pm to 6:00pm)</u></td></tr>
            <tr><td align="left" ><?php echo $this->Html->image('icons/globus_opd.png', array('width'=>'210px','height'=>'48px'));?></td></tr>
            <tr><td align="left" style="font-size:14px;"><strong>117/N/59, A-One Market, Kakadeo</strong></td></tr>
            <tr><td align="left" style="font-size:14px;"><strong>Kanpur - 208 025 Mob.:</strong> +91-9793009988, 9198502255</td><td align="right"><strong>(Saturday Closed)</strong></td></tr>
            <tr><td align="left" style="font-size:14px;"><u>For Appointment Please Dial 0512-2500888,2503355,2500005,9235414333 From (9AM to 10AM)</u></td></tr>
            <tr><td align="center" ><?php echo $this->Html->image('icons/Prescription_Pad_hindi.jpg', array('width'=>'520px','height'=>'20px'));?></td></tr>
           </table>
          </td>

  
 </tr>

</table>
</body>

