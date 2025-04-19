<?php 
$monthArray = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June',
                                        '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Total Income - ".$monthArray[$this->request->data['AccountReceipt']['month']]."-".$this->request->data['AccountReceipt']['year'].".xls");
header ("Content-Description: Generated Report" ); 
?>
 
<STYLE type='text/css'>
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
</STYLE>

<table border="1" class="table_format"  cellpadding="2" align="center" cellspacing="0" width="80%" style="text-align:center;">	
  <tr class="row_title">
   <td align="center" colspan="2"><h2><?php echo __('Total Receipts for the month of '.$monthArray[$this->request->data['AccountReceipt']['month']]."-".$this->request->data['AccountReceipt']['year']); ?></h2></td>
  </tr>
  <tr class="row_title">
    <td align="left"><strong><?php echo __('Income Head'); ?></strong></td>
    <td align="right"><strong><?php echo __('Amount'); ?></strong></td>
  </tr>
  <?php foreach($admissionType as $key=> $type) { ?> 
    <tr class="row_title"> 
      <td align="center"><strong><?php echo $type; ?></strong></td>
        <td align="right"><?php echo $result[$type] ? number_format(round($result[$type])) :0;
        $totalCollection +=  (double) round($result[$type]); ?> </td> 
    </tr>  
    <tr>
      <td>
        <table width="80%" align="center" style="padding-left:100px;">
          <tr>
            <td align="left"><i><b>Private</b></i></td>
            <td align="right"><?php echo number_format($headResult[$type]['Private']?$headResult[$type]['Private']:0); unset($headResult[$type]['Private']); ?></td>
          </tr>
          <tr>
            <td align="left"><i><b>Corporate</b></i></td>
            <td align="right"><?php echo number_format(array_sum($headResult[$type])?array_sum($headResult[$type]):0); ?>
            </td>
          </tr>
          <?php if(!empty($headResult[$type])) { ?>
          <tr>
            <td>
              <table width="80%" align="center">
                <?php foreach ($headResult[$type] as $corKey => $corVal) { ?>
                  <tr>
                    <td align="left"><?php echo $corKey; ?></td>
                    <td align="right"><?php echo number_format($corVal?$corVal:0); ?></td>
                  </tr>
                <?php } ?>
              </table>
            </td>
          </tr>
          <?php } ?>
        </table>
      </td>
      <td></td>
    </tr>
  <?php }?>  
       <tr>					
        <td align="left">Total</td>
        <td align="right"><?php echo number_format($totalCollection); ?></td>
       </tr>
</table>
		
