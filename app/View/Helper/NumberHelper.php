<?php
//helper overrides the default cakephp's numberhelper 


class NumberHelper extends AppHelper {
	public $helpers = array('Html',"Session");
	private $currencyDefaults = '' ;
	
	public function currency($number, $options = array('negative'=>"()")) {
			$currencySymbol  = $this->Session->read('Currency.currency_symbol') ; 
			$currencyCode  = $this->Session->read('Currency.currency_code') ;
			
			$options['wholePosition'] = "before" ;
			
			if(!empty($currencySymbol)){
				$default = $currencySymbol ; 
				$options['wholeSymbol'] = $currencySymbol ;  
			}else{
				$default = $currencyCode ; 
				$options['wholeSymbol'] = $currencyCode ;  
			}
			 
			//$options = array_merge($default, $options);
	
			if (isset($options['before']) && $options['before'] !== '') {
				$options['wholeSymbol'] = $options['before'];
			}
			if (isset($options['after']) && !$options['after'] !== '') {
				$options['fractionSymbol'] = $options['after'];
			}
	
			$result = $options['before'] = $options['after'] = null;
	
			$symbolKey = 'whole';
			if ($number == 0 ) {
				/*if ($options['zero'] !== 0 ) {
					return $options['zero'];
				}*/
				return '0.00';
			} elseif ($number < 1 && $number > -1 ) {
				if ($options['fractionSymbol'] !== false) {
					$multiply = intval('1' . str_pad('', $options['places'], '0'));
					$number = $number * $multiply;
					$options['places'] = null;
					$symbolKey = 'fraction';
				}
			}
	
			$position = $options[$symbolKey.'Position'] != 'after' ? 'before' : 'after';
			 
			$options[$position] = $options[$symbolKey.'Symbol'];
			 
			$abs = abs($number);
			$result = $this->format($abs, $options);
			 
			if ($number < 0 ) {
				if ($options['negative'] == '()') {
					$result = '-(' . $result .')';
				} else {
					$result = $options['negative'] . $result;
				}
			}
			return html_entity_decode($result);
		}
		
	public function format($number, $options = false) {
			$places = 0;
			if (is_int($options)) {
				$places = $options;
			}
	
			$separators = array(',', '.', '-', ':');
	
			$before = $after = null;
			if (is_string($options) && !in_array($options, $separators)) {
				$before = $options;
			}
			$thousands = ',';
			if (!is_array($options) && in_array($options, $separators)) {
				$thousands = $options;
			}
			$decimals = '.';
			if (!is_array($options) && in_array($options, $separators)) {
				$decimals = $options;
			}
	
			$escape = true;
			if (is_array($options)) {
				$options = array_merge(array('before'=>'$', 'places' => 2, 'thousands' => ',', 'decimals' => '.'), $options);
				extract($options);
			}
			
			
			if (is_float($number))//for removing decimal points in charges. pankaj w  & yashwant.
			{
			  $out = $before." ".number_format($number, $places, $decimals, $thousands) . $after;
			}else{
			  $out = $before." ".number_format($number, 0, $decimals, $thousands) . $after;
			}

			//$out = $before." ".number_format($number, $places, $decimals, $thousands) . $after;
	  
			if ($escape) {
				return h($out);
			}
			return $out;
		}

	/**
	 * Formats a number with a level of precision.
	 *
	 * @param float $number	A floating point number.
	 * @param integer $precision The precision of the returned number.
	 * @return float Formatted float.
	 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/number.html#NumberHelper::precision
	 */
	public function precision($number, $precision = 3) {
		return sprintf("%01.{$precision}f", $number);
	}
	
	
	/**
	 * Formats a number into a percentage string.
	 *
	 * @param float $number A floating point number
	 * @param integer $precision The precision of the returned number
	 * @return string Percentage string
	 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/number.html#NumberHelper::toPercentage
	 */
	public function toPercentage($number, $precision = 2) {
		return $this->precision($number, $precision) . '%';
	}
	
	/**
	 * Returns a formatted-for-humans file size.
	 *
	 * @param integer $size Size in bytes
	 * @return string Human readable size
	 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/number.html#NumberHelper::toReadableSize
	 */
	public function toReadableSize($size) {
		switch (true) {
			case $size < 1024:
				return __dn('cake', '%d Byte', '%d Bytes', $size, $size);
			case round($size / 1024) < 1024:
				return __d('cake', '%d KB', $this->precision($size / 1024, 0));
			case round($size / 1024 / 1024, 2) < 1024:
				return __d('cake', '%.2f MB', $this->precision($size / 1024 / 1024, 2));
			case round($size / 1024 / 1024 / 1024, 2) < 1024:
				return __d('cake', '%.2f GB', $this->precision($size / 1024 / 1024 / 1024, 2));
			default:
				return __d('cake', '%.2f TB', $this->precision($size / 1024 / 1024 / 1024 / 1024, 2));
		}
	}
	
	/**
	 * Returns a Accounting Formatted Amount.
	 *@author Amit Jain
	 */
	public function getPriceFormat($amount) {
		if ($amount) {
			return $this->format($amount, array('places'=>2,'before'=>false,'escape'=>false,'decimals'=>'.','thousands'=>','));
		}
	}
}