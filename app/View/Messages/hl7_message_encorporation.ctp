<style>

/**
 * for left element1
 */
.table_first{
 	margin-bottom: -20px;
 	
}

.td_second{
	border-left-style:solid; 
	padding-left: 25px; 
	padding-top: 25px
}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
}

.table_format{
	padding: 0px;
}

.inner_title h3 {
    clear: both !important;
    float: left !important;
	padding:-5px !important;
}
.inner_title p{padding-top: 6px; margin:0px;}

.inner_t{
 	color: #1c7087;
    font-size: 14px;
    font-weight: bold;
}

.inner_t{
 	color: #1c7087;
    font-size: 14px;
    font-weight: bold;
}

.inner_title h3{
	padding: 5px;
}
/* EOCode */
</style>


<div id="message_error" align="center"></div>

<div class="inner_title" >
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Lab Mailbox >') ?>
	</h3>
	<p class="inner_t" >
		<?php echo __(' Incorporation'); ?>
	
	</p>
</div>

<table class="table_first" width="100%"  cellspacing='0' cellpadding='0'>
	<tr>
		<td valign="top" width="5%">
			<div class="mailbox_div">
				<?php echo $this->element('mailbox_index');?>
			</div>
		</td>
		<td class="td_second" valign="top">	
<!-- 			<div class="mailbox_div"> -->
				<?php //echo $this->element('hl7_list');?>
			
			<div class="">
<!-- 				<h3 class="title_format" style="padding: 12px;">
					<?php //echo __('Message Incorporation') ?>
				</h3> -->
				
			
			<!-- <span><?php  echo $this->Html->link('Back',array("controller"=>"Messages","action"=>"index"),array('escape'=>false,'class'=>'blueBtn')); ?></span> -->
			</div>
			
			<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align: center;">
						<?php/*  if(isset($testOrdered_lab) && !empty($testOrdered_lab)){   */?>
						<td class="table_cell"><strong> <?php echo __('Order#'); ?>
						</strong></td>
						<td class="table_cell"><strong> <?php echo __('Patient MRN'); ?>
						</strong></td>
						<!-- <td class="table_cell"><strong> <?php echo __('Test Name'); ?>
						</strong></td>-->
						<td class="table_cell"><strong> <?php echo __('Order Type'); ?>
						</strong></td>
						<!-- 
						<td class="table_cell"><strong> <?php echo __('Review'); ?>
						</strong></td>-->
						<td class="table_cell"><strong><?php //echo __('Action'); ?></strong></td>
			
			
						</tr>
			
						<?php 
			
			$getCount=count($get_Result);
			//echo "<pre>";print_r($get_Result);exit;
			for($i=0;$i<count($get_Result);$i++){
			
			$result_hl7[]=explode("\n",$get_Result[$i]['Hl7Result']['message']);
			}
			$cnt=count($result_hl7);
			
			
			for($i=0;$i<count($result_hl7);$i++){
			$result_MSH[]=explode('|',$result_hl7[$i]['0']);
			$result_PID[]=explode('|',$result_hl7[$i]['1']);
			$result_ORC[]=explode('|',$result_hl7[$i]['2']);
			$result_OBR[]=explode('|',$result_hl7[$i]['3']);
			$result_NTE[]=explode('|',$result_hl7[$i]['4']);
			$result_TQ1[]=explode('|',$result_hl7[$i]['5']);
			$result_OBX[]=explode('|',$result_hl7[$i]['6']);
			$result_SPM[]=explode('|',$result_hl7[$i]['7']);
			}
			
			
			
			
										  $toggle =0;
										  $time = '';
										  if(count($get_Result) > 0) {//debug($get_Result);
			
												for($i=0;$i<count($get_Result);$i++){
													 
													   if($toggle == 0) {
															echo "<tr class='row_gray'>";
															$toggle = 1;
													   }else{
															echo "<tr class='row_details'>";
															$toggle = 0;
													   }
												
													  ?>
						<td class="row_format"><?php 
						$o_r_d  = explode("^",$result_ORC[$i]['2']);
						echo  $o_r_d[0]?></td>
						<?php $u_id=explode('^',$result_PID[$i]['3']); ?>
						<?php //for($i=0;$i<=count($get_Result);$i++){ ?>
						<td class="row_format"><?php echo $this->Html->link($u_id['0'],array('controller' => 'messages', 'action' => 'viewHl7Result',$u_id['0'],$i)); ?></td>
						
						<!-- <td class="row_format"><?php echo $labs['LaboratoryTestOrder']['create_time']; ?></td> -->
			
						<?php $order =$labs['LaboratoryTestOrder']['order_id']; ?>
						<td class="row_format">LAB<?php //echo  $substring = substr($order, 0, -11); ?></td>
						<!-- <td class="row_format"><?php echo $labs['LaboratoryTestOrder']['order_id']; ?></td> -->
			
			
			
			
			
			
						<td class="row_format"><?php 
							if($status == 'Pending'){
							//	echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'laboratories','action' => 'deleteLabTest', $labs['LaboratoryTestOrder']['id']), array('escape' => false),__('Are you sure?', true));	
							}
									 
			$labo_id = $labs['LaboratoryToken'][0]['id'];
			//echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_laborder($labo_id);return false;")), array(), array('escape' => false));
			/* echo $this->Html->link($this->Html->image('icons/sign-icon.png',array('title'=>'Generate HL7','alt'=>'Generate HL7', 'onclick'=>"gen_HL7_Lab($labo_id);return false;")), array(), array('escape' => false));
				*/ 
			$uid = $u_id['0'];
			//echo $this->Html->image('icons/post_reply.gif',array('title'=>'Send','alt'=>'Send', 'onclick'=>"openPopUp('$uid','$i','$patient_id')"));//$u_id['0'],$i)
			?>
						</td>
						</tr>
						<?php } 	
							//set get variables to pagination url
							//$this->Paginator->options(array('url' =>array("?"=>$this->params->query))); 
					?>
						
						<?php } ?><?php //} ?>
						<?php					  
									/*   } else { */
								 ?>
						<!-- <tr>
							<TD colspan="8" align="center" class="error"> --><?php /*echo __('No test assigned to selected patients', true); */ ?>
							<!-- </TD>
						</tr> -->
						<?php
									/*   }
									  
									  echo $this->Js->writeBuffer(); */ 
								  ?>
					</table>
				<div>&nbsp;</div>
		</td>
	</tr>
</table>