<div class="inner_title">
<h3><?php echo __('UTI Rate', true); ?></h3>
</div>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
 <div style="text-align: right;" class="inner_title">
   <?php 
    echo $this->Html->link(__('Generate Excel Report'), array('action' => 'utirate_xlsreports', 'admin'=> true), array('escape' => false,'class'=>'blueBtn'));
   ?>
<div class="clr ht5"></div>
</div>                   
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
						 <th><?php echo __('Number of Urinary tract infection', true); ?></th>
						 <th><?php echo __('Catheter Days', true); ?></th>
                                                 <th><?php echo __('UTI Rate', true); ?></th>
                                </tr>
                                <tr>
						 <td><?php if(count($utiCount) > 0) echo $utiCount[0][0]['uticount']; else echo  __('Record Not Found', true); ?></td>
						 <td><?php if(count($ucCount) > 0) echo $ucCount[0][0]['uccount']; else echo  __('Record Not Found', true); ?></td>
                                                 <td>
                                                 <?php if($utiCount[0][0]['uticount']>0 && $ucCount[0][0]['uccount']) {
                                                         $utirate = ($utiCount[0][0]['uticount']/$ucCount[0][0]['uccount'])*100;
                                                         echo $this->Number->toPercentage($utirate);
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