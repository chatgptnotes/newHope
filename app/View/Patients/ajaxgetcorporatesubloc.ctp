<?php /*BOF-Mahalaxmi for WCL Patient*/
	//if($wclTariffID == $this->params->query['tariffId'] || $cghsTariffID == $this->params->query['tariffId'])	
	if(in_array($this->params->query['tariffId'],$wclCghsTariffID))
			$validateaclass="validate[required,custom[mandatory-select]]";
	  else
			$validateaclass="";
			
	/*EOF-Mahalaxmi for WCL Patient*/?>
&nbsp;&nbsp;&nbsp;<select class="textBoxExpnd <?php echo $validateaclass;?>" id="ajaxcorporatesublocationid" name="data[Patient][corporate_sublocation_id]">
 <option value="">Select Corporate Sublocations</option>
 <?php foreach($corporatesulloclist as $corporatesulloclistval) { ?>
  <option value="<?php echo $corporatesulloclistval['CorporateSublocation']['id'] ?>"><?php echo $corporatesulloclistval['CorporateSublocation']['name']; ?></option>
 <?php } ?>
</select>


