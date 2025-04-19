<?php
/**
 * BarcodeQR - Code QR Barcode Image Generator (PNG)
 *
 * @package BarcodeQR
 * @category BarcodeQR
 * @name BarcodeQR
 * @version 1.0
 * @author Gaurav Chauriya
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 */
 class QRCodeComponent extends Component { 
	/**
	 * Chart API URL
	 */
	const API_CHART_URL = "http://chart.apis.google.com/chart";

	/**
	 * Code data
	 *
	 * @var string $_data
	 */
	private $_data;

	/**
	 * Bookmark code
	 *
	 * @param string $title
	 * @param string $url
	 */
	public function bookmark($title = null, $url = null) {
		$this->_data = "MEBKM:TITLE:{$title};URL:{$url};;";
	}

	/**
	 * MECARD code
	 *
	 * @param string $name
	 * @param string $address
	 * @param string $phone
	 * @param string $email
	 */
	public function contact($name = null, $address = null, $phone = null, $email = null) {
		$this->_data = "MECARD:N:{$name};ADR:{$address};TEL:{$phone};EMAIL:{$email};;";
	}

	/**
	 * Create code with GIF, JPG, etc.
	 *
	 * @param string $type
	 * @param string $size
	 * @param string $content
	 */
	public function content($type = null, $size = null, $content = null) {
		$this->_data = "CNTS:TYPE:{$type};LNG:{$size};BODY:{$content};;";
	}

	/**
	 * Generate QR code image
	 *
	 * @param int $size
	 * @param string $filename
	 * @return bool
	 */
	public function draw($size = 150, $filename = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::API_CHART_URL);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($this->_data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$img = curl_exec($ch);
		curl_close($ch);

		if($img) {
			if($filename) {
				if(!preg_match("#\.png$#i", $filename)) {
					$filename .= ".png";
				}
				
				return file_put_contents($filename, $img);
			} else {
				header("Content-type: image/png");
				print $img;
				return true;
			}
		}

		return false;
	}

	/**
	 * Email address code
	 *
	 * @param string $email
	 * @param string $subject
	 * @param string $message
	 */
	public function email($email = null, $subject = null, $message = null) {
		$this->_data = "MATMSG:TO:{$email};SUB:{$subject};BODY:{$message};;";
	}

	/**
	 * Geo location code
	 *
	 * @param string $lat
	 * @param string $lon
	 * @param string $height
	 */
	public function geo($lat = null, $lon = null, $height = null) {
		$this->_data = "GEO:{$lat},{$lon},{$height}";
	}

	/**
	 * Telephone number code
	 *
	 * @param string $phone
	 */
	public function phone($phone = null) {
		$this->_data = "TEL:{$phone}";
	}

	/**
	 * SMS code
	 *
	 * @param string $phone
	 * @param string $text
	 */
	public function sms($phone = null, $text = null) {
		$this->_data = "SMSTO:{$phone}:{$text}";
	}

	/**
	 * Text code
	 *
	 * @param string $text
	 */
	public function text($text = null) {
		$this->_data = $text;
	}

	/**
	 * URL code
	 *
	 * @param string $url
	 */
	public function url($url = null) {
		$this->_data = preg_match("#^https?\:\/\/#", $url) ? $url : "http://{$url}";
	}

	/**
	 * Wifi code
	 *
	 * @param string $type
	 * @param string $ssid
	 * @param string $password
	 */
	public function wifi($type = null, $ssid = null, $password = null) {
		$this->_data = "WIFI:T:{$type};S{$ssid};{$password};;";
	}
	
	
	/**
	 * Image Comparing Function 
	 * $image1                     STRING/RESOURCE          Filepath and name to PNG or passed image resource handle
	 * $image2                    STRING/RESOURCE          Filepath and name to PNG or passed image resource handle
	 * $RTolerance               INTEGER (0-/+255)     Red Integer Color Deviation before channel flag thrown
	 * $GTolerance               INTEGER (0-/+255)     Green Integer Color Deviation before channel flag thrown
	 * $BTolerance               INTEGER (0-/+255)     Blue Integer Color Deviation before channel flag thrown
	 * $WarningTolerance     INTEGER (0-100)          Percentage of channel differences before warning returned
	 * $ErrorTolerance          INTEGER (0-100)          Percentage of channel difference before error returned
	
	 */
	function imageCompare($image1, $image2, $RTolerance=0, $GTolerance=0, $BTolerance=0, $WarningTolerance=1, $ErrorTolerance=5)
	{
		if (is_resource($image1))
			$im = $image1;
		else
			if (!$im = imagecreatefrompng($image1)){
			 $RET['PercentDifference'] = "Image 1 could not be opened";//trigger_error("Image 1 could not be opened",E_USER_ERROR);
			 return $RET;
			}
		 
		if (is_resource($image2))
			$im2 = $image2;
		else
			if (!$im2 = imagecreatefrompng($image2)){
			$RET['PercentDifference'] = "Image 2 could not be opened";//trigger_error("Image 2 could not be opened",E_USER_ERROR);
			return $RET;
			}
	
	
	
		$OutOfSpec = 0;
	
		if (imagesx($im)!=imagesx($im2))
			die("Width does not match.");
		if (imagesy($im)!=imagesy($im2))
			die("Height does not match.");
	
	
		//By columns
		for ($width=0;$width<=imagesx($im)-1;$width++)
		{
		for ($height=0;$height<=imagesy($im)-1;$height++)
		{
			$rgb = imagecolorat($im, $width, $height);
			$r1 = ($rgb >> 16) & 0xFF;
			$g1 = ($rgb >> 8) & 0xFF;
			$b1 = $rgb & 0xFF;
			 
			$rgb = imagecolorat($im2, $width, $height);
			$r2 = ($rgb >> 16) & 0xFF;
			$g2 = ($rgb >> 8) & 0xFF;
			$b2 = $rgb & 0xFF;
			 
			if (!($r1>=$r2-$RTolerance && $r1<=$r2+$RTolerance))
				$OutOfSpec++;
	
				if (!($g1>=$g2-$GTolerance && $g1<=$g2+$GTolerance))
				$OutOfSpec++;
	
			if (!($b1>=$b2-$BTolerance && $b1<=$b2+$BTolerance))
				$OutOfSpec++;
				 
				 
			}
			}
			$TotalPixelsWithColors = (imagesx($im)*imagesy($im))*3;
	
			$RET['PixelsByColors'] = $TotalPixelsWithColors;
			$RET['PixelsOutOfSpec'] = $OutOfSpec;
	
			if ($OutOfSpec!=0 && $TotalPixelsWithColors!=0)
			{
			$PercentOut = ($OutOfSpec/$TotalPixelsWithColors)*100;
			$RET['PercentDifference']=$PercentOut;
			if ($PercentOut>=$WarningTolerance) //difference triggers WARNINGTOLERANCE%
					$RET['WarningLevel']=TRUE;
					if ($PercentOut>=$ErrorTolerance) //difference triggers ERRORTOLERANCE%
					$RET['ErrorLevel']=TRUE;
		}
	
		RETURN $RET;
			}
	
	
	
}
?>