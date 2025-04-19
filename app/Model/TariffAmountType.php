<?php
class TariffAmountType extends AppModel {

	 public $name = 'TariffAmountType';
	 public $useTable = 'tariff_amount_types';
        public $specific = true;
	    function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  

}
?>

