<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<?php echo $this->Html->css('internal_style')?>
<title>		
		<?php echo $title_for_layout; ?>
	</title>	 
<style>
	.boxBorder{border:1px solid #3E474A;}
	.boxBorderBot{border-bottom:1px solid #3E474A;}
	.boxBorderRight{border-right:1px solid #3E474A;}
	.tdBorderRtBt{border-right:1px solid #3E474A; border-bottom:1px solid #3E474A;}
	.tdBorderBt{border-bottom:1px solid #3E474A;}
	.tdBorderTp{border-top:1px solid #3E474A;}
	.tdBorderRt{border-right:1px solid #3E474A;}
	.tdBorderTpBt{border-bottom:1px solid #3E474A; border-top:1px solid #3E474A;}
	.tdBorderTpRt{border-top:1px solid #3E474A; border-right:1px solid #3E474A;}
	.columnPad{padding:5px;}
	.columnLeftPad{padding-left:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.totalPrice{font-size:14px;}
</style> 
</head>
<body> 
<h3><?php echo $title;?></h3>
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="formFull">
	<tr>
		<th colspan="3" style="text-transform:uppercase;"><?php echo __('Patient\'s Information') ?></th>
	</tr>
	<tr>
		<td width="49%" align="left" valign="top" style="padding-top:7px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				<tr>
					<td width="100" height="25" valign="top" class="tdLabel1" id="boxSpace1" align="right"><b><?php echo __('Name') ?> : &nbsp;</b></td>
					<td align="left" valign="top">
					<?php echo ucfirst($patient['Patient']['lookup_name']);
					?>
					</td>
				</tr>
				<tr>
					<td valign="top" class="tdLabel1" id="boxSpace1" align="right"><b><?php echo __('Address') ?> : </b>&nbsp;</td>
					<td align="left" valign="top" style="padding-bottom:10px;">
					<?php echo $formatted_address ; ?>
					</td>
				</tr>
			</table>
		</td>
		<td width="" align="left" valign="top">&nbsp;</td>
		<td width="49%" align="left" valign="top" style="padding-top:7px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
				<tr>
					<td width="140" height="25" valign="top" class="tdLabel1" id="boxSpace1" align="right"><b><?php echo __('MRN') ?> : &nbsp;</b></td>
					<td align="left" valign="top"><?php echo $patient['Patient']['admission_id'];?></td>
				</tr>
				<tr>
					<td width="140" height="25" valign="top" class="tdLabel1" id="boxSpace1" align="right"><b><?php echo __('Patient ID') ?> : </b>&nbsp;</td>
					<td align="left" valign="top">
					<?php echo $patient_uid ; ?>
					</td>
				</tr>
				<tr>
					<td height="25" valign="top" class="tdLabel1" id="boxSpace1" align="right"><b><?php echo __('Sex') ?> : </b>&nbsp;</td>
					<td align="left" valign="top"><?php
						echo ucfirst($patient['Patient']['sex']);?></td>
				</tr>
				<tr>
					<td height="25" valign="top" class="tdLabel1" id="boxSpace1" align="right"><b><?php echo __('Age') ?> : </b>&nbsp;</td>
					<td align="left" valign="top"><?php	echo $patient['Patient']['age'];?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $content_for_layout ?>

</body>
</html>
