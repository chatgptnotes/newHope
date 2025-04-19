<?php if($inData['IncorporatedPatient']['patient_id']){ ?>
<iframe src="<?php echo FULL_BASE_URL.Router::url("/")."/uploads/ccda_imported/".$xml ;?>" width="1300 px" height="1000px"></iframe>
<?php } else{ ?>
<iframe src="<?php echo FULL_BASE_URL.Router::url("/")."/uploads/CCDA/".$xml ;?>" width="1300 px" height="1000px"></iframe>
<?php } ?>