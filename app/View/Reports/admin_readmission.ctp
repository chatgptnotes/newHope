<div class="inner_title">
<h3><?php echo __('Readmission Rate', true); ?></h3>
</div>

<?php 
$i=1;
foreach($rate as $key=>$value)
{
	foreach($value as $key=>$mon)
	{
		//pr($mon);
		$admit[$i]=count($mon['admit']);
		$readmit[$i]=count($mon['Readmit']);
		$i++;
	}


}
$j=1;
foreach($admit as $admitRate)
{
	$reRate[$j]=($readmit[$j]/$admitRate)*100;
	$j++;
}
echo $this->Form->create('Reports',array('action'=>'readmission_rate','type'=>'post', 'id'=> 'readmitratefrm'));?>	
<table border="0"   cellpadding="0" cellspacing="0" width="500px" >
	        <tr >				 
			
			<td align="right"><?php echo __('Year') ?> :</td>										
			<td class="row_format">											 
		    	<?php  
                                 $currentYear = date("Y");
                                 for($i=0;$i<=10;$i++) {
                                    $lastTenYear[$currentYear] = $currentYear;
                                    $currentYear--;
                                 }
		    		 echo    $this->Form->input(null, array('name' => 'reportYear', 'class' => 'validate[required,custom[mandatory-select]]', 'id' => 'reportYear', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options' =>$lastTenYear, 'value' =>$reportYear));
		    	?>
		  	</td>
		 </tr>	
 		  <tr >				 
			<td class="row_format" align="left" colspan="2" style="padding-left:145px;">
				<?php
					echo $this->Form->submit(__('Show Graph'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
		
</table>	

<?php echo $this->Form->end();?>
<div class="clr ht5"></div>
<div> 	
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th style="text-align:center;">Report for the Year-<?php echo $reportYear;?></th>
           <?php //debug($yaxisArray); 
           foreach($yaxisArray as $yaxisArrayVal) { 
																?>
           <th style="text-align:center;"><?php echo $yaxisArrayVal; ?></th>
           <?php } ?>
           </tr>
	  <tr>
		<td><?php echo __('Total Number of Patients Admitted ', true); ?></td>   
	  <?php 
	  //debug($yaxisArray);
	  $i=1;
	  foreach($yaxisArray as $yaxisArrayVal) {
	  
	  ?>
                <td align="center">
                   <?php 
                            if($admit[$i]!=""){ echo $admit[$i]; } 
                            else { echo "0"; }
                   ?>
                </td>
          <?php $i++; } ?>
          </tr>
          <tr>
		<td><?php echo __('Total Number of Patients Readmitted ', true); ?></td>   
	  <?php 
	  //debug($yaxisArray);
	  $i=1;
	  foreach($yaxisArray as $yaxisArrayVal) {
	  ?>
                <td align="center">
                   <?php 
							if($readmit[$i]!="") { echo $readmit[$i]; } else { echo "0"; }
                   ?>
                </td>
          <?php $i++; } ?>
          </tr>
          <tr>
		<td><?php echo __('Readmission Rate In Percent', true); ?></td>   
	  <?php 
	  //debug($reRate);
	  $i=1;
	  foreach($yaxisArray as $yaxisArrayVal) {
		
	  ?>
                <td align="center">
                   <?php 
                   if($reRate[$i]!="")
                   {
                             echo number_format($reRate[$i],"2")."%"; } else { echo "0"; }
                   ?>
                </td>
          <?php $i++; } ?>
          </tr>
          
        </table>
	</div>
<div class="clr ht5"></div>
 <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?>
   </div>
