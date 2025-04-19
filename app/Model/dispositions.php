<?php
App::uses('AppModel', 'Model');

class Disposition extends AppModel {
    public $name = 'Disposition';
    public $useTable = 'dispositions';

    // Define the relationship with the Ambulance model
    public $belongsTo = array(
        'Ambulance' => array(
            'className' => 'Ambulance',
            'foreignKey' => 'ambulance_id'
        )
    );

    // Validation rules for the Disposition fields
    public $validate = array(
        'call_assigned_to' => array(
            'rule' => 'notEmpty',
            'message' => 'Please assign the call to someone.'
        ),
        'call_timestamp' => array(
            'rule' => 'datetime',
            'message' => 'Please enter a valid date and time for the call.'
        ),
        'disposition' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select a disposition.'
        ),
        'sub_disposition' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select a sub-disposition.'
        ),
        'outcome' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select an outcome.'
        ),
        'follow_up_date' => array(
            'rule' => 'date',
            'message' => 'Please select a valid follow-up date.'
        ),
        'remark' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter a remark.'
        )
    );
}
