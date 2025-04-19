<div class="inner_title">
<h3><?php echo __('Hospital Associated Infections Rate', true); ?></h3>
</div>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
 <div style="text-align: right;" class="inner_title">
   <?php 
    echo $this->Html->link(__('Generate Excel Report'), array('action' => 'haicent_xlsreports'), array('escape' => false,'class'=>'blueBtn'));
   ?>
<div class="clr ht5"></div>
</div>  
                 
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
						 <th><?php echo __('Total HAI', true); ?></th>
						 <th><?php echo __('Number of Discharge + Number of Death', true); ?></th>
                                                 
                                                 <th><?php echo __('HAI Rate', true); ?></th>
                                </tr>
                                <tr>
						 <td>
                                                  <?php 
                                                    $totalhai = ($ssiCount[0][0]['ssicount']+$vapCount[0][0]['vapcount']+$utiCount[0][0]['uticount']+$bsiCount[0][0]['bsicount']+$thromboCount[0][0]['thrombocount']); 
                                                    echo $totalhai;
                                                  ?>
                                                 </td>
						 <td><?php echo  '15' ; ?></td>
                                                
                                                 <td>
                                                  <?php 
                                                       $haicent = ($totalhai/(15))*100; 
                                                       echo $this->Number->toPercentage($haicent);
                                                  ?>
                                                 </td>
                                                 
                                                 
				</tr>
                   </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
   <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
       </div>