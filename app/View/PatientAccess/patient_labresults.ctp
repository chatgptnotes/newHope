<style>
.heading
{
    background: #FFFFFF	;
    color: #180000;
    
}

.margin
{
    margin-bottom: 5px;
}
</style>
<html><head><?php echo $this->Html->script(array('patient_access_js1.js','patient_access_js2.js') );
  echo $this->Html->css(array('patient_access.css',));?>
  
  
  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
</head>
<body>
 <div><h1>Results</h1>
 <p>Listed below are all lab on file for you. "Prescribed lab " are those on file with the patient's provide.
  "Other lab" are those	that have been entered via MYADC. Click the tabs to move between the lists.</p>
 <p>This may not a complete and accurate list depending on when a last review and update was done.
  We appreciate your assistance with updating your lab lists. </p></div>
 
 <p>To inform a provider about a lab and add it to the "other lab" list, click <a href="#"><b>Report Lab.</b></a>
  To view lab details, clicks the lab name.</p>
 <p>Every effort will be made to respond to your request within 24 hours, excepts when the offer is closed on weekends and holidays.</p>
 <p style="background:"><b>Need immediate service?</b> Please call your health care provider directly at 000-111-222</p>
 <div ><h2>Report On results</h2></div>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1"><b>Past Result</b></a></li>
   <!-- <li><a href="#tabs-2">Current Result</a></li> --> 
    <!--<li><a href="#tabs-3">Aenean lacinia</a></li>-->
  </ul>
  <div id="tabs-1" style="color:#33ccff; background:#000;">
    
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align="center" valign='top'>
				<tr class="heading">
					<td style="padding-left: 10px"><b>Lab</b></td>
					<td style="padding-left: 10px"><b>Observation</b></td>
					<td style="padding-left: 10px"><b>Range</b></td>
					<td style="padding-left: 10px"><b>Status</b></td>
				
				
				<tr class="margin ">
					<?php foreach($labRecords as $labRecords){ ?>
				
				
				<tr class="row_title">
					<td><?php echo $labRecords['Laboratory']['name'];?></td>
					<td><?php echo $labRecords['LaboratoryHl7Result']['result'].$labRecords['LaboratoryHl7Result']['uom'].",".$labRecords['LaboratoryHl7Result']['unit'];?>
					</td>
					<td><?php echo $labRecords['LaboratoryHl7Result']['range'];?></td>
					<td><?php echo $labRecords['LaboratoryHl7Result']['abnormal_flag'];?></td>
				
				
				
					<?php }?>
			
			</table>
  </div>
   <!--  <div id="tabs-2" style="color:#33ccff; background:#000;">
    <p>Hello this is Current Result.</p>
  </div>-->
  <!--<div id="tabs-3">
    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
    <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
  </div>-->
</div>
 
 
</body>
</html>