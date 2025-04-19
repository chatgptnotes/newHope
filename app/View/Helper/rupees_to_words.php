<?php
class RupeesToWordsHelper extends AppHelper {
	public $helpers = array("Session");
	/*
	 * Converts indian rupees to words
	 */
	function no_to_words($no,$is_recursive=false){   
	 	$words = array('0'=> '' ,'1'=> 'One' ,'2'=> 'Two' ,'3' => 'Three','4' => 'Four','5' => 'Five','6' => 'Six',
	 	'7' => 'Seven','8' => 'Eight','9' => 'Nine','10' => 'Ten','11' => 'Eleven','12' => 'Twelve','13' => 'Thirteen','14' => 'Fourteen','15' => 'Fifteen','16' => 'Sixteen','17' => 'Seventeen','18' => 'Eighteen','19' => 'Nineteen','20' => 'Twenty','30' => 'Thirty','40' => 'Fourty','50' => 'Fifty','60' => 'Sixty','70' => 'Seventy','80' => 'Eighty','90' => 'Ninty','100' => 'Hundred','1000' => 'Thousand','100000' => 'Lakh','10000000' => 'Crore');
	 	$currency   = $this->Session->read('Currency.currency') ; 
		 
	    if($no == 0)
	        return ' ';
	    else {
		$novalue='';
		$highno=$no;
		$remainno=0;
		$value=100;
		$addtext='';
		$backtext='';
		$value1=1000;       
	            while($no>=100)    {
	                if(($value <= $no) &&($no  < $value1))    {
	                $novalue=$words["$value"];
	                $highno = (int)($no/$value);
	                $remainno = $no % $value;
	                break;
	                }
	                $value= $value1;
	                $value1 = $value * 100;
	            }       
	          if(array_key_exists("$highno",$words)){
	          	  if(!$is_recursive) $addtext =   ucfirst($currency)." "; 
	          	  if($remainno == 0) $backtext =  " Only";
	              return $textAmt = $addtext.$words["$highno"]." ".$novalue." ".$this->no_to_words($remainno,true).$backtext;
	    	  }else {
	    	  	 if($remainno == 0) $backtext =  " Only";
	    	  	 if(!$is_recursive) $addtext =   ucfirst($currency)." "; 
	             $unit=$highno%10;
	             $ten =(int)($highno/10)*10;            
	           	return  $textAmt = $addtext.$words["$ten"]." ".$words["$unit"]." ".$novalue." ".$this->no_to_words($remainno,true).$backtext;
	           }
	           
	           
	    }
	}
#echo no_to_words(12345401);
}