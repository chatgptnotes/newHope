

<?php
//List of XML files to be imported
echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css')); 
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js?ver=3.3','slides.min.jquery.js?ver=1.1.9',
		'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4','jquery.autocomplete')); 
 
?>
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
	
}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
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

<?php   
if($this->params->query['directEmail'] == 'noset'){ ?>
<div  style= 'text-align:center;' >
<?php 
	echo $this->Html->link('Click here to set direct address',array('controller'=>'users','action'=>'edit',$this->Session->read('userid'),'admin'=>true),array('escape'=>false));
?></div>
<?php } ?>

<div class="inner_title" >
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Referral Mailbox >') ?>
	</h3>
	<p class="inner_t" >
		<?php echo __(' Inbox'); ?>
	</p>
</div>

<table class="table_first" width="100%"  cellspacing='0' cellpadding='0' >
	<tr>
		<td valign="top" width="5%" >
			<div class="mailbox_div">
				<?php echo $this->element('mailbox_index');?>
			</div>
			
		</td>
		
		<td class="td_second" style="padding-top: 20px;">
			
			
			
			
			<div class="" >
			
				
				<!--  Transition Of Care/Summary Of Care Record Received-->
					<span style="float:right" ><?php // echo $this->Html->link(__('Back'),array("controller" => "messages", "action" => "ccdaMessage"),array('escape'=>false,'class'=>'blueBtn')); 
						echo $this->Html->link($this->Html->image('icons/refresh-icon.png',array('alt'=>'Refresh List','title'=>'Refresh List')),array('action'=>'imapCcda'),array('escape'=>false)); 
					?>
					</span>
				
				
			</div>
			<div class="clr">&nbsp;</div>
			
			<?php echo $this->Form->create('Patient',array('action'=>'search','type'=>'get'));?>
			<!-- <div> -->
				<table style="width:200px;">
					
					<?php 
						 /* foreach ($files as $xml){	
							$pos = strpos($xml, ".xml");
							if($pos === false) continue ;
							echo "<tr>";
							echo "<td class='filename'  style = 'text-decoration:underline;'>".$xml."</td>" ;
							//echo '<td style="display:inline">'.$this->Html->link($this->Html->image('icons/view-icon.png'),array('action'=>'view_received_ccda',$xml),array('escape'=>false)).'</td>';
							echo '<td style="display:inline">'.$this->Html->image('icons/view-icon.png',array('onclick'=>'view_consolidate_ccda(\''.$this->Html->url(array('action'=>'view_received_ccda',$xml)).'\')','escape'=>false)).'</td>';
							echo "<tr>" ; 
						}  */
					?>
					</tr>
				</table>
				
				<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
				<?php  if(isset($data) && !empty($data)){
					$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
					?>
				
				<tr class="row_title">
					<td class="table_cell"><strong><?php echo __('From') ?> </strong></td>
					<td class="table_cell"><strong><?php echo __('From Address') ?> </strong></td>
					<td class="table_cell"><strong><?php echo __('Subject ') ?> </strong> </td>
					<!-- <td class="table_cell"><strong><?php // echo __('XML File Name') ?> </strong> </td> -->
					<td class="table_cell" colspan="2"><strong><?php echo __('Action') ?> </strong> </td>
				</tr>
									 <?php 
										 $toggle =0;
										if(count($data) > 0) {
							      		foreach($data as $details){
										       if($toggle == 0) {
											       	echo "<tr class='row_gray'>";
											       	$toggle = 1;
										       }else{
											       	echo "<tr>";
											       	$toggle = 0;
										       } 
										       ?>
				<td class="row_format">&nbsp;<?php echo $details['IncorporatedPatient']['fromName'] ?></td>
					<td class="row_format">&nbsp;<?php echo $details['IncorporatedPatient']['fromAddress'] ?></td>
					<td class="row_format">&nbsp;<?php echo $details['IncorporatedPatient']['subject'] ?></td>
					<!-- <td class="row_format">&nbsp;<?php // echo $details['IncorporatedPatient']['xml_file'];?></td> -->
					
					<?php  
					 
						echo '<td class="row_format" style="display:inline">'.$this->Html->image('icons/view-icon.png',
						array('onclick'=>'view_consolidate_ccda(\''.$this->Html->url(array('action'=>'view_received_ccda',$details['IncorporatedPatient']['xml_file'],$details['IncorporatedPatient']['id'])).'\')',
						'escape'=>false)).'</td>'; 
					 
				
				?>
				
				<td >&nbsp;<?php 
					if($details["IncorporatedPatient"]["patient_id"]){
						echo "Incorporated" ;	
					}else{
						echo $this->Html->link(__('Incorporate'),"#",array('escape'=>false,'class'=>'blueBtn','onclick'=>"incorporate('".$details["IncorporatedPatient"]["id"]."')")) ;
					}
				?></td>
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
			</td>
		</tr>
	</table>
	
	
<!-- </div> -->
<script>

	function incorporate(id){
	$.fancybox({ 
		'width' : '85%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "searchParsePatient")); ?>"+ '/null/' + id 
	}); 
	}
 
//---------view ccda-----
	

			function view_consolidate_ccda($url) { 
				$.fancybox({ 
					'width' : '85%',
					'height' : '100%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : $url 
				});
			}


			
	
</script>
