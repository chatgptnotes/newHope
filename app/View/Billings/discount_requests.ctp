<style>
.text_center{ text-align:center;}
.row_action img {
    
}
</style>
<?php 
	echo $this->Html->script(array('inline_msg','jquery.blockUI'));
?>   
<div id="myContainer">

</div>

<script>
var discountInterval = "";
var refundInterval = "";
var currentType = "";

$(document).ready(function(){
	currentType = "Discount";
	$.ajax({
		url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajax_discount_requests","admin" => false)); ?>"+"/"+currentType,
		  context: document.body,
		  beforeSend:function(){
			loading('myContainer','id');
		  },	
		  success: function(data){ 
			 $('#myContainer').html(data);
			 onCompleteRequest('myContainer','id');
			 discountInterval = setInterval("Notifications('Discount')", 30000);
		  }
	});
});

$(document).on('click',".discount-button",function(){
	currentType = "Discount";
	$.ajax({
		url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajax_discount_requests","admin" => false)); ?>"+"/"+currentType,
		  context: document.body,
		  beforeSend:function(){
			loading('myContainer','id');
		  },	
		  success: function(data){ 
			 $('#myContainer').html(data);
			 onCompleteRequest('myContainer','id');
			 clearInterval(refundInterval);
			 discountInterval = setInterval("Notifications('Discount')", 30000);
		  }
	});
});

$(document).on('click',".refund-button",function(){
	currentType = "Refund";
	$.ajax({
		url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajax_discount_requests","admin" => false)); ?>"+"/"+currentType,
		  context: document.body,
		  beforeSend:function(){
			loading('myContainer','id');
		  },	
		  success: function(data){ 
			  $('#myContainer').html(data);
				 onCompleteRequest('myContainer','id');
			 clearInterval(discountInterval);
			 refundInterval = setInterval("Notifications('Refund')", 30000);
		  }
	});
});

$(document).on('click',".approved",function(){
	idd = $(this).attr('id');
	newId = idd.split("_");
	$.ajax({
    	type : "POST",
		  data: "id="+newId[1]+"&is_approved="+1,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ApprovalRequest","admin" => false)); ?>",
		  context: document.body,
		  beforeSend:function(){
			  loading('myContainer','id');
		  },	
		  success: function(data){ 
			  $('#myContainer').html(data);
				 onCompleteRequest('myContainer','id');
				 
		  }
	});
});

$(document).on('click',".reject",function(){
	idd = $(this).attr('id');
	newId = idd.split("_");
	$.ajax({
    	type : "POST",
		  data: "id="+newId[1]+"&is_approved="+2,
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ApprovalRequest","admin" => false)); ?>",
		  context: document.body,
		  beforeSend:function(){
			  loading('myContainer','id');
		  },	
		  success: function(data){ 
			  $('#myContainer').html(data);
				 onCompleteRequest('myContainer','id');
		  }
	});
});
function Notifications(type){
	$.ajax({
		url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajax_discount_requests","admin" => false)); ?>"+"/"+type,
		  context: document.body,
		  beforeSend:function(){
			loading('myContainer','id');
		  },	
		  success: function(data){ 
			  $('#myContainer').html(data);
				 onCompleteRequest('myContainer','id');
		  }
	});
}
function getWardTariffRequest(){
	$.ajax({
		url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajax_ward_tariff_change_request","admin" => false)); ?>",
		  context: document.body,
		  beforeSend:function(){
			loading('myContainer','id');
		  },	
		  success: function(data){ 
			  $('#myContainer').html(data);
				 onCompleteRequest('myContainer','id');
		  }
	});
}
var website = '<?php echo $this->Session->read('website.instance')?>';	
if(website =='lifespring'){ 
		$(document).on('click',".wardTariffRequests-button",function(){
			$.ajax({
				url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajax_ward_tariff_change_request","admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
					loading('myContainer','id');
				  },	
				  success: function(data){ 
					  $('#myContainer').html(data);
						 onCompleteRequest('myContainer','id');
					 clearInterval(discountInterval);
					 refundInterval = setInterval("getWardTariffRequest()", 30000);
				  }
			});
		});
		function getWardTariffRequest(){
			$.ajax({
				url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajax_ward_tariff_change_request","admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
					loading('myContainer','id');
				  },	
				  success: function(data){ 
					  $('#myContainer').html(data);
						 onCompleteRequest('myContainer','id');
				  }
			});
		}
		
		$(document).on('click',".approvedreq",function(){
			idd = $(this).attr('id');
			newId = idd.split("_");
			$.ajax({
		    	type : "POST",
				  data: "id="+newId[1]+"&is_approved="+1,
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ApprovalRequestForWardTariff","admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
					  loading('myContainer','id');
				  },	
				  success: function(data){ 
					  $('#myContainer').html(data);
					  onCompleteRequest('myContainer','id');
				}
			});
		});
		
		$(document).on('click',".rejectreq",function(){
			idd = $(this).attr('id');
			newId = idd.split("_");
			$.ajax({
		    	type : "POST",
				  data: "id="+newId[1]+"&is_approved="+2,
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ApprovalRequestForWardTariff","admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
					  loading('myContainer','id');
				  },	
				  success: function(data){
					  $('#myContainer').html(data); 
					  onCompleteRequest('myContainer','id');
					}
			});
		});
	}	
</script>