<table cellspacing="1" border="0" class="tabularForm" style="margin-top: 30px; float: left">
	<tr>
		<th colspan="5" align="center" id="displayName" style="text-align:center"></th> 
	</tr>
	
	<?php if(count($detailList)>0){ $count = 0; ?>
	<tr>
		<th style="text-align:center;">SR.No</th>
		<th style="text-align:center;">Item Name</th>
		<!--<th>Batch No</th>-->
		<th style="text-align:center;">Units</th>
		<th style="text-align:center;">Current Stock</th>
		<!--<th>Expiry Date</th>-->
		<th style="text-align:center;">Date</th>
	</tr>
		<?php foreach($detailList as $list){ $count++; ?>
	<tr>
		<td style="text-align:center;"><?php echo $count;?></td>
		<td style="text-align:center;"><?php echo $list['PharmacyItem']['name'];?></td>
		<!--<td><?php echo $list['StockMaintenanceDetail']['product_batch']?></td>-->
		<td style="text-align:center;"><?php echo $list['StockIssueDetail']['issued_qty'];?></td>
		<td style="text-align:center;"><?php echo $list['StockIssueDetail']['closing_stock']?></td>
		<!--<td><?php echo $list['StockMaintenanceDetail']['product_expiry'];?></td>-->
		<td style="text-align:center;"><?php echo $this->DateFormat->formatDate2local($list['StockIssueDetail']['created'],Configure::read('date_format'),true);?></td>
	</tr>
	<?php }
	}else{
		echo "<tr><td colspan='5' align='center'><strong>No Record Found..!!</strong></td></tr>";
	}?>
</table>

<script>
	$(document).ready(function(){	//by swapnil to dislpay the heading of consumption 25.03.2015
		var locationName = $("#location_name").val();
		var sublocationName = $("#ward").val(); 
		var display = departmentList[locationName];
		if(sublocationName != "undefined" && sublocationName != ''){
			display = departmentList[locationName] +" ("+subDepartment[sublocationName]+")";
		}
		$("#displayName").html(display);
	});
</script>