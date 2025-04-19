<?php 
$website= $this->Session->read('website.instance');
if($website=='kanpur')
{
	$paddingTop="50px";

}
else
{
	$paddingTop="20px";

}?>
<style>
	 #printButton{ position:relative!important;}
	</style>
   <div style="float:right;" id="printButton">
		<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
	</div>
	  
	
<table width="100%"  cellspacing="1" cellpadding="0" class="" id="" border="0" style="margin-top:10px;padding-top:<?php echo $paddingTop;?>;">
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


