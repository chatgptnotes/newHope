<style> .rowaction{text-align: center;}
.rowaction img{float:inherit;}</style>
<div class="inner_title">
<h3> &nbsp; <?php echo __('Medical Requisition - List', true); ?></h3>
<span> <?php echo $this->Html->link(__('Add'), array("action"=>"medical_requisition"), array('escape' => false,'class'=>'blueBtn'));?> </span>
</div>
 <p class="ht5"></p>
<table   cellspacing="1" cellpadding="0" border="0" id="tabularForm" class="tabularForm" width="100%">
<tr class="row_title">

  <th align="center" style="text-align:center;"><?php echo __('Sr.', true); ?></th>
 	<th align="center" style="text-align:center;"> <?php echo __('Requisition for', true); ; ?> </th>
 	<th align="center" style="text-align:center;"> <?php echo  $this->Paginator->sort('MedicalRequisition.create_time', __('Date')) ; ?></th>
 <th align="center" style="text-align:center;"> <?php echo  $this->Paginator->sort('MedicalRequisition.status', __('Status')) ; ?></th>
	<th align="center" style="text-align:center;"> <?php echo   __('Action')  ;?></th>
 </tr>

  <?php
      $cnt =0;
      if(count($medical_requisition_list) > 0) {
       foreach($medical_requisition_list as $medical_requisition):

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
			echo ucfirst($medical_requisition['MedicalRequisition']['for']);
		?>

           (<?php
			echo ucfirst($medical_requisition['MedicalRequisition']['requisition_for']);
		?>)
	</td>
	 <td class="row_format" align="center">
		<?php
			echo $this->DateFormat->formatDate2local($medical_requisition['MedicalRequisition']['create_time'],Configure::read('date_format'),false);

		?>
	</td>
 <td class="row_format" align="center">
		<?php
			echo $medical_requisition['MedicalRequisition']['status'];
		?>
	</td>
   <td class="rowaction" >

   <?php
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Medical Requisition', true),'title' => __('Edit Medical Requisition', true))),array('action' => 'medical_requisition', $medical_requisition['MedicalRequisition']['id'],"edit"), array('escape' => false));
   ?>
     <?php
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Medical Requisition', true),'title' => __('View Medical Requisition', true))), array('action' => 'medical_requisition', $medical_requisition['MedicalRequisition']['id'],"view"), array('escape' => false));
   ?>
   <?php
   echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print Medical Requisition', true),'title' => __('Print Medical Requisition', true))), array('action' => 'medical_requisition', $medical_requisition['MedicalRequisition']['id'],"print"), array('escape' => false,"target"=>"_blank"));
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

