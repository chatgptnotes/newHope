 <?php 
	echo $this->Html->script('pager.js');
?>	

	<div class="inner_title">
	<h3>&nbsp; <?php echo __('Diagnosis Search', true); ?></h3>
	
	</div>
	<?php 
	  if(!empty($errors)) {
	?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	 <tr>
	  <td colspan="2" align="left"><div class="alert">
	   <?php 
	     foreach($errors as $errorsval){
	         echo $errorsval[0];
	         echo "<br />";
	     }
	   ?></div>
	  </td>
	 </tr>
	</table>	
	<?php } ?>
	<?php echo $this->Form->create('',array('action'=>'familyproblem'));?>	
	<?php echo $this->Form->hidden('flag',array('id'=>'flag','value'=>$flag));?>
	<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="1000">		 			    			 				    
			<tr class="row_title">			
				<td class="row_format" width="18%" ><?php echo __('Search by Description') ?></td>
			<?php echo $this->Form->hidden('familyid',array('value'=>$this->Session->read('familyid'),'id'=>'familyid'));?>
				<td class="row_format" width="27%">											 
			    	<?php 
			    		 echo $this->Form->input('Snomed.description', array('type'=>'text','id' => 'description', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;'));
					echo $this->Form->submit('Search', array('onclick'=>"return checkLength()",'label'=> false, 'name'=>'button','div' => false, 'error' => false,'class'=>'blueBtn'));
			    	?>
			  	</td>
                <td class="row_format" align="center" colspan=3><?php echo __('OR') ?>
			</td>
            <td class="row_format" colspan=2><?php echo __('') ?>
			</td>
            <td class="row_format"><?php 
			echo $this->Form->input('imo',array('type' => 'text', 'id' => 'icd9cm', 'class' => 'removeSince','autocomplete'=>"off",
			'label'=> false, 'div'=> false, 'style' => 'width:150px'));
			?>
            <?php 
			echo    $this->Form->submit('IMO Search', array('type'=>'submit','label'=> false, 'div' => false, 'error' => false,'class'=>'blueBtn'));
			?>
           </td>
			
			<!--<td class="row_format"><?php 
			echo    $this->Form->submit('IMO Search', array('type'=>'submit','label'=> false, 'div' => false, 'error' => false,'class'=>'blueBtn'));
			?>
			</td>-->
			</tr>

	</table>
	<?php echo $this->Form->end(); ?> 
	
	<?php echo $this->Form->create('',array('action'=>'familyproblem'));?>
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
			echo    $this->Form->submit('IMO Search', array('type'=>'submit','label'=> false, 'div' => false, 'error' => false,'class'=>'blueBtn'));
			?>
			</td>
		</tr>
	</table>-->
	<?php echo $this->Form->end(); ?>
	
	 	<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" id="procedureGrid">  
		<tr>
			<td  colspan="3">
				<?php echo $this->Form->button(__('Apply Selection'), array('type'=>'button','id' =>'selection','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn'));?>
			</td>
		</tr>
		<?php if(count($getData) > 0){?>
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
		</tr>
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
		<?php 
		echo $this->Form->hidden('icdloc',array('id'=>'icdloc','value'=> $data[0][icd][patient_id],'autocomplete'=>"off"));
		?>
		<td class="row_format"><?php echo $this->Form->checkbox('',array('name'=>$probdata["SnomedMappingMaster"]["mapTarget"]."::".$probdata["SnomedMappingMaster"]["referencedComponentId"]."::".$probdata["SnomedMappingMaster"]["icdName"],'value'=>$probdata["SnomedMappingMaster"]["mapTarget"]."::".$probdata["SnomedMappingMaster"]["referencedComponentId"]." :: ".$probdata["SnomedMappingMaster"]["icdName"])); ?>
		</td>

		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $probdata["SnomedMappingMaster"]["referencedComponentId"]; ?>

		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $probdata["SnomedMappingMaster"]["sctName"]; ?>

		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo str_replace("?","",$probdata["SnomedMappingMaster"]["mapTarget"]); ?>

		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $probdata["SnomedMappingMaster"]["icdName"]; ?>

		</td>

		</tr>
	  	<?php }  ?>
	   	<tr>
		    <TD colspan="8" align="center" class="row_format">
		    <!-- Shows the page numbers -->
		 	<?php 
		 		// $this->Paginator->options(array('url' => array("?"=>$this->request->query))); 		
		 		//echo $this->Paginator->numbers(array('class' => 'paginator_links')); 
		 	
		 	?>
		 	<!-- Shows the next and previous links -->
			<?php // echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
		 	<?php //echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
		 	<!-- prints X of Y, where X is current page and Y is number of pages -->
		 	<span class="paginator_links"><?php //echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
		    </TD>
	   	</tr>
	  	
	  
	  <?php }    
		$toggle =0;$i=0;
		$data=1;
		if(count($xmldata) > 0){ ?>
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
		<td class="row_format"><?php echo $this->Form->checkbox('',array('name'=>$expImo['3']."::".$probdata["SnomedMappingMaster"]["referencedComponentId"]."::".$expImo['2'],
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
  <?php }?>
	   
 </table>
<div id="pageNavPosition" align="center"></div> 
	 
	<script>



	var pager = new Pager('procedureGrid', 15); 
	pager.init(); 
	pager.showPageNav('pager', 'pageNavPosition'); 
	pager.showPage(1);
	
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

	 var identif = $('#familyid').val();
	 
	function openbox(icd,note_id,p_id) {

		var patient_id = $('#Patientsid').val();
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$.fancybox({

					'width' : '40%',
					'height' : '80%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
							 + '/' + icd + '/' + note_id + '/' + p_id
				});

	}
  		$(document).ready(function(){

  			$('#selection').click(function(){
				
		 	    var  icd_text='' ;
				//var icd_ids = $( '#icd_ids', parent.document ).val();	
				
		 		$("input:checked").each(function(index) { 
		 		//var icd_code=$(this).val().split("-");
		 		//alert($(this).val());
		 		
		 			 if($(this).attr('name') != 'undefined'){
		 				var icd_code=$(this).val().split(" ");
				       var icd = $(this).attr('name');
				       //alert($(this).attr('name'));
				      var icd=$(this).val().split("::");
				 
				    	icd_text +=  "<p id='icd_"+$(this).attr('name')+"' style='padding:0px 10px;'><a href='javascript:openbox("+icd[0]+")'>"+$(this).val()+"</a><img align='right' class='icd_eraser' src='../../img/icons/cross.png' alt='Remove' style='cursor: pointer;' title='Remove' onclick='javascript:remove_icd("+$(this).attr('name')+");' id='ers_"+$(this).attr('name')+"'</p>";

					       icd_text1=$(this).attr('name');
				    	//icd_ids  += $(this).attr('name')+"|";
				       
				    }
				});		 		
				//icd_text += "<table>";
				//alert(('#chkbox', parent.document).attr("checked"));
				$('#chkbox', parent.document).removeAttr('checked');//alert('i');

				if($('#flag').val()=='diagnosis'){
					$('#icdSlc', parent.document).show();
		 			$( '#icdSlc', parent.document ).append(icd_text);
				}
		 		
		 		if(identif=='father'){
			 		
		 			 var icd=icd_text1.split("::");
		 			
		 		$( '#father', parent.document ).val(icd[2]);
		 		$( '#Statusfather', parent.document ).removeAttr('disabled');
		 		//parent.document.getElementById("Statusfather").enabled=true;
		 		
		 		}
		 		else if(identif=='mother')
		 		{	 var icd=icd_text1.split("::");
		 			$( '#mother', parent.document ).val(icd[2]);
		 			$( '#Statusmother', parent.document ).removeAttr('disabled');
		 		}
		 		else if(identif=='brother')
		 		{	 var icd=icd_text1.split("::");
		 			$( '#brother', parent.document ).val(icd[2]);
		 			$( '#Statusbrother', parent.document ).removeAttr('disabled');
		 		}
		 		else if(identif=='sister')
		 		{	 var icd=icd_text1.split("::");
		 			$( '#sister', parent.document ).val(icd[2]);
		 			$( '#Statussister', parent.document ).removeAttr('disabled');
		 		}
		 		if(identif=='son'){
		 			 var icd=icd_text1.split("::");
		 		$( '#son', parent.document ).val(icd[2]);
		 		$( '#Statusson', parent.document ).removeAttr('disabled');
		 		}
		 		if(identif=='daughter'){
		 			 var icd=icd_text1.split("::");
		 		$( '#daughter', parent.document ).val(icd[2]);
		 		$( '#Statusdaughter', parent.document ).removeAttr('disabled');
		 		}
		 		if(identif=='uncle'){
		 			 var icd=icd_text1.split("::");
		 		$( '#uncle', parent.document ).val(icd[2]);
		 		$( '#statusuncle', parent.document ).removeAttr('disabled');
		 		}
		 		if(identif=='aunt'){
		 			 var icd=icd_text1.split("::");
		 		$( '#aunt', parent.document ).val(icd[2]);
		 		$( '#statusaunt', parent.document ).removeAttr('disabled');
		 		}

		 		if(identif=='grandmother'){
		 			 var icd=icd_text1.split("::");
		 		$( '#grandmother', parent.document ).val(icd[2]);
		 		$( '#statusgrandmother', parent.document ).removeAttr('disabled');
		 		}
		 		if(identif=='grandfather'){
		 			 var icd=icd_text1.split("::");
		 		$( '#grandfather', parent.document ).val(icd[2]);
		 		$( '#statusgrandfather', parent.document ).removeAttr('disabled');
		 		}
		 				 		
		 		else if(identif.indexOf('illness')>=0)
		 		{	 var icd=icd_text1.split("::");
		 			$( '#'+identif, parent.document ).val(icd[2]);
		 		}
		 		 
		 		//$( '#icd_ids', parent.document ).val(icd_ids);
		 		$("#eraser", parent.document).show();
		 		
		 		parent.$.fancybox.close();
		 	});
	 	});	 
  		
  		
  		function checkLength(){//'onclick'=>"return checkLength()"
  			var searchString = $("#description").val();
  			if(searchString.length < 3){
  				alert("Please enter minimum 3 characters");
  				return false;
  			}else{
  				return true;
  			}
  		}
  </script>
  </html> 