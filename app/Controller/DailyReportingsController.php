<?php
/**
 * This is roles controller file.
 *
 * Use to create/edit/view/delete roles
 * created : 16 Nov
 */
class DailyReportingsController extends AppController {

	public $name = 'DailyReportings';
	public $uses = array('DailyReporting');
	public $helpers = array('Html','Form', 'Js'); 
	public $components = array('RequestHandler','Email');


/***
	@Action: form
	@access : Public
	@created : 2/1/2012
	@modified:
***/

public function form(){
	$this->set('title_for_layout', __('Daily Reporting By CMO', true));
}

}
