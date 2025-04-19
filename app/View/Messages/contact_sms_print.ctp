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
<h3><?php echo __('Contact SMS Group', true);?></h3>
</div>
<div id="printButton" style="float: right;">
  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
</div>
<table border="0" class="table_view_format" cellpadding="0" cellspacing="0" style="width:50% !important" align="left">   
  <td class="form_lables">
  <?php echo __('Group Name',true); ?><font color="red">*</font>
  </td>
  <td><?php echo $data['GroupSms']['name'];
   
     ?></td>
  </tr>
   <tr>
  <td class="form_lables">
  <?php echo __('Manager Name',true); ?><font color="red">*</font>
  </td>
  <td><?php echo $data['GroupSms']['manager_name'];
     ?></td>
  </tr>

    <tr>
  <td class="form_lables">
  <?php echo __('Manager Mobile No.',true); ?><font color="red">*</font>
  </td>
  <td><?php echo $data['GroupSms']['manager_mobile_no'];
     ?></td>
  </tr>
         <tr>
    <td class="form_lables">
     <?php echo __('Is Active',true); ?><font color="red">*</font>
    </td>
    <td>
      <?php 
           if($data['GroupSms']['is_active'])
      echo "Yes";
     else
      echo "No";?>
    </td>
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
          <th align="center"><?php echo __('Initial');?><font color="red">*</font>
          </th>
          <th align="center"><?php echo __('Contact Name');?><font color="red">*</font>
          </th>
          <th align="center"><?php echo __('Mobile');?>
          </th>   
          <th align="center"><?php echo __('Corporate');?>
          </th> 
          <th align="center"><?php echo __('Location');?>
          </th> 
          <th align="center"><?php echo __('Other Information');?>
          </th>               
         
        </tr>

    <?php if($data['ContactSms']){ ?>
        <?php $key = 0;?>
        <?php  foreach($data['ContactSms'] as $keyM=>$value){?>
      <tr id="removePackageData-<?php echo $key;?>">  
          <td style="padding-left:10px;"><?php $radiologySrNo = $key+1;
          echo $initials[$value['initial_id']];
              ?>
          <td  style="padding-left:10px;"><?php 
          echo $value['name']; ?>
          </td>
           <td  style="padding-left:10px;"><?php 
          echo $value['mobile']; ?>
          </td>
          <td style="padding-left:10px;"><?php  echo $tariffStandardData[$value['corporate_id']];
            ?>
          </td>
          <td style="padding-left:10px;">
           <?php if(!empty($corporateSublocationData[$value['sublocation_id']])){
                      $location=$corporateSublocationData[$value['sublocation_id']];
                    }else{
                      $location=$value['sublocation_id'];
                    }
              echo $location;  ?>   
              <?php   if(!empty($value['city_id'])){
                        echo ",City:".$dataCity[$value['city_id']];
                      }?>                 

             
          </td>
          <td style="padding-left:10px;"><?php echo $value['other_info'];
            ?>
          </td>          
        </tr>
        <?php $key++; 
              } ?>
   <?php }
        ?>
      </table>
  </td>
  </tr> 
   
  </table>