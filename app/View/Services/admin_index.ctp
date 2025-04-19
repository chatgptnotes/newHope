<div class="inner_title">
<h3>&nbsp; <?php echo __('Service Management', true); ?></h3>

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
 <?php echo $this->Form->create('Service',array('id'=>'servicefrm','inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)));?>

<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr>
	<td width="150" align="right" > 
		 <?php echo __('Credit Type'); ?> <font color="red"> *</font>
	</td>
	<td width = "200" align="left"> 
	         
	    <?php
	        echo $this->Form->input('Service.credit_type_id', array('div' => false,'label' => false,'empty'=>__('Please select'),'options'=>array('1'=>'Corporate','2'=>'Insurance'),'id' => 'corporate_id','class' => 'validate[required,custom[mandatory-select]]','onchange'=> $this->Js->request(array('action' => 'getcorporate','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{corporateType:$("#corporate_id").val()}', 'dataExpression' => true, 'div'=>false))));  
	   ?>

			
   </td>
  
  <td width="200" align="left">
   <input class="blueBtn" type="submit" value="Show">
   <?php echo $this->Form->end(); ?>
   </td>
  
  <td align="right">
  <?php 
  	 echo $this->Html->link(__('Add Service'),array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
  	 
  	 if(!empty($this->request->data['Service']['credit_type_id'])){
  	 if($corporate_type != ''){
		 if($corporate_type == 'corporate'){
			$companyHtml = $this->Form->input('Service.corporate_id', array('class' => 'validate[required,custom[mandatory-select]]','empty'=>'Select Corporate','options'=>$corporate_list,'id' => 'corporate_id', 'label'=> false, 'div' => false, 'error' => false));
		 } else if($corporate_type == 'insurance') {
			$companyHtml = $this->Form->input('Service.insurance_company_id', array('class' => 'validate[required,custom[mandatory-select]]', 'empty'=>'Select Insurance', 'options'=>$corporate_list,'id' => 'corporate_id', 'label'=> false, 'div' => false, 'error' => false));
		 }
  	 }   
		$display = "";
	}else{
		$display= 'none';
	}
   ?>
   </td>
  </tr>
  <tr style="display:<?php echo $display ;?>;" id = 'company'>
		<td class="form_lables" valign="top" align="right">
		<?php echo __('Company'); ?> <font color="red"> *</font>
		</td>
		<td id="changeCreditTypeList">  
			<?php 
			 	echo $companyHtml; 
			?>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr class="row_title">   
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Service.name', __('Service', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo  __('Subservice/Cost'); ?></strong></td> 
   <td class="table_cell"><strong><?php echo __('Description'); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></th>
  </tr>
  <?php 
  	  $toggle =0;
      if(count($service) > 0) {
      
      
       foreach($service as $services): 
	       if($toggle == 0) {
	       	echo "<tr class='row_gray'>";
	       	$toggle = 1;
	       }else{
	       	echo "<tr>";
	       	$toggle = 0;
	       }
  ?>  
    
   <td class="row_format"><?php echo ucfirst($services['Service']['name']); ?> </td>
   <td valign="top" style="padding-top:5px;">
		<table width="100%" border="0" cellspacing="1" cellpadding="0" style="border:1px solid #3E474A; border-bottom:0px;">
		    <?php 
		    	
				$count = count($subService) ;
				for($i=0;$i<$count;){			
					if($services['Service']['id']==$subService[$i]['SubService']['service_id'])	{
				?>			
						<tr>
							<td class="row_format" style="border-bottom:1px solid #3E474A;border-right:1px solid #3E474A;text-align:left;">
								<?php echo ucfirst($subService[$i]['SubService']['service']);?> 
							</td>
							<td class="row_format" style="border-bottom:1px solid #3E474A;">
								<?php echo ucfirst($subService[$i]['SubService']['cost']); ?> 
							</td> 
						</tr>	
			   		
			   	<?php
			   			
			   		} 
			   		$i++ ;
		   		}
		   	?>
   		</table>
	</td>
   
   <td class="row_format"><?php echo ucfirst($services['Service']['description']); ?> </td>
   
   <td ><?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view', $services['Service']['id']), array('escape' => false));
    
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $services['Service']['id']), array('escape' => false));
   
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $services['Service']['id']), array('escape' => false),__('Are you sure?', true));
   
   ?></td>
  </tr>
  <?php endforeach;  ?>
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

<script>
	$(document).ready(function(){
		$("#corporate_id").change(function(){
			if($("#corporate_id").val() != ''){
				$("#company").show();
			} else {
				$("#company").hide();
			}
		});

		
	});
</script>