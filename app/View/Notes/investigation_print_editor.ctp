<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<?php echo $this->Html->css(array('internal_style.css')); ?>
<?php echo $this->Html->script('jquery-1.5.1.min.js'); 

$website=$this->Session->read("website.instance");
if($website=='kanpur')
{
	$marginTop="140px";

}
else
{
	$marginTop="14px";
	
}
?>
<title>
		<?php //echo __('Bill Receipt', true); ?>
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
 </style>
</head>
<body style="background:none;width:98%;margin:auto;">
<style>

	 #printButton{ position:relative!important;}
	</style>
   <div style="float:right;" id="printButton">
		<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
	</div>
	  
	
<table width="100%"  cellspacing="1" cellpadding="0" class="" id="" border="0" style="margin-top:<?php echo $marginTop;?>;">

<tr><td>&nbsp;</td></tr>
	<tr>
	<td width="14%" valign="top" colspan="2" style="padding-right:20px;text-align:justify">
	<table width="100%">
	<tr><td><?php //echo $getcomplaintsData['Diagnosis']['complaints']."</br>"."</br>".str_replace("\n","<p>",$getNoteData['Note']['small_text']);?></td></tr>
	</table>
	</td>
	<td width="70%" valign="top">
			<table width="100%" style="border-left:1px dotted #000;text-align:justify; font-size: 16px !important;">
				
				<tr><td colspan="3" style="font-size: 16px !important;padding-top: 40px;"><?php echo $templateSmallTextArray['0'];?>
			</td>
			</tr>
			<tr>
			<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="0"
							 style="padding: 0px !important;margin-top: 10px;">
					<tr><td colspan="3" style="font-size: 16px !important;"><strong>Rx</strong></td>
			
				<?php 
				foreach ($getMedNameFinalArr as $key=>$data){?>
					<tr valign="top"><td  style="padding: 2px 0px 5px;font-size: 14px !important;">
			<?php if(empty($getDaysArr[$key]['0'])){
					continue;
				}
				echo $data['0']." - ".$getDaysArr[$key]['0'];?>
			<?php }?>
			</td></tr>
			</table>
			</td></tr>
			<tr><td colspan="3" style="font-size: 16px !important;">
				
				<?php 
				foreach ($dataPhysioArr as $key=>$data){?>
				<?php echo $data;?>
			<?php }?>
			
			</td>
			</tr>
			</table>
	</td>
		
	</tr>
</table><?php //debug( $getNoteData);?>
<table width="100%" align="right" cellspacing="1" cellpadding="0" class="" id="" border="0" >
<tr>
	<td align="" width="60%" style="padding-left:553px;" > Signature:</td>
</tr>
<tr>
<td align="right" width="60%"> <?php echo  $this->Html->image('/signpad/'.$getSign['User']['sign'],array('style'=>"float:right;"));?></td>
</tr>

</table>

</body>