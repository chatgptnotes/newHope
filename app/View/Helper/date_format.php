<?php
class DateFormatHelper extends AppHelper{
	 
	 static public $timezones = array(
			'Pacific/Midway'    => "-11:00",
			'US/Samoa'          => "-11:00",
			'US/Hawaii'         => "-10:00",
			'US/Alaska'         => "-09:00",
			'US/Pacific'        => "-08:00",
			'America/Tijuana'   => "-08:00",
			'US/Arizona'        => "-07:00",
			'US/Mountain'       => "-07:00",
			'America/Chihuahua' => "-07:00",
			'America/Mazatlan'  => "-07:00",
			'America/Mexico_City' => "-06:00",
			'America/Monterrey' => "-06:00",
			'Canada/Saskatchewan' => "-06:00",
			'US/Central'        => "-06:00",
			'US/Eastern'        => "-05:00",
			'US/East-Indiana'   => "-05:00",
			'America/Bogota'    => "-05:00",
			'America/Lima'      => "-05:00",
			'America/Caracas'   => "-04:30",
			'Canada/Atlantic'   => "-04:00",
			'America/La_Paz'    => "-04:00",
			'America/Santiago'  => "-04:00",
			'Canada/Newfoundland'  => "-03:30",
			'America/Buenos_Aires' => "-03:00",
			'Greenland'         => "-03:00",
			'Atlantic/Stanley'  => "-02:00",
			'Atlantic/Azores'   => "-01:00",
			'Atlantic/Cape_Verde' => "-01:00",
			'Africa/Casablanca' => "00:00",
			'Europe/Dublin'     => "00:00",
			'Europe/Lisbon'     => "00:00",
			'Europe/London'     => "00:00",
			'Africa/Monrovia'   => "00:00",
			'Europe/Amsterdam'  => "+01:00",
			'Europe/Belgrade'   => "+01:00",
			'Europe/Berlin'     => "+01:00",
			'Europe/Bratislava' => "+01:00",
			'Europe/Brussels'   => "+01:00",
			'Europe/Budapest'   => "+01:00",
			'Europe/Copenhagen' => "+01:00",
			'Europe/Ljubljana'  => "+01:00",
			'Europe/Madrid'     => "+01:00",
			'Europe/Paris'      => "+01:00",
			'Europe/Prague'     => "+01:00",
			'Europe/Rome'       => "+01:00",
			'Europe/Sarajevo'   => "+01:00",
			'Europe/Skopje'     => "+01:00",
			'Europe/Stockholm'  => "+01:00",
			'Europe/Vienna'     => "+01:00",
			'Europe/Warsaw'     => "+01:00",
			'Europe/Zagreb'     => "+01:00",
			'Europe/Athens'     => "+02:00",
			'Europe/Bucharest'  => "+02:00",
			'Africa/Cairo'      => "+02:00",
			'Africa/Harare'     => "+02:00",
			'Europe/Helsinki'   => "+02:00",
			'Europe/Istanbul'   => "+02:00",
			'Asia/Jerusalem'    => "+02:00",
			'Europe/Kiev'       => "+02:00",
			'Europe/Minsk'      => "+02:00",
			'Europe/Riga'       => "+02:00",
			'Europe/Sofia'      => "+02:00",
			'Europe/Tallinn'    => "+02:00",
			'Europe/Vilnius'    => "+02:00",
			'Asia/Baghdad'      => "+03:00",
			'Asia/Kuwait'       => "+03:00",
			'Europe/Moscow'     => "+03:00",
			'Africa/Nairobi'    => "+03:00",
			'Asia/Riyadh'       => "+03:00",
			'Europe/Volgograd'  => "+03:00",
			'Asia/Tehran'       => "+03:30",
			'Asia/Baku'         => "+04:00",
			'Asia/Muscat'       => "+04:00",
			'Asia/Tbilisi'      => "+04:00",
			'Asia/Yerevan'      => "+04:00",
			'Asia/Kabul'        => "+04:30",
			'Asia/Yekaterinburg' => "+05:00",
			'Asia/Karachi'      => "+05:00",
			'Asia/Tashkent'     => "+05:00",
			'Asia/Kolkata'      => "+05:30",
			'Asia/Kathmandu'    => "+05:45",
			'Asia/Almaty'       => "+06:00",
			'Asia/Dhaka'        => "+06:00",
			'Asia/Novosibirsk'  => "+06:00",
			'Asia/Bangkok'      => "+07:00",
			'Asia/Jakarta'      => "+07:00",
			'Asia/Krasnoyarsk'  => "+07:00",
			'Asia/Chongqing'    => "+08:00",
			'Asia/Hong_Kong'    => "+08:00",
			'Asia/Irkutsk'      => "+08:00",
			'Asia/Kuala_Lumpur' => "+08:00",
			'Australia/Perth'   => "+08:00",
			'Asia/Singapore'    => "+08:00",
			'Asia/Taipei'       => "+08:00",
			'Asia/Ulaanbaatar'  => "+08:00",
			'Asia/Urumqi'       => "+08:00",
			'Asia/Seoul'        => "+09:00",
			'Asia/Tokyo'        => "+09:00",
			'Asia/Yakutsk'      => "+09:00",
			'Australia/Adelaide' => "+09:30",
			'Australia/Darwin'  => "+09:30",
			'Australia/Brisbane' => "+10:00",
			'Australia/Canberra' => "+10:00",
			'Pacific/Guam'      => "+10:00",
			'Australia/Hobart'  => "+10:00",
			'Australia/Melbourne' => "+10:00",
			'Pacific/Port_Moresby' => "+10:00",
			'Australia/Sydney'  => "+10:00",
			'Asia/Vladivostok'  => "+10:00",
			'Asia/Magadan'      => "+11:00",
			'Pacific/Auckland'  => "+12:00",
			'Pacific/Fiji'      => "+12:00",
			'Asia/Kamchatka'    => "+12:00",
			'America/Denver'    => "-11:30",
		);
	var $helpers=array('Session');

	/**
	* format2Local converts the standard YYYY-MM-DD format to the local format
	* param $stdDate = receives the standard YYYY-MM-DD formatted date
	* param $localFromat = receives the local format
	* param $retTime = if 1, will append the time part to the returned date
	* param $sepChars = will accept the reference to an array containing the separator chars list.  if empty, the default will be used
	* return = the date in local format
	* The function assumes that the dates are in correct formats
	* therefore a validation routine must be done at the client side
	*/
	function formatDate2Local($stdDate, $localFormat, $retTime=FALSE, $timeOnly=FALSE, $sepChars='')
	{
	  if(empty($stdDate))
		 return;
	  if(($stdDate == '0000-00-00 00:00:00') || ($stdDate == '0000-00-00'))
	  	return;
	   global $lang;
	   $sepTime = explode(" ",$stdDate);
	   $sepTime = trim($sepTime['1']);
	   /** Commented by Pawan to resolve issues of timezone
	   if($sepTime)
	   $stdDate = $this->datetimeUtcToLocal($stdDate,"Y-m-d H:i:s");
	   */  
	   if(!$sepChars) $sepChars=array('-','.','/',':',',');
	   $localFormat=strtolower($localFormat); 
	   
	   if(stristr('0000',$stdDate))  return strtr($localFormat,'yYmMdDHis','000000000'); // IF  std date is 0 return 0's in local format
	
	   /* If time is included then isolate */
	   if(strchr($stdDate,':'))
	   {
	      list($stdDate,$stdTime) = explode(' ',$stdDate);
		  if($timeOnly) return $stdTime; /* If time only is needed */
	   }
	
	   $stdArray=explode('-',$stdDate);
	   
	   /* Detect time separator and explode localFormat */
	   for($i=0;$i<sizeof($sepChars);$i++)
	   {
	     if(strchr($localFormat,$sepChars[$i]))
		 {
		    $localSeparator=$sepChars[$i];
	        $localArray=explode($localSeparator,$localFormat);
			break;
		 }
	   }
	   
	   for($i=0;$i<3;$i++)
	   {
	     if($localArray[$i]=='yyyy') $localArray[$i]=$stdArray[0];
		  elseif($localArray[$i]=='mm') $localArray[$i]=$stdArray[1];
		    elseif($localArray[$i]=='dd') $localArray[$i]=$stdArray[2];
	   }
	   
	   //if ($lang=='de') $stdTime=strtr($stdTime,':','.'); // This is a hard coded time  format translator for german "de" language
	   
	/*   if($retTime) return implode($localSeparator,$localArray).' '.$stdTime;
	    else return implode($localSeparator,$localArray);*/
	    $result ='';
	   if($retTime) $result = implode($localSeparator,$localArray).' '.$stdTime;
	    else $result = implode($localSeparator,$localArray);
	    
	   return $result;
	   
	}
	
	function formatShortDate2Local($month,$day,$localFormat)
	{
	   if(!$sepChars) $sepChars=array('-','.','/',':',',');
	   $localFormat=strtolower($localFormat); 
	   
	 
	   /* Detect time separator and explode localFormat */
	   for($i=0;$i<sizeof($sepChars);$i++)
	   {
	     if(strchr($localFormat,$sepChars[$i]))
		 {
		    $localSeparator=$sepChars[$i];
	        $localArray=explode($localSeparator,$localFormat);
			break;
		 }
	   }
	   
	   for($i=0;$i<3;$i++)
	   {
	     if($localArray[$i]=='yyyy') $s_tag=$i;
		  elseif($localArray[$i]=='mm') $localArray[$i]=$month;
		    elseif($localArray[$i]=='dd') $localArray[$i]=$day;
	   }
	   
	   array_splice($localArray,$s_tag,1);
	   return implode($localSeparator,$localArray);
	   
	}
	
	
	function formatDate2STD($localDate,$localFormat,&$sepChars='')
	{
	  if(empty($localDate))
		 return;
	  if(($localDate == '0000-00-00 00:00:00') || ($localDate == '0000-00-00'))
	  	return;
		 
	   
	   $splitDate = explode(' ',$localDate);
	   
	   /* if(empty($splitDate[1])){
		   	$zone = $this->Session->read('timezone');	
		   	if(empty($zone)) $zone = '+05:30';	
			$key = array_search($zone,DateFormatHelper::$timezones);
			$dateTime = new DateTime("now", new DateTimeZone($key));
		 	$splitDate[1] = $dateTime->format("H:i:s");
	   }else{ */ //commnetd by pankaj as we do not need unnecessary time with date
	   		$localDate =  $splitDate[0]; 
	   //}
	   		
	   $finalDate=0;
	   $localFormat=strtolower($localFormat);
	
	   if(!$sepChars) $sepChars=array('-','.','/',':',',');
	
		  if(stristr('0000',$finalDate)) $finalDate=0;
	
	   
	   if(!$finalDate)
	   {
	     
		 for($i=0;$i<sizeof($sepChars);$i++)
		 {
	        if(strchr($localDate,$sepChars[$i]))
			{
		       $loc_array=explode($sepChars[$i],$localDate);
			   break;
			}
		 }
	     
		 for($i=0;$i<sizeof($sepChars);$i++)
		 {
	        if(strchr($localFormat,$sepChars[$i]))
			{
		       $Format_array=explode($sepChars[$i],$localFormat);
			   break;
			}
		 }
		 
		 /* Detect local format and reformat the local time to DATE standard */
		 for($i=0;$i<3;$i++)
		 {
		    if($Format_array[$i]=='yyyy')   	{ $vYear = $loc_array[$i];}
			 elseif($Format_array[$i]=='mm') { $vMonth = $loc_array[$i];}
			   elseif($Format_array[$i]=='dd') { $vDay = $loc_array[$i];}
		 }
		 
		 # if invalid numeric return empty string
		 if(!is_numeric($vYear)||!is_numeric($vMonth)||!is_numeric($vDay)){
		 	$finalDate= '';
	 	 }else{
			  # DATE standard
			  if(strlen($vMonth)==1) $vMonth='0'.$vMonth;
			  if(strlen($vDay)==1) $vDay='0'.$vDay;
			 $finalDate=$vYear.'-'.$vMonth.'-'.$vDay; 
		}
	     
	   } 
	    if(!empty($splitDate[1])) $finalDate = $finalDate." ".$splitDate[1];

	    return trim($finalDate);
	    /** Commented by Pawan to remove timezone issues
	    return $this->datetimeLocalToUtc($finalDate);
	    return $this-> datetimeLocalToUtc($finalDate,$splitDate[1]);

	    */
	    
	}
	
	
	function formatCurrentDate2STD($localDate,$localFormat,&$sepChars='')
	{
	
		if(empty($localDate))
			return;
		if(($stdDate == '0000-00-00 00:00:00') || ($stdDate == '0000-00-00'))
			return;
			
		$splitDate = explode(' ',$localDate);
		if(empty($splitDate[1])){
			$session  = new cakeSession();
			$zone = $session->read('timezone');
	
			$key = array_search($zone,DateFormatComponent::$timezones);
	
			$dateTime = new DateTime("now", new DateTimeZone($key));
	
			$splitDate[1] = $dateTime->format("H:i:s");
		}
	
		$localDate = $splitDate[0]." ".$splitDate[1];
		return DateFormatComponent::datetimeLocalToUtc($localDate);
	
	}
	
	/**
	* convertTimeStandard() will return a time in the format HH:mm:ss
	* param $time_val = the time value to be converted
	* return = the time in the format HH:mm:ss
	*/
	function convertTimeToStandard($time_val)
	{
	   $time_val=strtr($time_val,'.,/-','::::'); // convert the separators to ':'
	   
	   $sep_count=substr_count($time_val,':');
	   
	   switch($sep_count)
	   {
	     case '': $time_val.=':00:00'; break;
	     case 0: $time_val.=':00:00'; break;
	     case 1: $time_val.=':00';
	   }
	   
	   $session = new cakeSession();
	   $zone = $session->read('timezone');
	   $key = array_search($zone,DateFormatHelper::$timezones);
	   $timezone = new DateTimeZone($key);
	   $date = new DateTime(date('Y-m-d')." ".$time_val);
	   $date->setTimezone($timezone);
	   if(count($timeVal)==2){
	   	$time_val = $date->format("H:i:s");
	   }else{
	   	$time_val = $date->format("H:i");
	   }
	   
	   return $time_val;
	}
	
	/**
	* convertTimeLocal() will return a time in the local format 
	* param $time_val = the time value to be converted in HHxMMxSS, where x is the separator which will be converted to ":"
	* return = the time in the format HH:mm:ss
	*/
	function convertTimeToLocal($time_val)
	{
	   global $lang;
	  
	   switch($lang)
	   {
	     //case 'de': $time_val=strtr($time_val,':,/-','....'); break; # convert the separators to '.' 
	     default : $time_val=strtr($time_val,'.,/-','::::'); # convert the separators to ':'
	   }
	   
	  // echo $returnTime = substr($time_val,0,strrpos($time_val,':'))  ; 
	   
	   $session = new cakeSession();
	   $zone = $session->read('timezone');
	   $key = array_search($zone,DateFormatHelper::$timezones);
	   $timezone = new DateTimeZone($key); 
	   $date = new DateTime(date('Y-m-d')." ".$time_val);
	   $date->setTimezone($timezone); 
	   if(count($timeVal)==2){
	   		  $time_val = $date->format("H:i:s");
	   }else{
	   		  $time_val = $date->format("H:i");
	   } 
	   
	   return $time_val ; //substr($time_val,0,strrpos($time_val,':'));
	}
	
	
/**
 * Function to return age from date
 *
 * @param $start:current date
 * @param $end : date of birth
 * @return $accuracy:(Optional)
**/	
		 function age_from_dob($dob) {
		 
		    $dob = strtotime($dob);
		    $y = date('Y', $dob);
		   
		    if (($m = (date('m') - date('m', $dob))) < 0) {
		        $y++;
		    } elseif ($m == 0 && date('d') - date('d', $dob) < 0) {
		        $y++;
		    }
		   
		    return date('Y') - $y;
		   
		}

	// Calculate total time taken
	function getMyTimeDiff($t1,$t2){
		
		$a1 = explode(":",$t1);
		$a2 = explode(":",$t2);
		$time1 = (($a1[0]*60*60)+($a1[1]*60));
		$time2 = (($a2[0]*60*60)+($a2[1]*60));
		$diff = abs($time1-$time2);
		$hours = floor($diff/(60*60));
		$mins = floor(($diff-($hours*60*60))/(60));
		$secs = floor(($diff-(($hours*60*60)+($mins*60))));
		$result = $hours.":".$mins.":".$secs;
		return $result;
	}
		
	function getTimeStringFormSec($finalremTime=null) {
		  $days = (int) ($finalremTime/86400);
		  $finalremTime = $finalremTime-($days*86400);
		  $hours = (int)($finalremTime/3600);
		  $finalremTime = $finalremTime-($hours*3600);
		  $minutes = (int)($finalremTime/60);
		  $finalremTime =(int) $finalremTime-($minutes*60);
			//EOF			
		  $avgtime = ($days>1)?$days." Days ":"" ;
		  $avgtime .= ($days==1)?$days." Day ":"" ;
		  $avgtime .= ($hours>1)?$hours." hrs ":"" ; 
		  $avgtime .= ($hours==1)?$hours." hr ":"" ; 
		  $avgtime .= ($minutes>1)?$minutes." Minutes ":"" ;  	 
		  $avgtime .= ($minutes==1)?$minutes." Min ":"" ;
		  return $avgtime;
	 }

        function dateDiff($date1=null,$date2 =null){
	 		$datetime1 = new DateTime($date2);
			$datetime2 = new DateTime($date1);
			$interval = $datetime1->diff($datetime2);
			return $interval ;
	 }
	 
	 
		/* this function get local time of user*/
   function datetimeUtcToLocal($datetime,$dateFormat){
   
		$session = new cakeSession(); 
		$zone = $session->read('timezone');	
		$key = array_search($zone,DateFormatHelper::$timezones);	
 		$date = new DateTime($datetime,new DateTimeZone('UTC')); //please do not change   
		$date->setTimeZone(new DateTimeZone($key));
	    return  $date->format("Y-m-d H:i:s");  
	} 
	
   function datetimeLocalToUtc($datetime,$time=null){
   	 
   		$session = new cakeSession(); 
		$zone = $session->read('timezone');	
		$key = array_search($zone,DateFormatHelper::$timezones);	  
		$dateTime = new DateTime($datetime,new DateTimeZone($key));  //please do not change
		$dateTime->setTimeZone(new DateTimeZone("UTC"));
	    //return $dateTime->format("Y-m-d H:i:s"); 

	    //added by pankaj please confirm before edit or delete
	    if(empty($time))
	    	return $dateTime->format("Y-m-d");
	    else
	    	return $dateTime->format("Y-m-d H:i:s"); 
		   
	} 
	
//fucntion only return into specified format irrespective of UTC tim
	function formatDate2LocalNonUTC($stdDate, $localFormat, $retTime=FALSE, $timeOnly=FALSE, &$sepChars='')
	{
	  if(empty($stdDate))
		 return;
	    	 
	   global $lang;
	   
	   if(!$sepChars) $sepChars=array('-','.','/',':',',');
	   $localFormat=strtolower($localFormat); 
	   
	   if(stristr('0000',$stdDate))  return strtr($localFormat,'yYmMdDHis','000000000'); // IF  std date is 0 return 0's in local format
	
	   /* If time is included then isolate */
	   if(strchr($stdDate,':'))
	   {
	      list($stdDate,$stdTime) = explode(' ',$stdDate);
		  if($timeOnly) return $stdTime; /* If time only is needed */
	   }
	
	   $stdArray=explode('-',$stdDate);
	   
	   /* Detect time separator and explode localFormat */
	   for($i=0;$i<sizeof($sepChars);$i++)
	   {
	     if(strchr($localFormat,$sepChars[$i]))
		 {
		    $localSeparator=$sepChars[$i];
	        $localArray=explode($localSeparator,$localFormat);
			break;
		 }
	   }
	   
	   for($i=0;$i<3;$i++)
	   {
	     if($localArray[$i]=='yyyy') $localArray[$i]=$stdArray[0];
		  elseif($localArray[$i]=='mm') $localArray[$i]=$stdArray[1];
		    elseif($localArray[$i]=='dd') $localArray[$i]=$stdArray[2];
	   }
	   
	   //if ($lang=='de') $stdTime=strtr($stdTime,':','.'); // This is a hard coded time  format translator for german "de" language
	   $result ='';
	   if($retTime) $result = implode($localSeparator,$localArray).' '.$stdTime;
	    else $result = implode($localSeparator,$localArray);
	   return $result;
	}
	
	/**
	 *
	 * @param date  $stdDate
	 * @param string $localFormat
	 * @param boolean $retTime
	 * @param boolean $timeOnly
	 * @param string $sepChars
	 * @return void|string|multitype:
	 */
	function formatDate2LocalForReport($stdDate, $localFormat, $retTime=FALSE, $timeOnly=FALSE, &$sepChars='')
	{
		if(empty($stdDate))
			return;
			
		global $lang;
		//$stdDate = DateFormatComponent::datetimeUtcToLocal($stdDate,"Y-m-d H:i:s");
		if(!$sepChars) $sepChars=array('-','.','/',':',',');
		$localFormat=strtolower($localFormat);
	
		if(stristr('0000',$stdDate))  return strtr($localFormat,'yYmMdDHis','000000000'); // IF  std date is 0 return 0's in local format
	
		/* If time is included then isolate */
		if(strchr($stdDate,':'))
		{
			list($stdDate,$stdTime) = explode(' ',$stdDate);
			if($timeOnly) return $stdTime; /* If time only is needed */
		}
	
		$stdArray=explode('-',$stdDate);
	
		/* Detect time separator and explode localFormat */
		for($i=0;$i<sizeof($sepChars);$i++)
		{
		if(strchr($localFormat,$sepChars[$i]))
		{
		$localSeparator=$sepChars[$i];
		$localArray=explode($localSeparator,$localFormat);
		break;
		}
		}
	
	
		for($i=0;$i<3;$i++)
		{
		if($localArray[$i]=='yyyy') $localArray[$i]=$stdArray[0];
		elseif($localArray[$i]=='mm') $localArray[$i]=$stdArray[1];
		elseif($localArray[$i]=='dd') $localArray[$i]=$stdArray[2];
		}
	
		//if ($lang=='de') $stdTime=strtr($stdTime,':','.'); // This is a hard coded time  format translator for german "de" language
		$result ='';
		if($retTime) $result = implode($localSeparator,$localArray).' '.$stdTime;
		else $result = implode($localSeparator,$localArray);
	
		return $result;
	}
	
	
	//for report only
	function formatDate2STDForReport($localDate,$localFormat,&$sepChars='')
	{
		$finalDate=0;
		$localFormat=strtolower($localFormat);
		$splitDate = explode(' ',$localDate);
		
		
		if(!$sepChars) $sepChars=array('-','.','/',':',',');

		if(stristr('0000',$finalDate)) $finalDate=0;


		if(!$finalDate)
		{

			for($i=0;$i<sizeof($sepChars);$i++)
			{
				if(strchr($localDate,$sepChars[$i]))
				{
					$loc_array=explode($sepChars[$i],$localDate);
					break;
				}
			}

			for($i=0;$i<sizeof($sepChars);$i++)
			{
				if(strchr($localFormat,$sepChars[$i]))
				{
					$Format_array=explode($sepChars[$i],$localFormat);
					break;
				}
			}
			 
			/* Detect local format and reformat the local time to DATE standard */
			for($i=0;$i<3;$i++)
			{
				if($Format_array[$i]=='yyyy')   	{
					$vYear = (int)$loc_array[$i];
				}
				elseif($Format_array[$i]=='mm') {
					$vMonth = (int)$loc_array[$i];
				}
				elseif($Format_array[$i]=='dd') {
					$vDay = (int)$loc_array[$i];
				}
			}

			# if invalid numeric return empty string
			if(!is_numeric($vYear)||!is_numeric($vMonth)||!is_numeric($vDay)){
				$finalDate= '';
			}else{
				# DATE standard
				if(strlen($vMonth)==1) $vMonth='0'.$vMonth;
				if(strlen($vDay)==1) $vDay='0'.$vDay;
				$finalDate=$vYear.'-'.$vMonth.'-'.$vDay;
			}

		}
		if(!empty($splitDate[1])) $finalDate = $finalDate." ".$splitDate[1];
		
		return  $finalDate;

	}
	//function to get the total time difference between two times by Swapnil - 01.03.2016
	function getTimeDifference($t1,$t2){
		if($t1 > $t2){
			list($hour,$min) = explode(":",$t1);
			$adjust = 1440 - (($hour * 60) + $min);
			//debug($hour."--".$min."--".$adjust);
			$t1 = "00:00";
			list($shour,$smin) = explode(":",$t2);
			$t2 = (($shour * 60) + $smin) + $adjust;
			$t2 = floor($t2/60).":".($t2%60);
		}
		$result = '';
		$a1 = explode(":",$t1);
		$a2 = explode(":",$t2);
		$time1 = (($a1[0]*60*60)+($a1[1]*60));
		$time2 = (($a2[0]*60*60)+($a2[1]*60));
		$diff = abs($time1-$time2);
		 
		$hours = floor($diff/(60*60));
		$mins = floor(($diff-($hours*60*60))/(60));
		//$secs = floor(($diff-(($hours*60*60)+($mins*60))));
		if($hours > 0){
			$result .= $hours;
		}
		if($mins > 0){
			if($hours ==0){
				$result .= "0";
			}
			$result .= ".".$mins;
		}
		//$result = $hours." hrs".$mins." mins";
		return $result;
	}
	
	//function to calculate the total time in a\hour and minutes using all time array by Swapnil - 01.03.2016
	public function getTotalTime($times=array()){
		foreach ($times as $key => $time){
			list($hours,$mins) = explode(".",$time);
			$totalHour += $hours;
			$totalMin += $mins;
		}
		$hours = $totalHour + floor($totalMin/60);
		$mins = floor($totalMin%60);
		return $hours.".".$mins;
	}
	
	//function to calculate the number of days between two dates including from date by Swapnil - 07.03.2016
	public function getNoOfDays($fromDate,$toDate){
		$datetime1 = new DateTime($toDate);
		$datetime2 = new DateTime($fromDate);
		$interval = $datetime1->diff($datetime2);
		return ($interval->days)+1 ;
	}
	
	/*
	 * function to get the list of dates between two dates
	* @author : Swapnil
	* @created : 18.03.2016
	*/
	public function get_date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' ) {
		$dates = array();
		$current = strtotime($first);
		$last = strtotime($last);
		while( $current <= $last ) {
			$dates[] = date($output_format, $current);
			$current = strtotime($step, $current);
		}
		return $dates;
	}
}
	
