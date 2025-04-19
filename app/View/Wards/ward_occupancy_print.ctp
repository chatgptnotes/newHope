<style>	 
	.tableFoot{font-size:11px; color:#b0b9ba;}
	
	.tabularForm td{
    background: none repeat scroll 0 0 #ffffff;
    color: #333333;
    font-size: 13px;
    cellspacing:0;
    /* padding: 0px 0px;  */
}
.tableBorder td {
    background: none repeat scroll 0 0 #ffffff;
    color: #333333;
    cellspacing:0;
    padding-top:0;
    padding: 5px 8px;
 
}
body {
    color: #000000;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 23px;
    margin: -23px auto auto; 
    padding: 0;
    width: 1180px;
}

</style>
<h3 style="float:left;"><?php echo 'Ward Occupancy - '.date('d/m/Y');?></h3>  
 <div align="right" id="printButton"><a class="blueBtn" href="#" onclick="this.style.display='none';window.print();">Print</a></div>
                
                  <table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm">
                  		<tr>
               	  	  	  <th width="100px" align="center" valign="top"  style="text-align:center; min-width:100px;">Ward</th>
                          <th width="100px" align="center" valign="top"  style="text-align:center;">Bed</th>
                          <th width="150px" align="center"valign="top" style="text-align: center;min-width:150px;">Patient Name</th>
                          <th width="90px" align="center" valign="top"  style="text-align:center;">Age</th>
                          <th width="90px" align="center" valign="top"  style="text-align:center;">Patient ID</th>
                          <th width="125px" align="center" valign="top" style="text-align:center;">Reg. ID.</th>	
                          <th width="125px" align="center" valign="top" style="text-align:center;">Doctor Name</th>	
                           <th width="125px" align="center" valign="top" style="text-align:center;">Address</th>
                          <th width="90px" align="center" valign="top" style="text-align:center;">Sponsor</th>
                     	</tr>
                     	<?php 
                     	$i=0;
                     	$currentWard =0;
                     	//count no of bed per ward
                     	 
                     	foreach($data as $wardKey =>$wardVal){
                     		$wardArr[$wardVal['Ward']['name']][] = $wardVal['Ward']['id']; 
                     	}
                     	$totalBed = count($data);
                     	$booked = 0;
                     	$male =0;
                     	$female=0;
                     	$waiting=0;
                      	$maintenance =0;
                     	foreach($data as $wardKey =>$wardVal){
                     		
                     	?> 
                      	<tr><?php	if($i==0){ ?>
	                      	  		<td  rowspan="<?php echo count($wardArr[$wardVal['Ward']['name']]);?>" align="left" valign="top" style="text-align: center;padding-top:12px;">
	                          		<?php echo $wardVal['Ward']['name']?>
	                          		</td>
	                          		<?php
	                          		$i++;
                      	  		}else{
                      	  			$i++;
                      	  		}
                      	  		if($i==count($wardArr[$wardVal['Ward']['name']])){                           
                      	  			$i = 0;
                      	 	    }
                      	  ?>
                          <td  align="center" valign="middle" style="text-align:center;"><?php echo $wardVal['Room']['bed_prefix'].$wardVal['Bed']['bedno'] ;?></td>
                          <td  align="left" valign="middle" style="text-align:center;"><?php echo $wardVal['Patient']['lookup_name']?></td>
                          <td valign="middle" style="text-align:center;"><?php echo $wardVal['Patient']['age']?></td>
                           <td valign="middle" style="text-align:center;"><?php echo $wardVal['Patient']['patient_id']?></td>
                          <td valign="middle" style="text-align:center;"><?php echo $wardVal['Patient']['admission_id']?> </td>
                           <td valign="middle" style="text-align:center;"><?php echo $wardVal['DoctorProfile']['doctor_name']?> </td>
                          <td valign="middle" style="text-align:center;"><?php echo $wardVal['Person']['district']?> </td>
                          <td valign="middle" style="text-align:center;">
	                          <?php  
		                          	/*if($wardVal['Patient']['credit_type_id']==1){
		                          		echo ucfirst($wardVal['Corporate']['name']) ;	
		                          	}else if($wardVal['Patient']['credit_type_id']==2){
		                          		echo ucfirst($wardVal['InsuranceCompany']['name']);
		                          	}else if($wardVal['Patient']['patient_id']){
		                          		echo "Private";
		                          	}*/
		                          	
	                         echo $wardVal['TariffStandard']['name'];
	                          ?> 
                          </td>
                      	  
                     </tr>
                     	
                    <?php  }?>
                        
                   </table>
                   <div class="clr ht5"></div>
                   <table width="100%" cellpadding="5" cellspacing="1" border="0" align="center">
	                   <tr>
		                   	<td align="center">
			                   <?php 
			                   		if(empty($data)){
			                   			echo "No Record Found" ;                			
			                   		}
			                   ?>
			                 </td>
	                   </tr>
                   </table>
                   <!--<div class="btns">
                              <input name="" type="button" value="Save" class="blueBtn" tabindex="33"/>
                              <input name="" type="button" value="Cancel" class="grayBtn" tabindex="33"/>
                  </div>-->
                   <!-- billing activity form end here --> 
				<p class="ht5"></p>  