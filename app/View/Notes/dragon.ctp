<?php
echo $this->Html->script(array('jquery-1.5.1.min'));
echo $this->Html->css(array('internal_style.css'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array( 'jquery.custom.js?ver=1.0','jquery.fancybox-1.3.4')); ?>


<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Speech Recognition System', true); ?>
	</h3>
</div><br/>



	
	<table border="0" cellpadding="0" cellspacing="0" width="40%" >
        <tr>
	   <td width="100%" style="padding-left:8px;"><textarea name="copytextarea" data-nusa-concept-name="clinical findings" rows="4" cols="90" style="width:350px;" id="copytextarea"></textarea><br/><br/><?php echo $this->Html->link(__('Copy Text') ,
												     '#',
												     array('escape' => false,'class'=>'blueBtn','id' => 'copytext'));?></td>
       </tr>
       </table>


<script>
	$(document).ready(function(){
		  $("#comment").click(function(){
			 var count=0; 
			$("td span").each(function(){ 
				count++; 
		    $("#cmnt_presc"+count).toggle();
		  });
			  });
		});
</script>
<script language="javascript" type="text/javascript" src="http://speechanywhere.nuancehdp.com/1.4/scripts/Nuance.SpeechAnywhere.js"></script>  
<script language="javascript" type="text/javascript">
//window.onload=setCookies;
function setCookies()
{
  var c_name='NUSA_Guids';
  var c_value='dba4119d-29b9-46ff-9c43-6de3154d8017/d4f0ef09-008b-4874-b04a-7e32d3d33bfe';  
  document.cookie = "NUSA_Guids=dba4119d-29b9-46ff-9c43-6de3154d8017/d4f0ef09-008b-4874-b04a-7e32d3d33bfe";
   getCookie('NUSA_Guids');
}
	</script>

<script language="javascript" type="text/javascript">
function SetCookie(cookieName,cookieValue,nDays) 
{
      var today = new Date();
      var expire = new Date();
      if (nDays==null || nDays==0) nDays=1;
      expire.setTime(today.getTime() + 3600000*24*nDays);
      document.cookie = cookieName+"="+escape(cookieValue)
                 + ";expires="+expire.toGMTString();
    
}

function getCookie(c_name)
{
  var c_value = document.cookie;
  var c_start = c_value.indexOf(" " + c_name + "=");
  if (c_start == -1)
  {
  c_start = c_value.indexOf(c_name + "=");
  }
if (c_start == -1)
  {
  c_value = null;
  }
else
  {
  c_start = c_value.indexOf("=", c_start) + 1;
  var c_end = c_value.indexOf(";", c_start);
  if (c_end == -1)
    {
    c_end = c_value.length;
    }
  c_value = unescape(c_value.substring(c_start,c_end));
  }
  //alert(c_value);
if(c_value=="")
  window.location.reload();
}

function NUSA_configure() 
{
   NUSA_enableAll = true;
   NUSA_userId = "drmhope";
   NUSA_applicationName = "Sample_Basic";			

}
$(document).ready(function(){
setCookies();
$('#copytext').click(function(){
var notetypes='<?php echo $notetype?>';
var copytextareavalue=document.getElementById("copytextarea").value;
/*
$( '#subShow', parent.document ).val(copytextareavalue);*/
if(notetypes=='objective'){
	var objectShowVal= $( '#objectShow', parent.document ).val();
  	$( '#objectShow', parent.document ).val(objectShowVal+" "+copytextareavalue);
}
if(notetypes=='subjectRos')	{
		var subShowRosVal= $( '#subShowRos', parent.document ).val();
	 	 $( '#subShowRos', parent.document ).val(subShowRosVal+" "+copytextareavalue);
}
if(notetypes=='subject'){
	var subShowVal= $( '#subShow', parent.document ).val();
  $( '#subShow', parent.document ).val(subShowVal+" "+copytextareavalue);
}
if(notetypes=='assessment')	{
	var AssesShowval= $( '#AssesShow', parent.document ).val();
  $( '#AssesShow', parent.document ).val(AssesShowval+" "+copytextareavalue);
}
  if(notetypes=='plan')	{
	var planShowVal= $( '#planShow', parent.document ).val();
 	 $( '#planShow', parent.document ).val(planShowVal+" "+copytextareavalue);
  }
 if(notetypes=='complaints')	
  $( '#cc_desc', parent.document ).val(copytextareavalue);
  if(notetypes=='complaints')	
   $( '#complaints_desc', parent.document ).val(copytextareavalue);
 if(notetypes=='lab_report')	
   $( '#lab-reports_desc', parent.document ).val(copytextareavalue);
 if(notetypes=='general_examine')	
   $( '#general_examine', parent.document ).val(copytextareavalue);
 if(notetypes=='surgery')	
   $( '#surgery_desc', parent.document ).val(copytextareavalue);
 if(notetypes=='plancare')	
   $( '#plancare_desc', parent.document ).val(copytextareavalue);
 if(notetypes=='Template')	
	 $( '#Template', parent.document ).val($('#Template', parent.document).val() + " "+copytextareavalue);
	 //  $( '#Template', parent.document ).val(copytextareavalue);

  
				  
parent.$.fancybox.close();
});
});
</script>