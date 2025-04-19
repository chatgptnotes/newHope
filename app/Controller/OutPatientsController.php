<?php
/**
 * OutPatientController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 DrmHope Software.  (http://www.drmhope.com/)
 * @package       Out Patient Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj Wanjari
 */

class OutPatientsController extends AppController {	
	public $name = 'OutPatients';
	function index(){
		//$this->render('frontdesk_opd_patient') ;
		//$this->render('add?type=OPD') ; //registration
		$this->redirect(array("controller" => "patients", "action" => "add",'?type=OPD'));
	}
}