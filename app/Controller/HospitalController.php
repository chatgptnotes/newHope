<?php
/**
 * HospitalController file
 *
 * PHP 5
 *
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Dinesh Tawade
 */
class HospitalController extends AppController {
    public $name = 'Hospital';
    public $uses = array('Hospital'); // Add models used by this controller
    public $helpers = array('Html', 'Form', 'Js', 'DateFormat', 'General');
    public $components = array('RequestHandler', 'Email', 'Cookie', 'ImageUpload', 'QRCode', 'dateFormat', 'GibberishAES');

    /**
     * Index method
     */
    public function index() {
      
    }
     
    public function hospital_status(){
        
    }
    /**
     * Add other methods as needed
     */
}