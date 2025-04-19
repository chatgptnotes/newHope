<?php
class OptTable extends AppModel {

	public $name = 'OptTable';
	public $belongsTo = array('Opt' => array('className'    => 'Opt',
                                                  'foreignKey'    => 'opt_id'
                                                 )
                                 );
        public $validate = array(
		        'opt_id' => array(
			    'rule' => "notEmpty",
			    'message' => "Please select OPT."
			    ),
		        'number' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter number."
			    ),
                        'name' => array(
			    'rule' => array('checkUnique'),
			    'message' => "Please enter unique name."
			    ),
                         'description' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter description."
			    )
		        
                );
	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
	
public function checkUnique($check) {
                //$check will have value: array('username' => 'some-value')
                
                //$check = array('Opt.name' => $check['name']);
                if(isset($this->data['OptTable']['id'])) {
                 $extraContions = array('OptTable.is_deleted' => 0, 'OptTable.id <>' => $this->data['OptTable']['id'], 'opt_id' => $this->data['OptTable']['opt_id']);
                } else {
                 $extraContions = array('OptTable.is_deleted' => 0, 'opt_id' => $this->data['OptTable']['opt_id']);
                }
                $conditonsval = array_merge($check,$extraContions);
                $countOT = $this->find( 'count', array('conditions' => $conditonsval, 'recursive' =>-1)); 
                if($countOT >0) {
                  return false;
                } else {
                  return true;
                }
        }
/**
 * for delete opt table.
 *
 */

      public function deleteOptTable($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["OptTable"]["id"] = $postData['pass'][0];
      	$this->data["OptTable"]["is_deleted"] = '1';
      	$this->save($this->data);
      	return true;
      }		
	
}
?>