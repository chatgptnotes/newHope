<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	//Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
		//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	   //Router::connect('/', array('controller' => 'sessions', 'action' => 'index'));
        Router::connect('/', array('controller' => 'users', 'action' => 'login'));
        
        
          Router::redirect('/pages/about_us', 'http://www.drmhope.com/about-us.html', array('status' => 302));
          Router::redirect('/pages/patient_portal', 'http://www.drmhope.com/solutions/ambulatory-solutions/patient-portal.html', array('status' => 302));
		  Router::redirect('/pages/ambulatory_emr', 'http://www.drmhope.com/solutions/ambulatory-solutions/ambulatory-emr.html', array('status' => 302));
          Router::redirect('/pages/hosptal_info_manage', 'http://www.drmhope.com/solutions/hospital-solutions/hospital-information-management.html', array('status' => 302));
          Router::redirect('/pages/impatient_emr', 'http://www.drmhope.com/solutions/hospital-solutions/inpatient-emr.html', array('status' => 302));
          Router::redirect('/pages/public_health', 'http://www.drmhope.com/solutions/public-sector-solutions/public-health.html', array('status' => 302));
          Router::redirect('/pages/telemedecine', 'http://www.drmhope.com/solutions/public-sector-solutions/telemedicine.html', array('status' => 302));
          Router::redirect('/pages/ot_s_m', 'http://www.drmhope.com/solutions/specialty-solutions/ot-scheduling-and-management.html', array('status' => 302));
          Router::redirect('/pages/dental', 'http://www.drmhope.com/solutions/specialty-solutions/dental.html', array('status' => 302));
          Router::redirect('/pages/physio', 'http://www.drmhope.com/solutions/specialty-solutions/physiotherapy.html', array('status' => 302));
          
          Router::redirect('/pages/obest_gyna', 'http://www.drmhope.com/solutions/specialty-solutions/obstetrics-gynecology.html', array('status' => 302));
          Router::redirect('/pages/opth', 'http://www.drmhope.com/solutions/specialty-solutions/ophthalmology.html', array('status' => 302));
          Router::redirect('/pages/oncology', 'http://www.drmhope.com/solutions/specialty-solutions/oncology.html', array('status' => 302));
          Router::redirect('/pages/cardio', 'http://www.drmhope.com/solutions/specialty-solutions/cardiology.html', array('status' => 302));
          Router::redirect('/pages/story_so_far', 'http://www.drmhope.com/story-so-far.html', array('status' => 302));
          Router::redirect('/pages/consulting_implement', 'http://www.drmhope.com/services/consulting-implementation.html', array('status' => 302));
          Router::redirect('/pages/healthcare_itservice', 'http://www.drmhope.com/services/healthcare-it-services.html', array('status' => 302));
          Router::redirect('/pages/hats', 'http://www.drmhope.com/services/healthcare-application-training-services.html', array('status' => 302));
          Router::redirect('/pages/infra_support', 'http://www.drmhope.com/services/infrastructure-support-services.html', array('status' => 302));
          Router::redirect('/pages/partnership', 'http://www.drmhope.com/partners/partnerships.html', array('status' => 302));
         
          Router::redirect('/pages/be_our_partner', 'http://www.drmhope.com/partners/be-our-partner.html', array('status' => 302)); 
          Router::redirect('/pages/comp_awards_certi', 'http://www.drmhope.com/company/company-awards.html', array('status' => 302));
          Router::redirect('/pages/free_emr', 'http://www.drmhope.com/benefits/free-emr.html', array('status' => 302));
          Router::redirect('/pages/web_based', 'http://www.drmhope.com/benefits/web-based.html', array('status' => 302)); 
          Router::redirect('/pages/earn_money', 'http://www.drmhope.com/benefits/earn-stimulus-money.html', array('status' => 302));
          Router::redirect('/pages/emr_software', 'http://www.drmhope.com/benefits/emr-software.html', array('status' => 302));
          Router::redirect('/pages/stay_secure', 'http://www.drmhope.com/benefits/stay-secure.html', array('status' => 302));
          Router::redirect('/pages/emr_comparison', 'http://www.drmhope.com/benefits/emr-comparison.html', array('status' => 302));
          Router::redirect('/pages/support', 'http://www.drmhope.com/benefits/unlimited-support.html', array('status' => 302));
          Router::redirect('/pages/adverse_events', 'http://www.drmhope.com/benefits/innovations/adverse-events.html', array('status' => 302));
          
          Router::redirect('/pages/support_portal', 'http://www.drmhope.com/benefits/innovations/support-portal.html', array('status' => 302));
          Router::redirect('/pages/language_interpreters', 'http://www.drmhope.com/benefits/innovations/language-interpreter.html', array('status' => 302));
          Router::redirect('/pages/smartroom', 'http://www.drmhope.com/benefits/innovations/smartest-room.html', array('status' => 302));
          Router::redirect('/pages/vap_monitor', 'http://www.drmhope.com/benefits/innovations/vap-quality-monitor.html', array('status' => 302));
          Router::redirect('/pages/dshbrd', 'http://www.drmhope.com/benefits/innovations/dashboards.html', array('status' => 302));
        

       
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';

