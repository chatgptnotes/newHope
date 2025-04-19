<table width="100%" cellpadding="0" cellspacing="0" border="0" align='left' class="formFull formFullBorder">
						<?php if(!empty($get_lab)){
							foreach($get_lab as $get_lab){
								$lab_id=$get_lab['Laboratory']['lonic_code'];
							?>
						<?php 
						echo "<tr><td width='50%'>". $get_lab['Laboratory']['name'] ."</td>";
						//echo  "<td width='20px'>".$this->Html->image('/img/icons/infobutton.png',array('alt'=>'infoButton','title'=>'Info Button','onClick'=>"javascript:infolab('$lab_id')"))."</td>";
						echo  "<td align='left' width='25px' height='25' id='".$this->General->clean($lab_id)."' name = '".$lab_id."' class='info_button infolab' alt='Info Button' title='Info Button' valign='middle'></td>";
							echo "<td align='left' style='padding-left:5px'>".$this->Html->link($this->Html->image('/img/icons/Leaflet_1.png'), 'http://online.lexi.com/lco/action/pcm', array('target' => '_blank','escape'=>false,'alt'=>'leaflet','title'=>'leaflet','valign'=>'top')) ."</td></tr>";?>
						
				<?php } ?> <?php }else{?>
				<tr>
							
							<td>No data recorded</td>
						</tr>
						<?php }?>
						</table>