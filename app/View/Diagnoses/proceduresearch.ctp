<?php 
	echo $this->Html->script('pager.js');
?>	 
	 	<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" id="procedureGrid">  
		<tr>
			<td colspan="2">
				<?php echo $this->Form->button(__('Apply selection'), array('type'=>'button','id' =>'selection','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn'));?>
			</td>
			<td colspan="4">CPT Copyright 2014 American Medical Association. All rights reserved.</td>
		</tr>
	  <tr class="row_title icd">   
	   <td class="table_cell"><strong><?php echo  __('Select'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('Title'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('CPT&#174; code'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('CPT&#174; Desc'); ?></strong></td> 
	   <!-- <td class="table_cell"><strong><?php echo  __('ICD9'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('ICD9 Desc'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('ICD10PCS'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('ICD10PCS Desc'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('HCPCS'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('HCPCS Desc'); ?></strong></td> -->
	   <td class="table_cell"><strong><?php echo  __('LOINC'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('LOINC Desc'); ?></strong></td>    
	   <!--    
	   <td class="table_cell"><strong><?php echo __('SNOMED CT Code'); ?></strong></td>  
	   <td class="table_cell"><strong><?php echo __('Snomed Desc'); ?></strong></td>  --> 
	  </tr>
	 <?php   

	  for($p=0;$p<count($xmldata);$p++){
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
		       
		
		echo $this->Form->hidden('icdloc',array('id'=>'icdloc','value'=> $data[0][icd][patient_id],'autocomplete'=>"off"));
		?>
		<td class="row_format"><?php echo $this->Form->checkbox('',array('name'=>$expImo['13'],
				'value'=>$expImo['0']."::".$expImo['1']."::".$expImo['2']."::".$expImo['3']."::".$expImo['4']."::".$expImo['5']."::".$expImo['6']."::".$expImo['7']."::".$expImo['8']."::".$expImo['9']."::".$expImo['10']."::".$expImo['11']."::".$expImo['12']."::".$expImo['13'])); ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['0']; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['1']; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['2']; ?>
		</td>
		<!--<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['3']; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['4']; ?>
		</td>
		 
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['5']; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['6']; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['7']; ?>
		</td> 
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['8']; ?>
		</td>-->
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['9']; ?>
		</td>   
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['10']; ?>
		</td><!--
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['11']; ?>
		</td>
		<td class="row_format" valign="top" style="padding-top: 5px;"><?php echo $expImo['12']; ?>
		</td>  -->
		</tr>
		<?php }  ?>
	    
	   
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
				       icd_text1=$(this).attr('value');
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
				
		 		
		 		if(identif=='forlab'){
		 			 var icd=icd_text1.split("::");
		 			
		 			
		 			$( '#testname', parent.document ).val(icd[0]);
			 		$( '#cptCode', parent.document ).val(icd[1]);
			 		$( '#cptDesc', parent.document ).val(icd[2]);
			 		$( '#icd9Code', parent.document ).val(icd[3]);
			 		$( '#icd9Desc', parent.document ).val(icd[4]);
			 		$( '#icd10pcsCode', parent.document ).val(icd[5]);
			 		$( '#icd10pcsDesc', parent.document ).val(icd[6]);
			 		$( '#hcpcsCode', parent.document ).val(icd[7]);
			 		$( '#hcpcsDesc', parent.document ).val(icd[8]);
			 		$( '#LonicCode', parent.document ).val(icd[9]);
			 		$( '#LonicDesc', parent.document ).val(icd[10]);
			 		$( '#sctCode', parent.document ).val(icd[11]);
			 		$( '#sctDesc', parent.document ).val(icd[12]);
			 		$( '#isIMO', parent.document ).val('yes');
			 		$( '#testcode', parent.document ).val(icd[9]);

		 		
		 		//parent.document.getElementById("Statusfather").enabled=true;
		 		
		 		}
		 		else if(identif=='forrad')
		 		{
		 			var icd=icd_text1.split("::");	 
		 		  $( '#rad_testname', parent.document ).val(icd[0]);
		 		  $( '#rad_cptCode', parent.document ).val(icd[1]);
		 		  //$( '#cptDesc', parent.document ).val(icd[2]);
		 		  $( '#rad_icd9code', parent.document ).val(icd[3]);
		 		  //$( '#icd9Desc', parent.document ).val(icd[4]);
		 		  //$( '#icd10pcsCode', parent.document ).val(icd[5]);
		 		  //$( '#icd10pcsDesc', parent.document ).val(icd[6]);
		 		  //$( '#hcpcsCode', parent.document ).val(icd[7]);
		 		  //$( '#hcpcsDesc', parent.document ).val(icd[8]);
		 		   $( '#rad_LonicCode', parent.document ).val(icd[9]);
		 		   //$( '#LonicDesc', parent.document ).val(icd[10]);
		 		  $( '#rad_sctCode', parent.document ).val(icd[11]);
		 		   //$( '#sctDesc', parent.document ).val(icd[12]);
				$( '#isIMO', parent.document ).val('yes');
		 		  $( '#rad_testcode', parent.document ).val(icd[9]);
		 		}
		 		else if(identif=='forproc')
		 		{	 var icd=icd_text1.split("::");

	 		   

		 		    //check if hcpcs type is there or not
		 		    if(icd[7]=="")//code is CPT type
		 		    {
		 		    	$( '#procedure_name', parent.document ).val(icd[0]); 
		 		    	$( '#code_value', parent.document ).val(icd[1]); 
		 		    	$( '#code_type', parent.document ).val("CPT"); 
		 		    	$( '#isIMO', parent.document ).val('yes');
			 		    
		 		    }
		 		    else // code id HCPCS type
		 		    {
		 		    	$( '#procedure_name', parent.document ).val(icd[0]); 
		 		    	$( '#code_value', parent.document ).val(icd[7]); 
		 		    	$( '#code_type', parent.document ).val("HCPCS"); 
		 		    	$( '#isIMO', parent.document ).val('yes');
			 		    
		 		    }
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