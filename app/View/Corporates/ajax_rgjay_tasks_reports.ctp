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

</style>

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
	  		<th width="10%" valign="top" align="center" style="text-align: center; min-width:21px;">Team No</th>
			<th width="15%" valign="top" align="center" style="text-align:center; min-width:80px;">Patient name</th>
			<th width="10%" valign="top" align="center" style="text-align:center; min-width:21px;">District</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Case No.</th>
			<th width="8%" valign="top" align="center" style="text-align:center; min-width:21px;">Hospital No.</th>
			<th width="20" valign="top" align="center" style="text-align:center; min-width:65px;">Admission Date</th>	
			<th width="25%" valign="top" align="center" style="text-align:center; min-width:245px;">Claim Status</th>
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
      
     	 <?php if($claim_status == "In Patient Case Registered" || $claim_status == "Preauth Updated"  || $claim_status == "Society Pending" || $claim_status == "TPA Pending" || $claim_status =="Preauth Pending"/*|| $claim_status =="Preauth Updated Cancelled"|| $claim_status == "Sent For Preauthorization"    || $claim_status == "Terminated By TPA" || $claim_status == "Terminated By Society"*/ ) { 	?>
     	 	<tr>
		      	<td align="center"><?php echo $i++; ?></td>
		      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
		      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
		      	<td align="center"><?php echo $results['Person']['district'];?></td>
		      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
		      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
		      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
		      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
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
   		</thead>
      </tr>
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
      
      <?php if(/*$claim_status == "Treatment Schedule" ||   || $claim_status == "TPA Approved"||*/$claim_status == "Treatment Schedule"  || $claim_status == "Surgery Update" || $claim_status == "Society Approved" || $claim_status == "Preauth Approved"){ ?>
      <tr>
      	<td align="center"><?php echo $i++; ?></td>
      	<td align="center"><?php echo $results['Patient']['assigned_to'];?></td>
      	<td align="center"><?php echo $results['Patient']['lookup_name'];?></td>
      	<td align="center"><?php echo $results['Person']['district'];?></td>
      	<td align="center"><?php echo $results['Patient']['case_no'];?></td>
      	<td align="center"><?php echo $results['Patient']['hospital_no'];?></td>
      	<td align="center"><?php echo $this->DateFormat->formatDate2Local($results['Patient']['form_received_on'],Configure::read('date_format'));?></td>
      	<td align="center"><?php echo $results['Patient']['claim_status']; ?></td>
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
			<th width="5%" valign="top" align="center" style="text-align:center; min-width:25px;">Ten days after bill completion</th>
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
      	<td align="center"><?php echo "-";?></td>
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
      
      <?php $i = 1;  foreach($result as $results) {	$claim_status = $results['Patient']['claim_status']; ?>
     
      <?php if($claim_status =="Claim Doctor Pending" ) { ?>
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

</div>