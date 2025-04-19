<?php
/**
 * UserDashboardChart Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2014 DrmHope Software.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       UserDashboardChart.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class UserDashboardChart extends AppModel {
    public $name = 'UserDashboardChart';
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
}
