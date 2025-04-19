<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php ucfirst($this->Session->read('facility')) ?>
		
</title>
			<?php echo $this->Html->css(array('internal_style.css')); ?>
 </head>
               <body style="background: #fff; color: #000; width: 800px; margin: auto;" onload="window.print();">

               
               <div class="Section1">
                <table width="100%">
	         <tr>
		  <td valign="top">
		  <table cellspacing="0" cellpadding="0" width="800" border="0">

<?php   for($i=1; $i<=10;$i++){ ?>
                   <tr>
                 <?php  for($j=1; $j<=3; $j++){
                  	if($i>3) $height = "110px;";
                  	else $height ="110px;"?>
                 <td style="width: 100px;padding:5px; "  <?php $height?> valign="center">
				<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="text-align:right;">
				
 
<?php $complete_name  = $patient[0]["lookup_name"] ;?>
                  <tr>
                               <td valign="top" align=""><?php echo $complete_name ?></td>
			      </tr>
			      <tr>
				 <td valign="top" align=""><?php echo $patient["Patient"]["admission_id"]?></td>
			      </tr>
			      <tr>
				 <td valign="top" align="">Age/Sex :<?php echo $patient["Patient"]["age"]?> Y/<?php echo ucfirst(substr($patient["Patient"]["sex"],0,1)) ?></td>
			      </tr>
			      <tr><td>&nbsp;</td></tr>
			      <tr style="float: right;
    margin-top: -68px; margin-right: 116px;">
				 <td valign="top" align="" >
                     <?php  if(file_exists(WWW_ROOT."uploads/qrcodes/".$patient['Patient']['admission_id'].".png")){ ?> 
    						<?php echo $this->Html->image("/uploads/qrcodes/".$patient['Patient']['admission_id'].".png", 
    						array('alt' => $complete_name,'title'=>$complete_name, 'width'=> '80', 'height' => '80')); 
			 	    } ?></td>
			 	  </tr><tr><td></td></tr>
			      </table>
			   </td>
                           <?php }?>
                         </tr>
                         <?php  }?>
                        </table>
		                  </td>
		                  </tr>
                                  </table>
                                  </div></body>
</html>
                     
