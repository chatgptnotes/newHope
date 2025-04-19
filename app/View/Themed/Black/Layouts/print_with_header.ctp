<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>   </title>
	<?php echo $this->Html->css('internal_style.css');?> 
	 
	<style>
	body{
		margin:10px 0 0 0;padding:0; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000;
		width:800px;margin:auto;
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
   
   .inner_title h3 {
    	color: #000000;
   }
   .img1 {
    border: 0 none;
    cursor: pointer;
    float: right;
}

  .page-break{page-break-after:always;}
</style>
</head>
<?php if($this->Session->read('website.instance') == 'kanpur')
{ ?> 
<body style="background:none;padding:10px;">
    <div style="text-align:center;margin-left:4px;">
         <table border="0" width="100%" cellspacing="0" cellpadding="0" >
            <?php
            if($this->Session->read('locationid') == 22 && $patient['Patient']['admission_type'] == "IPD" )   //&& ($patient['Patient']['treatment_type'] == Configure::read('radiotherapy') || $patient['Patient']['treatment_type'] == Configure::read('radiotherapyOpd')))
				{?>
            <tr><td align="center" colspan="3" style="font-size:22px;"><strong>GLOBUS HOSPITAL</strong></td></tr>
            <tr>
             <td width="20%">
              <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <!-- <tr><td align="left" style="font-size:22px;"><strong><?php echo "Dr. R. K. Singh";?></strong></td></tr> -->
            <tr><td align="left" style="font-size:14px;">For Joint Replacement</td></tr>
            <tr><td align="left" style="font-size:14px;"><strong>(A Unit of Hospital Infotech (P) Ltd.)</strong></td></tr>
            <tr><td align="left" style="font-size:14px;">ISO 9001:2008 Certified</td></tr>
            <tr><td align="left" style="font-size:14px;">CIN No. U85110UP2002PTC026777</td></tr>
            <tr><td align="left" style="font-size:14px;">Web : www.globushospital.com</td></tr>
            <!-- <tr><td align="left" style="font-size:14px;">Spinal Surgery & Advanced Fracture Surgery</td></tr> -->
           
          </table>
          </td>
          <td width="5%"><?php
           echo $this->Html->image($this->Session->read('header_image'),array('alt'=>$this->Session->read('facility'),'title'=>$this->Session->read('facility')))
            //echo $this->Html->image('icons/logo.jpg',array('alt'=>__('UIDPatient Lookup'),'title'=>__('UIDPatient Lookup')));
           
          ?>
          </td>
          <td width="14%">
          <table border="0" width="100%" cellspacing="0" cellpadding="0" >
           
            <!-- <tr><td align="right" style="font-size:14px;">For Joint Replacement <b>(OPD Unit)</b> </td></tr> -->
            <tr><td align="right" style="font-size:14px;">117/N/33, A-One Market, Kakadeo</td></tr>
            <tr><td align="right" style="font-size:14px;">Kanpur, Uttar Pradesh - 208 025</td></tr>
            <tr><td align="right" style="font-size:14px;">0512-2500500, 2501444, 2501555</td></tr>
            <tr><td align="right" style="font-size:14px;">0512-3085105,09936333772</td></tr>
            <tr><td align="right" style="font-size:14px;">EMail : info@globushospital.com</td></tr>
            
          </table>
        </td>
          </tr>
       
            <?php }
            else {?>
              <?php 
              if($this->Session->read('locationid') == 22)// &&  ($patient['Patient']['treatment_type'] == Configure::read('radiotherapy') || $patient['Patient']['treatment_type'] == Configure::read('radiotherapyOpd')))
				 {?>
		<tr><td align="center" colspan="3" style="font-size:22px;"><strong>GLOBUS HOSPITAL</strong></td></tr>
		<tr>
		<td width="20%">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<!-- <tr><td align="left" style="font-size:22px;"><strong><?php echo "Dr. R. K. Singh";?></strong></td></tr> -->
		    <tr><td align="left" style="font-size:14px;">For Joint Replacement</td></tr>
            <tr><td align="left" style="font-size:14px;"><strong>(A Unit of Hospital Infotech (P) Ltd.)</strong></td></tr>
            <tr><td align="left" style="font-size:14px;">ISO 9001:2008 Certified</td></tr>
            <tr><td align="left" style="font-size:14px;">CIN No. U85110UP2002PTC026777</td></tr>
            <tr><td align="left" style="font-size:14px;">Web : www.globushospital.com</td></tr>
            <!-- <tr><td align="left" style="font-size:14px;">Spinal Surgery & Advanced Fracture Surgery</td></tr> -->
           
          </table>
          </td>
          <td width="5%"><?php
            echo $this->Html->image($this->Session->read('header_image'),array('alt'=>$this->Session->read('facility'),'title'=>$this->Session->read('facility')))
            //echo $this->Html->image('icons/logo.jpg',array('alt'=>__('UIDPatient Lookup'),'title'=>__('UIDPatient Lookup')));
           
          ?>
          </td>
          <td width="14%">
          <table border="0" width="100%" cellspacing="0" cellpadding="0" >
           
            <!-- <tr><td align="right" style="font-size:14px;">For Joint Replacement <b>(OPD Unit)</b> </td></tr> -->
            <tr><td align="right" style="font-size:14px;">117/N/33, A-One Market, Kakadeo</td></tr>
            <tr><td align="right" style="font-size:14px;">Kanpur, Uttar Pradesh - 208 025</td></tr>
            <tr><td align="right" style="font-size:14px;">0512-2500500, 2501444, 2501555</td></tr>
            <tr><td align="right" style="font-size:14px;">0512-3085105,09936333772</td></tr>
            <tr><td align="right" style="font-size:14px;">EMail : info@globushospital.com</td></tr>
          </table>
        </td>
          </tr>

<?php } else{?>
            <tr>
          <td width="20%">
          <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr><td align="left" style="font-size:22px;"><strong><?php echo "Dr. R. K. Singh";?></strong></td></tr>
            <tr><td align="left" style="font-size:14px;">Joint Replacement & Spine Surgeon</td></tr>
            <tr><td align="left" style="font-size:13px;">M.Ch.(Ortho), M.S.(Ortho), D.Orth., MAMS, MBBS</td></tr>
            <tr><td align="left" style="font-size:14px;">Fellow IGOF (Germany)</td></tr>
            <tr><td align="left" style="font-size:14px;">Fellow AO International (Switzerland)</td></tr>
            <tr><td align="left" style="font-size:14px;">Specialist : Joint Replacement, Arthroscopy,</td></tr>
            <tr><td align="left" style="font-size:14px;">Spinal Surgery & Advanced Fracture Surgery</td></tr>
           
          </table>
          </td>
          <td width="5%" style="padding-left: 6%"><?php
            echo $this->Html->image($this->Session->read('header_image'),array('alt'=>$this->Session->read('facility'),'title'=>$this->Session->read('facility')))
            //echo $this->Html->image('icons/logo.jpg',array('alt'=>__('UIDPatient Lookup'),'title'=>__('UIDPatient Lookup')));
           
          ?>
          </td>
          <td width="14%">
          <table border="0" width="100%" cellspacing="0" cellpadding="0" >
            <tr><td align="right" style="font-size:22px;" class="img1"><?php echo $this->Html->image('icons/globus_opd.png', array('width'=>'222px','height'=>'50px'));?></td></tr>
            <!-- <tr><td align="right" style="font-size:22px;"><strong>GLOBUS Hospital</strong></td></tr> -->
            <!-- <tr><td align="right" style="font-size:14px;">For Joint Replacement <b>(OPD Unit)</b> </td></tr> -->
            <tr><td align="right" style="font-size:14px;">117/N/59, A-One Market, Kakadeo</td></tr>
            <tr><td align="right" style="font-size:14px;">Kanpur, Uttar Pradesh - 208 025</td></tr>
            <tr><td align="right" style="font-size:14px;">0512-2500888, 2500005, 2503355</td></tr>
            <tr><td align="right" style="font-size:14px;">09235414333, 09793009988</td></tr>
            <tr><td align="right" style="font-size:14px;">eMail : info@globushospital.com</td></tr>
          </table>
        </td>
          </tr>
         <?php }?>
        <?php }?> 
       
    </table>
    </div> 
    <div>&nbsp;</div>
    <!-- <div>&nbsp;</div> -->
    <?php echo $content_for_layout; ?>
    <?php echo $this->element('report_footer'); ?>  
</body>
<?php } else 
{?>

<body style="background:none;padding:10px;"  >
	<div>
		<?php
			//echo $this->Html->image($this->Session->read('header_image'),array('alt'=>$this->Session->read('facility'),'title'=>$this->Session->read('facility'))) 
		?>
	</div>  
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<?php echo $content_for_layout; ?>
	<?php echo $this->element('report_footer');?> 
	<?php }?>  
</body>
</html>
