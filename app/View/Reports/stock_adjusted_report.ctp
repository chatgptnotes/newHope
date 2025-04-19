
<style> 
	.tabularForm {
	    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
	    background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 5px 10px;
	}
        
        .tabularForm td {
            border: 1px black;
         }
</style>
<div class="inner_title">
<h3>&nbsp; <?php echo __("Stock Adjusted Reports", true); ?></h3>
<span><?php 
   echo $this->Html->link(__('Generate Excel Report'),array('controller'=>'reports','action' => 'stockAdjustedReport','generate_excel','admin'=>false), array('escape' => false,'class'=>'blueBtn'));
   echo $this->Html->link(__('Back to Report'), array('controller'=>'pharmacy','action' => 'pharmacy_report','purchase','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
               ?></span>
</div>
<br/> 
<?php echo $this->Form->create('',array('type'=>'get')); ?> 
<table align="left"> 
    <tr>
	 <td align="right">From : </td>
	 <td align="left"><?php
		echo $this->Form->input('from', array('id' => 'from','class'=>'textBoxExpnd','value'=>$this->params->query['from'], 'label'=> false, 'div' => false));  
	 ?></td>
         <td align="right">To : </td>
	 <td align="left"><?php
		echo $this->Form->input('to', array('id' => 'to','class'=>'textBoxExpnd','value'=>$this->params->query['to'], 'label'=> false, 'div' => false));  
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
<table width="" border="0" cellspacing="" cellpadding="5" class="tabularForm" align="">
    <thead>
        <tr>
            <th width="" style="text-align:center"><b>Sr. No.</b></th>
            <th width="" style="text-align:left"><b>Product Name</b></th>
            <th width="" style="text-align:left"><b>Batch No</b></th>
            <th width="" style="text-align:right"><b>Adjusted Add</b></th>
            <th width="" style="text-align:right"><b>Adjusted Minus</b></th>
            <th width="" style="text-align:right"><b>Adjusted Date</b></th>
            <th width="" style="text-align:right"><b>Adjusted By</b></th>  
        </tr>  
    </thead>
    <tbody>
    <?php if(!empty($stockData)){ $cnt = 1; $totalPurchase = 0; $totalPackage = 0;  foreach($stockData as $key => $val): 
    ?>
        <tr>
            <td align="center"><?php echo $cnt++ ; ?></td> 
            <td width="" align="left"><?php echo $val['Product']['name']; ?></td>
            <td width="" align="right"><?php echo $val['StockAdjustment']['batch_number']; ?></td> 
            <td width="" align="center"><?php echo !empty($val['StockAdjustment']['sur_plus'])?$val['StockAdjustment']['sur_plus']:'-'; ?></td> 
            <td width="" align="center"><?php echo !empty($val['StockAdjustment']['sur_minus'])?$val['StockAdjustment']['sur_minus']:'-'; ?></td> 
            <td width="" align="right"><?php echo $val['StockAdjustment']['created']; ?></td> 
            <td width=""><?php echo $val[0]['name']; ?></td> 
        </tr>
   <?php endforeach; ?>
            
   <?php }else{?>
        <tr>
            <td colspan="7" style="text-align:center"><b>No Record Found..!!</b></td>
        </tr>
        <?php } ?>
    </tbody>
</table> 

<script>
$(function() {
    $("#to").datepicker({
        showOn: "button",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat: '<?php echo $this->General->GeneralDate();?>',
         				
    });	

    $("#from").datepicker({
        showOn: "button",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat: '<?php echo $this->General->GeneralDate();?>' 
    });
});
</script>
