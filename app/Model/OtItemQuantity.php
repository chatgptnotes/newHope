<?php
class OtItemQuantity extends AppModel {

	public $name = 'OtItemQuantity';
	public $belongsTo = array('OtItem' => array('className'    => 'OtItem',
                                                  'foreignKey'    => 'ot_item_id'
                                                 ),
                               'OtItemCategory' => array('className'    => 'OtItemCategory',
                                                  'foreignKey'    => 'ot_item_category_id',
                                                  
                                                 ),
                               'PharmacyItem' => array('className'    => 'PharmacyItem',
                                                  'foreignKey'    => false,
                                                  'conditions' => array('PharmacyItem.id=OtItem.pharmacy_item_id')
                                                 )
                                 );
        public $validate = array(
		        'ot_item_id' => array(
			    'rule' => "notEmpty",
			    'message' => "Please select Ot Item."
			    ),
		        'number' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter quantity."
			    )
               );
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
	
	
}
?>