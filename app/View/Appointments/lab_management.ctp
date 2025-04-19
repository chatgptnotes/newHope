<?php  echo $this->Html->script(array('inline_msg','jquery.blockUI',/* 'jquery.autocomplete',*/'jquery.fancybox-1.3.4','jquery.contextMenu','jquery.tooltipster.min.js'));
echo $this->Html->css(array('tooltipster.css'/*,'jquery.autocomplete.css'*/,'jquery.fancybox-1.3.4.css','jquery.fancybox-1.3.4.css' ,'jquery.contextMenu'));   ?>
<style>

#talltabs-blue {
    border-top: 6px solid #8A9C9C;
    clear: left;
    float: left;
    font-family: Georgia,serif;
    overflow: hidden;
    padding: 0;
	display:none;
    /*width: 100%;*/
}

#talltabs-blue ul {
    list-style: none outside none;
    margin: 0;
    padding: 0;
    position: relative;
    text-align: center;
}

#talltabs-blue ul li {
    display: block;
    float: left;
    list-style: none outside none;
    margin: 0;
    padding: 0;
    position: relative;}
#talltabs-blue ul li a:hover {
    background:#DDDDDD;
	color:#31859C !important;
}

#talltabs-blue ul li a.active,
 #talltabs-blue ul li.active a:hover 
 {background:#DDDDDD;
 color: #31859C !important;}

#talltabs-blue ul li a {
    background: none repeat scroll 0 0 #8A9C9C;
    color: #FFFFFF !important;
    display: block;
    float: left;
    margin: 0 1px 0 0;
    padding: 8px 10px 6px;
    text-decoration: none;
}
.future-filter {
    float: left;
    padding-left: 0 !important;
}

.todays-filter {
    float: left;
}
.table_format a{
padding: 0 0 0 0 !important;
}
.darkBrown {
	background: #7B472F !important;
	color: #fff !important;
	font-weight: bold;
	padding: 0;
}

.blue {
	background: #CCDEFC !important;
	color: #020181 !important;
	font-weight: bold;
	padding: 0;
}

.darkBlue {
	background: #5CAAF5 !important;
	color: #CCDEFC !important;
	font-weight: bold;
	padding: 0;
}

.yellow {
	background: #F6F99E !important;
	color: #5A7625 !important;
	font-weight: bold;
	padding: 0;
}

.lightGreen {
	background: #DBFEDA !important;
	color: #5A7625 !important;
	font-weight: bold;
	padding: 0;
}

.darkGreen {
	background: #1C6A16 !important;
	color: #fff !important;
	font-weight: bold;
	padding: 0;
}

.red {
	background: #D40001 !important;
	color: #fff !important;
	font-weight: bold;
	padding: 0;
}
.purple{
	background:#580E87 !important;
	color: #fff !important;
	font-weight: bold;
	padding: 0;
}
.orange{
	background:#FC8A06 !important;
	color: #000 !important;
	font-weight: bold;
	padding: 0;
}

.textAlign {
	text-align: left;
	font-size: 12px;
	padding-right: 0px;
	padding-left: 0px;
}

select {
	border: 0.100em solid;
	border-radius: 25px;
	border-color: olive;
	color: #E7EEEF;
	font-size: 13px;
	outline: medium none;
	padding: 5px 7px;
	resize: none;
}

.td_ht {
	line-height: 18px;
}

.furtueDropdown {
	border: 1px solid #214A27;
	color: #E7EEEF;
	font-size: 13px;
	outline: medium none;
	padding: 0px;
	resize: none;
}

.hover {
	background-color: none;
}

.currentDropdown {
	background: none repeat scroll 0 0 #FFFFFF !important;
	border: 1px solid #214A27;
	color: #E7EEEF;
	font-size: 13px;
	outline: medium none;
	padding: 0px;
	resize: none;
	width: auto;
}


.row_gray .tdLabel { /*padding-left: 4px !important;*/
	
}

.yellowBulb {
	background:
		url("<?php echo $this->webroot ?>theme/Black/img/icons/finalBlink.gif")
		no-repeat center 18px;
	cursor: pointer;
}

.greyBulb {
	background:
	url("<?php echo $this->webroot ?>theme/Black/img/icons/grey.png")
	no-repeat center 14px;
	/* display:inline-block;*/
	cursor: not-allowed;
}

.redBulb {
	background:
		url("<?php echo $this->webroot ?>theme/Black/img/icons/red.png")
		no-repeat center 12px;
	cursor: pointer;
}
.greenBulb {
	background:
		url("<?php echo $this->webroot ?>theme/Black/img/icons/green.png")
		no-repeat center 12px;
	cursor: pointer;
}
.chamberAllotted input,select,textarea {
	background: none repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
}

.seen-filter {
    float: left;
    margin: 0px;
    /*padding: 0 0 0 0;*/
}

#dateTo {
    float: left;
    margin: 1px 0 0 10px;
	line-height:15px;
}

#selectedDate {
    float: left;
    margin:2px 0 0 0px;
}
#search-box {
    border: 1px solid #DDEBF9 !important;
    padding-bottom:5px !important;
	padding-right:0px !important;
	/*width: 332px;*/
	float:left;
	margin-top:11px;
}
.context-menu-three {
    float: left;
    margin:10px 0 0 0;
 }
 
.ui-datepicker-trigger {
  /*  height: 25px !important;*/
    padding: 0px !important;
    
}
.hasDatepicker {
    height: 15px !important;
    line-height: 20px;
    width: 120px;
}

.context-menu-item label{
padding: 0px;
text-align:left;
}

#dateFrom {
    margin: 1px 0 0;
	line-height:15px;
}
.active{
color: red !important;
}
#ui-datepicker-div{
z-index:3000;
}
label {
    color: #000 !important;
    float: none !important;
    font-size: 13px;
    margin-right: 10px;
    padding-top: 7px;
    text-align: right;
    width: 97px;
}
input[type=radio] {
    display:none;
}
 
input[type=radio] + label {
    display:inline-block;
    margin:8px -3px 0 ;
    padding: 4px 12px;
    margin-bottom: 0;
    font-size: 14px;
    line-height: 20px;
  /*  width:10%;*/
    color: #333;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255,255,255,0.75);
    vertical-align: middle;
    cursor: pointer;
    background-color: #f5f5f5;
    background-image: -moz-linear-gradient(top,#fff,#e6e6e6);
    background-image: -webkit-gradient(linear,0 0,0 100%,from(#fff),to(#e6e6e6));
    background-image: -webkit-linear-gradient(top,#fff,#e6e6e6);
    background-image: -o-linear-gradient(top,#fff,#e6e6e6);
    background-image: linear-gradient(to bottom,#fff,#e6e6e6);
    background-repeat: repeat-x;
    border: 1px solid #ccc;
    border-color: #e6e6e6 #e6e6e6 #bfbfbf;
    border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
    border-bottom-color: #b3b3b3;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff',endColorstr='#ffe6e6e6',GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
    -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
}
 
input[type=radio]:checked + label {
       background-image: none;
    outline: 0;
    -webkit-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
    -moz-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
        background-color:#e0e0e0;
}
</style>
<!-- <div class="message" id="flashQuickRegSucess" style="display: none">Patient
	Registered Sucessfully</div> -->
<div class="inner_title"><h3>  <?php //echo __('Patients list' ); ?>  	 </h3>
	<span ><?php  
		//echo $this->Html->link($this->Html->image('icons/refresh-icon.png',array('alt'=>'Refresh List','title'=>'Refresh List')),
			// "#",array('escape'=>false,'onclick'=>"load_list();")); 
		?></span>
		<?php 
	$role = $this->Session->read('role');
	
?>
		<?php  		echo $this->Form->create('Appointment',array('action'=>'lab_patient_dashboard','default'=>false,'id'=>'content-form')); ?>
<table width="100%">
	<tr>
					
					<td class="tdLabel"><label><?php echo $this->Form->input('Discharged',array('type'=>'checkbox','class'=>'isDischarge','id'=>"isDischarge",
							'autocomplete'=>'off','label'=>false,'div'=>false));
					echo "Show Closed Visit"; ?></label>
	        	</td>
					<td class="tdLabel" width="5%" >
					
					<!--<label>Patient Name:</label>-->
					<?php echo $this->Form->input('patient_name',array('type'=>'text','class'=>'patient-filter','id'=>"patient-filter",
											'autocomplete'=>'off','label'=>false,'div'=>false,'placeholder'=>'Patient Name'));
					echo $this->Form->hidden('patient_id',array('id'=>'patient_id'));?>
					<script>
			$('#patient-filter').click(function(){
				$('#dateFrom').val('');
				$('#dateTo').val('');
				$('#list_tab').hide();
				$('#future-filter').removeClass('active');
				$('#closed-filter').removeClass('active');
				$('#todays-filter').removeClass('active');
				$('#myPatient-filter').removeClass('active');
				$('#viewAll-filter').removeClass('active');
				$('#physician_tab').removeClass('active');
				});</script>
				<?php 
					$this->Js->get('#patient_id'); 
					$this->Js->event(
							'change',
							$this->Js->request(
									array('action' => 'lab_patient_dashboard',),
									array('method'=>'POST','dataExpression'=>true,'data'=> $this->Js->serializeForm(
																						                    array(
																						                        'isForm' => false,
																						                        'inline' => true
																						                    )
																						                ),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
							)
					);

			?>
		</td> 
		<td><?php echo $this->Form->input('reset',array('class'=>'blueBtn','id'=>"resetData",'type'=>'reset',
							'label'=>false,'style'=> 'float:left;margin:0 10px 0 0;'));?></td>
					<!--<td class="tdLabel search_icon" id="search-box">
					<label>Date From:</label>-->
					<?php //echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",
										//	'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'Date From'));?>
					<!--<label>Date To:</label>-->
					<?php // echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",
							//'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'Date To'));
					//echo "Show Completed ";
			
			//echo '&nbsp; &nbsp;'.$this->Html->image('icons/views_icon.png',array('id'=>'selectedDate', 'style'=>'float:right'));?>
			<script>
			$('#selectedDate').click(function(){
				$('#patient-filter').val('');
				$('#patient_id').val('');
				$('#list_tab').hide();
				$('#future-filter').removeClass('active');
				$('#closed-filter').removeClass('active');
				$('#todays-filter').removeClass('active');
				$('#myPatient-filter').removeClass('active');
				$('#viewAll-filter').removeClass('active');
				$('#physician_tab').removeClass('active');
				});</script>
				<?php 
					$this->Js->get('#selectedDate'); 
					$this->Js->event(
							'click',
							$this->Js->request(
									array('action' => 'lab_patient_dashboard',),
									array('method'=>'GET','dataExpression'=>true,'data'=> $this->Js->serializeForm(
																						                    array(
																						                        'isForm' => false,
																						                        'inline' => true
																						                    )
																						                ),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
							)
					);?>
		</td>
		<!--  <td class="search_icon" id="search-box"><?php //echo $this->Form->button('Search',array('type'=>'button','class'=>'blueBtn','id'=>'selected','label'=>false,'div'=>false));?>
		</td>-->
		<td align="left" style="width:575px; float:left;"><?php if($role != Configure::read('doctorLabel')&& $role != Configure::read('nurseLabel')){ //not visible for doctor and Nurse?>
		<div style="float:left; margin:10px 0px 0px;" class="tdLabel"><?php 
			//echo $this->Html->link('Future Appts','#future',array('class'=>'future-filter','id'=>"future-filter", 'label'=>false,'div'=>false));?>
			<script>
			$('#future-filter').click(function(){
				
				$('#patient-filter').val('');
				$('#patient_id').val('');
				$('#dateFrom').val('');
				$('#dateTo').val('');
				$('#list_tab').hide();
				$('#future-filter').addClass('active');
				$('#closed-filter').removeClass('active');
				$('#todays-filter').removeClass('active');
				$('#myPatient-filter').removeClass('active');
				$('#viewAll-filter').removeClass('active');
				$('#physician_tab').removeClass('active');
				});</script>
			<?php $this->Js->get('#future-filter');
			$this->Js->event('click',
							$this->Js->request(
							array('action' => 'lab_patient_dashboard','future'),
							array('method'=>'POST','dataExpression'=>true,'data'=> $this->Js->serializeForm(
									array(
											'isForm' => false,
											'inline' => true
									)
							),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
					)
			);
		
		?>
		</div>
		<?php }
		?><div style="padding-left:5px; margin:10px 0px 0px;float: left;" class="tdLabel">
		<?php 
		//if($future == 'future'){
			//echo $this->Html->link('Today\'s Appts','#future',array('class'=>'todays-filter','id'=>"todays-filter", 'label'=>false,'div'=>false));
			?>
			<script>
			$('#todays-filter').click(function(){
				$('#patient-filter').val('');
				$('#patient_id').val('');
				$('#dateFrom').val('');
				$('#dateTo').val('');
				$('#list_tab').hide();
				$('#todays-filter').addClass('active');
				$('#closed-filter').removeClass('active');
				$('#future-filter').removeClass('active');
				$('#myPatient-filter').removeClass('active');
				$('#viewAll-filter').removeClass('active');
				$('#physician_tab').removeClass('active');
				});</script>
			<?php $this->Js->get('#todays-filter');
				$this->Js->event('click',
								$this->Js->request(
								array('action' => 'lab_patient_dashboard'),
								array('method'=>'POST','dataExpression'=>true,'data'=> $this->Js->serializeForm(
										array(
												'isForm' => false,
												'inline' => true
										)
								),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
						)
				);
		//}
			?>
			</div>
			<div style="padding-left:5px; margin:10px 0px 0px;float: left;" class="tdLabel">
		<?php 
			//echo $this->Html->link('Today\'s Closed Appts','#future',array('class'=>'close-filter','id'=>"closed-filter", 'label'=>false,'div'=>false));
			?>
			<script>
			$('#closed-filter').click(function(){
				$('#patient-filter').val('');
				$('#patient_id').val('');
				$('#dateFrom').val('');
				$('#dateTo').val('');
				$('#todays-filter').removeClass('active');
				$('#closed-filter').addClass('active');
				$('#list_tab').show();
				$('#future-filter').removeClass('active');
				$('#myPatient-filter').removeClass('active');
				$('#viewAll-filter').removeClass('active');
				$('#physician_tab').removeClass('active');
				});</script>
			<?php $this->Js->get('#closed-filter');
				$this->Js->event('click',
								$this->Js->request(
								array('action' => 'lab_patient_dashboard','closed'),
								array('method'=>'POST','dataExpression'=>true,'data'=> $this->Js->serializeForm(
										array(
												'isForm' => false,
												'inline' => true
										)
								),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
						)
				);
			?>
			</div>
			<?php if($role==Configure::read('nurseLabel')){?>
			<div class="tdLabel" style=" float: left; margin:10px 0 0;" id="my_patient">
		<?php 
			//echo $this->Html->link('My Patients','#myPatient',array('class'=>'myPatient-filter','id'=>"myPatient-filter", 'label'=>false,'div'=>false));
			?>
			<script>
			$('#myPatient-filter').click(function(){
				$('#patient-filter').val('');
				$('#patient_id').val('');
				$('#dateFrom').val('');
				$('#dateTo').val('');
				$('#view_all').show();
				$('#list_tab').hide();
				$('#my_patient').hide();
				$('#todays-filter').removeClass('active');
				$('#closed-filter').removeClass('active');
				$('#future-filter').removeClass('active');
				$('#myPatient-filter').addClass('active');
				$('#viewAll-filter').removeClass('active');
				$('#physician_tab').removeClass('active');
				});</script>
			<?php $this->Js->get('#myPatient-filter');
				$this->Js->event('click',
								$this->Js->request(
								array('action' => 'lab_patient_dashboard',$role),
								array('method'=>'POST','dataExpression'=>true,'data'=> $this->Js->serializeForm(
										array(
												'isForm' => false,
												'inline' => true
										)
								),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
						)
				);
			?>
			</div><?php }?>	
			<?php if($role==Configure::read('nurseLabel')){?>
			<div class="tdLabel" style=" float: left; margin:10px 0 0;display: none;" id="view_all">
		<?php 
			//echo $this->Html->link('View All Patients','#viewAll',array('class'=>'viewAll-filter','id'=>"viewAll-filter", 'label'=>false,'div'=>false));
			?>
			<script>
			$('#viewAll-filter').click(function(){
				$('#patient-filter').val('');
				$('#patient_id').val('');
				$('#dateFrom').val('');
				$('#dateTo').val('');
				$('#my_patient').show();
				$('#list_tab').hide();
				$('#view_all').hide();
				$('#todays-filter').removeClass('active');
				$('#closed-filter').removeClass('active');
				$('#future-filter').removeClass('active');
				$('#myPatient-filter').removeClass('active');
				$('#viewAll-filter').addClass('active');
				$('#physician_tab').removeClass('active');
				});</script>
			<?php $this->Js->get('#viewAll-filter');
				$this->Js->event('click',
								$this->Js->request(
								array('action' => 'lab_patient_dashboard'),
								array('method'=>'POST','dataExpression'=>true,'data'=> $this->Js->serializeForm(
										array(
												'isForm' => false,
												'inline' => true
										)
								),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
						)
				);
			?>
			</div><?php }?>	  
			<!--<div class="context-menu-three tdLabel" title="Right Click To Select Physicians" id="physician_tab">
    &nbsp;&nbsp;Select Physicians<br><br>
    <span style="font-style: italic;font-size: x-small; color: gray;  padding-top: 7px;">(Right Click To View Physicians)</span>
    </div>-->
    <?php if($this->Session->read('website.instance')=='kanpur'){?>
    <div class="tdLabel"  id="list_tab" style="float: left; display:none">
    <?php //echo $this->Html->link(__('List of VIPs'),array('action'=>'discount_patient_list','free'),array('class'=>'blueBtn','escape'=>false,'target'=>__blank));?>
    <?php //echo $this->Html->link(__('List of Discounted Patient'),array('action'=>'discount_patient_list','discount'),array('class'=>'blueBtn','escape'=>false,'target'=>__blank));?>
    <?php //echo $this->Html->link(__('List of All Patients'),array('action'=>'discount_patient_list','all'),array('class'=>'blueBtn','escape'=>false,'target'=>__blank));?>
    </div>
    <?php }?>
    
	</td>
	
		<div style="float: right; margin: 22px 0;"><?php  
			if($this->Session->read('website.instance')!='vadodara'){
		     echo $this->Html->link(__('Display Token no.'),
			 array("action"=>'patientWaitingList'),array('escape'=>false,'class'=>'blueBtn')); 
			}?>
		</div>
		
<!--   <td width="17%" class="tdLabel" style=" padding-left:0px !important;">
 
			<?php 
					/* if(strtolower($role)==strtolower(Configure::read('adminLabel'))) {
						echo "Select Doctor:" ; 
						echo $this->Form->input('All Doctors',array('empty'=>'All Doctors','type'=>'select','options'=>$doctors,'class'=>'all-doctors','id'=>"all-doctors",
												'autocomplete'=>'off','label'=>false,'div'=>false));
						$this->Js->get('#all-doctors'); 
						$this->Js->event(
								'change',
								$this->Js->request(
										array('action' => 'appointments_dashboard',),
										array('method'=>'POST','dataExpression'=>true,'data'=> $this->Js->serializeForm(
																							                    array(
																							                        'isForm' => false,
																							                        'inline' => true
																							                    )
																							                ),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
								)
						);

					}  */  ?>
					</td>
 
	-->
		
	</tr>
	<tr><td colspan="4" style="padding-bottom: 10px"><?php /*$options  = array('OPD'=>'<b>OPD Patients</b>','Rad'=>'<b>Radiology Patients</b>');
		   echo $this->Form->input('type',array('type'=>'radio','options'=>$options,'div'=>false,'value'=>'deposit',
					'label'=>true,'legend'=>false,'class'=>'typeSelected'));*/?>
					
	<div style="padding-left: 16px">			
				<input id="radio1" name="radios" value="OPD"  type="radio" class='typeSelected'>
				   <label for="radio1"><font color="#3185AC">OPD</font></label>
				<input id="radio2" name="radios" value="Lab" checked type="radio" class='typeSelected'>
				   <label for="radio2"><font color="#3185AC">Laboratory</font></label>
				<input id="radio3" name="radios" value="Rad" type="radio" class='typeSelected'>
				   <label for="radio3"><font color="#3185AC">Radiology</font></label> 
				   
				 
		</div>
</td></tr>
</table> 
				 	
</div>
<div class="clr ht5"></div>
<!--  <div id="talltabs-blue">
		<ul>
			<li id="button_tab" style="float:left;">
			<?php 
				echo $this->Form->input('doctor_id',array('id'=>'doctor_id' ,'type'=>'hidden'));
				echo $this->Html->link('All','javascript:void(0)',array('class'=>'active doctor_tab','id'=>'' ));?>
			</li>
			<?php foreach($doctors as $key=>$doctor){?>
				<li id="<?php echo $key;?>" style="float:left;"  >
				<?php	$selectedAction = $this->params->action ;
					$$selectedAction = 'active' ;
					 echo $this->Html->link($doctor,'javascript:void(0)',array('class'=>"doctor_tab",'id'=>$key ));?>  
				</li>
				<?php }?>
			</ul>
</div>-->
<?php if(strtolower($role)==strtolower(Configure::read('adminLabel'))) {
						$this->Js->get('#all-doctors'); 
						$this->Js->event(
								'change',
								$this->Js->request(
										array('action' => 'lab_patient_dashboard',),
										array('method'=>'POST','dataExpression'=>true,'data'=> $this->Js->serializeForm(
																							                    array(
																							                        'isForm' => false,
																							                        'inline' => true
																							                    )
																							                ),'async' => true, 'update' => '#content-list','before'=>'loading();','complete'=>'onCompleteRequest();')
								)
						);

					}?>
					
					
					<?php  	echo $this->Form->end();
				echo $this->Js->writeBuffer(); 
				
		//		echo $this->Form->input('patient_count',array('id'=>'patient-count' , "value"=>''));
				?>
<div id="content-list" ></div>
<style>
		#msg{
			display:none; position:absolute; z-index:200;
			padding-left:7px;
			background-image: url("../theme/Black/img/icons/tick.png");
		    background-position: 2px 40%;
		    padding: 5px 0px 5px 18px;
		    background-repeat: no-repeat;     
		    background-color: #EBF8A4;
		    color: #000000;
		    background-repeat: no-repeat;
		    border: 1px solid #A2D246;
		    border-radius: 5px;
		    box-shadow: 0 1px 1px #FFFFFF inset;
		    margin: 0.5em 0 1.3em;
		    background-color: #EBF8A4;
		    width: 150px;
		    font-weight: bold;
		}
		
		
</style><?php //debug($this->request);?>
<script>	 

	function load_list(refresh){
		//$("#content-form").reset();
		$('#content-form')[0].reset();
		//$('#content-form').find('form')[0].reset();
		
		url="<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "lab_patient_dashboard","admin" => false)); ?>";
		pageUrl=$('#patient-count').attr('url');

		if (typeof pageUrl !== "undefined") {
			url= pageUrl;  		
		}
		
		$.ajax({
			  type : "POST",
			  url: url,
			  context: document.body,
			  beforeSend:function(){
			    // this is where we append a loading image
			    if(refresh!='1'){	   
			   loading();
			  } 
			  },	  		  
			  success: function(data){					 
				 // $('#busy-indicator').hide('fast');
				$('#content-list').html(data).fadeIn('slow');
				//$('#content-list').unblock();
				
			  }
		});
		return false ;
	}

	//load_list(); // page onload call 
	//refresh_list();  
	function refresh_list(){
		
		//for refreshing on count change
		//var countData= $('#patient-count').val();
		setInterval(function(){
			//Condition for not to refresh on search and future appointment 
			if($('#is_search').val()!='1'){
			countData = parseInt($('#patient-count').val());
			if(isNaN(countData))
				countData=0;
			// url=$('#patient-count').attr('url);
			$.ajax({
			   type : "POST",
		       url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "lab_count", "admin" => false)); ?>",
		       context: document.body,
		       success: function( data ){
		           // do something with the data 
		           data = parseInt(data) ;
		           if(data != countData){ 
					   load_list(1);
				   }
		          // recursive(); // recurse
		       },
		       error: function(){
		          // recursive(); 
		       }
		   });}//end of if...
			   },20000);
		}

	   
	function loading(){
		 $('#content-list').block({ 
	        message: '<h1><img src="../theme/Black/img/icons/ajax-loader_dashboard.gif" /> Please Wait...</h1>', 
	        css: {            
	            padding: '5px 0px 5px 18px',
	            border: 'none', 
	            padding: '15px', 
	            backgroundColor: '#DDDDDD', 
	            '-webkit-border-radius': '10px', 
	            '-moz-border-radius': '10px',               
	            color: '#000',
	            'text-align':'left' 
	        },
	        overlayCSS: { backgroundColor: '#cccccc' } 
	    }); 
	}
	
	function onCompleteRequest(){
		$('#content-list').unblock(); 
	}
	 
	$(document).on('change',".status",function(){
 
			currentId = $(this).attr('id') ;
			splittedVar = currentId.split("_");		 
			id = splittedVar[1]; 	//appointment ID 
			currentValue = $(this).val();	
			optionClass= $(this).find("option:selected").attr('class') ;  
			$(this).css('background-color',optionClass);
			patient_id= $(this).attr('patient_id');
			 var  is_delete ='';
			if(currentValue=="Arrived"){
				var arrTime= new Date();
				var hour= arrTime.getHours();
				if(hour<10){
					hour='0'+hour;
				}
				var min = arrTime.getMinutes();
				if(min<10){
					min='0'+min;
				}
				var arrivedAt= hour+":"+min;
				var time="&arrived_time="+arrivedAt;
			}else if(currentValue=="Seen" || currentValue=="Closed"){
				elapsed=$('#elapsed-'+currentId).html(); 
				if(typeof elapsed !== "undefined" ) //added by pankaj (elapsed is undefined)
				time="&elapsed_time="+elapsed.trim();
			}else{
				time='';
			}
			if(currentValue=="No-Show" || currentValue=="Cancelled"){
				$("#room_"+id).attr('disabled',true);
				$("#nurse_"+patient_id+"_"+id).attr('disabled',true);
				$("#"+currentId).attr('disabled',true);
					if(currentValue=="Cancelled"){
						$("#"+currentId).addClass('red');
						var isSchedule=confirm('Do You Want To Re-Schedule Appointment?');
					    if (isSchedule) {
					    	 window.location="<?php echo $this->Html->url(array("controller" => 'DoctorSchedules', "action" => "doctor_event","admin" => false)); ?>?reScheduleAppt="+id;
					    	 is_delete="";
					    } else {
					    	 is_delete="&is_deleted=1";
					    }
					}
					else if(currentValue=="No-Show"){
						$('#Iconregister').hide();
						$("#"+currentId).addClass('purple');
					}
					 
				}
			if(currentValue=="Confirmed with Patient"){
				confirm="&confirmed_by_doctor=Yes";
				  $("#"+currentId).removeClass('darkBrown');
				  $("#"+currentId).addClass('darkGreen');
			}
			else{
				confirm='';
			}
			
			
			$.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "update_appointment_status","admin" => false)); ?>/"+$(this).val()+"/status",
				  data:"id="+id+time+confirm+is_delete,//Pooja
				  context: document.body,	   
				  beforeSend:function(){
				    // this is where we append a loading image
				   //loading();	
				   inlineMsg(currentId,'Updating Status..',false);			   
				  }, 	  		  
				  success: function(data){					  					 
					  if(currentValue=="Arrived"){
						 // $("#"+currentId+" option").remove();	
						 $("#blink_"+id).removeClass('greyBulb');//action column changes images on status change
						 $("#blink_"+id).addClass('yellowBulb');
						  $("#room_"+id).attr('disabled',false);  //ID with appointment id
						  $("#nurse_"+patient_id+"_"+id).attr('disabled',false); //id with patientID and appointment id
						  $("#doctor_"+id).attr('disabled',false);
						  $("#arrived_time_"+id).html(arrivedAt).css('color','#318FAE');
						  $("#elapsed-"+currentId).html('0 Min');
						  $("#"+currentId).addClass('blue');
						  var mySelect = $(this);
						   
						  if(data.trim() == 'register' ){
							alert("Please register patient");
							window.location.href = "<?php echo $this->Html->url(array('controller'=>'patients','action'=>'add','?'=>array('type'=>'OPD')));?>&from=dashboard&person_id="+splittedVar[0]+"&apptId="+id+"&flag=fromPtList" ;
						  }else{	
							  load_list();			  
							 // data1 = $.parseJSON(data); 

							 // var optClass = '';						 
							 /* $.each(data1, function(val, text) {  
								  if(val=='Arrived')
									  optClass = 'blue';
								  else if(val=='Assigned')
									  optClass = 'darkBlue';
								  else if(val=='In-Progress')
									  optClass = 'yellow';
							 	  else if(val=='Seen')
									  optClass = 'lightGreen';
								  else if(val=='Closed')
									  optClass = 'darkGreen';
									  
								  	$("#"+currentId).append( "<option value='"+val+"' class='"+optClass+"'>"+text+"</option>" );
								  	
							  });*/
						  }
						 
					  }else if(currentValue=='Closed'){
						  load_list(); //reload patient list 
					  }
					  //alert(currentId);
					  // inlineMsg(currentId,'Status Changed');
					  //
					 
					  			 
				  }
				  
			});
		});

	$(document).on('change',".seen-status",function(){
			currentId = $(this).attr('id') ;
			splittedVar = currentId.split("_");	
			person_id = splittedVar[0];	 
			id = splittedVar[1];
			currentVal =$(this).val() ;			 
			if(currentVal=='In Room'){
				html1 = $("#parent-content").html() ;
				$('#content-list').block({ 
					        message: html1, 
					        css: {            
					            padding: '5px 0px 5px 18px',
					            border: 'none', 
					            padding: '15px', 
					            backgroundColor: '#fffff', 
					            '-webkit-border-radius': '10px', 
					            '-moz-border-radius': '10px',               
					            color: '#fff',
					            'text-align':'left' 
					        },
					        overlayCSS: { backgroundColor: '#cccccc' } 
					    }); 					    
				//$("#chambers").fadeOut('slow');
			}else{
				$.ajax({
					  type : "POST",
					  url: "<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "update_appointment_status","admin" => false)); ?>/"+$(this).val()+"/seen_status",
					  data:"id="+id,
					  context: document.body,	   
					  beforeSend:function(){
					    // this is where we append a loading image	
						  inlineMsg(currentId,'Updating Status..',false);			   
					  }, 	  		  
					  success: function(data){
						  // BOF finalBilling 
						 /* $.ajax({
							  type : "POST",
							  url: "<?php //echo $this->Html->url(array("controller" => 'Billings', "action" => "opProcessDone","admin" => false)); ?>/"+person_id,
							  data:"person_id="+person_id,
							  context: document.body,	 
							  success: function(data){
							  } 
						 });*/
						  // EOF finalBilling 
						  /*$("#"+currentId+" option").remove(); 
						  var mySelect = $(this);					  
						  data1 = $.parseJSON(data);	
						  $.each(data1, function(val, text) {  
							  $("#"+currentId).append( "<option value='"+val+"'>"+text+"</option>" );
						  });*/
						  //location.reload();
						  inlineMsg(currentId,'Status Changed');				 
					  }
				});
			}
	});
	 
	$(document).on('change',"#appointment-room",function(){
		 
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "update_appointment_status","admin" => false)); ?>/"+$(this).val()+"/chamber_id",
			  data:"id="+id+"&chamber="+$(this).find("option:selected").text(),
			  context: document.body,	   
			  beforeSend:function(){
			    // this is where we append a loading image		
				  inlineMsg(currentId,'Updating Status..',false);		   
			  }, 	  		  
			  success: function(data){	 
				  $("#"+currentId+" option").remove(); 
				  var mySelect = $(this);					  
				  data1 = $.parseJSON(data);					 
				  $.each(data1, function(val, text) {  
					  if(val=='In Room') selected = "selected" ;
					  else selected ="" ;
					  $("#"+currentId).append( "<option value='"+val+"' "+selected+">"+text+"</option>" );
				  });
				  location.reload();
				  inlineMsg(currentId,'Status Changed');
				  onCompleteRequest();
				 			 
			  }
		});
	});
	$(document).ready(function (){ 
		
		
		$("#dateFrom").datepicker({
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
					$(this).focus();
					 $('#patient-filter').val('');
					 $( "#patient_id" ).val('');
					$( "#seen-filter" ).trigger( "change" );
				}
		});
		$("#dateTo").datepicker({
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				 $('#patient-filter').val('');
				 $( "#patient_id" ).val('');
				$( "#seen-filter" ).trigger( "change" );
			}
	});
		 $("#patient-filter").keypress(function (){
			 $( "#patient_id" ).val('');
				});
		/* $("#patient-filter").autocomplete("<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "testcomplete","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'patient-filter,patient_id',
			onItemSelect:function () {
				if($( "#patient_id" ).val() != '');
				$( "#patient_id" ).trigger( "change" );
			}
		});*/

		$("#patient-filter").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "testcomplete",'LAB',"admin" => false,"plugin"=>false)); ?>",
			select: function(event,ui){	
				$( "#patient_id" ).val(ui.item.id);
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
	/*	$(document).ready(function(){
			 
			$("#patient-filter").autocomplete("<?php //echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null',0,'null','is_discharge=0&admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
		});*/

		 $(".active-menu-tabs").click(function(){  
		    	var tabClicked = $(this).attr("name");
		    	$(".child-tabs").hide();
		    	$("#"+tabClicked).fadeIn('slow');
		    	$(".active-menu-tabs").removeClass('active');
		    	$(this).addClass('active');
				

		        return false ;
			});

		// For Right Click on Document Signed
		/*var global_items = {
			"flag": {name: "Flag", icon: "flag"},
			"Unflag": {name: "Unflag", icon: "flag"},
			"flagComment": {name: "Flag With Comment", icon: "flag"},
		    "edit": {
		        name: "Modify",
		        icon: "edit"
		    },
		    "result": {
		        name: "View Result Details",
		        icon: "view"
		    }, 
		    "delete": {
		        name: "UnChart",
		        icon: "delete"
		    },
		    "sep1": "---------",
		    "quit": {
		        name: "Quit",
		        icon: "quit"
		    }};*/
		 $.contextMenu({
		        selector: '.context-menu-one', 
		        callback: function(key, options) {
		            if(key=='rx'){
		            	currentId = $(this).attr('id') ;
		            	openRx(currentId);	
			        }
		            if(key=='hpi'){
		            	currentId = $(this).attr('id') ;
		            	openHpi(currentId);	
			        }
		        },
		        build: function($trigger, e) {		        	
		            // this callback is executed every time the menu is to be shown
		            // its results are destroyed every time the menu is hidden
		            // e is the original contextmenu event, containing e.pageX and e.pageY (amongst other data)
		            
		            return {	                
		                items: {
		                	"rx": {name: "Rx", icon: "flag"},
		                	//"hpi": {name: "HPI", icon: "flag"},
		                	} // assign revised options to contextmenu
		            };
		        }
		         
		    });


		 $.contextMenu({
		        selector: '.context-menu-two', 
		        callback: function(key, options) {
		            if(key=='no'){
		            	currentId = $(this).attr('id') ;
		            	
		            	splitAttrId=currentId.split("_"); // For changing action icon
		            	 if(splitAttrId[3]!='Arrived' && splitAttrId[3]!='Scheduled' && splitAttrId[3]!='Pending' && splitAttrId[3]!='1' && splitAttrId[3]!='Confirmed with Patient'){
		            	$("#blink_"+splitAttrId[1]).removeClass("yellowBulb");
		  			    $("#blink_"+splitAttrId[1]).addClass("greyBulb");
		            	 }
		            	$("#"+currentId).attr('src','../theme/Black/img/icons/grey.png').attr('title','No Follow up needed').removeClass('context-menu-two');
						$("#"+currentId).parent().attr( "href", "#" );
						hasFollowUp(splitAttrId[1],splitAttrId[2]);
				       }
		        },
		        build: function($trigger, e) {		        	
		            // this callback is executed every time the menu is to be shown
		            // its results are destroyed every time the menu is hidden
		            // e is the original contextmenu event, containing e.pageX and e.pageY (amongst other data)
		            
		            return {	                
		                items: {
		                	"no": {name: "No Follow Up Needed "},} // assign revised options to contextmenu
		            };
		        }
		         
		    });
	});

function hasFollowUp(apptId,patId){
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "updateFollowUp", "admin" => false)); ?>",
		  context: document.body,
		  data:'id='+apptId+'&patient_id='+patId,
		  success: function(data){ 
			  onCompleteRequest();
		 }
		  
	});
		}

	function openRx(patient_id){
		window.location.href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "rx")); ?>"+'/'+patient_id;
		
			}
		
	function openHpi(patient_id){
		
		$.fancybox({
		'width' : '70%',
		'height' : '100%',
		'autoScale': true,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'iframe',
		'href': "<?php echo $this->Html->url(array("controller" => "PatientForms", "action" => "hpiCall")); ?>"+'/'+patient_id,
		'onLoad': function () {window.location.reload();}
		});
		return false ;
		}

	function insertMedicationInfo(patient_id)
	{
		
	     $.ajax({
	     type : "POST",
	     url: "<?php echo $this->Html->url(array("controller" => "PatientsTrackReports", "action" => "insertMedicationInfo")); ?>"+'/'+patient_id,
	     context: document.body,
	     beforeSend:function(){
	     loading();
	      },
	      success: function(data){
		 onCompleteRequest();
	
	}

});

}

///Function for tab
	$(document).on('click',".doctor_tab",function(){
		currentId = $(this).attr('id') ;
		var obj = $(this) ;
		$("#doctor_id").val(currentId);
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "lab_patient_dashboard", "admin" => false)); ?>",
			  context: document.body,
			  data:$("form").serialize(),
			  beforeSend:function(){
				  loading();
			  }, 	  		  
			  success: function(data){ 
				  onCompleteRequest();
				  $('#content-list').html(data).fadeIn('slow');
				  $(".doctor_tab").removeClass("active");
				  obj.addClass("active");
				 // obj.attr('src','../theme/Black/img/icons/green.png').attr('title','Medication Administered').removeClass('med');
			  }
			  
		});
	});	
	//Context Menu for My Physician Checkboxes--- Pooja
	$(function(){
		$.contextMenu({
	        selector: '.context-menu-three', 
	        callback: function(key, options) {
	        	if(key=='submit'){
			        var checked = $( "input[type='checkbox']" ).serialize().split("&");
			       
			        var docID = '';
			        //var docID = checked.join();
			        length = checked.length;
			        $.each(checked, function( index, value ) {
				       value=value.split("=");
				        if(index===(length-1)){
				            docID +=value[1];
				        }else{					        
				        	docID += value[1]+'_';
					        }
				        
			      	});	
			        
			      	if(docID=== "undefined"){
			      		docID='';
			      	}
				      	
			      $.ajax({
		  			  type : "GET",
		  			  url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "lab_patient_dashboard", "admin" => false)); ?>",
		  			  context: document.body,
		  			  data:"doctorsId="+docID,
		  			  beforeSend:function(){
		  				$('#patient-filter').val('');
						$('#patient_id').val('');
						$('#dateFrom').val('');
						$('#dateTo').val('');						
		  				  loading();
		  			  }, 	  		  
		  			  success: function(data){ 
		  				$('#todays-filter').removeClass('active');
						$('#future-filter').removeClass('active');
						$('#myPatient-filter').removeClass('active');
						$('#viewAll-filter').removeClass('active');
						$('#physician_tab').addClass('active');
						$('#closed-filter').removeClass('active');
						$('#list_tab').hide();
		  				  onCompleteRequest();
		  				  $('#content-list').html(data).fadeIn('slow');
		  			  }
		  			  
		  		});
		        	 return true;
			        
		        }
	      },
	       items: {
	    	   "select_all":{name:"Select All", type:"checkbox",icon: "select", value:"0"},
	    	   "sep2":"<br>",   
	          <?php foreach($doctors as $key=>$doctor){?>
		       <?php echo $key;?> : {name: "<?php echo $doctor ;?>",
			       					type: 'checkbox',
			       					icon: "<?php echo $key?>",
				       				value:"<?php echo $key?>"},
	            <?php  }?>
	            "sep":"----------",
	            "submit":{name:"<b>Submit</b>"},
	       },
	        events: {
	            show: function(opt) {
	                // this is the trigger element
	                var $this = this;
	                // import states from data store 
	                $.contextMenu.setInputValues(opt, $this.data());
	               // this basically fills the input commands from an object
	                // like {name: "foo", yesno: true, radio: "3", …}
	            	// console.log(opt.$menu);
	                /*opt.$menu.find('.context-menu-item').attr('title', function() { 
		                console.log(this);
		                return $(this).text(); 
	                  });*/
	                 
	                <?php foreach($doctors as $key=>$doctor){?>
	 		       			var id= <?php echo $key?>; 
	 		       		 $('.icon-'+id).find('span').attr('id','doctorMenu_'+id);
	 		       			//selectedDoctors.pop(id);
	 		       			//$('#doctorMenu_'+id).css('color','black');
	 	            <?php  }?>
	 	           $('.icon-select').find('span').attr('id','checkAll');
	 	          $('.icon-select').find('span').css('color','red'); 
	 	        }, 
	            hide: function(opt) {
	                // this is the trigger element
	                var $this = this;
	                // export states to data store
	                 $.contextMenu.getInputValues(opt, $this.data());
	                 
	              	// window.console && console.log(opt, $this.data());
	                // this basically dumps the input commands' values to an object
	                // like {name: "foo", yesno: true, radio: "3", …}
	            }
	        }
	    });
		$('.context-menu-three').on('click', function(e){
	        console.log('clicked', this);
	    });
	});

	$(document).on( 'click','.icon-select',function(){  
		
		  isChecked = $('.icon-select label input').prop('checked') ; ///check if select all is clicked or not
		  $('.context-menu-item label input').each(function (val,obj) { 
			  if(isChecked)		   
		       	  $(obj).prop('checked',true);
			  else
				  $(obj).prop('checked',false); 
		  }); 
	});
	</script>
	

	
	<script>
	//appointment_dashboard
	
$( document ).ready(function () {
	$('.tooltip').tooltipster({
 		interactive:true,
 		position:"right", 
 	});
 	});
$(document).on('change',".nurse",function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");		 
	ptId = splittedVar[1];//patient Id
	opt=splittedVar[0];//option
	aptId=splittedVar[2];//appointment Id
	person=$(this).attr('person_id');//person Id
	value = $(this).val();
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "lab_patient_dashboard", "admin" => false)); ?>"+"/"+null+"/"+ptId+"/"+opt+"/"+aptId,
		  context: document.body,	
		  data : "value="+value,
		  beforeSend:function(){
			  loading();
		  }, 	  		  
		  success: function(data){					  
			 //$('#busy-indicator').hide('fast');
			 // inlineMsg(currentId,'Updated');
			  ids = currentId.split("_");
			  $('.'+ids[1]).toggle();
			  $('.td_'+ids[1]).html(value);
			  /********** For temporary change in status for view-- Pooja ************/
			 id=$('#'+person+'_'+aptId+' option:selected');
			  var status_val= id.text();
			  //alert(status_val);
			  if(status_val!='Seen'&& status_val!='Closed'){
				  if(status_val=='In-Progress'){
					  $('#'+person+'_'+aptId).val('In-Progress');
				  }else{
			  $('#'+person+'_'+aptId).val('Assigned');
			  $('#'+person+'_'+aptId).attr('disabled',true);
				  }
			  $('#'+person+'_'+aptId).removeClass('blue');
			  $('#'+person+'_'+aptId).removeClass('orange');
			  $('#'+person+'_'+aptId).addClass('darkBlue');
			  $("#blink_"+aptId).removeClass('yellowBulb');//action column changes images on status change
			  $("#blink_"+aptId).addClass('greyBulb');
			  }
			  /**********end*********************************************************/
			//Condition for not to refresh on search 
				if($('#is_search').val()!='1' ){
			  $('#content-list').html(data);
				}
			  onCompleteRequest();
		  }
	});		 
});

$(document).on('change',".room",function(){
	 
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");	// eg: room_2 where 2 is the appointment id
	aptId = splittedVar[1];//appt Id
	opt=splittedVar[0];//option
	var value = $(this).val();
	person=$(this).attr('person_id');//person Id
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "lab_patient_dashboard", "admin" => false)); ?>"+"/"+null+"/"+aptId+"/"+opt,
		  context: document.body,	
		  data : "value="+value,
		  beforeSend:function(){
			  loading();
		  }, 	  		  
		  success: function(data){					  
			  //$('#busy-indicator').hide('fast');
			 // inlineMsg(currentId,'Updated');
			  ids = currentId.split("_");
			  $('.'+ids[1]).toggle();
			  $('.td_'+ids[1]).html(value);
			  /********** For temporary change in status for view-- Pooja ************/
			  id=$('#'+person+'_'+aptId+' option:selected');
			  var status_val= id.text();
			  if(status_val!='Seen'&& status_val!='Closed'){
				  if(status_val=='In-Progress'){
					  $('#'+person+'_'+aptId).val('In-Progress');
				  }else{
			  $('#'+person+'_'+aptId).val('Assigned');
			  $('#'+person+'_'+aptId).attr('disabled',true);
				  }
			  $('#'+person+'_'+aptId).removeClass('blue');
			  $('#'+person+'_'+aptId).removeClass('orange');
			  $('#'+person+'_'+aptId).addClass('darkBlue');
			  $("#blink_"+aptId).removeClass('yellowBulb');//action column changes images on status change
			  $("#blink_"+aptId).addClass('greyBulb');
			  }
			  /**********end*********************************************************/
			//Condition for not to refresh on search 
			if($('#is_search').val()!='1'){
			  $('#content-list').html(data);
				}
			  onCompleteRequest();
		  }
	});		 
});

$(document).on('click',".med",function(){
	var currentId = $(this).attr('id') ;
	var splittedVar = currentId.split("_");	
	var ptId=splittedVar[1];
	var apptId=splittedVar[2];
	var ptUniqueId=splittedVar[3];
	window.location.href="<?php echo $this->Html->url(array("controller" => "Patients", "action" => "rxhistory")) ?>"+"/"+ptId+"/"+ptUniqueId+"/"+apptId;
	
	/*$.fancybox({
		'width' : '80%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php //echo $this->Html->url(array("controller" => "Patients", "action" => "rxhistory")) ?>"+"/"+ptId+"/"+ptUniqueId,
	});	*/
});
var ajaxcreateCredentialsUrl ="<?php echo $this->Html->url(array("controller" => "messages", "action" => "createCredentials","admin" => false)); ?>"; ;//
function createPatientCredentials(personid,patientid){

	$.fancybox({
		'width' : '50%',
		'height' : '50%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "messages", "action" => "openFancyBox")) ?>"+"/"+personid+"/"+patientid+"?"+'clickedId='+personid,
	});
	
}
$(document).on('click','.initial',function(){
	 
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");	
	apptId=splittedVar[1];
	ptId=splittedVar[2];
	var status='In-Progress';
	var arrived_time=$("#arrived_time_"+apptId).html();
	//var atym=arrived_time.split(':');
	//var atym1=atym['0']+'p'+atym['1'];
	arrived_time.trim();
	var field='status';
	var obj = $(this) ;
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "update_appointment_status", "admin" => false)); ?>"+"/"+status+"/"+field,
		  context: document.body,
		  data:"id="+apptId,	
		  beforeSend:function(){
			  loading();
		  }, 	  		  
		  success: function(data){
			  <?php if($role==Configure::read('nurseLable')){?>  
			  $("#"+apptId).removeClass("yellowBulb");
			  $("#"+apptId).addClass("greyBulb");
			  <?php } ?>
			  var url = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "initialAssessment", "admin" => false)); ?>"+"/"+ptId+"/"+'null'+"/"+apptId+"/?type="+arrived_time;
			  window.location.href = url;
			  onCompleteRequest();
			  
		  }
	});
});

$(document).on('click','.positiveId',function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "positiveIdDone", "admin" => false)); ?>",
		  context: document.body,	
		  data : "id="+splittedVar[1],//appt id
		  beforeSend:function(){
			  loading();
		  }, 	  		  
		  success: function(data){					  
			  $("#"+currentId).attr('src','../theme/Black/img/icons/green.png').attr('title','Positive Id Confirmed').removeClass('positiveId');
			  onCompleteRequest();
		  }
	});	
});



$(document).on('change',".doctor",function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");	
	aptId = splittedVar[1];//appt Id
	preDoctor=splittedVar[2];//Previous Doctor Id
	patId = splittedVar[3];//patient id
	var value = $(this).val();	
	 $
	.fancybox({

		'width' : '50%',
		'height' : '50%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "changeProvider")); ?>"+"/"+aptId+"/"+preDoctor+"/"+value+"/"+patId,		
		 	
	});	 
});
//if clicked on document Signed button doctor's dropdown should be disabled
$(document).on('change',".doc_clicked",function(){
	currentId = $(this).attr('id') ;
	$("#"+currentId).attr('disabled',true);

});
$('.labRadOverDue').click(function(){
	var currentId = $(this).attr('id') ;
	var splittedVar = currentId.split("_");	
	var source = splittedVar[0];
	var patientId = splittedVar[1];
	$.fancybox({
		'width' : '80%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "overdueLabRadTest")); ?>"+"/"+patientId+"/"+source,		
		 	
	});
});

$(function(){
		setInterval(function(){	 
			$(".elapsed").each(function() {
			  currentID= this.id ; //elapsed container id
			  splittedId=currentID.split("-");
			  currentValue = $(this).html(); 
			  status=$('#'+splittedId[1]).val();
			 if(status!='Scheduled' && status!='Seen'&& status!='Closed' && status!='' && status!='Pending' && status!='Confirmed with Patient'){
			  if(currentValue.trim() ==  ''){
				  $(this).html("1 Min");
			  }else{
				  splittedVal= currentValue.split(" ") ; //split number and "minutes" text
				  currentMin =  parseInt(splittedVal[0],10)+1 ;
				  if(currentMin<15){
				  $(this).html(currentMin+" Min");
				  }
				  else if(currentMin>15 && currentMin<=30){
					  $("#"+currentID).removeClass("elapsedGreen");
					  $("#"+currentID).addClass("elapsedYellow");
					  $(this).html(currentMin+" Min");
				  }
				  else if(currentMin>30){
					  $("#"+currentID).removeClass("elapsedYellow");
					  $("#"+currentID).addClass("elapsedRed");
					  $(this).html(currentMin+" Min");
				  }
			  } 
			  }
			else if(status=='Seen' || status=='Closed'){
				$("#"+currentID).removeClass("elapsed");
			}
			})	;				
		},60000);
		
	
});

$(document).on('click','.encounter',function(){
	currentId=this.id;
	splitID=currentId.split("_");
	$.ajax({
		type : "POST",
		url: "<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "update_encounter","admin" => false)); ?>",
		data:'id='+splitID[1],
		context: document.body,	   
		beforeSend:function(){
	    // this is where we append a loading image
	   //loading();	
	  	}, 	  		  
	  	success: function(data){
		  $("#"+currentId).attr('src','../theme/Black/img/icons/green.png').attr('title','Encounter Closed').removeClass('encounter');
		   load_list();
		  onCompleteRequest();		  
	  }
});
	
});

/* $(document).on('click','.manage_alert', function(){
	var currentId = $(this).attr('id') ;
	var splittedVar = currentId.split("_");	
	var source = splittedVar[0];
	var patientId = splittedVar[1];	
		 $.fancybox({
				'width' : '80%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Messages", "action" => "compose")); ?>"+"/"+patientId+"/null/"+source,		
				 	
			});
		  	  
	  
});*/ 

$('.typeSelected').click(function(){
	if($(this).val()=='OPD'){
		url="<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "appointments_management","admin" => false)); ?>";
	}else if($(this).val()=='Rad'){
		url="<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "rad_management","admin" => false)); ?>";
	}

	window.location=url;
});


	
	</script>
	
