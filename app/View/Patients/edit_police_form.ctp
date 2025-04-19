<div class="inner_title">
<h3>
<?php 
  echo __('Add Police Form');
?></h3>
</div>
<div class="patient_info">
 <?php echo $this->element('patient_information');?>
</div> 
<div class="clr"></div>
<div style="text-align: right;" class="clr inner_title"></div>
<p class="ht5"></p>
<?php  
       if($this->request->data['PoliceForm']['inform_date']) {
 	    $informDate = $this->DateFormat->formatDate2Local($this->request->data['PoliceForm']['inform_date'],Configure::read('date_format'), false);
       } else {
       	$informDate = "";
       }
       if($this->request->data['PoliceForm']['accident_date']) {
 	    $accidentDate = $this->DateFormat->formatDate2Local($this->request->data['PoliceForm']['accident_date'],Configure::read('date_format'), false);
       } else {
       	$accidentDate = "";
       }
       if($this->request->data['PoliceForm']['admit_date']) {
 	    $admitDate = $this->DateFormat->formatDate2Local($this->request->data['PoliceForm']['admit_date'],Configure::read('date_format'), false);
       } else {
       	$admitDate = "";
       }
 
        $timeOptions =  array('00:00'=> '00:00','00:15'=> '00:15','00:30'=> '00:30','00:45'=> '00:45','01:00'=> '01:00','01:15'=> '01:15','01:30'=> '01:30','01:45'=> '01:45','02:00'=> '02:00','02:15'=> '02:15','02:30'=> '02:30','02:45'=> '02:45','03:00'=> '03:00','03:15'=> '03:15','03:30'=> '03:30','03:45'=> '03:45','04:00'=> '04:00','04:15'=> '04:15','04:30'=> '04:30','04:45'=> '04:45','05:00'=> '05:00','05:15'=> '05:15','05:30'=> '05:30','05:45'=> '05:45','06:00'=> '06:00','06:15'=> '06:15','06:30'=> '06:30','06:45'=> '06:45','07:00'=> '07:00','07:15'=> '07:15','07:30'=> '07:30','07:45'=> '07:45','08:00'=> '08:00','08:15'=> '08:15','08:30'=> '08:30','08:45'=> '08:45','09:00'=> '09:00','09:15'=> '09:15','09:30'=> '09:30','10:00'=> '10:00','10:15'=> '10:15','10:30'=> '10:30','10:45'=> '10:45','11:00'=> '11:00','11:15'=> '11:15','11:30'=> '11:30','11:45'=> '11:45','12:00'=> '12:00','12:15'=> '12:15','12:30'=> '12:30','12:45'=> '12:45','13:00'=> '13:00','13:15'=> '13:15','13:30'=> '13:30','13:45'=> '13:45','14:00'=> '14:00','14:15'=> '14:15','14:30'=> '14:30','14:45'=> '14:45','15:00'=> '15:00','15:15'=> '15:15','15:30'=> '15:30','15:45'=> '15:45','16:00'=> '16:00','16:15'=> '16:15','16:30'=> '16:30','16:45'=> '16:45','17:00'=> '17:00','17:15'=> '17:15','17:30'=> '17:30','17:45'=> '17:45','18:00'=> '18:00','18:15'=> '18:15','18:30'=> '18:30','18:45'=> '18:45','19:00'=> '19:00','19:15'=> '19:15','19:30'=> '19:30','19:45'=> '19:45','20:00'=> '20:00','20:15'=> '20:15','20:30'=> '20:30','20:45'=> '20:45','21:00'=> '21:00','21:15'=> '21:15','21:30'=> '21:30','21:45'=> '21:45','22:00'=> '22:00','22:15'=> '22:15','22:30'=> '22:30','22:45'=> '22:45','23:00'=> '23:00','23:15'=> '23:15','23:30'=> '23:30','23:45'=> '23:45')
  
?>
<form name="policefrm" id="policefrm" action="<?php echo $this->Html->url(array("controller" => "patients", "action" => "edit_police_form", $patient_id, $this->request->data['PoliceForm']['id'])); ?>" method="post" > 
  <?php 
     echo $this->Form->input('PoliceForm.patient_id', array('type' => 'hidden', 'value'=> $patient_id, 'id' => 'patient_id'));
     echo $this->Form->input('PoliceForm.id', array('type' => 'hidden', 'id' => 'police_form_id'));
  ?>
  <table width="100%" cellspacing="0" cellpadding="0" border="0">
     <tr>
      <td width="100%" align="center"><b style="font-size:18px;">&#2346;&#2379;&#2354;&#2367;&#2358; &#2360;&#2381;&#2335;&#2375;&#2358;&#2344; &#2346;&#2352;&#2381;&#2330;&#2368;</b></td>
     </tr>
<tr> 
   <td align="right"> &#2344;. 
                <?php 
		          echo $this->Form->input('PoliceForm.inform_no', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'inform_no', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?>
		    </td>
  </tr>
 <tr>
 <td align="right">&#2360;&#2369;&#2330;&#2344;&#2366; &#2342;&#2367;&#2344;&#2366;&#2306;&#2325;:<?php 
		          echo $this->Form->input('PoliceForm.inform_date', array('type'=> 'text', 'class' => 'validate[required,custom[mandatory-enter]]','id' => 'inform_date', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off','value' => $informDate));
		        ?></td>
 </tr>
  <tr><td>
  </td></tr>
<tr>
   <td align="left">&#2346;&#2381;&#2352;&#2340;&#2367;<br>
&#2346;&#2379;&#2354;&#2367;&#2358; &#2344;&#2367;&#2352;&#2368;&#2325;&#2381;&#2359;&#2325;<br>
&#2346;&#2379;&#2354;&#2367;&#2358; &#2360;&#2381;&#2335;&#2375;&#2358;&#2344; <?php 
		          echo $this->Form->input('PoliceForm.police_station_location', array('type'=> 'text', 'class' => 'validate[required,custom[mandatory-enter]]','id' => 'police_station_location', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?><br>
<?php 
		          echo $this->Form->input('PoliceForm.location', array('type'=> 'text', 'class' => 'validate[required,custom[mandatory-enter]]','id' => 'location', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?></td>
  </tr>
 <tr>
  <td>&#2350;&#2361;&#2379;&#2342;&#2351;,</td>
 </tr>
 <tr>
 <td>
 <p>
 
&#2310;&#2346;&#2325;&#2379; &#2360;&#2370;&#2330;&#2367;&#2340; &#2325;&#2367;&#2351;&#2366; &#2332;&#2366;&#2340;&#2366; &#2361;&#2376; &#2325;&#2368; &#2352;&#2369;&#2327;&#2381;&#2339;   <?php echo $patient[0]['lookup_name']; ?>   &#2313;&#2350;&#2381;&#2352;   <?php echo $patient['Patient']['age']; ?>   &#2357;&#2352;&#2381;&#2359;<?php 
		          //echo $this->Form->input('PoliceForm.year', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'year', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?> &#2354;&#2367;&#2306;&#2327;
<?php 
	echo ucfirst($patient['Patient']['sex']);
?> &#2344;&#2367;&#2357;&#2366;&#2360;&#2368; &#2327;&#2381;&#2352;&#2366;&#2350;<?php 
		          echo $this->Form->input('PoliceForm.address', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'address', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?>&#2340;&#2366;&#2354;&#2369;&#2325;&#2366;<?php 
		          echo $this->Form->input('PoliceForm.taluka', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'taluka', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?> &#2332;&#2367;&#2354;&#2366; <?php 
		          echo $this->Form->input('PoliceForm.district', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'district', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?> &#2354;&#2366;&#2344;&#2375; &#2357;&#2366;&#2354;&#2375; &#2357;&#2381;&#2351;&#2325;&#2381;&#2340;&#2367; &#2325;&#2366; &#2344;&#2366;&#2350;<?php 
		          echo $this->Form->input('PoliceForm.brought_person_name', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'brought_person_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?>&#2352;&#2367;&#2358;&#2381;&#2340;&#2366;<?php 
		          echo $this->Form->input('PoliceForm.relation', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'relation', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?>&#2344;&#2367;&#2357;&#2366;&#2360;&#2368; &#2327;&#2381;&#2352;&#2366;&#2350;<?php 
		          echo $this->Form->input('PoliceForm.brought_person_address', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'brought_person_address', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?>&#2340;&#2366;&#2354;&#2369;&#2325;&#2366;<?php 
		          echo $this->Form->input('PoliceForm.brought_person_taluka', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'brought_person_taluka', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?>&#2332;&#2367;&#2354;&#2366;<?php 
		          echo $this->Form->input('PoliceForm.brought_person_district', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'brought_person_district', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?>
&#2342;&#2381;&#2357;&#2366;&#2352;&#2366; &#2354;&#2366;&#2351;&#2366; &#2327;&#2351;&#2366; &#2361;&#2376; &#2404; &#2357;&#2361; &#2309;&#2360;&#2381;&#2346;&#2340;&#2366;&#2354; &#2350;&#2375;&#2306; /&#2360;&#2375;  &#2342;&#2367;&#2344;&#2366;&#2306;&#2325;<?php 
		          echo $this->Form->input('PoliceForm.admit_date', array('type'=> 'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'admit_date', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off', 'value' => $this->DateFormat->formatDate2Local($this->request->data['PoliceForm']['admit_date'],Configure::read('date_format'), false)));
		        ?>&#2360;&#2350;&#2351;<?php 
		          echo $this->Form->input('PoliceForm.admit_time', array('selected'=> date("H:i", strtotime($this->request->data['PoliceForm']['admit_time'])),'options'=> $timeOptions,'class' => 'validate[required,custom[mandatory-enter]]','id' => 'admit_time', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?> &#2325;&#2379; &#2342;&#2366;&#2326;&#2367;&#2354; &#2361;&#2369;&#2310; / &#2344;&#2367;&#2357;&#2371;&#2340;&#2381;&#2340;  &#2361;&#2369;&#2310; / &#2350;&#2371;&#2340;&#2381;&#2351;&#2369; &#2361;&#2369;&#2312; &#2404;<br /><br /> &#2313;&#2360;&#2375; (&#2350;&#2352;&#2368;&#2332; &#2325;&#2379; <?php 
		          echo $this->Form->input('PoliceForm.patient_details', array('type'=> 'text', 'class' => 'validate[required,custom[mandatory-enter]]','id' => 'patient_details', 'label'=> false, 'size' => '112','div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?><br />
&#2330;&#2379;&#2335; &#2310;&#2351;&#2368; &#2361;&#2376; &#2404;

&#2313;&#2360;&#2325;&#2368; &#2330;&#2379;&#2335;&#2379; &#2325;&#2366; &#2360;&#2350;&#2381;&#2346;&#2370;&#2352;&#2381;&#2339; &#2357;&#2367;&#2357;&#2352;&#2339; &#2344;&#2367;&#2350;&#2381;&#2344;&#2354;&#2367;&#2326;&#2367;&#2340;  &#2361;&#2376; &#2404;
&#2309;&#2346;&#2328;&#2366;&#2340; &#2342;&#2367;&#2344;&#2366;&#2306;&#2325;<?php 
		          echo $this->Form->input('PoliceForm.accident_date', array('type'=> 'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'accident_date', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off','value' => $this->DateFormat->formatDate2Local($this->request->data['PoliceForm']['accident_date'],Configure::read('date_format'), false)));
		        ?> &#2309;&#2346;&#2328;&#2366;&#2340; &#2360;&#2350;&#2351;<?php 
		          echo $this->Form->input('PoliceForm.accident_time', array('options'=> $timeOptions,'class' => 'validate[required,custom[mandatory-enter]]','id' => 'accident_time', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off','selected'=> date("H:i", strtotime($this->request->data['PoliceForm']['accident_time']))));
		        ?> &#2309;&#2346;&#2328;&#2366;&#2340; &#2360;&#2381;&#2341;&#2366;&#2344; <?php 
		          echo $this->Form->input('PoliceForm.accident_place', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'accident_place', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?>
&#2327;&#2381;&#2352;&#2366;&#2350;<?php 
		          echo $this->Form->input('PoliceForm.accident_address', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'accident_address', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?> &#2340;&#2366;&#2354;&#2369;&#2325;&#2366; <?php 
		          echo $this->Form->input('PoliceForm.accident_taluka', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'accident_taluka', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?> &#2332;&#2367;&#2354;&#2366; <?php 
		          echo $this->Form->input('PoliceForm.accident_district', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'accident_district', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?>
&#2346;&#2379;&#2354;&#2367;&#2358; &#2360;&#2381;&#2335;&#2375;&#2358;&#2344; <?php 
		          echo $this->Form->input('PoliceForm.police_station', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'police_station', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?> &#2309;&#2306;&#2340;&#2352;&#2381;&#2327;&#2340; <?php 
		          echo $this->Form->input('PoliceForm.other_details', array('type' => 'text', 'class' => 'validate[required,custom[mandatory-enter]]','id' => 'other_details', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?><br />
&#2309;&#2340;&#2307;  &#2310;&#2346;&#2360;&#2375; &#2344;&#2367;&#2357;&#2375;&#2342;&#2344; &#2361;&#2376; &#2325;&#2368;, &#2310;&#2346; &#2352;&#2369;&#2327;&#2381;&#2339; &#2325;&#2379; &#2346;&#2381;&#2352;&#2340;&#2381;&#2351;&#2325;&#2381;&#2359; &#2342;&#2375;&#2326;&#2344;&#2375; &#2310;&#2351;&#2375; &#2324;&#2352; &#2351;&#2358;&#2379;&#2330;&#2367;&#2340;  &#2325;&#2366;&#2352;&#2381;&#2351;&#2357;&#2366;&#2361;&#2368; &#2325;&#2352;&#2375; &#2404; 
<br /><br /><br />
&#2343;&#2344;&#2381;&#2351;&#2357;&#2366;&#2342; !
</p>
 </td>
 </tr>   
 <tr>
 <td align="right">
  <table width="300" border="0">
   <tr><td align="center"><?php 
		          echo $this->Form->input('PoliceForm.hospital_name', array('type'=> 'text', 'class' => 'validate[required,custom[mandatory-enter]]','id' => 'hospital_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));
		        ?> &#2361;&#2377;&#2360;&#2381;&#2346;&#2367;&#2335;&#2354;</td></tr>
   <tr>
   <td align="center"> &#2357;&#2352;&#2368;&#2359;&#2381;&#2336; &#2330;&#2367;&#2325;&#2367;&#2340;&#2381;&#2360;&#2325;/&#2344;&#2367;&#2357;&#2366;&#2360;&#2368; &#2330;&#2367;&#2325;&#2367;&#2340;&#2381;&#2360;&#2325;</td>
 </tr> 
  </table>
  </td>
 </tr> 
                                                         
                                                                                                                 
</table>
                    <p class="clr ht5"></p>
               		
<p class="ht5"></p>
<p class="clr ht5"></p>
<div class="btns"><input type="submit" value="Submit" class="blueBtn" />
	<a class="grayBtn" href="javascript:history.go(-1)" ><?php echo __('Cancel'); ?></a>
	</div>
</form>	
<script>
jQuery(document).ready(function(){
      jQuery("#policefrm").validationEngine();
	  jQuery(".rightTopBg").click(function() {
		  jQuery("#policefrm").validationEngine('hide');
	  });
      $( "#admit_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate();?>'
		});
      $( "#inform_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate();?>'
		});
 });
</script>