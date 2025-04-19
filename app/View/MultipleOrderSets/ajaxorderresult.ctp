  <?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));      
echo $this->Html->script(array('jquery.fancybox-1.3.4'));?>
 
   <br>
   <table border="0" class="table_format_body" cellpadding="0"
				cellspacing="0" width="100%" id="content">
          
			
   
                <tr class="row_title">
                 <?php echo $this->Form->hidden('patient_id',array('value'=>$patient_id,'id'=>'patient_id'))?>
    <td class="table_cell"><strong><?php echo __(' Name', true); ?></th>    
    <td class="table_cell"><strong><?php echo __('Loinc Code', true); ?></th>
      </tr>
  <?php 
   $toggle =0;
      if(count($data) > 0) {
       foreach($data as $key=>$orderresult): 
    
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
   <td class="row_format rxcuiClass" >
   <input type="hidden" name="<?php echo $orderresult['Laboratory']['name'];?>" value="<?php echo $orderresult['Laboratory']['name'];?>" id="<?php echo $key;?>">
   <?php echo $this->Html->link(__($orderresult['Laboratory']['name']),'#',
   		array('onclick'=>'ordersentences("'.$patient_id.'","'.$category.'","'.$orderresult['Laboratory']['lonic_code'].'","'.$orderresult['Laboratory']['name'].'","'.$orderresult['Laboratory']['id'].'")','class'=>'','div'=>false,'label'=>false,"id"=>"result".$orderresult['Laboratory']['lonic_code']));
			?>
			</td>
   <td class="row_format"><?php echo $orderresult['Laboratory']['lonic_code']; ?> </td>
   </tr>
  <?php endforeach;  ?>
 
   <tr>
    <TD colspan="2" align="center">
    <?php
    /* $this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
)); */
 ?>
    <!-- Shows the page numbers -->
 <?php //echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php //echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php //echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <span class="paginator_links"><?php //echo $this->Paginator->counter(); echo $this->Js->writeBuffer();?></span>
    </TD>
   </tr>
   <tr>
   <td align="right" style="padding-right:10px;padding-top:50px" colspan="2"><input class="blueBtn" type="button" value="Done" id="submit1">
   </tr>
  <?php
  
      } else {
  ?>
  <tr>
   <TD colspan="2" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
      
        
  ?>
</table>

<script>
var lastClickedElement = '';
$( ".rxcuiClass" ).click(function() {
	lastClickedElement = $(this);
	
});
$(document).ready(function(){
	$("#submit1").click(function(){
		parent.$.fancybox.close();
		var id=$('#patient_id').val();
		window.top.location.href = '<?php echo $this->Html->url("/patients/orders"); ?>'+"/"+id+"/"+1;
		
		
		});
	});
			</script>