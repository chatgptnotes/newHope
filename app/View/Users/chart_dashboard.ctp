<?php 
     App::import('Vendor', 'fusion_charts'); 
     echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<style>.basket {
    position: relative;
}</style>
<div class="inner_title">
<h3><?php echo __('Charts Dashboard', true); ?></h3>
</div>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
 <tr>
    <td>
    
           <table width="80%" align="center">
           <tr>
           
                  <!-- here we are inserting chart -->
                  <?php 
                   
                     $chartArray = array('chart1' => 'Total Number of UID Registration', 'chart2' => 'Total Number of IPD Patient Cash/Card', 'chart3' => 'OPD Patient Survey', 'chart4' => 'Total Number of OPD/IPD');
                     if(count($userDashboardChart) > 0) { 
						$i=1;//debug($userDashboardChart);
                  foreach($userDashboardChart as $userDashboardChartVal) { $userChartCnt++; ?>
							<td style="padding-top: 20px">
							<?php 
                            $userChartToDisplay = $this->requestAction('/users/createCustomizeChart?charttypeid='.$userDashboardChartVal['UserDashboardChart']['chartname']); 
                            echo $userChartToDisplay;
                            echo "</td> ";
                     		if($i%2==0)
                     		{
                            	echo "<br/></tr>" ;?>
                            	<tr >
                         <?php }?>
	                  <?php $i++; } ?>
                  <?php } ?>
                  </tr>
                </table>
            
     </td>
          </tr>
        </table>  
        <span style="float: right; padding-right:20px"><?php //echo $this->Html->link(__('Back'),array(), array('escape' => false,'class'=>'blueBtn back')); ?>
		<input type="button" name="Back" value="Back" class="blueBtn goBack">
	</span>
        <script>$(document).ready(function(){     
    		$('.goBack').click(function(){         parent.history.back();         return false;     }); });</script> 
   