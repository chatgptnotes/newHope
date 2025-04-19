<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
 // echo $this->Html->script(array('jquery-1.5.1.min','fullcalendar','validationEngine.jquery','date.js','jquery.datePicker.js','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
?>
<style>
.message{
	 /*background:#acc586;
	 padding:7px 13px;
	 border:1px solid #c0dc96;
	 font-size:13px;
	 color:#2e4c00;
	 font-weight:bold;
	 text-shadow:1px 1px 1px #c3dba0;
	 margin: 5px 0;
	 display:block;
	 text-align:center;*/
	 
	background-color: #ebf8a4;
    background-image: url("../../../theme/Black/img/icons/tick.png");
    background-position: 2px 40%;
    background-repeat: no-repeat;
    border: 1px solid #a2d246;
    border-radius: 5px;
    box-shadow: 0 1px 1px #ffffff inset;
    color: #515151; 
    font-weight: normal;
    left: 40%;
    margin: 0 auto;
    padding: 5px 0 5px 18px;
    position: absolute;
    top: 0;
    z-index: 2000;
}

.error{
	 background:#d7c487;
	 padding:7px 5px;
	 border:1px solid #e8d495;
	 font-size:13px;  
	 color:#8c0000;
	 font-weight:bold;
	 text-shadow:1px 1px 1px #ecdca8;
	 margin: 5px 0;
	 display:block;
	 text-align:center;
	 left: 40%;
     margin: 0 auto;
     padding: 5px 0 5px 18px;
     position: absolute;
     top: 0;
     z-index: 2000;
}

#busy-indicator {
	display: none;
	position: fixed;
	left: 50%;
	top: 50%;
	z-index: 10000;
}
</style>
<?php echo $this->Session->flash(); ?>
	 
	<div align="center" id = 'busy-indicator'>	
		&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
	</div>

<?php echo $content_for_layout; ?>   