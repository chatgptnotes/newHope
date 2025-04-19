<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
</title>
			<?php echo $this->Html->css(array('internal_style.css')); ?>
<script>

</script>
</head>
<body onload="javascript:window.print();">

<div class="inner_title">
<h3> &nbsp; <?php echo __('Incident Form', true); ?></h3>
</div>
 
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">


<?php $i=1;
	foreach($formQuestions as $formquestion){?>
		<tr><td align="left"><strong>
		<?php echo $i.')&nbsp;'.$formquestion['FormQuestion']['name']; ?>
		</strong></td></tr>
  <?php	 foreach($formAnswers as $formAnswer){
  
			if($formAnswer['PatientDataForms']['form_question_id'] == $formquestion['FormQuestion']['id']){?>
				<tr><td align="left">
		<?php	echo $formAnswer['PatientDataForms']['data'];
		?>		
				</td></tr>
			
	<?php	}//end if
		
		}//foreach
				?>
	<?php $i++;
	}

?>
</body>
</html>