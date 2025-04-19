<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
<?php 

	 echo $this->Html->css(array('tooltipster.css'));
	 echo $this->Html->script(array('jquery.tooltipster.min.js')); 
	 
	 ?>
<style>	
	.tableFoot{font-size:11px; color:#b0b9ba;}
	 
	.textAlign{
		text-align:left ;
		font-size :12px;
		padding-right:0px;
		padding-left:0px;
	}
</style>
<div class="inner_title">
                    	<h3 style="float:left;">Adverse Event</h3>
                        <div style="float:right;">
                        	<table width="" cellpadding="0" cellspacing="0" border="0" class="tdLabel2" style="color:#b9c8ca;">
                                <tr> 
                                  <td><?php echo $this->Html->link('Back',array('controller'=>'reports','action'=>'all_report','admin'=>true),array('escape'=>true,'class'=>'blueBtn','style'=>'float:right;'));?></td>
                                </tr>
                           </table>
                        </div>
                        <div class="clr"></div>
                  </div>
                  <div class="clr ht5"></div> 
                  <table width="100%" cellpadding="3" cellspacing="0" border="0" class="table_format textAlign">
                  		<tr class="row_title"> 
                          <td class="table_cell" width="20%"   valign="top"  style="min-width:150px;">Patient Name</td>
                          <td class="table_cell" width="5%"    valign="top"   >Age</td> 
                          <td class="table_cell" width="10%"   valign="top"   >Reg. ID.</td>	 
                          <td class="table_cell"     valign="top"  style=" min-width:120px;">Report</td> 
                     	</tr>
                     	<?php 
                     	$i=0;
                     	$currentWard =0;
                     	//count no of bed per ward 
                     	 
                     	foreach($data as $adverseKey =>$adverseVal){  
								$i++; 
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr class='row_gray_dark'>";
								       	$toggle = 0;
							       } ?>
									<td align="left" valign="top"  ><?php 
										echo $this->Html->link(ucfirst($adverseVal['info']['lookup_name']),
												array('controller'=>'patients','action'=>'patient_information',$adverseVal['info']['id']),
												array('error'=>false, 'title'=> ucfirst($adverseVal['info']['lookup_name']) ));
									 ?>
									</td>
									<td valign="top"  ><?php echo $adverseVal['info']['age']?>
									</td>
									<td valign="top"  ><?php echo $adverseVal['info']['admission_id']?>
									</td>
									<td  valign="top" rowspan="<?php echo count($adverseVal)-1 ;?>">		
								 
					<?php  foreach($adverseVal['AdverseEventTrigger'] as $subInfo =>$infoVal){
						    
							if(!is_numeric($subInfo)){ 
									echo '<strong style=" color:red;">'.ucfirst($subInfo).'</strong><br />' ;
									foreach($infoVal as $classVal){
										//echo "<a class='tooltip' href='#' title='".ucfirst($classVal['values'])."'>" ;
										echo "&nbsp;&nbsp;".$this->Html->link(ucfirst($classVal['values']),
																array('controller'=>'patients','action'=>'patient_information',$adverseVal['info']['id']),
																array('error'=>false,'class'=>'tooltip','title'=> ucfirst($classVal['values']) ));
										//echo "&nbsp;&nbsp;".ucfirst($classVal['values']); 
										//echo "</a>";
										echo "<br />" ;
									} 		
									continue ; //skip 				
							}
							
							echo "<a class='tooltip' href='#' title='".$infoVal['values']."'>" ;
							echo $infoVal['values'];
							echo "</a>" ;
					?>
							<br />		
					<?php  } ?>
						</td></tr>
					<?php  } ?> 
                   </table>
                   <div class="clr ht5"></div>
                   <table width="100%" cellpadding="5" cellspacing="0" border="0" align="center">
	                   <tr>
		                   	<td align="center">
			                   <?php 
			                   		if(empty($data)){
			                   			echo "No Record Found"    ;                			
			                   		}
			                   ?>
			                 </td>
	                   </tr>
                   </table>
                  
                   <div class="clr">&nbsp;</div>
                   
                   <div class="clr"></div>   
				<p class="ht5"></p>


<script type="text/javascript">
	 $(document).ready(function() {
	 	$('.tooltip').tooltipster({
	 		interactive:true,
	 		position:"right", 
	 	});
	 });
</script>
