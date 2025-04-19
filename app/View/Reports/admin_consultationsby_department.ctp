<div class="inner_title">
<h3><?php echo __('Consultations By Speciality', true); ?></h3>
</div>
<?php echo $this->Form->create('Reports',array('action'=>'consultationsby_department','type'=>'post', 'id'=> 'datefilterfrm'));?>	
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
                 <tr >				 
			
			<td  align="right"><?php echo __('Speciality') ?> :</td>										
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'departmentType', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => $departmentList, 'empty'=>'Please Select','id' => 'reportType', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' =>$departmentType));
		    	?>
		  	</td>
		 </tr>	 
 		  <tr >				 
			<td class="row_format" align="left" colspan="2" style="padding-left:125px;">
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
					   echo $this->Form->create('Reports',array('action'=>'consultationsby_department_chart','type'=>'post', 'id'=> 'departconsultchartfrm', 'style'=> 'float:left;'));
			   echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
					   echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'departmentType', 'value' =>$departmentType));
			   echo $this->Form->submit(__('Show Graph'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
			   echo $this->Form->end();
					} 
                              
                echo $this->Form->create('Reports',array('action'=>'consultationsby_department_xls','type'=>'post', 'id'=> 'departconsultxlsfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
                        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportMonth', 'value' =>$reportMonth));
                        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'departmentType', 'value' =>$departmentType));
		        echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
   ?>
  <div class="clr ht5"></div>
  </div> 
  
</div>  
   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <?php  $total=0; 
                 // for daily reports
                 if(!empty($reportMonth)) { 
          ?> 
          <tr>
           <th style="text-align:center;"><?php echo __('Days', true); ?></th>
	   <th style="text-align:center;"><?php echo __('Total Number of Daily Consultations', true); ?></th>
	   
	  </tr>
         
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
             <tr>
             <td style="text-align:center;"><?php echo $yaxisArrayVal;?></td>
             <td align="center">
               <?php 
                 if(@in_array($key, $filterDepartConsultDateArray)) { echo $filterDepartConsultCountArray[$key]; } else { echo "0"; }
               ?>
              </td>
            </tr>
           <?php $total=$total+$filterDepartConsultCountArray[$key];
          		}?>
          	<tr>
          	    <th style="text-align:center;">Total</th>
          	    <th style="text-align:center;"><?php echo $total;?></th>
          	</tr>	
          <?php } else { ?>
                  <tr>
                   <th></th>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <th><?php echo $yaxisArrayVal; ?></th>
                    
                   <?php } ?>
                    <th>Total</th>
	          </tr>
                  <tr>
                   <td><?php echo __('Total Number of Monthly Consultations', true); ?></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td>
                     <?php 
                          if(@in_array($key, $filterDepartConsultDateArray)) { echo $filterDepartConsultCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php $total=$total+$filterDepartConsultCountArray[$key];
          		}?>
          		 <td><?php  echo $total; ?></td>
                  </tr>
          <?php } ?>
        </table>
           
   <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?>
   </div>