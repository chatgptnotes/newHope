<div class="inner_title">
<h3><?php echo __('BSI Rate', true); ?></h3>
</div>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
 <div style="text-align: right;" class="inner_title">
   <?php 
    echo $this->Html->link(__('Generate Excel Report'), array('action' => 'bsirate_xlsreports', 'admin'=> true), array('escape' => false,'class'=>'blueBtn'));
   ?>
<div class="clr ht5"></div>
</div>                   
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
						 <th><?php echo __('Number of CLABSI', true); ?></th>
						 <th><?php echo __('Central Line Days', true); ?></th>
                                                 <th><?php echo __('BSI Rate', true); ?></th>
                                </tr>
                                <tr>
						 <td><?php if(count($bsiCount) > 0) echo $bsiCount[0][0]['bsicount']; else echo  __('Record Not Found', true); ?></td>
						 <td><?php if(count($clCount) > 0) echo $clCount[0][0]['clcount']; else echo  __('Record Not Found', true); ?></td>
                                                 <td>
                                                 <?php if($bsiCount[0][0]['bsicount']>0 && $clCount[0][0]['clcount']) {
                                                         $bsirate = ($bsiCount[0][0]['bsicount']/$clCount[0][0]['clcount'])*100;
                                                         echo $this->Number->toPercentage($bsirate);
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