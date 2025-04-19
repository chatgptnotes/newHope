<?php
/**
 * FacilityModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope Hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class FacilityDatabaseMapping extends AppModel {

	public $name = 'FacilityDatabaseMapping';
 
        public $belongsTo = array('Facility' => array('className'    => 'Facility',
                                                  'foreignKey'    => 'facility_id'
                                                 ),
                                
                                 );
       

       
}
?>