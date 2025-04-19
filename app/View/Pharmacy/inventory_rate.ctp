<?php 
  if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
  </td>
 </tr>
</table>
<?php } ?>
 <div class="inner_title">
<h3> &nbsp; <?php echo __('Specilty Management - Rate Master', true); ?></h3>
	<span style="margin-top:-25px;">
	
	</span>	
	
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table-format">
  
</table>
  <div class="clr ht5"></div>
                   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                        <td width="100" valign="middle" class="tdLabel" id="boxSpace">Product Code</td>
                        <td width="250"><input type="text" name="item_id" id="item_id" class="textBoxExpnd" tabindex="1"/></td>
                        <td width="">&nbsp;</td>
                        <td width="100" class="tdLabel" id="boxSpace">Product Name</td>
                        <td width="250"><input type="text" name="item_name" id="item_name" class="textBoxExpnd" tabindex="2"/></td>
                     </tr>
                      <tr>
                        <td valign="middle" class="tdLabel" id="boxSpace">MRP</td>
                        <td><input type="text" name="mrp" id="mrp" class="textBoxExpnd" tabindex="3"/></td>
                        <td>&nbsp;</td>
                        <td class="tdLabel"  id="boxSpace">Tax%</td>
                        <td><input type="text" name="tax" id="tax" class="textBoxExpnd"  tabindex="4"/></td>
                      </tr>
                      <tr>
                        <td valign="middle" class="tdLabel" id="boxSpace">Pur. Price.</td>
                        <td><input type="text" name="purchase_rate" id="purchase_rate" class="textBoxExpnd" tabindex="5"/></td>
                        <td>&nbsp;</td>
                        <td class="tdLabel"  id="boxSpace">CST</td>
                        <td><input type="text" name="cst" id="cst" class="textBoxExpnd"  tabindex="6"/></td>
                      </tr>
                  	<tr>
                        <td valign="middle" class="tdLabel" id="boxSpace">Cost Price</td>
                        <td><input type="text" name="cost_price" id="cost_price" class="textBoxExpnd"  tabindex="7"/></td>
                        <td>&nbsp;</td>
                        <td class="tdLabel" id="boxSpace">Sale Price</td>
                    	<td><input type="text" name="sale_price" id="sale_price" class="textBoxExpnd"  tabindex="8"/></td>
                     </tr>
                    </table>
                   
                   <!-- billing activity form end here -->
                   <div class="btns">
                              <input name="" type="button" value="Submit" class="blueBtn" tabindex="9"/>
                  </div>
                   
<p class="ht5"></p>
                    
                   
                    
                    
                   
                    

                    
                    
                    
                    
                    
                    <!-- Right Part Template ends here -->                </td>
            </table>