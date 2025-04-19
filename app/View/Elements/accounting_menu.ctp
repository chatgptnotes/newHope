<style>
#talltabs-blue {
    border-top: 0px solid #8A9C9C;
    clear: left;
    float: left;
    font-family: Georgia,serif;
    overflow: hidden;
    padding: 0;
    width: 100%;
}

#talltabs-blue ul {
    list-style: none outside none;
    margin: 0;
    padding: 0;
    position: relative;
    text-align:left!important;
}

#talltabs-blue ul li {
    display: block;
  	float:none !important;
    list-style: none outside none;
    margin: 0;
    padding: 0;
    position: relative;}


#talltabs-blue ul li a.active,
 #talltabs-blue ul li.active a:hover 
 { 
 	/*padding: 30px 10px 6px !important;*/
 	color : white !important ; 
 }

.new {
    color: red !important;
    font-family: 'Times New Roman',serif;
}
 
#talltabs-blue ul li a {
    background: none repeat scroll 0 0 #C0C0C0;
    color: #000 !important;
    display: block;
    float: none!important;
    margin: 0 1px 0 0;
    padding: 8px 9px 6px;
    text-decoration: none;
    width: 132px!important;
}
</style>

<div id="talltabs-blue" style="width:100%">
	<ul>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="index"> 		
			<?php echo $this->Html->link('List Of Ledger',array('controller'=>'Accounting','action'=>'index','admin'=>false));?>  
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="account_creation"> 
			<?php echo $this->Html->link('Ledger Account Creation',array('controller'=>'Accounting','action'=>'account_creation','admin'=>false));?>  
		</li>
		<!--<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="payable_details"> 
			<?php //echo $this->Html->link('Ledger Overdue',array('controller'=>'Accounting','action'=>'payable_details','admin'=>false));?>
		</li>-->
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="legder_voucher"> 
			<?php  echo $this->Html->link('Ledger Statement',array('controller'=>'Accounting','action'=>'legder_voucher','admin'=>false));?>
		</li>
		
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="patient_journal_voucher"> 
			<?php  echo $this->Html->link('Patient Journal Voucher',array('controller'=>'Accounting','action'=>'patient_journal_voucher','admin'=>false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="payment_posting"> 
			<?php echo $this->Html->link('Patient Payment',array('controller'=>'Accounting','action'=>'payment_posting','admin'=>false));?>
			</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="get_patient_details"> 
			<?php echo $this->Html->link('Patient Ledger',array('controller'=>'Accounting','action'=>'get_patient_details','admin'=>false));?>
		</li>
		<!--<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="paymentPosting"> 
			<?php //echo $this->Html->link('Patient Receipt',array('controller'=>'Accounting','action'=>'paymentPosting','admin'=>false));?>
		</li>-->
		<li style="padding-top: 1px; float:left;"class="active-menu-tabs" id="journal_entry"> 
			<?php echo $this->Html->link('Journal Voucher',array('controller'=>'Accounting','action'=>'journal_entry','admin'=>false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="payment_voucher"> 
			<?php echo $this->Html->link($this->Html->tag('span','F1: ',array('class'=>'new'))."Payment Voucher",array('controller'=>'Accounting','action'=>'payment_voucher','admin'=>false),array('escape' => false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="account_receipt"> 
			<?php echo $this->Html->link($this->Html->tag('span', 'F2: ',array('class'=>'new'))."Receipt Voucher",array('controller'=>'Accounting','action'=>'account_receipt','admin'=>false),array('escape' => false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="contra_entry"> 
			<?php echo $this->Html->link($this->Html->tag('span', 'F4: ',array('class'=>'new'))."Contra Voucher",array('controller'=>'Accounting','action' =>'contra_entry','admin'=>false),array('escape' => false));?>	
		</li>
		<!--<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="account_receivable"> 
			<?php //echo $this->Html->link('Receivable',array('controller'=>'Accounting','action'=>'account_receivable','admin'=>false));?>
			</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="account_payable"> 
			<?php //echo $this->Html->link('Payable',array('controller'=>'Accounting','action'=>'account_payable','admin'=>false));?>
		</li>-->
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="admin_group_creation">
			<?php echo $this->Html->link('Group',array('controller'=>'Accounting','action'=>'group_creation','admin'=>true));?>
		</li>
		<!-- <li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="group_summary">
			<?php //echo $this->Html->link('Group Summary',array('controller'=>'Accounting','action'=>'group_summary','admin'=>true));?>
			</li> -->
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="dailyCashBook">
			<?php echo $this->Html->link('Cashier Transactions',array('controller'=>'billings','action'=>'dailyCashBook','admin'=>false));?>
		</li>
		<!-- <li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="patient_account_total">
			<?php //echo $this->Html->link('Patient Total',array('controller'=>'Accounting','action'=>'patient_account_total','admin'=>false));?>
		</li>-->
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="day_book">
			<?php echo $this->Html->link($this->Html->tag('span', 'F8: ', array('class' => 'new'))."Day Book",array('controller'=>'Accounting','action'=>'day_book','admin'=>false),array('escape' => false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="getAllCashierTransactions">
			<?php echo $this->Html->link($this->Html->tag('span', 'F9: ', array('class' => 'new'))."Cash Book",array('controller'=> 'billings','action'=>'getAllCashierTransactions','admin'=>false),array('escape' => false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="cashier_approve"> 
			<?php echo $this->Html->link('Allow Cashier',array('controller'=>'Accounting','action'=>'cashier_approve','admin'=>false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="service_group_report"> 
			<?php echo $this->Html->link('Service Group Report',array('controller'=>'Accounting','action'=>'service_group_report','admin'=>false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="purchase_entry"> 
			<?php //echo $this->Html->link('Purchase',array('controller'=>'Accounting','action'=>'purchase_entry','admin'=>false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="pettyCashBook"> 
			<?php echo $this->Html->link('Petty Cash Book',array('controller'=>'Accounting','action'=>'pettyCashBook','admin'=>false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="corporateSuspense"> 
			<?php echo $this->Html->link('Corporate Suspense',array('controller'=>'Accounting','action'=>'corporateSuspense','admin'=>false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="trialBalanceNew"> 
			<?php echo $this->Html->link('Trial Balance',array('controller'=>'Accounting','action'=>'trialBalanceNew','admin'=>false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="profitLoss"> 
			<?php echo $this->Html->link('Profit & Loss A/c',array('controller'=>'HR','action'=>'profitLossStatement','?'=>array('flag'=>'fromAcc'),'admin'=>false));?>
		</li>
		<li style="padding-top: 1px; float:left;" class="active-menu-tabs" id="balanceSheet"> 
			<?php echo $this->Html->link('Balance Sheet',array('controller'=>'HR','action'=>'balanceSheetStatement','?'=>array('flag'=>'fromAcc'),'admin'=>false));?>
		</li>
	</ul>
    <div class="clear">&nbsp;</div>
	<div class="clear">&nbsp;</div>
     
</div>
<script>
$(document).ready(function () {
	 $('li#'+'<?php echo $this->params[action]?>').find('a').attr( 'style','color : white !important');  
		$(".active-menu-tabs").click(function(){  
	            var tabClicked = $(this).attr("name");
	            $(".child-tabs").hide();
	            $("#"+tabClicked).fadeIn('slow');
	            $(".active-menu-tabs").removeClass('active');
	            $(this).addClass('active');
	            return true ;
		});
	 });
//shortcut key by amit jain
$(document).bind('keydown', function(e) {
	if (e.keyCode == "115"){
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'contra_entry'));?>" ;
	} else if(e.keyCode == "112"){
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'payment_voucher'));?>";
	} else if(e.keyCode == "113"){
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'account_receipt'));?>";
	} else if(e.keyCode == "120"){
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'billings','action'=>'getAllCashierTransactions'));?>";
	} else if(e.keyCode == "119"){
		window.location.href = "<?php echo $this->Html->url(array('controller'=>'Accounting','action'=>'day_book'));?>";
	}
});
</script>