
<style>
	
	.filename{ 
		cursor:pointer;
	}
	
/**
 * for left element1
 */
.table_first{
 	margin-bottom: -20px;
 	
}

.td_second{
	border-left-style:solid; 
	padding-left: 25px; 
	padding-top: 32px;
	
}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
}

.black_line{
	padding-bottom: 10px;
	border-top: 1px solid #4C5E64;
}	

.table_format{
	padding: 0px;
	
}


.inner_t{
 	color: #1c7087;
    font-size: 14px;
    font-weight: bold;
}

.inner_title h3{
	padding: 5px;
}
.inner_title h3 {
    clear: both !important;
    float: left !important;
}

.inner_title p {
    margin: 0;
    padding-top: 6px;
}
/* EOCode */

</style>



<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));      
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js?ver=3.3','slides.min.jquery.js?ver=1.1.9',
									'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4')); ?>
									

<?php // DEBUG($data);EXIT;
  echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');
    
  if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
		<tr>
	  		<td colspan="2" align="left" class="error">
		   		<?php 
		     		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		   		?>
	  		</td>
	 </tr>
	</table>
<?php }
	if($this->params->query['type']=='OPD'){
		$urlType= 'OPD';
		$serachStr ='OPD';
		$searchStrArr = array('type'=>'OPD');
	}else if($this->params->query['type']=='emergency'){
		$urlType= 'emergency';
		$serachStr ='IPD&is_emergency=1';
		$searchStrArr = array('type'=>'IPD','is_emergency'=>1);
	}else if($this->params->query['type']=='IPD'){
		$urlType= 'IPD' ;
		$serachStr ='IPD&is_emergency=0' ;
		$searchStrArr = array('type'=>'IPD','is_emergency'=>0);
	}
	$queryStr =  $this->General->removePaginatorSortArg($this->params->query) ;
?>


<div class="inner_title" >
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Referral Mailbox >') ?>
	</h3>
	<p class="inner_t" >
		<?php echo __(' Summary'); ?>
	
	</p>
</div>

<table class="table_first" width="100%"  cellspacing='0' cellpadding='0'>
	<tr>
		<td valign="top" width="5%">
			<div class="mailbox_div">
				<?php echo $this->element('mailbox_index');?>
			</div> 
		</td>	
		<td class="td_second" >
<!-- 			<div class="mailbox_div" > -->
				<?php //echo $this->element('referral_icon');?>
<!-- 			</div>   -->
			<div class="" >
<!-- 				<div >	 
					<h3 class="title_format" style="padding: 12px;">-->
						<?php //echo __('Summary') ?>
<!-- 					</h3> -->
<!-- 				</div> -->
			
<!--				<h3 style="padding: 28px;" align="center">
 				Patient List -->
					<span style="padding-top:0px;float:right;">
					<?php 	echo $this->Html->link('Incorporate', 
											array('action'=>'searchParsePatient'),array('escape'=>false,'class'=>'blueBtn')); 
							 
					?>
				</span>
			<!-- </h3>  -->	
			</div>
			
			<?php echo $this->Form->create(null,array('action'=>'search','type'=>'get'));?>	
			
			<table border="0"  cellpadding="0" cellspacing="0" width="500px" align="center" >
				<tbody>
								    			 				    
					<tr class="row_title">				 
						<td class=" " align="right" width="7%"><label><?php echo __('DOB') ?> :</label></td>
						<td class=" " style="float: left; width: 150px; padding: 10px 0px;" width="7%">											 
					    	<?php 
					    		 echo    $this->Form->input('Person.dob', array('type'=>'text','class' =>'textBoxExpnd','id' => 'dob_search', 'label'=> false, 'div' => false, 'error' => false,'style'=>'','readonly'=>'readonly'));
					    	?>
					  	</td>	
						<td class=" " align="right" width="7%"><label><?php echo __('SSN') ?> :</label></td>
						<td class=" " width="7%">											 
					    	<?php 
					    		 echo    $this->Form->input('Person.ssn_us', array('type'=>'text','class' =>'textBoxExpnd','id' => 'ssn_us_search', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:130px'));
					    	?>
					  	</td>	
						<td class=" " align="right" width="7%"><label><?php echo __('Patient Name') ?> :</label></td> 
						<td class=" ">											 
					    	<?php 
					    		 echo $this->Form->hidden('type',array('value'=>$this->request->query['type'])); 
					    		 echo $this->Form->hidden('patientstatus',array('value'=>$this->params->query['patientstatus'])); 
					    		 echo    $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
					    	?>
					  	</td> 
						<td class=" " align="right" width="7%"><label><?php echo __('Patient ID') ?> :</label></td>
						<td class=" " width="7%">											 
					    	<?php 
					    		 echo    $this->Form->input('patient_id', array('type'=>'text','id' => 'patient_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
					    	?>
					  	</td>
					  	<td class=" " align="right" width="7%"><label><?php echo __('Visit ID') ?>:</label></td>
						<td class=" ">											 
					    	<?php 
					    		 echo    $this->Form->input('admission_id', array('type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
					    	?>
					  	</td>
					 				 
						
					 		 
						<td class=" " align="center" width="7%">
							<?php
								echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
							?>
						</td>
					 
					 </tr>	
										
				</tbody>	
			</table>	
			 <?php echo $this->Form->end();?>	
			
			 
			  <div  style="text-align:right;"> </div>
			 
			 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
			<?php  if(isset($data) && !empty($data)){
				
				 	 
						$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 
				?>
						
							  
							  <tr class="row_title">
							   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.discharge_date', __('DOB', true)); ?></strong></td>
							   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.discharge_date', __('SSN', true)); ?></strong></td>
							<td class="table_cell"><strong><?php echo $this->Paginator->sort('Person.first_name', __('Patient Name', true)); ?></strong></td>
							  
								   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.patient_id', __('Patient ID', true)); ?></strong></td>
			                        <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.admission_id', __('Visit ID', true)); ?></strong></td>
			                        <td class="table_cell" ><strong><?php echo $this->Paginator->sort('Consultant.name', __(Configure::read('doctor'), true)); ?></strong></td>
								     <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.patient_id', __('Department', true)); ?></strong></td> 
								   <td class="table_cell"  ><strong><?php echo  __('Form Received Date'); ?></strong></td> 
								   <td class="table_cell" colspan="3" ><strong><?php echo  __('Action'); ?></strong></td> 
							  </tr>
							  <?php 
							  	  $toggle =0;
							      if(count($data) > 0) {
							      		foreach($data as $patients){ 
										       if($toggle == 0) {
											       	echo "<tr class='row_gray'>";
											       	$toggle = 1;
										       }else{
											       	echo "<tr>";
											       	$toggle = 0;
										       }//debug($data);
											  ?>							
											  <td class="row_format"><?php echo substr($this->DateFormat->formatDate2Local($patients['Person']['dob'],Configure::read('date_format'),true),0,10); ?> </td>
												<td class="row_format"><?php echo $patients['Person']['ssn_us']; ?></td>	
											   <td class="row_format"><?php echo ucfirst($patients[0]['lookup_name']); ?> </td>
													  
											   <td class="row_format"><?php echo $patients['Patient']['patient_id']; ?></td>
											  <td class="row_format"><?php echo $patients['Patient']['admission_id']; ?> </td>
											  <td class="row_format" align="left"><?php echo $patients['Initial']['name']." ".$patients[0]['name']; ?> </td>	
											   <td class="row_format"><?php echo $patients['Department']['name']; ?> </td>
											   <td class="row_format" ><?php echo $this->DateFormat->formatDate2Local($patients['Patient']['form_received_on'],Configure::read('date_format'),true); ?> </td>
											  <td style="width: 30px;"><?php 
											  
											/*   if($patients['Patient']['admission_type']=='OPD'){
													$id =  $patients['Patient']['id']."-".$patients['Patient']['patient_id'] ;
											  		echo $this->Html->link($this->Html->image("icons/xml-icon.png",
													array('alt'=>'Generate CCDA','title'=>'Generate CCDA')),"#main-grid",array('id'=>$id,'class'=>"opd",'escape' => false ,'style'=>'display:block;'));
											  }else{ */
												  	echo $this->Html->link($this->Html->image("icons/xml-icon.png",
												  		array('alt'=>'Generate CCDA','title'=>'Generate CCDA')),array('controller' => 'ccda', 'action' => 'index',$patients['Patient']['id'],
														$patients['Patient']['patient_id'],"yes","yes"),array('escape' => false ,'style'=>'display:block;'));
											//  }
			
			
											 ?></td>  
													
												<?php  
												$filename = $patients['XmlNote']['filename'] ;
												if(empty($patients['XmlNote']['filename'])){
													$filename = $patients['XmlNote']['patients_e2_filename'] ;
												}
												$file = "files".DS."note_xml".DS.$filename.".xml" ;
												 
												if(!empty($filename) && file_exists($file)){ ?>
											 	<td style="width: 30px;"><?php 
											 	echo $this->Html->link($this->Html->image("icons/view-icon.png",array('alt'=>'View CCDA','title'=>'View CCDA')),'#',
												array('onclick'=>"view_consolidate_ccda('".$patients['Patient']['id']."')",'escape' => false,'style'=>'display:block;' )); ?> 
											  </td> 
											  <td style="width: 30px;">
											  <?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download CCDA','title'=>'Download CCDA','width'=>'20','height'=>'18')),
											  		array('action'=>'downloadXml',$patients['Patient']['id']),array('escape'=>false ,'style'=>'display:block;')); ?>
											  </td>
											  
											  <?php }else{ ?>
											  	 <td style="padding-top: 8px;width: 30px;" colspan="2"> </td>
											  <?php } ?>
											 <!--  <td><strong><label><a href="#" id="<?php // echo $patients['Patient']['id'];?>" class="transmit">Transmit</a> </label></strong></td> -->
								  </tr>
								  <?php } 
								 		$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 	
								   ?>
								   <tr>
								    <TD colspan="8" align="center">
								    <!-- Shows the page numbers -->
								 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
								 <!-- Shows the next and previous links -->
								 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
								 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
								 <!-- prints X of Y, where X is current page and Y is number of pages -->
								 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
								    </TD>
								   </tr>
						<?php } ?> <?php					  
						      } else {
						 ?>
						  <tr>
						   <TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
						  </tr>
						  <?php
						      }
						  ?>
					  
					 </table>
					 <div class="clr">&nbsp;</div>
			</td>
		</tr>
	</table>		 

		 
		 <script>
	
//---------view ccda-----
	$(function() {
			$("#dob_search").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>', 
		});
		});

			function view_consolidate_ccda(id) {
				
				// id= $(this).attr("id");
				 
				 $.fancybox({ 
									'width' : '85%',
									'height' : '100%',
									'autoScale' : true,
									'transitionIn' : 'fade',
									'transitionOut' : 'fade',
									'type' : 'iframe',
									'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "view_consolidate")); ?>"
									+ '/' + id 
									});
					
			/*	 var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "ccda", "action" => "isCcdaGenerated","admin" => false)); ?>";
			        $.ajax({
			          type: 'POST',
			          url: ajaxUrl+"/"+id,
			          data: '',
			          dataType: 'html',
			          success: function(data){
				           
							if(data==1){
								$.fancybox({ 
									'width' : '85%',
									'height' : '100%',
									'autoScale' : true,
									'transitionIn' : 'fade',
									'transitionOut' : 'fade',
									'type' : 'iframe',
									'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "view_consolidate")); ?>"
									+ '/' + id 
									});
							}else{
								alert("Please generate CCDA and try again");
								return false ;
							}
					  },
					  error: function(message){
			              alert(message);
			          }        
			       });*/


			          return false ;

			          
			/*	$.fancybox({

				'width' : '85%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "view_consolidate")); ?>"
				+ '/' + patient_id 
				});*/

			 }

//Transmit Ccda
			

			


			$(document).ready(function(){
		    	 
				$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null','null','null','admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});
				$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});
				$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});

				$(".transmit").click(function(){
					 id= $(this).attr("id");
					 
					 var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "ccda", "action" => "isCcdaGenerated","admin" => false)); ?>";
				        $.ajax({
				          type: 'POST',
				          url: ajaxUrl+"/"+id,
				          data: '',
				          dataType: 'html',
				          success: function(data){
								if(data){
									$.fancybox({

										'width' : '60%',
										'height' : '50%',
										'autoScale' : true,
										'transitionIn' : 'fade',
										'transitionOut' : 'fade',
										'type' : 'iframe',
										'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "transmit_ccda")); ?>"
										+ '/' + id 
										});
								}else{
									alert("Please generate CCDA first.");
									return false ;
								}
						  },
						  error: function(message){
				              alert(message);
				          }        
				       });


				          return false ;
				
				});

				 $(".opd").click(function(){
					 data = $(this).attr('id');
					 splittedData = data.split("-") ;					 
					 $.fancybox({

							'width' : '60%',
							'height' : '75%',
							'autoScale' : true,
							'transitionIn' : 'fade',
							'transitionOut' : 'fade',
							'type' : 'iframe',
							'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "clinical_summary")); ?>"
							+ '/' + splittedData[0]+"/"+splittedData[1] 
							});
				 }); 
		 	}); 
</script>
