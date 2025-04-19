<div class="inner_title">
<h3><?php echo __('Consultations By Month', true); ?></h3>
</div>
<?php echo $this->Form->create('Reports',array('action'=>'monthly_consultations','type'=>'post', 'id'=> 'datefilterfrm'));?>	
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
                        echo $this->Form->create('Reports',array('action'=>'monthly_consultations_chart','type'=>'post', 'id'=> 'showloschartfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
		        echo $this->Form->submit(__('Show Graph'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
    
                        echo $this->Form->create('Reports',array('action'=>'monthly_consultations_xls','type'=>'post', 'id'=> 'losxlsfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
		        echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
   ?>
  <div class="clr ht5"></div>
  </div> 
  
</div>  
   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th></th>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
           <th style="text-align:center;"><?php echo $yaxisArrayVal; ?></th>
           <?php } ?>
            <th>Total</th>
           </tr>
	  <tr>
		<td><?php echo __('Total Number of Monthly Consultations', true); ?></td>   
	  <?php $total=0;
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                   <?php 
                         if(@in_array($key, $filterConsultationDateArray)) { echo $filterConsultationCountArray[$key]; } else { echo "0"; }
                   ?>
                </td>
          <?php $total=$total+$filterConsultationCountArray[$key];
				} ?>
          <td><?php echo $total;?></td>
          </tr>
          
        </table>
           
   <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?>
   </div>