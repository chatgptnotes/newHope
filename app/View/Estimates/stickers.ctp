<style >
  .add{
   font-size:13px;
   max-width:200px !important;
      word-wrap:break-word;
  }
  .p{
   font-size:11px;
   font-style: italic;
  }
  td{
   text-align: justify;
      text-justify: inter-word;
      
  }
 </style>
 <?php
  echo '<table style="width:800px;margin-top:40px;table-layout: fixed;" border="1">';
  //$sql = "SELECT `batch_name`  FROM `coupons` WHERE `parent_id` NOT LIKE '0' AND `type`='Privilege Card'";
   // $result = $conn->query($sql);
   
    if (count($data) > 0) {
     echo '<tr style="padding-right:5px;">';
     $cnt = 0;
     foreach($data as $key =>$val){
      echo '<td fixed-width="30%" align="center" valign="middle" style="word-wrap: break-word;height:120px;padding-left:35px;">';
      echo "<span ><b>".$val."</span></b>";//<br><span class=''>".$val."</span>
      echo '</td>';
      $cnt++;
      if($cnt==3){
       $cnt=0;
       echo '</tr><tr style="padding-right:5px;">';
      }
     }
     echo '</table>';
    }else{
     continue;
    }
  ?>