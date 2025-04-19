<style>

.lableFont{font-size: 12px; }

</style>

<?php
 	if($section == "InventoryPurchaseReturn"){
 ?>
  <tr>
    <td width="100%">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="prescribeDetail" >
        	<tr>
            	<td width="40%" valign="top" style="border-right:1px solid #333333; padding:2px 5px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      
                      <tr>
                        <td class="lableFont">Party Code:</td>
                        <td>:</td>
                          <td class="lableFont"><?php  if(isset($data['InventorySupplier']['code'])){echo $data['InventorySupplier']['code'];}else{ echo $supplier['code']; }?></td>
                      </tr>
					     <tr>
                        <td class="lableFont">Date and Time:</td>
                        <td>:</td>
                          <td class="lableFont"><?php echo $this->DateFormat->formatDate2Local($data['InventoryPurchaseReturn']['create_time'],Configure::read('date_format')); ?></td>
                      </tr>
                    </table>
                </td>
                <td valign="top" style="padding:2px 5px 2px 10px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="120" class="lableFont">Party Name</td>
                        <td width="10" >:</td>
						  <td class="lableFont"><?php  if(isset($data['InventorySupplier']['name'])){echo $data['InventorySupplier']['name'];}else{ echo $supplier['name']; }?></td>
                        
                      </tr>
                     
                    
                    </table>
               </td>
            </tr>
        </table>
    </td>
  </tr>
 <?php
} else{
 
 ?>
 <tr>
    <td width="100%">
    	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="prescribeDetail" >
        	<tr>
            	<td width="60%" valign="top" style="border-right:1px solid #333333; padding:2px 5px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="120" class="lableFont">Vr. No.</td>
                        <td width="10">:</td>
                        <td class="lableFont"><?php echo $data['InventoryPurchaseDetail']['vr_no'];?></td>
                      </tr>
                      <tr>
                        <td class="lableFont">Vr. Dt.</td>
                        <td>:</td>
                           <td class="lableFont"><?php echo $this->DateFormat->formatDate2Local($data['InventoryPurchaseDetail']['vr_date'],Configure::read('date_format')); ?></td>
                      </tr>
                      <tr>
                        <td class="lableFont">Party Code</td>
                        <td>:</td>
                          <td class="lableFont"><?php  if(isset($data['InventorySupplier']['code'])){echo $data['InventorySupplier']['code'];}else{ echo $supplier['code']; }?></td>
                      </tr>
                    </table>
                </td>
                <td valign="top" style="padding:2px 5px 2px 10px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="120" class="lableFont">Party Name</td>
                        <td width="10">:</td>
						  <td class="lableFont"><?php  if(isset($data['InventorySupplier']['name'])){echo $data['InventorySupplier']['name'];}else{ echo $supplier['name']; }?></td>
                        
                      </tr>
                      <tr>
                        <td class="lableFont">Bill No.</td>
                        <td>:</td>
                          <td class="lableFont"><?php echo $data['InventoryPurchaseDetail']['bill_no'];?></td>
                      </tr>
                      <tr>
                        <td class="lableFont">Memo</td>
                        <td>:</td>
                       <td class="lableFont"><?php echo ucwords($data['InventoryPurchaseDetail']['payment_mode']);?></td>
                      </tr>
                    </table>
               </td>
            </tr>
        </table>
    </td>
  </tr>
  <?php
  
  }?>