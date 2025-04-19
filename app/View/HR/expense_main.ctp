<?php echo $this->Html->script(array('inline_msg'));?>
<style>
td span:hover {
  color: black ;
  background-color: #FFFFFF ;
}

.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}

.top-header {
	background: #3e474a;
	height: 60px;*
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}
</style>

<div class="inner_title" style="margin-top: 10px;">
	<h3 style="float: left;"></h3>
	<span><?php echo $this->Html->link(__('Back', true),array('controller' => 'Reports', 'action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn','style'=>"float:right;"));
	?></span>
</div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('VoucherPayment',array('type' => 'GET',
		'url' => array('controller' => 'HR', 'action' => 'expense_main'),'class'=>'manage','style'=>array("float"=>"left","width"=>"100%"),'id'=>'HeaderForm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )
			));	 
?>
<?php //echo $this->Form->create('VoucherPayment',array('type'=>"GET",'action'=>'expense_main','default'=>false,'id'=>'HeaderForm','div'=>false,'label'=>false));?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="formFull" align="center" style="padding: 5px; margin-top: 5px">
	<tr>
	<td width="15%" align="center">Current Month:</td>
	<td width="20%" class="form_lables" align="center"><?php 
	$yearArr=array();
	for($i=date('Y'); $i>1980; $i--) {
		$yearArr[$i]=$i;	
	}
	$monthsArr=array();
	for($month=1;$month<=12;$month++){

 //   $monthsArr[] = date('F',strtotime("$month Months"));	
	//  $monthsArr[$m] = $m = date("F", strtotime("January +$month months"));
 $monthsArr[$month] = date('F', mktime(0,0,0,$month));
 
	}
echo $this->Form->input('month_list', array('options'=>$monthsArr,'empty'=>'Select Month','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'month','style'=>'width:230px;','autocomplete'=>'off','label'=>false,'div'=>false)); ?>
</td>
<td width="15%" align="center">Current Year:</td>
<td width="20%"><?php echo '&nbsp; &nbsp;'.$this->Form->input('year_list', array('options'=>$yearArr,'empty'=>'Select Year','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'year','style'=>'width:230px;','autocomplete'=>'off','label'=>false,'div'=>false));?>
</td>
<td width="5%"><?php //echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
echo $this->Html->image('icons/views_icon.png',array('id'=>'Submit','type'=>'submit','title'=>'Search'));?>			
</td>
<td width="5%"><?php echo $this->Html->image('icons/refresh-icon.png',array('escape'=>false, 'title' => 'refresh','id'=>'refreshBtn'));?></td>

</td>
<td width="20%">
</td>
</tr>
</table>
<?php echo $this->Form->end();?>
<div class="clr ht5"></div>

<div id="records"></div>
<div class="clr ht5"></div>
<script>

$(document).on('click','.checkboxRow', function() {	
	if(confirm("Do you really want to delete this record?")){	
		 this.checked = true;
   	   	checkId=this.id;	
		splitedId=checkId.split('_');
		ID=splitedId['1'];
		 
				var htmlvalue=$("#totalperDayExpense_"+ID).html();							
				var floatVal=parseFloat(htmlvalue);					
				var totalPerDayExpAmt=$("#total_per_day_expense").val();
				totalValue=totalPerDayExpAmt-floatVal;
				totalValue=Number(totalValue).toFixed(2);    
				$("#total_per_day_expense").val(totalValue);
				$("#totalperDayExpenseval").show().html(totalValue);	

				$("#row_"+ID).fadeOut(2000, function(){ 
				    $(this).remove();
				});
		// $("#row_"+ID).fadeOut(2000);				
	}else{
		return false;
	}			
});
$(function(){
$(document).on('click','.ChkBoxMonthlySelectAll', function() { 	 
	if(confirm("Do you really want to delete this record?")){
	//	currentId=$(this).attr('id'); 
		 this.checked = true;
	   	   	checkId=this.id;	
		splitedId=checkId.split('_');		
		ID=splitedId['2'];
		selectedHideID=splitedId['1'];	
		//deletedColumns.push(ID);		
		
		var chkMonthArray = new Array();	
		var splitedidMonth;
		/*********BOF-For calculating no of column by monthwise***/
		$(".ChkBoxMonthlySelectAll").each(function(){					
				idMonth = $(this).attr('id');
				splitedidMonth=idMonth.split('_');
				var MonthN=splitedidMonth['1'];					
				if(MonthN==selectedHideID){					
					return;
				}				
				chkMonthArray.push(MonthN);			
		});	

		
		
		var calColMonth;
		var tCount=1;   
		var counter = 1;
		var totalExpValue; 
		var perDayExpArray = new Array();	
		var Id = ID;
		
		$(".col_"+Id).fadeOut(1000, function(){ 
			 $(".colTh_"+Id).remove();
		    $(this).remove();
		});
		$(".col_"+ID).each(function(){				 
 				var htmlvalue = $(this).text();
				var floatVal=parseFloat(htmlvalue);			 	
 				
 				var getAvgAmtText = $(this).attr("totalVar"); 				
 				var getAvgAmt=$("#"+getAvgAmtText).val();
 				
 				var rowID = getAvgAmtText.split("_")[1] ;
 				
				/*if(typeof  getAvgAmt  == "undefined"){
					return;
				}*/
				calColMonth=chkMonthArray.length;			
				var totalValue=getAvgAmt-floatVal;				
				var totalAvgValueDisplay=totalValue/calColMonth;				
				totalAvgValueDisplay=Number(totalAvgValueDisplay).toFixed(2);			  
				var eachPerDayExp=totalAvgValueDisplay/30;				
				eachPerDayExp=Number(eachPerDayExp).toFixed(2);    
								
				$("#getAvgAmt_"+rowID).val(totalValue);
				$("#monthtoatalAvg_"+rowID).show().html(totalAvgValueDisplay);	
				$("#monthAvgAmt_"+rowID).val(totalAvgValueDisplay);		
				$("#totalperDayExpense_"+rowID).show().html(eachPerDayExp);
				$("#monthavgperday_"+rowID).val(eachPerDayExp);	
						
				tCount++;	
		 
		
		});	
		var perDayExpArray = new Array();
		$(".monthavgperday").each(function(){
			perDayExpArray.push($(this).val());	
		});
		
		totalExpValue = Number(eval("parseFloat(" + perDayExpArray.join(") + parseFloat(") + ");")).toFixed(2);  
		//totalExpValue=Number(totalExpValue).toFixed(2);    
		
		if(isNaN(totalExpValue)){
			totalExpValue="0.00";
		}
		
		$("#totalperDayExpenseval").show().html(totalExpValue);
		$("#total_per_day_expense").val(totalExpValue);
		
		$("#showHeading").show().html("Expenses For Last "+calColMonth+" Months");
		$("#showAvgHeading").show().html("Last "+calColMonth+" Months Average");
	
		if(calColMonth=="1" || calColMonth=="0"){	
			//console.log(chkMonthArray["0"]);	
			//console.log(splitedidMonth["2"]);
			$("#chk_"+chkMonthArray["0"]+"_"+splitedidMonth["2"]).attr("disabled",true);
		}
		
		
		//$(".col_"+ID).remove();
	    //$('#busy-indicator').show('fast');
		//  window.location.href = '<?php echo $this->Html->url("/HR/Expense"); ?>';
		   	  
  	  
		 
	}else{
		return false;
	}			
});
});
////BoF-Calculating total Per Day Expense
function Calc_totals(perDayExpArray) {	
    return eval("parseFloat(" + perDayExpArray.join(") + parseFloat(") + ");");
}
$(document).ready(function(){
	//load all records from here using ajax
		$("#Submit,#refreshBtn").click(function(){ 
			var currentId= $(this).attr('id');
		
			if(currentId=="refreshBtn")			
				$("#month,#year").val("");
		
			$.ajax({
				url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'expense_list'));?>',
				data:$('#HeaderForm').serialize(),
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success:function(data){					
					$("#records").html(data).fadeIn('slow');
					$('#busy-indicator').hide();
				}
			});
		});
	//on load render expense_list
	$.ajax({
		url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'expense_list'));?>',
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success:function(data){			
			$("#records").html(data).fadeIn('slow');
			$('#busy-indicator').hide();
		}
	});
	//$("#Submit").click(function(){ 
	//	alert("hello");
	////	
	///	 $('#approvesubmit').attr('disabled','disabled');
	//});
});
	$(document).on('click','.commentLblCls',function(){
		var currentId= $(this).attr('id');
		var splitedId=currentId.split("_");
		var Id=splitedId['1'];
		var htmlvalue=$(this).html();		
		
		$('#commentInTxt_'+Id).show();
		$("#commentInTxt_"+Id).attr('style','display:block;width:500px;');
		$('#commentInTxt_'+Id).focus();	
		$('#commentInTxt_'+Id).val(htmlvalue);		
		$('#CommentLbl_'+Id).hide();	
	
	});
	/////For Save the comment
	$(document).on('blur','.commentTxtCls',function(){
		var currentId= $(this).attr('id');
		var splitedId=currentId.split("_");
		var Id=splitedId['1'];	
		var commentInTxt=$("#commentInTxt_"+Id).val(); 		
		var recId=$("#recId_"+Id).val(); 			
		var htmlData = '';
		$.ajax({
   			url : "<?php echo $this->Html->url(array("controller" => 'HR', "action" => "edit_expense", "admin" => false));?>",
   			type: 'POST',
   			data: "commentInTxt="+commentInTxt+"&recId="+recId,
   			dataType: 'html',
   		  
   			beforeSend:function(data){
   			$('#busy-indicator').show();
   			},

   			success: function(data){   	   			
   	   			if(data!=""){
   	   				inlineMsg(currentId,'Comment has been Updated');   	   	   			
   	   	   			$("#commentInTxt_"+Id).hide();
   	   	   			$('#CommentLbl_'+Id).show().html(data);
   	   	   //	$("#CommentTxt_"+Id).hide();   	   	   	
   	   			}else{
   	   		//	$("#CommentLbl_"+Id).hide(); 
   	   			}
   			$('#busy-indicator').hide();
   			}
   			});       
	}); 


</script>