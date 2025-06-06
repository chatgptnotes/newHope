<?php
class WorldTimeHelper extends AppHelper{
	 
	// timezone adjustment in seconds
	private $timezone = 0;

	// time server response
	private $response = false;

	// time server result in seconds
	private $result = 0;
	
	// time server host being queried
	private $selected;

	// time server port
	private $port = 37;
	
	// time servers
	private $host = array(
		'nist1-ny.ustiming.org',
		'nist1-nj.ustiming.orgv',
		'nist1-pa.ustiming.org',
		'time-a.nist.gov',
		'time-b.nist.gov',
		'nist1.aol-va.symmetricom.com',
		'nist1.columbiacountyga.gov',
		'nist1-atl.ustiming.org',
		'nist1-chi.ustiming.org',
		'nist1.expertsmi.com',
		'nist.netservicesgroup.com',
		'nisttime.carsoncity.k12.mi.us',
		'wwv.nist.gov',
		'time-a.timefreq.bldrdoc.gov',
		'time-b.timefreq.bldrdoc.gov',
		'time-c.timefreq.bldrdoc.gov',
		'time.nist.gov',
		'utcnist.colorado.edu',
		'utcnist2.colorado.edu',
		'ntp-nist.ldsbc.edu',
		'nist1-lv.ustiming.org',
		'time-nw.nist.gov',
		'nist1.aol-ca.symmetricom.com',
		'nist1.symmetricom.com',
		'nist1-sj.ustiming.org',
		'nist1-la.ustiming.org'
	);

	// }}
	// {{ constructor
	public function __construct() {
		$this->setTimeZone( 0 );
		return true;
	}
	
	// }}
	// {{ set timezone
	public function setTimeZone( $adjust = 0 ) {
		$this->timezone = $adjust;
	}
	
	// }}
	// {{ get timezone
	public function getTimeZone() {
		return $this->timezone;
	}

	// }}
	// {{ get port
	public function getPort() {
		return $this->port;
	}

	// }}
	// {{ get selected host
	public function getHost() {
		return $this->selected;
	}

	// }}
	// {{ return number of available time servers
	public function getServerCount() {
		$count = sizeof( $this->host );
		return $count;
	}
	
	// }}
	// {{ query selected time server
	public function query() {
		for ($i=0; $i<$this->getServerCount(); $i++) {
			$server = $this->host[$i];
			$this->selected = $server;
			$fp = fsockopen($server, $this->port, $errno, $errstr, 30);
			if (!$fp) {} else {
				$data = NULL;
				while (!feof($fp)) $data .= fgets($fp, 128);
				fclose($fp);
				if (strlen($data) != 4) { // invalid response; try next host until list is depleted
				} else {
					$this->response = true;
					break;
				}
			}
		}
		return $this->processResponse( $data );
	}
	
	// }}
	// {{ process response
	private function processResponse( $data ) {
		if ($this->response) {
			// process time server response
			$ntp_time = (ord($data{0})*pow(256,3))+(ord($data{1})*pow(256,2))+(ord($data{2})*pow(256,1))+(ord($data{3})*pow(256,0));
			// convert seconds to the present seconds
			$time_filter = $ntp_time - 2840140800; // 2840140800 = Thu, 1 Jan 2060 00:00:00 UTC
			$time_now = $time_filter + 631152000; // 631152000  = Mon, 1 Jan 1990 00:00:00 UTC
			// add timezone in seconds
			$time_now = $time_now + ($this->timezone * 3600);
			// result in seconds
			$this->setResult( $time_now );
			return true;
		} else {
			return false; // no time servers available
		}
	}

	// }}
	// {{ set result
	private function setResult( $result ) {
		$this->result = $result;
	}

	// }}
	// {{ get result
	public function getResult() {
		return $this->result;
	}
	
	// }}
	// {{ magic method: sleep
    public function __sleep() {
        // sleep method should be placed here
    }
    
	// }}
	// {{ magic method: wake up
    public function __wakeup() {
        // wake up method should be placed here
    }	
	
	// }}
	// {{ destructor
	function __destruct() {
		// reserved for codes to run when this object is destructed
		if (isset($this->timezone)) unset($this->timezone);
		if (isset($this->response)) unset($this->response);
		if (isset($this->result)) unset($this->result);
		if (isset($this->selected)) unset($this->selected);
		if (isset($this->port)) unset($this->port);
		if (isset($this->host)) unset($this->host);
	}
}
	
