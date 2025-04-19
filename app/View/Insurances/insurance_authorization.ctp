<?php //jquery-1.5.1.min',
  echo $this->Html->script(array('jquery-1.5.1.min','jquery.fancybox-1.3.4','ui.datetimepicker.3.js'));//jquery-1.9.1.js
  echo $this->Html->css(array('jquery.fancybox-1.3.4.css','internal_style.css'));//,'internal_style.css'
 ?>
 <style>
 .red{
 	color: red;
 }
 
 </style>
 <script>
var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
</script>
<div class="inner_title" >
	<table style="margin: 10px;" width="100%" cellspacing="0">
	<tr>
		<td><h3>&nbsp;<?php echo __('Insurance Authorizations', true); ?></h3></td>
		<td><?php echo $this->Form->button('Add New Authorization', array('class'=>'blueBtn','style'=>'float:right','type' => 'button','id'=>'addNewInsuranceAuthorization'));?></td>
	</tr>
	</table>
</div>
<div id="listContainer">
	<table style="margin: 10px;" width="100%" class="table_format" cellspacing="0">
		<tr class="row_title">
			<td class="table_cell"><?php echo __('Authorization Number')?></td>
			<td class="table_cell"><?php echo __('Procedure')?></td>
			<td class="table_cell"><?php echo __('Start Date')?></td>
			<td class="table_cell"><?php echo __('End Date')?></td>
			<td class="table_cell"><?php echo __('Visits Approved')?></td>
			<td class="table_cell"><?php echo __('Visits Remaining')?></td>
			<td class="table_cell"><?php echo __('Notes')?></td>
			<td class="table_cell"><?php echo __('Actions')?></td>
		</tr>
		<?php foreach($activeAuthorizations as $data){ ?>
		<tr>
			<td class="tdLabel"><?php echo $data['InsuranceAuthorization']['authorization_number'];?></td>
			<td class="tdLabel"><?php echo $data['TariffList']['name'];?></td>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['InsuranceAuthorization']['start_date'],Configure::read('date_format'),false);?></td>
			<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($data['InsuranceAuthorization']['end_date'],Configure::read('date_format'),false);?></td>
			<td class="tdLabel"><?php echo $data['InsuranceAuthorization']['visit_approved'];?></td>
			<td class="tdLabel"><?php echo $data['InsuranceAuthorization']['visit_remaining'];?></td>
			<td class="tdLabel"><?php echo $data['InsuranceAuthorization']['notes'];?></td>
			<td class="tdLabel">
			<?php echo $this->Html->image('icons/edit-icon.png',array('alt'=>'Edit','title'=>'Edit Insurance Authorization','class'=>'edit','id'=>'edit_'.$data['InsuranceAuthorization']['id']));?>
			<?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'Delete Insurance Authorization','class'=>'delete','id'=>'delete_'.$data['InsuranceAuthorization']['id']));?>
			</td>
		</tr>
	<?php }?>
</table>


<div class="inner_title">
	<td><h3>
		&nbsp;<?php echo __('Expired Authorizations', true); ?>
	</h3></td>
	<span></span>
</div>
<table style="margin: 10px;" width="100%" class="table_format" cellspacing="0">
	<tr class="row_title">
		<td class="table_cell"><?php echo __('Authorization Number')?></td>
		<td class="table_cell"><?php echo __('Procedure')?></td>
		<td class="table_cell"><?php echo __('Start Date')?></td>
		<td class="table_cell"><?php echo __('End Date')?></td>
		<td class="table_cell"><?php echo __('Visits Approved')?></td>
		<td class="table_cell"><?php echo __('Visits Remaining')?></td>
		<td class="table_cell"><?php echo __('Notes')?></td>
		<td class="table_cell"><?php echo __('Actions')?></td>
	</tr>
	<?php foreach($expiredAuthorizations as $expiredAuthorization){?>
	<tr>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['authorization_number'];?></td>
		<td class="tdLabel red"><?php echo $data['TariffList']['name'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['start_date'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['end_date'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['visit_approved'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['visit_remaining'];?></td>
		<td class="tdLabel red"><?php echo $expiredAuthorization['InsuranceAuthorization']['notes'];?></td>
		<td class="tdLabel">
			<?php echo $this->Html->image('icons/edit-icon.png',array('alt'=>'Edit','title'=>'Edit Insurance Authorization','class'=>'edit','id'=>'edit_'.$expiredAuthorization['InsuranceAuthorization']['id']));?>
			<?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'Delete Insurance Authorization','class'=>'delete','id'=>'delete_'.$expiredAuthorization['InsuranceAuthorization']['id']));?>
			</td>
	</tr>
<?php }?>
</table>
</div>
<script>
var newInsuranceAuthorizationURL = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "newInsuranceAuthorization",$patientId,"admin" => false)); ?>" ; 
$( "#addNewInsuranceAuthorization" ).live('click',function() {
	$.fancybox({
			'width' : '95%',
			'height' : '90%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'href' : newInsuranceAuthorizationURL
	});
});

 
$( ".edit" ).live('click',function() {
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");
	recordId = splittedVar[1];
	var editInsuranceAuthorizationURL = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "editInsuranceAuthorization","admin" => false)); ?>"+"/"+recordId ;
	$.fancybox({
			'width' : '55%',
			'height' : '80%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'href' : editInsuranceAuthorizationURL
	});
});



$(".delete").live('click',function (){
	if(confirm("Do you really want to delete this record?")){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");
	recordId = splittedVar[1];
 	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "deleteInsuranceAuthorization", "admin" => false)); ?>"+"/"+recordId+"/"+"<?php echo $patientId ;?>",
		  context: document.body,	
		  //data : formData, 	  		  
		  success: function(data){
 			 // parent.location.reload(true);
			  $("#listContainer").html(data);
		  }
	});	
	}else{
        return false;
    }	 
});
</script>