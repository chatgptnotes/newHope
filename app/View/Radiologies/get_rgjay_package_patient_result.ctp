<?php
echo $this->Html->script(array( 'jquery.mCustomScrollbar.concat.min.js','colResizable-1.4.min.js'));
echo $this->Html->css(array('jquery.mCustomScrollbar.css','colResizable.css'));
?>
<script>
        (function($){
                $(window).load(function(){
                        $(".thumbnail-area").mCustomScrollbar({
                                autoHideScrollbar:false,
                                theme:"dark"
                        });
                                                        });
        })(jQuery);
</script>
	<style> 

	.mCSB_scrollTools{
		margin-right:14px;
	}
	.mCustomScrollBox > .mCSB_scrollTools{
		margin-right: 4px !important;
	}
	.mCSB_1_scrollbar .mCSB_dragger .mCSB_dragger_bar{ width: 2px !important; }
        .thumbnail-area{
			/*outline: 1px solid; */
          	background-color:#898381;
		    display: block; 
		    float: left;
		    /*height: 480px;
		    left: 0;
		    margin: 0 auto;*/
		    max-height: 545px;
		    overflow: scroll;
		    /*position: relative;
		    top: 0;
		    visibility: visible;*/
		    width: 240px;  
        }
		
		.outline{
			background-color:#898381;
			/*outline: 1px solid; */
			padding-top: 5px;
			/*-moz-outline-radius:10px;
			-webkit-outline-radius:10px;
			outline-radius:10px;*/
		}
        
		.borderBottom td{ 
			border-bottom: solid #000 1px; bg-color:#cccc !important;
		}
		 

        .thumbnail-area img:hover{ 
            border: #fff 1px solid; 
        }
        
        
   
.alignCenter{ 
	text-align: center !important;
}

.tableForm th {
	background: #8b8b8b none repeat scroll 0 0 !important;
	border-bottom: 1px solid #3e474a;
	color: #FFFFFF !important;
	font-size: 12px;
	padding: 1px 0;
	text-align: left;
}

.table_format {
	padding: 0px !important;
}

.table_format tr td {
	padding: 0px !important;
}

  .uploaded{
        background-color: #27ae60;
        color: white;
    }
    
    .notUploaded{
        background-color: #ea6153 !important;
        color: white;
    }
</style>
<div class="inner_title">
	<h3> &nbsp; <?php echo __('Upload Patients Documents', true); ?></h3> 
</div>
<?php echo $this->Form->create('RgjayPackage',array('id'=>'search-form','type'=>'get'));?>
<table align="center"  >
	<tr>
		<td><?php echo $this->Form->input('patient_name',array('class'=>'textBoxExpnd patient_name select','id'=>'patient_name','label'=>false,'div'=>false,'placeholder'=>'Search Patient','value'=>$data['RgjayPackage']['patient_name']));?>
			<?php echo $this->Form->hidden('patient_id',array('id'=>'patientId','value'=>$data['RgjayPackage']['patient_id']))?>
		</td>
		<td><?php echo $this->Form->input('package_name',array('class'=>'textBoxExpnd','id'=>'package_name','label'=>false,'div'=>false,'placeholder'=>'Search Package','value'=>$data['RgjayPackage']['package_name']));?>
			<?php echo $this->Form->hidden('package_id',array('id'=>'package_id','value'=>$data['RgjayPackage']['package_id']))?>
		</td>
		<td><?php echo $this->Form->input('diagnosis_name',array('class'=>'textBoxExpnd','id'=>'diagnosis_name','label'=>false,'div'=>false,'placeholder'=>'Search Primary Diagnosis','value'=>$data['RgjayPackage']['diagnosis_name']));?>
			<?php echo $this->Form->hidden('diagnosis_id',array('id'=>'diagnosis_id','value'=>''))?>
		</td>
		<td><?php echo $this->Form->input('actual_diagnosis',array('class'=>'textBoxExpnd','id'=>'actualDiagnosis','label'=>false,'div'=>false,'placeholder'=>'Search Actual Diagnosis','value'=>$data['RgjayPackage']['actual_diagnosis']));?>
			<?php echo $this->Form->hidden('actual_diagnosis_id',array('id'=>'actual_diagnosis_id','value'=>''))?>
		</td>
		<td><?php echo $this->Form->input('from_date', array('class'=>'textBoxExpnd select','id'=>'fdate','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From Date','value'=>$data['RgjayPackage']['from_date'],'autocomplete'=>'off'));?></td>
		<td><?php echo $this->Form->input('to_date', array('class'=>'textBoxExpnd select','id'=>'tdate','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'To Date','value'=>$data['RgjayPackage']['to_date'],'autocomplete'=>'off'));?></td>
	</tr>
		<tr>
			<td><?php echo $this->Form->input('package_category_name',array('type'=>'text','id'=>'packageCategory','label'=>false,'div'=>false,'error'=>false,'placeHolder'=>"Package Having Sub Category",'class'=>'textBoxExpnd'));
			          echo $this->Form->input('package_category_id',array('type'=>'hidden','id'=>'packageCategoryId'));?>
			</td>
			<td><?php echo $this->Form->input('package_sub_category_name',array('type'=>'text','id'=>'packageSubCategory','label'=>false,'div'=>false,'error'=>false,'placeHolder'=>"Sub Package Category",'class'=>'textBoxExpnd' ));
				      echo $this->Form->input('package_sub_category_id',array('type'=>'hidden','id'=>'packageSubCategoryId'));
			?>
			</td>
			<td><?php echo $this->Form->input('package_subsub_category_name',array('type'=>'text','id'=>'packageSubSubCategory','label'=>false,'div'=>false,'error'=>false,'placeHolder'=>"Sub Sub Package Category",'class'=>'textBoxExpnd '));
			          echo $this->Form->input('package_subsub_category_id',array('type'=>'hidden','id'=>'packageSubSubCategoryId'));
			?>
			</td>
		<td><?php
		$category=array('1'=>'Photo','2'=>'Investigation','3'=>'ID Proof','4'=>'Notes','5'=>'Death Related');
		echo $this->Form->input('category_id',array('options'=>array(''=>'Select Upload Category',$category),'type'=>'select','class'=>'textBoxExpnd category','style'=>'width:100%','id'=>'category_id','label'=>false,'div'=>false,'placeholder'=>'Select Category','value'=>$data['RgjayPackage']['category_id']));?>
		</td>
		
		<td id="subCat" style="display: none"><?php echo $this->Form->input('sub_category_id',array('options'=>array(''=>'Select Sub Category',$subCategory),'type'=>'select','class'=>'textBoxExpnd subCategory','id'=>'sub_category_id','label'=>false,'div'=>false,'placeholder'=>'Select SubCategory','value'=>$data['RgjayPackage']['sub_category_id']));?>
		</td>
		
		<?php $subIntraOpcategory= array('1'=>'Incision','2'=>'Identification of Surgery Parts','3'=>'Critical Steps in Surgery','4'=>'Suture line');?>
		<td id= "subSubCat" style="display: none"><?php echo $this->Form->input('intraop_sub_category_id',array('options'=>array(''=>'Select Intra OP Sub Category',$subIntraOpcategory),'type'=>'select','class'=>'textBoxExpnd','id'=>'intraOp_sub_category_id','label'=>false,'div'=>false,'value'=>$data['RgjayPackage']['intraop_sub_category_id']));?>
		</td>
		<td><?php echo $this->Form->checkbox('display_image',array('id'=>'display_image','class'=>'display_image','label'=> false, 'div' => false));?></td>
		
		<td><?php echo $this->Form->submit('Search',array('id'=>'submit','class'=>'blueBtn','label'=> false, 'div' => false));?></td>
		<td><?php echo $this->Html->image('icons/eraser.png',array('id'=>'resett','title'=>'Reset'));?>	</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tableForm resizable sticky" id="tableId">
	<thead <?php if($this->request->query['display_image'] == 1) { ?> style="display:none" <?php } ?>>
		<tr> 
			<th class="alignCenter"><?php echo __('Sr No');?></th> 
			<th class="alignCenter"><?php echo __('Gender');?></th> 
			<th class="alignCenter"><?php echo __('Patient Name');?></th> 
			<th class="alignCenter"><?php echo __('Corpoate Type');?></th> 
			<th class="alignCenter"><?php echo __('Admission ID');?></th> 
			<th class="alignCenter"><?php echo __('Date Of Admission');?></th>
			<th class="alignCenter"><?php echo __('Package');?></th>
			<th class="alignCenter"><?php echo __('Primary Diagnosis');?></th>
			<th class="alignCenter"><?php echo __('Actual Diagnosis');?></th>
			<th class="alignCenter"><?php echo __('Upload Category');?></th>
			<th class="alignCenter"><?php echo __('Upload Sub Category');?></th>
			<th class="alignCenter"><?php echo __('IntraOp Sub Category');?></th>
			<th class="alignCenter"><?php echo __('Package Category');?></th>
			<th class="alignCenter"><?php echo __('Package Sub Category');?></th>
			<th class="alignCenter"><?php echo __('Package Sub Sub Category');?></th>
			<th class="alignCenter"><?php echo __('Upload Document');?></th>
		</tr> 
	</thead>
	<?php
	foreach ($servicesData as $key => $value){
		if (!empty($value['PatientDocumentDetail']['id'])) {
			$uploaded = 'uploaded';
		} else {
			$uploaded = 'notUploaded';
		}
		?>
		<tr class="<?php echo $uploaded;?>"> 
			<td class="alignCenter"><?php echo $key+1;?></td> 
			<td class="alignCenter">
				<?php if($value['Patient']['sex']=='male'){ ?>
					  <?php echo "M" ?>
					<?php }else if($value['Patient']['sex']=='female') {?>
					<?php echo "F"; ?>
					<?php }?>
			</td> 
			<td class="alignCenter"><?php echo $value['Patient']['lookup_name'];?></td> 
			<td class="alignCenter"><?php echo $value['TariffStandard']['name'];?></td> 
			<td class="alignCenter"><?php echo $value['Patient']['admission_id'];?></td> 
			<td class="alignCenter"><?php $date= $this->DateFormat->formatDate2Local($value['Patient']['form_received_on'],Configure::read('date_format'),true);
										echo $date;?>
			</td>
			<td class="alignCenter"><?php
				if($value['Patient']['tariff_standard_id']== $rgjayTariffId || $value['Patient']['tariff_standard_id'] == $rgjayTariffAsOnTodayId){
					echo strtoupper($value['TariffList']['name']);
				}else{
					echo $pacakgeCategory[$value['GalleryPackageDetail']['package_category_id']];
				}
			?></td>
			<td class="alignCenter"><?php echo $value['Diagnosis']['final_diagnosis'];?></td>
			<td valign="middle" style="text-align: center;">
				<?php echo $this->Form->input('actual_diagnosis',array('label'=>false,'div'=>false,'class'=>" textBoxExpnd billingDiag",'id'=>'billingDiagnosis_'.$value['Patient']['id']."_".$value['Diagnosis']['id'],'type'=>'text','value'=>$value['Diagnosis']['actual_diagnosis']));
				echo $this->Form->hidden('actual_diagnosis_id',array('label'=>false,'div'=>false,'class'=>" textBoxExpnd actual_diagnosis_id alertMsg",'id'=>'actualDiagnosisId_'.$value['Patient']['id']."_".$value['Diagnosis']['id']));
				alertMsg
				?>
		</td>
			
			<td class="alignCenter"><?php echo $category[$value['PatientDocumentDetail']['category_id']];?></td>
			<td class="alignCenter"><?php echo $docType[$value['PatientDocumentDetail']['sub_category_id']];?></td>
			<td class="alignCenter"><?php echo $subIntraOpcategory[$value['PatientDocumentDetail']['intraop_sub_category_id']];?></td>
			
			<td class="alignCenter"><?php echo $pacakgeCategory[$value['GalleryPackageDetail']['package_category_id']];?></td>
			<td class="alignCenter"><?php echo $pacakgeSubCategory[$value['GalleryPackageDetail']['package_sub_category_id']];?></td>
			<td class="alignCenter"><?php echo $pacakgeSubSubCategory[$value['GalleryPackageDetail']['package_subsub_category_id']];?></td>
			
			<td class="alignCenter">
			<?php if(!empty($value['PatientDocumentDetail']['id']))
					$getImgFlag="upload_document.png";
			  else
					$getImgFlag="upload_document.png";
			   if($conditionsFilter){
			  	$conditionalFlag = 'conditionalFlag';
			  } 
			  ?>
				<?php //echo $this->Html->image('icons/'.$getImgFlag, array('class'=>'uploadDoc','id'=>'uploadDoc','alt' => 'Upload Document','title'=>'Upload Document','style'=>'float:none;width: 25px;height: 25px','patientId'=>$value['Patient']['id'])); ?>
				<?php echo $this->Html->link($this->Html->image('icons/'.$getImgFlag,array('title'=>'Upload Document','style'=>'float: none !important;')),array("controller" => "Radiologies", "action" => "uploadDocument",$value['Patient']['id'],'?'=>array('conditionalFlag'=>$conditionalFlag),"admin" => false),array('escape'=>false,'class'=>''));?></td>
		</tr> 
		
		
		<?php } 
		
		if(!empty($servicesData)){
			$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			?>
			<tr>
			    <TD colspan="15" align="center">
			    <!-- Shows the page numbers -->
				 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				 <!-- Shows the next and previous links -->
				 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				 <!-- prints X of Y, where X is current page and Y is number of pages -->
				 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
				 </span>
			    </TD>
			   </tr>
			<?php 
		}
		?>
</table>
<table width="95%" border="0" align="center">
	<tr>
		<td valign="top" width="1%">
			<table class="thumbnail-area" width="100%"> 
				<?php
				if (! empty ( $servicesDataOnlyImages )) {  #debug($servicesDataOnlyImages);
					$k = 0;
					foreach ( $servicesDataOnlyImages as $imgKey => $imgValue ) { // debug($imgValue);
						if (($k % 2) === 0) {
							if ($k > 0)
								echo "</tr>";
							echo "<tr>";
						}
						echo "<td>";
						$documentId = $imgValue['PatientDocumentDetail']['id'];
						echo $this->Form->hidden('document_id',array('value'=>$documentId)); 
						echo $this->Html->image ( RADIOPATH . "thumbnail/" . $imgValue ['PatientDocumentDetail']['filename_report'], array (
								'id'=>"thumb_".$imgValue['PatientDocumentDetail']['id'],
								'class'=>'thumb',
								'alt'=>$imgValue ['PatientDocumentDetail']['document_description']
						) );
						
						//hidden html build to place after click on thumbnail 
						echo $this->Form->create('',array('id'=>'myForm_'.$imgValue['PatientDocumentDetail']['id'],'onsubmit'=>"return false"));
						echo "<div id='".$imgValue['PatientDocumentDetail']['id']."' style='display:none;'><table align='center' width='100%' class='outline' cellpadding='5' cellspacing='0'><tr class='borderBottom'><td>" ; 
						$category=array('1'=>'Photo','2'=>'Investigation','3'=>'ID Proof','4'=>'Notes','5'=>'Death Related');
						echo $this->Form->input('category_id',array('options'=>$category,'empty'=>'Select Category','type'=>'select','class'=>'textBoxExpnd categoryId','style'=>'width:100%','id'=>'categoryId_'.$documentId,'label'=>false,'div'=>false,'value'=>$imgValue['PatientDocumentDetail']['category_id']));
						echo "</td><td>";
						echo $this->Form->input('sub_category_id',array('options'=>$subCategory,'empty'=>'Select Sub Category', 'type'=>'select','class'=>'textBoxExpnd subCategoryId','style'=>'width:100%','id'=>'subCategoryId_'.$documentId,'label'=>false,'div'=>false,'value'=>$imgValue['PatientDocumentDetail']['sub_category_id']));
						echo "</td>"; 
						$intraOpPhoto = Configure::read('intraOpPhoto');
						echo "<td id='intraOpSubCat_$intraOpPhoto' style='display:none'>";
						$subIntraOpcategory= array('1'=>'Incision','2'=>'Identification of Surgery Parts','3'=>'Critical Steps in Surgery','4'=>'Suture line');
						echo $this->Form->input('intraop_sub_category_id',array('options'=>$subIntraOpcategory,'empty'=>'Select Intra OP Sub Category','style'=>'width:100%','type'=>'select','class'=>'textBoxExpnd intraOpSubCategoryId','id'=>'intraOpSubCategoryId_'.$documentId,'label'=>false,'div'=>false,'value'=>$imgValue['PatientDocumentDetail']['intraop_sub_category_id'])); 
						echo "</td>";
					
						echo "<td>";
                        echo $this->Html->image('icons/saveSmall.png',array('class'=>'updateDocumentDetials','escape'=>false,'div'=>false,'label'=>false,'id'=>'detail_'.$imgValue['PatientDocumentDetail']['id'],'alt'=>'Download','title'=>'Update'));
                        //echo $this->Form->submit(__('Save'),array('div'=>false,'label'=>false,'class'=>'blueBtn updateDocumentDetials','id'=>'detail_'.$imgValue['PatientDocumentDetail']['id']));
						echo "</td>";  
                        if($imgValue['PatientDocumentDetail']['is_download_allow']=='1'){                   
						echo "<td>".$this->Html->link($this->Html->image('download_icon.png',array('alt'=>'Download','title'=>'Download')),RADIOPATH . $imgValue['PatientDocumentDetail']['filename_report'],array('download'=>$imgValue ['PatientDocumentDetail']['filename_report'],'div'=>false,'label'=>false,'class'=>'download','escape'=>false));
						echo "</td>";
						}
						echo "</tr><tr><td colspan='5' align='center'>";  
						echo $this->Html->image ( RADIOPATH . "/" . $imgValue ['PatientDocumentDetail']['filename_report'], array ( 
								'alt'=>$imgValue ['PatientDocumentDetail']['document_description'] 
						 ,'width'=>'600px','height'=>'600px;','style'=>'float:none;')); 
						echo "</td></tr></table></div>" ;
						echo $this->Form->end();  
                                                
					
						if($imgValue['Patient']['tariff_standard_id']== $rgjayTariffId || $imgValue['Patient']['tariff_standard_id'] == $rgjayTariffAsOnTodayId){
							$packageName = strtoupper($imgValue['TariffList']['name']);
						}else{
							$packageName = $pacakgeCategory[$imgValue['GalleryPackageDetail']['package_category_id']];
						}
						
                                                //for patient details
                                                echo "<div id='patientDetail_".$documentId."' style='display:none;'>".
                                                        "<table align='center' style='color:white' class='outline' width='100%' cellpadding='5' cellspacing='5'>".
                                                            "<tr class='borderBottom'>".
                                                                "<td colspan='2' align='center'>Patient Details</td>".
                                                            "</tr>".
                                                            "<tr>".
                                                                "<td valign='top' style='width: 32%'>Name :</td>".
                                                                "<td valign='top'>".$imgValue['Patient']['lookup_name']."</td>".
                                                            "</tr>".
                                                            "<tr>".
                                                                "<td valign='top'>Package :</td>".
                                                                "<td valign='top'>".$packageName."</td>".
                                                            "</tr>".
                                                            "<tr>".
                                                                "<td valign='top'>Diagnosis :</td>".
                                                                "<td valign='top'>".$imgValue['Diagnosis']['diagnosis']."</td>".
                                                            "</tr>".
                                                            "<tr>".
                                                                "<td valign='top'>Category :</td>".
                                                                "<td valign='top'>".$category[$imgValue['PatientDocumentDetail']['category_id']]."</td>".
                                                            "</tr>".
                                                            "<tr>".
                                                                "<td valign='top'>Sub Category:</td>".
                                                                "<td valign='top' valign='top'>".$subCategory[$imgValue['PatientDocumentDetail']['sub_category_id']]."</td>".
                                                            "</tr>".
                                                            "<tr>".
                                                                "<td valign='top'>Sub Sub Category:</td>".
                                                                "<td valign='top'>".$subIntraOpcategory[$imgValue['PatientDocumentDetail']['intraop_sub_category_id']]."</td>".
                                                            "</tr>".
                                                            "<tr>".
                                                            "<td valign='top'>Package Category :</td>".
                                                            "<td valign='top'>".$pacakgeCategory[$imgValue['GalleryPackageDetail']['package_category_id']]."</td>".
                                                            "</tr>".
                                                            "<tr>".
                                                            "<td valign='top'>Package Sub Category:</td>".
                                                            "<td valign='top' valign='top'>".$pacakgeSubCategory[$imgValue['GalleryPackageDetail']['package_sub_category_id']]."</td>".
                                                            "</tr>".
                                                            "<tr>".
                                                            "<td valign='top'>Package Sub Sub Category:</td>".
                                                            "<td valign='top'>".$pacakgeSubSubCategory[$imgValue['GalleryPackageDetail']['package_subsub_category_id']]."</td>".
                                                            "</tr>".
                                                        "</table>".
                                                      "</div>";  
						echo "</td>";
						$k ++;
					}
				}
				?>
				</table>
		</td>
		<!-- <td width="2%"></td> -->
		<td valign="top" width="55%" id='thumb-area'> 
		</td>
		<!-- <td width="2%"></td> -->
		<td valign="top" width="23%" id='thumb-area-detail'>
                    
		</td>
	</tr>
</table>
<script>

$(document).ready(function(){	
	//BOF-Mahalaxmi for adding rgjay package
	var getServiceId="<?php echo $rgjayPackage;?>";
	 $('.billingDiag').autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","TariffList","id&name",'null',"null",'null',"admin" => false,"plugin"=>false)); ?>"+'/'+'service_category_id='+getServiceId,
	           // setPlaceHolder: false,
	        select: function( event, ui ) {	        	
				currentId = $(this).attr('id') ;
  				splittedVar = currentId.split("_");  				
  				patientId = splittedVar[1];	  				
  				diagnosisId = splittedVar[2];	  					
				$("#actualDiagnosisId_"+patientId+"_"+diagnosisId).val(ui.item.id); 
	        },
	        messages: {
	          noResults: '',
	          results: function() {}
	        }
	    });
	//EOF-Mahalaxmi for adding rgjay package
$(function(){
	  
	  var onSampleResized = function(e){  
	   // var table = $(e.currentTarget); //reference to the resized table
	  };  

	 $("#tableId").colResizable({
	    liveDrag:true,
	    gripInnerHtml:"<div class='grip'></div>", 
	    draggingClass:"dragging", 
	    onResize:onSampleResized
	  });    
	  
	});	
$(function() {
	var $sidebar   = $(".top-header"),
      $window    = $(window),
      offset     = $sidebar.offset(),
      topPadding = 0;

  $window.scroll(function() {
      if ($window.scrollTop() > offset.top) {
          //$sidebar.stop().animate({
           //   top: $window.scrollTop() - offset.top + topPadding
         // });

          $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
      } else {
          $sidebar.stop().animate({
              top: 0
          });
      }
  });
 
});

	 //display image on thumb clicj
	 $(document).on('click','.thumb',function(){
		 //id 
		 splitted_id  = $(this).attr('id').split('_')[1] ;
		 $('#thumb-area').hide().html($('#'+splitted_id).html()).fadeIn(1500);
         $('#thumb-area-detail').hide().html($("#patientDetail_"+splitted_id).html()).fadeIn(1500);
		
        //var categoryId = $('#thumb-area #categoryId_'+splitted_id).val();
        var intraOp = '<?php echo $intraOpPhoto;?>';
        var subCategoryId = $('#thumb-area #subCategoryId_'+splitted_id).val();
       	if(subCategoryId==intraOp){
       		$("#thumb-area #intraOpSubCat_"+intraOp).show();
		  }else{
			 $("#thumb-area #intraOpSubCat_"+intraOp).hide(); 
	     }
	   /*	/$.ajax({
	   		  url: "<?php echo $this->Html->url(array("controller" => 'Radiologies', "action" => "getListOfSubCategory", "admin" => false)); ?>"+"/"+categoryId,
	   		  context: document.body,				  		  
	   		  success: function(data){//alert(data);
	   		  	data= $.parseJSON(data);
	   		  	//$("#thumb-area #subCategoryId_"+docId+" option").remove(); 
	   		  	//$("#thumb-area #subCategoryId_"+docId).append( "<option value=''>Please Select</option>" );
	   			$.each(data, function(val, text) {  
	   			    $("#thumb-area #subCategoryId_"+splitted_id).append( "<option value='"+val+"'>"+text+"</option>" );
	   			});
	   		  }
	   	 });*/
		 
	 }); 
	
	$("#patient_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'IPD',"admin" => false,"plugin"=>false)); ?>",
			setPlaceHolder : false,
			select: function(event,ui){	
				$("#patientId").val(ui.item.id);			
		},
		 messages: {
	         noResults: '',
	         results: function() {},
	   	},
		
	});
	
	$("#package_name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices",$rgjayPackage,'?'=>array('tariff_standard_id'=>$rgjayTariffId),"admin" => false,"plugin"=>false)); ?>",
			setPlaceHolder : false,
			select: function(event,ui){	
				$( "#package_id" ).val(ui.item.id);			
		},
		 messages: {
	         noResults: '',
	         results: function() {},
	   },
		
	});
	
	$('#diagnosis_name').autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "diagnosisKeywordSearch", "admin" => false, "plugin" => false)); ?>",
	    setPlaceHolder : false,
	    select:function(event,ui){
	    	$( "#diagnosis_id" ).val(ui.item.id);		
	    }, 
	    messages: {
	        noResults: '',
	        results: function() {}
	    }
	}); 

	$('#actualDiagnosis').autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "actualDiagnosisSearch", "admin" => false, "plugin" => false)); ?>",
	    setPlaceHolder : false,
	    select:function(event,ui){
	    	$( "#actual_diagnosis_id" ).val(ui.item.id);		
	    }, 
	    messages: {
	        noResults: '',
	        results: function() {}
	    }
	}); 
}); 


$("#fdate").datepicker
({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});	
		
 $("#tdate").datepicker
 ({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});
 
 //to update documents detials like category_id/sub_category_id/intraOp_sub_category_id
 $(document).on('click','.updateDocumentDetials',function(){
	 var documentId = $(this).attr('id').split("_")[1];  
	 
	 $.ajax({
			url: "<?php echo $this->Html->url(array("controller" => 'Radiologies', "action" => "updateDocumentDetials", "admin" => false)); ?>"+'/'+documentId,
			context: document.body,
			method : 'POST',
			data : $("#myForm_"+documentId).serialize(),
			beforeSend:function(){
				$('#busy-indicator').show('fast');
			  },				  		  
			success: function(data){ 
				if(data === "true"){
					window.location.reload();
				}else{
					alert("Something went wrong, please try again!");
					$('#busy-indicator').hide('slow');
				} 
			}  
		});
 }); 
//reset all filters
	$("#resett").click(function (){
		resetFormm();
		$("#submit").val('Search'); // resetformm function clear all input values thats why assign value to submit button
	}); 

    function resetFormm(){
    	var formData = document.getElementById("search-form");
    	$(formData).find('input').each(function() {
        	$(this).val('');
        }); 
    }

	$(document).on('change','.intraOpSubCategoryId',function(){ 
		var id = $(this).attr('id').split("_")[1];
		//console.log($(this).val());
		//$("#"+id).val($(this).val());
		$('#intraOpSubCategoryId_'+id+' option[value='+$(this).val()+']').attr('selected','selected');
	});

	$(document).on('change',".categoryId",function(){
	  var docId = $(this).attr('id').split("_")[1];
      var categoryId = $('#thumb-area #categoryId_'+docId).val();
      $('#thumb-area #categoryId_'+docId+' option[value='+$(this).val()+']').attr('selected','selected');
	 $.ajax({
		  url: "<?php echo $this->Html->url(array("controller" => 'Radiologies', "action" => "getListOfSubCategory", "admin" => false)); ?>"+"/"+categoryId,
		  context: document.body,				  		  
		  success: function(data){//alert(data);
		  	data= $.parseJSON(data);
		  	$("#thumb-area #subCategoryId_"+docId+" option").remove(); 
		  	$("#thumb-area #subCategoryId_"+docId).append( "<option value=''>Please Select</option>" );
			$.each(data, function(val, text) {  
			    $("#thumb-area #subCategoryId_"+docId).append( "<option value='"+val+"'>"+text+"</option>" );
			});
		  }
	 });
	});
			
	$(document).on('change',".subCategoryId" ,function(){
			  var id = $(this).attr('id').split("_")[1];
		      var subCatValue = $("#thumb-area #subCategoryId_"+id).val();
		      $('#thumb-area #subCategoryId_'+id+' option[value='+$(this).val()+']').attr('selected','selected');
		      intraOp = '<?php echo $intraOpPhoto;?>';
		      if(subCatValue== intraOp ){
		    	 $("#thumb-area #intraOpSubCat_"+intraOp).show();
			  }else{
				 $("#thumb-area #intraOpSubCat_"+intraOp).hide(); 
		     }
			});


	$(document).on('change',".category",function(){
		  var catID = $(this).val();
		  var subCat = $(".subCategory").val();
		  if(catID != ''){
			  $("#subCat").show();  	
			}else{
				$("#subCat").hide();  	
			}
		  if(catID == 1 && subCat == 1){
			  $("#subSubCat").show();  	
		   }else{
			   $("#subSubCat").hide();  	
	       }
			 $.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'Radiologies', "action" => "getListOfSubCategory", "admin" => false)); ?>"+"/"+catID,
				  context: document.body,				  		  
				  success: function(data){//alert(data);
				  	data= $.parseJSON(data);
				  	$(".subCategory option").remove();
				  	$(".subCategory").append( "<option value=''>Select Upload Sub Category</option>" );
					$.each(data, function(val, text) {
					    $(".subCategory").append( "<option value='"+val+"'>"+text+"</option>" );
					});
				  }
			});
			});
			
		$(document).on('change',".subCategory" ,function(){
			 var subCatID = $(this).val();
		      if(subCatID == 1){
		    	  $("#subSubCat").show();  	
			  }else{
			  	  $("#subSubCat").hide(); 
		     }
			});

		$("#packageCategory").autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getListOfPackage","admin" => false,"plugin"=>false)); ?>",
			 setPlaceHolder : false,
			 select: function( event, ui ) {
				 $("#packageCategoryId").val(ui.item.id);
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	    $(document).on('focus',"#packageSubCategory",function(){
	    	 var packageCatId = $("#packageCategoryId").val();
	         if(packageCatId == ''){
				alert("Please Select Package Category");
				$("#packageSubCategory").val('');
	          }
	         
		    $(this).autocomplete({
		    	
					 source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getListOfSubPackage","admin" => false,"plugin"=>false)); ?>"+"/"+$("#packageCategoryId").val(),
					 setPlaceHolder : false,
					 select: function( event, ui ) {
						 $("#packageSubCategoryId").val(ui.item.id);
					 },
					 messages: {
					        noResults: '',
					        results: function() {}
					 }
		          
			});
	   });

	    $(document).on('focus',"#packageSubSubCategory",function(){
	   	 var packageCatId = $("#packageCategoryId").val();
	   	 var packageSubCatId = $("#packageSubCategoryId").val();
	      if(packageCatId == ''){
				alert("Please Select Package Category");
				$("#packageSubSubCategory").val('');
	         }
	        if(packageSubCatId == ''){
				alert("Please Select Sub Package Category");
				$("#packageSubSubCategory").val('');
	         }
		    $(this).autocomplete({
					 source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getListOfSubSubPackage","admin" => false,"plugin"=>false)); ?>"+"/"+packageCatId+"/"+packageSubCatId,
					 setPlaceHolder : false,
					 select: function( event, ui ) {
						 $("#packageSubSubCategoryId").val(ui.item.id);
					 },
					 messages: {
					        noResults: '',
					        results: function() {}
					 }
		          
			});
	  });

		$(".billingDiag").blur(function () {  
			//BOF-mahalaxmi for validate if not enter valid actual diagnosis
		 	var errors = 0;
		    $("#tableId :hidden").map(function(){	    
               $('.actual_diagnosis_id').each(function() {//loop through each value hidden serviceId                      
        	    if( !$(this).val() ) {         					
          			$(this).parents('input').addClass('warning');
         			errors++;
    			} else if ($(this).val()) {
         			 $(this).parents('input').removeClass('warning');
   				 }               	 
               });		              
		    });
		   
		    if(errors > 0){
		    	alert("Please Select Valid Actual Diagnosis First.");		        
		        return false;
		    }
		    //EOF-mahalaxmi for validate if not enter valid actual diagnosis			
			var patientId = $(this).attr('id') ;
			splittedId = patientId.split("_"); 
			patient_id=splittedId[1]
			newId = splittedId[2];
			if(newId=='')
				newId='null';
			var val = $(this).val();
			$.ajax({
				url : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "saveBillingDiagnosis", "admin" => false));?>"+"/"+patient_id+"/"+newId,
				data:"billing_diagnosis="+val,
				
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
				}
		});
	    
	}); 
</script> 