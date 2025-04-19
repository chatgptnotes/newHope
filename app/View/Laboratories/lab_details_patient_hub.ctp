<?php echo $this->Html->css("tab_menu.css"); ?>
<style>
    body{
        font-family:  "trebuchet MS","Lucida sans",Arial;
    }
    
    #table {
        display: table; 
        width: 100%; 
        background: #FFFFC4;
        margin: 0;
        box-sizing: border-box; 
     }
     
     #tab_css ul {
     	background: none !important;
     }   

     .caption {
        display: block;
        width: 100%;
        background: #64e0ef; 
        padding-left: 10px;
        color: #fff;
        font-size: 15px; 
        text-shadow: 1px 1px 1px rgba(0,0,0,.3);
        box-sizing: border-box;
     } 
     .header-row {
            background: #B6F8DE;
            color: black; 
     } 
    .row {
        display: table-row;
    } 
    .cell {
        display: table-cell; 
        padding: 6px; 
        border-bottom: 1px solid #e5e5e5;
        text-align: center;
    } 
    .alignLeft {
        text-align: left;
    } 
    .alignRight{
        text-align: right;
    }
    
    .paidAmount{
        background-color: #27ae60;
        color:white;
    }
    
     .pendingAmount{
        background-color: #ea6153;
        color:white;
    }
    
    .serviceAddTable{
      text-align: left;
      padding-bottom: 2%;
    }
    .row_format {
   		padding: 0px 0px !important;
	}
	label{
	text-align: left !important;
	  padding-top: 15px !important;
	}
	
	.infoDiv {
	    color: #454545;
	    font-size: 15px !important;
	    line-height: 25px;
	    margin: 0px !important;
	    padding: 0 0 0 11px !important;
	    width: 680px;
	}
	
	.visitDetails {
    border-bottom: 2px solid #b6f8de;
    clear: both;
    float: left !important;
    max-height: 500px !important;
    overflow: auto;
    width: 700px !important;
}

#tab_css > ul > li.active > a::after, #tab_css > ul > li:hover > a::after, #tab_css > ul > li > a:hover::after {
    background: #B6F8DE none repeat scroll 0 0 !important;
    color: black !important;
    font-weight: bold;
}

#tab_css > ul > li.active > a, #tab_css > ul > li:hover > a, #tab_css > ul > li > a:hover {
    color: blue !important; 
     text-shadow:none !important; 
      font-weight: bold; 
}
</style>

			<h3 style="border-bottom: solid 4px #20B2AA">Laboratory/Radiology Details</h3>
			 	<!-- BOF for previour encounter list -->
				<?php $count=count($encounterId);
				if($count>1){
				?>
				<div  style="max-width: 600px !important; float: none !important;">
					<div style="width: -moz-fit-content;float: none !important;">
						<strong style="color:navy;">Encounters Of Patient :</strong>
					</div>
					<div style="background-color: #b6f8de;  max-width: 500px !important;overflow-x: scroll; 
					overflow-y:hidden;white-space: nowrap;float: none !important;width:500px!important " >
						<?php $regDate=explode(' ',$regDate);
							foreach($encounterId as $encounterId){ 
						//for($p=0;$p<=$count-1;){
							$date=$this->DateFormat->formatDate2Local($encounterId['Patient']['form_received_on'],Configure::read('date_format'),false);
							if($date==$regDate['0'])continue;?>
						<span><?php $class='';
						if($encounterId['Patient']['id']==$this->params->pass[0]){
							$class='activeLink';
						 }
							echo $this->Html->link($date,'javascript:void(0)',
									array('class'=>"link $class",'style'=>$style,'id'=>'previousEncounter_'.$encounterId['Patient']['id'],'escape' => false,'label'=>false,'div'=>false));?>
						</span>
						<?php  }//$p++;}?>
					</div>
				</div>
				<?php }?>
				<!-- EOF for previour encounter list -->
			
				 <div style="float: left;">
       	 <table width="1" cellpadding="0" cellspacing="0" id="table" cellpadding="0" border="0" >  
        	 <tr>
                <th colspan="4">
                    <div id='tab_css' style="float: none !important;">
                        <ul>
                        <!--    <li  class="row active"><a href='#'>Services</a></li> --> 
                           <li  id="row_1" class="row active"><a href='#'>Laboratory</a></li>
                           <li id="row_2" class="row"><a href='#'>Radiology</a></li>
                         <!--    <li id="row_2" class="row"><a href='#'>physiology</a></li>-->
						</ul>
                                      
                    </div>
                </th>
            </tr>  
              <tbody id="section_1" class="section">
                <tr>
                    <td colspan="4">
                    <div class="visitDetails" style="float: left;">
                    <?php if (!empty($labs)) { ?>
                        <table cellspacing="0" width="100%" id="ladTable" class="infoDiv">
                            <tr class="header-row row"> 
                                <th width="50%">Lab Name</th>
								<th>Date</th>
								<th>Action</th>
                            </tr>  
                 	 <?php foreach($labs as $lab) {?>
                       <tr>
							<td><?php echo $lab['Laboratory']['name']?></td>
							<td><?php echo $this->DateFormat->formatDate2Local($lab['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),true);?></td>
							<td><?php if($lab['LaboratoryResult']['id']){
								echo $this->Html->link($this->Html->image('icons/print.png'),'#',
										array('escape' => false,'class'=>'',
												'onclick'=>"var openWin = window.open('".$this->Html->url(
														array('controller'=>'new_laboratories','action'=>'printLab',
																'?'=>array('testOrderId'=>$lab['LaboratoryTestOrder']['id'],
																'group_id'=>$lab['Laboratory']['group_id'])))."', '_blank',
																'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=500');  return false;"
												/*
												 'onclick'=>"var openWin = window.open('".$this->Html->url(
																	array('controller'=>'new_laboratories','action'=>'printLab',
														  					'?'=>array('testOrderId'=>$lab['LaboratoryTestOrder']['id'],
																			'group_id'=>$lab['Laboratory']['group_id'])))."', '_blank',
												 		'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,
												 		width=700,left=500,top=500,height=500');  return false;" */));
							}?></td>
							 <?php } ?>
						</tr>
				      </table>
                       <?php }  else { ?>
                        <table cellspacing="0" width="100%" id=""  class="infoDiv">
                            <tr class="header-row row"> 
                                <th width="50%">Lab Name</th>
								<th>Date</th>
								<th>Action</th>
                            </tr> 
                            <tr>
                                <td colspan="5" class="cell" style="font-weight: bold;">
                                    <?php echo __("No Record Found!"); ?>
                                </td>
                            </tr>
                       </table>
                       <?php } ?>
                       </div>
                    </td> 
                </tr>
            </tbody> 
           
            <tbody id="section_2" class="section"  style="display:none;">
               <tr>
                    <td colspan="4">
                    	<div class="visitDetails" style="float: left;">
                    <?php if (!empty($rads)) { ?> 
                        <table cellspacing="0" width="100%" id="radTable"  class="infoDiv">
                           <tr class="header-row row"> 
                                <th style="width:50%">Rad Name</th>
                                 <th >Date</th>
                               <!--   <th class="cell" style="width:10%">Action</th>-->
                            </tr> 
                 
                    <?php
                     foreach($rads as $rad){
                        ?>
                        <tr>
							<td><?php echo $rad['Radiology']['name']?></td>
							<td><?php echo $this->DateFormat->formatDate2Local($rad['RadiologyTestOrder']['create_time'],Configure::read('date_format'),true);?>
							</td>
						</tr>
                    <?php } ?>
                                                                                
                     </table>
                    <?php } else { ?>
                            <table cellspacing="0" width="100%" id=""  class="infoDiv">
                            <tr class="header-row row"> 
                                <th style="width: 50%">Rad Name</th>
                                <th >Date</th>
                               <!--   <th class="cell" style="width:10%">Action</th>-->
                            </tr> 
                            <tr>
                                <td colspan="5" class="cell" style="font-weight: bold;">
                                    <?php echo __("No Record Found!"); ?>
                                </td>
                            </tr>
                       </table>
                    <?php } ?>
                    </div>
                    </td>
               </tr>
            </tbody>   
            </table>
       
			</div>
		
	
<script>
$(document).ready(function(){
	$('.activeLink').focus();
	$('.link').click(function(){
		patient_id=$(this).attr('id').split('_')['1'];
	   $.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "labDetailsPatientHub", "admin" => false)); ?>/"+patient_id,
			  context: document.body,	
			  beforeSend:function(){
				  $('#busy-indicator').show();
			  }, 	  		  
			  success: function(data){	
				  $('#busy-indicator').hide('fast');				  
				  $('#content').html(data);
			   }
		});
		  	

	});
});

$(".row").click(function(){
    var currentID = $(this).attr('id').split("_")[1]; 
    var div = document.getElementById("section_"+currentID);   
    if (div.style.display !== 'none') { 
        $("#row_"+currentID).addClass('active'); 
    }  else {
        $(".row").removeClass('active'); 
        $(".section").hide();
        $("#row_"+currentID).addClass('active'); 
    }
    $("#section_"+currentID).show('slow'); 	
}); 

</script>