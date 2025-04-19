<?php App::import('Vendor', 'html_to_doc'); ?>
<?php $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
               <html xmlns="http://www.w3.org/1999/xhtml">
               <head>
               <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
               <title>'.ucfirst($this->Session->read('facility')).'</title>
	       <style type="text/css">
		@media print {
			body {
				background-color: #FFFFFF;
				background-image: none;
				color: #000000
			}
			#ad {
				display: none;
			}
			#leftbar {
				display: none;
			}
			#contentarea {
				width: 100%;
			}
		} 
		@page {
		  margin: 3cm;
		}
		
		</style>
               </head>
               <body style="background: #fff; color: #000; width: 800px; margin: auto;">
               <div class="Section1">
                <table width="100%">
	         <tr>
		  <td valign="top">
		  <table cellspacing="0" cellpadding="0" width="800" border="0">'; 
                
                  for($i=1; $i<=9;$i++){ 
                    $html .= '<tr>';
                  for($j=1; $j<=4; $j++){
                  	if($i>4) $height = "110px;";
                  	else $height ="110px;";
                    $html .= '<td style="width: 200px; height:'.$height.'" valign="center">
				<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="text-align:center;">';
                    $complete_name  = $patient[0]["lookup_name"] ;
                    $html .= '<tr>
                               <td valign="top" align="">'.$complete_name.'</td>
			      </tr>
			      <tr>
				 <td valign="top" align="">'.$patient["Patient"]["admission_id"].'</td>
			      </tr>
			      <tr>
				 <td valign="top" align="">Age/Sex : '.$patient["Patient"]["age"].' Y/'.ucfirst(substr($patient["Patient"]["sex"],0,1)).'</td>
			      </tr>
			      <tr>
				 <td valign="top" align="">'.$facilityDetails["Facility"]["name"].'</td>
			      </tr>
			     </table>
			    </td>';
                          }
                         $html .= '</tr>';
                         }
                         $html .='</table>
		                  </td>
		                  </tr>
                                  </table>
                                  </div></body>
</html>'; 
                     
$htmltodoc= new HTML_TO_DOC();
$htmltodoc->createDocFromHtml($html,$patient["Patient"]["lookup_name"]."_".$patient["Patient"]["admission_id"], true);
?>
