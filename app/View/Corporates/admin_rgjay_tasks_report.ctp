<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));  
 echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js','jquery.autocomplete.js')); ?>
<style>	
	.tableFoot{font-size:11px; color:#b0b9ba;}
	.tabularForm td td{padding:0;}
	.top-header
	{
		background:#3e474a;
		height:75px;
		left:0;
		right:0;
		top:0px;
		margin-top:10px;
		position: relative;
	}  
	textarea
	{
		width: 100px;
	}
	
	.inner_title span 
	{
    	margin: -33px 0 0 !important;
 	}
 	.inner_menu
 	{
		padding: 10px 0px;
	}
	td .days-alert{
		background-color: #ffaaaa !important;
	}
</style>
<?php
	$team = array('A'=>'A','B'=>'B','C'=>'C');
?>
<?php  echo $this->element("reports_menu");?>
 <div class="inner_title"> 
 	<h3>&nbsp; RGJAY Tasks Report</h3> 	
 </div> 

<div class="inner_menu">
	<div>
		<div style="float:left;">
				<?php
					echo $this->Form->create('Corporates',array('action'=>'admin_rgjay_tasks_report_xls', 'admin' => true,'type'=>'post', 'id'=> 'losxlsfrm', 'style'=> 'float:left;'));
					
		        	echo "Search by Team: ".$this->Form->input('assigned_to', array('type' => 'select','label'=>false ,'class'=>'filter','div'=>false,'id'=>'team','options' => $team,'empty'=>'--All--'));?>  
		</div>
			
		<div style="float: right;">
			<?php
				echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'float:center;')); 
				echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));
		        echo $this->Form->end(); 
			?>
		</div>
	</div>
</div>
<div class="clr">&nbsp;</div>

<div id="container">          
<div class="clr ht5"></div>
<div class="inner_title"> 
 	<h3>&nbsp; Section 1 = Executive Tasks <i>(Pre Auth To Be Completed)</i></h3>
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="5%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="20%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="10" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th colspan="2" width="30%" valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
      
     	 <?php if($claim_status == "In Patient Case Registered" || $claim_status == "Preauth Updated"  || $claim_status == "Society Pending" || $claim_status == "TPA Pending" || $claim_status =="Preauth Pending"/*|| $claim_status =="Preauth Updated Cancelled"|| $claim_status == "Sent For Preauthorization"    || $claim_status == "Terminated By TPA" || $claim_status == "Terminated By Society"*/  ) { 	?>
     	 	<tr>
		      	<td align="center"><?php echo $i++; ?></td>
		      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
		      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
		      	<td align="center"><?php echo $results['Person']['district'];?></td>
		      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
		      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
		      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
		      	<td colspan="2" align="center"><?php echo $results['Patient']['claim_status']; ?></td>
		    </tr>
	   	 <?php } ?> 
      <?php	} ?>
      </table>
       
<div class="clr">&nbsp;</div> 


                
<div class="clr ht5"></div>

 <div class="inner_title"> 
 	<h3>&nbsp; Section 2 = Team Doctors task <i>(Treatement Sheet ,OT Notes , DischargeTo be Uploaded)</i></h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
      
      <?php if(/*$claim_status == "Treatment Schedule" ||   || $claim_status == "TPA Approved"||*/$claim_status == "Treatment Schedule"  || $claim_status == "Surgery Update" || $claim_status == "Society Approved" || $claim_status == "Preauth Approved"){ ?>
      <?php $changedDate = date("Y-m-d",strtotime($results['Patient']['claim_status_change_date'])); 
      		$DateAfter15days = date("Y-m-d", strtotime($changedDate ." +15 day") ); 
      		//debug(strtotime($DateAfter15days)." ---> ".strtotime(date("Y-m-d")));
      		if(strtotime($DateAfter15days) <= strtotime(date("Y-m-d"))){
				$class= "days-alert"; } else { $class = ''; } ?>
      <tr >
      	<td align="center" class="<?php echo $class; ?> "><?php echo $i++; ?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Person']['district'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
      </tr>
      <?php }  
      		
      	} 
      ?>
      </table>


<div class="clr">&nbsp;</div> 


               
<div class="clr ht5"></div>

 <div class="inner_title"> 
 	<h3>&nbsp; Section 3 = Executive Tasks 2 <i>(Bills of following patient to be uploaded)</i></h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
      
      <?php  if($claim_status == "Discharge Update"  && !empty($results['Patient']['lookup_name'])){ ?>
      <tr>
      	<td align="center"><?php echo $i++; ?></td>
      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center"><?php echo $results['Person']['district'];?></td>
      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
       </tr>
      <?php }  
      		} 
      ?>
      </table>

<div class="clr">&nbsp;</div> 

                
<div class="clr ht5"></div>

 <div class="inner_title"> 
 	<h3>&nbsp; Section 4 = Team Doctor 2 <i>(Queries To Be Answered)</i></h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     
      <?php if($claim_status =="CMO Pending(Repudiated)" || $claim_status =="Claim Doctor Pending"/*$claim_status == "CMO Pending Updated(Repudiated)" || $claim_status =="Claim Doctor Pending Updated" || $claim_status =="Claim Doctor Rejected"|| $claim_status =="Claim Rejected by CMO"||  $claim_status == "Claim Doctor Approved" ||
      || $claim_status =="Cancelled By Society"|| $claim_status == "Cancelled By TPA"  || $claim_status == "CMO Approved(Repudiated)" ||  $claim_status == "CMO Rejected(Repudiated)"*/) { ?>
       <tr>
      	<td align="center"><?php echo $i++; ?></td>
      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center"><?php echo $results['Person']['district'];?></td>
      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
     	 </tr>
      <?php }  
      		} 
      ?>
      </table>
<div class="clr">&nbsp;</div>


<div class="clr ht5"></div>
 <div class="inner_title"> 
 	<h3>&nbsp; Section 5 = Admitted Yesterday</h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; //echo date('Y-m-d',strtotime("-2 days"));?>
     <?php if(date("Y-m-d",strtotime($results['Patient']['form_received_on'])) == date('Y-m-d',strtotime("-1 days"))) { ?>
       <tr>
      	<td align="center"><?php echo $i++; ?></td>
      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center"><?php echo $results['Person']['district'];?></td>
      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
     	 </tr>
      <?php }  
      		} 
      ?>
      </table>
<div class="clr">&nbsp;</div>



<div class="clr ht5"></div>
 <div class="inner_title"> 
 	<h3>&nbsp; Section 6 = Enrollment Pending</h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     
      <?php if($claim_status =="Enrollment (Pending)") { ?>
       <tr>
      	<td align="center"><?php echo $i++; ?></td>
      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center"><?php echo $results['Person']['district'];?></td>
      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
     	 </tr>
      <?php }  
      		} 
      ?>
      </table>
<div class="clr">&nbsp;</div>


<div class="clr ht5"></div>
 <div class="inner_title"> 
 	<h3>&nbsp; Section 7 = Pre-Auth Pending</h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     
      <?php if($claim_status === "Pre-authorization (Pending)") { ?>
       <tr>
      	<td align="center"><?php echo $i++; ?></td>
      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center"><?php echo $results['Person']['district'];?></td>
      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
     	 </tr>
      <?php }  
      		} 
      ?>
      </table>
<div class="clr">&nbsp;</div>



<div class="clr ht5"></div>
 <div class="inner_title"> 
 	<h3>&nbsp; Section 8 = Surgery Pending</h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     
      <?php if($claim_status =="Surgery (Pending)") { ?>
       <tr>
      	<td align="center"><?php echo $i++; ?></td>
      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center"><?php echo $results['Person']['district'];?></td>
      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
     	 </tr>
      <?php }  
      		} 
      ?>
      </table>
<div class="clr">&nbsp;</div>



<div class="clr ht5"></div>
 <div class="inner_title"> 
 	<h3>&nbsp; Section 9 = Surgery Update</h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     
      <?php if($claim_status =="Surgery (Update)") { ?>
       <tr>
      	<td align="center"><?php echo $i++; ?></td>
      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center"><?php echo $results['Person']['district'];?></td>
      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
     	 </tr>
      <?php }  
      		} 
      ?>
      </table>
<div class="clr">&nbsp;</div>



<div class="clr ht5"></div>
 <div class="inner_title"> 
 	<h3>&nbsp; Section 10 = Discharge Pending</h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     
      <?php if($claim_status =="Discharge (Pending)") { ?>
       <tr>
      	<td align="center"><?php echo $i++; ?></td>
      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center"><?php echo $results['Person']['district'];?></td>
      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
     	 </tr>
      <?php }  
      		} 
      ?>
      </table>
<div class="clr">&nbsp;</div>



<div class="clr ht5"></div>
 <div class="inner_title"> 
 	<h3>&nbsp; Section 11 = Discharge Update</h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     
      <?php if($claim_status =="Discharge (Update)") { ?>
       <tr>
      	<td align="center"><?php echo $i++; ?></td>
      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center"><?php echo $results['Person']['district'];?></td>
      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
     	 </tr>
      <?php }  
      		} 
      ?>
      </table>
<div class="clr">&nbsp;</div>


 
<div class="clr ht5"></div>
 <div class="inner_title"> 
 	<h3>&nbsp; Section 12 = Claim Doctor Pending</h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; 
	      $changedDate = date("Y-m-d",strtotime($results['Patient']['claim_status_change_date']));
	      $DateAfter15days = date("Y-m-d", strtotime($changedDate ." +15 day") );
	      //debug(strtotime($DateAfter15days)." ---> ".strtotime(date("Y-m-d")));
	      if(strtotime($DateAfter15days) <= strtotime(date("Y-m-d"))){
	      	$class= "days-alert"; } else { $class = ''; }
      
      ?>
     
      <?php if($claim_status =="Claim Doctor Pending" ) { ?>
       <tr>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $i++; ?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Person']['district'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
     	 </tr>
      <?php }  
      		} 
      ?>
      </table>
<div class="clr">&nbsp;</div>


<div class="clr ht5"></div>
 <div class="inner_title"> 
 	<h3>&nbsp; Section 13 = Due Bills Today</h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	//$discharge_date = date("Y-m-d",$results['Patient']['discharge_date']); ?>
     
      <?php if(date("Y-m-d",strtotime($results['Patient']['discharge_date'])) == date('Y-m-d',strtotime("-10 days"))) { ?>
       <tr>
      	<td align="center"><?php echo $i++; ?></td>
      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center"><?php echo $results['Person']['district'];?></td>
      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
     	 </tr>
      <?php }  
      		} 
      ?>
      </table>
<div class="clr">&nbsp;</div>


<div class="clr ht5"></div>
 <div class="inner_title"> 
 	<h3>&nbsp; Section 14 = Claim Doctor Rejected</h3> 	
 </div>
 <div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	  <tr>
	  	<thead>
	  		<th width="5%" valign="top" align="center" style="text-align:center; min-width:21px;">No.</th>
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
			<th width="25%"  valign="top" align="center" style="text-align:center; min-width:245px;">Status Change Date</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status'];
      	?>
     
      <?php if($claim_status === "Claim Doctor Rejected")  {
      		$changedDate = date("Y-m-d",strtotime($results['Patient']['claim_status_change_date'])); 
      		$DateAfter10days = date("Y-m-d", strtotime($changedDate ." +10 day") ); 
      		if(strtotime($DateAfter10days) <= strtotime(date("Y-m-d"))){
				$class= "days-alert"; } else { $class = ''; }  ?>
       <tr class="<?php echo $class; ?>">
      	<td align="center" class="<?php echo $class; ?> "><?php echo $i++; ?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Person']['district'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $results['Patient']['claim_status']; ?></td>
      	<td align="center" class="<?php echo $class; ?> "><?php echo $this->DateFormat->formatDate2Local($results['Patient']['claim_status_change_date'],Configure::read('date_format')); ?></td>
     	 </tr>
      <?php }  
      		} 
      ?>
      </table>
<div class="clr">&nbsp;</div>





</div>



<!--******************************************* table closed *******************************************************-->           
                               
<script>
jQuery(document).ready(function()
{
	
	$('.filter').change(function()	//.checkMe is the class of select having patient's id as the id
	{
		var team = ($('#team').val()) ? $('#team').val() : 'null' ;
		//alert(team);
		//var status = ($('#status').val()) ? $('#status').val() : 'null';
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "rgjay_tasks_report", "admin" => true));?>";
		$.ajax({
		url : ajaxUrl + '?assigned_to=' + team,
		beforeSend:function(data){
		$('#busy-indicator').show();
		},
		success: function(data){
			$("#container").html(data).fadeIn('slow');
			$('#busy-indicator').hide();
		}
		});
	});

});

</script>