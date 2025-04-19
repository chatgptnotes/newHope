
<td valign="top" style="padding-top: 10px;"><?php echo $counter; ?></td>
<td valign="top">                                	 
                                	<?php
																																	echo $this->Form->input ( '', array (
																																			'name' => "data[LaboratoryHistopathology1][$counter][0]",
																																			'class' => "",
																																			'label' => false,
																																			'div' => false,
																																			'error' => false,
																																			'id' => '',
																																			'value' => $getData 
																																	) );
																																	
																																	?>
                                </td>
<td style="padding-top: 10px;">
                             <?php
																													
																													echo $this->Form->textarea ( '', array (
																															'name' => "data[LaboratoryHistopathology1][$counter][1]",
																															'id' => 'histopathology_data_Frst',
																															'label' => false,
																															'div' => false,
																															'error' => false,
																															'style' => 'width:682px' 
																													) );
																													?>           
                                   </td>
<td valign="top" align="center" style="padding-top: 15px;">
                          		  <?php
																														echo $this->Html->link ( $this->Html->image ( 'icons/close-icon.png' ), '#', array (
																																'id' => "removeButtonHistopathology_$counter",
																																'escape' => false,
																																'class' => 'removeBtnHistopathology',
																																'title' => 'Remove' 
																														) );
																														
																														?>
                          		  </td>
