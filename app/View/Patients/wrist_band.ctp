<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
</title>
			<?php echo $this->Html->css(array('internal_style.css')); ?>
</head>
<body style="background:#fff;color:#000" onload="window.print();">
<table width="1000" border="0" cellspacing="0" cellpadding="0" style="text-align:center;margin:auto;vertical-align:center;">
  <tr>
    <td width="1000" valign="top" align="left">
    	<table width="1000" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td width="50" class="redStrip">&nbsp;</td>
                <td width="15" class="redClr">&nbsp;</td>
                <td width="10"> 
					<?php 
						$complete_name  = $patient[0]['lookup_name'] ;
						if(file_exists(WWW_ROOT."uploads/qrcodes/".$patient['Patient']['admission_id'].".png")){  
    				  			echo $this->Html->image("/uploads/qrcodes/".$patient['Patient']['admission_id'].".png", 
    				  				 array('alt' => $complete_name,'title'=>$complete_name,'height'=>'100px','weight'=>'100'));     					 
 					  	  }
 					?>
			 	</td>
                <td width="15" class="redClr">&nbsp;</td>
                <td width="20">&nbsp;</td>
                <td width="230" align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="30" align="left" valign="middle">NAME</td>
                    <td height="30" align="left" valign="middle">
							<?php
								echo $complete_name ; 
							?>
					</td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle"><?php echo __('AGE/SEX') ;?></td>
                    <td height="30" align="left" valign="middle">
                    	<?php
                               	echo $patient['Patient']['age'];
                     	?> yrs <?php echo ucfirst($patient['Patient']['sex']) ;?></td>
                  </tr>
                  <tr>
                    <td height="30" align="left" valign="middle">DR.</td>
                    <td height="30" align="left" valign="middle"><?php echo $doctor; ?></td>
                  </tr>
                </table></td>
                <td width="58">&nbsp;</td>
              <td width="130">REG. ID:<?php echo $patient['Patient']['admission_id'] ;?></td>
              <td width="15" class="redClr">&nbsp;</td>
              <td width="293" class="redStrip">&nbsp;</td>
              <td width="15" class="redClr">&nbsp;</td>
          </tr>
        </table>
    </td>
  </tr>
  
</table>
</body>
</html>
