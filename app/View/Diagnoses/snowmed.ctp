<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>
<style>
.removepadding{
padding:0px;!important;
}
.row_gray{ border-top:none !important;}
</style>
<?php 
echo $this->Html->css(array('internal_style','jquery.autocomplete'));
echo $this->Html->script(array('jquery-1.5.1.min','jquery.autocomplete','jquery.blockUI'));
echo $this->Html->css(array('home-slider.css','jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','jquery.fancybox-1.3.4','pager'));
?>

</head>

<body class="disabled">

	<div class="inner_title">
		<h3>
			&nbsp;
			<?php  echo __('Diagnosis Search', true); ?>
		</h3>

	</div>
	
	<?php 
	if(!empty($errors)) {
	?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"
		align="center">
		<tr>
			<td colspan="2" align="left"><div class="alert">
					<?php 
					foreach($errors as $errorsval){
	         echo $errorsval[0];
	         echo "<br />";
	     }
	     ?>
				</div>
			</td>
		</tr>
	</table>
	<?php } 

		if($this->params->query['back']=='ipdDashboard'){
			echo $this->Form->create('',array('action'=>'snowmed'.'/'.$patient_id.'/'.'0'.'/'.trim($_SESSION['NoteId']).'/?'.'appt='.$this->params->query['appt'].'&widgetId='.$this->params->query['back']));
		}else{
			echo $this->Form->create('',array('action'=>'snowmed'.'/'.$patient_id.'/'.'0'.'/'.trim($_SESSION['NoteId']).'/?'.'appt='.$this->params->query['appt'].'&widgetId='.$this->params->query['widgetId']));	
		}  
		
	?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		<tr class="row_title">
			<td class="row_format" width="10%"><?php echo __('Search by Description') ?>
			</td>

			<td class="row_format" width="36%"><?php 
			echo $this->Form->input('Snomed.description', array('type'=>'text','id' => 'description', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:293px;'));
			echo $this->Form->hidden('Snomed.noteId',array('type'=>'text','value'=>$_SESSION['NoteId']));
			echo $this->Form->submit('Search', array('onclick'=>"return checkLength()",'label'=> false, 'name'=>'button','div' => false, 'error' => false,'class'=>'blueBtn','style'=>'margin: 0 0 0 4px;'));
			
			?>
			</td>
            <td class="row_format" align="center"><?php echo __('OR') ?>
			</td>
            <td class="row_format" width="10%"><?php echo __('Search by ICD10 Code') ?>
			</td>
			<td class="row_format"><?php 
			echo $this->Form->input('Snomed.icd9',array('type' => 'text', 'id' => 'icd9cm','autocomplete'=>"off",'label'=> false, 'div'=> false, 'style' => 'width:293px'));
			echo $this->Form->submit('Search', array('id'=>'icdCodeSearch','label'=> false, 'name'=>'button','div' => false, 'error' => false,'class'=>'blueBtn','style'=>'margin: 0 0 0 4px;'));
			?>
            <?php 
			echo $this->Form->hidden('noteId',array('type'=>'text','value'=>$_SESSION['NoteId']));?>
			<td class="row_format"></td>
		</tr>

	</table>
	<div id= "allCommanProblem"></div>
	<?php echo $this->Form->end(); ?>
	<?php echo $this->Form->create('',array('action'=>'snowmed'.'/'.$patient_id.'/'.'0'.'/'.$_SESSION['NoteId']));?>
	<!--<table border="0" class="table_format" cellpadding="0" cellspacing="0">
		<tr class="row_title">

			<td class="row_format" align="center" colspan=3><?php echo __('OR') ?>
			</td>
		</tr>
		<tr class="row_title">
			<td class="row_format" colspan=2><?php echo __('') ?>
			</td>
			<td class="row_format"><?php 
			echo $this->Form->input('imo',array('type' => 'text', 'id' => 'icd9cm', 'class' => 'removeSince','autocomplete'=>"off",
			'label'=> false, 'div'=> false, 'style' => 'width:250px'));
			?>
			
			<td class="row_format"><?php 
			echo $this->Form->hidden('noteId',array('type'=>'text','value'=>$_SESSION['NoteId']));
			echo    $this->Form->submit('IMO Search', array('type'=>'submit','label'=> false, 'div' => false, 'error' => false,'class'=>'blueBtn'));
			
			?>
			</td>
		</tr>
	</table>-->
	<?php echo $this->Form->end(); ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" id="" style="padding-bottom:0px!important;">
	<tr>
			<td colspan="2"  align="left"><?php 
			echo    $this->Form->button(__('Apply selection'), 
					array('type'=>'button','id' => 'selection','label'=> false, 'div' => false,
					'error' => false,'class'=>'blueBtn','onclick'=>'javascript:openbox(myIcd,'+null + newRandomId +')'));
					 
					
			?>
			</td>
			<td colspan="" align="right"><?php 
					if($this->params->query['widgetId']=='ipdDashboard'){
						echo    $this->Html->link(__('Back'),array('controller'=>'Users','action'=>'doctor_dashboard'),
					array('type'=>'button','id' => 'backBtn','label'=> false, 'div' => false, 
					'error' => false,'class'=>'blueBtn', 'style'=>'margin: 0 0 0 10px;'));
					}else if($this->params->query['back']=='ipdDashboard'){
						echo    $this->Html->link(__('Back'),array('controller'=>'Users','action'=>'doctor_dashboard'),
					array('type'=>'button','id' => 'backBtn','label'=> false, 'div' => false, 
					'error' => false,'class'=>'blueBtn', 'style'=>'margin: 0 0 0 10px;'));
					}else{
						echo    $this->Html->link(__('Back'),array('controller'=>'notes','action'=>'soapNote',$patient_id,$_SESSION['NoteId'],'appt'=>$this->params->query['appt'],'#'=>'item'.$this->params->query['widgetId'],'?'=>array('expand'=>'Assessment')),
					array('type'=>'button','id' => 'backBtn','label'=> false, 'div' => false, 
					'error' => false,'class'=>'blueBtn', 'style'=>'margin: 0 0 0 10px;'));
					}
					
			?>
			</td>
		</tr>
	
		</table>
	<table border="0" class="table_format " cellpadding="0" cellspacing="0" width="100%" id="snowmedGrid" style="padding-top:0px !important;">
		<tr class="row_title icd">
			<td class="table_cell"><strong><?php echo  __('Select'); ?> </strong>
			</td>
			<td class="table_cell"><strong><?php echo __('ICD9 Name'); ?> </strong>
			</td>
			<td class="table_cell"><strong><?php echo __('ICD10 Name'); ?> </strong>
			</td>
			<td class="table_cell"><strong><?php echo __('ICD9 Code'); ?> </strong>
			</td>
			<td class="table_cell" ><strong><?php echo __('ICD10 Code'); ?> </strong>
			</td>
			<td class="table_cell" ><strong><?php echo __('Snomed Code'); ?> </strong>
			</td>
            <td colspan="3">&nbsp;</td>
		</tr>
		<?php 
	 $toggle =0;$i=0;
	 $data=1;
	 if(count($getData) > 0){ ?>
	 
	 <?php
	       foreach($getData as $probdata){ 
	       $i++;

	       if($toggle == 0) {
		       	echo "<tr class='row_gray',id='snow'>";
		       	$toggle = 1;
		       }else{
		       	echo "<tr id='snow'>";
		       	$toggle = 0;
		       }$i++;
		       ?>
		
		<td class="row_format" width="190px"><?php 
		echo $this->Form->hidden('icdloc',array('id'=>'icdloc','value'=> $data[0][icd][patient_id],'autocomplete'=>"off"));
		//echo $this->Form->hidden('appt',array('id'=>'appt','value'=> $this->params->query['appt'],'autocomplete'=>"off"));
		
		
		?>
		<?php 
		$explodeIcdName = str_replace("[", "(", $probdata["SnomedMappingMaster"]["icdName"]);
		$explodeIcdNameFinal = str_replace("]", ")", $explodeIcdName);?>
		<?php echo $this->Form->checkbox('',array('name'=>str_replace("?","",$probdata["SnomedMappingMaster"]["icd9code"])."::".str_replace("?","",$probdata["SnomedMappingMaster"]["mapTarget"])."::".$explodeIcdNameFinal,'value'=>str_replace("?","",$probdata["SnomedMappingMaster"]["mapTarget"])."::".str_replace("?","",$probdata["SnomedMappingMaster"]["mapTarget"])." :: ".$explodeIcdNameFinal)); ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $probdata["SnomedMappingMaster"]["icd9name"]; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $probdata["SnomedMappingMaster"]["icdName"]; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo str_replace("?","",$probdata["SnomedMappingMaster"]["icd9code"]); ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo str_replace("?","",$probdata["SnomedMappingMaster"]["mapTarget"]); ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;" colspan="2"><?php echo $probdata["SnomedMappingMaster"]["referencedComponentId"]; ?>
		</td>

		</tr>
		<?php }  ?>
		<tr>
			<TD colspan="8" align="center" class="row_format">
				<!-- Shows the page numbers --> <?php 
		 	// $this->Paginator->options(array('url' => array("?"=>$this->request->query)));
		 	//echo $this->Paginator->numbers(array('class' => 'paginator_links'));

		 	?> <!-- Shows the next and previous links --> <?php // echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php //echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php //echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>

			</span>
			</TD>
		</tr>
		<?php  
	      }else{   ?>


		<tr class="row_gray" id='icd' style="display: none">

			<td class="row_format"><?php //echo $this->Form->checkbox('',array('id'=>'dbICD')); ?>
			</td>



			<td class="table_cell"><label style="text-align: left;" id="code">
			
			</td>
			<td class="table_cell"></label>
			</td>
			<td class="table_cell" id="snomed_code"></td>
			<td class="table_cell"></td>
			<td class="table_cell"></td>
			<td class="table_cell"><label id="nameselected"></label>
			</td>
		</tr>

		<?php
	      }
	      ?>
		<?php    
		$toggle =0;$i=0;
		$data=1;
		if(count($xmldata) > 0){?>
		<tr class="row_title icd">
			<td class="table_cell"><strong><?php echo  __('Select'); ?> </strong>
			</td>
			<td class="table_cell"><strong><?php echo __('SNOMED CT Code'); ?> </strong>
			</td>
			<td class="table_cell"><strong><?php echo __('Snomed Desc'); ?> </strong>
			</td>
			<td class="table_cell"><strong><?php echo __('ICD9 Code'); ?> </strong>
			</td>
			<td class="table_cell"><strong><?php echo __('ICD9 Name'); ?> </strong>
			</td>
			<td class="table_cell"><strong><?php echo __('ICD 10 Code'); ?> </strong>
			</td>
			<td class="table_cell"><strong><?php echo __('ICD 10 Name'); ?> </strong>
			</td>
		</tr>

	    <?php    for($p=0;$p<count($xmldata);$p++){
	       $i++;
	       // explode data of IMO
	       $expImo=explode('|',$xmldata[$p]);
	       if($toggle == 0) {
		       	echo "<tr class='row_gray',id='snow'>";
		       	$toggle = 1;
		       }else{
		       	echo "<tr id='snow'>";
		       	$toggle = 0;
		       }$i++;
		       ?>
		<?php 
		echo $this->Form->hidden('icdloc',array('id'=>'icdloc','value'=> $data[0][icd][patient_id],'autocomplete'=>"off"));
		?>
		<td class="row_format"><?php echo $this->Form->checkbox('',array('name'=>$expImo['3']."::".$probdata["SnomedMappingMaster"]["referencedComponentId"]."::".$expImo['3'],
				'value'=>$expImo['3']."::".$probdata["SnomedMappingMaster"]["referencedComponentId"]."::".$expImo['4'])); ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['0']; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['2']; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['3']; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['4']; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['5']; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['6']; ?>
		</td>
		</tr>
		<?php }  ?>
		 
		<?php  
	      }else{  if(empty($getData)){ ?>
		<tr class="row_gray" id='icd'>
			<td class="row_gray" align='center' colspan='7'><strong>Enter value
					in TextBox to get Result.</strong></td>
		</tr>
		<?php
	   }
}
?>
	</table> 
  <div id="pageNavPosition" align="center"></div> 


</body>

<script>	


	var pager = new Pager('snowmedGrid', 14); 
	pager.init(); 
	pager.showPageNav('pager', 'pageNavPosition'); 
	pager.showPage(1);

	 
	var diagnosisSelectedArray = new Array();
	
	function onCompleteRequest(){
		$('body').unblock(); 
	}
	
	
	function openbox(icd,note_id,p_id) {
		var patient_id = $('#Patientsid').val();
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		 
		$.fancybox({
			
			'width' : '50%',
			'height' : '75%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
					 + '/' + icd + '/' + note_id + '/' + p_id, 
			 'hideOnOverlayClick':false,
			 'showCloseButton':true, 
		});
	}

	
  	$(document).ready(function(){   
  	  	$('#backBtn').click(function(){  	  	  	
  	  	var setFlag="<?php echo $setFlagFrmAltMgt;?>"
  	  	  	if( setFlag=='1'){
  	  	  	parent.$.fancybox.close();
  	  	  	}
  	  	});
  		 	onCompleteRequest();
  			
			/*$("#description").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","SnomedMaster","term", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});*/
		 	$('#selection').click(function(){
		 	    var  icd_text='' ;
				var icd_ids = $( '#icd_ids', parent.document ).val();	
		 		$("input:checked").each(function(index) { 
		 			 if($(this).attr('name') != 'undefined'){
		 			 	var name=$(this).attr('name');
		 			 	 	name = name.replace("'", "");
		 			 	var icd_code=$(this).val().split(" ");
				        var icd = $(this).attr('name');
				        icd = icd.replace("'", "");
				   	    var myIcd = '"'+icd+'"';
				   	    var icd=$(this).val().split("::");
				 	   idSize = parseInt($("#icd_ids_count",parent.document).val()) ; 
				 	   var randomID  = "just_"+Math.floor((Math.random()*100)+1) ;
				 	   var newRandomId = '"'+randomID+'"';
					   icd[0] = $.trim(icd[0]); icd[1] = $.trim(icd[1]);
				 	   var icdstring ='"'+icd[0]+"::"+icd[1]+"::"+ icd[2].replace("'", "")+'"'; 
				 	  if($("#icd9cm").val()!=$(this).val())
				         icd_text +=  "<p id='icd_"+idSize+"' style='padding:0px 10px;'><a id='"+randomID+"' href='javascript:openbox("+myIcd+','+null+ ',' + newRandomId + ")'>"+$(this).val()+"</a><img align='right' class='icd_eraser' src='../../img/icons/cross.png' alt='Remove' style='cursor: pointer;' title='Remove' onclick='javascript:remove_icd(\""+idSize+"\",\""+name+"\");' id='ers_"+name+"'</p>";
				    	 
				       icd_text1=name;
				    	icd_ids  += name+"|";
						var basicNoteId='<?php echo $_SESSION['NoteId'];?>';
						if(basicNoteId!=''){
							icd[0].replace("?", ""); 
							var newIcdstring = icd[0]+'::'+icd[1]+'::'+icd[2].replace("'", "")+'::'+basicNoteId;
						}
						else{
							icd[0].replace("?", ""); 
							var newIcdstring = icd[0]+'::'+icd[1]+'::'+icd[2].replace("'", "");
						}
				    	
				    	$( '#icd_ids_count', parent.document ).val(idSize);	
				    	if(icd[2]!==undefined)
				    	diagnosisSelectedArray.push(newIcdstring);
						
						//alert(parent.$('#Patientsid').val());
						
				    }
				});		 		
				//icd_text += "<table>";
				//alert(('#chkbox', parent.document).attr("checked"));
				$('#chkbox', parent.document).removeAttr('checked');//alert('i');
				$('#icdSlc', parent.document).show();
				 
				
		 		$( '#icdSlc', parent.document ).append(icd_text);
		 		$( '#prob', parent.document ).val(icd_text1);
		 		$( '#icd_ids', parent.document ).val(icd_ids);
		 		$("#eraser", parent.document).show();
		 		addDiagnosisDetails();
				
		 		//parent.$.fancybox.close();
		 	});
	 	});	 
		
  		function getIcdDetails(){
  		   var smokerid=$('#description').val();
  			  var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "diagnoses", "action" => "getIcdDetails","admin" => false)); ?>";
  		        $.ajax({
  		          type: 'POST',
  		          url: ajaxUrl+"/"+smokerid,
  		          data: '',
  		          dataType: 'html',
  		          success: function(data){
  						//alert(data);	
  		        $("#description_id").val(data);
  				},
  				
  					
  					error: function(message){
  		              alert(message+'hi');
  		          }        });
  		    
  		    return false; 
  		}

  		


  		
  			


			function changeTest1() {
  	  		

  	  	      	name= $("#icd9cm option:selected").text() ;
  	  	      	code = $("#icd9cm").val();

  	 	
			var icd_code = $(code.split("|"));
  	  	      	if ($("#icd9cm option:selected").val()!="") {
  	  	      	icd_code[0] = $.trim(icd_code[0]); icd_code[1] = $.trim(icd_code[1]);
  	 			$("#nameselected").html(name);
  	 			$("#code").html(icd_code[0]);
  	 			$("#snomed_code").html(icd_code[1]);
  	 			$("#dbICD").val(icd_code[0]+"::"+name);
  	 			$("#dbICD").attr("name",+icd_code[0]+"::"+icd_code[1]+" :: "+name); 
  	 			$("#snow").hide();
  	 			$("#icd").show();
  	  	}
  	  	      	
  	  	      	else{
  	  	      			$("#icd").remove();
  	  	  	      }
  	  	     	
  	  		}

  		function changerow(){
  			$(".icd").remove();
  			$(".icd").hide();
  	  		}
  		function checkLength(){//'onclick'=>"return checkLength()"
  			var currentFocus=$("*:focus").attr('id');
  			if(currentFocus=='icd9cm'){
  	  			
  			}
  			else{
	  			var searchString = $("#description").val();
	  			if(searchString.length < 3){
	  				alert("Please enter minimum 3 characters");
	  				return false;
	  			}else{
	  				return true;
	  			}
  			}
  		}
  		 

	$('#icdCodeSearch').click(function(){
		if($('#icd9cm').val()==''){
			alert("Please enter Code");
			return false;
		}
	});
  		var sample;
  		var global_note_id = "<?php echo $global_note_id;?>";	
  		var diagnosisSelectedArray = new Array();
  		function addDiagnosisDetails(){
  			var selectedPatientId = "<?php echo $patient_id;?>";
  			
  			if(selectedPatientId != ''){
  				
  				var currEle = diagnosisSelectedArray.pop();
  				$('input:checkbox[name='+currEle+']').attr('checked',false);
  				if((currEle !='') && (currEle !== undefined)){
  					openbox(currEle,selectedPatientId,parent.global_note_id);
  				}
  			}
  			
  		}
/**  Main function**/
  		function openbox(icd,note_id,linkId) { 
  			var sample;
  			icd = icd.split("::");
  			var questionMark=icd[0].slice(-1);
  			if(questionMark=='?'){
  				icd[0] = icd[0].slice(0, -1);
  			
  			}
  			var patient_id = '<?php echo $patient_id?>';
  			if (patient_id == '') {
  				alert("Please select patient");
  				return false;
  			}

  			icd[2]=icd[2].split(":");
  			var msgName='';
  			if(icd[2]!=''){
  			$.each( icd[2], function( key, value ) {
  				msgName+=value;
  				});
  			}
  			icd[2]=msgName;
  			var icdNew=icd['0']+"!!!!"+icd['1']+"!!!!"+icd['2'];
  			$.fancybox({
  						'type' : 'iframe',
  						'width' : '60%',
  						'height' : '80%',
  						'autoScale' : true,
  						'transitionIn' : 'fade',
  						'transitionOut' : 'fade',
  						'type' : 'iframe',
  						'hideOnOverlayClick':false,
  						'showCloseButton':false,
  						'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
  								 + '/' + patient_id + '/' + icdNew, 
  						
  					});
  			return false ;

			

  		}
  		$('#description').click(function(){
  	  		$('#imo1').val('');});
  		$('#imo1').click(function(){
  	  		$('#description').val('');});
	  	// auto complete
  	 
  	$("#description").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "googlecomplete",
  			"SnomedMappingMaster","id",'icdName','null','icdName',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				showNoId:true,
				selectFirst: true,
				valueSelected:true,
				loadId : 'sctName,id'
			});
	$('#icd9cm').click(function(){
		$('#description').val('');
	});
	
	$('#description').click(function(){
		$('#icd9cm').val('');
	});
	function getFrequentDiagnosis(noteID){ 
		 var ajaxUrl1 = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getFrequentDiagnosis","admin" => false)); ?>";
		  $.ajax({
	        	beforeSend : function() {
	        		//loading();
	        	},
	        	type: 'POST',
	        	url: ajaxUrl1+"/"+'<?php echo $patient_id?>'+"/"+'<?php echo $_SESSION['NoteId']?>',
	        	dataType: 'html',
	        	   beforeSend:function(){ 
				    	 $('#busy-indicator').show('fast');; 
				     },
				     success: function(data){		
				    	  data = data.trim();	
				    	  if(data != ''){
				    		  $("#allCommanProblem").html(data);
				    	  } $('#busy-indicator').hide('fast');; },
		  });
	 }
  		</script>
</html>
