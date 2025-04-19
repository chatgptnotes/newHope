				<?php foreach($commanIncomeArrList as $accKey3 => $accExpVal){  ?>
								<ul >
										<li>
										<div class="subchildCls">
											<div class="subchldDiv1 subchild" ><?php echo ucfirst($accExpVal['acc_name']);?></div>
											<div style="float: right;"><?php if(!empty($accExpVal['income_debit'])){
														$totalIncomeAmt=$accExpVal['income_debit'];
												  }else{
												  		$totalIncomeAmt=$accExpVal['income_credit'];
												  }			
													$totalAccAmt = number_format($totalIncomeAmt, 2);
													echo $totalAccAmt ;																					
													
												 ?>
											</div>
										</div>
										</li>
									</ul>
							<?php	} //EOF IF ?> 
							 