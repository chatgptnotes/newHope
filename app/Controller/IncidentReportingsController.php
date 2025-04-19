<?php
/**
 * This is roles controller file.
 *
 * Use to create/edit/view/delete roles
 * created : 16 Nov
 */
class IncidentReportingsController extends AppController {

	public $name = 'IncidentReportings';
	public $uses = array('IncidentReporting');
	public $helpers = array('Html','Form', 'Js'); 
	public $components = array('RequestHandler','Email');


/***
	@Action: form
	@access : Public
	@created : 2/1/2012
	@modified:
***/

public function form(){
	$this->set('title_for_layout', __('Incident Reporting', true));
}

}
