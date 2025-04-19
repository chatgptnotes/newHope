<style>
/*img {
    border: 0 none;
    cursor: pointer;
    float: none !important;
}*/
.textAlign {
	text-align: center;
	font-size: 12px;
	padding-right: 0px;
	padding-center: 0px;
}

/*.td_ht {
	line-height: 18px;
	
}*/
.table_format1 td {
padding-bottom: 3px;
padding-right: 10px;
/* font-size: 13px; */
}

.vitalImage {
  background:url("<?php echo $this->webroot ?>img/icons/vital_icon.png") no-repeat center 2px;  
  cursor: pointer;
}
.maleImage {
  background:url("<?php echo $this->webroot ?>img/icons/male.png") no-repeat center 2px;  
  cursor: pointer;
  text-align: center !important;
  /*float: center;*/
}
.femaleImage {
  background:url("<?php echo $this->webroot ?>img/icons/female.png") no-repeat center 2px;  
  cursor: pointer;
  text-align: middle !important;
}
select {
	/* background: none repeat scroll 0 0 #121212; */
	border: 0.100em solid;
	border-radius: 25px;
	border-color: olive;
	color: #E7EEEF;
	font-size: 13px;
	outline: medium none;
	padding: 5px 7px;
	resize: none;
}
.light:hover {
background-color: #F7F6D9;
/* text-decoration:none;
color: #000000; */
}

.discharge_red{
		background-color: pink ;
}



</style>

<?php $role = $this->Session->read('role');?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="table_format1 textAlign">
	<tr style="text-align: center;">
		<td colspan="14">
			<!-- Shows the next and previous links --> <?php 

			if(empty($this->request->data['User']['All Doctors'])){
				$queryStr =   array('doctor_id'=>$paginateArg) ;
			}else{
				$queryStr =  array('doctor_id'=>$this->request->data['User']['All Doctors']) ;
			}
			
			if($data){
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			}

			echo	$this->Paginator->options(array(
					'update' => '#content-list',
					'evalScripts' => true,
					'before' => "loading();",'complete' => "onCompleteRequest();",
					'url' =>array("?"=>$queryStr)
					//'convertKeys'=>array($this->request->data['User']['All Doctors'])
			));

	   ?>
			<!-- Shows the next and previous links --> <?php 
			echo $this->Paginator->first(__('« First', true),array('class' => 'paginator_links'));
			echo $this->Paginator->prev(__('« Previous', true),array('class' => 'paginator_links'));
			echo $this->Paginator->numbers(array('update'=>'#content-list'  ));
			echo $this->Paginator->next(__('Next »', true),array('class' => 'paginator_links'));
			echo $this->Paginator->last(__('Last »', true),array('class' => 'paginator_links'));
		
			/* echo $this->Paginator->prev(__('« Previous', true),array('class' => 'paginator_links'));
			echo $this->Paginator->next(__('Next »', true),array('class' => 'paginator_links')); */
			?> <!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>
		</td>
	</tr>
	<tr class="row_title">		
		<td width="10%" valign="top" class="table_cell" align="left"><?php  
				echo $this->Paginator->sort('Patient.lookup_name', __('Patient', true),array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));	?></td>
		<td width="10%" valign="top" class="table_cell" align="center">Patient Id</td>		
		<td width="5%" valign="top" class="table_cell" align="center">Age</td>
		<td width="5%" valign="top" class="table_cell" align="center">Gender</td>
		<td width="10%" valign="top" class="table_cell" align="center">Tariff</td>
		<td width="20%" valign="top" class="table_cell" align="center">Radiology Services</td>
		<td width="10%" valign="top" class="table_cell" align="center">Req Date</td>
		<td width="10%" valign="top" class="table_cell" align="center">Req By</td>
		<td width="5%" valign="top" class="table_cell" align="center">SOAP</td>
		<td width="5%" valign="top" class="table_cell" align="center">Documents</td>
		<td width="5%" valign="top" class="table_cell" align="center">Print Report</td>
		<td width="10%" valign="top" class="table_cell" align="center">View Dicom Viewer</td>
		
	</tr>
	<?php 
	$i=0;
	$currentWard =0;
	//count no of bed per ward
	$level = array(1=>'I','2'=>'II','3'=>'III','4'=>'IV','5'=>'V');
	$status = array('Admitted'=>'Admitted','Posted For Surgery'=>'Posted For Surgery','Operated'=>'Operated','Discharged'=>'Discharged');
	//debug($data);
if($data){
$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
}
                     	$totalBed = count($data);
                     	$booked = 0;
                     	$male =0;
                     	$female=0;
                     	$waiting=0;
                     	$maintenance =0;
                     	$i=0;
						//print_r($data);
                     	foreach($data as $wardKey =>$wardVal){// debug($wardVal);

	
	?>
	<tr  <?php 
	
	if($i%2 == 0) {
		if($wardVal['Patient']['Patient']['is_discharge']=='1'){
				echo "class='discharge_red light'";
		}else{
				echo "class='row_gray light'";
		}
					
	}else {
		if($wardVal['Patient']['Patient']['is_discharge']=='1'){
			echo "class='discharge_red light'";
		}else{
			echo "class='light'";
		}
	} ?>>
		<?php  

		echo $this->Form->create('User',array('url'=>array('controller'=>'User','action'=>'update_patient'),'default'=>false,'inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )) );
			?>
		
						
		
			
		
		<td align="left" class="td_ht" valign="top" style="text-align: left;">
			<?php
			echo ucwords($wardVal['Patient']['Patient']['lookup_name']);
			//$this->Html->link(ucwords(strtolower($wardVal['Patient']['Patient']['lookup_name'])),array('controller'=>'Persons','action'=>'patient_information',$wardVal['Patient']['Patient']['person_id'],'?'=>"flag=1"),		array('style'=>'text-decoration:underline;padding:2px 0px;'));
			

			

		?>
		</td>
		<td valign="top" style="text-align: center;"><?php echo $wardVal['Patient']['Patient']['admission_id']?>
		</td>
		<td valign="top" style="text-align: center;"><?php echo $this->General->getCurrentAge($wardVal['Patient']['Person']['dob'])?>
		</td>
		<?php 
		if(strtolower($wardVal['Patient']['Person']['sex'])=='male'){
			echo '<td class="td_ht maleImage" valign="middle" style="text-align: center;"></td>';
		}
		if(strtolower($wardVal['Patient']['Person']['sex'])=='female'){
			echo '<td class="td_ht femaleImage" valign="middle" style="text-align: center;"></td>';
		}
		if($wardVal['Patient']['Person']['sex']==''){
			echo '<td class="td_ht" valign="middle" style="text-align: center;">&nbsp;</td>';
			}?>
		<td valign="top" style="text-align: center;"><?php 
		         echo $wardVal['Patient']['TariffStandard']['name'];?>
		</td>
		<td valign="top" style="text-align: left;"><?php 
				$radiolgyIdsNew=array();
				unset($getRadiologyServicesUnserialized);
				unset($newRadServiceArr);
				if(count($wardVal['Patient']['PatientDocument'])>0){
		        	foreach ($wardVal['Patient']['PatientDocument'] as $key => $value) {		        		
		        		$getRadiologyServicesUnserialized=unserialize($value['document_id']);		        		
		        		foreach($getRadiologyServicesUnserialized as $radiologyIds){
		        			$newRadServiceArr[]=$radiologyIds;
		        		}
		        	}			
			    }			    	   
			    foreach($newRadServiceArr as $radiologyIds){			    	
			    	if(!empty($radiologyServices[$radiologyIds])){?>
		        			<li><?php echo $radiologyServices[$radiologyIds];?></li>
		  <?php 	}
		  		} ?>
		</td>

		<td valign="top" style="text-align: center;"><?php 
		         echo $this->DateFormat->formatDate2Local($wardVal['Patient']['ExternalRequisition']['created_time'],Configure::read('date_format'),true);?>
		</td>
		
		<td valign="top" style="text-align: center;"><?php echo $wardVal['Patient']['User']['first_name']." ".$wardVal['Patient']['User']['last_name'];?>
		</td>	
		<td valign="top"><?php 
		if(isset($wardVal['Patient']['Note']['id']) && !empty($wardVal['Patient']['Note']['id'])){
			echo $this->Html->link($this->Html->image('icons/green.png',array()),array('controller'=>'Notes','action'=>'soapNote',$wardVal['Patient']['Patient']['id'],$wardVal['Patient']['Note']['id']),array('id'=>$wardVal['Patient']['Patient']['id'],'escape'=>false,'title'=>'Documentation Complete'));
		}else{
			echo $this->Html->link($this->Html->image('icons/red.png',array()),array('controller'=>'Notes','action'=>'soapNote',$wardVal['Patient']['Patient']['id']),array('id'=>$wardVal['Patient']['Patient']['id'],'escape'=>false,'title'=>'Documentation Complete'));
		}
		?>
		 </td>
		<?php 	
		if(count($wardVal['Patient']['PatientDocument'])>0){
					$getImgFlag="green.png";					
			  	}else{
					$getImgFlag="red.png";
			 	}?>
		<td valign="top"><?php 
		 echo $this->Html->link($this->Html->image('icons/'.$getImgFlag,array('title'=>'Documents Upload','style'=>'float: none !important;border: 0 none;cursor: pointer;')),array("controller" => "PatientDocuments", "action" => "index",$wardVal['Patient']['Patient']['id'],"admin" => false),array('escape'=>false,'class'=>'d_board'));?>
		 </td>
		 <td valign="top" align="center">
		<?php //debug($wardVal['Patient']['PatientDocument']);
		foreach ($wardVal['Patient']['PatientDocument'] as $key => $value) {	
				$getRadTestOrderId=unserialize($value['rad_test_order_id']);		
				if(!empty($getRadTestOrderId[0])){
					$radID=$getRadTestOrderId[0];
				}else{
					$radID=$getRadTestOrderId[1];
				}
			  	if(!empty($value['note'])){					
					 echo $this->Html->link($this->Html->image('icons/printer_mono.png',array('style'=>'float: none !important;border: 0 none;cursor: pointer;')),'javascript:void(0)',array('escape' => false,'title'=>'Print with Header',
						'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_preview',$wardVal['Patient']['Patient']['id'],$value['id'],$radID,'?'=>'flag=print_with_header')).
						"', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
			  	}			
		}?>
		</td>	
		
		<td valign="top">
		<?php 
	
				if(!empty($wardVal['Patient']['Patient']['studyuid'])){
						$getImgFlag1="green.png";
						$title="Dicom image available";
						$stdID=$wardVal['Patient']['Patient']['studyuid']; 
						$otherParams=urlencode($wardVal['Patient']['Patient']['lookup_name']."_(".$this->General->getCurrentAge($wardVal['Patient']['Person']['dob']).")_".date("d-m-Y")."_".date("H:i"));
			?>
			<!-- <a href="<?php echo $_SERVER['HTTP_SERVER']?>../PatientDocuments/patientAllDld/<?php echo $stdID?>/<?php echo $otherParams?>"><img src="<?php echo $this->webroot?>theme/Black/img/icons/<?php echo $getImgFlag1?>" title="<?php echo $title?>" alt="" title="<?php echo $title?>"  style="float: none !important;" target="_blank" id="<?php echo $stdID?>"></a> -->
			 <img src="<?php echo $this->webroot?>theme/Black/img/icons/<?php echo $getImgFlag1?>" title="<?php echo $title?>" alt="" title="<?php echo $title?>"  style="float: none !important;" target="_blank"  class ="showAllStudies" id="<?php echo $wardVal['Patient']['Patient']['admission_id']?>" patientfk="<?php echo $wardVal['Patient']['Patient']['patientfk']?>">

			<?php  
				}else{
						$getImgFlag1="red.png";
						$title="Dicom image not available";
						$stdID='0';
			?>
			<img src="<?php echo $this->webroot?>theme/Black/img/icons/<?php echo $getImgFlag1?>" title="<?php echo $title?>" alt="" title="<?php echo $title?>"  style="float: none !important;" id="<?php echo $stdID?>">
			<?php 	}

			?>
		</td>
		

		<?php echo $this->Form->end(); ?>
	</tr>
	<?php  $i++; 
} ?>
	<tr style="text-align: center;">
		<td colspan="14">
		<?php $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));?>
			<!-- Shows the next and previous links --> <?php 
			echo $this->Paginator->first(__('« First', true),array('class' => 'paginator_links'));
			echo $this->Paginator->prev(__('« Previous', true),array('class' => 'paginator_links'));
			echo $this->Paginator->numbers(array('update'=>'#content-list'  ));
			echo $this->Paginator->next(__('Next »', true),array('class' => 'paginator_links'));
			echo $this->Paginator->last(__('Last »', true),array('class' => 'paginator_links'));
			?> <!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>
		</td>
	</tr>
	<?php  
	echo $this->Js->writeBuffer();
	
	echo $this->Form->hidden('Patientsid',array('id'=>'Patientsid')) ;
	?>

</table>


<div id="no_app">
	<?php
	if(empty($data)){
			echo "<span class='error'>";
			echo __('No record found.');
			echo "</span>";
		}
		?>
</div>

<script>
	$( document ).ready(function () {
		$('.tooltip').tooltipster({
	 		interactive:true,
	 		position:"right", 
	 	});

		$('select').hover(function() {
			var value=$(this).val();
			this.title = this.options[this.selectedIndex].text; 
		})
	 });
	 function openplainimage(url)
	 {
	  
	   window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=1000,left=200,top=200"); 
	 }
	 $('.downloadClass').click(function(){
		var studyID=$(this).attr('id'); 
		$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => 'PatientDocuments', "action" => "patientAllDld","admin" => false)); ?>"+"/"+studyID,
		  context: document.body,	   
		  beforeSend:function(){
		    loading();
		  }, 	  		  
		  success: function(data){				 
			 // $('#busy-indicator').hide('fast');
			$('#content-list').html(data).fadeIn('slow');
			//$('#content-list').unblock();  
		  }
	});
	});
	 $(".showAllStudies").click(function(){
	 
	var id = $(this).attr('id');
	var patientfk = $(this).attr('patientfk');
	$.fancybox({
		'width' : '100%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'onClosed':function(){
			//getSpecial();
			//window.location.reload();
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "PatientDocuments", "action" => "showAllStudies")); ?>"
				 + '/' + id + '/' + patientfk,
		
	});
	$('html, body').animate({ scrollTop: 0 }, 'slow', function () {
    });
});
</script>
