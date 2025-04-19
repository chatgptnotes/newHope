<div class="inner_title">
 <h3>	
  <div style="float:left"><?php echo __('View Corporate Sublocation Details'); ?></div>			
  <div style="float:right;">
   <?php
	echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  </div>
 </h3>
<div class="clr"></div>
</div>
<table border="0" cellpadding="0" cellspacing="0" align="center" class="table_view_format">
<!-- <tr class="first">
  <td class="row_format"><strong>
   <?php echo __('Corporate Location',true); ?>
  </td>
  <td>
   <?php echo $corporatesublocation['CorporateLocation']['name']; ?>
  </td>
 </tr> -->
 <tr >
  <td class="row_format"><strong>
   <?php  echo __('Corporate Name',true); ?>
  </td>
  <td>
   <?php echo $corporatesublocation['TariffStandard']['name']; ?>
  </td>
 </tr> 
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Corporate Sublocation Name',true); ?>
  </td>
  <td>
   <?php echo $corporatesublocation['CorporateSublocation']['name']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Description',true); ?>
  </td>
  <td>
   <?php echo $corporatesublocation['CorporateSublocation']['description']; ?>
  </td>
 </tr>
  <tr>
      <td><strong><?php echo __('Doctor`s Name',true); ?></strong></td>
      <td><strong><?php echo __('Mobile No',true); ?></strong></td>
  </tr>
 <?php $unserializeDocName=unserialize($corporatesublocation['CorporateSublocation']['dr_name']);
 $unserializeMobileNo=unserialize($corporatesublocation['CorporateSublocation']['mobile']);
 foreach ($unserializeDocName as $key => $value) {?>
      <tr>
          <td><?php echo $value;?></td>
          <td><?php echo $unserializeMobileNo[$key];?></td>
      </tr>
 <?php }?>
 
 </table>
