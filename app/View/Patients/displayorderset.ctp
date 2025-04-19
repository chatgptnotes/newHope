<tr>
							<td width="25%" valign="top">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td><b> <?php echo ('Lab')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetLab);$i++){
											$labData[]=$dataOrderSetLab[$i]['OrderSetLab']['name'];
									}

									if(!empty($dataOrderSetLab)){
									foreach($dataOrderSetLab as $lab_datas){
											if(in_array($lab_datas['OrderSetLab']['name'],$selectedLab)){
															$checkedLab= "checked";
																	}
																	else {
														$checkedLab= "checked";
														}
														//echo $this->Form->input("test", array("type" => "checkbox"));echo $lab_datas['OrderSetLab']['name'];
														echo $this->Form->input("Laboratory.name", array("type" => "checkbox","label"=>false,"div"=>false,"checked"=>$checkedLab,'hiddenField'=>false,'name'=>'data[Laboratory][name][]',
									'class'=>given_medi,'value'=>$lab_datas['Laboratory']['name']));echo $lab_datas['Laboratory']['name']."<br/>";
                                        echo $this->Form->input("Laboratory.loinc_code", array("type" => "hidden","value"=>$lab_datas['Laboratory']['lonic_code'],'name'=>'data[Laboratory][loinc_code][]'));
                                        echo $this->Form->input("Laboratory.cpt_code", array("type" => "hidden","value"=>$lab_datas['Laboratory']['cpt_code'],'name'=>'data[Laboratory][cpt_code][]'));
									}
									}
									else 
									{
										echo "No lab found";
										
									}
									
									?></td>
									</tr>								

								</table>
							</td>
							<td width="25%" valign="top"><table width="100%" cellpadding="0"
									cellspacing="0" border="0">
									<tr>
										<td><b> <?php echo ('Medication')."<br/>";?>
										</b>
									<?php 
									
									for($i=0;$i<count($dataOrderSetMed);$i++){
											$medData[]=$dataOrderSetMed[$i]['OrderSetMed']['name'];
									}


									?>

									<?php 
									if(!empty($dataOrderSetMed)){
									foreach($dataOrderSetMed as $phar_datas){
											if(in_array($phar_datas['OrderSetMed']['name'],$selectedMed)){
												$checkedMed= "checked";
											}
											else 
                                            {
											   $checkedMed= "checked";
											}
											echo $this->Form->input("NewCropPrescription.description", array("type" => "checkbox","label"=>false,"div"=>false,"checked"=>$checkedMed,'hiddenField'=>false,'name'=>'data[NewCropPrescription][description][]','class'=>given_medi,'value'=>$phar_datas['OrderSetMed']['name']));echo $phar_datas['OrderSetMed']['name']."<br/>";
											echo $this->Form->input("NewCropPrescription.rxnorm_code", array("type" => "hidden","value"=>$phar_datas['OrderSetMed']['rxnorm_code'],'name'=>'data[NewCropPrescription][rxnorm_code][]'));
	
									}
									
									}
									else
									{
										echo "No medication found";
										
									}
									?>
                                    </td>
									</tr>								
									
									
								</table></td>
							<td width="25%" valign="top"><table width="100%" cellpadding="0"
									cellspacing="0" border="0">
									<tr>
										<td id="lowback"><b> <?php echo ('Radiology')."<br/>";?>
										</b> <?php 
										for($i=0;$i<count($dataOrderSetMed);$i++){
											$radData[]=$dataOrderSetMed[$i]['OrderSetRad']['name'];
									}


									?> <?php
									if(!empty($dataOrderSetRad)){
									foreach($dataOrderSetRad as $rad_datas){
													if(in_array($rad_datas['OrderSetRad']['name'],$selectedDataRad)){
															//debug(in_array($rad_datas['OrderSetRad']['name'],$selectedRad));
															$checkedRad= "checked";
														}
														else {
														$checkedRad= "checked";
													}
													
													echo $this->Form->input("Radiology.name", array("type" => "checkbox","label"=>false,"div"=>false,"checked"=>$checkedRad,'hiddenField'=>false,'name'=>'data[Radiology][name][]','class'=>given_medi,'value'=>$rad_datas['Radiology']['name']));echo $rad_datas['Radiology']['name']."<br/>";
													echo $this->Form->input("Radiology.loinc_code", array("type" => "hidden","value"=>$rad_datas['Radiology']['loinc_code'],'name'=>'data[Radiology][loinc_code][]'));
                                                    echo $this->Form->input("Radiology.cpt_code", array("type" => "hidden","value"=>$rad_datas['Radiology']['cpt_code'],'name'=>'data[Radiology][cpt_code][]'));
                                                    echo $this->Form->input("Radiology.id", array("type" => "hidden","value"=>$rad_datas['Radiology']['id'],'name'=>'data[Radiology][id][]'));
													

									}
									}
									else
									{
										echo "No radiology found";
									
									}								
									?>
										</td>

									</tr>
									
								</table></td>
								
								<td width="25%" valign="top"><table width="100%" cellpadding="0"
									cellspacing="0" border="0">
									<tr>
										<td><b> <?php echo ('EKG')."<br/>";?>
										</b></td>
									</tr>
									<?php 
									for($i=0;$i<count($dataOrderSetEkg);$i++){
											$ekgData[]=$dataOrderSetEkg[$i]['OrderSetEkg']['name'];
									}


									?>
									<?php 
									if(!empty($dataOrderSetEkg)){
									foreach($dataOrderSetEkg as $ekg_datas){


											if(in_array($ekg_datas['OrderSetEkg']['name'],$selectedMed)){

												$checkedEkg= "checked";
											}
											else {
													$checkedEkg= "checked";
											}
											echo "<tr><td>".$this->Form->input("Ekg.name", array("type" => "checkbox","label"=>false,"div"=>false,"checked"=>$checkedEkg,'hiddenField'=>false,'name'=>'data[Ekg][name][]','class'=>given_medi,'value'=>$ekg_datas['OrderSetEkg']['name']));echo $ekg_datas['OrderSetEkg']['name']."</td></tr>";
											echo $this->Form->input("Ekg.code", array("type" => "hidden","value"=>$ekg_datas['OrderSetEkg']['code'],'name'=>'data[Ekg][code][]'));
                         
											
									}
									}
									else
									{
										echo "No EKG found";
											
									}
									?>
								</table></td>
							
						</tr>