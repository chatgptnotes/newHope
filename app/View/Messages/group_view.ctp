<div class="inner_title">
 <h3>	
 <?php echo __('View Group'); ?></h3>
 <span>
<?php
echo $this->Html->link(__('Back', true),array('controller' => 'Messages', 'action' => 'groupIndex','admin'=>false), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
  </div>
 
<div class="clr"></div>
<table border="0" class="table_view_format" cellpadding="0" cellspacing="0" style="width:50% !important" align="left">    
        <tr>
  <td class="form_lables">
  <?php echo __('Group Name',true); ?><font color="red">*</font>
  </td>
  <td><?php echo $getGroupSms['GroupSms']['name'];
     ?></td>
  </tr>
     <tr>
  <td class="form_lables">
  <?php echo __('Manager Name',true); ?><font color="red">*</font>
  </td>
  <td><?php echo $getGroupSms['GroupSms']['manager_name'];
     ?></td>
  </tr>

    <tr>
  <td class="form_lables">
  <?php echo __('Manager Mobile No.',true); ?><font color="red">*</font>
  </td>
  <td><?php echo $getGroupSms['GroupSms']['manager_mobile_no'];
     ?></td>
  </tr>

         <tr>
    <td class="form_lables">
     <?php echo __('Is Active',true); ?><font color="red">*</font>
    </td>
    <td>
     <?php 
           if($getGroupSms['GroupSms']['is_active'])
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
            <?php
            foreach($getGroupSms['ContactSms'] as $getGroupSmss){?>
            <tr>
              <td style="padding-left:10px;"><?php echo $initials[$getGroupSmss['initial_id']];
              ?>
              </td>
              <td style="padding-left:10px;"><?php echo $getGroupSmss['name'];
              ?>
              </td>
              <td><?php echo $getGroupSmss['mobile'];?>
              </td> 
              <td style="padding-left:10px;">
              <?php echo $tariffStandardData[$getGroupSmss['corporate_id']]; ?>
              </td>
              <td style="padding-left:10px;">
              <?php if(!empty($corporateSublocationData[$getGroupSmss['sublocation_id']])){
                      $location=$corporateSublocationData[$getGroupSmss['sublocation_id']];
                    }else{
                      $location=$getGroupSmss['sublocation_id'];
                    }
              echo $location; 
                if(!empty($value['city_id'])){
                        echo ",City:".$dataCity[$value['city_id']];
                      }?>             
              </td>
              <td style="padding-left:10px;"><?php echo $getGroupSmss['other_info'];  ?>
              </td>
             
            </tr>
            <?php }  ?>
          </table>
      </td>
      </tr>       
      </table>
  </td>
  </tr>
  </table>

