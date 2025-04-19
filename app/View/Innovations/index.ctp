<div class="inner_title">
                    	<h3 style="float:left;">Innovations</h3>
                        <div style="float:right;">
                        	<table width="" cellpadding="0" cellspacing="0" border="0" class="tdLabel2" style="color:#b9c8ca;">
                                <tr> 
                                  <td><?php echo $this->Html->link('Back',array('action'=>'index'),array('escape'=>true,'class'=>'blueBtn','style'=>'float:right;'));?></td>
                                </tr>
                           </table>
                        </div>
                        <div class="clr"></div>
                  </div>
                  <div class="clr ht5"></div> 
<?php
	echo $this->Html->link("Adverse Event",array('controller'=>'innovations','action'=>'adverse_events'),array(''));
?>