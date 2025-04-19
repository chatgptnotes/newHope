<?php 
/** ClaimTransaction model
*
* PHP 5
*
* @copyright     Copyright 2013 DrM Hope Softwares
* @link          http://www.drmcaduceus.com/
* @package       ClaimTransaction.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pooja
*/
class ClaimTransaction extends AppModel {
	
	public $name = 'ClaimTransaction';

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
}
?>