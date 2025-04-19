<div class="inner_title">
<h3><?php echo __('Total Number of Patient Readmitted to ICU within 48 hrs', true); ?></h3>
</div>
<?php echo $this->Form->create('Reports',array('action'=>'patient_readmitted_to_icu','type'=>'post', 'id'=> 'datefilterfrm'));?>	
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
                 <tr>				 
			
			<td  align="right"><?php echo __('Month') ?> :</td>										
			<td class="row_format">											 
		    	<?php 
                                $monthArray = array('01'=> 'January','02'=> 'February','03'=> 'March','04'=> 'April','05'=> 'May','06'=> 'June','07'=> 'July','08'=> 'August','09'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December',);
		    		echo    $this->Form->input(null, array('name' => 'reportMonth', 'class' => 'validate[required,custom[mandatory-select]]', 'id' => 'reportMonth', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options' =>$monthArray, 'empty'=> 'Select', 'value' =>$reportMonth));
		    	?>
		  	</td>
		 </tr>
                 <tr>				 
			<td class="row_format" align="left" colspan="2" style="padding-left:130px;">
				<?php
					echo $this->Form->submit(__('Show Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
		
</table>	
 <?php echo $this->Form->end();?>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
       <div style="float: right;border:none;" class="inner_title">
   <?php 
				if(empty($reportMonth)) { 
					   echo $this->Form->create('Reports',array('action'=>'patient_readmitted_to_icu_chart','type'=>'post', 'id'=> 'departconsultchartfrm', 'style'=> 'float:left;'));
			   echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
			   echo $this->Form->submit(__('Show Graph'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
			   echo $this->Form->end();
					} 
                              
                echo $this->Form->create('Reports',array('action'=>'patient_readmitted_to_icu_xls','type'=>'post', 'id'=> 'departconsultxlsfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
                        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportMonth', 'value' =>$reportMonth));
                        echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
   ?>
  <div class="clr ht5"></div>
  </div> 
  
</div>  
   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <?php 
                 // for daily reports
                 if(!empty($reportMonth)) { 
          ?> 
          <tr>
           <th style="text-align:center;"><?php echo __('Days', true); ?></th>
	   <th style="text-align:center;"><?php echo __('Total number of patient readmitted to ICU within 48 hrs', true); ?></th>
	  </tr>
          <tr>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
             <tr>
             <td style="text-align:center;"><?php echo $yaxisArrayVal; ?></td>
             <td align="center">
               <?php 
                 if(@in_array($key, $filterPatientReadmittedDateArray)) { echo $filterPatientReadmittedCountArray[$key]; } else { echo "0"; }
               ?>
              </td>
            </tr>
           <?php } ?>
          <?php } else { ?>
                  <tr>
                   <th></th>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <th><?php echo $yaxisArrayVal; ?></th>
                   <?php } ?>
	          </tr>
                  <tr>
                   <td><?php echo __('Total number of patient readmitted to ICU within 48 hrs', true); ?></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td>
                     <?php 
                          if(@in_array($key, $filterPatientReadmittedDateArray)) { echo $filterPatientReadmittedCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php } ?>
                  </tr>
          <?php } ?>
        </table>
           
   <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>