<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       InventoryPurchaseDetai Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class InventoryPurchaseDetail extends AppModel {
	
	public $name = 'InventoryPurchaseDetail';

	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
	public $hasMany = array(
		'InventoryPurchaseItemDetail' => array(
		'className' => 'InventoryPurchaseItemDetail',
		'dependent' => true,
		'foreignKey' => 'inventory_purchase_detail_id',
		),
		'InventoryPurchaseReturn' => array(
		'className' => 'InventoryPurchaseReturn',
		'dependent' => true,
		'foreignKey' => 'inventory_purchase_detail_id',
		),
	); 
	public $belongsTo = array(
		'InventorySupplier' => array(
		'className' => 'InventorySupplier',
		'foreignKey' => 'party_id'
		)
	); 
}
?>