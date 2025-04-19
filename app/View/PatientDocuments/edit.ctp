<?php
	echo $this->Html->script('ckeditor/ckeditor');
?>
<style>
.table_format {
    background: #fff none repeat scroll 0 0;
    box-sizing: border-box;
    display: table;
    font-family: "trebuchet MS","Lucida sans",Arial;
    font-weight: 300;
    margin: 0;
    width: 64% !important;
}
textarea {
    background: rgba(0, 0, 0, 0) -moz-linear-gradient(center top , #f1f1f1, #fff) repeat scroll 0 0 !important;
    border: 1px solid #214a27;
    color: #e7eeef;
    font-size: 13px;
    outline: 0 none;
    padding: 0px 0px !important;
    resize: both;
    width: 250px;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Edit Patient Documents', true);?><font font-size="20px" font-family="verdana" color="darkolivegreen"><?php echo "&nbsp;(".$patientData['Patient']['lookup_name'].' - '.$patientData['Patient']['patient_id'].")";
		if(!empty($patientData['Diagnosis']['final_diagnosis']))
		echo ",&nbsp;Diagnosis :".$patientData['Diagnosis']['final_diagnosis'];
		if(!empty($patientData['TariffStandard']['name']))
		echo ",&nbsp;Tariff :".$patientData['TariffStandard']['name'];?>
		</font>		

	</h3>
	<span><?php
	echo $this->Html->link(__('Back'), array('action' => 'index',$patientId), array('escape' => false,'class'=>'blueBtn'));
	?> </span>

</div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 

		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }

     ?></td>
	</tr>
</table>
<?php } ?>

<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#PatientDocumentEditForm").validationEngine();
	});
 
 </script>

<div class="clr ht5"></div>
<?php if($patient['Patient']['id'] != 0) 
		//echo $this->element('patient_information');?>

<?php echo $this->Form->create('PatientDocument',array('type' => 'file','url'=>array('controller'=>'PatientDocuments','action'=>'edit',$patientId,$data['PatientDocument']['id'])));?>
	<div width="100%" align="center" style="padding-top: 5px;">
	<input name="submit" type="submit" value="Submit" class="blueBtn" id="submit"
		tabindex="4" />
		<?php
	echo $this->Html->link(__('Cancel'), array('action' => 'index',$patientId), array('escape' => false,'class'=>'blueBtn'));
	?>

	</div>
<table border="0" class="table_format" cellpadding="0"
	cellspacing="0" width="64%" align="left">

	<tr>
		<td>Name :<font color="red">*</font></td>
		<td><input type="text" name="PatientDocument[name]" 
			class="textBoxExpnd validate[required,custom[mandatory-enter]]" readonly style='' tabindex="1" 
			value="<?php echo $data['PatientDocument']['name'];?>" /></td>
	</tr>	
	<tr>
		<td>Date :
		</td>
		<td ><?php if(empty($data['PatientDocument']['date']))
					$d= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true); 	 
				else
					$d= $this->DateFormat->formatDate2LocalForReport($data['PatientDocument']['date'],Configure::read('date_format'),true);
		echo $this->Form->input('date',array('type'=>'text','id'=>'date', 'readonly'=>'readonly','class'=>'textBoxExpnd','style'=>'width:120px','value'=>$d,'label'=>false));?> 
		</td>
	</tr>
	
	<tr>
		<td>Bill Amount :<font color="red">*</font>
		</td>
		<td style="padding-top:5px;">
		<table>
		<tr>
		<td><?php echo $this->Form->input('bill_amount',array('type'=>'text','id'=>'bill_amount','class'=>'textBoxExpnd validate[required,custom[onlyNumber]]','style'=>'width:120px','label'=>false,'div'=>false,'value'=>$data['PatientDocument']['bill_amount']));?>
		</td>
		<td>
		<?php echo $this->Form->input('payment_type',array('type'=>'select','id'=>'pay_type','class'=>'textBoxExpnd ','style'=>'width:120px','label'=>false,'empty'=>'Please Select','options'=>array('Cash'=>'Cash','Credit'=>'Credit'),'div'=>false,'value'=>$data['PatientDocument']['payment_type']));?>
		</td>
		</tr>
		</table>
		</td>		
	</tr>

	<tr>
		<td>Document Description :</td>
		<td><textarea name="PatientDocument[document_description]"
				tabindex="3" class='textBoxExpnd' style=''><?php  echo $data['PatientDocument']['document_description'];?></textarea></td>
	</tr>	
	
	<tr>
		<td>Comments :</td>
		<td><textarea name="PatientDocument[comment]"
				tabindex="3" class='textBoxExpnd' style=''><?php  echo $data['PatientDocument']['comment'];?></textarea></td>
	</tr>	

	<tr>
	<td colspan="2" style="padding-top:10px;">
<table class="" border="0" cellpadding="0" cellspacing="0" width="100%"
	align="center">	
	<tr id="PackageBreakup">
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				align="" class="formFull" id="packageData">
				<tr>				
					<th align="center" width="30%"><?php echo __('Service Name');?><font color="red">*</font>
					</th>
					<th align="center" width="32%"><?php echo __('Image Upload');?>
					</th>
					<th align="center" width="33%"><?php echo __('Report Upload');?>
					</th>					
					<th class="text" width="5%"><?php echo __('Action');?>
					</th>
				</tr>

		<?php if($data['PatientDocument']['document_id']){			
				$docuNameArr=unserialize($data['PatientDocument']['document_id']);
				$fileNameArr=unserialize($data['PatientDocument']['filename']);
				$fileReportNameArr=unserialize($data['PatientDocument']['filename_report']);
			//	debug($fileReportNameArr);?>
				<?php $key = 0;?>
				<?php  foreach($docuNameArr as $keyM=>$value){ ?>
				<tr id="removePackageData-<?php echo $key;?>">					
					<td width="20%" style="padding-left:10px;"><?php $radiologySrNo = $key+1;
					echo $this->Form->input("fddfg",array('type'=>'text','id'=>"childId-$key",'name'=> 'data[document_name]['.$key.']','value'=>$tariffListData[$value],'class' => 'docName validate[required,custom[mandatory-enter]] textBoxExpnd','label'=>false,'div'=>false));
						echo $this->Form->hidden("dddd",array('type'=>'text','id'=>"docId-$key",'class' => 'alertMsg rate textBoxExpnd calculateCost','name'=> 'data[document_id]['.$key.']','autocomplete'=> 'off','label'=>false,'div'=>false,'value'=>$value));?>
					</td>
					<td valign="top"><?php echo $this->Form->hidden("bbb",array('type'=>'text','id'=>"childImages-$key",'name'=> 'data[filename1]['.$key.']','value'=>$fileNameArr[$keyM],'class' => ' textBoxExpnd calculateCost','autocomplete'=> 'off','label'=>false,'div'=>false));
					echo $this->Form->input("bbb1",array('type'=>'file','id'=>"childImages-$key",'name'=> 'data[filename]['.$key.']','class' => 'textBoxExpnd calculateCost','autocomplete'=> 'off','label'=>false,'div'=>false,'style'=>'width:240px;'));				
					if(!empty($fileNameArr[$keyM])){
						$image1[$keyM]=  FULL_BASE_URL.Router::url("/")."uploads/user_images/".$fileNameArr[$keyM];				
						echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View', true), 'title' => __('View', true),'style'=>"margin:0px 0px 0px 0px !important;")),$image1[$keyM], array('escape' => false,'target'=>'__blank'));
					}?>
					</td>		
					<td><?php echo $this->Form->hidden("dd",array('type'=>'text','id'=>"childReport-$key",'class' => 'rate textBoxExpnd calculateCost','name'=> 'data[filename_report1]['.$key.']','value'=>$fileReportNameArr[$keyM],'autocomplete'=> 'off','label'=>false,'div'=>false));
					echo $this->Form->input("dd1",array('type'=>'file','id'=>"childReport-$key",'class' => 'rate textBoxExpnd calculateCost','name'=> 'data[filename_report]['.$key.']','autocomplete'=> 'off','label'=>false,'div'=>false,'style'=>'width:240px;'));
				
					if(!empty($fileReportNameArr[$keyM])){
					$image2[$keyM]=  FULL_BASE_URL.Router::url("/")."uploads/user_images/".$fileReportNameArr[$keyM];
				
					//echo $this->Html->link($files1,$image1[$keyM],array('escape'=>false,'target'=>'__blank'));
					echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View', true), 'title' => __('View', true))),$image2[$keyM], array('escape' => false,'target'=>'__blank'));
					}?>
					</td>			
							
					<?php $display = 'none'; ?>
					<?php if($key == count($docuNameArr)- 1 ){?>
					<?php $display = '';
}?>
					<?php //if(count($this->data['TariffList']['packageServiceData']) == 1 )?>

					<td class="text"><span><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),'id'=>"Add-$key",
							'alt'=> __('Add', true),'class'=>'addMoretr','style'=>"float:none;display:$display",'onClick'=>"addMoretr();$(this).hide();$('#Remove-$key').show()"));?>
					</span> <span><?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
							'alt'=> __('Remove', true),'class'=>'removePackageData','style'=>'float:none;','id'=>"Remove-$key"));?></span>
					</td>
				</tr>
				<?php $key++; 
                                } ?>
				<?php } else{ ?>
				
			
				<?php $key = 0;?>
				<tr id="first">
					<td width="20%" style="padding-left:10px;"><?php $radiologySrNo = $key+1;
					echo $this->Form->input("vbv",array('type'=>'text','id'=>"childId-$key",'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd ','name'=> 'data[document_name]['.$key.']','label'=>false,'div'=>false));
					echo $this->Form->hidden("dddd",array('type'=>'text','id'=>"docId-$key",'class' => 'alertMsg rate textBoxExpnd calculateCost','name'=> 'data[document_id]['.$key.']','autocomplete'=> 'off','label'=>false,'div'=>false));?>
					</td>
					<td><?php echo $this->Form->input("bbb",array('type'=>'file','id'=>"childImages-$key",'class' => 'docName rate textBoxExpnd calculateCost','autocomplete'=> 'off','name'=> 'data[filename]['.$key.']','label'=>false,'div'=>false,'style'=>'width:240px;'));?>
					</td>	
					<td><?php echo $this->Form->input("",array('type'=>'file','id'=>"childReport-$key",'class' => 'rate textBoxExpnd calculateCost','name'=> 'data[filename_report]['.$key.']','autocomplete'=> 'off','label'=>false,'div'=>false,'style'=>'width:240px;'));?>
					</td>	
				
					<td class="text"><span><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),'id'=>"Add-$key",
							'alt'=> __('Add', true),'class'=>'addMoretr','style'=>'float:none;','onClick'=>"addMoretr();$(this).hide();$('#Remove-$key').show()"));?>
					</span> <span><?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
							'alt'=> __('Remove', true),'class'=>'removePackageData','style'=>'float:none;display:none;','id'=>"Remove-$key"));?></span>
					</td>
				</tr>
				<?php }  ?>
			</table>
	</td>
	</tr>	
<tr>
	<td colspan="2" style="padding-top:10px;">
	   <?php echo __('Notes :'); ?> <br /><br />
	 <?php echo  $this->Form->create('RadiologyDoctorNote',array('id'=>'labManagerfrm','type'=>'file','url'=>array('controller'=>'radiologies','action'=>'radiology_doctor_view',$patient_id),
			 'inputDefaults'=>array('label'=> false, 'div' => false, 'error' => false))); ?>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center">
           		    		<tr>
                            	 
                                      <td valign="top" width="100%">
                                        <?php
                                       $radID = "radupload" ; 
                                        
                                        ?>
                                          <div class="ht5"></div>
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            	
                                                <tr> 
	                                                <td width="40%" style="padding:0;" valign="top">
	                                                	<div id="templateArea-radiology">
	                                                    <?php
	                                                    	 echo $this->requestAction('radiologies/template_add/radiology/null/null/'.$radID);
	                                                    ?>
	                                                    </div>
	                                                 </td>	                                               		                                                                                              	  	
	                                                 <td width="60%" style="padding:0;" valign="top">
	                                                    <?php		                 
	                                                    	                                  
	                                                    	$note = isset($data['PatientDocument']['note'])?$data['PatientDocument']['note']:'' ;
	                                                    	echo $this->Form->textarea('RadiologyResult.note',array('id'=>'doctors-note','rows'=>21,'style'=>'width:95%;','class'=>'','value'=>$note)); 
	                                                    ?>
                                                  	</td>
                                                </tr>		                                                 
                                          	</table>     
                                         </td> 
		                                      </tr>
		                                    </table>  
														                       
   <?php echo $this->Form->end();	 ?>
			                   
	</td>
	</tr>
	</table>
	<?php echo $this->Form->end();?>

<script>
  <?php if(isset($forUrl)) {?>
  	$("#link").css("display","inline");
    $("#document").css("display","none");
	$("#document_radio").attr("checked",false);
	$("#url_radio").attr("checked",true);
  
  <?php }?>

 
 $("#date,#dob").datepicker({  
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: false,
		changeYear: false,
		yearRange: '1950',		
		dateFormat: '<?php echo $this->General->GeneralDate('HH:II:SS');?>',
	});	
  $(document).ready(function(){
  	$(document).on( 'click', '#submit', function() {		
	 //$("#submit").click(function(){       
		    var errors = 0;
		    $("#packageData :hidden").map(function(){    	
		                   $('.alertMsg').each(function() {//loop through each value hidden serviceId        
		            	    if( !$(this).val() ) {         					
		              			$(this).parents('td').addClass('warning');
		             			errors++;
		        			} else if ($(this).val()) {
		             			 $(this).parents('td').removeClass('warning');
		       				 }               	 
		                   });
		              
		    });
		    console.log(errors);
		    if(errors > 0){
		    	alert("Please Select Valid Service First.");
		        //$('#errorwarn').fadeIn("slow");
		      //  $('#errorwarn').text("Please Select Valid Service First");
		        return false;
		    }
		    // do the ajax..        
    });
	
	//BOF-For empty of person_id autocomplete
  		$(document).on( 'keyup', '#childId-0', function() {			
		    if($(this).val() == ''){
				$('#docId-0').val('');
			}		
		}); 
	//EOF-For empty of person_id autocomplete
	    
	});

	var radiologySrNo = isNaN(parseInt('<?php echo $radiologySrNo;?>')) ? 1 : parseInt('<?php echo $radiologySrNo;?>'); 
//var wardData = $.parseJSON('<?php echo json_encode($wardData);?>');
//wardCost ={};
console.log(radiologySrNo);
var key =radiologySrNo;
function addMoretr() {
   // var wardOrderNo = 1;
	 $('#packageData')
     .append($('<tr>').attr('id','removeRow-'+radiologySrNo)             
                     .append($('<td  style="padding-left:10px;">')
                             .append($('<input>').attr({'name':'data[document_name]['+radiologySrNo+']','type':'text','class': 'docName cost validate[required,custom[mandatory-enter]] textBoxExpnd','autocomplete': 'off','id' : 'childId-'+radiologySrNo}))
							.append($('<input>').attr({'name':'data[document_id]['+radiologySrNo+']','type':'hidden','class': 'alertMsg cost validate[required,custom[mandatory-enter]] textBoxExpnd','autocomplete': 'off','id' : 'docId-'+radiologySrNo})))
                     .append($('<td>')
                                     .append($('<input>').attr({'name':'data[filename]['+radiologySrNo+']','type':'file','class' :'rate calculateCost textBoxExpnd','autocomplete': 'off', 'id' : 'childImages-'+radiologySrNo,'style':'width:240px;'})))
                    	 .append($('<td>')
                                     .append($('<input>').attr({'name':'data[filename_report]['+radiologySrNo+']','type':'file','class' :'rate calculateCost textBoxExpnd','autocomplete': 'off', 'id' : 'childReport-'+radiologySrNo,'style':'width:240px;'})))
                   
						 .append($('<td class="text">').attr('id','Td-'+radiologySrNo).append($('<span>').attr({'id' : 'Add-'+radiologySrNo})
                                            .append('<?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
                                                            'alt'=> __('Add', true),'style'=>'float:none;','class'=>'addMoretr','onClick'=>'addMoretr();$(this).parent().hide()'));?>'))
                                            .append($('<span>').attr({'class':'removePackageData','id' : 'Remove-'+radiologySrNo/*,'onclick' : "$('#Add-"+radiologySrNo-1+").show()"*/})
                                                .append('<?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
                                                            'alt'=> __('Remove', true),'style'=>'float:none;'));?>')))
    
     );
     
    
     key++;
	    $('.removePackageData').on('click' , function (){
	        var thisElementId = $(this).attr('id'); 
	        var thisKey = thisElementId.split('-');
	        $("#removeRow-" + thisKey[1]).remove();
	        var trId = $('#packageData tr:last').attr('id'); 
	        var lastTrKey = trId.split('-');
	        if($('#packageData tr:last').attr('id') == 'firstn' || lastTrKey[1] == 0){
	            $('#Add-0').show();
	            $('img#Remove-0').hide();
	        }else{
	            var tdId = $('#packageData tr:last').attr('id')
	             var lastKey = tdId.split('-');
	             $('#Add-'+lastKey[1]).show(); 
	        }
	        $('.calculateCost').trigger('keyup');
	    });	
		
	    $('.docName').autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","radiology","id&name",'null',"null",'null',"null","admin" => false,"plugin"=>false)); ?>",
	           // setPlaceHolder: false,
	        select: function( event, ui ) {
				currentId = $(this).attr('id') ;
  				splittedVar = currentId.split("-");		 
  				IdDoc = splittedVar[1];			
				$("#docId-"+IdDoc).val(ui.item.id); 
	        },
	        messages: {
	          noResults: '',
	          results: function() {}
	        }
	    });
	     radiologySrNo++;//in
	}
	$('.removePackageData').on('click' , function (){
	    var thisElementId = $(this).attr('id');
	        var thisKey = thisElementId.split('-');
	        $("#removePackageData-" + thisKey[1]).remove();
	        var trId = $('#packageData tr:last').attr('id');
	        var lastTrKey = trId.split('-');
	        if($('#packageData tr:last').attr('id') == 'first' || lastTrKey[1] == 0){
	            $('#Add-0').show();
	            $('img#Remove-0').hide();
	        }else{
	            var tdId = $('#packageData tr:last:last').attr('id')
	             var lastKey = tdId.split('-');
	             $('#Add-'+lastKey[1]).show();
	        }
	        $('.calculateCost').trigger('keyup');
	    });
	     $("#childId-0").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","radiology","id&name",'null',"null",'null',"null","admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				$('#docId-0').val(ui.item.id); 				
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
		

 </script>
