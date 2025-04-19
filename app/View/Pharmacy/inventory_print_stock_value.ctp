<?php
        if(isset($result)){
            header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
            header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header ("Cache-Control: no-cache, must-revalidate");
            header ("Pragma: no-cache");
            header ("Content-type: application/vnd.ms-excel");
            header ("Content-Disposition: attachment; filename=\"pharmacy_value.xls" );
            header ("Content-Description: Generated Report" );

        }
?>
<style>
    .tabularForm{
        border:1px solid;
    }

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
</style>
<?php
if(!isset($result)){
?>
<div style="float:right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
<?php
    }
    ?>
<div class="clr ht5"></div>
  <div class="clr ht5"></div>
  <?php
        if(isset($result)){
    ?>
                   <table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm" id="item-row">
                  	<tr>
               	  	  	  <th width="20" align="center" valign="top"  style="text-align:center;">Sr. No.</th>
                          <th width="120" align="center" valign="top"  style="text-align:center;">Product Name</th>
                          <th width="112" align="center" valign="top"  style="text-align:center;">Product Code</th>
                          <th width="80" align="center" valign="top"  style="text-align:center;">Manufacturer</th>
                          <th width="20" align="center" valign="top"  style="text-align:center;">Pack</th>
                          <th width="60" valign="top" style="text-align:center;">Outward (Unit)</th>
                          <th width="62" valign="top" style="text-align:center;">Current Stock (Unit)</th>

                          <th width="60" valign="top" style="text-align:center;">Value (<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</th>

            <?php
                $cnt = 1;
                $total = 0.00;
                $stock=0;
                $outward=0;
                foreach($result as $key=>$value){
                    $total  = $total+$value['value'];
                    $stock=$stock+$value['current_stock'];
                    $outward=$outward+$value['outward'];
            ?>
                     	</tr>

                        <tr id="row1">
                          <td align="center" valign="middle" class="sr_number" width="20"><?php echo $cnt; ?></td>
                          <td align="center" valign="middle" width="200"> <?php echo $value['name']; ?></td>
                           <td align="center" valign="middle"> <?php echo $value['code']; ?></td>
                          <td align="center" valign="middle" id="manufacturer1" style="text-align:center;"><?php echo $value['manufacturer']; ?></td>
                          <td align="center" valign="middle" id="pack1" style="text-align:center;"><?php echo $value['pack']; ?></td>

                          <td width="60" id="outward1" align="center"> <?php echo $value['outward']; ?></td>

                          <td width="60" id="currentstock1" align="center"><?php echo $value['current_stock']; ?> </td>

                          <td width="60" id="value1" align="right"><?php echo ($value['value']); ?> </td>

                          </tr>
            <?php
                $cnt++;
                }
            ?>

</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>

 <table width="100%" cellpadding="0" cellspacing="1" border="0">
   	<tr>

                          <td ><strong>Outward:&nbsp;<?php echo $outward;?> </strong>&nbsp; units</td>
                            <td ><strong> Total Stock:&nbsp; <?php echo $stock; ?></strong>&nbsp; units</td>
                            <td > <strong>Value &nbsp;<?php echo number_format($total,2); ?> </strong></td>
  </tr>
  </table>

<?php
        }else if(isset($summary)){
    ?>
            <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
                  	<tr>

                          <th width="120" align="center" valign="top"  style="text-align:center;">Total stock in Pharmacy  (Unit)</th>
                          <th width="112" align="center" valign="top"  style="text-align:center;">Outward (Unit)</th>
                          <th width="112" align="center" valign="top"  style="text-align:center;">Value(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</th>


                     	</tr>
                    <tr>
                        <td align="center" ><?php echo $stock; ?></td>
                        <td align="center" ><?php echo $outward; ?></td>
                        <td align="center" ><?php echo number_format($value,2); ?></td>
                    </tr>
</table>

<?php
      }
    ?>


