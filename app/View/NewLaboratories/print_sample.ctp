<style>
@media print {
	#printButton {
		display: none;
	}
}
</style>
<div style="text-align: right;" id="printButton">
	<table align='right'>
		<tr>
			<td><?php echo $this->Html->link($this->Html->image('icons/print.png'),'#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false,'id'=>'print','title'=>'Print'));?>
			</td>
		</tr>
	</table>
</div>
<table width="100%">
	<?php for($i=0;$i<=2;$i++){?>
	<tr style="">
		<td width="20%" style="">
			<table width="" >
				<tr>
					<td width="100%"><?php
					if (file_exists ( WWW_ROOT . "/uploads/qrcodes/labOrderQrCard/" .$getData[0]['LaboratoryTestOrder']['req_no']. ".png" )) {
						echo $this->Html->image ( "/uploads/qrcodes/labOrderQrCard/" .$getData[0]['LaboratoryTestOrder']['req_no']. ".png", array (
								'alt' => $getData[0]['Patient']['lookup_name'],
								'title' => $getData[0]['Patient']['lookup_name'],
								'width' => '100%',
								'height' => '20px'
						) );
					} ?>
					</td>
				</tr>
				
				<tr>
					<td>
						<table>
							<tr>
								<td style="font-size: 13x;padding-bottom: 1px;padding-top: 0px;"><b><?php echo  $getData[0]['Patient']['lookup_name'];?></b></td>
							</tr>
							<tr>
								<td  style="font-size: 10px;padding-bottom: 0px;padding-top: 0px;"><?php echo  $getData[0]['Patient']['admission_id'];?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table> 
			
		</td>
	</tr>
	
		<?php }?>
</table>

<script>
$(document).ready(function(){
	window.print();	
});
</script>
