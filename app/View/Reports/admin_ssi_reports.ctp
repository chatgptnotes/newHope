<div class="inner_title">
<h3><?php echo __('Surgical Site Infections Reports', true); ?></h3>
</div>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
 <div style="text-align: right;" class="inner_title">
   <?php 
    echo $this->Html->link(__('Generate Excel Report'), array('action' => 'ssi_xlsreports'), array('escape' => false,'class'=>'blueBtn'));
   ?>
<div class="clr ht5"></div>
</div>                   
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
						 <th><?php echo __('Number of SSI', true); ?></th>
						 <th><?php echo __('Number of Surgical Procedure', true); ?></th>
                                                 <th><?php echo __('SSI%', true); ?></th>
                                </tr>
                                <tr>
						 <td><?php if(count($ssiCount) > 0) echo $ssiCount[0][0]['ssicount']; else echo  __('Record Not Found', true); ?></td>
						 <td><?php if(count($spYesCount) > 0) echo $spYesCount[0][0]['spYescount']; else echo  __('Record Not Found', true); ?></td>
                                                 <td>
                                                 <?php if($ssiCount[0][0]['ssicount']>0 && $spYesCount[0][0]['spYescount']) {
                                                         $centssi = ($ssiCount[0][0]['ssicount']/$spYesCount[0][0]['spYescount'])*100;
                                                         echo $this->Number->toPercentage($centssi);
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