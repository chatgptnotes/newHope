<style>
/*----- Tabs -----*/
.tabs {
    width:100%;
    display:inline-block;
}
 
    /*----- Tab Links -----*/
    /* Clearfix */
    .tab-links:after {
        display:block;
        clear:both;
        content:'';
    }
 
    .tab-links li {
        margin:0px 5px;
        float:left;
        list-style:none;
    }
 
        .tab-links a {
            padding:9px 15px;
            display:inline-block;
            border-radius:3px 3px 0px 0px;
            background:#7FB5DA;
            font-size:16px;
            font-weight:600;
            color:#4c4c4c;
            transition:all linear 0.15s;
        }
 
        .tab-links a:hover {
            background:#a7cce5;
            text-decoration:none;
        }
 
    li.active a, li.active a:hover {
        background:#fff;
        color:#4c4c4c;
    }
 
    /*----- Content of Tabs -----*/
    .tab-content {
        padding:15px;
        border-radius:3px;
        box-shadow:-1px 1px 1px rgba(0,0,0,0.15);
        background:#fff;
    }
 
        .tab {
            display:none;
        }
 
        .tab.active {
            display:block;
        }
</style>


<div class="inner_title">
	<h3>
		<?php echo __('New Admission Intimation', true); ?>
	</h3>
</div>






<div class="tabs">
    <!-- Navigation header -->
	    <ul class="tab-links">
	        <li class="active"><a href="#tab1">Patient Details</a></li>
	        <li><a href="#tab2">Admission</a></li>
	        <li><a href="#tab3">Patient History</a></li>
	        <li><a href="#tab4">Clinical Finding</a></li>
	        <li><a href="#tab5">Ailment Details</a></li>
	        <li><a href="#tab6">Proposed Treatment</a></li>
	        <li><a href="#tab7">Documents</a></li>
	    </ul>
 	<!-- Navigation header End -->
 	
 	<!-- tab Section --> 
    <div class="tab-content">
        
        <!-- Patient Details -->
	        <div id="tab1" class="tab active">
			 	
			 	<table border="0" class="formFull" cellpadding="0" cellspacing="0" width="100%" align="center" style="padding: 10px;">
			 		<tr>
			 			<td colspan="4" align="left">
			 				<h3>&nbsp; Card Details</h3>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				CGHS ID:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Card Type:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select'),'div'=>false,'label'=>false));?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Card Holder Name:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Card Validity:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Office Name:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td colspan="2">
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Department:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Entitlement:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		
			 		
			 		
			 	<!-- Personal Information -->
			 		<tr>
			 			<td colspan="4" align="left">
			 				<h3>&nbsp; Personal Information</h3>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Relation with Card Holder:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select'),'div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Age:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Patient Name:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Gender:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select','male'=>'Male','female'=>'Female'),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Address:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td colspan="2">
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				City:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Pincode:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				State:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Email:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Mobile:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Phone:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 	</table>
			 	
			</div>
		<!-- End Patient Details -->

		<!-- Admission -->
	        <div id="tab2" class="tab">
	           
	           <table border="0" class="formFull" cellpadding="0" cellspacing="0" width="100%" align="center" style="padding: 10px;">
			 		<tr>
			 			<td colspan="4" align="left">
			 				<h3>&nbsp; Admission Details</h3>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Admission Date:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td colspan="2">
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Admission Number:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td colspan="2">
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Admission Type:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('emergency'=>'Emergency','referrel'=>'Referrel'),'div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Expected Discharge Date:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Room Type:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'slect','options'=>array('empty'=>'Please Select room type'),'div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Room Number:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		
			 		
			 		
			 	<!-- Referral Details -->
			 		<tr>
			 			<td colspan="4" align="left">
			 				<h3>&nbsp; Referral Details</h3>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Reference Number:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td colspan="2">
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				CGHS Region:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select Region'),'div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td colspan="2">
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Referred by Dispensary
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select Dispensary'),'div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td colspan="2">
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Issued Date:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Validity Upto:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Advised By:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Approved By:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				Referred Hospital:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select Hospital'),'div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Referred Room Type:
			 			</td>
			 			
			 			<td>
							<?php echo $this->Form->input('',array('type'=>'select','options'=>array('empty'=>'Please Select Room Type'),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td>
			 				No. of Session Allowed:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				Reffered Procedures:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'text','rows'=>2,'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 	</table>
			 	
			 </div>
		<!-- #End Admission -->
		 
		 <!-- Patient History -->
	        <div id="tab3" class="tab">
	            
	             <table border="0" class="formFull" cellpadding="0" cellspacing="0" width="100%" align="center" style="padding: 10px;">
			 		<tr>
			 			<td align="right" width="50%">
			 				<h3>&nbsp; Particulars</h3>
			 			</td>
			 			<td align="left">
			 				<h3>&nbsp; Yes/No</h3>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Hypertension
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Diabetic
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Heart
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Chronic Obstructive Pulmonary Disease (COPD)
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Bronchail Asthama
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Sexually Transmitted Disease (STD)
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Alcohol/DrugsIntoxication
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Other Disease
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 	</table>
	            
			 </div>
		<!-- #End Patient History -->
		
		<!-- Clinical Finding -->
	        <div id="tab4" class="tab">
	            <table border="0" class="formFull" cellpadding="0" cellspacing="0" width="100%" align="center" style="padding: 10px;">
			 		<tr>
			 			<td align="right" width="50%">
			 				Blood Pressure (BP)
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Cardio Vascular System (CVS)
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Respiratory System (RS)
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Abdomen
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Central Nervous System (CNS)
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Other
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 	</table>
			 </div>
		<!-- #End Clinical Finding -->
		
		<!-- Ailment Details -->
	        <div id="tab5" class="tab">
	            <table border="0" class="formFull" cellpadding="0" cellspacing="0" width="100%" align="center" style="padding: 10px;">
			 		<tr>
			 			<td align="right" width="50%">
			 				Is RTA
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Admission Ailment:
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'text','rows'=>2,'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Present System Duration:
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 	</table>
			 </div>
		<!-- #End  Ailment Details -->
		
		<!-- Proposed Treatment -->
	        <div id="tab6" class="tab">
	            <table border="0" class="formFull" cellpadding="0" cellspacing="0" width="100%" align="center" style="padding: 10px;">
			 		<tr>
			 			<td align="right" width="50%">
			 				Investigations
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Intensive Care
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Medical Management
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Surgical Management
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Procedure Description [Minor]
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Procedure Description [Major]
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 		<tr>
			 			<td align="right">
			 				Other Treatment/Procedure
			 			</td>
			 			
			 			<td align="left">
			 				<?php echo $this->Form->input('',array('type'=>'radio','options'=>array('yes'=>"Yes",'no'=>"No",'NM'=>"N.M"),'div'=>false,'label'=>false))?>
			 			</td>
			 		</tr>
			 		
			 	</table>
			 </div>
		<!-- #End Proposed Treatment -->
		
		<!-- Documents -->
	        <div id="tab7" class="tab">
	            <table border="0" class="formFull" cellpadding="0" cellspacing="0" width="100%" align="center" style="padding: 10px;">
		           <tr>
			 			<td>
			 				Doc Type:
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'select','multiple'=>'multiple','options'=>array('empty'=>'Please Select','CGHS Card Copy'=>'CGHS Card Copy','Doctor Certificate'=>'Doctor Certificate','FIR'=>'FIR','MLC'=>'MLC','Medical Report'=>'Medical Report','Others'=>'Others','Referral/Emergency Letter'=>'Referral/Emergency Letter'),'div'=>false,'label'=>false))?>
			 			</td>
			 			
			 			<td>
			 				<?php echo $this->Form->input('',array('type'=>'file','div'=>false,'label'=>false))?>
			 			</td>
				 	</tr>
				 </table>
			 </div>
		<!-- #End Documents -->

    </div>

    </div>





<script>
	jQuery(document).ready(function() {
	    jQuery('.tabs .tab-links a').on('click', function(e)  {
	        var currentAttrValue = jQuery(this).attr('href');
	        
	        // Show/Hide Tabs
	        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
	 
	        // Change/remove current tab to active
	        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
	        e.preventDefault();
	    });
	});
</script>