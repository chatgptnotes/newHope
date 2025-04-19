<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
</title>
			<?php  	
					echo $this->Html->css(array('internal_style','jquery.autocomplete'));
					echo $this->Html->script(array('jquery-1.5.1.min','jquery.autocomplete'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
			?>
</head>
<body>

	<div class="inner_title">
	<h3>&nbsp; <?php echo __('ICD code Management', true); ?></h3>
	
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
	<?php echo $this->Form->create('',array('action'=>'snowmed','type'=>'get'));?>	
	<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="750px" >		 			    			 				    
			<tr class="row_title">			
				<td class="row_format"><label><?php echo __('Search by Description') ?> :</label></td>
			
				<td class="row_format">											 
			    	<?php 
			    		 echo    $this->Form->input('description', array('type'=>'text','id' => 'description', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
			    	?>
			  	</td>
			  	<td class="row_format">
			  		<?php 
			    		 echo    $this->Form->submit('Search', array('label'=> false, 'name'=>'button','div' => false, 'error' => false,'class'=>'blueBtn','onClick'=>'javascript:changerow()'));
			    	?>
			    </td>
			 </tr>
	</table>
	<?php echo $this->Form->end(); ?> 
	
	<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="750px" >		 			    			 				    
			<tr class="row_title">			
				<td class="row_format"><label><?php echo __('OR') ?> :</label></td>
			<td class="row_format">	
	                                

	                                
	                             <?php //debug($icdOptions);exit;
	                             // echo $this->Form->input('icd9',array('type' => 'select', 'id' => 'icd9cm', 'class' => 'removeSince',   'options'=>$icdOptions, 'name'=>'dropdown', 'label'=> false, 'div'=> false, 'style' => 'width:250px','onChange'=>'javascript:changeTest1()')); 
echo $this->Form->select('icd9',array($icdOptions),array("empty"=>__('Please Select'),
		'label'=>false,'div'=>false,'id' => 'icd9cm','onChange'=>'javascript:changeTest1()'));
                   		?>
	                            
				
			  	<td class="row_format">
			  		<?php 
			    		// echo    $this->Form->button('Search', array('type'=>'button','label'=> false, 'div' => false, 'error' => false,'class'=>'blueBtn'));
			    	?>
			    </td>
			 </tr>
	</table> 
	
	 	<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >  
		<tr>
			<td align="right" colspan="3">
				<?php 
			    		 echo    $this->Form->button(__('Apply selection'), array('type'=>'button','id' => 'selection','label'=> false, 'div' => false, 'error' => false,'class'=>'blueBtn'));
			    	?>
			</td>
		</tr>
	  <tr class="row_title icd">   
	   <td class="table_cell"><strong><?php echo  __('Select'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('Item Code'); ?></strong></td>   
	   <td class="table_cell"><strong><?php echo __('Preferred SNOMED CT US Extension Code '); ?></strong></td>  
	   <td class="table_cell"><strong><?php echo __('Preferred SNOMED CT Code'); ?></strong></td> 
	    <td class="table_cell"><strong><?php echo __('Preferred primary ICD-9-CM '); ?></strong></td>   
	   <td class="table_cell"><strong><?php echo __('Preferred primary ICD-10-CM '); ?></strong></td>  
	   <td class="table_cell"><strong><?php echo __('SNOMED_DESCRIPTION '); ?></strong></td> 
	 
	   
	  </tr>
	 <?php 
     
	  	  $toggle =0;$i=0;
$data=1;
	      if(count($xmldata) > 0 && !empty($xmldata)) {
	     
	       foreach($xmldata->item as $icd){ 

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
		   <td class="row_format"><?php echo $this->Form->checkbox('',array('name'=>$icd['code']."::".$icd['SCT_CONCEPT_ID']."::".$icd['SNOMED_DESCRIPTION'],'value'=>$icd['code']."::".$icd['SCT_CONCEPT_ID']." :: ".$icd['SNOMED_DESCRIPTION'])); ?> </td>
		   
		   <td class="row_format" valign="top" style="padding-top:5px;"><?php echo $icd["code"]; ?>
		   			
		   </td> 
		    <td class="row_format" valign="top" style="padding-top:5px;"><?php echo $icd["SCT_US_CONCEPT_ID"]; ?>
		   			
		   </td>
		    <td class="row_format" valign="top" style="padding-top:5px;"><?php echo $icd["SCT_CONCEPT_ID"]; ?>
		   			
		   </td>
		     <td class="row_format" valign="top" style="padding-top:5px;"><?php echo $icd["kndg_code"]."-".$icd[kndg_title]; ?>
		   			
		   </td>
		     <td class="row_format" valign="top" style="padding-top:5px;"><?php echo $icd["ICD10CM_CODE"]."-".$icd[ICD10CM_TITLE]; ?>
		   			
		   </td>
		   <td class="row_format" valign="top" style="padding-top:5px;"><?php echo $icd["SNOMED_DESCRIPTION"]; ?>
		   			
		   </td>
		   
		   
		   <td class="row_format"><?php //echo ucfirst($icd['icd']['description']); ?> </td>   
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
	  	<?php  
	      }else{   ?>
	      
	       
	  	 <tr class="row_gray" id='icd' style="display:none">
		
		<td class="row_format"><?php echo $this->Form->checkbox('',array('id'=>'dbICD')); ?> </td>
		
		
			
			<td class="table_cell"><label style="text-align:left;" id="code"></td>
			<td class="table_cell"></label></td>
			<td class="table_cell" id="snomed_code"></td>
			<td class="table_cell"></td>
			<td class="table_cell"></td>
			<td class="table_cell"><label id="nameselected"></label></td>
		</tr>

	  	<?php
	      }
	  ?> 
	 
    


	 
	  
	  
	  
	  
	  
	  
	  
	  
	  
	   
 </table>
	</body>

	<script>	
	function openbox(icd,note_id,p_id) {

		var patient_id = $('#Patientsid').val();
		if (patient_id == '') {
			alert("Please select patient");
			return false;
		}
		$
				.fancybox({

					'width' : '40%',
					'height' : '80%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis_patient")); ?>"
							 + '/' + icd + '/' + note_id + '/' + p_id
				});

	}
  		$(document).ready(function(){    	 
			$("#description").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","icd","description", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
		 	$('#selection').click(function(){
		
		 	    var  icd_text='' ;
				var icd_ids = $( '#icd_ids', parent.document ).val();	
				
		 		$("input:checked").each(function(index) { 
		 		
		 			 if($(this).attr('name') != 'undefined'){
		 				var icd_code=$(this).val().split(" ");
				       var icd = $(this).attr('name');
				   		var myIcd = '"'+icd+'"';
				      var icd=$(this).val().split("::");
				 		idSize = parseInt($("#icd_ids_count",parent.document).val())+1 ; 
				 		var randomID  = "just_"+Math.floor((Math.random()*100)+1) ;
							icd[0] = $.trim(icd[0]); icd[1] = $.trim(icd[1]);
				 		var icdstring ='"'+icd[0]+"::"+icd[1]+"::"+icd[2]+'"'; 
				    	icd_text +=  "<p id='icd_"+idSize+"' style='padding:0px 10px;'><a id='"+randomID+"' href='javascript:openbox("+myIcd+")'>"+$(this).val()+"</a><img align='right' class='icd_eraser' src='../../img/icons/cross.png' alt='Remove' style='cursor: pointer;' title='Remove' onclick='javascript:remove_icd(\""+idSize+"\");' id='ers_"+$(this).attr('name')+"'</p>";
				       icd_text1=$(this).attr('name');
				    	icd_ids  += $(this).attr('name')+"|";
				    	
				    	$( '#icd_ids_count', parent.document ).val(idSize);	
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
		 		
		 		parent.$.fancybox.close();
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
  		
  		
  </script>
  </html> 