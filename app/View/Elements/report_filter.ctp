<?php echo $this->Html->script('topheaderfreeze') ;?>
<?php //echo $this->Html->css(array('jquery.dataTables.min'));  
echo $this->Html->script(array('jquery.dataTables.min'));?>
<style>
table.dataTable tbody td {
    padding: 3px 8px;
}
.tabularForm {
	    background: none repeat scroll 0 0 #d2ebf2 !important;
		}
.tabularForm td {
		background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
		 padding: 3px 8px;
	}
.tdLabel2 img{ float:none !important;}
</style>
<?php   
$getFlagNotDatePicker=false;

if($this->params['action']=='admin_other_outstanding_report')
	$getAdmin=true;
else
	$getAdmin=false;

if($this->params['action']=='doctorRevenueReport' || $this->params['action']=='billwiseDoctorRevenueReport')
	$getFormType='POST';
else
	$getFormType='GET';

echo $this->Form->create('Patient',array('url'=>array('controller'=>$this->params->controller,'action'=>$this->params->action,'admin'=>$getAdmin),'id'=>'surgeonreport','type'=>$getFormType));?>
<?php if($this->params['action']=='doctorRevenueReport' || $this->params['action']=='billwiseDoctorRevenueReport'){ ?>
<table align="center" class="formFull" style="margin-top: 5px;" ><!-- width="99%"-->
			<tr>
				<td align="right" valign="top"><strong><?php echo "CITY";?></strong></td>
				<td  valign="top"><?php echo $this->Form->input('city_id', array('id'=>'city','class'=>'textBoxExpnd cityCls','label'=>false, 'div' => false,'options'=>array_map("strtoupper", $dataCities),'multiple'=>true, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;height:84px;'));	?><br/><font color="RED">Press ctrl to select multiple</font></td>

				<td align="right" valign="top"><strong><?php echo __('BRANCH');?></strong></td>
				<td  valign="top">
				<div style="overflow-x: hidden; overflow-y: scroll; height: 84px;width:150px;" id="BranchShowid">
                 <?Php echo $this->Form->checkBox('allLocation',array('checked'=>$this->params->query['allLocation'],'hiddenField'=>false,'class'=>'all','onclick'=>'setDoctors();')); ?> <?php echo __('ALL'); ?>                 
				   <?php foreach ($locations as $key=>$locationList){
				 
				    if(in_array($key,$this->params->query['location_id']))
						$chcked="checked";
					  else
						$chcked="";?>
                  <div>
                      <?php echo $this->Form->checkBox('gfh',array('name'=>'data[Patient][location_id][]','value'=>$key,'hiddenField'=>false,'class'=>'locations','checked'=>$chcked,'id'=>'locId_'.$key,'onclick'=>'setDoctors();')); ?>
                      <?php echo strtoupper($locationList); ?>
                  </div>
                  <?php } ?>
				</div></td>			

			<td align="right" valign="top"><strong><?php echo "DOCTOR NAME ";?></strong></td>
			<td  valign="top">
			<?php
			echo $this->Form->input('doctor_id_txt', array('id'=>'doctor_id_txt','label'=>false, 'div' => false,'options'=>array_map("strtoupper", $allDoctorList),'multiple'=>true,'empty'=>'PLEASE SELECT','error' => false,'autocomplete'=>false,'style'=>'width:200px;height:84px;','value'=>$this->params->query['doctor_id_txt']));	
			?><br/><font color="RED">Press ctrl to select multiple</font></td>
			
			<td align="right" valign="top"><strong>FROM <font
				color="red">*</font></strong></td>
				<td valign="top"><?php if(empty($this->params->query['from'])){
							    $currFromDate=$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false);
						  }else{
							     $currFromDate=$this->params->query['from'];
						  }
				echo $this->Form->input('from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From Date','value'=>$currFromDate));?></td>
				<td align="right" valign="top"><strong>TO <font
				color="red">*</font></strong></td>
				<td valign="top"><?php if(empty($this->params->query['to'])){
							  $currToDate=$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false);
						  }else{
							  $currToDate=$this->params->query['to'];
						  }
				echo $this->Form->input('to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'To Date','value'=>$currToDate));?></td>

			</tr>				
			<tr>
			<td valign="top"><strong>SERVICE MAIN GROUP</strong></td>				
			<td  valign="top"><?php
				echo $this->Form->input('service_group_id', array('id' => 'service_group_id', 'label'=> false,'class'=>'textBoxExpnd', 'div' => false, 'error' => false,'style'=>'width:150px;','empty'=>'ALL SERVICE GROUP','options'=>array_map("strtoupper", $serviceCatData),'selected'=>$this->params->query['service_group_id']));?></td>

			<td  valign="top"><strong>SERVICE NAME</strong></td>	
			<td  valign="top"><?php echo $this->Form->input('service_name', array('type'=>'text','id' => 'search_service_name','style'=>'width:150px;','class'=>'textBoxExpnd','autocomplete'=>'off','label'=>false,'value'=>$this->params->query['service_name'])); 
			echo $this->Form->hidden('serviceID', array('label'=>false,'id'=>'serviceID','value'=>$this->params->query['serviceID']));?></td>		
			<?php	if($this->params['action']=='doctorRevenueReport')
					$getReportType=array('Summary'=>'SUMMARY');
				else
					$getReportType=array('Detailed'=>'DETAILED');?>
				<td align="right" valign="top"><strong><?php echo __('REPORT FORMAT');?></strong></td>
				<td align="left" valign="top"><?php echo $this->Form->input('report_format', array('class'=>'textBoxExpnd','style'=>'width:150px','id'=>'report_format','label'=> false, 'div' => false, 'error' => false,'options'=>$getReportType,'value'=>$this->params->query['report_format']));?>
				</td>			
			<td  valign="top"><?php echo $this->Form->submit('SEARCH',array('class'=>'blueBtn','label'=> false, 'div' => false,'id'=>'searchrevenue',"onclick"=>"SelectExcel('null');"));?></td>
			<td  valign="top" align="left"><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>$this->params->controller,'action'=>$this->params->action),array('escape'=>false,'style'=>"float:left;"));
			echo $this->Html->link($this->Html->image('icons/eraser.png'),'javascript:void(0)',array('escape'=>false, 'title' => 'Reset','id'=>'reset','style'=>"float:left;"));?>
			<?php 			
				//if($this->params->query){					
						//$qryStr=$this->params->query;					
					?>
			<?php echo $this->Html->image('icons/excel.png',array('escape'=>false,'title' => 'Export To Excel',"onclick"=>"SelectExcel('excel');"));		
							//}?></td>
			<td></td>
			<td></td>
			</tr>
			
		</table>

<?php }else{?>
<!--width="<?php //echo $getWidth;?>"-->
<table align="center"  class="formFull" style="margin-top: 5px;">
			<tr>
			
				<?php if($this->params['action']!='billListReport'){
							$getWidthforCity="160px";
							$getWidthforBranch="150px";
					   }else{
							$getWidthforCity="129px";
							$getWidthforBranch="134px";
					   }
					  ?>
				<td align="right" valign="top"><strong><?php echo "CITY";?></strong></td>
				<td valign="top"><?php echo $this->Form->input('city_id', array('id'=>'city','class'=>'textBoxExpnd cityCls','label'=>false, 'div' => false,'options'=>array_map("strtoupper", $dataCities),'multiple'=>true, 'error' => false,'autocomplete'=>false,'style'=>'width:'.$getWidthforCity.';height:78px;'));	
				//if($this->params['action']!='billListReport'){?>	
				</br><font color="RED">Press ctrl to select multiple</font>	
				<?php //}?>
				</td>
				<td align="right" valign="top"><strong><?php echo __('BRANCH');?></strong></td>
				<td valign="top">
				<div style="overflow-x: hidden; overflow-y: scroll; height: 78px;width:<?php echo $getWidthforBranch;?>;" id="BranchShowid">
                  <?php echo $this->Form->checkBox('allLocation',array('checked'=>$this->params->query['allLocation'],'hiddenField'=>false,'class'=>'all')); ?>
                  <?php echo __('All'); ?>
                  <?php foreach ($locations as $key=>$locationList){
				    if(in_array($key,$this->params->query['location_id']))
						$chcked="checked";
					  else
						$chcked="";?>
                  <div>
                      <?php echo $this->Form->checkBox('gfh',array('name'=>'location_id[]','value'=>$key,'hiddenField'=>false,'class'=>'locations','checked'=>$chcked,'id'=>'chk_'.$key)); ?>
                      <?php echo strtoupper($locationList); ?>
                  </div>
                  <?php } ?>
				</div></td>
					<?php if($this->params['action']=='deliveredAndDischargedInTheLastOneMonth'){ ?>

				<td align="right" valign="top"><?php
				if(empty($getLastMonFrm)){
					$getLastMonthSelectedT=date('m');	
				}else{
					$getLastMonthSelected=date("m", strtotime($getLastMonFrm));	
				}							
				$monthArray = array('01'=> 'JANUARY','02'=> 'FEBRUARY','03'=> 'MARCH','04'=> 'APRIL','05'=> 'MAY','06'=> 'JUNE','07'=> 'JULY','08'=> 'AUGUST','09'=> 'SEPTEMBER','10'=> 'OCTOBER','11'=> 'NOVEMBER','12'=> 'DECEMBER');?>				
				<?php 	echo "Month : "."&nbsp;";?><font color="red">*</font><?php echo $this->Form->input('months', array('id'=>'months','empty'=>'Please Select','options'=>$monthArray,'value'=>$this->request->query['months'],'default'=>$getLastMonthSelectedT,'label'=> false, 'div' => false, 'error' => false,'class'=>'validate[required,custom[mandatory-select]]')); ?>
	    		</td>
			<?php }?>
				<?php if($getFlagNotDatePicker=='0'){
					if($this->params['action']!='hospitalBedOccupancyReport' && $this->params['action']!='facilityReport' && $this->params['action']!='customerList' && $this->params['action']!='deliveredAndDischargedInTheLastOneMonth'){?>

				<td align="right" valign="top"><strong>FROM <font
				color="red">*</font></strong></td>
				<td valign="top"><?php if(empty($this->params->query['from'])){
							  $currFromDate=$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false);
						  }else{
							  $currFromDate=$this->params->query['from'];
						  }
				echo $this->Form->input('from', array('class'=>'textBoxExpnd  validate[required,custom[mandatory-select]]','style'=>'width:100px','id'=>'from','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From Date','value'=>$currFromDate));?></td>
				<td align="right" valign="top"><strong>TO <font
				color="red">*</font></strong></td>
				<td valign="top"><?php if(empty($this->params->query['to'])){
							  $currToDate=$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'), false);
						  }else{
							  $currToDate=$this->params->query['to'];
						  }
				echo $this->Form->input('to', array('class'=>'textBoxExpnd  validate[required,custom[mandatory-select]]','style'=>'width:100px','id'=>'to','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'To Date','value'=>$currToDate));?></td>
				<?php if($this->params['action']=='attendanceReport'){  ?>
					<td align="right" valign="top"><strong>User Name</strong></td>
			<?php $userName = $this->params->query['user_name'];?> 
					<td valign="top"><?php echo $this->Form->input("user_name",array('value'=>$userName,'style'=>'width:138px','id'=>"reporting_manager",'class'=>'textBoxExpnd reporting_manager','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Search User'));
					$userId = $this->params->query['userId'];
					echo $this->Form->hidden("userId",array('value'=>$userId,'style'=>'width:138px','id'=>"userID",'class'=>'textBoxExpnd','label'=> false, 'div' => false, 'error' => false));?>
				</td> <?php } ?>
				<?php } if($this->params['action']=='customerList'){
					$campdate = $this->params->query['search_camp'];
					$data = array('Prospect'=>'Prospect','First Visit Date'=>'First Visit Date','Last Visit Date' =>'Last Visit Date','EDD'=>'EDD','Next Visit Date'=>'Next Visit Date','CampDate'=>'Referred Through');?>
				
				<td align="left" valign="top">
				<?php $valFilterDate = $this->params->query['FilterDate']; 
					echo $this->Form->input('FilterDate', array('class'=>'textBoxExpnd validate[required,custom[mandatory-select]]','id'=>'FilterDates','type'=>'select','label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select','options'=>$data,'value'=>$valFilterDate));?></td>
				
					<td valign="top" class='camp' style="display:none">
						<?php echo $this->Form->input('search_camp', array('class'=>'textBoxExpnd  validate[required,custom[mandatory-enter]]','style'=>'width:150px','id'=>'searchCampDate','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Search camp date','value'=>$campdate));
						     echo $this->Form->hidden('searchCampDateData', array('class'=>'textBoxExpnd','style'=>'width:150px','id'=>'searchCampDateData','label'=> false, 'div' => false, 'error' => false));
						     ?></td>
					</td>
				<td class='other' valign="top"><?php $curreddFromDate=$this->params->query['edd_f'];
					echo $this->Form->input('edd_f', array('class'=>'textBoxExpnd validate[required,custom[mandatory-select]]','style'=>'width:100px','id'=>'edd_from','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From Date','value'=>$curreddFromDate,'autocomplete'=>'off'));?></td>
				<td class='other' valign="top"><?php 
							  $curreddToDate=$this->params->query['edd_t'];
				echo $this->Form->input('edd_t', array('class'=>'textBoxExpnd validate[required,custom[mandatory-select]]','style'=>'width:100px','id'=>'edd_to','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'To Date','value'=>$curreddToDate,'autocomplete'=>'off'))?> </td>					
				<?php }?>
				<?php }?>
				<?php if($this->params['action']=='birthCertificateDetails'){?>
				<td align="right" valign="top"><strong>MOTHER </strong> </td>	
				<td align="left" valign="top">
				<?php echo $this->Form->input('lookup_name', array('id' => 'lookup_name','value'=>$this->params->query['lookup_name'],
					 'label'=> false,'style'=>'width:120px;', 'div' => false ,'autocomplete'=>'off','class'=>'name'));			
					echo $this->Form->hidden('patient_id',array('id'=>'patient_id','value'=>$this->params->query['patient_id']));
				?> 
				</td>
				<?php }?>
				<?php if($this->params['action']=='billListReport'){?>
				<td align="right" valign="top"><strong>CUSTOMER CATEGORY </strong></td>				
				<td valign="top"><?php
				echo $this->Form->input('cust_category', array('id' => 'type', 'label'=> false, 'div' => false, 'class'=>'textBoxExpnd','error' => false,'style'=>'width:100px;','empty'=>'ALL ','options'=>array_map("strtoupper", $tariffStandardData),'selected'=>$this->params->query['cust_category']));?></td>
				<?php }?>
				<?php if($this->params['action']=='serviceListReport'){?>
				<td align="right" valign="top"><strong>CUSTOMER CATEGORY </strong></td>				
				<td valign="top"><?php
				echo $this->Form->input('cust_category', array('id' => 'type', 'label'=> false, 'div' => false, 'class'=>'textBoxExpnd','error' => false,'style'=>'width:147px;','empty'=>'ALL','options'=>array_map("strtoupper", $tariffStandardData),'selected'=>$this->params->query['cust_category']));?></td>
				<?php }?>
				<?php if($this->params['action']=='creditBillAgingReport' || $this->params['action']=='admin_other_outstanding_report'){?>
				<td align="right" valign="top"><strong>TARIFF </strong> </td>		
				<td align="left" valign="top">
				<?php  echo $this->Form->input('tariff_standard_id', array(  'empty'=>__('PLEASE SELECT') , 'options'=>array_map("strtoupper", $tariffStandardData),'style'=>'width:120px;','class' => 'textBoxExpnd','id'=>'tariff',
					'label'=>false,'value'=>$this->params->query['tariff_standard_id'])); ?>
				</td>
				<?php }?>
				<?php if($this->params['action']=='creditBillAgingReport' || $this->params['action']=='admin_other_outstanding_report'  || $this->params['action']=='birthDocumentationReport' || $this->params['action']=='finalSheet'){?>
				<td align="right" valign="top"><strong>PATIENT </strong> </td>	
				<td align="left" valign="top">
				<?php echo $this->Form->input('lookup_name', array('id' => 'lookup_name','value'=>$this->params->query['lookup_name'],
					 'label'=> false,'style'=>'width:120px;', 'div' => false ,'autocomplete'=>'off','class'=>'name'));			
					echo $this->Form->hidden('patient_id',array('id'=>'patient_id','value'=>$this->params->query['patient_id']));
				?> 
				</td>
				<?php }?>
				<?php if($this->params['action']=='dailyCashScroll' || $this->params['action']=='finalSheet' || $this->params['action']=='birthCertificateDetails' || $this->params['action']=='birthDocumentationReport' || $this->params['action']=='operationalReport' || $this->params['action']=='billListReport' || $this->params['action']=='collectionDeposit'){
				if($this->params['action']=='finalSheet' || $this->params['action']=='birthCertificateDetails' || $this->params['action']=='operationalReport' || $this->params['action']=='birthDocumentationReport'  || $this->params['action']=='collectionDeposit')
					$getReportType=array('Detailed'=>'DETAILED');
				else
					$getReportType=Configure::read('reportFormat');?>
				<td align="right" valign="top"><strong><?php echo __('REPORT FORMAT');?></strong></td>
				<td align="left" valign="top"><?php echo $this->Form->input('report_format', array('class'=>'textBoxExpnd','style'=>'width:100px','id'=>'report_format','label'=> false, 'div' => false, 'error' => false,'options'=>$getReportType,'value'=>$this->params->query['report_format']));?>
				</td>
				<?php }?>
				
				<?php if($this->params['action']=='billListReport' || $this->params['action']=='serviceListReport'){?>
				
	 </tr>
	 <tr>
				<td align="right" valign="top"><strong>BED CATEGORY </strong></td>				
				<td valign="top"><?php if($this->params['action']=='billListReport')
											$getBedWidth="129px";
										else 
											$getBedWidth="160px";

		echo $this->Form->input('bed_type', array('id' => 'type', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'All Wards','options'=>array_map("strtoupper", $Ward),'style'=>'width:'.$getBedWidth.';','selected'=>$this->params->query['bed_type']));
	 ?></td>

<?php	}if($this->params['action']=='billListReport'){?>
				<td valign="top"><strong>BILL CATEGORY</strong></td>				
				<td valign="top"><?php
		echo $this->Form->input('type', array('id' => 'type', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('All'=>'ALL','IPD'=>'IPD','OPD'=>'OPD','OtherServices'=>'DIAGNOSTICS'),'selected'=>$this->params->query['type'],'style'=>'width:120px;'));
	 ?></td>
			<td align="right" valign="top"><strong>SORT BY</strong></td>				
				<td valign="top"><?php
		echo $this->Form->input('sort_by', array('id' => 'type', 'label'=> false, 'div' => false, 'error' => false,'options'=>array_map("strtoupper", array('Bill Date'=>'Bill Date','Bill No'=>'Bill No','City'=>'City','Hospital'=>'Hospital')),'style'=>'width:100px;','selected'=>$this->params->query['sort_by']));
	 ?></td>	
	 	<td align="right" valign="top"><strong>PATIENT </strong> </td>	
		<td align="left" valign="top">
				<?php echo $this->Form->input('lookup_name', array('id' => 'lookup_name','value'=>$this->params->query['lookup_name'],
					 'label'=> false,'style'=>'width:100px;', 'div' => false ,'autocomplete'=>'off','class'=>'name textBoxExpnd'));			
					echo $this->Form->hidden('patient_id',array('id'=>'patient_id','value'=>$this->params->query['patient_id']));
				?> 
		</td>
			
		<td align="right" valign="top"><strong>PACKAGE TYPE </strong></td>				
		<td valign="top"><?php
			if($this->params->query['pack_type']['0']=="non-delivery" && $this->params->query['pack_type']['1']=="delivery"){	
					$this->params->query['pack_type']="both";
				}
				echo $this->Form->input('pack_type', array('id' => 'pack_type','style'=>'width:100px;', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select','options'=>array_map("strtoupper", Configure::read('packageType')),'selected'=>$this->params->query['pack_type']));
			?></td>
	 <?php $display = ($this->params->query['pack_type'] != 'delivery') ? 'display:none;' : ''; ?>	
		<td valign="top" align="right" class="delivery" style='<?php echo $display;?>'><strong>Delivery Type </strong></td>				
		<td valign="top" class="delivery" style='<?php echo $display;?>'><?php
		echo $this->Form->input('delivery_type', array('id' => 'delivery_type','style'=>'width:100px;', 'label'=> false, 'div' => false,'empty'=>'Please Select', 'error' => false,'options'=>array_map("strtoupper", Configure::read('deliveryType')),'selected'=>$this->params->query['delivery_type']));
	 ?></td>			
	 <?php }
	 if($this->params['action']=='serviceListReport'){?>
	 
	 		<td valign="top"><strong>SERVICE MAIN GROUP</strong></td>				
			<td  valign="top"><?php
				echo $this->Form->input('service_group_id', array('id' => 'service_group_id', 'label'=> false,'class'=>'textBoxExpnd', 'div' => false, 'error' => false,'style'=>'width:150px;','empty'=>'All Service Group','options'=>array_map("strtoupper", $serviceCatData),'selected'=>$this->params->query['service_group_id']));?></td>

				<td  valign="top"><strong>SERVICE NAME</strong></td>	
				<td  valign="top"><?php echo $this->Form->input('service_name', array('type'=>'text','id' => 'search_service_name','style'=>'width:100px;','class'=>'textBoxExpnd','autocomplete'=>'off','label'=>false,'value'=>$this->params->query['service_name'])); 
				echo $this->Form->hidden('serviceID', array('label'=>false,'id'=>'serviceID','value'=>$this->params->query['serviceID']));?></td>
				
		
		<?php }?>
		<?php if($this->params['action']=='serviceListReport'){?>
				<td align="right" valign="top"><strong>PATIENT </strong> </td>	
				<td align="left" valign="top">
				<?php echo $this->Form->input('lookup_name', array('id' => 'lookup_name','value'=>$this->params->query['lookup_name'],
					 'label'=> false,'style'=>'width:200px;', 'div' => false ,'autocomplete'=>'off','class'=>'name textBoxExpnd'));			
					echo $this->Form->hidden('patient_id',array('id'=>'patient_id','value'=>$this->params->query['patient_id']));
				?> 
				</td>
				<?php }?>
	<?php //debug($this->params['action']);
if($this->params['action'] != 'billListReport'){ 
   if($this->params['action'] != 'customerList'){ ?>

	  <td valign="top">
	 <?php //if($this->params->query){
				//$qryStr=$this->params->query;
	?>
	<?php  echo $this->Form->submit('GENERATE EXCEL',array("onclick"=>"submitExcel();",'class'=>'blueBtn','label'=> false, 'div' => false,'style'=>"float:right;"));
	//echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel','?'=>$qryStr),array('escape'=>false,'title' => 'Export To Excel','style'=>"float:right !important;"));
		//  }
 echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>$this->params->controller,'action'=>$this->params->action),array('escape'=>false,'style'=>"float:right;"));
	 echo $this->Html->link($this->Html->image('icons/eraser.png'),'javascript:void(0)',array('escape'=>false, 'title' => 'Reset','id'=>'reset','style'=>"float:right;"));?>
		<?php if($this->params['action']=='profitLossStatement')
				 echo $this->Html->image('icons/views_icon.png',array('id'=>'Submit','type'=>'submit','title'=>'Search'));	
			  else
				 echo $this->Form->submit('SEARCH',array("onclick"=>"selectExcelAvoid();",'class'=>'blueBtn','label'=> false, 'div' => false,'style'=>"float:right;"));?>			
			</td>
			<?php  } 
}?>
			<!-- BOF-For Bill List in select delivery type then not display this -->
			 <td valign="top" style="display:none;" id="searchUpper">
                        <?php //if($this->params->query){
					$qryStr=$this->params->query; ?>
			<?php //echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel','?'=>$qryStr),array('escape'=>false,'title' => 'Export To Exceltest','style'=>"float:right !important;"));
					
                        echo $this->Form->submit('GENERATE EXCEL',array("onclick"=>"submitExcel();",'class'=>'blueBtn','label'=> false, 'div' => false,'style'=>"float:right;"));
                       // }
			//echo $this->Html->image('icons/excel.png',array('escape'=>false,'title' => 'Export To Excel'/*,"onclick"=>"SelectExcel('excel');"*/,'style'=>"float:right !important;"));		
							//}
							
	echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>$this->params->controller,'action'=>$this->params->action),array('escape'=>false,'style'=>"float:right;"));
	 echo $this->Html->link($this->Html->image('icons/eraser.png'),'javascript:void(0)',array('escape'=>false, 'title' => 'Reset','id'=>'reset','style'=>"float:right;"));?>
		<?php if($this->params['action']=='profitLossStatement')
				 echo $this->Html->image('icons/views_icon.png',array('id'=>'Submit','type'=>'submit','title'=>'Search'));	
			  else
				 echo $this->Form->submit('SEARCH',array("onclick"=>"submitForm();",'class'=>'blueBtn','label'=> false, 'div' => false,'style'=>"float:right;"));?>			
			</td>	
			<!-- EOF-For Bill List in select delivery type then not display this -->		
			</tr>
			<?php if($this->params['action']=='billListReport'){ ?>
			<!-- BOF-For Bill List in select delivery type then display this -->
			<tr>
			 <td colspan="9.dea"></td>
		<?php //if($this->params['action']=='customerList'){  ?>
		<?php //}?>
			 
			 <td valign="top" align="right"  style="display:none;" id="searchLower">
	 <?php //if($this->params->query){
				$qryStr=$this->params->query;
	?>
	<?php //echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel','?'=>$qryStr),array('escape'=>false,'title' => 'Export To Excel','style'=>"float:right !important;"));
	  echo $this->Form->submit('GENERATE EXCEL',array("onclick"=>"submitExcel();",'class'=>'blueBtn','label'=> false, 'div' => false,'style'=>"float:right;"));
					//}
	//echo $this->Html->image('icons/excel.png',array('escape'=>false,'title' => 'Export To Excel'/*,"onclick"=>"SelectExcel('excel');"*/,'style'=>"float:right !important;"));
	echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>$this->params->controller,'action'=>$this->params->action),array('escape'=>false,'style'=>"float:right;"));
    echo $this->Html->link($this->Html->image('icons/eraser.png'),'javascript:void(0)',array('escape'=>false, 'title' => 'Reset','id'=>'reset','style'=>"float:right;"));?>
	<?php if($this->params['action']=='profitLossStatement')
			echo $this->Html->image('icons/views_icon.png',array('id'=>'Submit','type'=>'submit','title'=>'Search'));	
		  else
			echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false,'style'=>"float:right;"/*,"onclick"=>"selectExcelAvoid();"*/));?>			
			</td>
			</tr>
			<!-- EOF-For Bill List in select delivery type then display this -->
			<?php }?>
		</table>
		<?php }?>
<?php echo $this->Form->end();?>
<?php if(!empty($this->params->query['from']) && !empty($this->params->query['to'])){?>
<table align="center">			
			<tr>		    	
		    	<td align="" valign="top" colspan="13" style="text-align:center;padding-left:80px;">
				  	<?php echo '<b>CREATED FROM '.$this->params->query['from'].' TO '.$this->params->query['to'].'</b>'; ?>
				</td>
	    	</tr> 			
		</table>
<?php }?>
<script>
$(document).ready(function() {
	
	<?php if($this->params->query['FilterDate'] =='CampDate'){?>
		$('.camp').show();
		$('.other').hide(); 
	<?php } ?>
	
	<?php	if($this->params['action'] != 'customerList' && $this->params['action']!='hospitalBedOccupancyReport' && $this->params['action']!='facilityReport'){?> 
	$( "#surgeonreport").click(function(){
		$('#from').validationEngine('hide');
        result  = compareDates($( '#from' ).val(),$( '#to' ).val(),'<?php echo $this->General->GeneralDate();?>') //function with dateformat 
 		$("#to").validationEngine("hideAll");
		 if(!result){ 
			 $('#to').validationEngine('showPrompt', 'To date should be greater than from date', 'text', 'topRight', true);
		  return false ;
		  }		  
});
<?php } 
if($this->params['action'] == 'customerList'){ ?>
$( "#surgeonreport").click(function(){
$('#edd_from').validationEngine('hide');
	results  = compareDates($( '#edd_from' ).val(),$( '#edd_to' ).val(),'<?php echo $this->General->GeneralDate();?>') //function with dateformat
	$("#edd_to").validationEngine("hideAll");
	if(!results){
		$('#edd_to').validationEngine('showPrompt', 'To date should be greater than from date', 'text', 'topRight', true);
		return false ;
	}
});
$("#searchCampDate").autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "App", "action" => "advanceMultipleAutocomplete","consultant","id&first_name&refferer_doctor_id",'null','null','null'/* ,'consultant.refferer_doctor_id=3' */)); ?>",
				select:function( event, ui ) { 						
					$("#searchCampDateData").val(ui.item.id);		
					//$("#searchCampDatename").text(ui.item.first_name);								
				},
				messages: {
			        noResults: '',
			        results: function() {}
				 }
				});
$("#FilterDates").change(function(){
	 var getFilterDatesFilter = $("#FilterDates").val();
		if(getFilterDatesFilter == 'CampDate'){ 
			$( ".camp" ).show();
			$( ".other" ).hide();
			searchCampDate = $("#searchCampDate").val();   //+'/'+'first_name='+searchCampDate
			
		}else{
			$( ".other" ).show();
			$( ".camp" ).hide();
			}
});
<?php } ?>

<?php  if($this->params['action'] == 'attendanceReport'){ ?>

$('.reporting_manager').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "App", "action" => "advanceMultipleAutocomplete","User","full_name",'null',"null",'null',"admin" => false,"plugin"=>false)); ?>",
           // setPlaceHolder: false,
                        select: function( event, ui ) {
         			$(".reporting_manager" ).val(ui.item.value);
         			$("#userID").val(ui.item.id);
        },
        messages: {
          noResults: '',
          results: function() {}
        }
    }); 
 <?php  } ?>
	<?php /* if($this->params['action'] == 'customerList'){ ?>
			
	 <?php   }else{ ?>
	        $('#from').addClass("validate[required,custom[name],custom[mandatory-select]]");
	        $('#to').addClass("validate[required,custom[name],custom[mandatory-select]]");
	 <?php   }*/ ?>

	
	<?php if($this->params['action'] == 'billListReport'  || $this->params['action'] == 'customerList'){?>
			$('#searchUpper').show();
			$('#searchUpper').css("display", "");
	<?php }?>
	<?php if($this->params['action']=='billListReport' || $this->params['action']=='birthCertificateDetails'){?>
		var heightscroll="350";
	<?php }else{?>
			var heightscroll="400";
	<?php }?>
   $('#example').DataTable( {
        "scrollY": heightscroll,
        "scrollX": true,
		"bSort": false,			
		"bPaginate": false,
		"bFilter": false,
        "bInfo": false
    });




jQuery("#surgeonreport").validationEngine();	
$("#container-table").freezeHeader({ 'height': '450px'});
$("#container-table2").freezeHeader({ 'height': '450px'});
<?php if($this->params['action']=='finalSheet'){?>
	$("#lookup_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "testcompleteReport","no","is_discharge=1&is_deleted=0","admin" => false,"plugin"=>false)); ?>",
			select: function(event,ui){	
				$("#patient_id" ).val(ui.item.id);
				
				if($( "#patient_id" ).val() != ''){
					var patientName=ui.item.value;
					var name=patientName.split('-')[0];
					$('#patient-filter').val(name);
				   $( "#patient_id" ).trigger( "change" );
			     }			
		    },
		    messages: {
		         noResults: '',
		         results: function() {},
	   		},		
		});
	 /*$("#lookup_name").autocomplete({
    	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","no","is_discharge=1&is_deleted=0","yes","admin" => false,"plugin"=>false)); ?>", 
    		select: function(event,ui){
    			$( "#patient_id" ).val(ui.item.id);
    			
    	},
    	 messages: {
             noResults: '',
             results: function() {},
      }
    });*/
	<?php }else if($this->params['action']=='serviceListReport' || $this->params['action']=='billListReport'){?>
		$("#lookup_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "testcompleteReport","no","is_deleted=0","admin" => false,"plugin"=>false)); ?>",
			select: function(event,ui){	
				$("#patient_id" ).val(ui.item.id);
				
				if($( "#patient_id" ).val() != ''){
					var patientName=ui.item.value;
					var name=patientName.split('-')[0];
					$('#patient-filter').val(name);
				   $( "#patient_id" ).trigger( "change" );
			    }
			    if($( "#lookup_name" ).val() == ''){
			    	alert("hdfdf");
						$("#patient_id" ).val('');
			    }
		    },
		    messages: {
		         noResults: '',
		         results: function() {},
	   		},
		
		});
	/* $("#lookup_name").autocomplete({
    	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","no","is_deleted=0","yes","admin" => false,"plugin"=>false)); ?>", 
    		select: function(event,ui){
    			$( "#patient_id" ).val(ui.item.id);
    			
    	},
    	 messages: {
             noResults: '',
             results: function() {},
      }
    });*/
	<?php }else if($this->params['action']=='birthDocumentationReport'){?>	
		$("#lookup_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "testcompleteReport",'IPD',"is_discharge=1&is_deleted=0","admin" => false,"plugin"=>false)); ?>",
			select: function(event,ui){	
				$("#patient_id" ).val(ui.item.id);				
				if($( "#patient_id" ).val() != ''){
					var patientName=ui.item.value;
					var name=patientName.split('-')[0];
					$('#patient-filter').val(name);
				   $( "#patient_id" ).trigger( "change" );
			     }			    
		    },
		    messages: {
		         noResults: '',
		         results: function() {},
	   		},		
		});
	/* $("#lookup_name").autocomplete({
    	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","IPD","is_discharge=1&is_deleted=0","yes","admin" => false,"plugin"=>false)); ?>", 
    		select: function(event,ui){
    			$( "#patient_id" ).val(ui.item.id);
    			
    	},
    	 messages: {
             noResults: '',
             results: function() {},
      }
    });*/
	<?php }else if($this->params['action']=='birthCertificateDetails'){?>	
		$("#lookup_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "testcompleteReport",'IPD',"is_deleted=0","admin" => false,"plugin"=>false)); ?>",
			select: function(event,ui){	
				$("#patient_id" ).val(ui.item.id);
				
				if($( "#patient_id" ).val() != ''){
					var patientName=ui.item.value;
					var name=patientName.split('-')[0];
					$('#patient-filter').val(name);
				   $( "#patient_id" ).trigger( "change" );
			     }			
		    },
		    messages: {
		         noResults: '',
		         results: function() {},
	   		},		
		});	
	<?php }else{?>
	$("#lookup_name").autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "admissionPatientWithCreditTariff","IPD",'is_discharge=1&Patient.tariff_standard_id IN ('.$getCreditTariffArr.')',"admin" => false,"plugin"=>false)); ?>", 
		select: function(event,ui){ 
		//	console.log(ui);
			$("#patient_id").val(ui.item.id);
		},
		messages: {
	         noResults: '',
	         results: function() {},
	  	}
	});
<?php }?>
			//BOF-For empty of person_id autocomplete
  			$(document).on( 'keyup', '#lookup_name', function() {			
		         if($(this).val() == ''){
						$("#patient_id" ).val('');
			     }		
		    }); 
			//EOF-For empty of person_id autocomplete


		 $(document).on( 'click', '.all', function() {			
		        var $checkboxes = $(this).parent().find('input[type=checkbox]');		       
		        $checkboxes.prop('checked', $(this).is(':checked'));				
		    }); 
		  $(document).on( 'click', '.locations', function() {			
		        if (!$(this).is(':checked')){                
                   $(".all").attr('checked', false);
               }			
		    }); 
		 
		 
		//BOF-click on city to fetch Branch
		$(".cityCls").click(function() {
			 var selectId = $(this).attr('id') ;
			 selectedVal=$('#'+selectId+' option:selected').val();			
			
			 $.ajax({
					<?php if($this->params['action']=='attendanceReport'){?>
						url : "<?php echo $this->Html->url(array("controller" => 'Reports', "action" => "ajaxFetchBranchOnCityId", "admin" => false));?>"+"/"+"withCorporate",
					<?php }else{?>
						url : "<?php echo $this->Html->url(array("controller" => 'Reports', "action" => "ajaxFetchBranchOnCityId", "admin" => false));?>",
					<?php }?>

						type: 'POST',
						data: 'city_id='+ selectedVal,
						dataType: 'html',
					  	beforeSend:function(data){
			 			$('#busy-indicator').show('fast');
			 			},
			 			success: function(data){   							
			 			$('#busy-indicator').hide('fast');
							var objBranch= jQuery.parseJSON(data); 							
							returnBrnchArr = sortData(objBranch);							
							addCheckboxBranchElement(returnBrnchArr);
			 			}
			 	});  
		});
		
		//For render checkbox of branch on selected city  
		function addCheckboxBranchElement(BrnchArr){
			//console.log(BrnchArr);
			$('#BranchShowid').html('');

			<?php if($this->params['action']=='doctorRevenueReport' || $this->params['action']=='billwiseDoctorRevenueReport'){?>
				$("#BranchShowid")
				.append($('<input>').attr({'style':'float:left;','class':'all','onclick':'setDoctors();','type':'checkbox','name':'allLocation','hiddenField':false}))
			<?php }else{?>
				$("#BranchShowid")
				.append($('<input>').attr({'style':'float:left;','class':'all','type':'checkbox','name':'allLocation','hiddenField':false}))
			<?php }?>

				.append($('<label>').attr({'style':'text-align:left;margin-right: 0 !important;padding-top: 3px !important;','valign':'top'}).text('ALL'))
			$.each(BrnchArr, function (key, value) {					
	   			$("#BranchShowid")				
				.append($('<div>').attr({'class':'clear'}).append($('<input>').attr({'style':'float:left;','class':'locations','id':'locId_'+value.name,'type':'checkbox','onclick':'setDoctors();','name':'data[Patient][location_id][]','value':value.name,'hiddenField':false}))).append($('<label>').attr({'style':'text-align:left;margin-right: 0 !important;padding-top: 3px !important;'}).text(value.val))
			});		
		}
		//EOF-click on city to fetch Branch
		
/*$("#doctor_id_txt").autocomplete({
	source: "<?php echo $this->Html->url(array("controller" => "App", "action" => "advanceTwoFieldsAutocomplete","DoctorProfile",'user_id',"doctor_name",'is_active=1','null','null',"admin" => false,"plugin"=>false)); ?>",
	select:function( event, ui ) {  
		$("#doctorID").val(ui.item.id);
	},
	messages: {
        noResults: '',
        results: function() {}
	 }
	});*/


		$("#from").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	
		
 $("#to").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',
	
	});
	 $("#pack_type").change(function(){
		if($('#pack_type option:selected').val()=="delivery"){
			$('.delivery').show();
			$('#searchLower').show();
			$('#searchLower').css({"display": "","float": "right"});
			$('#searchUpper').hide();			
		}else{
			$('.delivery').hide();
			$('#delivery_type').val('');
			$('#searchUpper').show();
			$('#searchUpper').css("display", "block");
			$('#searchLower').hide();
			
		}
	});
		
	 $("#edd_to").datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			//maxDate: new Date(),
			dateFormat: '<?php echo $this->General->GeneralDate();?>',
		
		});		
	 $("#edd_from").datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			//maxDate: new Date(),
			dateFormat: '<?php echo $this->General->GeneralDate();?>',
		
		});
	$('#reset').click(function(){
		//for resetting filtrs
 		$('#surgeonreport').trigger('reset');
 		$('#searchCampDate').val('');
 		$('#from').val('');
 		$('#to').val('');
 		$('#edd_from').val('');
 		$('#edd_to').val('');
		$('#lookup_name').val('');
		$('#patient_id').val('');
		$('#userID').val('');
		$('#reporting_manager').val('');
		$('#tariff').val('');
		$('#search_service_name').val('');
		$('#serviceID').val('');
		$("option:selected").removeAttr("selected");
	});
		$("#search_service_name").autocomplete({
							source: "<?php echo $this->Html->url(array("controller" => "App", "action" => "advanceMultipleAutocomplete","TariffList","id&name&service_category_id",'null','null','null',"admin" => false,"plugin"=>false)); ?>",
							select:function( event, ui ) { 						
								$("#serviceID").val(ui.item.id);								
								$('#service_group_id').val(ui.item.service_category_id).attr("selected", "selected");	
							},
							messages: {
						        noResults: '',
						        results: function() {}
							 }
							});
			
    $("#service_group_id").change(function(){	
		var getServiceId=$("#service_group_id").val();
		if(getServiceId !=''){
		$("#search_service_name").autocomplete({
							source: "<?php echo $this->Html->url(array("controller" => "App", "action" => "advanceMultipleAutocomplete","TariffList","id&name&service_category_id",'null','null','null')); ?>"+'/'+'service_category_id='+getServiceId,
							select:function( event, ui ) { 						
								$("#serviceID").val(ui.item.id);								
								$('#service_group_id').val(ui.item.service_category_id).attr("selected", "selected");	
							},
							messages: {
						        noResults: '',
						        results: function() {}
							 }
							});
			$("#search_service_name").val("");
			$("#serviceID").val("");
		}else{
			return true;
		}
			
		});
		$("#search_service_name").keyup(function() {
			console.log($(this).val());
			if($(this).val()==''){
				$("#serviceID").val("");
			}
		});
		$('#searchrevenue').click(function(){
				var currentURL = window.location.href;			
				$("#surgeonreport").attr("action", currentURL);
	});


<?php //BOF-For only P & L Report
	if($this->params['action']=='profitLossStatement'){?>
	//load all records from here using ajax
		$("#Submit,#refreshBtn").click(function(){			
			var currentId= $(this).attr('id');		
			if(currentId=="refreshBtn")			
				$("#from_date,#to_date").val("");
			if(currentId=="Submit"){	
				var valid=jQuery("#surgeonreport").validationEngine('validate');
				if(valid){					
					 $("#submit").hide();
					 $('#busy-indicator').show();
				}else{
					return false;
				}
			}
		//	console.log($('#HeaderForm').serialize());
			$.ajax({
				url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossReport'));?>',
				data:$('#surgeonreport').serialize(),
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success:function(data){					
					$("#records").html(data).fadeIn('slow');
					$('#busy-indicator').hide();
				}
			});
		});
	//on load render profitLossReport
	/*$.ajax({
		url: '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'profitLossReport'));?>',
		beforeSend:function(data){
			$('#busy-indicator').show();
		},
		success:function(data){			
			$("#records").html(data).fadeIn('slow');
			$('#busy-indicator').hide();
		}
	});*/	
<?php }
	//BOF-For only P & L Report
	?>
		
});

//BOF-Only For Doctor revenue Report as well Service Doctor Revenue Report
function SelectExcel(excel){			
				if(excel=='excel'){					
					var currentURL = window.location.href;			
					$("#surgeonreport").attr("action", currentURL+"/"+ excel);
					$( "#surgeonreport" ).submit();	
				}		
}

function selectExcelAvoid(){					
					var currentURL = window.location.href;			
					$("#surgeonreport").attr("action", currentURL);
					$( "#surgeonreport" ).submit();	
				
			
}

function submitExcel(){
    var action = $("#surgeonreport").attr("action");
    $("#surgeonreport").attr("action",action+'/excel');
}
function submitForm(){
   var action = $("#surgeonreport").attr("action");
   action = action.replace('/excel','');
    $("#surgeonreport").attr("action",action); 
}
//EOF-Only For Doctor revenue Report as well Service Doctor Revenue Report
//For Sort array in ascending Order
		function sortData(data) {
			var sorted = [];
			Object.keys(data).sort(function(a,b){				
				return data[a] < data[b] ? -1 : 1
			}).forEach(function(key){ 
				sorted.push({name: key, val: data[key]});
			});			 
			return sorted;
		}
//BOF-click on Branch to fetch doctors
		<?php if($this->params['action']=='doctorRevenueReport' || $this->params['action']=='billwiseDoctorRevenueReport'){?>
		
		function setDoctors() {			
			 var chk1Array=[];   	  
        	   $(".locations:checked").each(function () {        	   	 	
          	   			checkId=this.id;          	   	 
          	   			splitedId=checkId.split('_');          	   	 	   	   
          	   			chk1Array.push(splitedId[1]);            	   		       	   	 
          		});
			
			 $.ajax({
					url : "<?php echo $this->Html->url(array("controller" => 'Reports', "action" => "ajaxFetchDoctorOnLocationId", "admin" => false));?>",
						type: 'POST',
						data: 'branch_id='+ chk1Array,
						dataType: 'html',
					  	beforeSend:function(data){
			 			$('#busy-indicator').show('fast');
			 			},
			 			success: function(data){   						
			 				$('#busy-indicator').hide('fast');
							var objDoctor= jQuery.parseJSON(data); 							
							returnDocArr = sortData(objDoctor);			//For sort data				
							addMultipleDoctorElement(returnDocArr);
			 			}
			 	});  
		}

		//For render checkbox of branch on selected city  
		function addMultipleDoctorElement(docArr){
			//console.log(BrnchArr);
			$('#doctor_id_txt').html('');
			$("#doctor_id_txt")
			.append($('<select>').attr({'style':'float:left;width:200px;height:100px;','class':'textBoxExpnd','multiple':'multiple','empty':'PLEASE SELECT','name':'data[Patient][doctor_id_txt][]','hiddenField':false}))			
			$('#doctor_id_txt option').remove();
			$('#doctor_id_txt').append( new Option('PLEASE SELECT' , ''));
			$.each(docArr, function( key, value ) { 
			$('#doctor_id_txt').append( new Option(value.val , value.name));
          });
		}
		<?php }?>
		//EOF-click on Branch to fetch doctors
</script>

