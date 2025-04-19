<style>
.table_format {
    padding: 0px !important;
}
.table_format tr td {
    text-align: left !important;
}
.tempData1 {
    height: 269px !important;
}
.tempData, .tempData1 {
    padding-top: 0px !important;
}
.tempHead {
    background: #8B8B8B !important;
    color: white;
}
.row_format a {
    color: 	#31859c  !important;
    font-size: 13px !important;
}

.table_format tr:nth-child(even) {background: #CCC !important}
.table_format tr:nth-child(odd) {background: #e7e7e7 !important}

</style>
<?php
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
<?php } ?>
 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
		<td width="374" align="left" valign="top">
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	          	
	            <td width="100%" align="left" valign="top" class="tempSearch"> 
	               
	                <div id="search_template" style="margin:0px 3px;">
						<p> Templates: 
						<?php								
								 echo 	$this->Form->input('',array('name'=>$template_type,'id'=>'search','autocomplete'=>'off', 'label'=>false,'div'=>false,'value'=>'Search',
										"style"=>"margin-right:3px;","onfocus"=>"javascript:if(this.value=='Search'){this.value='';  }",
										"onblur"=>"javascript:if(this.value==''){this.value='Search';} "));
								 
								 echo $this->Js->link($this->Html->image('icons/refresh-icon.png'), array('alt'=>'Reset search','title'=>'Reset search','action' => 'template_add',$template_type), 
								 array('escape' => false,'update'=>"#$updateID",
								 'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								  'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
								   			
								 
								 echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'add-template','style'=>'padding-left:5px;cursor:pointer'));
							?>
						</p>
					</div>	
	                <?php echo $this->Form->create('RadiologyTemplate',array('action'=>'radiology_template','id'=>'RadiologyTemplatefrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false)));?>
						 						 
					 	<?php //BOF dialog form 
					 		if(!empty($this->data['RadiologyTemplate']['id'])){
					 			$template_form  = "block";
					 		}else{
					 			$template_form  = "none";
					 		}
					 	?>
					 	<div id="add-template-form" style="display:<?php echo $template_form ;?>;">
							
							<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
								<tr>
									<td style="text-align:center;"><?php echo __('Template');?>:</td>
									<td><?php 
											echo $this->Form->hidden('id');
											echo $this->Form->hidden('radiology_id',array('value'=>$labID));
											echo $this->Form->input('template_name',array('type'=>'text'));
											echo $this->Form->hidden('template_type',array('value'=>$template_type));
											
											
									 ?>	</td>
								</tr>
								
								<tr>
									<td colspan="2" align="right">		
								   		<?php echo $this->Html->link(__('Cancel'),"#",array('id'=>'close-template-form','class'=>'grayBtn')); ?>			     	 
										<?php echo $this->Js->submit('Submit', array('class' => 'blueBtn','div'=>false,'update'=>"#$updateID",'method'=>'post','url'=>array('controller'=>'radiologies','action'=>'radiology_template',$updateID,$labID)	)); ?>
										<?php //echo $this->Js->link(__('Submit'),array('controller'=>'radiologies','action'=>'Radiology_template'),array('class'=>'blueBtn','div'=>false,'update'=>'#templateArea','method'=>'post')); ?>
				 
									</td>
								</tr>
							</table>						 
						</div>
					 <?php echo $this->Form->end(); ?>
	            </td>
	          </tr>
	          <tr>
	            <td width="100%" align="left" valign="top" height="10"></td>
	          </tr>
	          <tr>
	            <td width="100%" align="left" valign="top" class="tempDataBorder">
	            	<p class="tempHead">Frequent templates:</p>
	            	<div class="tempData" id="template-list-<?php echo $template_type ;?>">
	                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="table_format" >
	                    	 
	                        <?php 
							      $cnt =0;
							      if(count($data) > 0) {
							       foreach($data as $Radiologytemp):
							       $cnt++;
							  ?>
								   <tr>		
								  
									 <!--   <td align="right">
									   <?php
									   		if($Radiologytemp['RadiologyTemplate']['user_id']=='0'){
									   			echo  $this->Html->image('icons/favourite-icon.png', array('title'=> __('Admin Template', true), 'alt'=> __('Radiology Template Edit', true)));
									   		}else{
									   			echo "&nbsp;";
									   		}  
									   ?>
									   </td>   --> 
								   <td class="row_format " style="font-size:11px;">
								   		<?php 
								   		 
								   		 	echo $this->Js->link($Radiologytemp['RadiologyTemplate']['template_name'] , array('action' => 'add_template_text', $Radiologytemp['RadiologyTemplate']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    	 											'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
								   			 
								   		?>
								   </td>
								   <td class="row_format">
								   <?php
									  /* if($Radiologytemp['RadiologyTemplate']['user_id']=='0'){
									   		echo "&nbsp;";
									   }else{*/
								   			echo $this->Js->link($this->Html->image('icons/edit-icon.png',array('style'=>'float:right') ,array('title'=> __('Radiology Template Edit', true), 'alt'=> __('Radiology Template Edit', true))),
								   								 array('action' => 'template_add',$template_type, $Radiologytemp['RadiologyTemplate']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    							'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));

								   			

										
								   	//	}	  
								 
								   ?>
								   </td>
								   <td>
								   	<?php echo $this->Js->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete Template', true), 'alt'=> __('Delete Discharge Template', true))),
								   								 array('action' => 'template_delete', $Radiologytemp['RadiologyTemplate']['id'],$Radiologytemp['RadiologyTemplate']['radiology_id'],'admin'=>true), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    							'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)))); ?>
								   </td>
								  </tr>
							  <?php endforeach;  ?>				   
					  <?php		  
					      } else {
					  ?>
						  <tr>
						   		<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
						  </tr>
					  <?php
					      }	
					      ?>
	                    </table>
	                </div>
	            </td>
	          </tr>
	      </table>
    	</td>
    </tr>
</table>
			<?php
		      echo $this->Js->writeBuffer(); 	//please do not remove 
		  ?>		  
	 
<script>
			jQuery(document).ready(function(){
				$('#selection').click(function(){		 	 
			 	    var  icd_text='' ;
					var icd_ids = $( '#diagnosis', window.opener.document ).val();		 				 	 
			 		$("input:checked").each(function(index) {
			 			 if($(this).attr('name') != 'undefined'){    	
					        $( '#diagnosis', window.opener.document ).val($( '#diagnosis', window.opener.document ).val()+"\r\n"+$(this).val());
					    }
					});		 	
			 		window.close();
		 	     });
		 		$('#add-template').click(function(){
		 			$('#search_template').fadeOut('slow');
		 			$('#add-template-form').delay(800).fadeIn('slow');		 			
		 			return false ;
		 		});
			 
				$('#close-template-form').click(function(){
		 			$('#add-template-form').fadeOut('slow');
		 			$('#search_template').delay(800).fadeIn('slow');
		 			return false ;
		 		});

	 			//BOF template search
	 			$('#search').keyup(function(){
		 			//collect name of search ele
		 			var searchName = $(this).attr('name');
		 			var replacedID = "templateArea-"+searchName ;	
		 			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'radiologies', "action" => "template_search",'radiology',"admin" => false)); ?>";
 					$.ajax({  
			 			  type: "POST",						 		  	  	    		
						  url: ajaxUrl,
						  data: "searchStr="+$(this).val(),
						  context: document.body,
						  beforeSend:function(){
					    		// this is where we append a loading image
					    		$('#busy-indicator').show('fast');
						  },					  		  
						  success: function(data){	
							 
							    $('#busy-indicator').hide('fast');				 					 				 								  		
						   		$("#template-list-"+searchName).html(data);								   		
						   		$("#template-list-"+searchName).fadeIn();
						   		
						  }
					});
	 			});
	 			//EOF tempalte search
						
			});	
</script>
				