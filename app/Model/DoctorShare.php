<?php

/** DoctorShare model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 DrM Hope Softwares
 * @link          http://www.drmcaduceus.com/
 * @package       DoctorShare.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 */
class DoctorShare extends AppModel {

    public $name = 'DoctorShare';
    public $specific = true;

    function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
        $this->db_name = $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
    /**
     * function to update doctor share
     * @author Gaurav Chauriya <gauravc@drmhope.com>
     */
    public function updateShare($data = array()){
        $session = new cakeSession();
        $data['location_id']  = $session->read('locationid');
        if($data['id']){
            $data['modified_by'] = $session->read('userid');
            $data['modify_time'] = date('Y-m-d H:i:s');
        }else{
            $data['created_by'] = $session->read('userid');
            $data['create_time'] = date('Y-m-d H:i:s');
        }
        $this->save($data);
        $data['id'] = $this->id;
        return $data;
    }
}