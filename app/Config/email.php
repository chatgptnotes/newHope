<?php
/**
 * This is email configuration file.
 *
 * Use it to configure email transports of Cake.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * In this file you set up your send email details.
 *
 * @package       cake.config
 */
/**
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *		Mail 		- Send using PHP mail function
 *		Smtp		- Send using SMTP
 *		Debug		- Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email.  Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 *
 */
class EmailConfig {
	
	
	public $default2 = array(
			'transport' => 'smtp_old',
			'from' => array('info@drmhope.com' => 'DRMHope'),
			'host' => 'smtp.mailgun.org',
			'port' => 587,
			'timeout' => 30,
			'username' => 'info@drmhope.com',
			'password' => 'hope123',
			'client' => null,
			'log' => false,
	);
	
	public $default = array(
		'transport' => 'Smtp',
		'from' => array('noreply@gmail.com' => 'DRM Hope'),
		'host' => 'sandbox.smtp.mailtrap.io',
		'port' => 2525,
		'timeout' => 30,
		'username' => 'cd41b607e93704',
		'password' => '7052fdbd71f003',
		'client' => null,
		'log' => true,
		'tls'=> true
	);
	
	public $test = array(
		'log' => true
	);
	
	public $smtp = array(
			'transport' => 'Smtp',
			'from' => array('info@drmhope.com' => 'DRM Hope'),
			'host' => 'smtp.drmhope.com',
			'port' => 25,
			//'timeout' => 30,
			'username' => 'info@drmhope.com',
			'password' => 'hopehospital',
			'client' => null,
			'log' => false,
			//'charset' => 'utf-8',
			//'headerCharset' => 'utf-8',
	);
	
	public $gmail = array(
			'host' => 'ssl://smtp.gmail.com',
			'port' => 465,
			'username' => 'pankajw@drmhope.com',
			'password' => 'hopehospital',
			'transport' => 'Smtp'
	);
	

	public $fast = array(
		'from' => 'you@localhost',
		'sender' => null,
		'to' => null,
		'cc' => null,
		'bcc' => null,
		'replyTo' => null,
		'readReceipt' => null,
		'returnPath' => null,
		'messageId' => true,
		'subject' => null,
		'message' => null,
		'headers' => null,
		'viewRender' => null,
		'template' => false,
		'layout' => false,
		'viewVars' => null,
		'attachments' => null,
		'emailFormat' => null,
		'transport' => 'Smtp',
		'host' => 'localhost',
		'port' => 25,
		'timeout' => 30,
		'username' => 'user',
		'password' => 'secret',
		'client' => null,
		'log' => true,
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);

}
