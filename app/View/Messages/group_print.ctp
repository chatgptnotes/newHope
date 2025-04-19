<style>
@media print {
    #printButton {
      display: none;
    }
    
    #hideFromPage{
    display: none;
    }
  }
  body{
    margin: 0;
  }
.row_gray{
  #acdef6 none repeat scroll 0 0 !important
}
</style>

<div class="inner_title">
<h3><?php echo __('SMS Group', true);?></h3>
</div>
<div id="printButton" style="float: right;">
  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
</div>
<table border="0" class="table_view_format" cellpadding="0" cellspacing="0" style="width:50% !important" align="left"> 
        <tr> 
  <tr class="row_title">
    <td class="table_cell" align="left"><strong><?php echo  __('Name', true); ?></strong></td>
  <td class="table_cell" align="left"><strong><?php echo  __('Active', true); ?></strong></td>  
  </tr>
  <?php 
      $cnt =0;  
      if(count($data) > 0) {
       foreach($data as $datas): 
        $cnt++;
    
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format" align="left"><?php echo $datas['GroupSms']['name']; ?> </td>
    <td class="row_format" align="left">
   <?php if($datas['GroupSms']['is_active'] == 1) {          
             $imgSrc = 'active.png';
             $activeTitle = 'Active';
             $status = 0;
          } else {           
             $imgSrc = 'inactive.jpg';
             $activeTitle = 'InActive';
             $status = 1;
          }
    echo  $activeTitle; ?></td>
   
  </tr>
  <?php endforeach;  ?>  
  <?php } else { ?>
  <tr>
    <TD colspan="2" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php }?>  
 </table>
