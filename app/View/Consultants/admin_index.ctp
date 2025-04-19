<?php
//echo $this->Html->script('jquery.autocomplete','inline_msg');
//echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->script('topheaderfreeze') ;
echo $this->Html->script('inline_msg') ;

?>
<style type="text/css">
.row_gray{
  #acdef6 none repeat scroll 0 0 !important
}

@media print {
	#printButton {
		display: none;
	}
</style>
<div class="inner_title">
<h3><?php echo __('Referral Doctor', true);?></h3>
<span>
<?php
echo $this->Html->link('Add',array("action" => "add"), array('style'=>'margin:0 10px 0 0;','class' => 'blueBtn','escape' => false));
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<table border="0">
	<tr>
		<?php       echo $this->Form->create('Consultant',array('url'=>array('action'=>'admin_index','admin'=>true), 'id'=>'Refffrm','type'=>'get','inputDefaults' => array(
				'label' => false,
				'div' => false,
				'error' => false
		)));

		?>
		<td align="left"><?php echo $this->Form->input('', array('name'=>'first_name_search','type'=>'text','value'=>$this->request->data['first_name_search'],'id' => 'first_name_search','style'=>'width:150px;','autocomplete'=>'off'));
    	echo $this->Form->hidden('', array('name'=>'consultant_id','type'=>'text','value'=>$this->request->data['consultant_id'],'id' => 'consultant_id','style'=>'width:150px;','autocomplete'=>'off')); ?>
		</td>
     <td>
         <?php 
          echo $this->Form->input('', array('name'=>'market_team','class' => 'validate[required,custom[mandatory-select]]', 'options' => $marketing_teams, 'empty' => 'Select Market Team', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:150px;','multiple'=>false,'value'=>$this->request->data['market_team']));
        ?>
  </td>
		<td>
        <?php echo $this->Form->input('', array('name'=>'corporate_sublocation_id','class' => 'sublocations', 'options' => $sponsor, 'empty' => 'Select Sponsor', 'id' => 'sublocations', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:150px;','multiple'=>false,'value'=>$this->request->data['corporate_sublocation_id']));
        ?>
  </td>

		<td align="left"><?php echo $this->Form->submit('Search', array('id'=>'reffSearch','div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?>
		</td>

		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'admin_index','admin'=>true),array('escape'=>false, 'title' => 'refresh'));?>
    <?php //debug($this->request->data);
    $qryStr=$this->request->data;
          echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel','?'=>$qryStr),array('escape'=>false,'title' => 'Export To Excel','style'=>"float:right !important;"));?>
		</td>
		
		<td id="printButton" style="float: right;">
		<?php echo $this->Html->link($this->Html->image('icons/printImage.png'),'#',
				array('style'=>'width:20px','name'=>'print','title' => 'Print','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>$this->params->action,'print',
				'?'=>$qryStr))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
		</td>
		<?php echo $this->Form->end();?>
	</tr>
</table>   
</td>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="container-table">
<thead>
  <tr class="row_title">   
    <th width="2%"><strong><?php echo  __('Sr.No.', true); ?></strong></th>
    <th width="12%"><strong><?php echo  __('Name', true); ?></strong></th> 
    <th width="12%"><strong><?php echo  __('Agent ID', true); ?></strong></th> 
    <th width="6%"><strong><?php echo __('Marketing Team', true); ?></strong></th>
    <th width="6%"><strong><?php echo __('Sponsors', true); ?></strong></th>
    <th width="6%"><strong><?php echo  __('Email', true); ?></strong></th>
    <th width="6%"><strong><?php echo __('Mobile', true); ?></strong></th>
    <th width="6%"><strong><?php echo __('Camp Date', true); ?></strong></th> 
    <th width="20%"><strong><?php echo __('Alias', true); ?></strong></th>   
    <th width="29%"><strong><?php echo __('Remark', true); ?></strong></th>     
    <th width="5%"><strong><?php echo __('Action', true); ?></strong></th>
  </tr>
  </thead>
  <tbody>
  <?php   
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $consultant):
         $cnt++
  ?>
   <tr <?php if($cnt%2 ==0) { echo "class='row_even'"; }?> >
   <td class="row_format" valign="top"><?php echo $cnt; ?></td>
   <td class="row_format" valign="top"><?php echo $initials[$consultant['Consultant']['initial_id']]." ".$consultant['Consultant']['first_name']." ".$consultant['Consultant']['last_name']; ?> </td>
    <td class="row_format" valign="top"><?php echo $consultant['Consultant']['id']; ?> </td>
   <td class="row_format" valign="top"><?php echo $consultant['Consultant']['market_team']; ?> </td>
   <td class="row_format" valign="top"><?php echo $sponsor[$consultant['Consultant']['corporate_sublocation_id']]; ?> </td>
   <td class="row_format" valign="top"><?php echo $consultant['Consultant']['email']; ?> </td>
   <td class="row_format" valign="top"><?php echo $consultant['Consultant']['mobile']; ?> </td>
   
   <td class="row_format" valign="top"><?php echo $this->DateFormat->formatDate2Local($consultant['Consultant']['camp_date'],Configure::read('date_format'),false); ?> </td> 
    <td class="row_format" valign="top"><?php echo $this->Form->input('alias', array('type'=>'text','id' => 'alias_'.$consultant['Consultant']['id'],'style'=>'width:250px;','class'=>'textBoxExpnd clickMeToaddRemark','autocomplete'=>'off','label'=>false,'value'=>$consultant['Consultant']['alias']));  ?> </td>
   <td class="row_format" valign="top"><?php echo $this->Form->input('remark', array('type'=>'textarea','id' => 'remark_'.$consultant['Consultant']['id'],'style'=>'width:350px;','rows'=>'1','cols'=>'1','class'=>'clickMeToaddRemark','autocomplete'=>'off','label'=>false,'value'=>$consultant['Consultant']['remark']));  ?> </td>
   <td valign="top">
   <?php 
   		//echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view', $consultant['Consultant']['id']), array('escape' => false,'title' => 'View', 'alt'=>'View'));
   ?>
    
   <?php 
   		echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $consultant['Consultant']['id']), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
   ?>
  
   <?php //commented by amit jain
   		//echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $consultant['Consultant']['id']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));
   
   ?></td>
  </tr>
  <?php endforeach;  ?>
   
  <?php
  
      } else {
  ?>
  <tr>
   <TD colspan="10" align="center"><strong><font color="RED"><?php echo __('No record found', true); ?>.</font></strong></TD>
  </tr>
  <?php
      }
  ?>
  
  
  </tbody>
 </table>
 <table width="100%" cellpadding="0" cellspacing="1" border="0" style="background-color: #4d90fe !important;">
  <tr>
   <TD colspan="10" align="left"><strong><font color="white"><?php echo "Total Referral Doctor :  ".count($data); ?></font></strong></TD>
  </tr>
 </table> 
<script>
$(document).ready(function() {
	/*$("#first_name_search").autocomplete("<?php echo $this->Html->url(array("controller" => "Consultants", "action" => "autocompelete_consultant","admin" => false,"plugin"=>false)); ?>", {
		width: 250, selectFirst:true });*/

$("#first_name_search").autocomplete({
            source: "<?php echo $this->Html->url(array("controller" => "Consultants", "action" => "autocompelete_consultant","admin" => false,"plugin"=>false)); ?>", 
          select: function(event,ui){
            console.log(ui.item);
             $("#consultant_id").val(ui.item.id);
          },
          messages: {
                 noResults: '',
                 results: function() {},
            }
        });
   $("#container-table").freezeHeader({ 'height': '600px'});

   $(document).on( 'blur', '.clickMeToaddRemark', function() {    
 //$('.clickMeToaddRemark').blur(function(){
      var consultantId = $(this).attr('id') ;
      splittedId = consultantId.split("_");
      consultantIdtext=splittedId[0];
      consultantIds = splittedId[1];
      if(consultantIdtext=='remark'){
        var textval = $(this).val();
      }
      if(consultantIdtext=='alias'){
        var textval = $(this).val();
      }
      if(textval==''){
        return false;
      }
      $.ajax({
                    url : "<?php echo $this->Html->url(array("controller" => 'Consultants', "action" => "updateConsultant", "admin" => false));?>",
                    type: 'POST',
                    data: "consultantIds="+consultantIds+"&textval="+textval+"&consultantIdtext="+consultantIdtext,
                    dataType: 'html',
                    beforeSend:function(data){
                    $('#busy-indicator').show();
                    },

                    success: function(data){
                      var alertId = $('#'+consultantIdtext+'_'+consultantIds).attr('id') ;   
                      if(consultantIdtext=='remark'){        
                        inlineMsg(alertId,'Remark saved successfully.'); 
                      }
                      if(consultantIdtext=='alias'){
                        inlineMsg(alertId,'Alias saved successfully.'); 
                      }
                      $('#busy-indicator').hide();                   
                    }
      });  
});   
      

});


</script>

