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
	<h3>&nbsp; <?php echo __('Diagnosis Name Management', true); ?></h3>
	
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
	<?php echo $this->Form->create('',array('action'=>'icd','type'=>'get'));?>	
	<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="500px" >		 			    			 				    
			<tr class="row_title">			
				<td class="row_format"><label><?php echo __('Search by Description') ?> :</label></td>
				<td class="row_format">											 
			    	<?php 
			    		 echo    $this->Form->input('description', array('type'=>'text','id' => 'description', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
			    	?>
			  	</td>
			  	<td class="row_format">
			  		<?php 
			    		 echo    $this->Form->submit('Search', array('onclick'=>"return checkLength()",'label'=> false, 'div' => false, 'error' => false,'class'=>'blueBtn'));
			    	?>
			    </td>
			 </tr>
	</table>
	<?php echo $this->Form->end(); ?>
	<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >  
		<tr>
			<td align="right" colspan="3">
				<?php 
			    		 echo    $this->Form->button(__('Apply selection'), array('type'=>'button','id' => 'selection','label'=> false, 'div' => false, 'error' => false,'class'=>'blueBtn'));
			    	?>
			</td>
		</tr>
	  <tr class="row_title">   
	   <td class="table_cell"><strong><?php echo  __('Select'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('Diagnosis name'); ?></strong></td> 
	   <td class="table_cell"><strong><?php echo __('Description'); ?></strong></td>   
	  </tr>
	  <?php 
	  	  $toggle =0;$i=0;
	      if(count($data) > 0) {
	      
	      
	       foreach($data as $icd){ 
		       if($toggle == 0) {
		       	echo "<tr class='row_gray'>";
		       	$toggle = 1;
		       }else{
		       	echo "<tr>";
		       	$toggle = 0;
		       }$i++;
	  ?> 
	    <?php
echo $this->Form->hidden('icdloc',array('id'=>'icdloc','value'=> $data[0]['SnomedMappingMaster'][patient_id],'autocomplete'=>"off"));
?>
		   <td class="row_format"><?php echo $this->Form->checkbox('',array('name'=>$icd['SnomedMappingMaster']['id'],'value'=>$icd['SnomedMappingMaster']['mapTarget']." :: ".$icd['SnomedMappingMaster']['sctName'])); ?> </td>
		   
		   <td class="row_format" valign="top" style="padding-top:5px;"><?php echo $icd['SnomedMappingMaster']['mapTarget']; ?>
		   			
		   </td>   
		   <td class="row_format"><?php echo ucfirst($icd['SnomedMappingMaster']['sctName']); ?> </td>   
	  	</tr>
	  	<?php }  ?>
	   	<tr>
		    <TD colspan="8" align="center" class="row_format">
		    <!-- Shows the page numbers -->
		 	<?php 
		 		 $this->Paginator->options(array('url' => array("?"=>$this->request->query))); 		
		 		echo $this->Paginator->numbers(array('class' => 'paginator_links')); 
		 	
		 	?>
		 	<!-- Shows the next and previous links -->
			<?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
		 	<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
		 	<!-- prints X of Y, where X is current page and Y is number of pages -->
		 	<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
		    </TD>
	   	</tr>
	  	<?php  
	      }else{  ?>
	  	<tr>
	   		<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
	  	</tr>
	  	<?php
	      }
	  ?>  
 </table>
	</body>

	<script>	   
  		$(document).ready(function(){    	 
			/*$("#description").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","icd","description", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});*/
		 	$('#selection').click(function(){
		 
		 	    var  icd_text='' ;
				var icd_ids = $( '#icd_ids', parent.document ).val();		 				 	 
		 		$("input:checked").each(function(index) { 
		 		//var icd_code=$(this).val().split("-");
		 		//alert($(this).val());
		 		
		 			 if($(this).attr('name') != 'undefined'){
		 				var icd_code=$(this).val().split(" ");
		 				alert(icd_code);
				       var icd = $(this).attr('name');
				       alert(icd);
				    	icd_text +=  "<p id='icd_"+$(this).attr('name')+"' style='padding:0px 10px;'><a href='javascript:openbox("+icd+")'>"+$(this).val()+"</a><img align='right' class='icd_eraser' src='../../img/icons/cross.png' alt='Remove' style='cursor: pointer;' title='Remove' onclick='javascript:remove_icd("+$(this).attr('name')+");' id='ers_"+$(this).attr('name')+"'</p>";
				       	icd_ids  += $(this).attr('name')+"|";
				       
				    }
				});		 		
				//icd_text += "<table>";
				//alert(('#chkbox', parent.document).attr("checked"));
				$('#chkbox', parent.document).removeAttr('checked');
				$('#icdSlc', parent.document).show();
		 		$( '#icdSlc', parent.document ).append(icd_text);
		 		$( '#icd_ids', parent.document ).val(icd_ids);
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