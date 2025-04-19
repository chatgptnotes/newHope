 <?php 
  	 if(date("l",strtotime($date)) == "Monday"){ 
	     $firstMondayInWeek =  strtotime($date);  		
	 }else{
	 	 $firstMondayInWeek = strtotime('last Monday', strtotime($date));  
	  }
	 
	  $WeekDays = array();
	  $timestampofdate = array();
	  for ($days = 0; $days <= 6; $days++) {
			 $timestampofdate[] =  strtotime("+$days day", $firstMondayInWeek );
			 $WeekDays[] =  $this->DateFormat->formatDate2Local(date('Y-m-d', strtotime("$days day", $firstMondayInWeek)),Configure::read('date_format')); 
	  }
	 
 ?>
 <table border="0" class="table-format" cellpadding="0" cellspacing="0" width="100%"  align="left" >
	 <tr class="row_title">
		<td class="table_cell" align="center"><strong> NAME</strong></td>
		<td class="table_cell" align="center"><strong>MONDAY </strong> <br/><?php echo $WeekDays[0];?></td>
		<td class="table_cell" align="center"><strong>TUESDAY </strong> <br/><?php echo $WeekDays[1];?></td>
		<td class="table_cell" align="center"><strong>WEDNESDAY </strong> <br/><?php echo $WeekDays[2];?></td>
		<td class="table_cell" align="center"><strong> THURSDAY</strong> <br/><?php echo $WeekDays[3];?></td>
		<td class="table_cell" align="center"><strong> FRIDAY</strong> <br/><?php echo $WeekDays[4];?></td>
		<td class="table_cell" align="center"><strong>SATURDAY </strong> <br/><?php echo $WeekDays[5];?></td>
		<td class="table_cell" align="center"><strong>SUNDAY</strong> <br/><?php echo $WeekDays[6];?></td>
	 </tr>
<?php
  	  $toggle =0;
	 
      if(!isset($message)) {
       foreach($data as $key => $datum): 
	    $resultDateSlot = array();
        if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
	   $weekdaysArray = array("MONDAY","TUESDAY","WEDNESDAY","THURSDAY","FRIDAY","SATURDAY","SUNDAY");
	 
  ?>
   
		 <td class="row_format" align="center"><?php  echo $datum['Initial']; ?>&nbsp;<?php  echo $datum['first_name']; ?>&nbsp;<?php  echo $datum['last_name']; ?></td>
	 		
		 <?php
		 	foreach($datum['timeslot'] as $key=>$value){
		 		
		 ?>
		 	
				<?php
				
				 
					 switch($value){
							case "night":
								echo "<td align='center'><span class='shift-cell' userId='".$datum['id']."' date='".$key."' name='".$datum['Initial']." ".$datum['first_name']." ".$datum['last_name']."'>N</span></td>";
							break;
							case "evening":
								echo "<td align='center'><span class='shift-cell' userId='".$datum['id']."' date='".$key."' name='".$datum['Initial']." ".$datum['first_name']." ".$datum['last_name']."'>E</span></td>";
							break;
							
							case "morning":
								echo "<td align='center'><span class='shift-cell' userId='".$datum['id']."' date='".$key."' name='".$datum['Initial']." ".$datum['first_name']." ".$datum['last_name']."'>M</span></td>";
							break;
							case "leave":
								echo "<td align='center'>On Leave</td>";
							break;
							case "off":
								echo "<td align='center' remove='true' class='shift-cell' userId='".$datum['id']."' date='".$key."' name='".$datum['Initial']." ".$datum['first_name']." ".$datum['last_name']."'>Day Off</td>";
							break;
							default:
							   echo "<td align='center'>Not Available</td>";
							break;
						}
			 
				?>
			
		 
		 <?php } ?>
		 <?php  endforeach; ?>
		 
	</tr>
  
    
   <?php
  
      } else {
  ?>
  
   <tr>
   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  
  
   <?php
      }
  ?>
  

</table>