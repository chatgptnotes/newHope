<div class="inner_title">
<h3><?php echo __('Thrombophlebitis', true); ?></h3>
</div>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
 <div style="text-align: right;" class="inner_title">
   <?php 
    echo $this->Html->link(__('Generate Excel Report'), array('action' => 'thrombophlebitisrate_xlsreports', 'admin'=> true), array('escape' => false,'class'=>'blueBtn'));
   ?>
<div class="clr ht5"></div>
</div>                   
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
						 <th><?php echo __('Number of Thrombophlebitis', true); ?></th>
						 <th><?php echo __('Peripheral Line Days', true); ?></th>
                                                 <th><?php echo __('Thrombophlebitis Rate', true); ?></th>
                                </tr>
                                <tr>
						 <td><?php if(count($thromboCount) > 0) echo $thromboCount[0][0]['thrombocount']; else echo  __('Record Not Found', true); ?></td>
						 <td><?php if(count($plCount) > 0) echo $plCount[0][0]['plcount']; else echo  __('Record Not Found', true); ?></td>
                                                 <td>
                                                 <?php if($thromboCount[0][0]['thrombocount']>0 && $plCount[0][0]['plcount']) {
                                                         $thromborate = ($thromboCount[0][0]['thrombocount']/$plCount[0][0]['plcount'])*100;
                                                         echo $this->Number->toPercentage($thromborate);
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