<style>
.tabularForm th {
    background: none repeat scroll 0 0 #d2ebf2;
    border-bottom: 1px solid #d2ebf2;
    color: #31859c;
    font-size: 12px;
    padding: 5px 8px;
    text-align: center;
}

</style>

<div class="inner_title">
<h3> &nbsp; <?php echo __('Mood Disorder Questionnaire', true); ?></h3>
</div>
<?php 
		$options=array('1'=>'yes','2'=>'no');
		
		$options2=array('1'=>'No problems',
						'2'=>'Minor Problem',
						'3'=>'Moderate Problem',
						'4'=>'Serious Problem');
?>

<div class="clr"></div>

<p class="ht5"></p> 

<?php echo $this->Form->create('Screening',array('controller'=>'Screenings','action'=>'mdq'))?>
<?php echo $this->Form->hidden('',array('type'=>'text','name'=>"data[Screening][form_name]",'value'=>"mdq"))?>


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
<tr style="height: 35px">
   <th></th>
  <th><?php echo __('QUESTIONS'); ?></th>
  <th><?php echo __('OPTIONS'); ?></th>
  
 </tr>
 <tr>
                        <td width="10" style="text-align: center;">1.</td>
                      
                        <td width="350" style="font-weight: bold;"><?php echo __('Has there ever been a period of time when you were not your usual self and... '); ?></td>
                        <td width="90">
                                 	 </td>
                                 	 
                      </tr>
                      
                       <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...you felt so good or so hyper that other people thought you were not your normal self or you were so hyper that you got into trouble? '); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio1','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q1]"))?></td>
                                </tr>
                            </table>                        
                        </td>
                           
                      </tr>
                      
                      <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...you were so irritable that you shouted at people or started fights or arguments? '); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio2','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q2]"))?></td>
                                </tr>
                            </table>                        
                        </td>
                            
                      </tr>
                      
                      <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...you felt much more self-confident than usual? '); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio3','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q3]"))?></td>
                                </tr>
                            </table>                        </td>
                           
                      </tr>
                      <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...you got much less sleep than usual and found that you didnt really miss it ? '); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio4','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q4]"))?></td>
                                </tr>
                            </table>                        </td>
                           
                      </tr>
                      <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...you were more talkative or spoke much faster than usual? '); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio5','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q5]"))?></td>
                                </tr>
                            </table>                        </td>
                           
                      </tr>
                      <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...thoughts raced through your head or you couldnt slow your mind down? '); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio6','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q6]"))?></td>
                                </tr>
                            </table>                        </td>
                            
                      </tr>
                      
                      <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...you were so easily distracted by things around you that you had trouble concentrating or
staying on track? '); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio7','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q7]"))?></td>
                                </tr>
                            </table>                        </td>
                           
                      </tr>
                      
                       <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...you had more energy than usual? '); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio8','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q8]"))?></td>
                                </tr>
                            </table>                        </td>
                           
                      </tr>
                       <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...you were much more active or did many more things than usual?'); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio9','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q9]"))?></td>
                                </tr>
                            </table>                        </td>
                           
                      </tr>
                       <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...you were much more social or outgoing than usual, for example, you telephoned friends in
the middle of the night?'); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio10','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q10]"))?></td>
                                </tr>
                            </table>                        </td>
                            
                      </tr>
                       <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...you were much more interested in sex than usual? '); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio11','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q11]"))?></td>
                                </tr>
                            </table>                        </td>
                            
                      </tr>
                       <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...you did things that were unusual for you or that other people might have thought were
excessive, foolish, or risky? '); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio12','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q12]"))?></td>
                                </tr>
                            </table>                        </td>
                           
                      </tr>
                       <tr>
                        <td width="10"></td>
                       
                        <td width="350"><?php echo __('...spending money got you or your family in trouble? '); ?></td>
                        <td width="90">
                        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio13','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q13]"))?></td>
                                </tr>
                            </table>                        </td>
                           
                      </tr>
                      
                      <tr>
                        <td width="10" style="text-align: center;">2.</td>
                      
                        <td width="350" style="font-weight: bold;"><?php echo __('If you checked YES to more than one of the above, have several of these ever
happened during the same period of time? '); ?></td>
                        <td width="90">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio14','options'=>$options,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q14]"))?></td>
                                </tr>
                            </table> 
                        	 </td>
                        	
                      </tr>
                      
                       <tr>
                        <td width="10" style="text-align: center;">3.</td>
                      
                        <td width="350" style="font-weight: bold;"><?php echo __('How much of a problem did any of these cause you - like being unable to work;
having family, money or legal troubles; getting into arguments or fights?  '); ?></td>
                        <td width="90">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            	<tr>
                                	<td style="padding-right: 0px; padding-right:0px; margin-right: 0px;"  ><?php echo $this->Form->input('',array('type'=>'radio','id'=>'radio15','options'=>$options2,'label'=>false,'legend'=>false,'name'=>"data[Screening][questions][q15]"))?></td>
                                
                                </tr>
                            </table> 
                        	 </td>
                        	 
                      </tr>
</table>
<div class="clr ht5"></div>
                    <div class="btns">
                           <input type="submit" value="Submit" class="blueBtn" >
                           <?php echo $this->Html->link(__('Cancel'),array('action' => 'mdq'),array('escape' => false,'class'=>'blueBtn')); ?>
                           
		    </div>
                    <div class="clr ht5"></div>
<?php echo $this->Form->end();?>
