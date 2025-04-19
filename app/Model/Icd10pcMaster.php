<?php
/**
 * 
  PHP 5
 *
 * @link          http://www.drmcadecueus.com/
 * @package       Icd10.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 */
class Icd10pcMaster extends AppModel {

    public $specific = true;
    public $name = 'Icd10pcMaster';
    var $useTable = 'icd10pc_masters';
    
    function __construct($id = false, $table = null, $ds = null) {
    	$session = new cakeSession();
    	$this->db_name =  $session->read('db_name');
    	parent::__construct($id, $table, $ds);
    }
}
