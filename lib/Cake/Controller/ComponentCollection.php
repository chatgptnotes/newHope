<?php
/**
 * Components collection is used as a registry for loaded components and handles loading
 * and constructing component class objects.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('ObjectCollection', 'Utility');
App::uses('Component', 'Controller');

class ComponentCollection extends ObjectCollection {

/**
 * The controller that this collection was initialized with.
 *
 * @var Controller
 */
	protected $_Controller = null;

/**
 * Initializes all the Components for a controller.
 * Attaches a reference of each component to the Controller.
 *
 * @param Controller $Controller Controller to initialize components for.
 * @return void
 */
	public function init(Controller $Controller) {
		if (empty($Controller->components)) {
			return;
		}
		$this->_Controller = $Controller;
		$components = ComponentCollection::normalizeObjectArray($Controller->components);
		
		/** Pawan Meshram For autocomplete ajax
		 * Laoding userdeifined helpers,components
		 */
		if(in_array($Controller->request['action'], $Controller->autoCompleteComponentLoader['default'])){
			$allowedComponents = array('Auth');
		}else if(in_array($Controller->request['action'], $Controller->autoCompleteComponentLoader['session'])){
			$allowedComponents = array('Auth','Session');
		}else if(in_array($View->request['action'], $Controller->autoCompleteComponentLoader['dateSession'])){
			$allowedComponents = array('Auth','Session','DateFormat','General');
		}else if(in_array($Controller->request['action'], $Controller->autoCompleteComponentLoader['date'])){
			$allowedComponents = array('Auth','DateFormat','General');
		}elseif($Controller->request->isAjax()){
			$allowedComponentsDeny = array('Acl','AclFilter',"Menu",'DebugKit.Toolbar');
			$deniedComponents = array('Menu'); //added by pankaj to skip menu for all ajax request.
		}
		 
		$exceptionArray = $Controller->autoCompleteComponentLoader['exceptionsForAjaxMenu']; 
		 
		if(in_array(trim($Controller->request['action']),$exceptionArray/* array('AddSample') */)){ 
				$deniedComponents = array('Menu');
		}
		$Controller->request->autocompleteActionsHelper = $Controller->autoCompleteHelperLoader;
		$Controller->request->autocompleteActionsHelperExceptions = $Controller->exceptionForPermissions;
		 
		foreach ($components as $name => $properties) {
			if((count($allowedComponents) > 0) && $Controller->request->isAjax() && (count($deniedComponents) == 0)){
				if(in_array($name, $allowedComponentsDeny)) continue;
				if(!in_array($name, $allowedComponents)) continue;
			}
			//added by pankaj 
			if(!empty($deniedComponents)){ //to skip menu component is requested action
				if(in_array($name, $deniedComponents)) continue;
			}
			$Controller->{$name} = $this->load($properties['class'], $properties['settings']);
		}
	}

/**
 * Get the controller associated with the collection.
 *
 * @return Controller.
 */
	public function getController() {
		return $this->_Controller;
	}

/**
 * Loads/constructs a component.  Will return the instance in the registry if it already exists.
 * You can use `$settings['enabled'] = false` to disable callbacks on a component when loading it.
 * Callbacks default to on.  Disabled component methods work as normal, only callbacks are disabled.
 *
 * You can alias your component as an existing component by setting the 'className' key, i.e.,
 * {{{
 * public $components = array(
 *   'Email' => array(
 *     'className' => 'AliasedEmail'
 *   );
 * );
 * }}}
 * All calls to the `Email` component would use `AliasedEmail` instead.
 *
 * @param string $component Component name to load
 * @param array $settings Settings for the component.
 * @return Component A component object, Either the existing loaded component or a new one.
 * @throws MissingComponentException when the component could not be found
 */
	public function load($component, $settings = array()) {
		if (is_array($settings) && isset($settings['className'])) {
			$alias = $component;
			$component = $settings['className'];
		}
		list($plugin, $name) = pluginSplit($component, true);
		if (!isset($alias)) {
			$alias = $name;
		}
		if (isset($this->_loaded[$alias])) {
			return $this->_loaded[$alias];
		}
		$componentClass = $name . 'Component';
		App::uses($componentClass, $plugin . 'Controller/Component');
		if (!class_exists($componentClass)) {
			throw new MissingComponentException(array(
				'class' => $componentClass
			));
		}
		$this->_loaded[$alias] = new $componentClass($this, $settings);
		$enable = isset($settings['enabled']) ? $settings['enabled'] : true;
		if ($enable === true) {
			$this->_enabled[] = $alias;
		}
		return $this->_loaded[$alias];
	}

}