<?php
/**
 * Ambulance Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Facility.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Dinesh tawade
 */

App::uses('AppModel', 'Model');

class Ambulance extends AppModel {
    public $name = 'Ambulance';
   Public $useDbConfig = 'defaultHospital';
    public $validate = array(
        'first_name' => array(
            'rule' => 'notEmpty',
            'message' => 'First name is required'
        ),
        'last_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Last name is required'
        ),
        'public_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Public name is required'
        ),
        'ambulance_type' => array(
            'rule' => 'notEmpty',
            'message' => 'Ambulance type is required'
        ),
        'ambulance_model' => array(
            'rule' => 'notEmpty',
            'message' => 'Ambulance model is required'
        ),
        'number_plate' => array(
            'rule' => 'notEmpty',
            'message' => 'Number plate is required'
        ),
        'ambulance_color' => array(
            'rule' => 'notEmpty',
            'message' => 'Ambulance color is required'
        ),
        'mobile_number' => array(
            'rule' => array('custom', '/^[0-9]{10}$/'),
            'message' => 'Please enter a valid mobile number'
        ),
        'email' => array(
            'rule' => 'email',
            'allowEmpty' => true,
            'message' => 'Please enter a valid email address'
        ),
        'photo' => array(
            'rule' => 'notEmpty',
            'message' => 'Please upload your photo'
        ),
        'ambulance_photo' => array(
            'rule' => 'notEmpty',
            'message' => 'Please upload a photo of your ambulance'
        ),
        'aadhaar_front' => array(
            'rule' => 'notEmpty',
            'message' => 'Please upload your Aadhaar card front'
        ),
        'aadhaar_back' => array(
            'rule' => 'notEmpty',
            'message' => 'Please upload your Aadhaar card back'
        ),
        'license' => array(
            'rule' => 'notEmpty',
            'message' => 'Please upload your driver’s license'
        ),
        'vehicle_rc' => array(
            'rule' => 'notEmpty',
            'message' => 'Please upload your vehicle’s registration certificate'
        ),

          'call_assigned_to' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select who the call is assigned to.'
        ),
        'call_timestamp' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select a timestamp for the call.'
        ),
        'disposition' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select a disposition.'
        )
        // Add more validation rules as required
    );
}
