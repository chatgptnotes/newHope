<?php
class AclArosAco extends AppModel {

	public $name = 'AclArosAco';
        public $useTable = 'aros_acos';
    
        public $belongsTo = array(
        'AclAro' => array(
            'className' => 'Acl.AclAro',
            'foreignKey' => 'aro_id',
        ),
        'AclAco' => array(
            'className' => 'Acl.AclAco',
            'foreignKey' => 'aco_id',
        ),
    );

}
?>