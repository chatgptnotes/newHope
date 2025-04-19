<div class="inner_title">
<h3><?php echo __('VAP Rate', true); ?></h3>
</div>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
 <div style="text-align: right;" class="inner_title">
   <?php 
    echo $this->Html->link(__('Generate Excel Report'), array('action' => 'vaprate_xlsreports', 'admin'=> true), array('escape' => false,'class'=>'blueBtn'));
   ?>
<div class="clr ht5"></div>
</div>                   
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
						 <th><?php echo __('Number of Ventilator Associated Pneumonia', true); ?></th>
						 <th><?php echo __('Ventilator Days', true); ?></th>
                                                 <th><?php echo __('VAP Rate', true); ?></th>
                                </tr>
                                <tr>
						 <td><?php if(count($vapCount) > 0) echo $vapCount[0][0]['vapcount']; else echo  __('Record Not Found', true); ?></td>
						 <td><?php if(count($mvCount) > 0) echo $mvCount[0][0]['mvcount']; else echo  __('Record Not Found', true); ?></td>
                                                 <td>
                                                 <?php if($vapCount[0][0]['vapcount']>0 && $mvCount[0][0]['mvcount']) {
                                                         $vaprate = ($vapCount[0][0]['vapcount']/$mvCount[0][0]['mvcount'])*100;
                                                         echo $this->Number->toPercentage($vaprate);
                                                       } else {
                                                         echo  __('Record Not Found', true);
                                                       }
                                                 ?></td>
                                                                                                
				</tr>
                   </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
   <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report','admin' => true),array('class'=>'grayBtn','div'=>false)); ?>
       </div>