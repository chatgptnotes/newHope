<?php  $day=($Diff > 1)?'days':'day';?>
<?php $role = $this->Session->read('role');
		if(strtolower($role)==strtolower(Configure::read('doctorLabel'))){
			
			if(($Diff <= 30)){?>
			<div id="flashMessage" class="error">
				<?php echo "Kindly note your license's expiration date is approaching and you need to renew it in ".$Diff." ". $day." before ".$this->DateFormat->formatDate2Local($expDate,Configure::read('date_format'),false);?>
			</div>
	<?php  }}?>

	 
 <script>
 $('#change_login_date')
	.click(
			function() { 
				//	var patient_id = $('#selectedPatient').val();

				
						$.fancybox({
							'width' : '70%',
							'height' : '90%',
							'autoScale' : true,
							'transitionIn' : 'fade',
							'transitionOut' : 'fade',
							'type' : 'iframe',
							'onComplete' : function() {
								$("#allergies").css({
									'top' : '20px',
									'bottom' : 'auto',
									
								});
							},
							'href' : "<?php echo $this->Html->url(array("controller" => "messages", "action" => "changeLoginDate",$_SESSION['Auth']['User']['patient_uid'])); ?>"

						});

			});
 </script> 

<script>
  	 /* var progressBar = document.getElementById("p"),
      client = new XMLHttpRequest()
	  client.open("GET", "<?php //echo $this->Html->url(array('controller'=>'Landings','action'=>'loadPermissions')); ?>")
	  client.onprogress = function(pe) {
	    if(pe.lengthComputable) {
	      progressBar.max = pe.total
	      progressBar.value = pe.loaded
	    }
	  }
	  client.onloadend = function(pe) {
	    progressBar.value = pe.loaded
	  }
      client.send()*/
</script>

