<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       InventoryPurchaseReturn Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class InventoryPurchaseReturn extends AppModel {
	
	public $name = 'InventoryPurchaseReturn';

	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
	public $belongsTo = array(
		'InventorySupplier' => array(
		'className' => 'InventorySupplier',
		'dependent' => true,
		'foreignKey' => 'party_id',
		)
	); 
   public $hasMany = array(
		'InventoryPurchaseReturnItem' => array(
		'className' => 'InventoryPurchaseReturnItem',
		'dependent' => true,
		'foreignKey' => 'inventory_purchase_return_id',
		)
	); 
}
?>