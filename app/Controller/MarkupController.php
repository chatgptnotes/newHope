<?php
/**
 * CostCenterController 
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       CostCenter Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        
 */
class MarkupController extends AppController {

	public $name = 'Markup';
	public $uses = array('Markup');
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General');
	public $components = array('RequestHandler','Email');

	public function admin_index(){


	}
	 public function admin_add(){
	 	
	 }
	 
	 public function admin_edit(){
	 	
	 }
	
	
	
}