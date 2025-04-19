<div class="inner_title">
	<h3>Master</h3>
</div> 
<ul class="interIcons">
<!-- Bof icons added by vikas -->
<!-- <li> <?php echo $this->Html->link($this->Html->image('/img/icons/accounting_class_icon.png', array('alt' => 'Accounting Class','title'=>'Accounting Class')),array("controller" => "accounting", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Accounting Class')); ?></li> -->
<!-- 
<li><?php //echo $this->Html->link($this->Html->image('/img/icons/concepts.png', array('alt' => 'Concept','title'=>'Concept')),array("" => "", "action" => "", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Concept')); ?></li>
 -->
<li><?php echo $this->Html->link($this->Html->image('/img/icons/cost center.png', array('alt' => 'Cost Center','title'=>'Cost Center')),array("controller" => "costcenter", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Cost Center')); ?></li>

<li><?php echo $this->Html->link($this->Html->image('/img/icons/images.png', array('alt' => 'Images','title'=>'Images')),array("controller" => "image", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Images')); ?></li>
<li><?php echo $this->Html->link($this->Html->image('/img/icons/user.png', array('alt' => 'HR','title'=>'HR Masters')),array("controller" => "HR", "action" => "index","admin" => false,'plugin' => false), array('escape' => false,'label'=>'HR Masters')); ?></li>

<li><?php echo $this->Html->link($this->Html->image('/img/icons/manufacturer icon.png', array('alt' => 'Accounting Class','title'=>'Accounting Class')),array("controller" => "Manufacturers", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Manufacturer')); ?></li>
<li><?php echo $this->Html->link($this->Html->image('/img/icons/markup.png', array('alt' => 'Markup','title'=>'markup')),array("controller" => "markup", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Markup')); ?></li>
<li><?php echo $this->Html->link($this->Html->image('/img/icons/packges.png', array('alt' => 'Packages','title'=>'Packages')),array("controller" => "Packages", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Packages')); ?></li>

<li><?php echo $this->Html->link($this->Html->image('/img/icons/product_type.png', array('alt' => 'Product','title'=>'Product')),array("controller" => "Products", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Product Type')); ?></li>

<li><?php echo $this->Html->link($this->Html->image('/img/icons/tax rules.png', array('alt' => 'Tax Rule','title'=>'Tax Rules')),array("controller" => "Taxrules", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Tax Rule')); ?></li>
<li><?php echo $this->Html->link($this->Html->image('/img/icons/company.png', array('alt' => 'Company','title'=>'Company')),array("controller" => "Hospitals", "action" => "admin_company_list", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Company')); ?></li>
<!-- EOF Icons added by vikas -->
<li> 	 <?php echo $this->Html->link($this->Html->image('icons/geographical_region.png', array('alt' => __('Geographical Region'), 'title' => __('Geographical Region'))),array("controller" => "countries", "action" => "geographicmap", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Geographical Region')); ?></li>

<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/location.jpg', array('alt' => 'Facility','title'=>'Facility')),array("controller" => "locations", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Facility')); ?></li>
				
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/user.png', array('alt' => 'Users','title'=>'Users')),array("controller" => "users", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Users')); ?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/guarantor.png', array('alt' => 'Guarantor','title'=>'Guarantor')),array("controller" => "users", "action" => "indexGuarantor", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Guarantors')); ?></li>	
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/guarantor.png', array('alt' => 'Marketing Team','title'=>'Marketing Team')),array("controller" => "users", "action" => "marketing_team", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Marketing team')); ?></li>							
<li><?php echo $this->Html->link($this->Html->image('/img/icons/department.jpg', array('alt' => 'Specialty','title'=>'Specialty')),array("controller" => "departments", "action" => "index", "admin" => true, 'plugin' => false), array('escape' => false,'label'=>'Specialties')); ?></li>
<li>  <?php echo $this->Html->link($this->Html->image('/img/icons/user.png', array('alt' => 'Users','title'=>'Users')),array("controller" => "users", "action" => "index",'?'=>array('newUser'=>'ls'), "admin" => true,'plugin' => false), array('escape' => false,'label'=>'New Users')); ?></li>
 	<li><?php echo $this->Html->link($this->Html->image('/img/icons/taxation.png', array('alt' => ('Payment System '),'title' => __('Payment System Master'))),array("controller"=>"Costcenter","action"=>'earningDeductionMaster',"admin" => false,'plugin' => false), array('escape' => false,'label'=>'Payment System Master')); ?></li>

<li>    <?php echo $this->Html->link($this->Html->image('/img/icons/roles1.png', array('alt' => 'Roles','title'=>'Roles')),array("controller" => "roles", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false,'label'=>'Roles')); ?></li>

<li>  <?php echo $this->Html->link($this->Html->image('icons/designation.jpg', array('alt' => __('Designation'), 'title' => __('Designation'))),array("controller" => "designations", "action" => "index", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Designation')); ?></li>

<li>  <?php echo $this->Html->link($this->Html->image('icons/doctor-inner.jpg', array('alt' => __('In-House Doctor Enquiry'), 'title' => __('In-House Doctor Enquiry'))),array("controller" => "doctors", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'In-House Doctor Enquiry')); ?></li>

<li> <?php echo $this->Html->link($this->Html->image('icons/inhouse-external-doctor.jpg', array('alt' => 'External Consultant', 'title'=> 'External Consultant')),array("controller" => "consultants", "action" => "inhouse_externaldoctor", "admin" => true, "superadmin" => false,'plugin' => false), array('escape' => false,'label'=>'External Consultant')); ?></li>

<li> <?php echo $this->Html->link($this->Html->image('icons/referral_doctor.png', array('alt' => 'Referral Doctor', 'title'=> 'Referral Doctor')),array("controller" => "consultants", "action" => "index", "admin" => true, "superadmin" => false,'plugin' => false), array('escape' => false,'label'=>'Referral Doctor')); ?></li>

<li> <?php echo $this->Html->link($this->Html->image('icons/doctor-templates.jpg', array('alt' => __('Initial Assessment Template'), 'title' => __('Initial Assessment Template'))),array("controller" => "doctor_templates", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Initial Assessment Template')); ?></li>

<li> <?php echo $this->Html->link($this->Html->image('icons/notes-template.jpg', array('alt' => __('Notes Template'), 'title' => __('Notes Template'))),array("controller" => "notes", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Notes Template')); ?></li>

<li><?php echo $this->Html->link($this->Html->image('icons/radiology-template.jpg', array('alt' => __('Radiology Template'), 'title' => __('Radiology Template'))),array("controller" => "radiologies", "action" => "template", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Radiology Template')); ?></li>

<li><?php echo $this->Html->link($this->Html->image('icons/smart_phrases.png', array('alt' => __('Smart Phrases'), 'title' => __('Smart Phrases'))),array("controller" => "SmartPhrases", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Smart Phrases')); ?></li>

<li>  <?php echo $this->Html->link($this->Html->image('icons/Laboratory1.png', array('alt' => __('Laboratory'), 'title' => __('Laboratory'))),array("controller" => "laboratories", "action" => "index", "inventory" => false,"admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Laboratory')); ?></li>

<li>  <?php echo $this->Html->link($this->Html->image('icons/services.jpg', array('alt' => __('Configurations'), 'title' => __('Configurations'))),array("controller" => "Configurations", "action" => "index", "inventory" => false,"admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Configurations')); ?></li>

<li>   <?php echo $this->Html->link($this->Html->image('icons/radiology.jpg', array('alt' => __('Radiology'), 'title' => __('Radiology'))),array("controller" => "radiologies", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Radiology ')); ?></li>

<li> <?php echo $this->Html->link($this->Html->image('icons/ot-table.jpg', array('alt' => __('OR'), 'title' => __('OR'))),array("controller" => "opts", "action" => "listAllOt", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'OR')); ?></li> 

<li> 	 <?php //echo $this->Html->link($this->Html->image('icons/complaints.jpg', array('alt' => __('Complaints'), 'title' => __('Complaints'))),array("controller" => "complaints", "action" => "index", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Complaints')); ?></li>

<li> 	 <?php echo $this->Html->link($this->Html->image('icons/incident-form.png', array('alt' => __('Incident Type'), 'title' => __('Incident Type'))),array("controller" => "incidents", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Incident Type')); ?></li>

<li>  <?php echo $this->Html->link($this->Html->image('icons/payment.jpg', array('alt' => __('Corporate & Insurance Management'), 'title' => __('Corporate & Insurance Management'))),array("controller" => "corporate_locations", "action" => "common", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Corporate & Insurance Management')); ?></li>

<li> 	 <?php echo $this->Html->link($this->Html->image('icons/services-tariff.jpg', array('alt' => __('Services & Payer'), 'title' => __('Services & Payer'))),array("controller" => "tariffs", "action" => "index", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Services & Payer')); ?></li>

<li> 	 <?php echo $this->Html->link($this->Html->image('icons/advance-payment.jpg', array('alt' => __('Advance Amount'), 'title' => __('Advance Amount'))),array("controller" => "advance_type", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Advance Amount')); ?></li>
<li> 	 <?php echo $this->Html->link($this->Html->image('icons/chamber_master.jpg', array('alt' => __('Exam Room'), 'title' => __('Exam Room'))),array("controller" => "chambers", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Exam Room')); ?></li>


<!--          			
<li> <?php //echo $this->Html->link($this->Html->image('/img/icons/services.jpg', array('alt' => 'Services','title'=>'Services')),array("controller" => "services", "action" => "index","admin"=>true, "superadmin" => false, 'plugin' => false), array('escape' => false)); ?>
<p style="margin:0px; padding:0px;"><?php //echo __('Services',true); ?></li>-->

<!-- 			
<li> 	 <?php echo $this->Html->link($this->Html->image('icons/nursing-tariff.jpg', array('alt' => __('Advance Type'), 'title' => __('Advance Type'))),array("controller" => "tariffs", "action" => "viewNursing", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Nursing Tariff')); ?></li>
 -->
 <li> 	 <?php echo $this->Html->link($this->Html->image('icons/service_providers.png', array('alt' => __('Service Provider'), 'title' => __('Service Provider'))),array("controller" => "service_providers", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Service Provider')); ?></li>
 
  <li> 	 <?php echo $this->Html->link($this->Html->image('icons/patient-centric-department.jpg', array('alt' => __('Patient Centric Department'), 'title' => __('Patient Centric Department'))),array("controller" => "patient_centric_departments", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Patient Centric Department')); ?></li>
  <li> 	 <?php echo $this->Html->link($this->Html->image('icons/item-category.jpg', array('alt' => __('Item Categories'), 'title' => __('Item Categories'))),array("controller" => "ot_items", "action" => "ot_item_category", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Item Categories')); ?></li>
  
  <li> 	 <?php echo $this->Html->link($this->Html->image('icons/medical_item1.png', array('alt' => __('Medical Item'), 'title' => __('Medical Item'))),array("controller" => "opts", "action" => "medical_item_list", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Medical Item')); ?></li> 
  <li> 	 <?php echo $this->Html->link($this->Html->image('icons/billing.jpg', array('alt' => __('Currency'), 'title' => __('Currency'))),array("controller" => "currency", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Currency')); ?></li>
   <li> <?php echo $this->Html->link($this->Html->image('icons/instrument.png', array('alt' => __('Instrument'), 'title' => __('Instrument'))),array("controller" => "instruments", "action" => "index", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Instrument')); ?> 
   
   <li> 	 <?php echo $this->Html->link($this->Html->image('icons/billing.jpg', array('alt' => __('Generate HL7'), 'title' => __('Generate HL7'))),array("controller" => "hl7_messages", "action" => "index", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Generate HL7')); ?></li>
   <li> 	 <?php echo $this->Html->link($this->Html->image('icons/faxreferral.png', array('alt' => __('Fax Referral'), 'title' => __('Fax referral'))),array("controller" => "recipients", "action" => "index", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Fax Referral')); ?></li>
<li> 	 <?php echo $this->Html->link($this->Html->image('icons/item-category.jpg', array('alt' => __('Template Categories'), 'title' => __('Template Categories'))),array("controller" => "ot_items", "action" => "index", "admin" => true,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Template Categories')); ?></li>
  
  <li> 	 <?php echo $this->Html->link($this->Html->image('icons/medical_item1.png', array('alt' => __('Template Categories'), 'title' => __('Template Categories'))),array("controller" => "ot_items", "action" => "temp_category", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Template Categories')); ?></li>
 <li> 	 <?php echo $this->Html->link($this->Html->image('icons/medical_item1.png', array('alt' => __('Template SubCategories'), 'title' => __('Template SubCategories'))),array("controller" => "ot_items", "action" => "temp_subcategory", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Template SubCategories')); ?></li>
 <!-- <li> 	 <?php echo $this->Html->link($this->Html->image('icons/icd.png', array('alt' => __('ICD'), 'title' => __('ICD'))),array("controller" => "diagnoses", "action" => "search_icd", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'ICD')); ?></li> -->
 
  <li> <?php echo $this->Html->link($this->Html->image('icons/template_category.png', array('alt' => __('Systems'), 'title' => __('Review Of System'))),array("controller" => "templates", "action" => "template_sub_category",'?'=>array('template_category_id'=>1), "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Review Of System')); ?></li>
  <li> <?php echo $this->Html->link($this->Html->image('icons/template_category.png', array('alt' => __('Systems'), 'title' => __('Physical Examination'))),array("controller" => "templates", "action" => "template_sub_category",'?'=>array('template_category_id'=>2), "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Physical Examination')); ?></li>
  <li> <?php echo $this->Html->link($this->Html->image('icons/template_category.png', array('alt' => __('Systems'), 'title' => __('HPI'))),array("controller" => "templates", "action" => "template_sub_category",'?'=>array('template_category_id'=>3), "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'HPI')); ?></li>
   <li> <?php echo $this->Html->link($this->Html->image('icons/Laboratory1.png', array('alt' => __('Laboratory'), 'title' => __('Multiple Lab Orders'))),array("controller" => "MultipleOrderSets", "action" => "labAddMaster", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Multiple Lab Orders')); ?></li>
 
  <li> <?php // echo $this->Html->link($this->Html->image('icons/template_sub_category.png', array('alt' => __('Sign & Symptoms'), 'title' => __('Sign & Symptoms'))),array("controller" => "templates", "action" => "template_sub_category", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Sign & Symptoms')); ?></li>
  
  
  <li> <?php  echo $this->Html->link($this->Html->image('icons/template_sub_category.png', array('alt' => __('Store Locations'), 'title' => __('Store Locations'))),array("controller" => "Locations", "action" => "storeLocation", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Store Locations')); ?></li>
  <li> <?php  echo $this->Html->link($this->Html->image('icons/template_sub_category.png', array('alt' => __('Location Type'), 'title' => __('Location Type'))),array("controller" => "Locations", "action" => "locationType", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Location Type')); ?></li>

 <li><?php echo $this->Html->link($this->Html->image('icons/services-tariff.jpg', array('alt' => __('Package'), 'title' => __('Package'))),array("controller" => "Estimates", "action" => "packageMaster", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false,'label'=>'Package')); ?></li> 
<?php if(Configure::read('Coupon')){?>
	<li><?php echo $this->Html->link($this->Html->image('/img/icons/recipts.png', array('alt' => ('Coupon Master'),'title' => __('Coupon Master'))),array("controller"=>"Estimates","action"=>'couponBatchGeneration',"admin" => false,'plugin' => false), array('escape' => false,'label'=>'Coupon Master')); ?></li>
	<?php } ?>
  <li>  <?php echo $this->Html->link($this->Html->image('/img/icons/supplier-list.gif', array('alt' => 'Supplier List','title' => __('Supplier List'))),array("controller"=>"Pharmacy","action" => "supplier_list", "inventory" => true,"admin" => false,'plugin' => false,'superadmin'=> false),  array('escape' => false,'label'=>'Supplier List')); ?></li>
  
  <li>  <?php echo $this->Html->link($this->Html->image('/img/icons/taxation.png', array('alt' => 'Vat Classes','title' => __('Vat Classes'))),array("controller"=>"Pharmacy","action" => "vat", "inventory" => false,"admin" => false,'plugin' => false,'superadmin'=> false),  array('escape' => false,'label'=>'Vat Classes')); ?></li>

 
 
 <!-- -----------------------------BOF-----M M I S------------------------------------------------------------- -->
 
 
 
 <li>
		<?php echo $this->Html->link($this->Html->image('icons/Account.png', array('alt' => ('Account'),'title' => __('Account'))),array("controller"=>"Accounting","admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php echo __('Account',true); ?></p>
	</li>
	<li>
		<?php echo $this->Html->link($this->Html->image('icons/Account.png', array('alt' => ('Order Set'),'title' => __('Order Set'))),array("controller"=>"MultipleOrderSets","action"=>'index',"admin" => true,'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php echo __('Order Set',true); ?></p>
	</li>
	<li>
		<?php echo $this->Html->link($this->Html->image('icons/billings.jpg', array('alt' => ('Commission Master'),'title' => __('Commission Master'))),array("controller"=>"Accounting","action"=>'external_charges',"admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php echo __('Commission Master',true); ?></p>
	</li>
	<li>
		<?php echo $this->Html->link($this->Html->image('icons/Diagnosis_master.png', array('alt' => ('Leave Master'),'title' => __('Leave Master'))),array("controller"=>"HR","action"=>'leave_master',"admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php echo __('Leave Master',true); ?></p>
	</li>
	
	<li>
		<?php echo $this->Html->link($this->Html->image('icons/billings.jpg', array('alt' => ('External Requisition Commission'),'title' => __('External Requisition Commission'))),array("controller"=>"Accounting","action"=>'ExternalRequisition',"admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php echo __('External Requisition Commission',true); ?></p>
	</li>
	<li>
		<?php echo $this->Html->link($this->Html->image('icons/SMS_config.png', array('alt' => ('Group SMS'),'title' => __('Group SMS'))),array("controller"=>"Messages","action"=>'groupIndex',"admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php echo __('SMS Group',true); ?></p>
	</li>

	<li>
		<?php echo $this->Html->link($this->Html->image('icons/surgicalimpalnt.png', array('alt' => ('Surgical Implant'),'title' => __('Surgical Implant'))),array("controller"=>"NewOptAppointments","action"=>'implantIndex',"admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php echo __('Surgical Implant',true); ?></p>
	</li>
	<!--add by dinesh tawade-->
	 <li>
		<?php echo $this->Html->link($this->Html->image('icons/office_building.png', array('alt' => ('Telecaller Staff Update'),'title' => __('Telecaller Staff Update'))),array("controller"=>"NewOptAppointments","action"=>'manage_records',"admin" => false,'plugin' => false), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php echo __('Telecaller Staff Update',true); ?></p>
	</li>

	<li><?php //echo $this->Html->link($this->Html->image('icons/assets.png', array('alt' => ('Assets'), 'title' => __('Assets'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
		<p style="margin:0px; padding:0px;"><?php //echo __('Assets',true); ?></p>
	</li>
	<li><?php //echo $this->Html->link($this->Html->image('icons/products.png', array('alt' => __('Products'), 'title' => __('Products'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Products',true); ?>		
    </li>
    <li><?php //echo $this->Html->link($this->Html->image('icons/clients.png', array('alt' => __('Client'), 'title' => __('Client'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php // echo __('Client',true); ?>		
    </li>
  <!--  <li><?php echo $this->Html->link($this->Html->image('/img/icons/location.jpg', array('alt' => __('Facility'), 'title' => __('Facility'))),array("action" => "", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php echo __('Facility',true); ?>		
    </li>-->
    <!--<li><?php echo $this->Html->link($this->Html->image('/img/icons/purchasing_contract.png', array('alt' => __('Facility'), 'title' => __('Facility'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php echo __('Purchase',true); ?>		
    </li>-->
    
     <!--<li><?php //echo $this->Html->link($this->Html->image('icons/procedure.png', array('alt' => __('Procedure'), 'title' => __('Procedure'))),array("action" => "", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php echo __('Procedure',true); ?>		
    </li>-->
     <li><?php //echo $this->Html->link($this->Html->image('icons/administration_session.png', array('alt' => __('Administration'), 'title' => __('Administration'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Administration',true); ?>		
    </li>
     <!--<li><?php echo $this->Html->link($this->Html->image('icons/session.png', array('alt' => __('Session'), 'title' => __('Session'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Session',true); ?>		
    </li>-->
    <li><?php //echo $this->Html->link($this->Html->image('icons/taxation.png', array('alt' => __('Taxation'), 'title' => __('Taxation'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Taxation',true); ?>		
    </li>
    <li><?php //echo $this->Html->link($this->Html->image('icons/terms.png', array('alt' => __('Term'), 'title' => __('Term'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Term',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/INVENTORIES.png', array('alt' => __('Inventories'), 'title' => __('Inventories'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Inventories',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/INVENTORY-TRANSFER.png', array('alt' => __('Inventory Transfer'), 'title' => __('Inventory Transfer'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Inventory Transfer',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/invoices.png', array('alt' => __('Invoices'), 'title' => __('Invoices'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php // echo __('Invoices',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/issue.png', array('alt' => __('Issue'), 'title' => __('Issue'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php // echo __('Issue',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/LOCATIONS.png', array('alt' => __('Location'), 'title' => __('Location'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Location',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/mfg.png', array('alt' => __('MFG'), 'title' => __('MFG'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('MFG',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/physician.png', array('alt' => __('Physician'), 'title' => __('Physician'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php // echo __('Physician',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/po.png', array('alt' => __('PO'), 'title' => __('PO'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('PO',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/PREFERENCE-CARD-DESIGNS.png', array('alt' => __('Preference Card Design'), 'title' => __('Preference Card Design'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Preference Card Design',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/PREFERNCE-CARD-INSTANCES.png', array('alt' => __('Preerence Card Instance'), 'title' => __('Preerence Card Instance'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Preerence Card Instance',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/PRODUCT-REQUEST.png', array('alt' => __('Product Instance'), 'title' => __('Product Instance'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Product Instance',true); ?>		
    </li>
    <li><?php //echo $this->Html->link($this->Html->image('icons/products.png', array('alt' => __('Product'), 'title' => __('Product'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Product',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/PURCHASING-CONTRACTS.png', array('alt' => __('Purchasing Contract'), 'title' => __('Purchasing Contract'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Purchasing Contract',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/receiving.png', array('alt' => __('Receiving'), 'title' => __('Receiving'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Receiving',true); ?>		
    </li>
     <li><?php //echo $this->Html->link($this->Html->image('icons/requisitions.png', array('alt' => __('Requisition'), 'title' => __('Requisition'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php //echo __('Requisition',true); ?>		
    </li>
     <li><?php // echo $this->Html->link($this->Html->image('icons/vendors.png', array('alt' => __('Vendors'), 'title' => __('Vendors'))),array("action"=>"menu","?"=>array('type'=>'master'),'admin'=>true), array('escape' => false)); ?>
        <p style="margin:0px; padding:0px;"><?php // echo __('Vendors',true); ?>		
    </li>
 
 <!-- ------------------------------EOF ------------------------M M I S----------------------------------- -->
     </ul>
