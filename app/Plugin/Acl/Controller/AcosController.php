<?php
/**
 *
 * @author   Nicolas Rod <nico@alaxos.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.alaxos.ch
 */
class AcosController extends AclAppController {

	public $name = 'Acos';
	public $uses       = array('Role','User');
	//var $components = array('Acl', 'Acl.AclManager');
	 
	public function admin_index()
	{
	     $this->redirect('/admin/acl/aros');
	}
	
	public function admin_empty_acos($run = null)
	{
	    if(isset($run))
	    {
    		if($this->Aco->deleteAll(array('id > 0')))
    	    {
    	        $this->Session->setFlash(__d('acl', 'The ACO table has been cleared', true), 'flash_message', null, 'plugin_acl');
    	    }
    	    else
    	    {
    	        $this->Session->setFlash(__d('acl', 'The ACO table could not be cleared', true), 'flash_error', null, 'plugin_acl');
    	    }
    	    
    	    $this->set('run', true);
	    }
	    else
	    {
	        $this->set('run', false);
	    }
	}
	
	public function admin_build_acl($run = null)
	{
	    if(isset($run))
	    {
    		$logs = $this->AclManager->create_acos();
    		
    		$this->set('logs', $logs);
    		$this->set('run', true);
	    }
	    else
	    {
	        $this->set('run', false);
	    }
	}

	public function admin_user_freindly_name()
	{
		$this->loadModel("Aco");
	 	$methods = $this->Aco->find("all",array("conditions"=>array('parent_id !='=>"1","is_viewable"=>"1")));
 		 if ($this->request->is('post')) {
		 foreach ($this->request->data['label'] as $key =>$value) {
		
				$this->Aco->id = $key;
				$this->request->data['Aco']['label'] = $value;
				$this->request->data['Aco']['desc'] = $this->request->data['desc'][$key];
				$this->Aco->save($this->request->data);
			}
 			$this->redirect('/admin/acl/acos/user_freindly_name');
		 
		 }
	   
	    $this->set('actions', $methods);
	}
}
?>