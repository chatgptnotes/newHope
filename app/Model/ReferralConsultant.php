
<?php

App::uses('AppModel', 'Model');

/**
 * Beneficiary Model
 *
 */
class ReferralConsultant extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $useTable = 'referral_consultants';
    Public $useDbConfig = 'defaultHospital';

    public $name = 'ReferralConsultant';
   

}

?>