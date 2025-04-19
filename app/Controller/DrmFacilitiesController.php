<?php
/*
 @author Aditya Vijay
*/
class DrmFacilitiesController extends AppController {
	  public $name = 'DrmFacilities';
      public $helpers = array('Html', 'Form', 'Js', 'Cache');
      public $components = array('RequestHandler', 'Email', 'Session');

	/* to run vedio on Tv...*/
		public function drmVideo(){
			$this->layout="advance";
		}
	/* eod...*/

}