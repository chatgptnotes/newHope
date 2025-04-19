<style>
.main_wrap{ width:55%;float:left;margin:0px;padding:0px; border:1px solid #000; border-radius:5px; min-height:250px;}
.btns{float:left !important;}
.tabularForm{float:left; margin:10px 0 0 20px; width:92%!important;}
.inner_title{width:98%!important;}
.textBoxExpnd{ width:79% !important;}
.a_stock{padding-left:0px !important; width:12%}
.save_btn{float:left;font-size:13px;}
.deficit{float:left;font-size:13px;}
.mandatory{color:#ff0000; font-size:13px;padding: 0 0 0 13px;}
.adjust_stock{width:100%;padding:15px; float:left;}
.report_btn{float:left;padding:15px 0 10px 20px;}
</style>





<div class="">
   <div class="inner_title">
      <h3>Stock Tracking</h3>
	  </div>
   <div class="first_table">
      <table cellspacing="1" border="0" class="tabularForm" colspan="7">
	     <tr>
		   <th>Drug Name</th>
		   <th>Batch No</th>
		   <th>Current Stock</th>
           <th>Physical Stock</th>
		   <th>Remark</th>
           <th>&nbsp;</th>
		   
		 </tr>
		 <tr>
		   <td><?php echo $this->Form->input('', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false)); ?></td>
		   <td></td>
		   <td></td>
           <td><?php echo $this->Form->input('', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false)); ?></td>
		   <td></td>
           <td><a href="#" class="blueBtn">Verify</a></td>
		   
		 </tr>
	  </table>
      <table class="adjust_stock">
        <tr>
			<td width="13%" valign="middle" class="tdLabel" style="padding-left:0px !important;"><?php echo __('Adjust Stock');?></td>
            <td style="font-size:13px;">0</font></td>
			
		</tr>
        <tr>
            <td colspan="3">
			 <div class="btns">
				<div class="save_btn"><input type="radio" /><?php echo __("Surplus");?></div>
                <div class="deficit" ><input type="radio" /><?php echo __("Deficit");?></div>
                <div class="save_btn"><input type="radio" /><?php echo __("Damage");?></div>
			 </div>
			</td>
        </tr>
        <tr>
            <td colspan="2"><a href="#" class="blueBtn">Stock Adjustment</a></td>
            <!-- <td><span class="mandatory">(*)Mark Feild are Mandatory</span></td> -->
        </tr>
      </table>
      
      <table width="100%" style="float:left;">
	      <tr>
			<!-- <td width="23%!important;" valign="middle" class="tdLabel" id=""><?php echo __('From Date');?><font color="red">*</font></td>
			<td width="41%">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td><?php echo $this->Form->input('Itme_Name', array('class' => 'validate[required,custom[name]] ','id' => 'first_name','label'=>false)); ?>
						</td>
					</tr>
				</table>
			</td> -->
			<td width="10%" class="tdLabel" id=""><?php echo __('Search Drug Name')?> </td>
			<td width="10%"><?php echo $this->Form->input('', array('label'=>false,'id' => 'group_name','class'=> '','div'=>false)); ?> </td>
			
			<td width="10%" class="tdLabel" id=""><?php echo __('From Date')?> </td>
			<td width="10%"><?php echo $this->Form->input('', array('label'=>false,'id' => 'group_name','class'=> '','div'=>false)); ?> </td>
			
			<td width="10%" class="tdLabel" id=""><?php echo __('To Date')?> </td>
			<td width="10%"><?php echo $this->Form->input('', array('label'=>false,'id' => 'group_name','class'=> '','div'=>false)); ?> </td>
			
			<td width="10%" class="tdLabel save_btn" id=""><a href="#" class="blueBtn">Search</a></td>
		</tr>
	    <!--  <tr>
			<td width="15%!important;" valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Search Drug Name');?><font color="red">*</font></td>
			<td width="41%">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td><?php echo $this->Form->input('', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'first_name','label'=>false)); ?></td>
					</tr>
				</table>
			</td>
			<td width="13%" class="tdLabel" id=""></td>
			<td width="35%" class="tdLabel"></td>
	
		</tr> -->
		<tr>
			<td colspan="7" style="padding-right: 100px ">
				<div class="save_btn" style="float:right;margin:15px 0 0 15px; "> <a href="#" class="blueBtn">Report</a> </div>
			</td>
		</tr>
   </table>
	  
	  <table cellspacing="1" border="0" class="tabularForm" colspan="7">
	     <tr>
		   <th>Adjusted Date</th>
		   <th>Item Id</th>
		   <th>Drug Name</th>
           <th>Adjusted Quantity</th>
		   <th>Current Stock</th>
		   <th>Batch No</th>
           <th>Physical Stock</th>
           <th>Remark</th>
		 </tr>
		 <tr>
		   <td></td>
		   <td></td>
		   <td></td>
           <td></td>
		   <td></td>
		   <td></td>
           <td></td>
           <td></td>
		 </tr>
          
	  </table>
   <!-- <div class="report_btn">
        <a href="#" class="blueBtn">Report</a>
   </div> -->
   </div>
</div>