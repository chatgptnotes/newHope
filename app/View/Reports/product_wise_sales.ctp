<div class="inner_title">
<h3>&nbsp; <?php echo __("Pharmacy Patient's Sales Report", true); ?></h3>
<span><?php
   echo $this->Html->link(__('Back to Report'), array('controller'=>'pharmacy','action' => 'pharmacy_report','purchase','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
   ?></span>
</div>
<br/>
<?php echo $this->Form->create('',array('type'=>'get')); ?> 
<table align="left"> 
    <tr>
	 <td align="right">Search Patient : </td>
	 <td align="left"><?php
		echo $this->Form->input('PharmacySale.lookup_name', array('id' => 'lookup_name','class'=>'textBoxExpnd','value'=>$this->params->query['lookup_name'], 'label'=> false, 'div' => false));
                echo $this->Form->hidden('PharmacySale.patient_id',array('id'=>'person_id','value'=>$this->params->query['patient_id']));  
	 ?></td>
         <td>
            <input type="submit" value="Get Report" class="blueBtn" id="submit" onclick = "return getValidate();">
            &nbsp;&nbsp;
             <a  class="grayBtn" href="javascript:history.back();">Cancel</a>            
              </td>
        <td><?php echo $this->Form->input('Generate Excel Report',array('class'=>'blueBtn','name'=>'generate_excel','type'=>'submit','value'=>'Generate Excel','div'=>false,'label'=>false)); 
               ?></td>
    </tr>
</table>  
<?php echo $this->Form->end(); ?>
<div class="clr ht5"></div>
<table width="80%" border="0" cellspacing="0" cellpadding="0" class="formFull" align="center">
    <thead>
        <tr>
            <th width="10%" style="text-align:center"><b>Sr. No.</b></th>
            <th width="30%" style="text-align:left"><b>Product</b></th>
            <th width="20%" style="text-align:center"><b>Quantity</b></th>
            <th width="15%" style="text-align:right"><b>Purchase Amount</b></th>
            <th width="15%" style="text-align:right"><b>Sale Amount</b></th>
            <th width="10%"></th>
        </tr>  
    </thead>
    <tbody>
    <?php if(!empty($salesData)){ $cnt = 1; $totalPurchase = 0; $totalSale = 0;  foreach($salesData as $key => $val): 
    ?>
        <tr>
            <td align="center"><?php echo $cnt++ ; ?></td>
            <td width="30%"><?php echo $val['name']; ?></td>
            <td width="20%" align="center"><?php echo $val['qty']; ?></td>
            <td width="15%" align="right"><?php $totalPurchase += $val['purchase_price']; echo number_format($val['purchase_price'],2); ?></td>
            <td width="15%" align="right"><?php $totalSale += $val['sale_price']; echo number_format($val['sale_price'],2); ?></td> 
            <td width="10%"></td>
        </tr>
   <?php endforeach; ?>
        <tr>
            <td colspan="3" align="right"><?php echo "Total:"; ?></td>
            <td align="right"><?php echo $this->Number->currency($totalPurchase); ?></td>
            <td align="right"><?php echo $this->Number->currency($totalSale); ?></td>
            <td></td>
        </tr>
   <?php }else{?>
        <tr>
            <td colspan="5" style="text-align:center"><b>No Record Found..!!</b></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    //by swapnil
    $("#lookup_name").autocomplete({
        source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name",'null','1',"inventory" => true,"plugin"=>false)); ?>",
         minLength: 1, 
         select: function( event, ui ) {
            var person_id = ui.item.id;
            $("#person_id").val(person_id); 
        },
        messages: {
            noResults: '',
            results: function() {}
        }	
    });
</script>