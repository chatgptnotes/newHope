			<?php 	foreach($commanExpenseArrList as $accKey1 => $accExpVal){ ?>
								<ul>
										<li>
										<div class="subchildCls">
											<div class="subchldDiv1 subchild" ><?php echo ucfirst($accExpVal['acc_name']);?></div>
											<div style="float: right;"><?php 
												  if(!empty($accExpVal['exp_debit'])){
														$totalExpenseAmt=$accExpVal['exp_debit'];
												  }else{
												  		$totalExpenseAmt=$accExpVal['exp_credit'];
												  }		
													$totalAccAmt = number_format($totalExpenseAmt, 2);
													echo $totalAccAmt ;	
												 ?>
											</div>
										</div>
										</li>
									</ul>						
							<?php } //EOF account array foreach ?> 	