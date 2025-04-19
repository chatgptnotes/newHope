<div class="inner_title">
<h3> &nbsp; <?php echo __('OR Item Requisition', true); ?></h3>
<span><?php echo $this->Html->link(__('Back'), "/", array('escape' => false,'class'=>'blueBtn'));?> </span>
</div>
<div class="btns"><?php echo $this->Html->link(__('Add'), array("action"=>"otReplacement"), array('escape' => false,'class'=>'blueBtn'));?></div>

<table   cellspacing="1" cellpadding="0" border="0" id="tabularForm" class="tabularForm" width="100%">
<tr class="row_title">
 
  <th align="center" style="text-align:center;"><?php echo __('Sr.', true); ?></th>
 	<th align="center" style="text-align:center;"> <?php echo  $this->Paginator->sort('OtReplace.opt_id', __('OR Room')) ; ?> </th>
	<th align="center" style="text-align:center;"> <?php echo  $this->Paginator->sort('OtReplace.opt_table_id', __('OR Table')) ; ?> </th>
	<th align="center" style="text-align:center;"> <?php echo  $this->Paginator->sort('OtReplaceDetails.create_time', __('Date')) ; ?></th>
 
	<th align="center" style="text-align:center;"> <?php echo   __('Action')  ;?></th>
 </tr>
 
  <?php 
      $cnt =0;
      if(count($ot_replace_lists) > 0) { 
       foreach($ot_replace_lists as $ot_replace_list): 
	  	 
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
    <td class="row_format" align="center">
		<?php
			echo $cnt;
		?>
	</td>
 
	 <td class="row_format" align="center">
		<?php
			echo  $ot_replace_list['Opt']['name']; 
		 
		?>
	</td>
	 <td class="row_format" align="center">
		<?php
			echo  $ot_replace_list['OptTable']['name']; 
		 
		?>
	</td>
	 <td class="row_format" align="center">
		<?php
			echo $this->DateFormat->formatDate2local($ot_replace_list['OtReplace']['create_time'],Configure::read('date_format'),false);
		 
		?>
	</td>
 
   <td align="center">
 
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit OR Medical Replacement', true),'title' => __('Edit OR Medical Replacement', true))),array('action' => 'otReplacement', $ot_replace_list['OtReplace']['id'],"edit"), array('escape' => false));
   ?>
    <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View OR Medical Replacement', true),'title' => __('View OR Medical Replacement', true))), array('action' => 'otReplacement', $ot_replace_list['OtReplace']['id'],"view"), array('escape' => false));
   ?>
   <?php 
   echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print OR Medical Replacement', true),'title' => __('Print OR Medical Replacement', true))), array('action' => 'otReplacement', $ot_replace_list['OtReplace']['id'],"print"), array('escape' => false,"target"=>"blank"));
   ?>
    
   
   </td>
 
	 </tr>
	 	<?php endforeach;  ?>
	 
  <?php
      }else{
	?>
  	<tr><td colspan="5" align="center"> No Data found.</td></tr>
  <?php
  }
  ?>
</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table align="center">
   <tr>
    <TD colspan="10" align="center">
     <!-- Shows the page numbers -->
     <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     <!-- Shows the next and previous links -->
     <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
     <?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
     <!-- prints X of Y, where X is current page and Y is number of pages -->
     <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
    </TD>
   </tr>
</table>
                     
      