<?php  
                     echo $this->Form->create('Estimate', array('url' => array('controller' => 'estimates', 'action' => 'lab_test_order',$patient_id)
                 ,'id'=>'ordertestfrm' ,
                    'inputDefaults' => array(
                       'label' => false,
                       'div' => false,'error'=>false
                   )
      ));  
      
      //echo $this->Form->hidden('LaboratoryTestOrder.id');
?> 
   <table width="" cellpadding="0" cellspacing="0" border="0" align="left">
                    <tr>
                         <td width="60" class="tdLabel2"><strong>Search</strong></td>
                            <td width="300">
                            <?php 
                             echo $this->Form->input('search', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','id'=>'lab-search','autocomplete'=>'off'));
                             echo $this->Form->hidden('LaboratoryTestOrder.patient_id', array('value'=>$patient_id));
                             
                              
                            ?> 
                            </td>
                            <td>
                            <div align="center" id = 'temp-busy-indicator' style="display:none;"> 
         &nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
        </div>
       </td>                            
                        </tr>
                   </table>
                   <div class="clr ht5"></div>
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                     <tr>
                         <th width="50%">Lab Test Names</th>
                            <th width="50%">Lab Tests To Be Ordered</th>
                        </tr>
                        <tr>
                         <td valign="top">
                           <!--<div id="test-data" style="display:block;">
                              --><table width="100%" cellpadding="0" cellspacing="0" border="0">
                               <tr>
                                <td width="85%">
                                 <?php 
                                  echo $this->Form->input('toTest',array('options'=>$test_data,'escape'=>false,'multiple'=>true,'style'=>'width:90%;min-height:100px;','id'=>'SelectLeft'));
                                 ?>
                                </td>
                                <td width="15%">
                                 <input id="MoveRight" type="button" value=" >> " />
                 <input id="MoveLeft" type="button" value=" << " />
                                </td>
                               </tr>
                               <?php
                                 
                                /*foreach($test_data as $key =>$data){
                                 echo "<tr id=lab-".$key.">";
                                         echo "<td>"."<a href='#'>".$data."</a></td>";
                                       echo "</tr>"; 
                                } */
                               ?>                                  
                                 </table><!--
                                </div>
                          --></td>
                            <td valign="top">
                             <?php 
                               echo $this->Form->input('LaboratoryTestOrder.laboratory_id',array('options'=>array(),'escape'=>false,'multiple'=>true,'style'=>'width:90%;min-height:100px;','id'=>'SelectRight'));
                             ?>
                              <!--<table width="100%" cellpadding="0" cellspacing="0" border="0">
                              <?php
                               /*foreach($test_ordered as $ord_key =>$ord_data){
                                echo "<tr id=lab-".$ord_key.">";
                                        echo "<td>"."<a href='#'>".$test_data[$ord_key]['Laboratory']['name']."</a></td>";
                                      echo "</tr>"; 
                               } */ 
                              ?>                                  
                             </table> -->
                         </td>
                        </tr>
                   </table>
                   <!-- billing activity form end here -->
                    <div>&nbsp;</div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                        <tr>
                             <td width="50%" align="left">
                              <!--<input name="" type="button" value="Order More" class="blueBtn"/> -->
                             </td>
                                <td width="50%" align="right">
                                 <?php
                                 		
										echo $this->Form->submit(__('Submit'), array('id'=>'add-more','title'=>'Submit','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                  		//echo $this->Html->link(__('Cancel'), array('controller'=>'patients','action' => 'patient_information',$patient_id), array('escape' => false,'class' => 'grayBtn'));
                                  ?>
                                </td>
                            </tr>
                      </table>     
                      
 <?php echo $this->Form->end() ;?>
    <script language="javascript" type="text/javascript">
       
       
  $(document).ready(function(){   
   $("#lab-search").keyup(function () { 
    $.ajax({
       url: "<?php echo $this->Html->url(array("controller" => 'laboratories', "action" => "ajax_sort_test", "admin" => false)); ?>",
       data:{"searchParam":$("#lab-search").val(),"patient_id":<?php echo $patient_id ;?>},
       context: document.body,
       beforeSend:function(){
         //this is where we append a loading image
      $('#temp-busy-indicator').show('fast');
         },          
       success: function(data){ 
            $('#temp-busy-indicator').hide('fast');                    
         data= $.parseJSON(data);
         $("#SelectLeft option").remove();
       $.each(data, function(val, text) {
           $("#SelectLeft").append( "<option value='"+val+"'>"+text+"</option>" );
       });             
       }
    });             
   
   });

   $('#ordertestfrm').submit(function(){
    $("#SelectRight option").attr("selected","selected");    
   });
  });

  
   $(function() {
             $("#MoveRight,#MoveLeft").click(function(event) {
                 var id = $(event.target).attr("id");
                 var selectFrom = id == "MoveRight" ? "#SelectLeft" : "#SelectRight";
                 var moveTo = id == "MoveRight" ? "#SelectRight" : "#SelectLeft";
  
                 var selectedItems = $(selectFrom + " :selected").toArray();
                 $(moveTo).append(selectedItems);
                 selectedItems.remove;
             });
         });
 </script>