<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>   </title>
	<?php echo $this->Html->css('internal_style.css');?> 
	 
	<style>
	body{
		padding:0; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;
		width:800px;margin:auto;margin-top:90px;
		}
	.heading{font-weight:bold; padding-bottom:10px; font-size:19px; text-decoration:underline;}
	.headBorder{border:1px solid #ccc; padding:3px 0 15px 3px;}
	.title{font-size:14px;  font-weight:bold; padding-bottom:10px;color:#000;}
	input, textarea{border:1px solid #999999; padding:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.tbl .totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	.title ul{
		color: #000000;
		font-size: 13px;
		font-weight: normal;
		padding-bottom: 10px;
		text-decoration: none;
	}
	 .tabularForm td td{
		padding:0px;
		font-size:13px;
		/*color:#e7eeef;*/
		background:#1b1b1b;
	}
	.tabularForm th td{
		padding:0px;
		font-size:13px;
		/*color:#e7eeef;*/
		background:none;
	}
	.death-textarea{
		width:400px;
	}
	.tabularForm td, .tableBorder td {
    background: #ffffff;
    color: #333333;
    font-size: 13px;
    padding: 5px 8px;
	}
	.tableBorder{
		border:1px solid #333333;
		border-bottom:0px;
		border-left:0px;
	}
	.tableBorder .column{
		border:1px solid #333333;
		border-top:0px;
		border-right:0px;	
		padding: 5px 8px;
	}
	.tableBorder .columnLast{
		border-left:1px solid #333333;
		border-bottom:1px solid #333333;	
		padding: 5px 8px;
	}

	.tabularForm td td.hrLine{background:url(../img/line-dot.gif) repeat-x center;}
	.tabularForm td td.vertLine{background:url(../img/line-dot.gif) repeat-y 0 0;}
	#printButton{
		float:right;
		padding-top: 10px;
	    position: fixed;
	    right: 0;
	    top: 0;
	}
	@media print {

  		#printButton{display:none;}
		.page-break{page-break-after:always;}
		.tbl {
			background: none repeat scroll 0 0 #CCCCCC;
		}
   }
  .page-break{page-break-after:always;}
</style>
</head>
<body style="background:none;padding:10px;"  >
	 
	<?php echo $content_for_layout; ?>
	<?php echo $this->element('report_footer');?>   
</body>
</html>
