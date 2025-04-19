
<style>
	
	.filename{ 
		cursor:pointer;
	}
	
/**
 * for left element1
 */
.table_first{
 	margin-bottom: -20px;
	/*overflow:hidden;
	position:relative;*/
 	
}

.td_second{
	border-left-style:solid; 
	padding-left: 25px; 
	padding-top: 19px;
}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
}

.black_line{
	padding-top: 15px;
	border-top: 1px solid #4C5E64; 
}
.table_format{
	padding: 0px;
}

.table_format td {
    line-height: 22px;
	padding-bottom: 1px !important;
}

.inner_t{
 	color: #1c7087;
    font-size: 14px;
    font-weight: bold;
}
.inner_title span {
    float: left !important;
    margin:0 !important;
    padding: 0;
}

.inner_title h3{
	padding: 5px;
}

.inner_title h3 {
    clear: both !important;
    float: left !important;
	padding:-5px !important;
}
.inner_title p{padding-top: 6px; margin:0px;}
.stable{ position:absolute; left:0px; right:0px; top:129px; overflow:hidden;}
label{ padding-top:2px !important;}
/* EOCode */

</style>


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
		<?php echo __(' Compose'); ?>
	
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
				<?php //echo $this->element('referral_icon');?>
<!-- 			</div> -->
			
<!-- 			<span > -->
					<?php 	echo $this->Html->link('Incorporate', 
											array('action'=>'searchParsePatient'),array('escape'=>false,'class'=>'blueBtn')); 
							 
					?>
<!-- 				</span> -->
				
<!-- 				<span>  -->
					<?php // echo $this->Html->link(__('Back'),array('controller'=>'messages','action'=>'ccdaMessage'),array('escape'=>false,'class'=>'blueBtn'));?>
<!-- 				</span> -->
			</div>
			
			<?php echo $this->Form->create(null,array('action'=>'patientList','type'=>'get'));?>	
			<table border="0"  cellpadding="0" cellspacing="0" width="500px" align="center" class="">
				<tbody>
								    			 				    
					<tr class="row_title">				 
						
						<td class=" " align="right" width=" "><label><?php echo __('Patient Name') ?> :</label></td> 
						<td class=" ">											 
					    	<?php 
					    		 echo $this->Form->hidden('type',array('value'=>$this->request->query['type'])); 
					    		 echo $this->Form->hidden('patientstatus',array('value'=>$this->params->query['patientstatus'])); 
					    		 echo    $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
					    	?>
					  	</td> 
						<td class=" " align="right"><label><?php echo __('Patient ID') ?> :</label></td>
						<td class=" ">											 
					    	<?php 
					    		 echo    $this->Form->input('patient_id', array('type'=>'text','id' => 'patient_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
					    	?>
					  	</td>
					  	<td class=" " align="right"><label><?php echo __('Visit ID') ?>:</label></td>
						<td class=" ">											 
					    	<?php 
					    		 echo    $this->Form->input('admission_id', array('type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px;margin: 0 10px 0 0px;'));
					    	?>
					  	</td>
					 				 
						
					 		 
						<td class=" " align="center"  >
							<?php
								echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
							?>
						</td>
					 </tr>	
										
				</tbody>	
			</table>	
			 <?php echo $this->Form->end();?>	
			
			 
			  <div class="clr " style="text-align:right;"> </div>
			  
			 
			 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style=" border:1px solid #000;">
			 
			<?php if(isset($data) && !empty($data)){
				
				
				//set get variables to pagination url 
				 	 	 
						$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 
				?>
						
							  
							  <tr class="row_title">
							  
								   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.patient_id', __('Patient ID', true)); ?></strong></td>
								   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Person.first_name', __('Patient Name', true)); ?></strong></td>
			                        <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.admission_id', __('Visit ID', true)); ?></strong></td>
								   <td class="table_cell" ><strong><?php echo  __('Action'); ?></strong></td> 
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
										       }
											  ?>								  
											   <td class="row_format"><?php echo $patients['Patient']['patient_id']; ?></td>
											   <td class="row_format"><?php echo ucfirst($patients[0]['lookup_name']); ?> </td>
											  <td class="row_format"><?php echo $patients['Patient']['admission_id']; ?> </td>
											   <td style="" ><?php echo $this->Html->link(__('Pick'), array('controller' => 'Messages', 'action' => 'composeCcda', $patients['Patient']['id'],'?'=>array('returnUrl'=>'patientList')), array('escape' => false,'class'=>'blueBtn'));?>
											 <!-- commented by gulshan   -->
											  <!-- <?php //if(!empty($patients['XmlNote']['filename'])){ ?>
											  <td style="padding-top: 10px" ><?php //echo $this->Html->link(__('Pick'), array('controller' => 'Messages', 'action' => 'composeCcda', $patients['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));?>
											  <?php // }else{?>
											  <td style="padding-top: 10px" ><?php //echo $this->Html->link(__('Pick'), "#", array('onclick'=>"javascript:alert('CCDA is not generated !!');return false ;",'escape' => false,'class'=>'blueBtn'));?>
											  <?php //}?> -->
											  <!-- EOF -->
											  <?php echo $this->Html->link(__('Send Manual Referral'), array('controller' => 'Patients', 'action' => 'patient_referral', $patients['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));?></td>
											  </tr>
								  <?php } 
								 		$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 	
								   ?>
								   
								   <tr>
								    <TD colspan="8" align="center">
								    <div class="clr">&nbsp;</div>
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
				 
		 	});
		 	

	
</script>
