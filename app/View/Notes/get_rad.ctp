<?php			if(!empty($resultRadiology)){?>
<table width="100%" class="formFull formFullBorder">
	<tr "style="color: gray"">
		<td
			style="text-align: left; font-weight: bold; background: #d2ebf2 repeat-x; padding: 5px 0 5px 10px;"
			colspan="6">Radiology Records</td>
	</tr>
	<tr bgcolor="#CCCCCC">
		<td width=25% style="padding: 5px 0 5px 10px;">Radiology Test Name</td>
		<td width=30% style="padding: 5px 0 5px 10px;">Order Date</td>
		<td width=30% style="padding: 5px 0 5px 10px;">Result</td>
		<td width=20% style="padding: 5px 0 5px 10px;">Action</td>
	</tr>
	<?php 
	foreach($resultRadiology as $key=>$data){
					$radIdOrder[]=$data['RadiologyTestOrder']['id'];
					}
					foreach($RadiologyResultValues as $dataResult){
						$radIdResult[]=$dataResult['RadiologyResult']['radiology_test_order_id'];
					}
					foreach($resultRadiology as $key=>$data){
						if($toggle == 0) {
							$objHtml.= "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							$objHtml.= "<tr>";
							$toggle = 0;
						}
						?>
	<td style="padding: 5px 0 5px 10px;"><?php  echo $data["Radiology"]["name"]?>
	</td>
	<td style="padding: 5px 0 5px 10px;"><?php  echo $this->DateFormat->formatDate2Local($data["RadiologyTestOrder"]["radiology_order_date"],Configure::read('date_format'),true);?>
	</td>
	<?php if($data["RadiologyResult"]["img_impression"]!='Negative' &&($data["RadiologyResult"]["img_impression"])){
		$result='Normal';
	}else if(empty($data["RadiologyResult"]["img_impression"])){
							$result='Not Published';
						}else{
								$result='Abnormal';
										}?>
	<td style="padding: 5px 0 5px 10px;"><?php echo $result?></td>

	<td ><?php 
	$radId=$data[RadiologyTestOrder][id];
	echo $this->Html->image('icons/print.png',
								array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'radiologies','action'=>'investigation_print',$data['RadiologyTestOrder']['patient_id'],$data['RadiologyTestOrder']['batch_identifier']))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));

						echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')),
						array('controller'=>'radiologies','action' => 'deleteRadTest', $data['RadiologyTestOrder']['id']),
					    array('escape' => false),__('Are you sure?', true));

						echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit'
						)), "#", array('onclick'=>"edit_radorder($radId);",'escape' => false));
							if(in_array($radIdOrder[$key],$radIdResult)){
							//if($data['RadiologyTestOrder']['id']==$RadiologyResultValues[$key]['RadiologyResult']['radiology_test_order_id']){
								foreach($RadiologyResultValues[$key]['RadiologyReport'] as $subKey=>$filname){
								if(strpos($filname['file_name'], "tp://fujisyntestsrv") === false){
															$b[]=$filname['id'];
															$bImplode=implode(',',$b);

															?> <font color="#fff"><?php echo $this->Html->image('pathologyradiologyicons/RADIOLOGY 3 tick.png',array('onclick'=>"showImage('$bImplode')",'class'=>"view-large",'title'=>'RadiologyImage','alt'=>'RadiologyImage'),array('escape' => false,'style'=>'height: 28px; margin-top: -5px;'));?>
	</font> <?php }
	else{
$SubDisplayKey = $subKey + 1;
$toolTip = $data['RadiologyResult']['img_impression'];
echo $this->Html->link( "Radiology ".$SubDisplayKey, $filname['file_name'],array('class'=>'tooltip','title'=>$toolTip));

}
								}

								?> <?php 	}
								else{
							echo $this->Html->image('pathologyradiologyicons/RADIOLOGY 3.png',array('title'=>'RadiologyImage','alt'=>'RadiologyImage','style'=>'cursor: not-allowed; height: 28px; margin-top: -5px;'), array(), array('escape' => false));
							}?> <?php  unset($b);?>
	</td>
	</tr>
	<?php }
	?>
</table>
<?php }
?>


<script type="text/javascript">

			$(document).ready(function(){
			$( "#patient-info-acc" ).accordion({
				collapsible: true,
				autoHeight: false,
				clearStyle :true,	 
				navigation: true, 
				active:false
			});

			
			$('.tooltip').tooltipster({
		 		interactive:true,
		 		position:"left",
		 	});
			
			});
			</script>
<script>
				 function showImage(imgName){
				$
				.fancybox({
					'width' : '100%',
					'height' : '100%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "showRadImage")); ?>"
					+'/'+imgName,

				});
				}
				 function edit_radorder(id){
						$.fancybox({
							'width' : '70%',
							'height' : '70%',
							'autoScale' : true,
							'transitionIn' : 'fade',
							'transitionOut' : 'fade',
							'type' : 'iframe',
							'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "editRad")); ?>"
							+'/'+id,

						});
				}
				</script>
