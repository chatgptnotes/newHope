<?php
/**
 *  Controller : ccda
 *  Use : AEDV
 *  @created by :gulshan
 *  functions : ccda
 *  date : 26 Aug 2013
 *
 **/


class QrdaController extends AppController {

	public $name = 'Qrda';
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General');
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat');

	public function index(){
		$qrdabody=$this->Qrda->qrdaBody();
	}
	public function continuousExample(){
		$qrdaContinuousBody=$this->Qrda->qrdaContinuousBody();
	}
	public function patientQrda(){
		$patientQrdaBody=$this->Qrda->patientQrdaBody();
	}
}
?>
