<?php
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');

?>
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
    <h3> &nbsp; <?php echo __('Specialty Management -Stock Value', true); ?></h3>

              <div align="right">

							   <?php
   echo $this->Html->link(__('Back'), array('action' => 'outward_list'), array('escape' => false,'class'=>'blueBtn'));
   ?>

                  </div>
</div>
<input type="hidden" value="1" id="no_of_fields"/>
 <?php echo $this->Form->create('InventoryOutward');?>
  <div class="clr ht5"></div>
<div class="clr ht5"></div>
                  	<div>
                     Date<font color="red">*</font>:&nbsp;<input type="text" id="date" name="date" class="validate[required]" value="<?php if(isset($date)){echo $date;}?>" >&nbsp;&nbsp;
                    <input type="radio" name="type" value="summary" <?php if(!isset($result)){ echo " checked='checked'";}?> class='report_type'/> Summary &nbsp;&nbsp;<input type="radio" name="type" value="detailed" <?php if(isset($result)){ echo " checked='checked'";}?> class='report_type'/> Detailed
                     <input type="submit" value="Get Report" class="blueBtn" name="generate_report">
                      <input name="print_report" type="submit" value="Print Report" class="blueBtn" tabindex="37" id="print" />
	               </div>

<?php echo $this->Form->end();?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
  <div class="clr ht5"></div>
  <?php
        if(isset($result)){
    ?>
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
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

                          <td width="60" id="value1" align="right"><?php echo number_format($value['value'],2); ?> </td>

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

                          <td ><strong>Outward:&nbsp;<?php echo $outward;?></strong>&nbsp; units</td>
                            <td ><strong> Total Stock:&nbsp; <?php echo $stock; ?> </strong>&nbsp; units</td>
                            <td ><strong> Value &nbsp;<?php echo number_format($total,2); ?></strong> </td>
  </tr>
  </table>

<?php
        }else if(isset($summary)){
    ?>
            <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
                  	<tr>

                          <th width="120" align="center" valign="top"  style="text-align:center;">Total stock in Specilty (Unit)</th>
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
<div class="clr ht5"></div>



 <script>

$( "#date" ).datepicker({
			showOn: "button",
			buttonImage: "/img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: false,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',


		}).focus(function() {
        $("#date").datepicker("show");
    })

	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#InventoryOutwardInventoryStockValueForm").validationEngine();
	});
(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"Required.",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required"
                },

				 "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Invalid format"
                },

            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);
$(".report_type").click(function(){
    if($(this).val() == "detailed"){
        $("#print").hide();
    }else{
        $("#print").show();
    }

})
 </script>