<p class="ht5"></p> 
<!-- <div>&nbsp;</div> -->
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl">
          <tr>
            <td width=""><strong>Name:</strong></td>
            <td width="" align="left"><?php  if(empty($patient[0]['lookup_name'])) echo $patient['Patient']['lookup_name']; else echo $patient[0]['lookup_name'];?></td>
            <td width="" align="left"><strong>Reg ID :</strong></td>
            <td width=""><?php echo $patient['Patient']['admission_id'];?></td>
          </tr>
          <tr>
            <td valign="top"><strong>Address:</strong></td>
           <td width=""> <?php 
             echo $address; ?>
            <?php //if(!empty($patient['Person']['landmark']))$space=', ';else $space=' '; ?> 
           <?php //echo $patient['Person']['plot_no'].''.$space.''.$patient['Person']['landmark'];?></td>
            <td align="left" valign="top"><strong>Age/Sex :</strong></td>
            <td align="left" valign="top"><?php echo $patient['Patient']['age']." Yrs / ".ucfirst($patient['Patient']['sex']);?></td>
         </tr>
          <!--code by dinesh tawade-->
          <tr>
         	 <td valign="top"><strong>Treating Consultant:</strong></td>
            <td><?php echo $treating_consultant[0]['fullname'] ;?></td>
             <td valign="top" ><strong>DOA:</strong></td>
            <td><?php echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></td>         	
         </tr>
         
          <tr>
            <td  valign="top"><strong>Other Consultants:</strong></td>
            <td width="200px">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <?php foreach($otherConsultantData as $keyArr=>$getDoc){ ?>
            <tr><td valign="top">
            <?php if(!empty($getDoc['0']['name'])){
            			echo $getDoc['Initial']['nameInitial'].$getDoc['0']['name'];
            		}
				echo '</n>';		?></td> </tr>
			<?php }?>
           
            </table>
            </td>
            <td align="left" valign="top"><strong>DOD:</strong></td>
            <td align="left" valign="top"><?php if(empty($patient['FinalBilling']['discharge_date'])){
            	$getDODDate=date('Y-m-d H:i:s');
            }else if(!empty($patient['Patient']['discharge_date']) && $patient['Patient']['discharge_date']!="0000-00-00 00:00:00"){
				//else part by swapnil - 18.02.2016 if discharge_date is not present in finalbilling, retrieve date from patient
				$getDODDate=$patient['Patient']['discharge_date'];
			}else{
				$getDODDate=$patient['FinalBilling']['discharge_date'];
			}
            echo $this->DateFormat->formatDate2Local($getDODDate,Configure::read('date_format'),true); ?></td>
           
         </tr>
         
         
          <tr>
            <td valign="top"><strong>Reason Of Discharge:</strong></td>
            <td><?php if($patient['DischargeSummary']['reason_of_discharge']){
				echo $patient['DischargeSummary']['reason_of_discharge'];
			}else{
  		     if($patient['FinalBilling']['reason_of_discharge'] == "Recovered") {
  		       //echo __('Regular Discharge');
  		     } 
  		     if($patient['FinalBilling']['reason_of_discharge'] == "DischargeOnRequest") {
  		       echo __('Discharge On Request');
  		     }
  		     if($patient['FinalBilling']['reason_of_discharge'] == "DAMA") {
  		       echo __('Discharge Against Medical Advice');
  		     }
  		     if($patient['FinalBilling']['reason_of_discharge'] == "Death") {
  		       echo __('Death');
  		     }
  		     }
  		  ?>
                 
            </td>
            <td align="left" valign="top"><strong>Corporate Type:</strong></td>
            <td align="left" valign="top"><?php echo $patient['TariffStandard']['name']; ?></td>
          </tr>
        <!--  <tr>
            <td valign="top"><strong>Zip Code:</strong></td>
            <td><?php echo $patient['Person']['pin_code'];?></td>
            <td align="left" valign="top"><strong>Date Of Birth:</strong></td>
            <td align="left" valign="top"><?php echo $this->DateFormat->formatDate2Local($patient['Person']['dob'],Configure::read('date_format'));?></td>
         </tr>
         
         <tr>
            <td valign="top"><strong>City:</strong></td>
            <td><?php echo $patient['Person']['city'];?></td>
            <td align="left" valign="top"><strong>Age:</strong></td>
            <td align="left" valign="top"><?php 
             echo $this->General->getCurrentAge($patient['Person']['dob']);?></td>
         </tr>
         
          <tr>
            <td valign="top"><strong>State:</strong></td>
            <td><?php echo $patient['State']['name'];?></td>
            <td valign="top"><strong>Sex:</strong></td>
            <td ><?php echo ucfirst($patient['Patient']['sex']);?></td>
         </tr>
        
         <tr>
            <td valign="top" ><strong>Country:</strong></td>
            <td><?php echo ('India');?></td>
            <td align="left" valign="top"><strong>Phone:</strong></td>
              <td align="left" valign="top"><?php //$patient['Person']['person_city_code'] .' '.
            echo $patient['Person']['mobile'];?></td> -->
            <!-- <td align="left" valign="top"><strong>SSN:</strong></td>
            <td align="left" valign="top"><?php echo $patient['Person']['ssn_us']; ?></td> 
         </tr>-->
        
         <!--  <tr>
            <td valign="top"><strong><?php echo Configure::read('doctor') ?>:</strong></td>
            <td><?php echo $treating_consultant[0]['fullname'] ;?></td>
            <td align="left" valign="top"><strong>Sex:</strong></td>
            <td align="left" valign="top"><?php echo ucfirst($patient['Patient']['sex']);//echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></td>
          </tr> -->      
         
</table>
<div>&nbsp;</div>