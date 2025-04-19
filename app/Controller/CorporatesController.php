<?php

/**
 * CorporatesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
App::import('Controller', 'Billings');

class CorporatesController extends BillingsController {

    public $name = 'Corporates';
    public $uses = array('Corporate');
    public $helpers = array('Html', 'Form', 'Js', 'General', 'Number', 'RupeesToWords');
    public $components = array('RequestHandler', 'Email', 'General', 'Number', 'PhpExcel','ImageUpload');

    /**
     * corporate listing
     *
     */
    public function index() {

        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array(
                'Corporate.name' => 'asc'
            ),
            'conditions' => array('Corporate.is_deleted' => 0, 'Corporate.location_id' => $this->Session->read('locationid'))
        );
        $this->set('title_for_layout', __('Corporate', true));
        $this->Corporate->recursive = 0;
        $data = $this->paginate('Corporate');
        $this->set('data', $data);
    }

    /**
     * corporate view
     *
     */
    public function view($id = null) {
        $this->set('title_for_layout', __('Corporate Detail', true));
        if (!$id) {
            $this->Session->setFlash(__('Invalid corporate', true));
            $this->redirect(array("controller" => "corporates", "action" => "index"));
        }
        $this->set('corporate', $this->Corporate->read(null, $id));
    }

    /**
     * corporate add
     *
     */
    public function add() {
        $this->loadModel("CorporateLocation");
        $this->set('title_for_layout', __('Add New Corporate', true));
        if ($this->request->is('post')) {
            $this->request->data['Corporate']['location_id'] = $this->Session->read('locationid');
            $this->request->data['Corporate']['create_time'] = date('Y-m-d H:i:s');
            $this->request->data['Corporate']['created_by'] = $this->Auth->user('id');
            $this->Corporate->create();
            $this->Corporate->save($this->request->data);
            $errors = $this->Corporate->invalidFields();
            if (!empty($errors)) {
                $this->set("errors", $errors);
            } else {
                $this->Session->setFlash(__('The corporate has been saved', true));
                $this->redirect(array("controller" => "corporates", "action" => "index"));
            }
        }
        $this->set('corporatelocation', $this->CorporateLocation->find('list', array('fields' => array('id', 'name'), 'conditions' => array('CorporateLocation.is_deleted' => 0, 'CorporateLocation.location_id' => $this->Session->read('locationid')))));
    }

    /**
     * corporate edit
     *
     */
    public function edit($id = null) {
        $this->uses = array('CorporateLocation');
        $this->set('title_for_layout', __('Edit Corporate Detail', true));
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__('Invalid Corporate', true));
            $this->redirect(array("controller" => "corporates", "action" => "index"));
        }
        if ($this->request->is('post') && !empty($this->request->data)) {
            $this->request->data['Corporate']['location_id'] = $this->Session->read('locationid');
            $this->request->data['Corporate']['modify_time'] = date('Y-m-d H:i:s');
            $this->request->data['Corporate']['modified_by'] = $this->Auth->user('id');
            $this->Corporate->id = $this->request->data["Corporate"]['id'];
            $this->Corporate->save($this->request->data);
            $errors = $this->Corporate->invalidFields();
            if (!empty($errors)) {
                $this->set("errors", $errors);
            } else {
                $this->Session->setFlash(__('The corporate has been updated', true));
                $this->redirect(array("controller" => "corporates", "action" => "index"));
            }
        } else {
            $this->request->data = $this->Corporate->read(null, $id);
        }
        $this->set('corporatelocation', $this->CorporateLocation->find('list', array('fields' => array('id', 'name'), 'conditions' => array('CorporateLocation.is_deleted' => 0))));
    }

    /**
     * corporate delete
     *
     */
    public function delete($id = null) {
        $this->set('title_for_layout', __('Delete Corporate', true));
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for corporate', true));
            $this->redirect(array("controller" => "corporates", "action" => "index"));
        }
        if ($id) {
            $this->Corporate->deleteCorporate($this->request->params);
            $this->Session->setFlash(__('Corporate deleted', true));
            $this->redirect(array("controller" => "corporates", "action" => "index"));
        }
    }

    /**
     * get corporate location by xmlhttprequest
     *
     */
    public function getCorporateLocation() {
        $this->loadModel('CorporateLocation');
        if ($this->params['isAjax']) {
            $this->set('corporatelocation', $this->CorporateLocation->find('all', array('fields' => array('id', 'name'), 'conditions' => array('CorporateLocation.is_deleted' => 0, 'CorporateLocation.credit_type_id' => $this->params->query['credittypeid']))));
            $this->layout = 'ajax';
            $this->render('/Corporates/ajaxgetlocation');
        }
    }

    /*     * *******************************BOF for BHEL report****************** */

    public function admin_bhel_outstanding_report($type = NULL) {
        $this->layout = 'advance';
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Person');
        $tariffID = $this->TariffStandard->getTariffStandardID("BHEL");
        $this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false, 'type' => 'INNER',
                    'conditions' => array('FinalBilling.Patient_id=Patient.id'/* ,'FinalBilling.bill_uploading_date NOT'=>NULL */),
                    'fields' => array('FinalBilling.package_amount', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.bill_number', 'FinalBilling.amount_paid', 'FinalBilling.discharge_date', 'FinalBilling.discharge_date',
                        'FinalBilling.bill_uploading_date', 'FinalBilling.package_amount')),
                'Person' => array('primaryKey' => false,
                    'conditions' => array('Person.id=Patient.person_id'),
                    'fields' => array('Person.relation_to_employee', 'Person.name_of_ip', 'Person.executive_emp_id_no')),
                'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id')),
                )));

        $conditions = array('Patient.tariff_standard_id' => $tariffID, 'Patient.is_hidden_from_report' => 0, 'Patient.is_discharge' => 1, 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid'));
        //6 for Bhel (tariffStandard)
        if (!empty($this->request->query)) {
            unset($conditions['Patient.is_hidden_from_report']);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if (!empty($this->request->query['from'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['to'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
            }

            if ($to)
                $conditions['Patient.form_received_on <='] = $to;
            if ($from)
                $conditions['Patient.form_received_on >='] = $from;
        }

        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.form_received_on', 'Patient.lookup_name', 'FinalBilling.amount_paid', 'Person.relation_to_employee',
                'FinalBilling.bill_number', 'FinalBilling.cmp_amt_paid', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.cmp_paid_date', 'FinalBilling.package_amount', 'FinalBilling.total_amount',
                'FinalBilling.discharge_date', 'Patient.form_received_on', 'Person.name_of_ip', 'FinalBilling.tds', 'FinalBilling.other_deduction', 'FinalBilling.other_deduction_modified',
                'FinalBilling.bill_uploading_date', 'Patient.remark', 'Person.executive_emp_id_no', 'FinalBilling.id', 'PatientDocument.id', 'PatientDocument.filename'),
            'conditions' => $conditions);

        $result = $this->paginate('Patient');
        //debug($result);
        //$result = $this->Patient->find('all',array('fields'=>$fields,'conditions'=>$conditions));
        $this->set(results, $result);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_bhel_outstanding_xls', false);
        }

        $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'), 'conditions' => array('TariffStandard.is_deleted' => 0, /* 'TariffStandard.code_name IS NOT NULL', */'TariffStandard.location_id' => $this->Session->read('locationid'))));
        $this->set('tariffData', $tariffData);
    }

    /*     * *******************************EOF for BHEL report****************** */

    public function admin_bhel_outstanding_xls() {
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling');
        $tariffID = $this->TariffStandard->getTariffStandardID("BHEL");
        $this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));


        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false, 'type' => 'INNER',
                    'conditions' => array('FinalBilling.Patient_id=Patient.id', 'FinalBilling.bill_uploading_date NOT' => NULL),
                    'fields' => array('FinalBilling.package_amount', 'FinalBilling.bill_number', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.amount_paid', 'FinalBilling.discharge_date', 'FinalBilling.discharge_date', 'FinalBilling.cmp_amt_paid', 'FinalBilling.cmp_paid_date',
                        'FinalBilling.bill_uploading_date', 'Finalbilling.package_amount')),
                'Person' => array('primaryKey' => false,
                    'conditions' => array('Person.id=Patient.person_id'),
                    'fields' => 'Person.relation_to_employee', 'Person.name_of_ip', 'Person.executive_emp_id_no'))));


        $conditions = array('Patient.tariff_standard_id' => $tariffID, 'Patient.is_hidden_from_report' => 0, 'Patient.is_discharge' => 1, 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid'));
        //6 for Bhel (tariffStandard)
        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.form_received_on', 'Patient.lookup_name', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.amount_paid', 'Person.relation_to_employee', 'FinalBilling.bill_number', 'FinalBilling.cmp_paid_date',
                'FinalBilling.package_amount', 'FinalBilling.total_amount', 'FinalBilling.discharge_date', 'Patient.form_received_on', 'Person.name_of_ip', 'FinalBilling.tds', 'FinalBilling.other_deduction', 'FinalBilling.bill_uploading_date', 'Patient.remark', 'Person.executive_emp_id_no'),
            'conditions' => $conditions);

        $result = $this->paginate('Patient');

        //$result = $this->Patient->find('all',array('fields'=>$fields,'conditions'=>$conditions));
        //debug($result);
        $this->set(results, $result);

        $this->render('admin_bhel_outstanding_xls', false);
    }

    public function admin_surgeon_payment_report($type = NULL) {
        
        // 	debug($db_connection);exit;
        $this->uses = array('Patient', 'User', 'OptAppointment', 'Surgery', 'DoctorProfile', 'Department');
        	App::import('Vendor', 'DrmhopeDB');
        	$db_connection = new DrmhopeDB($this->Session->read('db_name'));
        $this->layout = 'advance';
        //debug($this->request->query);
        if (!empty($this->request->query)) {

            if (!empty($this->request->query['lookup_name'])) {
                $condition['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if (!empty($this->request->query['fromDate'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['fromDate'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['toDate'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['toDate'], Configure::read('date_format')) . " 23:59:59";
            }

            if ($to)
                $condition['OptAppointment.schedule_date <='] = $to;
            if ($from)
                $condition['OptAppointment.schedule_date >='] = $from;
        }

        $this->OptAppointment->bindModel(array(
            'hasOne' => array('User' => array('foreignKey' => false, 'conditions' => 'User.id= OptAppointment.department_id')),
        /* 'UserAlias'=>array('className'=>'User',"foreignKey"=>false ,
          'conditions'=>array('UserAlias.id=OptAppointment.department_id')) */        ));

        $condition['Patient.location_id'] = $this->Session->read('locationid');
        $condition['Patient.is_discharge'] = '1';
        $condition['Patient.is_deleted'] = '0';
        $condition['Patient.admission_type'] = 'IPD';

        $doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
        // debug($this->User->getAnaesthesistAndNone(true));exit;
        $this->set('doctorlist', $this->User->getSurgeonlist());
        $this->set('departmentlist', $this->User->getAnaesthesistAndNone(true));

        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array('OptAppointment.schedule_date' => 'desc'),
            'fields' => array('OptAppointment.*', 'CONCAT(User.first_name," ",User.last_name) as name', 'User.id', 'DoctorProfile.doctor_name', 'DoctorProfile.user_id', 'DoctorProfile.id', 'Patient.lookup_name', 'Patient.id', 'Patient.doctor_id', 'Surgery.name'), 'conditions' => $condition);
    //   debug($this->paginate('OptAppointment')); exit;
        $data = $this->paginate('OptAppointment'); //debug($data); exit;
        foreach ($data as $key => $value) {
            $OptAppointmentId[] = $data[$key]['OptAppointment']['id'];
        }
        $this->set(array('data' => $data, 'doctors' => $doctors));
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_surgeon_payment_xls');
        }
    }

// function for amount paid for surgeon in report by swati

    public function getSurgeonamt($id, $amount) {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->loadModel('OptAppointment');
        if (!empty($id)) {
            //$id holds the patient's id 
            $this->request->data['OptAppointment']['id'] = $id;
            $this->request->data['OptAppointment']['surgeon_amt'] = $amount;
            $this->OptAppointment->save($this->request->data);  //update the extension_status of patient
        }
    }

    public function getAnaesthesistamt($id, $amount) {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->loadModel('OptAppointment');
        if (!empty($id)) {
            //$id holds the patient's id 
            $this->request->data['OptAppointment']['id'] = $id;
            $this->request->data['OptAppointment']['anaesthesia_cost'] = $amount;
            $this->OptAppointment->save($this->request->data);  //update the extension_status of patient
        }
    }

    public function admin_surgeon_payment_xls() {
        $this->uses = array('Patient', 'User', 'FinalBilling', 'Billing', 'OptAppointment', 'Surgery', 'DoctorProfile', 'Department');

        $this->OptAppointment->bindModel(array(
            'hasOne' => array('User' => array('foreignKey' => false, 'conditions' => 'User.id= OptAppointment.department_id')),
        /* 'UserAlias'=>array('className'=>'User',"foreignKey"=>false ,
          'conditions'=>array('UserAlias.id=OptAppointment.department_id')) */        ));

        $condition['Patient.location_id'] = $this->Session->read('locationid');
        $condition['Patient.is_discharge'] = '1';
        $condition['Patient.is_deleted'] = '0';
        $condition['Patient.admission_type'] = 'IPD';

        $doctors = $this->User->getDoctorsByLocation($this->Session->read('locationid'));
        //debug($this->User->getAnaesthesistAndNone(true));exit;
        $this->set('doctorlist', $this->User->getSurgeonlist());
        $this->set('departmentlist', $this->User->getAnaesthesistAndNone(true));

        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array('OptAppointment.schedule_date' => 'desc'),
            'fields' => array('OptAppointment.*', 'CONCAT(User.first_name," ",User.last_name) as name', 'user.id', 'DoctorProfile.doctor_name', 'DoctorProfile.user_id', 'DoctorProfile.id', 'Patient.lookup_name', 'Patient.id', 'Patient.doctor_id', 'Surgery.name'), 'conditions' => $condition);
        $data = $this->paginate('OptAppointment'); //debug($data); exit;
        foreach ($data as $key => $value) {
            $OptAppointmentId[] = $data[$key]['OptAppointment']['id'];
        }
        $this->set(array('data' => $data, 'doctors' => $doctors));
        $this->render('admin_surgeon_payment_xls', false);
    }

    /*     * ************BOF Swati************** */

    public function admin_company_discharge_report($type = NULL) {
        $this->uses = array('Patient', 'Billing', 'Consultant', 'FinalBilling', 'PharmacySalesBill', 'LabTestPayment', 'RadiologyTestPayment', 'ReffererDoctor', 'TariffStandard',
            'LaboratoryTestOrder', 'ServiceCategory', 'RadiologyTestOrder', 'User', 'ServiceBill');
        //$this->Patient->unBindModel(array('hasMany'=>array('PharmacySalesBill','InventoryPharmacySalesReturn')));
        $this->layout = 'advance';
        $privateID = $this->TariffStandard->getPrivateTariffID();

        $this->Patient->bindModel(
                array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                    'fields' => array('FinalBilling.total_amount')),
                'TariffStandard' => array('foreignKey' => false, 'conditions' => array('TariffStandard.id=Patient.tariff_standard_id'), 'fields' => array('TariffStandard.name')),
                'Billing' => array('foreignKey' => false, 'conditions' => array('Billing.Patient_id=Patient.id'),
                    'fields' => array('Billing.id', 'Billing.patient_id', 'Billing.amount', 'Billing.date', 'Billing.amount_pending', 'Billing.amount_paid', 'Billing.amount_to_pay_today')),
                'User' => array('foreignKey' => false, 'conditions' => array('User.id=Patient.doctor_id')),
                'Consultant' => array('foreignKey' => false, 'conditions' => array('Consultant.id=Patient.consultant_id')),
                'PharmacySalesBill' => array('foreignKey' => false, 'conditions' => array('PharmacySalesBill.patient_id=Patient.id'),
                    'fields' => array('PharmacySalesBill.total')),
                'LaboratoryTestOrder' => array('foreignKey' => false, 'conditions' => array('LaboratoryTestOrder.patient_id=Patient.id'),
                    'fields' => array('LaboratoryTestOrder.amount')),
                'RadiologyTestOrder' => array('foreignKey' => false, 'conditions' => array('RadiologyTestOrder.patient_id=Patient.id'),
                    'fields' => array('RadiologyTestOrder.amount')),
                'LabTestPayment' => array('foreignKey' => false, 'conditions' => array('LabTestPayment.patient_id=Patient.id'),
                    'fields' => array('LabTestPayment.total_amount')),
                'RadiologyTestPayment' => array('foreignKey' => false, 'conditions' => array('RadiologyTestPayment.patient_id=Patient.id'),
                    'fields' => array('RadiologyTestPayment.total_amount'))
                )), false);

        $this->Patient->bindModel(array(
            'hasOne' => array(
                'Initial' => array('foreignKey' => false, 'conditions' => array('Initial.id=User.initial_id'))
                )), false);
        $conditions = array('Patient.location_id' => $this->Session->read('locationid'), 'Patient.is_discharge' => 1, 'Patient.is_deleted' => 0, 'Patient.admission_type' => "IPD",
            'Patient.tariff_standard_id NOT' => $privateID, 'Patient.is_hidden_from_report' => 0);
        if (!empty($this->request->query)) {
            if (!empty($this->request->query['lookup_name'])) {
                if ($this->request->query['lookup_name'] != 'null') {
                    $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
                }
            }

            if (!empty($this->request->query['from'])) {
                if ($this->request->query['from']) {
                    $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
                    $conditions['Patient.discharge_date >='] = $from;
                }
            }

            if (!empty($this->request->query['to'])) {
                if ($this->request->query['to'] != 'null') {
                    $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
                    $conditions['Patient.discharge_date <='] = $to;
                }
            }
        }

        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array('Patient.discharge_date' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.discharge_date', 'Patient.remark', 'FinalBilling.total_amount',
                'CONCAT(User.first_name," ",User.last_name) as name', 'PharmacySalesBill.total', 'LabTestPayment.total_amount',
                'RadiologyTestPayment.total_amount,Billing.patient_id', 'TariffStandard.name', 'Consultant.refferer_doctor_id', 'Consultant.first_name', 'FinalBilling.id',
                'FinalBilling.created_by', 'FinalBilling.bill_uploading_date', 'Patient.discharge_status_company', 'Patient.form_received_on',),
            'conditions' => $conditions, 'group' => array('Billing.patient_id'));


        $result = $this->paginate('Patient');
        //$implantId=$this->ServiceCategory->find('first',array('fields'=>array('id'),'conditions'=>array('ServiceCategory.name LIKE'=>Configure::read('implantsservices'))));

        if (!empty($result)) {
            foreach ($result as $patientKey => $patientValue) {
                $ids[] = $patientValue['Patient']['id'];
                $customArray[$patientValue['Patient']['id']] = $patientValue;
            }
        }
        $ImpAmt = $this->ServiceBill->find('all', array('fields' => array('ServiceBill.patient_id', 'ServiceBill.service_id', 'ServiceBill.no_of_times'),
            'conditions' => array('ServiceBill.patient_id' => $ids,
                'ServiceBill.service_id' => array($implantId['ServiceCategory']['id'])
                , 'ServiceBill.is_deleted' => '0'),
            'group' => array('ServiceBill.patient_id')));
        //debug($ImpAmt);

        $labTotal = $this->LaboratoryTestOrder->find('all', array('fields' => array('SUM(LaboratoryTestOrder.amount) as total',
                'LaboratoryTestOrder.patient_id'),
            'conditions' => array('LaboratoryTestOrder.is_print' => '0', 'LaboratoryTestOrder.patient_id' => $ids), 'group' => array('LaboratoryTestOrder.patient_id')));

        $radTotal = $this->RadiologyTestOrder->find('all', array('fields' => array('SUM(RadiologyTestOrder.amount) as total',
                'RadiologyTestOrder.patient_id'),
            'conditions' => array('RadiologyTestOrder.is_deleted' => '0', 'RadiologyTestOrder.patient_id' => $ids), 'group' => array('RadiologyTestOrder.patient_id')));

        $pharmacyTotal = $this->PharmacySalesBill->find('all', array('fields' => array('SUM(PharmacySalesBill.total) as total',
                'PharmacySalesBill.patient_id'),
            'conditions' => array('PharmacySalesBill.is_deleted' => '0', 'PharmacySalesBill.patient_id' => $ids), 'group' => array('PharmacySalesBill.patient_id')));

        foreach ($labTotal as $labKey => $labValue) {
            $customArray[$labValue['LaboratoryTestOrder']['patient_id']]['LaboratoryTestOrder'] = $labValue[0];
        }
        foreach ($radTotal as $radKey => $radValue) {
            $customArray[$radValue['RadiologyTestOrder']['patient_id']]['RadiologyTestOrder'] = $radValue[0];
        }
        foreach ($pharmacyTotal as $pharmKey => $pharmValue) {
            $customArray[$pharmValue['PharmacySalesBill']['patient_id']]['PharmacySalesBill'] = $pharmValue[0];
        }


        $userName = $this->User->getUserDetails($result[0]['FinalBilling']['created_by']);
        $this->set('userName', $userName['User']['username']);

        /* foreach ($result as $key => $value)
          {
          $patientID[] = $result[$key]['Patient']['id'] ;
          } */
        $this->set(array('results' => $customArray, 'pharmacyTotal' => $pharmacyTotal, 'labTotal' => $labTotal, 'radTotal' => $radTotal));

        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_company_discharge_report_xls', false);
        }
    }

    /*     * ************EOF Atulc************************************************************************************************************************** */

    public function admin_company_discharge_report_xls() {
        $this->uses = array('Patient', 'Billing', 'Consultant', 'FinalBilling', 'PharmacySalesBill', 'LabTestPayment', 'RadiologyTestPayment', 'ReffererDoctor', 'User');

        $this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(
                array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                    'fields' => array('FinalBilling.total_amount')),
                'Billing' => array('foreignKey' => false, 'conditions' => array('Billing.Patient_id=Patient.id'),
                    'fields' => array('Billing.id', 'Billing.patient_id', 'Billing.amount', 'Billing.date', 'Billing.amount_pending', 'Billing.amount_paid', 'Billing.amount_to_pay_today')),
                'Consultant' => array('foreignKey' => false, 'conditions' => array('Consultant.id=Patient.consultant_id')),
                'PharmacySalesBill' => array('foreignKey' => false, 'conditions' => array('PharmacySalesBill.patient_id=Patient.id'),
                    'fields' => array('PharmacySalesBill.total')),
                'LabTestPayment' => array('foreignKey' => false, 'conditions' => array('LabTestPayment.patient_id=Patient.id'),
                    'fields' => array('LabTestPayment.total_amount')),
                'RadiologyTestPayment' => array('foreignKey' => false, 'conditions' => array('RadiologyTestPayment.patient_id=Patient.id'),
                    'fields' => array('RadiologyTestPayment.total_amount'))
                )), false);
        //$result = $this->Patient->find('all',array('conditions'=>array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_discharge'=>1,'Patient.is_deleted'=>0,'Patient.admission_type'=>"IPD"),'order'=>'Billing.date DESC','group'=>array('Billing.patient_id')));
        //$add = $this->Billing->find('all',array('conditions'=>array('patient_id'=>$patientID,'location_id'=>$this->Session->read('locationid'))));
        //$this->set('advancePayment',$add);
        $conditions = array('Patient.location_id' => $this->Session->read('locationid'), 'Patient.is_discharge' => 1, 'Patient.is_deleted' => 0, 'Patient.admission_type' => "IPD",
            'Patient.is_hidden_from_report' => 0, 'Patient.tariff_standard_id NOT' => 7);

        $result = $this->Patient->find('all', array(
            'order' => array('Patient.discharge_date' => 'desc', 'Billing.date' => 'DESC'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.discharge_date', 'Patient.remark', 'FinalBilling.total_amount',
                'CONCAT(Consultant.first_name," ",Consultant.last_name) as full_name', 'PharmacySalesBill.total', 'LabTestPayment.total_amount',
                'RadiologyTestPayment.total_amount,Billing.patient_id', 'Consultant.refferer_doctor_id', 'Consultant.first_name', 'FinalBilling.id',
                'FinalBilling.bill_uploading_date', 'Patient.discharge_status_company', 'Patient.is_hidden_from_report'),
            'conditions' => $conditions, 'group' => array('Billing.patient_id')));


        foreach ($result as $key => $value) {
            $patientID[] = $result[$key]['Patient']['id'];
        }

        $userName = $this->User->getUserDetails($result[0]['FinalBilling']['created_by']);
        $this->set('userName', $userName['User']['username']);
        $this->set('results', $result);
        $this->render('admin_company_discharge_report_xls', false);
    }

    /*     * ************EOF Atulc************************************************************************************************************************** */

    //admin_discharge_report_all

    public function admin_company_discharge_report_all($type = NULL) {
        $this->uses = array('Patient', 'Billing', 'FinalBilling', 'TariffStandard');
        $this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
        $this->layout = 'advance';
        $this->Patient->bindModel(
                array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id')),
                'Billing' => array('foreignKey' => false, 'conditions' => array('Billing.Patient_id=Patient.id')),
                'TariffStandard' => array('foreignKey' => false, 'conditions' => array('TariffStandard.id=Patient.Tariff_standard_id'))
                )), false);

        $conditions = array('Patient.location_id' => $this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => "IPD");
        if (!empty($this->request->query)) {
            if (!empty($this->request->query['lookup_name'])) {
                if ($this->request->query['lookup_name'] != 'null') {
                    $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
                }
            }
            if (!empty($this->request->query['tariff_standared'])) {
                if ($this->request->query['tariff_standared'] != 'null') {
                    $conditions['TariffStandard.name'] = $this->request->query['tariff_standared'];
                }
            }
            if (!empty($this->request->query['from'])) {
                if ($this->request->query['from']) {
                    $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
                    $conditions['Patient.discharge_date >='] = $from;
                }
            }

            if (!empty($this->request->query['to'])) {
                if ($this->request->query['to'] != 'null') {
                    $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
                    $conditions['Patient.discharge_date <='] = $to;
                }
            }
        }
        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array('Patient.discharge_date' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.discharge_date', 'Patient.form_received_on',
                'Patient.discharge_status', 'Patient.form_received_on', 'TariffStandard.name'),
            'conditions' => $conditions, 'group' => array('patient.id'));
        $result = $this->paginate('Patient');
        foreach ($result as $key => $value) {
            $patientID[] = $result[$key]['Patient']['id'];
        }
        $this->set('results', $result);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_company_discharge_report_all_xls');
        }
    }

    public function admin_company_discharge_report_all_xls() {

        $this->uses = array('Patient', 'Billing', 'FinalBilling', 'TariffStandard');
        $this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(
                array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id')),
                'Billing' => array('foreignKey' => false, 'conditions' => array('Billing.Patient_id=Patient.id')),
                'TariffStandard' => array('foreignKey' => false, 'conditions' => array('TariffStandard.id=Patient.Tariff_standard_id')))), false);
        $conditions = array('Patient.location_id' => $this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => "IPD");
        if (!empty($this->request->query)) {
            if (!empty($this->request->query['lookup_name'])) {
                if ($this->request->query['lookup_name'] != 'null') {
                    $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
                }
            }
            if (!empty($this->request->query['from'])) {
                if ($this->request->query['from']) {
                    $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
                    $conditions['Patient.discharge_date >='] = $from;
                }
            }

            if (!empty($this->request->query['to'])) {
                if ($this->request->query['to'] != 'null') {
                    $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
                    $conditions['Patient.discharge_date <='] = $to;
                }
            }
        }

        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array('Patient.discharge_date' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.discharge_date', 'Patient.form_received_on',
                'Patient.discharge_status', 'Patient.form_received_on', 'TariffStandard.name'),
            'conditions' => $conditions, 'group' => array('patient.id'));

        $result = $this->paginate('Patient');
        foreach ($result as $key => $value) {
            $patientID[] = $result[$key]['Patient']['id'];
        }
        $this->set('results', $result);
        $this->render('admin_company_discharge_report_all_xls', false);
    }

    public function getCompanyStatus($id, $val) {
        $this->uses = array('Patient');
        $this->autoRender = false;
        $this->Layout = 'false';
        if ($val != NULL) {
            $this->Patient->id = $id; //debug($val);exit;
            $this->request->data['Patient']['discharge_status'] = $val;
            $this->request->data['Patient']['claim_status'] = $val;
            $this->request->data['Patient']['claim_status_change_date'] = date('Y-m-d H:i:s');
            $this->Patient->save($this->request->data);
        }
    }

    /*     * ************EOF Swatin************************************************************************************************************************* */
    /* ------------------------------------------------------------ */

    public function getStatus($id, $val) {
        $this->uses = array('Patient');
        $this->autoRender = false;
        $this->Layout = 'ajax';
        if ($val != NULL) {
            $this->Patient->id = $id; //debug($val);exit;
            $this->request->data['Patient']['discharge_status_company'] = $val;
            $this->Patient->save($this->request->data);
        }
    }

    /*     * ************EOF Atulc************************************************************************************************************************** */

    //admin_discharge_report_all

    public function admin_discharge_summary_report_all($type = NULL) {

        $this->uses = array('Patient', 'Billing', 'FinalBilling', 'TariffStandard');
        $this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
        $this->layout = 'advance_ajax';
        $this->Patient->bindModel(
                array('belongsTo' => array(
                //'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.Patient_id=Patient.id')),

                'Billing' => array('foreignKey' => false, 'conditions' => array('Billing.Patient_id=Patient.id')),
                'TariffStandard' => array('foreignKey' => false, 'conditions' => array('TariffStandard.id=Patient.Tariff_standard_id'))
                )), false);

        $conditions = array('Patient.location_id' => $this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => "IPD"); //debug($conditions);exit;
        if (!empty($this->request->query)) {
            if (!empty($this->request->query['lookup_name'])) {
                if ($this->request->query['lookup_name'] != 'null') {
                    $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
                }
            }
            if (!empty($this->request->query['tariff_standared'])) {
                if ($this->request->query['tariff_standared'] != 'null') {
                    $conditions['TariffStandard.name'] = $this->request->query['tariff_standared'];
                }
            }
            if (!empty($this->request->query['from'])) {
                if ($this->request->query['from']) {
                    $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
                    $conditions['Patient.discharge_date >='] = $from;
                    $conditions['Patient.form_received_on >='] = $from;
                }
            }

            if (!empty($this->request->query['to'])) {
                if ($this->request->query['to'] != 'null') {
                    $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
                    $conditions['Patient.discharge_date <='] = $to;
                    $conditions['Patient.form_received_on <='] = $to;
                }
            }

            if (!empty($this->request->query['is_discharge'])) {
                $isDischarge = $this->request->query['is_discharge'];
                if ($isDischarge == "discharge") {
                    $conditions['Patient.is_discharge'] = $isDischarge;
                } else {
                    $conditions[] = ('Patient.is_discharge != 1');
                }
            }

            if (!empty($this->request->query['discharge_status']) && $this->request->query['discharge_status'] != 'null') {
                $conditions['Patient.discharge_status'] = $this->request->query['discharge_status'];
            }
        }
        //debug($conditions);
        $this->paginate = array(
            'limit' => '50',
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.discharge_date', 'Patient.form_received_on', 'Patient.is_discharge',
                'Patient.discharge_status', 'Patient.form_received_on', 'TariffStandard.name'),
            'conditions' => $conditions,
            'group' => array('Patient.id')
        );
        $result = $this->paginate('Patient');
        foreach ($result as $key => $value) {
            $patientID[] = $result[$key]['Patient']['id'];
        }
        $this->set('results', $result);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_discharge_summary_report_all_xls');
        }
    }

    //function to discharge from discharge summary reports
    public function doDischarge($patientID, $status) {
        $this->layout = false;
        $this->autoRender = false;
        $this->uses = array("Patient");
        if ($this->Patient->updateAll(array('is_discharge' => $status), array('id' => $patientID))) {
            return true;
        }
    }

    public function admin_discharge_summary_report_all_xls() {

        $this->uses = array('Patient', 'Billing', 'FinalBilling', 'TariffStandard');
        $this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
        $this->Layout = 'ajax';
        $this->Patient->bindModel(
                array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id')),
                'Billing' => array('foreignKey' => false, 'conditions' => array('Billing.Patient_id=Patient.id')),
                'TariffStandard' => array('foreignKey' => false, 'conditions' => array('TariffStandard.id=Patient.Tariff_standard_id')))), false);
        $conditions = array('Patient.location_id' => $this->Session->read('locationid'), 'Patient.is_deleted' => 0, 'Patient.admission_type' => "IPD");
        if (!empty($this->request->query)) {
            if (!empty($this->request->query['lookup_name'])) {
                if ($this->request->query['lookup_name'] != 'null') {
                    $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
                }
            }
            if (!empty($this->request->query['from'])) {
                if ($this->request->query['from']) {
                    $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
                    $conditions['Patient.discharge_date >='] = $from;
                }
            }

            if (!empty($this->request->query['to'])) {
                if ($this->request->query['to'] != 'null') {
                    $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
                    $conditions['Patient.discharge_date <='] = $to;
                }
            }
        }


        $this->paginate = array(
            'limit' => 50,
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.discharge_date', 'Patient.form_received_on',
                'Patient.discharge_status', 'Patient.form_received_on', 'TariffStandard.name'),
            'conditions' => $conditions,
            'group' => array('Patient.person_id')
        );
        $result = $this->paginate('Patient');
        //debug($result); exit;
        foreach ($result as $key => $value) {
            $patientID[] = $result[$key]['Patient']['id'];
        }
        $this->set('results', $result);
        $this->render('admin_discharge_summary_report_all_xls', false);
    }

    /*     * ************EOF Swatin************************************************************************************************************************* */
    /* ------------------------------------------------------------ */

    //Mahindra & Mahindra Report

    public function admin_mahindra_report($type = NULL) {
        $this->layout = 'advance';
        $this->uses = array('Patient', 'TariffStandard', 'Person', 'FinalBilling', 'Billing');
        $tariffID = $this->TariffStandard->getTariffStandardID("Mahindra");
        $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'), 'conditions' => array('TariffStandard.is_deleted' => 0, /* 'TariffStandard.code_name IS NOT NULL', */'TariffStandard.location_id' => $this->Session->read('locationid'))));
        $this->set('tariffData', $tariffData);
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'Person' => array('foreignKey' => false, 'conditions' => array('Person.id=Patient.person_id')),
                'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id')),
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('FinalBilling.patient_id=Patient.id'/* ,'FinalBilling.bill_uploading_date NOT'=>NULL */)),
                )), false);

        $conditions = array('Patient.is_hidden_from_report' => 0, 'Patient.tariff_standard_id' => 23, 'Patient.admission_type' => 'IPD', 'Patient.is_discharge' => '1', 'Patient.location_id' => $this->Session->read('locationid'));

        //TariffStandard id =23 for Mahindra
        /* $result = $this->Patient->find('all',array(
          'order' => array('Patient.form_received_on' => 'desc'),
          'fields'=>array('Patient.id','Patient.lookup_name','Person.relation_to_employee','Patient.form_received_on','Patient.discharge_date',
          'FinalBilling.bill_number','FinalBilling.total_amount','FinalBilling.amount_pending'),
          'conditions' =>$conditons=array('Patient.tariff_standard_id'=>'23','Patient.is_deleted'=>0,'Patient.location_id'=>$this->Session->read('locationid')))); */


        if (!empty($this->request->query)) {
            unset($conditions['Patient.is_hidden_from_report']);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if (!empty($this->request->query['from'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['to'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
            }

            if ($to)
                $conditions['Patient.form_received_on <='] = $to;
            if ($from)
                $conditions['Patient.form_received_on >='] = $from;
        }
        $fields = array('Patient.id', 'Patient.lookup_name', 'Person.relation_to_employee', 'Patient.form_received_on', 'Patient.discharge_date', 'FinalBilling.cmp_paid_date','Patient.admission_type',
            'FinalBilling.cmp_amt_paid', 'FinalBilling.hospital_invoice_amount', 'FinalBilling.bill_number', 'FinalBilling.id', 'FinalBilling.total_amount', 'Patient.remark', 'FinalBilling.package_amount',
            'FinalBilling.bill_uploading_date', 'FinalBilling.other_deduction', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.tds', 'FinalBilling.other_deduction_modified', 'PatientDocument.id', 'PatientDocument.filename');
        if ($type != 'excel') {
            $this->paginate = array(
                'limit' => 10,
                'order' => array('Patient.form_received_on' => 'desc'),
                'fields' => $fields,
                'conditions' => $conditions,
                'group' => array('Patient.id'));
            $result = $this->paginate('Patient');
        } else {
            $result = $this->Patient->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => array('Patient.form_received_on' => 'desc')));
        }

        //debug($result);
        //get total invoice amount and paid
        $totalData = $this->getTotalInvoiceAndPaidAmnt('23', 'IPD');
        $suspenseDetails = $this->getCorporateSuspenseAmount('23');
        $this->set(array('totalInvoice' => $totalData['totalInvoice'], 'totalAdvancePaid' => $totalData['totalPaid'],
            'suspenseDetails' => $suspenseDetails['suspenseDetails'], 'suspenseAmount' => $suspenseDetails['totalSuspenseAmount']));
        $this->loadModel('Billing');
        foreach ($result as $key => $value) {
            //to get the total payment of that patient by Swapnil - 04.11.2015
            $totalVal[$value['Patient']['id']] = $this->Billing->getPatientTotalBill($value['Patient']['id'], $value['Patient']['admission_type']);
            $totalPaid[$value['Patient']['id']] = $this->Billing->getPatientPaidAmount($value['Patient']['id']);
        }
        $this->set('results', $result);
        $this->set('totalPaid', $totalPaid);
        $this->set('totalAmount', $totalVal);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_mahindra_xls', false);
        }


        //if($this->request->query) $this->render('ajax_mahindra_report');
    }

    //------------------------------------------------------------------------------------------------------------------------------------------//

    public function admin_mahindra_xls() {
        $this->uses = array('Patient', 'TariffStandard', 'Person', 'FinalBilling');
        $tariffID = $this->TariffStandard->getTariffStandardID("Mahindra");
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'Person' => array('foreignKey' => false, 'conditions' => array('Person.id=Patient.person_id')),
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('FinalBilling.patient_id=Patient.id', 'FinalBilling.bill_uploading_date NOT' => NULL)),
                )));

        $conditions = array('Patient.is_hidden_from_report' => 0, 'Patient.tariff_standard_id' => $tariffID, 'Patient.is_discharge' => '1', 'Patient.location_id' => $this->Session->read('locationid'));

        //TariffStandard id =23 for Mahindra
        $result = $this->Patient->find('all', array(
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Person.relation_to_employee', 'Patient.form_received_on', 'Patient.discharge_date', 'FinalBilling.cmp_amt_paid', 'FinalBilling.cmp_paid_date',
                'FinalBilling.bill_number', 'FinalBilling.id', 'FinalBilling.total_amount', 'Patient.remark', 'FinalBilling.package_amount',
                'FinalBilling.bill_uploading_date', 'FinalBilling.other_deduction', 'FinalBilling.tds', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.other_deduction_modified'),
            'conditions' => $conditions, 'group' => array('Patient.id')));
        $this->set('results', $result);
        $this->render('admin_mahindra_xls', false);
    }

    //------------------------------------------------------------------------------------------------------------------------------------------//

    public function getCalculateOtherDeduction($flag, $val, $id) {
        $this->uses = array('FinalBilling');
        $this->autoRender = false;
        $this->Layout = 'ajax';

        if (!empty($id)) {
            if (!empty($flag) && $flag == 1) {

                $this->FinalBilling->id = $id;
                $this->request->data['FinalBilling']['other_deduction'] = $val;

                $this->request->data['FinalBilling']['other_deduction_modified'] = $flag;

                $this->FinalBilling->save($this->request->data);
            }
        }
    }

    //------------------------------------------------------------------------------------------------------------------------------------------//

    public function getCase($id, $val) {
        $this->uses = array('Patient');
        $this->autoRender = false;
        $this->Layout = 'ajax';
        if ($val != NULL) {
            $this->Patient->id = $id;
            $this->request->data['Patient']['case_no'] = $val;

            $this->Patient->save($this->request->data);
        }
    }

    /*     * **************************************************************************************************************** */

    public function getHospital($id, $val) {
        $this->uses = array('Patient');
        $this->autoRender = false;
        $this->Layout = 'ajax';
        if ($val != NULL) {
            $this->Patient->id = $id;
            $this->request->data['Patient']['hospital_no'] = $val;

            $this->Patient->save($this->request->data);
        }
    }

    //rgjay

    /*     * **************************************************************************************************************** */


    public function admin_rgjayreport_xls() {
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Person');
        $this->autoRender = false;

        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                    'fields' => array('FinalBilling.bill_uploading_date')),
                'Person' => array('primaryKey' => false, 'conditions' => array('Person.id=Patient.person_id'),
                    'field' => 'Person.district'))));

        $conditons = array('Patient.tariff_standard_id' => '25', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid'));

        if (!empty($this->request->query)) {
            if (!empty($this->request->query['assigned_to']) || !empty($this->request->query['claim_status'])) {
                if ($this->request->query['assigned_to'] != 'null') {
                    $assigned = $this->request->query['assigned_to'];
                    //debug($assigned);
                    $new_ass = explode(",", $assigned);
                    //debug($new_ass);
                    $this->request->query['assigned_to'] = $new_ass;
                    $conditons['Patient.assigned_to'] = $this->request->query['assigned_to'];
                }
                if ($this->request->query['claim_status'] != 'null') {
                    $conditons['Patient.claim_status'] = $this->request->query['claim_status'];
                }
            } else {
                if ($this->request->query['lookup_name'] != 'null') {
                    $conditons['Patient.lookup_name'] = $this->request->query['lookup_name'];
                }
            }
        }

        $result = $this->Patient->find('all', array(
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.discharge_date', 'Patient.is_discharge', 'Patient.form_received_on', 'Patient.extension_status', 'Patient.remark', 'Patient.assigned_to', 'Patient.discharge_update', 'Patient.claim_status', 'Patient.case_no', 'Patient.hospital_no', 'Person.district',
                'FinalBilling.id', 'FinalBilling.bill_uploading_date', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.dr_claim_date', 'FinalBilling.CMO_claim_date', 'FinalBilling.CMO_claim_pending_approval', 'FinalBilling.dr_claim_pending_approval', 'FinalBilling.package_amount'),
            'conditions' => $conditons));

        foreach ($result as $key => $value) {
            $patientID[] = $result[$key]['Patient']['id'];
        }

        $this->loadModel('OptAppointment');
        $this->OptAppointment->unbindModel(array(
            'belongsTo' => array('Initial', 'Patient', 'Location', 'Opt', 'OptTable', 'Surgery', 'SurgerySubcategory', 'Doctor', 'DoctorProfile')));

        $this->OptAppointment->bindModel(array(
            'belongsTo' => array(
                'Surgery' => array('foreignKey' => 'surgery_id'),
                )));

        $surgeriesData = $this->OptAppointment->find('all', array(
            'fields' => array('Surgery.name', 'OptAppointment.patient_id'),
            'conditions' => array('OptAppointment.patient_id' => $patientID, 'OptAppointment.is_deleted' => 0, 'OptAppointment.location_id' => $this->Session->read('locationid'))));

        $this->set('surgeriesData', $surgeriesData);
        $this->set('results', $result);
        $this->render('admin_rgjayreport_xls', false);
    }

    /*     * **************************************************************************************************************** */

    /**
      @name : admin_rgjay_report
      @created for: Admitted rgjay report
      @created by: Swapnil G.Sharma
     * */
    public function admin_rgjay_report($type = NULL) {
        ob_end_clean();
        ob_start("ob_gzhandler");
        //echo "<h1>Please do not use this page, work in progress....</h1>";
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'ServiceCategory', 'ServiceBill');
        //25 for RGJAY
        $this->layout = 'advance';
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false,
                    //'type'=>'INNER',
                    'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                    'fields' => array('FinalBilling.bill_uploading_date')),
                'ServiceBill' => array('foreignKey' => false,
                    'conditions' => array('ServiceBill.patient_id = Patient.id', 'ServiceBill.tariff_standard_id' => '25')),
                'TariffList' => array('foreignKey' => false,
                    'conditions' => array('TariffList.id = ServiceBill.tariff_list_id')),
                'Person' => array('primaryKey' => false,
                    'type' => 'INNER',
                    'conditions' => array('Person.id=Patient.person_id'),
                    'field' => 'Person.district'))));

        $conditons = array('Patient.tariff_standard_id' => '25', 'Patient.is_deleted' => 0, 'Patient.admission_type' => 'IPD', 'Patient.location_id' => $this->Session->read('locationid'));

        if (!empty($this->request->query)) {
            //$this->layout = 'ajax';
            if (!empty($this->request->query['assigned_to']) || !empty($this->request->query['claim_status'])) {
                if ($this->request->query['assigned_to'] != 'null' && !empty($this->request->query['assigned_to'])) {
                    //$assigned = $this->request->query['assigned_to'];
                    //$new_ass = explode(",",$assigned);
                    //debug($assigned);
                    //$this->request->query['assigned_to'] = $new_ass;
                    $conditons['Patient.assigned_to'] = $this->request->query['assigned_to'];
                }
                if ($this->request->query['claim_status'] != 'null' && !empty($this->request->query['claim_status'])) {
                    //$claim = $this->request->query['claim_status'];
                    //debug($claim);
                    //$new_claim = explode(",",$claim);
                    //debug($new_claim);
                    //$this->request->query['claim_status'] = $new_claim;
                    $conditons['Patient.claim_status'] = $this->request->query['claim_status'];
                }
            }
            //else
            //{
            if ($this->request->query['patient_id'] != 'null' && !empty($this->request->query['patient_id'])) {
                $conditons['Patient.id'] = $this->request->query['patient_id'];
            }
            //}
            //}else{
            //	$conditons['Patient.assigned_to'] = NULL;
            //}
        }
        $this->paginate = array(
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.discharge_date', 'Patient.is_discharge',
                'Patient.form_received_on', 'Patient.extension_status', 'Patient.remark', 'Patient.assigned_to',
                'Patient.discharge_update', 'Patient.claim_status', 'Patient.case_no', 'Patient.hospital_no',
                'Patient.enrollment_date', 'Patient.preauth_send_date', 'Patient.preauth_approved_date',
                'Patient.surgery_pending_date', 'Patient.claim_status_change_date',
                'Patient.surgery_done_date', 'Patient.surgery_notes_update_date', 'Patient.post_of_notes_date',
                'Person.district', 'FinalBilling.id', 'FinalBilling.bill_uploading_date', 'FinalBilling.dr_claim_date','FinalBilling.tds','FinalBilling.discount',
                'FinalBilling.CMO_claim_date', 'FinalBilling.CMO_claim_pending_approval', 'FinalBilling.dr_claim_pending_approval',
                'FinalBilling.package_amount', 'TariffList.name, ServiceBill.amount, ServiceBill.no_of_times'),
            'conditions' => array($conditons, 'Patient.is_hidden_from_report' => 0),
            'limit' => '10',
            'order' => array('Patient.id' => 'DESC'),
            'group' => array('Patient.id'));
        $result = $this->paginate('Patient');

        $this->loadModel('Billing');
        foreach ($result as $key => $value) {
            $patientID[] = $result[$key]['Patient']['id'];
            $packageAmt[$value['Patient']['id']] = $this->ServiceBill->getRgjayPackageAmount($value['Patient']['id']);
            $totalPaid[$value['Patient']['id']] = $this->Billing->getPatientPaidAmount($value['Patient']['id']);
        } 
        $this->set('totalPaid', $totalPaid);
        $this->set('packageAmount', $packageAmt);
        $this->loadModel('OptAppointment');
        $this->OptAppointment->unbindModel(array(
            'belongsTo' => array('Initial', 'Patient', 'Location', 'Opt', 'OptTable', 'Surgery', 'SurgerySubcategory', 'Doctor', 'DoctorProfile')));

        $this->OptAppointment->bindModel(array(
            'belongsTo' => array(
                'Surgery' => array('foreignKey' => 'surgery_id', 'type' => 'INNER'),
                )));

        $surgeriesData = $this->OptAppointment->find('all', array(
            'fields' => array('Surgery.name', 'OptAppointment.patient_id'),
            'conditions' => array('OptAppointment.patient_id' => $patientID, 'OptAppointment.is_deleted' => 0, 'OptAppointment.location_id' => $this->Session->read('locationid'))));

        $this->set('surgeriesData', $surgeriesData);
        $this->set('results', $result);

        if (!empty($this->request->query)) {
            //$this->render('ajax_rgjay_reports');
        }

        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_rgjayreport_xls', false);
        }
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
    }

    /*     * ************************************************************************************************************** */

    /**
     *
      @name : delete patient from reports
      @created for: Rgjay Report
     */
    /*     * ****************************************************************************************************************************** */
    public function admin_rgjay_payment_received_report($type = NULL) {
        $this->uses = array('Patient', 'FinalBilling');
        $this->layout = 'advance';
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false, 
                    'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                    'fields' => array('FinalBilling.bill_uploading_date')),
                 ))); 
        $conditions = array('Patient.tariff_standard_id' => '25','Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' =>'0',
            'Patient.admission_type' => 'IPD', 'Patient.location_id' => $this->Session->read('locationid'));
        
         if (!empty($this->request->query)) {  
            if (!empty($this->request->query['patient_id'])) { 
                $conditions['Patient.id'] = $this->request->query['patient_id'];
            } 
        } 
        
        //$this->Patient->bindModel(array('belongsTo' => array('FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id'), 'fields' => array('FinalBilling.package_amount')))));
        $result = $this->Patient->find('all', array('fields' => array('Patient.id', 'Patient.case_no', 'Patient.hospital_no', 'Patient.lookup_name', 'Patient.admission_type', 
                'Patient.form_received_on', 'FinalBilling.package_amount','FinalBilling.id','FinalBilling.tds','FinalBilling.discount', 'FinalBilling.amount_paid'), 
            'conditions' => array('Patient.tariff_standard_id' => '25', 'Patient.is_deleted' => 0,$conditions,'Patient.is_discharge'=>'1'),
            'limit'=>'10',
            'group'=>'Patient.id'));
        $this->loadModel('Billing');
        $this->loadModel('ServiceBill');
        foreach ($result as $key => $value) { 
            //$packageAmt[$value['Patient']['id']] = $this->ServiceBill->getRgjayPackageAmount($value['Patient']['id']);
            $packageAmt[$value['Patient']['id']] = $this->Billing->getPatientTotalBill($value['Patient']['id'], $value['Patient']['admission_type']);
            $totalPaid[$value['Patient']['id']] = $this->Billing->getPatientPaidAmount($value['Patient']['id']);
        } 
        $this->set('totalPaid', $totalPaid);
        $this->set('packageAmount', $packageAmt);
        $this->set(results, $result);
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
    }

//swa
    public function admin_rgjay_outstanding_report() {
        $this->uses = array('Patient', 'FinalBilling');
        $this->layout = 'advance';
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array('FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id'), 'fields' => array('FinalBilling.package_amount')))));

        $result = $this->Patient->find('all', array('fields' => array('Patient.id', 'Patient.case_no', 'Patient.hospital_no', 'Patient.lookup_name', 'Patient.form_received_on', 'FinalBilling.package_amount', 'FinalBilling.amount_paid', 'FinalBilling.bill_number', 'FinalBilling.discharge_date', 'FinalBilling.total_amount', 'FinalBilling.amount_pending', 'FinalBilling.date'), 'conditions' => array('Patient.tariff_standard_id' => '25', 'Patient.is_deleted' => 0, 'Patient.location_id' => $this->Session->read('locationid'))));


//debug($result);exit;
        $this->set(results, $result);
    }

    /*     * ***************************************************created by swapnil************************************************ */

    /**
      @name : admin_rgjay_tasks_report
      @created for: rgjay report
      @created by: Swapnil G.Sharma
     * */
    public function admin_rgjay_tasks_report() {
        $this->uses = array('Patient', 'FinalBilling', 'TariffStandard');
        $this->layout = 'advance';
        $this->Patient->unBindModel(array('hasMany' => (array('PharmacySalesBill', 'InventoryPharmacySalesReturn'))));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false,
                    'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                    'fields' => array('FinalBilling.package_amount')),
                'Person' => array('primaryKey' => false,
                    'conditions' => array('Person.id=Patient.person_id'),
                    'fields' => 'Person.district'))));

        $fields = array('Patient.id', 'Patient.discharge_date', 'Patient.case_no', 'Patient.hospital_no', 'Patient.lookup_name', 'Patient.form_received_on', 'Patient.assigned_to', 'Patient.lookup_name', 'Patient.claim_status', 'Patient.claim_status_change_date', 'Person.district');

        $conditions = array('Patient.tariff_standard_id' => '25', 'Patient.is_deleted' => 0, 'Patient.admission_type' => 'IPD', 'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid'));

        if (!empty($this->request->query)) {
            if ($this->request->query['assigned_to'] != 'null') {
                $conditions['Patient.assigned_to'] = $this->request->query['assigned_to'];
            }
        }

        $result = $this->Patient->find('all', array('fields' => $fields, 'conditions' => $conditions));

        $this->set(result, $result);

        if ($this->request->query) {
            $this->layout = "ajax";
            $this->render('ajax_rgjay_tasks_reports');
        }
    }

    /*     * **************************************************************************************************************** */

    /**
      @name : admin_rgjay_tasks_report_xls
      @created for: rgjay tasks report
      @created by: Swapnil G.Sharma
     * */
    public function admin_rgjay_tasks_report_xls() {
        $this->autoRender = false;
        $this->uses = array('Patient', 'FinalBilling', 'TariffStandard');

        $this->Patient->unBindModel(array('hasMany' => (array('PharmacySalesBill', 'InventoryPharmacySalesReturn'))));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false,
                    'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                    'fields' => array('FinalBilling.package_amount')),
                'Person' => array('primaryKey' => false,
                    'conditions' => array('Person.id=Patient.person_id'),
                    'fields' => 'Person.district'))));

        $fields = array('Patient.id', 'Patient.case_no', 'Patient.hospital_no', 'Patient.lookup_name', 'Patient.form_received_on', 'Patient.assigned_to', 'Patient.lookup_name', 'Patient.claim_status', 'Person.district');

        //debug($fields);exit;
        $conditions = array('Patient.tariff_standard_id' => '25', 'Patient.admission_type' => 'IPD', 'Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid'));

        if (!empty($this->request->data)) {
            if ($this->request->data['Corporates']['assigned_to'] != null) {
                $conditions['Patient.assigned_to'] = $this->request->data['Corporates']['assigned_to'];
            }
        }

        $result = $this->Patient->find('all', array('fields' => $fields, 'conditions' => $conditions));
        $this->set(result, $result);
        $this->render('admin_rgjay_tasks_report_xls', false);
    }

    /*     * **************************************************************************************************************** */

    public function admin_mpkay_report($type = NULL) {
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Person', 'Billing');
        $this->layout = 'advance';
        $tariffID = $this->TariffStandard->getTariffStandardID("MPKAY");
        //debug($tariffID);exit;
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false,
                    'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                    'fields' => array('FinalBilling.package_amount', 'FinalBilling.bill_number', 'FinalBilling.amount_paid', 'FinalBilling.discharge_date', 'FinalBilling.discharge_date',
                        'FinalBilling.bill_uploading_date', 'FinalBilling.package_amount')),
                'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id')),
                'Person' => array('primaryKey' => false,
                    'conditions' => array('Person.id=Patient.person_id'),
                    'fields' => 'Person.id', 'Person.relation_to_employee', 'Person.name_of_ip', 'Person.executive_emp_id_no', 'Person.member_uhid_no', 'Person.sanction_no'))));

        $conditions = array('Patient.tariff_standard_id' => $tariffID, 'Patient.admission_type' => 'IPD', 'Patient.is_hidden_from_report' => 0, 'Patient.is_discharge' => '1', 'Patient.is_deleted' => 0,
            'Patient.location_id' => $this->Session->read('locationid'));

        if (!empty($this->request->query)) {
            unset($conditions['Patient.is_hidden_from_report']);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if (!empty($this->request->query['from'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['to'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
            }

            if ($to)
                $conditions['Patient.form_received_on <='] = $to;
            if ($from)
                $conditions['Patient.form_received_on >='] = $from;
        }
        $fields = array('Patient.id', 'Patient.lookup_name', 'Patient.card_no', 'Patient.sanction_no','Patient.discharge_date','Person.id', 'Patient.form_received_on', 'FinalBilling.amount_paid', 'FinalBilling.id', 'FinalBilling.other_deduction_modified',
            'Person.relation_to_employee', 'FinalBilling.bill_number', 'FinalBilling.cmp_amt_paid', 'FinalBilling.cmp_paid_date', 'FinalBilling.package_amount','Patient.admission_type',
            'FinalBilling.total_amount', 'FinalBilling.hospital_invoice_amount', 'FinalBilling.discharge_date', 'Person.name_of_ip', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.tds', 'FinalBilling.other_deduction_modified',
            'FinalBilling.other_deduction', 'FinalBilling.bill_uploading_date', 'Patient.remark', 'Person.executive_emp_id_no', 'Person.sponsor_company',
            'Person.member_uhid_no', 'Person.sanction_no', 'Person.unit_name', 'PatientDocument.id', 'PatientDocument.filename');
        if ($type != 'excel') {
            $this->paginate = array(
                'limit' => 10,
                'order' => array('Patient.form_received_on' => 'desc'),
                'fields' => $fields,
                'conditions' => $conditions);
            $result = $this->paginate('Patient');
        } else {
            $result = $this->Patient->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => array('Patient.form_received_on' => 'desc')));
        }
        //get total invoice amount and paid
        $totalData = $this->getTotalInvoiceAndPaidAmnt($tariffID, 'IPD');
        $suspenseDetails = $this->getCorporateSuspenseAmount($tariffID);
        $this->set(array('totalInvoice' => $totalData['totalInvoice'], 'totalAdvancePaid' => $totalData['totalPaid'],
            'suspenseDetails' => $suspenseDetails['suspenseDetails'], 'suspenseAmount' => $suspenseDetails['totalSuspenseAmount']));
        $this->set(results, $result);
        $this->loadModel('Billing');
        foreach ($result as $key => $value) {
            //to get the total payment of that patient by Swapnil - 04.11.2015
            $totalVal[$value['Patient']['id']] = $this->Billing->getPatientTotalBill($value['Patient']['id'],$value['Patient']['admission_type']);
            $totalPaid[$value['Patient']['id']] = $this->Billing->getPatientPaidAmount($value['Patient']['id']);
            //$totalDiscount[$val['Patient']['id']] = $this->Billing->getPatientDiscountAmount($val['Patient']['id']);
        }
        $this->set('totalDiscount', $totalDiscount);
        $this->set('totalPaid', $totalPaid);
        $this->set('totalAmount', $totalVal);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_mpkay_xls', false);
        }
        $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'), 'conditions' => array('TariffStandard.is_deleted' => 0, /* 'TariffStandard.code_name IS NOT NULL', */'TariffStandard.location_id' => $this->Session->read('locationid'))));
        $this->set('tariffData', $tariffData);
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
    }

    /*     * *********************************************************************** */

    public function admin_mpkay_xls() {
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling');
        $tariffID = $this->TariffStandard->getTariffStandardID("MPKAY");

        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false,
                    'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                    'fields' => array('FinalBilling.package_amount', 'FinalBilling.bill_number', 'FinalBilling.amount_paid', 'FinalBilling.discharge_date', 'FinalBilling.discharge_date', 'FinalBilling.cmp_amt_paid', 'FinalBilling.cmp_paid_date',
                        'FinalBilling.bill_uploading_date', 'Finalbilling.package_amount')),
                'Person' => array('primaryKey' => false,
                    'conditions' => array('Person.id=Patient.person_id'),
                    'fields' => 'Person.relation_to_employee', 'Person.name_of_ip', 'Person.executive_emp_id_no', 'Person.member_uhid_no', 'Person.sanction_no'))));

        $conditions = array('Patient.tariff_standard_id' => $tariffID, 'Patient.is_hidden_from_report' => 0, 'Patient.is_discharge' => 1, 'Patient.is_deleted' => 0,
            'Patient.location_id' => $this->Session->read('locationid'));

        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Person.id', 'Patient.form_received_on', 'FinalBilling.amount_paid', 'FinalBilling.id', 'FinalBilling.other_deduction_modified', 'Person.relation_to_employee', 'FinalBilling.bill_number',
                'FinalBilling.package_amount', 'FinalBilling.total_amount', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.discharge_date', 'Person.name_of_ip', 'FinalBilling.tds', 'FinalBilling.other_deduction_modified',
                'FinalBilling.other_deduction', 'FinalBilling.bill_uploading_date', 'Patient.remark', 'Person.executive_emp_id_no', 'Person.sponsor_company', 'Person.member_uhid_no', 'Person.sanction_no', 'Person.unit_name'),
            'conditions' => $conditions);

        $result = $this->paginate('Patient');

        //$result = $this->Patient->find('all',array('fields'=>$fields,'conditions'=>$conditions));
        //debug($result);
        $this->set(results, $result);
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
        $this->render('admin_mpkay_xls', false);
    }

    /*     * ************************************************************************************ */

    //**************Raymond Report


    public function admin_raymond_report($type = NULL) {
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Person', 'Billing');
        $this->layout = 'advance';
        $tariffID = $this->TariffStandard->getTariffStandardID("Raymonds");
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.patient_id=Patient.id')),
                'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id')),
                'Person' => array('primaryKey' => false,
                    'conditions' => array('Person.id=Patient.person_id'),
                    'fields' => 'Person.relation_to_employee'))));

        $conditions = array('Patient.tariff_standard_id' => $tariffID, 'Patient.is_discharge' => '1', 'Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid'));

        if (!empty($this->request->query)) {
            unset($conditions['Patient.is_hidden_from_report']);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if (!empty($this->request->query['from'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['to'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
            }

            if ($to)
                $conditions['Patient.form_received_on <='] = $to;
            if ($from)
                $conditions['Patient.form_received_on >='] = $from;
        }
        $fields = array('Patient.id', 'Patient.lookup_name', 'Patient.relative_name', 'Person.relation_to_employee', 'Patient.form_received_on', 'Patient.discharge_date','Patient.admission_type',
            'FinalBilling.bill_number', 'FinalBilling.hospital_invoice_amount', 'FinalBilling.id', 'FinalBilling.total_amount', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'Patient.remark', 'FinalBilling.package_amount', 'FinalBilling.amount_paid',
            'FinalBilling.amount_pending', 'FinalBilling.bill_uploading_date', 'FinalBilling.other_deduction', 'FinalBilling.tds', 'FinalBilling.other_deduction_modified',
            'PatientDocument.id', 'PatientDocument.filename');
        if ($type != 'excel') {
            $this->paginate = array(
                'limit' => 10,
                'order' => array('Patient.form_received_on' => 'desc'),
                'fields' => $fields,
                'conditions' => $conditions, 'group' => array('Patient.id'));
            $result = $this->paginate('Patient');
        } else {
            $result = $this->Patient->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => array('Patient.form_received_on' => 'desc'), 'group' => array('Patient.id')));
        }
        //get total invoice amount and paid
        $totalData = $this->getTotalInvoiceAndPaidAmnt($tariffID);
        $suspenseDetails = $this->getCorporateSuspenseAmount($tariffID);
        $this->set(array('totalInvoice' => $totalData['totalInvoice'], 'totalAdvancePaid' => $totalData['totalPaid'],
            'suspenseDetails' => $suspenseDetails['suspenseDetails'], 'suspenseAmount' => $suspenseDetails['totalSuspenseAmount']));
        $this->loadModel('Billing');
        $this->set('results', $result);
        foreach ($result as $key => $value) { 
            //to get the total payment of that patient by Swapnil - 04.11.2015
            $totalVal[$value['Patient']['id']] = $this->Billing->getPatientTotalBill($value['Patient']['id'],$value['Patient']['admission_type']);
            $totalPaid[$value['Patient']['id']] = $this->Billing->getPatientPaidAmount($value['Patient']['id']);
        }  
        $this->set('totalPaid', $totalPaid);
        $this->set('totalAmount', $totalVal);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_raymond_xls', false);
        }
        $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'), 'conditions' => array('TariffStandard.is_deleted' => 0, /* 'TariffStandard.code_name IS NOT NULL', */'TariffStandard.location_id' => $this->Session->read('locationid'))));
        $this->set('tariffData', $tariffData);
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
    }

    /*     * ***************************************************************************************** */

    public function admin_raymond_xls() {
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Person');

        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));


        $this->Patient->bindModel(array('belongsTo' => array(
                'Person' => array('foreignKey' => false, 'conditions' => array('Person.id=Patient.person_id')),
                'FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.patient_id=Patient.id', 'FinalBilling.bill_uploading_date NOT' => NULL))
                )));

        $conditions = array('Patient.tariff_standard_id' => '27', 'Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid'));



        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.relative_name', 'Person.relation_to_employee', 'Patient.form_received_on', 'Patient.discharge_date',
                'FinalBilling.bill_number', 'FinalBilling.id', 'FinalBilling.total_amount', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'Patient.remark', 'FinalBilling.package_amount', 'FinalBilling.amount_paid',
                'FinalBilling.amount_pending', 'FinalBilling.bill_uploading_date', 'FinalBilling.other_deduction', 'FinalBilling.tds'),
            'conditions' => $conditions, 'group' => array('Patient.id'));

        $result = $this->paginate('Patient');
        /* foreach ($result as $key => $value)
          {
          $patientID[] = $result[$key]['Patient']['id'] ;
          }
         */

        $this->set('results', $result);
        $this->render('admin_raymond_xls', false);
    }

    /*     * **************************************************************************************************************** */

    public function admin_discharge_report($type = NULL) {
        $this->uses = array('Patient', 'Billing', 'Consultant', 'FinalBilling', 'PharmacySalesBill', 'LabTestPayment', 'RadiologyTestPayment', 'ReffererDoctor', 'TariffStandard',
            'LaboratoryTestOrder', 'RadiologyTestOrder', 'User');
        $privateId = $this->TariffStandard->getPrivateTariffID();

        $this->layout = 'advance';
        /* $this->Patient->bindModel(
          array('belongsTo' => array(

          'FinalBilling'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.Patient_id=Patient.id'),
          'fields'=>array('FinalBilling.total_amount')),

          'Billing'=>array('foreignKey'=>false,'conditions'=>array('Billing.Patient_id=Patient.id'),
          'fields'=>array('Billing.id','Billing.patient_id','Billing.amount')),
          'User' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
          'Consultant'=>array('foreignKey'=>false,'conditions'=>array('Consultant.id=Patient.consultant_id')),

          'PharmacySalesBill'=>array('foreignKey'=>false,'conditions'=>array('PharmacySalesBill.patient_id=Patient.id'),
          'fields'=>array('PharmacySalesBill.total')),

          'LaboratoryTestOrder'=>array('foreignKey'=>false,'conditions'=>array('LaboratoryTestOrder.patient_id=Patient.id'),
          'fields'=>array('LaboratoryTestOrder.amount')),

          'RadiologyTestOrder'=>array('foreignKey'=>false,'conditions'=>array('RadiologyTestOrder.patient_id=Patient.id'),
          'fields'=>array('RadiologyTestOrder.amount')),

          'LabTestPayment'=>array('foreignKey'=>false,'conditions'=>array('LabTestPayment.patient_id=Patient.id'),
          'fields'=>array('LabTestPayment.total_amount')),
          'RadiologyTestPayment'=>array('foreignKey'=>false,'conditions'=>array('RadiologyTestPayment.patient_id=Patient.id'),
          'fields'=>array('RadiologyTestPayment.total_amount'))

          )),false); */

        $conditions = array('Patient.location_id' => $this->Session->read('locationid'), 'Patient.is_discharge' => 1, 'Patient.is_deleted' => 0,
            'Patient.admission_type' => "IPD", 'Patient.tariff_standard_id' => $privateId);

        if (!empty($this->request->query)) {
            //debug($this->request->query);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }

            if (!empty($this->request->query['from'])) {
                if ($this->request->query['from']) {
                    $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
                    $conditions['Patient.discharge_date >='] = $from;
                }
            }

            if (!empty($this->request->query['to'])) {
                if ($this->request->query['to'] != 'null') {
                    $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
                    $conditions['Patient.discharge_date <='] = $to;
                }
            }
        }

        $this->paginate = array(
            'limit' => 10,
            'order' => array('Patient.id' => 'desc', 'Billing.date' => 'DESC'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.discharge_date', /* 'FinalBilling.paid_to_patient','FinalBilling.discount', */'Patient.remark', 'Patient.form_received_on', /* 'FinalBilling.total_amount','FinalBilling.created_by','FinalBilling.amount_paid','CONCAT(User.first_name," ",User.last_name) as name', */
            /* 'PharmacySalesBill.total', *//* 'LabTestPayment.total_amount','RadiologyTestPayment.total_amount','Billing.amount' */            ),
            'conditions' => $conditions,
                //'group'=>array('Billing.patient_id'),
        );

        $result = $this->paginate('Patient');
        if (!empty($result)) {
            foreach ($result as $patientKey => $patientValue) {
                $ids[] = $patientValue['Patient']['id'];
                $customArray[$patientValue['Patient']['id']] = $patientValue;
            }
        }

        $labTotal = $this->LaboratoryTestOrder->find('all', array('fields' => array('SUM(LaboratoryTestOrder.amount) as total',
                'LaboratoryTestOrder.patient_id'),
            'conditions' => array('LaboratoryTestOrder.is_print' => '0', 'LaboratoryTestOrder.patient_id' => $ids), 'group' => array('LaboratoryTestOrder.patient_id')));

        $radTotal = $this->RadiologyTestOrder->find('all', array('fields' => array('SUM(RadiologyTestOrder.amount) as total',
                'RadiologyTestOrder.patient_id'),
            'conditions' => array('RadiologyTestOrder.is_deleted' => '0', 'RadiologyTestOrder.patient_id' => $ids), 'group' => array('RadiologyTestOrder.patient_id')));

        $pharmacyTotal = $this->PharmacySalesBill->find('all', array('fields' => array('SUM(PharmacySalesBill.total) as total',
                'PharmacySalesBill.patient_id'),
            'conditions' => array('PharmacySalesBill.is_deleted' => '0', 'PharmacySalesBill.patient_id' => $ids), 'group' => array('PharmacySalesBill.patient_id')));

        foreach ($labTotal as $labKey => $labValue) {
            $customArray[$labValue['LaboratoryTestOrder']['patient_id']]['LaboratoryTestOrder'] = $labValue[0];
        }
        foreach ($radTotal as $radKey => $radValue) {
            $customArray[$radValue['RadiologyTestOrder']['patient_id']]['RadiologyTestOrder'] = $radValue[0];
        }
        foreach ($pharmacyTotal as $pharmKey => $pharmValue) {
            $customArray[$pharmValue['PharmacySalesBill']['patient_id']]['PharmacySalesBill'] = $pharmValue[0];
        }

        $userName = $this->User->getUserDetails($result[0]['FinalBilling']['created_by']);
        $this->set('userName', $userName['User']['username']);
        $this->set(array('results' => $customArray, 'pharmacyTotal' => $pharmacyTotal, 'labTotal' => $labTotal, 'radTotal' => $radTotal));
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_discharge_report_xls');
        }
    }

    /*     * ********************************** Created by Leena *************************************************** */

    /**
      @name : discharge_report
      @created for: Admitted report

     * */
    public function admin_discharge_report_xls() {
        $this->uses = array('Patient', 'Billing', 'Consultant', 'FinalBilling', 'PharmacySalesBill', 'LabTestPayment', 'RadiologyTestPayment', 'ReffererDoctor', 'TariffStandard',
            'LaboratoryTestOrder', 'RadiologyTestOrder', 'User');
        $privateId = $this->TariffStandard->getPrivateTariffID();

        $this->Patient->bindModel(
                array('belongsTo' => array(
                'FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                    'fields' => array('FinalBilling.total_amount')),
                'Billing' => array('foreignKey' => false, 'conditions' => array('Billing.Patient_id=Patient.id'),
                    'fields' => array('Billing.id', 'Billing.patient_id', 'Billing.amount', 'Billing.date', 'Billing.amount_pending', 'Billing.amount_paid', 'Billing.amount_to_pay_today')),
                'Consultant' => array('foreignKey' => false, 'conditions' => array('Consultant.id=Patient.consultant_id')),
                'PharmacySalesBill' => array('foreignKey' => false, 'conditions' => array('PharmacySalesBill.patient_id=Patient.id'),
                    'fields' => array('PharmacySalesBill.total')),
                'LaboratoryTestOrder' => array('foreignKey' => false, 'conditions' => array('LaboratoryTestOrder.patient_id=Patient.id'),
                    'fields' => array('LaboratoryTestOrder.amount')),
                'RadiologyTestOrder' => array('foreignKey' => false, 'conditions' => array('RadiologyTestOrder.patient_id=Patient.id'),
                    'fields' => array('RadiologyTestOrder.amount')),
                'LabTestPayment' => array('foreignKey' => false, 'conditions' => array('LabTestPayment.patient_id=Patient.id'),
                    'fields' => array('LabTestPayment.total_amount')),
                'RadiologyTestPayment' => array('foreignKey' => false, 'conditions' => array('RadiologyTestPayment.patient_id=Patient.id'),
                    'fields' => array('RadiologyTestPayment.total_amount'))
                )), false);

        //$result = $this->Patient->find('all',array('conditions'=>array('Patient.location_id'=>$this->Session->read('locationid'),'Patient.is_discharge'=>1,'Patient.is_deleted'=>0,'Patient.admission_type'=>"IPD"),'order'=>'Billing.date DESC','group'=>array('Billing.patient_id')));
        //$add = $this->Billing->find('all',array('conditions'=>array('patient_id'=>$patientID,'location_id'=>$this->Session->read('locationid'))));
        //$this->set('advancePayment',$add);



        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array('Patient.id' => 'desc', 'Billing.date' => 'DESC'),
            'fields' => array('Patient.lookup_name', 'Patient.discharge_date', 'Patient.remark', 'FinalBilling.total_amount', 'FinalBilling.created_by', 'Consultant.refferer_doctor_id', 'CONCAT(Consultant.first_name," ",Consultant.last_name) as full_name',
                'PharmacySalesBill.total', 'LabTestPayment.total_amount', 'RadiologyTestPayment.total_amount,Billing.patient_id'),
            'conditions' => array('Patient.location_id' => $this->Session->read('locationid'), 'Patient.is_discharge' => 1, 'Patient.is_deleted' => 0,
                'Patient.admission_type' => "IPD"),
            'group' => array('Billing.patient_id'),);
        $result = $this->paginate('Patient');
        if (!empty($result)) {
            foreach ($result as $patientKey => $patientValue) {
                $ids[] = $patientValue['Patient']['id'];
                $customArray[$patientValue['Patient']['id']] = $patientValue;
            }
        }

        $labTotal = $this->LaboratoryTestOrder->find('all', array('fields' => array('SUM(LaboratoryTestOrder.amount) as total',
                'LaboratoryTestOrder.patient_id'),
            'conditions' => array('LaboratoryTestOrder.is_print' => '0', 'LaboratoryTestOrder.patient_id' => $ids), 'group' => array('LaboratoryTestOrder.patient_id')));

        $radTotal = $this->RadiologyTestOrder->find('all', array('fields' => array('SUM(RadiologyTestOrder.amount) as total',
                'RadiologyTestOrder.patient_id'),
            'conditions' => array('RadiologyTestOrder.is_deleted' => '0', 'RadiologyTestOrder.patient_id' => $ids), 'group' => array('RadiologyTestOrder.patient_id')));

        $pharmacyTotal = $this->PharmacySalesBill->find('all', array('fields' => array('SUM(PharmacySalesBill.total) as total',
                'PharmacySalesBill.patient_id'),
            'conditions' => array('PharmacySalesBill.is_deleted' => '0', 'PharmacySalesBill.patient_id' => $ids), 'group' => array('PharmacySalesBill.patient_id')));

        foreach ($labTotal as $labKey => $labValue) {
            $customArray[$labValue['LaboratoryTestOrder']['patient_id']]['LaboratoryTestOrder'] = $labValue[0];
        }
        foreach ($radTotal as $radKey => $radValue) {
            $customArray[$radValue['RadiologyTestOrder']['patient_id']]['RadiologyTestOrder'] = $radValue[0];
        }
        foreach ($pharmacyTotal as $pharmKey => $pharmValue) {
            $customArray[$pharmValue['PharmacySalesBill']['patient_id']]['PharmacySalesBill'] = $pharmValue[0];
        }

        $this->set(array('results' => $customArray, 'pharmacyTotal' => $pharmacyTotal, 'labTotal' => $labTotal, 'radTotal' => $radTotal));

        /* foreach ($result as $key => $value)
          {
          $patientID[] = $result[$key]['Patient']['id'] ;
          } */
        $userName = $this->User->getUserDetails($result[0]['FinalBilling']['created_by']);
        $this->set('userName', $userName['User']['username']);
        $this->set('results', $result);
        $this->render('admin_discharge_report_xls', false);
    }

    /*     * ************************************************************************************************************** */

    public function admin_echs_report($type = NULL) {
        $this->layout = 'advance';
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Person');
        $tariffID = $this->TariffStandard->getTariffStandardID("ECHS");
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('FinalBilling.patient_id=Patient.id'/* ,'FinalBilling.bill_uploading_date NOT'=>NULL */),
                    'fields' => array('FinalBilling.id', 'FinalBilling.other_deduction', 'FinalBilling.bill_uploading_date', 'FinalBilling.amount_paid', 'FinalBilling.bill_number', 'FinalBilling.tds', 'FinalBilling.package_amount')))), false);


        $this->Patient->bindModel(array('belongsTo' => array(
                'Person' => array('foreignKey' => false, 'conditions' => array('Patient.person_id=Person.id')),
                'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id')),
                )));
        $conditions = array('Patient.is_hidden_from_report' => 0, 'Patient.is_deleted' => 0, 'Patient.is_discharge' => 1, 'Patient.tariff_standard_id' => $tariffID, 'Patient.admission_type' => "IPD", 'Patient.location_id' => $this->Session->read('locationid'));


        // 		         $result = $this->Patient->find('all',array(
        // 				'fields'=>array('Patient.id','Patient.lookup_name','Patient.relative_name','Person.relation_to_employee','Patient.form_received_on','FinalBilling.bill_number','Patient.discharge_date','FinalBilling.total_amount','FinalBilling.amount_paid','FinalBilling.amount_pending',
        // 				'FinalBilling.id','Patient.remark','FinalBilling.bill_uploading_date'),
        // 				'conditions' =>$conditons));

        if (!empty($this->request->query)) {
            unset($conditions['Patient.is_hidden_from_report']);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if (!empty($this->request->query['from'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['to'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
            }
            if ($to)
                $conditions['Patient.form_received_on <='] = $to;
            if ($from)
                $conditions['Patient.form_received_on >='] = $from;
        }

        $fields = array('Patient.id', 'Patient.lookup_name', 'Patient.admission_type', 'Patient.card_no', 'FinalBilling.cmp_paid_date', 'Patient.relative_name', 'Person.id', 'Person.relation_to_employee',
            'Person.echs_card_no', 'Patient.form_received_on', 'FinalBilling.hospital_invoice_amount', 'FinalBilling.cmp_amt_paid', 'FinalBilling.bill_number', 'Patient.discharge_date', 'FinalBilling.total_amount',
            'FinalBilling.amount_paid', 'FinalBilling.amount_pending', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.id', 'Patient.remark', 'Patient.is_hidden_from_report', 'FinalBilling.bill_uploading_date',
            'FinalBilling.other_deduction', 'FinalBilling.tds', 'FinalBilling.package_amount', 'FinalBilling.other_deduction_modified', 'PatientDocument.id', 'PatientDocument.filename');


        if ($type != 'excel') {
            $this->paginate = array(
                'limit' => 10,
                'order' => array('Patient.form_received_on' => 'desc'),
                'fields' => $fields,
                'conditions' => $conditions);
            $result = $this->paginate('Patient');
        } else {
            $result = $this->Patient->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => array('Patient.form_received_on' => 'desc')));
        }
        //get total invoice amount and paid
        $totalData = $this->getTotalInvoiceAndPaidAmnt($tariffID);
        $suspenseDetails = $this->getCorporateSuspenseAmount($tariffID);
        $this->set(array('totalInvoice' => $totalData['totalInvoice'], 'totalAdvancePaid' => $totalData['totalPaid'],
            'suspenseDetails' => $suspenseDetails['suspenseDetails'], 'suspenseAmount' => $suspenseDetails['totalSuspenseAmount']));

        $this->set('results', $result);
        //to get the total payment of that patient by Swapnil - 04.11.2015
        $this->loadModel('Billing');
        foreach ($result as $key => $val) {
            $totalVal[$val['Patient']['id']] = $this->Billing->getPatientTotalBill($val['Patient']['id'], $val['Patient']['admission_type']);
            $totalPaid[$val['Patient']['id']] = $this->Billing->getPatientPaidAmount($val['Patient']['id']);
            $totalDiscount[$val['Patient']['id']] = $this->Billing->getPatientDiscountAmount($val['Patient']['id']);
        }
        $this->set(compact(array('totalPaid', 'totalDiscount')));
        $this->set('totalAmount', $totalVal);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_echs_xls', false);
        }
        $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'), 'conditions' => array('TariffStandard.is_deleted' => 0, /* 'TariffStandard.code_name IS NOT NULL', */'TariffStandard.location_id' => $this->Session->read('locationid'))));
        $this->set('tariffData', $tariffData);
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
    }

    public function admin_echs_xls() {

        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Person');
        $tariffID = $this->TariffStandard->getTariffStandardID("ECHS");
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('FinalBilling.patient_id=Patient.id', 'FinalBilling.bill_uploading_date NOT' => NULL),
                    'fields' => array('FinalBilling.id', 'FinalBilling.other_deduction', 'FinalBilling.cmp_paid_date', 'FinalBilling.bill_uploading_date', 'FinalBilling.amount_paid', 'FinalBilling.bill_number', 'FinalBilling.tds', 'FinalBilling.package_amount')))), false);


        $this->Patient->bindModel(array('belongsTo' => array(
                'Person' => array('foreignKey' => false, 'conditions' => array('Patient.person_id=Person.id'),
            ))));
        $conditions = array('Patient.is_hidden_from_report' => 0, 'Patient.is_discharge' => 1, 'Patient.tariff_standard_id' => 16, 'Patient.is_deleted' => 0, 'Patient.admission_type' => "IPD", 'Patient.location_id' => $this->Session->read('locationid'));


        // 		         $result = $this->Patient->find('all',array(
        // 				'fields'=>array('Patient.id','Patient.lookup_name','Patient.relative_name','Person.relation_to_employee','Patient.form_received_on','FinalBilling.bill_number','Patient.discharge_date','FinalBilling.total_amount','FinalBilling.amount_paid','FinalBilling.amount_pending',
        // 				'FinalBilling.id','Patient.remark','FinalBilling.bill_uploading_date'),
        // 				'conditions' =>$conditons));

        if (!empty($this->request->query)) {
            //debug($this->request->query);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if (!empty($this->request->query['from'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
            }//debug($from);
            if (!empty($this->request->query['to'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
            }

            if ($to)
                $conditions['Patient.form_received_on <='] = $to;
            if ($from)
                $conditions['Patient.form_received_on >='] = $from;
        }

        $this->paginate = array(
            'limit' => 10,
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.relative_name', 'Person.id', 'Person.relation_to_employee', 'Person.echs_card_no', 'Patient.form_received_on', 'FinalBilling.cmp_amt_paid', 'FinalBilling.cmp_paid_date',
                'FinalBilling.bill_number', 'Patient.discharge_date', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.total_amount', 'FinalBilling.amount_paid', 'FinalBilling.amount_pending',
                'FinalBilling.id', 'Patient.remark', 'Patient.is_hidden_from_report', 'FinalBilling.bill_uploading_date', 'FinalBilling.other_deduction', 'FinalBilling.tds', 'FinalBilling.package_amount', 'FinalBilling.other_deduction_modified'),
            'conditions' => $conditions);

        $result = $this->paginate('Patient'); //debug($result); exit;
        $this->set('results', $result);
        $this->render('admin_echs_xls', false);
    }

    public function getBillNo($id, $no) {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->loadModel('FinalBilling');

        if (!empty($id)) {
            //$this->FinalBilling->id = $id;	//$id holds the patient's id
            $this->request->data['FinalBilling']['id'] = $id;
            $this->request->data['FinalBilling']['bill_number'] = $no;
            $this->FinalBilling->save($this->request->data);  //update the extension_status of patient
        }
    }

    public function getBillamt($id, $amount, $patientId) {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->loadModel('FinalBilling');
        if (!empty($id)) {
            $this->request->data['FinalBilling']['id'] = $id;
            $this->request->data['FinalBilling']['hospital_invoice_amount'] = $amount;
            $this->FinalBilling->save($this->request->data);  //update the extension_status of patient
        }
    }

    public function CMPpaidDate($id) {
        $this->autoRender = false;
        $this->layout = 'ajax';
        //$this->uses = array('FinalBilling'); 
        $this->loadModel('FinalBilling');
        //debug($id);exit;

        if ($this->request->data) {
            $this->request->data['FinalBilling']['id'] = $id; //
            $cmpDate = $this->DateFormat->formatDate2STDForReport($this->request->data['date'], Configure::read('date_format'));
            $this->request->data['FinalBilling']['cmp_paid_date'] = $cmpDate;

            $this->FinalBilling->save($this->request->data);
        }
    }

    /*     * **********************************************CGHS report******************************************************** */
    /*     * ***********************************************Swati********************************************************* */

    public function admin_cghs_report($type = NULL) {
        $this->layout = 'advance';
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling');
        $tariffID = $this->TariffStandard->getTariffStandardID("CGHS");
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id')),
                )));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id'/* ,'FinalBilling.bill_uploading_date NOT'=>NULL */),
                    'fields' => array('FinalBilling.id', 'FinalBilling.other_deduction', 'FinalBilling.bill_uploading_date', 'FinalBilling.amount_paid', 'FinalBilling.bill_number', 'FinalBilling.tds', 'FinalBilling.package_amount')))), false);

        $conditions1 = array('Patient.tariff_standard_id' => $tariffID, 'Patient.is_discharge' => '1', 'Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid'));


        if (!empty($this->request->query)) {
            unset($conditions1['Patient.is_hidden_from_report']);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions1['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if (!empty($this->request->query['from'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['to'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
            }
            if ($to)
                $conditions1['Patient.form_received_on <='] = $to;
            if ($from)
                $conditions1['Patient.form_received_on >='] = $from;
        }
        //debug($conditions1);
        $fields = array('Patient.id', 'Patient.lookup_name', 'Patient.admission_type', 'Patient.card_no', 'Patient.claim_id', 'Patient.form_received_on', 'FinalBilling.bill_uploading_date', 'FinalBilling.other_deduction', 'Patient.form_received_on',
            'FinalBilling.tds', 'FinalBilling.hospital_invoice_amount', 'FinalBilling.bill_number', 'FinalBilling.amount_paid', 'Patient.discharge_date', 'FinalBilling.total_amount', 'FinalBilling.cmp_amt_paid',
            'FinalBilling.cmp_paid_date', 'FinalBilling.amount_paid', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.amount_pending', 'FinalBilling.other_deduction_modified', 'Patient.is_hidden_from_report',
            'FinalBilling.id', 'Patient.remark', 'FinalBilling.package_amount', 'PatientDocument.id', 'PatientDocument.filename');
        if ($type != 'excel') {
            $this->paginate = array(
                'limit' => 10,
                'order' => array('Patient.form_received_on' => 'desc'),
                'fields' => $fields,
                'conditions' => $conditions1);
            $result = $this->paginate('Patient');
        } else {
            $result = $this->Patient->find('all', array('fields' => $fields, 'conditions' => $conditions1, 'order' => array('Patient.form_received_on' => 'desc')));
        }

        //get total invoice amount and paid
        $totalData = $this->getTotalInvoiceAndPaidAmnt($tariffID);
        $suspenseDetails = $this->getCorporateSuspenseAmount($tariffID);
        $this->set(array('totalInvoice' => $totalData['totalInvoice'], 'totalAdvancePaid' => $totalData['totalPaid'],
            'suspenseDetails' => $suspenseDetails['suspenseDetails'], 'suspenseAmount' => $suspenseDetails['totalSuspenseAmount']));
        $this->loadModel('Billing');
        //to get the total payment of that patient by Swapnil - 04.11.2015
        foreach ($result as $key => $val) {
            $totalVal[$val['Patient']['id']] = $this->Billing->getPatientTotalBill($val['Patient']['id'],$val['Patient']['admission_type']);
            $totalPaid[$val['Patient']['id']] = $this->Billing->getPatientPaidAmount($val['Patient']['id']);
            //$totalDiscount[$val['Patient']['id']] = $this->Billing->getPatientDiscountAmount($val['Patient']['id']);
        }
        $this->set('totalPaid', $totalPaid);
        //$this->set('totalDiscount',$totalDiscount);
        $this->set('totalAmount',$totalVal);
        $this->set('results', $result);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_cghs_xls', false);
        }
        $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'), 'conditions' => array('TariffStandard.is_deleted' => 0, /* 'TariffStandard.code_name IS NOT NULL', */'TariffStandard.location_id' => $this->Session->read('locationid'))));
        $this->set('tariffData', $tariffData);
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
    }

    public function admin_cghs_xls() {
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling');
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id', 'FinalBilling.bill_uploading_date NOT' => NULL),
                    'fields' => array('FinalBilling.id', 'FinalBilling.other_deduction', 'FinalBilling.bill_uploading_date', 'FinalBilling.amount_paid', 'FinalBilling.bill_number', 'FinalBilling.tds')))));

        $conditions = array('Patient.tariff_standard_id' => '4', 'Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' => 0,
            'Patient.location_id' => $this->Session->read('locationid'));

        $result = $this->Patient->find('all', array(
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.admission_type', 'FinalBilling.other_deduction', 'Patient.form_received_on', 'FinalBilling.tds', 'FinalBilling.bill_number', 'FinalBilling.amount_paid', 'Patient.discharge_date', 'FinalBilling.total_amount', 'FinalBilling.amount_paid', 'FinalBilling.amount_pending', 'FinalBilling.cmp_amt_paid', 'FinalBilling.cmp_paid_date',
                'FinalBilling.id', 'Patient.remark', 'FinalBilling.bill_uploading_date', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.package_amount'),
            'conditions' => array('Patient.tariff_standard_id' => '4', 'Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid'))));

        foreach ($result as $key => $value) {
            $patientID[] = $result[$key]['Patient']['id'];
        }

        $this->set('results', $result);
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
        $this->render('admin_cghs_xls', false);
        if ($this->request->query)
            $this->render('ajax_cghs_reports');
    }

    /*     * ***********************************swatii********************************************************* */

    /**     * *******************************************WCL report swati*********************************************************** @return */
    public function admin_wcl_report($type = NULL) {
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing','Account','CorporateSublocation');
        $this->layout = 'advance';
        $patientStatusConfig = Configure::read('onDischargeStatus');
        $tariffID = $this->TariffStandard->getTariffStandardID("WCL");
        $this->set('subLocations',$this->CorporateSublocation->getCorporateSublocationList($tariffID));
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array(
        		'belongsTo' => array(
                	'PatientDocument' => array('foreignKey' => false,
                			'conditions' => array('PatientDocument.patient_id=Patient.id')),
                	'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false,
                			'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                    		'fields' => array('FinalBilling.id', 'FinalBilling.other_deduction', 'FinalBilling.paid_to_patient',
                    				'FinalBilling.discount', 'FinalBilling.bill_uploading_date', 'FinalBilling.amount_paid',
                    				'FinalBilling.bill_number', 'FinalBilling.tds', 'FinalBilling.package_amount')
                			)
        				)), false);

        $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'),
        		'conditions' => array('TariffStandard.is_deleted' => 0,'TariffStandard.location_id' => $this->Session->read('locationid'))));
        $this->set('tariffData', $tariffData);
        $this->set('banks', $this->Account->getBankNameList());
        if(empty($this->request->query)){
        	$statusCondition['Patient.claim_status'] = $patientStatusConfig['File Submitted'];
        	$status = $patientStatusConfig['File Submitted'];
        }
      
        $conditions1 = array('Patient.tariff_standard_id' => $tariffID, 'Patient.admission_type' => 'IPD', 'Patient.is_discharge' => '1', 'Patient.is_deleted' => 0,
        		'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid'),$statusCondition);
        if (!empty($this->request->query)) {
            unset($conditions1['Patient.is_hidden_from_report']);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions1['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if (!empty($this->request->query['from'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['to'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
            }
            if ($to){
                $conditions1['Patient.form_received_on <='] = $to;
            }
            if ($from){
                $conditions1['Patient.form_received_on >='] = $from;
            }
            if (!empty($this->request->query['status'])){
            	$conditions1['Patient.status'] = $patientStatusConfig[$this->request->query['status']];
            	$status = $patientStatusConfig[$this->request->query['status']];
            }
            
            if (!empty($this->request->query['sub_location'])){
            	$conditions1['Patient.corporate_sublocation_id'] = $this->request->query['sub_location'];
            	$subLocationId = $this->request->query['sub_location'];
            }
        }
        $fields = array('Patient.id', 'Patient.lookup_name', 'Patient.admission_type', 'Patient.form_received_on', 'FinalBilling.bill_uploading_date', 'FinalBilling.other_deduction',
            'Patient.form_received_on', 'FinalBilling.hospital_invoice_amount', 'FinalBilling.cmp_amt_paid', 'FinalBilling.cmp_paid_date', 'FinalBilling.tds', 'FinalBilling.bill_number', 'FinalBilling.amount_paid',
            'Patient.discharge_date', 'FinalBilling.total_amount', 'FinalBilling.amount_paid', 'FinalBilling.amount_pending', 'FinalBilling.other_deduction_modified',
            'Patient.is_hidden_from_report', 'FinalBilling.id', 'Patient.remark', 'FinalBilling.package_amount', 'PatientDocument.id', 'PatientDocument.filename','Patient.corporate_sublocation_id','Patient.name_of_ip','Patient.relation_to_employee');

        if ($type != 'excel') {
            $this->paginate = array(
                'limit' => 10,
                'order' => array('Patient.form_received_on' => 'desc'),
                'fields' => $fields,
                'conditions' => $conditions1);
            $result = $this->paginate('Patient');
        } else {
            $result = $this->Patient->find('all', array('fields' => $fields, 'conditions' => $conditions1,
            		'order' => array('Patient.form_received_on' => 'desc')));
        }
        //get total invoice amount and paid
        $totalData = $this->getTotalInvoiceAndPaidAmnt($tariffID, 'IPD');
        $suspenseDetails = $this->getCorporateSuspenseAmount($tariffID);
        $this->set(array('totalInvoice' => $totalData['totalInvoice'], 'totalAdvancePaid' => $totalData['totalPaid'],
            'suspenseDetails' => $suspenseDetails['suspenseDetails'], 'suspenseAmount' => $suspenseDetails['totalSuspenseAmount']));
    
        //to get the total payment of that patient by Swapnil - 04.11.2015
        foreach ($result as $key => $val) {
            $totalVal[$val['Patient']['id']] = $this->Billing->getPatientTotalBill($val['Patient']['id'],$val['Patient']['admission_type']);
            $totalPaid[$val['Patient']['id']] = $this->Billing->getPatientPaidAmount($val['Patient']['id']);
        }
        $this->set(compact(array('totalPaid', 'totalDiscount','status','subLocationId')));
        $this->set(array('totalAmount' => $totalVal));
        $this->set('results', $result);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_wcl_xls', false);
        }
    }

    public function admin_wcl_xls() {
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling',);

        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id', 'FinalBilling.bill_uploading_date NOT' => NULL),
                    'fields' => array('FinalBilling.id', 'FinalBilling.other_deduction', 'FinalBilling.bill_uploading_date', 'FinalBilling.amount_paid', 'FinalBilling.bill_number', 'FinalBilling.tds')))));

        $conditions = array('Patient.tariff_standard_id' => '8', 'Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' => 0,
            'Patient.location_id' => $this->Session->read('locationid'));

        $result = $this->Patient->find('all', array(
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'FinalBilling.cmp_amt_paid', 'FinalBilling.cmp_paid_date', 'FinalBilling.other_deduction', 'Patient.form_received_on',
                'FinalBilling.tds', 'FinalBilling.bill_number', 'FinalBilling.amount_paid', 'Patient.discharge_date', 'FinalBilling.total_amount', 'FinalBilling.amount_paid',
                'FinalBilling.amount_pending', 'FinalBilling.id', 'Patient.remark', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.bill_uploading_date', 'FinalBilling.package_amount'),
            'conditions' => array('Patient.tariff_standard_id' => '8', 'Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' => 0,
                'Patient.location_id' => $this->Session->read('locationid'))));

        foreach ($result as $key => $value) {
            $patientID[] = $result[$key]['Patient']['id'];
        }

        $this->set('results', $result);
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
        $this->render('admin_wcl_xls', false);
        if ($this->request->query)
            $this->render('ajax_wcl_reports');
    }

    /*     * ***********************************BSNL Report swati********************************************************* */

    public function admin_bsnl_report($type = NULL) {
        $this->layout = 'advance';
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Person', 'Billing');
        $tariffID = $this->TariffStandard->getTariffStandardID("BSNL");
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));


        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id'/* ,'FinalBilling.bill_uploading_date NOT'=>NULL */),
                    'fields' => array('FinalBilling.id', 'Patient.relative_name', 'FinalBilling.discharge_date', 'FinalBilling.other_deduction', 'FinalBilling.bill_uploading_date',
                        'FinalBilling.amount_paid', 'FinalBilling.bill_number', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.package_amount', 'FinalBilling.tds')))), false);

        $this->Patient->bindModel(array('belongsTo' => array(
                'Person' => array('foreignKey' => false, 'conditions' => array('Patient.person_id=Person.id')),
                'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id'))
                )));

        $conditions = array('Patient.tariff_standard_id' => $tariffID, 'Patient.is_discharge' => '1', 'Patient.admission_type' => 'IPD',
            'Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid'));

        if (!empty($this->request->query)) {
            unset($conditions['Patient.is_hidden_from_report']);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if (!empty($this->request->query['from'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['to'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
            }

            if ($to)
                $conditions['Patient.form_received_on <='] = $to;
            if ($from)
                $conditions['Patient.form_received_on >='] = $from;
        }

        $this->paginate = array(
            'limit' => 10,
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name, Patient.admission_type', 'Patient.relative_name', 'Person.relation_to_employee', 'Patient.form_received_on', 'Patient.discharge_date',
                'FinalBilling.cmp_amt_paid', 'FinalBilling.hospital_invoice_amount', 'FinalBilling.cmp_paid_date', 'FinalBilling.bill_number', 'FinalBilling.id', 'FinalBilling.total_amount', 'Patient.remark',
                'FinalBilling.package_amount', 'FinalBilling.bill_uploading_date', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.other_deduction_modified', 'FinalBilling.other_deduction', 'FinalBilling.tds',
                'Patient.is_hidden_from_report', 'FinalBilling.amount_paid', 'PatientDocument.id', 'PatientDocument.filename'),
            'conditions' => $conditions);

        $result = $this->paginate('Patient');
        foreach ($result as $key => $value) {
            $patientID[] = $result[$key]['Patient']['id'];
            //to get the total payment of that patient by Swapnil - 04.11.2015
            $totalVal[$value['Patient']['id']] = $this->Billing->getPatientTotalBill($value['Patient']['id'], $value['Patient']['admission_type']);
            $totalPaid[$value['Patient']['id']] = $this->Billing->getPatientPaidAmount($value['Patient']['id']);
        }

        //get total invoice amount and paid
        $totalData = $this->getTotalInvoiceAndPaidAmnt($tariffID, 'IPD');
        $suspenseDetails = $this->getCorporateSuspenseAmount($tariffID);
        $this->set(array('totalInvoice' => $totalData['totalInvoice'], 'totalAdvancePaid' => $totalData['totalPaid'],
            'suspenseDetails' => $suspenseDetails['suspenseDetails'], 'suspenseAmount' => $suspenseDetails['totalSuspenseAmount']));
        
        $this->set('totalPaid', $totalPaid);
        $this->set('totalAmount', $totalVal);
        $this->set('results', $result);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_bsnl_xls', false);
        }
        $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'), 'conditions' => array('TariffStandard.is_deleted' => 0, /* 'TariffStandard.code_name IS NOT NULL', */'TariffStandard.location_id' => $this->Session->read('locationid'))));
        $this->set('tariffData', $tariffData);
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
    }

    //function to get total invoice and paid amount by Swapnil - 16.11.2015
    public function getTotalInvoiceAndPaidAmnt($tariffStdId, $cond = null) {
        $this->uses = array('Patient', 'FinalBilling', 'Billing');
        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array(
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => array('FinalBilling.patient_id = Patient.id')
                )
                )));
        $conditions = array();
        if (!empty($cond)) {
            $conditions['Patient.admission_type'] = "IPD";
        }
        $patientData = $this->Patient->find('all', array(
            'fields' => array('Patient.id', 'Patient.lookup_name', 'FinalBilling.id', 'FinalBilling.hospital_invoice_amount', 'FinalBilling.tds'), 'conditions' => array('Patient.is_deleted' => '0',
                'Patient.tariff_standard_id' => $tariffStdId, $conditions, 'Patient.is_discharge' => '1', 'Patient.is_hidden_from_report' => '0', 'FinalBilling.hospital_invoice_amount IS NOT NULL'), 'order' => array('Patient.id' => 'DESC')));
        foreach ($patientData as $key => $value) {
            $returnData['totalPaid'] = $returnData['totalPaid'] + $this->Billing->getPatientPaidAmount($value['Patient']['id']);
            $returnData['totalInvoice'] = $returnData['totalInvoice'] + $value['FinalBilling']['hospital_invoice_amount'];
        }
        return $returnData;
    }

    //function to get the suspense amounts
    public function getCorporateSuspenseAmount($tariffStdId) {
        $this->uses = array('Account', 'AccountReceipt');
        $this->AccountReceipt->bindModel(array(
            'belongsTo' => array(
                'Account' => array('foreignKey' => false, 'conditions' => array('AccountReceipt.user_id=Account.id')),
                'User' => array('foreignKey' => false, 'conditions' => array('AccountReceipt.create_by=User.id')),
                )), false);
        $receiptData = $this->AccountReceipt->find('all', array('fields' => array('AccountReceipt.id', 'AccountReceipt.paid_amount', 'AccountReceipt.date', 'AccountReceipt.narration',
                'Account.name', 'Account.system_user_id', 'AccountReceipt.date', 'User.first_name', 'User.last_name', 'AccountReceipt.tds_amount'),
            'conditions' => array('AccountReceipt.type' => Configure::read('SuspenseType'), 'AccountReceipt.is_deleted' => '0', 'Account.system_user_id' => $tariffStdId)));

        foreach ($receiptData as $key => $value) {
            $returnDetail['totalSuspenseAmount'] = $returnDetail['totalSuspenseAmount'] + $value['AccountReceipt']['paid_amount'];
            if ($key != 0) {
                $output .= ', ';
            } else {
                $output = 'EFT of ';
            }
            $output .= 'Rs. ' . $value['AccountReceipt']['paid_amount'] . '/- received on dtd. ' . $this->DateFormat->formatDate2Local($value['AccountReceipt']['date'], Configure::read('date_format'));
        }
        $returnDetail['suspenseDetails'] = $output;
        return $returnDetail;
    }

    public function admin_bsnl_xls() {
        $this->uses = array('Patient', 'TariffStandard', 'Person', 'FinalBilling');
        $tariffID = $this->TariffStandard->getTariffStandardID("BSNL");
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'Person' => array('foreignKey' => false, 'conditions' => array('Person.id=Patient.person_id')),
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('FinalBilling.patient_id=Patient.id', 'FinalBilling.bill_uploading_date NOT' => NULL)),
                )));

        $conditions = array('Patient.tariff_standard_id' => $tariffID, 'Patient.is_discharge' => '1', 'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid'));

        if (!empty($this->request->query)) {
            if ($this->request->query['lookup_name'] != 'null') {
                $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
        }
        $this->paginate = array(
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Patient.relative_name', 'Person.relation_to_employee', 'Patient.form_received_on', 'Patient.discharge_date', 'FinalBilling.cmp_amt_paid', 'FinalBilling.cmp_paid_date',
                'FinalBilling.bill_number', 'FinalBilling.id', 'FinalBilling.total_amount', 'Patient.remark', 'FinalBilling.package_amount',
                'FinalBilling.bill_uploading_date', 'FinalBilling.other_deduction', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.tds', 'FinalBilling.amount_paid',),
            'conditions' => $conditions, 'group' => array('Patient.id'));

        $result = $this->paginate('Patient');

        $this->set('results', $result);


        $this->render('admin_bsnl_xls', false);
    }

    /*     * ***************************************************************************************** */

    public function admin_fci_report($type = NULL) {
        $this->layout = 'advance';
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Person', 'Billing');
        $tariffID = $this->TariffStandard->getTariffStandardID("FCI");
        //debug($tariffID);
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('FinalBilling.patient_id=Patient.id'/* ,'FinalBilling.bill_uploading_date NOT'=>NULL */)),
                'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id')),
                'Person' => array('primaryKey' => false, 'conditions' => array('Person.id=Patient.person_id'),
                    'fields' => 'Person.relation_to_employee', 'Person.name_of_ip'))));

        $conditions = array('Patient.tariff_standard_id' => $tariffID, 'Patient.admission_type' => 'IPD', 'Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid'));

        if (!empty($this->request->query)) {
            unset($conditions['Patient.is_hidden_from_report']);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if (!empty($this->request->query['from'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['to'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
            }

            if ($to)
                $conditions['Patient.form_received_on <='] = $to;
            if ($from)
                $conditions['Patient.form_received_on >='] = $from;
        }
        $fields = array('Patient.id', 'Patient.lookup_name, Patient.admission_type', 'Patient.card_no', 'Person.relation_to_employee', 'Person.name_of_ip', 'Patient.form_received_on', 'Patient.discharge_date',
            'FinalBilling.cmp_amt_paid', 'FinalBilling.hospital_invoice_amount', 'FinalBilling.cmp_paid_date', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.bill_number', 'FinalBilling.id', 'FinalBilling.total_amount', 'Patient.remark',
            'FinalBilling.package_amount', 'FinalBilling.bill_uploading_date', 'FinalBilling.other_deduction', 'FinalBilling.tds', 'Patient.is_hidden_from_report',
            'Person.id', 'Person.fci_card_no', 'FinalBilling.other_deduction_modified', 'PatientDocument.id', 'PatientDocument.filename');
        if ($type != 'excel') {
            $this->paginate = array(
                'limit' => 10,
                'order' => array('Patient.form_received_on' => 'desc'),
                'fields' => $fields,
                'conditions' => $conditions);
            $result = $this->paginate('Patient');
        } else {
            $result = $this->Patient->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => array('Patient.form_received_on' => 'desc')));
        }
        //get total invoice amount and paid
        $totalData = $this->getTotalInvoiceAndPaidAmnt($tariffID, 'IPD');
        $suspenseDetails = $this->getCorporateSuspenseAmount($tariffID);
        $this->set(array('totalInvoice' => $totalData['totalInvoice'], 'totalAdvancePaid' => $totalData['totalPaid'],
            'suspenseDetails' => $suspenseDetails['suspenseDetails'], 'suspenseAmount' => $suspenseDetails['totalSuspenseAmount']));
        $this->loadModel('Billing');
        $this->set('results', $result);
        foreach ($result as $key => $value) {
            //to get the total payment of that patient by Swapnil - 04.11.2015
            $totalVal[$value['Patient']['id']] = $this->Billing->getPatientTotalBill($value['Patient']['id'],$value['Patient']['admission_type']);
            $totalPaid[$value['Patient']['id']] = $this->Billing->getPatientPaidAmount($value['Patient']['id']);
        }
        $this->set('totalPaid', $totalPaid);
        $this->set('totalAmount', $totalVal);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_fci_xls', false);
        }
        $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'), 'conditions' => array('TariffStandard.is_deleted' => 0, /* 'TariffStandard.code_name IS NOT NULL', */'TariffStandard.location_id' => $this->Session->read('locationid'))));
        $this->set('tariffData', $tariffData);
        $this->loadModel('Account');
        $this->set('banks', $this->Account->getBankNameList());
    }

    /*     * ***************************************************************************************** */

    public function admin_fci_xls() {
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Person');
        $tariffID = $this->TariffStandard->getTariffStandardID("FCI");
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('FinalBilling.patient_id=Patient.id', 'FinalBilling.bill_uploading_date NOT' => NULL)),
                /* 'foreignKey'=>false,
                  'conditions'=>array('FinalBilling.patient_id=Patient.id'),
                  'fields'=>array('FinalBilling.package_amount')), */

                'Person' => array('primaryKey' => false,
                    'conditions' => array('Person.id=Patient.person_id'),
                    'fields' => 'Person.relation_to_employee', 'Person.name_of_ip'))));



        $conditions = array('Patient.tariff_standard_id' => $tariffID, 'Patient.is_deleted' => 0, 'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid'));

        if (!empty($this->request->query)) {
            if ($this->request->query['lookup_name'] != 'null') {
                $conditions['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
        }

        $this->paginate = array(
            'limit' => 15,
            'order' => array('Patient.form_received_on' => 'desc'),
            'fields' => array('Patient.id', 'Patient.lookup_name', 'Person.relation_to_employee', 'Person.name_of_ip', 'Patient.form_received_on', 'Patient.discharge_date', 'FinalBilling.cmp_amt_paid', 'FinalBilling.cmp_paid_date',
                'FinalBilling.bill_number', 'FinalBilling.id', 'FinalBilling.paid_to_patient', 'FinalBilling.discount', 'FinalBilling.total_amount', 'Patient.remark', 'FinalBilling.package_amount',
                'FinalBilling.bill_uploading_date', 'FinalBilling.other_deduction', 'FinalBilling.tds', 'Patient.is_hidden_from_report', 'Person.id', 'Person.fci_card_no', 'FinalBilling.other_deduction_modified'),
            'conditions' => $conditions, 'group' => array('Patient.id'));

        $result = $this->paginate('Patient');
        //debug($result);
        $this->set('results', $result);

        $this->render('admin_fci_xls', false);
    }

    /*     * **************************************************************************************************************** */

    public function getExtension($id, $status) {
        $this->uses = array('Patient');
        $this->autoRender = false;
        $this->layout = 'ajax';
        if ($status == 1) {
            $this->Patient->id = $id;
            $this->request->data['Patient']['id'] = $id; //$id holds the patient's id
            $this->request->data['Patient']['extension_status'] = $status;  //changing the extension_status to approved by 1
            $this->Patient->save($this->request->data);  //update the extension_status of patient
        }
    }

    /*     * **************************************************************************************************************** */

    public function getRemark($id, $val) {
        $this->uses = array('Patient');
        $this->autoRender = false;
        $this->Layout = 'ajax';
        if ($this->request->query['remark'] != NULL) {
            $this->request->data['Patient']['id'] = $id;
            $this->request->data['Patient']['remark'] = " " . $this->request->query['remark'] . " ";
            $this->Patient->save($this->request->data);
        }
    }

    public function setExpectedDateOfDischarge($id) {
        $this->uses = array('Patient');
        $this->autoRender = false;
        if ($this->request->query['likely_discharge_date'] != NULL) {
            $likelyDischargeDate = $this->DateFormat->formatDate2STD($this->request->query['likely_discharge_date'], Configure::read('date_format'));
            $updateArray = array('Patient.likely_discharge_date' => "'$likelyDischargeDate'");
            $this->Patient->updateAll($updateArray, array('Patient.id ' => $id));
        }
    }

    /*     * **************************************************************************************************************** */

    public function getdischargeRemark($id, $val) {
        $this->uses = array('Patient');
        $this->autoRender = false;
        $this->Layout = 'ajax';
        if ($val != NULL) {
            $this->Patient->id = $id;
            $this->request->data['Patient']['discharge_remark'] = $val;

            $this->Patient->save($this->request->data);
        }
    }

    /*     * ************************************EOF atul & lee**************************************************************************** */

    public function getUpdateStatus($id, $status_update, $tariffStandard = null) {
        $this->uses = array('Patient','Billing','ServiceBill','VoucherEntry','FinalBilling','ConsultantBilling','OptAppointment','PharmacyDuplicateSalesBill','PharmacySalesBill');
        $configStatus = Configure::read('onDischargeStatus');
        //$this->autoRender = false;
        //$this->layout = 'false';
        $this->Patient->id = $id; //$id holds the patient's id
        $this->request->data['Patient']['discharge_status'] = $status_update;
        $this->request->data['Patient']['claim_status'] = $status_update;  //changing the extension_status to approved by 1
        $this->request->data['Patient']['claim_status_change_date'] = date('Y-m-d H:i:s'); //update the current date & time while changing the stauts
        //$this->Patient->updateAll(array('Patient.claim_status'=>$status_update,'Patient.discharge_status'=>$status_update,'Patient.claim_status_change_date'=>date("Y-m-d H:i:s")),array('Patient.id'=>$id));
         
        if ($tariffStandard != "Private" && $tariffStandard != Configure::read('RGJAY') && $status_update == $configStatus['File Submitted']) {
            $finalData = $this->FinalBilling->find('first',array('fields'=>array('FinalBilling.is_bill_finalize'),
                'conditions'=>array('FinalBilling.patient_id'=>$id)));
            if(!isset($finalData['FinalBilling']['is_bill_finalize']) || $finalData['FinalBilling']['is_bill_finalize'] =='0'){
                echo json_encode('2');
                exit;
            } 
        }
        $this->Patient->save($this->request->data);  //update the extension_status of patient
         
        $billArrayData['Billing']['date'] = date('Y-m-d H:i:s');
        $billArrayData['Billing']['patient_id'] = $id ;
        $billArrayData['Billing']['remark'] = "";
        //BOF for RGJAY & Other corporate patient JV by amit jain
        if (($tariffStandard == Configure::read('RGJAY') && $status_update == $configStatus['Claim Doctor Approved']) || $tariffStandard != "Private" && $tariffStandard != Configure::read('RGJAY') && $status_update == $configStatus['File Submitted']) {
            $patientDetails = $this->Patient->getPatientAllDetails($id);
            $totalInvoiceAmount = $this->Billing->getPatientTotalBill($id,$patientDetails['Patient']['admission_type']);
            $this->FinalBilling->updateAll(array('FinalBilling.hospital_invoice_amount'=>$totalInvoiceAmount),array('FinalBilling.patient_id'=>$id));
            $this->FinalBilling->id = '';

        	$this->Billing->deleteRevokeJV($id);
        	$this->Billing->JVLabData($id);
        	$this->Billing->JVRadData($id);
        	$this->ServiceBill->JVServiceData($id);
        	$this->ConsultantBilling->JVConsultantData($id);
        	$this->OptAppointment->JVSurgeryData($id);
        	$this->Billing->jvMandatoryService($id);
        	
        	$isDuplicate = $this->Patient->getFlagUseDuplicateSalesCharge($id);
        	if($isDuplicate == 0){
        		$this->PharmacySalesBill->JVSaleBillData($id);
        	}else{
        		$pharmacyAmount = $this->PharmacyDuplicateSalesBill->getPharmacyTotal($id);
        		$pharAmount = $pharmacyAmount['0']['total'];
        		$this->PharmacySalesBill->JVSaleBillData($id,$pharAmount);
        	}
        	$this->Billing->addFinalVoucherLogJV($billArrayData,$id);
        }
        echo json_encode('1');
        exit;
        //EOF for RGJAY
    }

    /*     * **************************************************************************************************************** */

    public function getAssigned($id, $assigned) {

        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->uses = array('Patient');
        $this->Patient->id = $id; //$id holds the patient's id
        $this->request->data['Patient']['assigned_to'] = $assigned;  //changing the extension_status to approved by 1
        $this->Patient->save($this->request->data);  //update the extension_status of patient
    }

    /*     * **************************************************************************************************************** */

    public function updateDischargeDate() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->uses = array('Patient');

        if ($this->request->data) {
            $dischargeDate = $this->DateFormat->formatDate2STDForReport($this->request->data['date'], Configure::read('date_format'));
            $data = array('id' => $this->request->data['id'], 'discharge_update' => $dischargeDate);
            $this->Patient->save($data);
        }
    }

    public function updateDates() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->uses = array('Patient');
        Configure::write('debug', 2);
        if ($this->request->data) {
            debug($this->request->data);
            $field = $this->request->data['field'];
            $date = $this->DateFormat->formatDate2STDForReport($this->request->data['date'], Configure::read('date_format'));
            $this->Patient->id = $this->request->data['id'];
            $saveData[$field] = $date;
            //$this->Patient->updateAll(array('Patient.'.$field=>$date),array('Patient.id'=>$this->request->data['id']));
            //$data = array('id'=>$this->request->data['id'],'discharge_update'=>$dischargeDate);
            $this->Patient->save($saveData);
        }
    }

    /*     * **************************************************************************************************************** */

    function hideFromReportList($id) {
        $this->uses = array('Patient');
        $this->autoRender = false;
        $this->layout = false;
        if (!empty($id)) {
            $this->Patient->updateAll(array('Patient.is_hidden_from_report' => '1'), array('Patient.id' => $id));
        }
    }

    /*     * **************************************************************************************************************** */

    // Legal compliances reports- Leena

    public function admin_lifespring_reports() {
        
    }

    public function equip_maintenance() {
        $this->layout = false;
    }

    public function mtp_report() {
        $this->layout = false;
    }

    public function pndt_report() {
        $this->layout = false;
    }

    public function nmc_birth_report() {
        $this->layout = false;

        $this->uses = array('Patient', 'Person', 'State');

        $this->layout = 'advance';
        $this->Person->bindModel(array(
            'belongsTo' => array(
                'ReminderPatientList' => array('foreignKey' => false, conditions => array('Person.id=ReminderPatientList.person_id')),
                'Appointment' => array('foreignKey' => false, conditions => array('Person.id=Appointment.person_id')),
                'State' => array('foreignKey' => false, conditions => array('Person.state=State.id'), 'fields' => array('State.name')),
                )), false);

        //exit;
        //if(!empty($this->params->query)){


        /* if(!empty($this->params->query['gender'])){
          $search_key['Patient.sex like '] = trim($this->params->query['gender'])."%" ;
          } */

        //debug($search_key);exit;

        $conditions = array($search_key);
        $conditions = array_filter($conditions);


        $data = $this->Person->find('first', array('fields' => array('Person.first_name', 'Person.last_name', 'Person.mother_name', 'Person.relative_name',
                'Person.sex', 'Person.age', 'Person.dob', 'Person.id', 'Person.landmark', 'Person.taluka', 'Person.city', 'Person.district',
                'Person.state', 'Person.person_local_number', 'State.name',
            ),
            'conditions' => array('Person.is_deleted' => 0, 'Person.location_id' => $this->Session->read('locationid'), /* $conditions */ 'Person.id' => 6408),
                //'group'=>array('Person.id'),
                //'order' => array('Person.id' => 'DESC')
                ));

        /* $this->paginate = array(
          'limit' => Configure::read('number_of_rows'),
          'group' => array('Person.id'),
          'order' => array('Person.id' => 'DESC'),
          'fields'=> array('Person.first_name','Person.last_name','Person.mother_name','Person.sex','Person.age','Person.dob','Person.id','Person.patient_uid','Person.landmark','Person.taluka','Person.person_local_number','ReminderPatientList.id',
          ),
          'conditions'=>array('Person.is_deleted'=>0,'Person.location_id'=>$this->Session->read('locationid'),/*$conditions *///'Person.id'=> 6408));
        //$data = $this->paginate('Person');  */
        debug($data);
        $this->set('data', $data);

        //}
    }

    public function equip_repair_maintain() {
        
    }

    public function assets_list() {
        
    }

    public function statement_showing_equipment_details() {
        
    }

    public function conversion_percentage_report($type = NULL, $doctor_id = NULL, $surgeon_id = NULL) {
        $this->uses = array('User', 'Appointment', 'OptAppointment', 'Patient');
        $this->layout = 'advance';
        $doctors = $this->User->getAllDoctors();

        $this->Appointment->bindModel(array(
            'belongsTo' => array(
                'Patient' => array('foreignKey' => false, 'conditions' => array('Patient.id =Appointment.patient_id')),
                'OptAppointment' => array('foreignKey' => false, 'conditions' => array('Appointment.patient_id =OptAppointment.patient_id')),
                'User' => array('foreignKey' => false, 'conditions' => array('Appointment.doctor_id=User.id')))), false);

        $this->OptAppointment->bindModel(array(
            'belongsTo' => array(
                'Patient' => array('foreignKey' => false, 'conditions' => array('Patient.id =OptAppointment.patient_id')),
                'Appointment' => array('foreignKey' => false, 'conditions' => array('Appointment.patient_id =OptAppointment.patient_id')),
                'User' => array('foreignKey' => false, 'conditions' => array('OptAppointment.doctor_id=User.id')))), false);

        $this->Patient->bindModel(array(
            'belongsTo' => array(
                'OptAppointment' => array('foreignKey' => false, 'conditions' => array('Patient.id =OptAppointment.patient_id')),
                'User' => array('foreignKey' => false, 'conditions' => array('OptAppointment.doctor_id=User.id'))
                )), false);

        if ($this->params->query) {
            if (!empty($this->params->query['dateFrom'])) {
                /* $dateFrom=date('Y-m-d',strtotime($this->params->query['dateFrom'])); */
                $Fromdate = str_replace('/', '-', $this->params->query['dateFrom']);
                $dateFrom = date('Y-m-d', strtotime($Fromdate));
            } else {
                $dateFrom = date('Y-m-d');
            }
            if (!empty($this->params->query['dateTo'])) {
                /* $dateTo=date('Y-m-d ',strtotime($this->params->query['dateTo'])); */
                $Todate = str_replace('/', '-', $this->params->query['dateTo']);
                $dateTo = date('Y-m-d ', strtotime($Todate));
            } else {
                $dateTo = date('Y-m-d');
            }
            $bothTime = array($dateFrom, $dateTo);
            $this->set('date', $bothTime);
            //Specific doctor's Patient List swati
            if (!empty($doctor_id)) {
                $this->paginate = array(
                    'limit' => Configure::read('number_of_rows'),
                    'order' => array('Appointment.date' => 'ASC'),
                    'fields' => array('Patient.lookup_name', 'Appointment.status', 'Appointment.date', 'User.first_name', 'User.last_name'),
                    'conditions' => array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' => $bothTime,
                        'Appointment.status NOT' => array('Scheduled', 'Pending', 'No-Show', 'Cancelled'),
                        'Appointment.doctor_id' => $doctor_id,
                        'Appointment.location_id' => $this->Session->read('locationid'), 'Appointment.is_deleted' => '0'));
                $this->set('doctor_id', $doctor_id);
                $this->set('patientList', $this->paginate('Appointment'));
                if ($type == 'excel' && !empty($doctor_id)) {
                    $this->layout = false;
                    $this->render('physician_wise_list_excel');
                } else {
                    $this->render('pie_chart_patientlist');
                }
            }
            //specific surgeon's patient list
            if (!empty($surgeon_id)) {
                $this->paginate = array(
                    'limit' => Configure::read('number_of_rows'),
                    'order' => array('Appointment.date' => 'ASC'),
                    'fields' => array('Patient.lookup_name'/* ,'Appointment.status','Appointment.date' */, 'User.first_name', 'User.last_name', 'OptAppointment.schedule_date'),
                    'conditions' => /* array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' =>$bothTime,
                      'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled'),
                      'Appointment.doctor_id' =>$surgeon_id,
                      'Appointment.patient_id' =>'OptAppointment.patient_id',
                      'OptAppointment.procedure_complete' => 1,
                      'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0')); */
                    array('DATE_FORMAT(OptAppointment.schedule_date, "%Y-%m-%d") BETWEEN ? AND ? ' => $bothTime,
                        'OptAppointment.doctor_id' => $surgeon_id, 'OptAppointment.procedure_complete' => 1));

                $this->set('doctor_id', $surgeon_id);
                $this->set('patientList', $this->paginate('OptAppointment'));
                if ($type == 'excel' && !empty($surgeon_id)) {
                    $this->layout = false;
                    $this->render('physician_wise_list_excel');
                } else {
                    $this->render('pie_chart_patientlist');
                }
            }

            foreach ($doctors as $key => $value) {
                $patientCount = $this->Appointment->find('all', array('fields' => array('COUNT(Appointment.id) as count'),
                    'conditions' => array('DATE_FORMAT(Appointment.date,"%Y-%m-%d") BETWEEN ? AND ? ' => $bothTime,
                        'Appointment.location_id' => $this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
                        'Appointment.doctor_id' => $key, 'Appointment.status NOT' => array('Scheduled', 'Pending', 'No-Show', 'Cancelled')
                        )));

                $surgeryCount = $this->OptAppointment->find('all', array('fields' => array('COUNT(OptAppointment.id) as count'),
                    'conditions' => array('DATE_FORMAT(OptAppointment.schedule_date,"%Y-%m-%d") BETWEEN ? AND ? ' => $bothTime,
                        'OptAppointment.location_id' => $this->Session->read('locationid'), 'OptAppointment.procedure_complete' => 1,
                        'OptAppointment.doctor_id' => $key
                        )));

                $pieData[$key]['name'] = $value;
                $pieData[$key]['count'] = $patientCount[0][0]['count'];
                $pieData[$key]['surgery_count'] = $surgeryCount[0][0]['count'];
                $doctorArray[$key] = $key;
            }
            $totalPatient = $this->Appointment->find('all', array('fields' => array('COUNT(Appointment.id) as count'),
                'conditions' => array('DATE_FORMAT(Appointment.date, "%Y-%m-%d") BETWEEN ? AND ? ' => $bothTime,
                    'Appointment.location_id' => $this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
                    'Appointment.doctor_id' => $doctorArray, 'Appointment.status NOT' => array('Scheduled', 'Pending', 'No-Show', 'Cancelled')
                    )));
        } else {
            //Specific doctor's Patient List
            if (!empty($doctor_id)) {

                $this->paginate = array(
                    'limit' => Configure::read('number_of_rows'),
                    'order' => array('Appointment.date' => 'ASC'),
                    'fields' => array('Patient.lookup_name', 'Appointment.status', 'Appointment.date', 'User.first_name', 'User.last_name'),
                    'conditions' => array('DATE_FORMAT(Appointment.date, "%Y") ', /* LIKE 2014 */
                        'Appointment.status NOT' => array('Scheduled', 'Pending', 'No-Show', 'Cancelled'),
                        'Appointment.doctor_id' => $doctor_id,
                        'Appointment.location_id' => $this->Session->read('locationid'), 'Appointment.is_deleted' => '0'));
                $this->set('doctor_id', $doctor_id);

                $this->set('patientList', $this->paginate('Appointment'));
                if ($type == 'excel' && !empty($doctor_id)) {
                    $this->layout = false;
                    $this->render('physician_wise_list_excel');
                } else {
                    $this->render('pie_chart_patientlist');
                }
            }

            //specific surgeon's patient list
            if (!empty($surgeon_id)) {

                /* $yoyo = $this->OptAppointment->find('all',array('fields'=>array('patient_id'),'conditions'=>array('OptAppointment.doctor_id'=>$surgeon_id,'OptAppointment.procedure_complete'=>1)));
                  debug($yoyo);
                  exit; */

                $this->paginate = array(
                    'limit' => Configure::read('number_of_rows'),
                    //'order' => array('Appointment.date' => 'ASC'),
                    'fields' => array('Patient.lookup_name', 'Patient.id', 'User.first_name', 'User.last_name', 'OptAppointment.schedule_date'),
                    'conditions' => /* array('DATE_FORMAT(Appointment.date, "%Y") LIKE 2014 ',
                      'Appointment.status NOT'=>array('Scheduled','Pending','No-Show','Cancelled'),
                      'Appointment.doctor_id' =>$surgeon_id,
                      //'Appointment.patient_id' =>'OptAppointment.patient_id',
                      'OptAppointment.procedure_complete' => 1,
                      'Appointment.location_id'=>$this->Session->read('locationid'),'Appointment.is_deleted'=>'0')); */
                    array('OptAppointment.doctor_id' => $surgeon_id, 'OptAppointment.procedure_complete' => 1));
                $this->set('doctor_id', $surgeon_id);
                $this->set('patientList', $this->paginate('OptAppointment'));
                if ($type == 'excel' && !empty($surgeon_id)) {
                    $this->layout = false;
                    $this->render('physician_wise_list_excel');
                } else {
                    $this->render('pie_chart_patientlist');
                }
            }
            foreach ($doctors as $key => $value) {

                $patientCount = $this->Appointment->find('all', array('fields' => array('COUNT(Appointment.id) as count'),
                    'conditions' => array('DATE_FORMAT(Appointment.date, "%Y") ', /* LIKE 2014 */
                        'Appointment.location_id' => $this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
                        'Appointment.doctor_id' => $key, 'Appointment.status NOT' => array('Scheduled', 'Pending', 'No-Show', 'Cancelled')
                        )));

                $surgeryCount = $this->OptAppointment->find('all', array('fields' => array('COUNT(OptAppointment.id) as count'),
                    'conditions' => array('DATE_FORMAT(OptAppointment.schedule_date, "%Y")', /* LIKE 2014 */
                        'OptAppointment.location_id' => $this->Session->read('locationid'), 'OptAppointment.procedure_complete' => 1,
                        'OptAppointment.doctor_id' => $key
                        )));

                $pieData[$key]['name'] = $value;
                $pieData[$key]['count'] = $patientCount[0][0]['count'];
                $pieData[$key]['surgery_count'] = $surgeryCount[0][0]['count'];
                $doctorArray[$key] = $key;
            }
            $totalPatient = $this->Appointment->find('all', array('fields' => array('COUNT(Appointment.id) as count'),
                'conditions' => array('DATE_FORMAT(Appointment.date, "%Y") LIKE ' => date('Y'),
                    'Appointment.location_id' => $this->Session->read('locationid'), 'Appointment.is_deleted' => 0,
                    'Appointment.doctor_id' => $doctorArray, 'Appointment.status NOT' => array('Scheduled', 'Pending', 'No-Show', 'Cancelled')
                    )));
        }

        $this->set('pieData', $pieData);
        $this->set('totalPatient', $totalPatient);

        if ($type == 'excel' && empty($doctor_id)) {
            $this->layout = false;
            $this->render('doctorwise_report_excel');
        }
    }

    public function tpa_interface_report() {
        $this->uses = array('TariffStandard');
        $this->layout = 'advance';
        $this->paginate = array(
            'limit' => Configure::read('number_of_rows'),
            'order' => array(
                'TariffStandard.name' => 'asc',
            ), 'conditions' => array('TariffStandard.name LIKE' => "%" . "" . $getdata . "" . "%", 'TariffStandard.is_deleted' => 0, 'TariffStandard.location_id' => $this->Session->read('locationid'))
        );
        $data = $this->paginate('TariffStandard');

        $this->set('data', $data);
    }

    public function corporate_billing() {

        $this->layout = 'advance';
        $this->uses = array('RadiologyTestOrder', 'LaboratoryTestOrder', 'Patient', 'TariffStandard', 'Surgery',
            'DoctorProfile', 'Diagnosis', 'Ward', 'Billing', 'FinalBilling', 'OptAppointment', 'PharmacySalesBill',
            'LabTestPayment', 'RadiologyTestPayment', 'Bed', 'Room', 'Consultant', 'User', 'ServiceBill', 'TariffList',
            'TariffAmount', 'PharmacyItem', 'ServiceCategory');

        $this->Patient->unbindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(
                array('belongsTo' => array(
                        'TariffStandard' => array('primary_key' => false,
                            'conditions' => array('TariffStandard.id=Patient.tariff_standard_id'),
                        ),
                        'Diagnosis' => array('foreignKey' => false,
                            'conditions' => array('Patient.id=Diagnosis.patient_id'),
                        ),
                        'Person' => array('primaryKey' => false,
                            'conditions' => array('Person.id=Patient.person_id'),
                        ),
                        'OtherService' => array('foreignKey' => false, 'conditions' => array('OtherService.patient_id=Patient.id'),
                        ),
                        'Room' => array('foreignKey' => false, 'conditions' => array('Room.id=Patient.room_id'),
                        ),
                        'User' => array('foreignKey' => false, 'conditions' => array('User.id=Patient.doctor_id'),
                        ),
                        'Bed' => array('foreignKey' => false, 'conditions' => array('Bed.id=Patient.bed_id')),
                        'Ward' => array('foreignKey' => false, 'conditions' => array('Ward.id=Patient.ward_id')),
                        'FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                        ),
                        'PharmacySalesBill' => array('foreignKey' => false, 'conditions' => array('PharmacySalesBill.patient_id=Patient.id'),
                        ),
                    ), 'hasMany' => array('ConsultantBilling' => array('foreignKey' => 'patient_id',
                            'fields' => array('ConsultantBilling.amount')))));


        $privateId = $this->TariffStandard->getPrivateTariffID();
        if ($this->request->data) {
            if (!empty($this->request->data['TariffStandard']['company_id']))
                $conditions['TariffStandard.id'] = $this->request->data['TariffStandard']['company_id'];
            if (!empty($this->request->data['TariffStandard']['from_date'])) {
                $conditions['Patient.form_received_on >='] = $this->DateFormat->formatDate2STD($this->request->data['TariffStandard']['from_date'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->data['TariffStandard']['to_date'])) {
                $conditions['Patient.form_received_on <='] = $this->DateFormat->formatDate2STD($this->request->data['TariffStandard']['to_date'], Configure::read('date_format')) . " 23:59:59";
            }
            if (!empty($this->request->data['TariffStandard']['patient_id'])) {
                $conditions['Patient.id'] = $this->request->data['TariffStandard']['patient_id'];
            }
        }
        $result = $this->Patient->find('all', array('fields' => array('TariffStandard.name', 'TariffStandard.id',
                'Patient.id, Patient.lookup_name, Patient.create_time', 'Patient.tariff_standard_id', 'Diagnosis.final_diagnosis', 'Diagnosis.id',
                'Person.district', 'OtherService.service_name', 'OtherService.service_amount', 'Room.bed_prefix',
                'User.first_name', 'User.last_name', 'Bed.bedno', 'Ward.name', 'FinalBilling.total_amount',
                'PharmacySalesBill.total'),
            'conditions' => array('Patient.location_id' => $this->Session->read('locationid'), 'Patient.tariff_standard_id NOT' => $privateId,
                'Patient.is_discharge' => 1, 'Patient.is_deleted' => 0, 'Patient.admission_type' => "IPD", $conditions/* 'Patient.bed_id=Bed.id' */),
            'order' => array('Ward.sort_order', 'Bed.id', 'Room.id'/* 'Billing.date DESC' */), /* 'group'=>array('Billing.patient_id HAVING Billing.patient_id IS NOT NULL') */));
        $this->set('results', $result);


        foreach ($result as $key => $value) {
            $patientID[] = $result[$key]['Patient']['id'];
        }
        $patientID = array_filter($patientID);

        $this->set('patientID', $patientID);
        $add = $this->Billing->find('all', array('conditions' => array('patient_id' => $patientID, 'is_deleted' => '0',
                'location_id' => $this->Session->read('locationid'))));
        $this->set('advancePayment', $add);
        //$this->set('advancePayment',$add);

        $this->loadModel('OptAppointment');

        $this->OptAppointment->unbindModel(array(
            'belongsTo' => array('Initial', 'Patient', 'Location', 'Opt', 'OptTable', 'Surgery', 'SurgerySubcategory', 'Doctor', 'DoctorProfile')));

        $this->OptAppointment->bindModel(array(
            'belongsTo' => array(
                'Surgery' => array('foreignKey' => 'surgery_id'),
                )));

        $surgeriesData = $this->OptAppointment->find('all', array(
            'fields' => array('Surgery.name', 'OptAppointment.patient_id', 'Surgery.charges',
                'OptAppointment.surgery_cost', 'OptAppointment.anaesthesia_cost', 'OptAppointment.ot_charges'),
            'conditions' => array('OptAppointment.patient_id' => $patientID, 'OptAppointment.is_deleted' => 0,
                'OptAppointment.location_id' => $this->Session->read('locationid'))));
        $this->set('surgeriesData', $surgeriesData);

        foreach ($result as $tariff) {
            $tariffStandardId[] = $tariff['Patient']['tariff_standard_id'];
        }

        $hospitalType = $this->Session->read('hospitaltype');
        foreach ($result as $tariffDays) {
            $bedCharges[$tariffDays['Patient']['id']] = $this->getDay2DayCharges($tariffDays['Patient']['id'], $tariffDays['Patient']['tariff_standard_id']);
            $totalWardDays = count($bedCharges[$tariffDays['Patient']['id']]['day']); //total no of days
            if ($totalWardDays == 0) {
                $totalWardDays = 1;
            }
            //debug($tariffDays['Patient']['id'].'--'.$tariffDays['Patient']['tariff_standard_id']);
            $doctorCharges[$tariffDays['Patient']['id']] = $this->getDoctorCharges($totalWardDays, $hospitalType, $tariffDays['Patient']['tariff_standard_id'], 'IPD');
            $nursingCharges[$tariffDays['Patient']['id']] = $this->getNursingCharges($totalWardDays, $hospitalType, $tariffDays['Patient']['tariff_standard_id']);
            $wardServicesDataNew[$tariffDays['Patient']['id']] = $this->getDay2DayWardCharges($tariffDays['Patient']['id'], $tariffDays['Patient']['tariff_standard_id']);
            $nursingServices[$tariffDays['Patient']['id']] = $this->getServiceCharges($tariffDays['Patient']['id'], $tariffDays['Patient']['tariff_standard_id']);
        }

        foreach ($nursingServices as $nursingServicesKey => $nursingServicesCost) {
            foreach ($nursingServicesCost as $nursingServicesCost) {
                $nursingCnt = $nursingServicesCost['TariffList']['id'];
                $resetNursingServices[$nursingServicesKey][$nursingCnt]['qty'] = $resetNursingServices[$nursingServicesKey][$nursingCnt]['qty'] + $nursingServicesCost['ServiceBill']['no_of_times'];
                $resetNursingServices[$nursingServicesKey][$nursingCnt]['name'] = $nursingServicesCost['TariffList']['name'];
                $resetNursingServices[$nursingServicesKey][$nursingCnt]['cost'] = $nursingServicesCost['ServiceBill']['amount'];
                $resetNursingServices[$nursingServicesKey][$nursingCnt]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
                $resetNursingServices[$nursingServicesKey][$nursingCnt]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code'];
                //	$nursingCnt++;
            }
        }

        $this->set('servicesData', $resetNursingServices);
        //debug($wardServicesDataNew);
        foreach ($wardServicesDataNew as $key => $wardCharges) {
            foreach ($wardCharges as $ward) {
                foreach ($ward as $charge) {
                    foreach ($charge as $charge) {
                        $patientWardCharges[$key] = $patientWardCharges[$key] + $charge['cost'];
                    }
                }
            }
        }
        $this->set(array('doctorCharges' => $doctorCharges, 'nursingCharges' => $nursingCharges, 'patientWardCharges' => $patientWardCharges));
        //pr($servicesData);
        $this->set('results', $result);
        //pr($results) ;
        $this->loadModel('RadiologyTestOrder');
        $this->loadModel('LaboratoryTestOrder');
        $rad = $this->RadiologyTestOrder->radDetails($patientID); //array of patient ids
        $this->set('rad', $rad);
        $lab = $this->LaboratoryTestOrder->labDetails($patientID);
        $this->set('lab', $lab);

        //Pharmacy Data
        $this->loadModel('PharmacySalesBill');
        $this->loadModel('PharmacyItem');
        $pharmacyChargeDetails = array();
        $pharmacyResult = $this->PharmacySalesBill->find('all', array('conditions' => array('PharmacySalesBill.patient_id' => $patientID)));
        foreach ($pharmacyResult as $pharmacy) {
            foreach ($pharmacy['PharmacySalesBillDetail'] as $pharmacyItem) {
                $pharmacyItemDetails = $this->PharmacyItem->find('first', array('conditions' => array('PharmacyItem.id' => $pharmacyItem['item_id'])));

                if ($pharmacyItemDetails['PharmacyItemRate']['sale_price'] != 0) {
                    $cost = $pharmacyItemDetails['PharmacyItemRate']['sale_price'];
                } else {
                    $cost = $pharmacyItemDetails['PharmacyItemRate']['mrp'];
                }
                $pharmacyChargeDetails[$pharmacy['PharmacySalesBill']['patient_id']][] = array('itemName' => $pharmacyItemDetails['PharmacyItem']['name'], 'quantity' => $pharmacyItem['qty'], 'rate' => $cost, 'purchaseDate' => $pharmacy['PharmacySalesBill']['create_time'],
                    'tax' => $pharmacyItem['tax'], 'pharmacySalesBillTax' => $pharmacy['PharmacySalesBill']['tax'], 'payment_mode' => $pharmacy['PharmacySalesBill']['payment_mode']);
            }
        }
        $this->set('pharmacy_charges', $pharmacyChargeDetails);

        // consultant charges
        $this->loadModel('ConsultantBilling');
        $getconsultantData = $this->ConsultantBilling->find('all', array('conditions' => array('ConsultantBilling.patient_id' => $patientID)));
        $this->set('getconsultantData', $getconsultantData);

        $finaltotalPaid = $this->Billing->find('all', array('fields' => array('Billing.patient_id', 'Billing.amount'),
            'conditions' => array('Billing.patient_id' => $patientID, 'Billing.is_deleted' => '0'),
                ));
        foreach ($finaltotalPaid as $allPaid) {
            $finalPaid[$allPaid['Billing']['patient_id']] = $finalPaid[$allPaid['Billing']['patient_id']] + $allPaid['Billing']['amount'];
        }
        $this->set('finaltotalPaid', $finalPaid);
        //debug($surgeriesData);

        $this->loadModel('Bed');
        $this->Bed->bindModel(array(
            'belongsTo' => array(
                'Room' => array('foreignKey' => 'room_id', 'type' => 'inner'),
                'Ward' => array('foreignKey' => false,
                    'conditions' => array('Ward.id=Room.ward_id'), 'type' => 'inner')
            ),
            'hasMany' => array('WardPatient' => array('order' => 'WardPatient.id Desc', 'Limit' => 1, 'WardPatient.is_deleted=0')), false));
        $data = $this->Bed->find('all', array('conditions' => array('Ward.is_deleted' => 0, 'Ward.location_id' => $this->Session->read('locationid')), 'order' => array('Ward.id', 'Bed.id')));
        $this->set('data', $data);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = 'advance';
            foreach ($patientID as $patient_id) {
                $diffArray[$patient_id] = $this->diffAmountDetails($patient_id);
            }
            $this->set('setDiff', $diffArray);
            $this->render('advance_bill_xls', false);
        }
    }

    function excelReceipt($id, $mode = '') {
        $this->layout = false;
        $this->generateReceipt($id); //calling main function (Removed code can be found in svn backup)
        $this->render('company_patient_xls');
    }

    /*     * *****Bof reminder report******** */

    public function patient_reminder($flag = null, $type = null) {
        $this->uses = array('Patient', 'Appointment', 'Person', 'ReminderPatientList', 'State');

        $this->layout = 'advance';
        $this->Person->bindModel(array(
            'belongsTo' => array(
                'ReminderPatientList' => array('foreignKey' => false, conditions => array('Person.id=ReminderPatientList.person_id')),
                'Appointment' => array('foreignKey' => false, conditions => array('Person.id=Appointment.person_id')),
                )), false);


        $newState = $this->State->find('list', array('fields' => array('id', 'name'), 'conditions' => array('State.country_id' => '2')));
        $this->set('newState', $newState);

        //exit;
        //if(!empty($this->params->query)){

        if (!empty($this->params->query['first_name'])) {
            $search_key['Person.first_name like '] = trim($this->params->query['first_name']) . "%";
        }

        if (!empty($this->params->query['last_name'])) {
            $search_key['Person.last_name like '] = trim($this->params->query['last_name']) . "%";
        }

        if (!empty($this->params->query['gender'])) {
            $search_key['Patient.sex like '] = trim($this->params->query['gender']) . "%";
        }

        if (!empty($this->params->query['zip_code'])) {
            $search_key['Person.pin_code like '] = trim($this->params->query['zip_code']) . "%";
        }

        if (!empty($this->params->query['city'])) {
            $search_key['Person.city like '] = trim($this->params->query['city']) . "%";
        }

        if (!empty($this->params->query['state'])) {
            $search_key['Person.state like '] = trim($this->params->query['state']) . "%";
        }

        if (!empty($this->params->query['agefrom'])) {
            $bothTime = array($this->params->query['agefrom'], $this->params->query['ageto']);
            $search_key['Patient.age BETWEEN ? AND ? '] = $bothTime;
        }

        if ($this->params->query['flag'] == 'cancer') {
            $bothage = array('21', '65');
            $search_key['Patient.age BETWEEN ? AND ? '] = $bothage;
            $search_key['Patient.sex like '] = trim('female') . "%";
        }

        if ($this->params->query['flag'] == 'smoking') {
            $search_key['Patient.age >='] = 18;
        }

        if ($this->params->query['flag'] == 'highbp') {
            $search_key['Patient.age >='] = 18;
        }

        //debug($search_key);exit;

        $currentDate = date('Y-m-d');
        $noOfdays = '3';

        $d = new DateTime($currentDate);
        $t = $d->getTimestamp();

        // loop for 3 days
        for ($i = 0; $i < $noOfdays; $i++) {

            // add 1 day to timestamp
            $addDay = 86400;

            // get what day it is next day
            $nextDay = date('w', ($t + $addDay));

            // if it's Saturday or Sunday get $i-1    ($nextDay == 0 || $nextDay == 6)
            if ($nextDay == 0) {
                $i--;
            }

            // modify timestamp, add 1 day
            $t = $t + $addDay;
        }

        $d->setTimestamp($t);

        $nextThreeDays = $d->format('Y-m-d');
        $bothdates = array(date('Y-m-d', strtotime("+1 days")), $nextThreeDays);

        if ($this->params->query['flag'] == 'tab1') {
            $search_key['Appointment.date  BETWEEN ? AND ? '] = $bothdates;
        }

        $fourDays = date('Y-m-d', strtotime("-4 days"));

        if ($this->params->query['flag'] == 'tab2') {
            $search_key['ReminderPatientList.reminder_sent_date like'] = $fourDays . "%";
        }

        $oneWeekAgo = date('Y-m-d', strtotime("-1 weeks"));

        if ($this->params->query['flag'] == 'tab3') {
            $search_key['Person.create_time <='] = $oneWeekAgo;
            $search_key['Person.pregnant_week >='] = 32;
        }

        $twoWeekAgo = date('Y-m-d', strtotime("-2 weeks"));
        if ($this->params->query['flag'] == 'tab4') {
            $search_key['Person.create_time <='] = $twoWeekAgo;
            $search_key['Person.pregnant_week <'] = 32;
        }


        $conditions = array($search_key);
        $conditions = array_filter($conditions);

        if (!empty($this->params->query['type']) && $this->params->query['type'] == 'excel') {

            $data = $this->Person->find('all', array('fields' => array('Person.first_name', 'Person.last_name', 'Person.dob', 'Person.id', 'Person.person_local_number', 'ReminderPatientList.id',
                    'ReminderPatientList.reminder_followup_taken', 'ReminderPatientList.phone_reminder_script'),
                'conditions' => array('Person.is_deleted' => 0, 'Person.location_id' => $this->Session->read('locationid'), $conditions),
                'group' => array('Person.id'),
                'order' => array('Person.id' => 'DESC')));
            $this->set('data', $data);
            $this->render('patient_reminder_excel', '');
        } else {

            $this->paginate = array(
                'limit' => Configure::read('number_of_rows'),
                'group' => array('Person.id'),
                'order' => array('Person.id' => 'DESC'),
                'fields' => array('Person.first_name', 'Person.last_name', 'Person.sex', 'Person.age', 'Person.dob', 'Person.id', 'Person.patient_uid', 'Person.landmark', 'Person.taluka', 'Person.person_local_number', 'ReminderPatientList.id',
                    'Appointment.date', 'ReminderPatientList.reminder_followup_taken', 'ReminderPatientList.phone_reminder_script', 'ReminderPatientList.reminder_sent_date'),
                'conditions' => array('Person.is_deleted' => 0, 'Person.location_id' => $this->Session->read('locationid'), $conditions));
            $data = $this->paginate('Person');
            $this->set('data', $data);


            //}
        }
    }

    function savePatientReminder($personId = null) {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->uses = array('ReminderPatientList');
        $reminderData = "";
        $currentDate = date('Y-m-d h:i:s');
        $reminder = array('person_id' => $personId, /* 'reminder_sent_for'=>$flag, */'reminder_sent_date' => $currentDate, 'reminder_followup_taken' => 'No');

        $remRec = $this->ReminderPatientList->find('first', array('conditions' => array('ReminderPatientList.person_id' => $personId)));
        if (empty($remRec)) {
            $patients = $this->ReminderPatientList->save($reminder);
        } else {
            $updateArray = array('ReminderPatientList.person_id' => "'$personId'",
                'ReminderPatientList.reminder_sent_date' => "'$currentDate'", 'ReminderPatientList.reminder_followup_taken' => "'No'");
            $res = $this->ReminderPatientList->updateAll($updateArray, array('ReminderPatientList.person_id' => $personId));
        }
    }

    function savePatientReminderFollowup($personId = null) {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->uses = array('ReminderPatientList');
        $reminderData = "";
        $currentDate = date('Y-m-d h:i:s');
        $updateArray = array('ReminderPatientList.reminder_followup_taken' => "'Yes'");
        $res = $this->ReminderPatientList->updateAll($updateArray, array('ReminderPatientList.person_id' => $personId));
    }

    function savePatientScript($personId = null, $comment = null) {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->uses = array('ReminderPatientList');
        $reminderData = "";
        $currentDate = date('Y-m-d h:i:s');
        $reminder = array('person_id' => $personId, 'reminder_sent_date' => $currentDate, 'reminder_followup_taken' => 'No', 'phone_reminder_script' => $comment);

        $remScript = $this->ReminderPatientList->find('first', array('conditions' => array('ReminderPatientList.person_id' => $personId)));
        //debug($remScript);exit;
        if (empty($remScript)) {
            $patients = $this->ReminderPatientList->save($reminder);
        } else {
            $updateArray = array('ReminderPatientList.phone_reminder_script' => "'$comment'");
            $res = $this->ReminderPatientList->updateAll($updateArray, array('ReminderPatientList.person_id' => $personId));
        }
    }

    /**
     * function for download uploaded excel report
     * @param unknown_type $patientId
     * @yashwant
     */
    function downloadExcel($patientId = null, $documentID = null) {
        $this->layout = false;
        $this->autoRender = false;
        $this->uses = array('PatientDocument');
        $data = $this->PatientDocument->read(null, $documentID);

        $file = $data['PatientDocument']['filename'];
        header('Content-disposition: attachment; filename=' . $file);
        header("Content-type:" . $data['PatientDocument']['type'] . "");
        header('Content-Length: ' . $data['PatientDocument']['size']);
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        ob_clean();
        flush();
        readfile("uploads" . DS . "corporateExcel" . DS . $data['PatientDocument']['filename']);

        exit;
    }

    /** render reports on changing dropdown * */
    function selectCorporate($type = NULL) {
        $this->uses = array('TariffStandard');
        $this->layout = "advance";
        if (!empty($type)) {
            $tariffId = $this->TariffStandard->find('first', array('fields' => array('id', 'code_name'), 'conditions' => array('TariffStandard.id' => $type)));

            if (strtolower($tariffId['TariffStandard']['code_name']) == 'bsnl') {
                $this->redirect(array("controller" => 'Corporates', "action" => "bsnl_report", "admin" => true));
            } else if (strtolower($tariffId['TariffStandard']['code_name']) == 'cghs') {
                $this->redirect(array("controller" => 'Corporates', "action" => "cghs_report", "admin" => true));
            } else if (strtolower($tariffId['TariffStandard']['code_name']) == 'echs') {
                $this->redirect(array("controller" => 'Corporates', "action" => "echs_report", "admin" => true));
            } else if (strtolower($tariffId['TariffStandard']['code_name']) == 'mahindra') {
                $this->redirect(array("controller" => 'Corporates', "action" => "mahindra_report", "admin" => true));
            } else if (strtolower($tariffId['TariffStandard']['code_name']) == 'fci') {
                $this->redirect(array("controller" => 'Corporates', "action" => "fci_report", "admin" => true));
            } else if (strtolower($tariffId['TariffStandard']['code_name']) == 'raymond') {
                $this->redirect(array("controller" => 'Corporates', "action" => "raymond_report", "admin" => true));
            } else if (strtolower($tariffId['TariffStandard']['code_name']) == 'wcl') {
                $this->redirect(array("controller" => 'Corporates', "action" => "wcl_report", "admin" => true));
            } else if (strtolower($tariffId['TariffStandard']['code_name']) == 'mpkay') {
                $this->redirect(array("controller" => 'Corporates', "action" => "mpkay_report", "admin" => true));
            } else if (strtolower($tariffId['TariffStandard']['code_name']) == 'bhel') {
                $this->redirect(array("controller" => 'Corporates', "action" => "bhel_outstanding_report", "admin" => true));
            } else {
                $this->redirect(array("controller" => 'Corporates', "action" => "other_outstanding_report", $tariffId['TariffStandard']['id'], "admin" => true));
            }
        } else {
            $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', /* 'code_name', */'name'), 'conditions' => array('TariffStandard.is_deleted' => 0, /* 'TariffStandard.code_name IS NOT NULL', */'TariffStandard.location_id' => $this->Session->read('locationid'), 'TariffStandard.name NOT' => 'Private')));
            $this->set('tariffData', $tariffData);
            $this->render('/elements/corporate_billing_report');
        }
    }

    public function admin_other_outstanding_report($typeId = NULL) { 
        // debug($this->request->query);
        $this->layout = 'advance';

        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'PatientCard');
        //$tariffID=$this->TariffStandard->getTariffStandardID($typeId);
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id')),
                )));

        $this->Patient->bindModel(array('belongsTo' => array(
                'PatientCard' => array('foreignKey' => false, 'conditions' => array('PatientCard.person_id=Patient.person_id')),
                'FinalBilling' => array('type' => 'LEFT', 'foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id')),
                'Billing' => array('foreignKey' => false, 'conditions' => array('Patient.id=Billing.patient_id', 'Billing.is_deleted=0')),
                'TariffStandard' => array('foreignKey' => false, 'conditions' => array('TariffStandard.id=Patient.tariff_standard_id')),
                'User'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.bill_prepared_by=User.id')),
                "UserAlias"=>array('className'=>'User',"foreignKey"=>false ,'conditions'=>array('FinalBilling.bill_submitted_by=UserAlias.id')),
                )), false);


        $conditions1 = array('Patient.is_deleted' => 0, 'Patient.is_discharge' => 1, 'Patient.is_hidden_from_report' => 0,
            'Patient.location_id' => $this->Session->read('locationid'));

        if (!empty($this->request->query)) {
            // debug($this->request->query);
            //unset($conditions1['Patient.is_hidden_from_report']);
            if (!empty($this->request->query['patient_id'])) {
                $conditions1['Patient.id'] = $this->request->query['patient_id'];
            }
            if (!empty($this->request->query['from'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['to'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
            }
            if ($from)
                $conditions1['Patient.discharge_date >='] = $from;
            if ($to)
                $conditions1['Patient.discharge_date <='] = $to;
                $conditions1['Patient.tariff_standard_id !='] = '7';
                // debug($conditions1);
            
//  debug($this->request->query);exit;
            if($this->request->query['bill_options']=='not prepared'){
                $conditions1['Finalbilling.is_bill_finalize'] =array('0',NULL);
                //$conditions1['Finalbilling.bill_uploading_date']=NULL;
            }else if($this->request->query['bill_options']=='not submitted'){
                $conditions1['Finalbilling.is_bill_finalize'] = '1';
                $conditions1['Finalbilling.claim_status']=NULL;
                $conditions1['Finalbilling.dr_claim_date']=NULL;
            }

            if($this->params->query['tariff_standard_id']){ 
                $conditions1['Patient.tariff_standard_id']= $this->params->query['tariff_standard_id'];
            }

            if($this->params->query['admission_type']){ 
                $conditions1['Patient.admission_type']= $this->params->query['admission_type'];
                // debug($conditions1);
            }


        }else{
           if (empty($from))
                $conditions1['Patient.discharge_date >='] = date('Y-m-d').' 00:00:00';
            if (empty($to))
                $conditions1['Patient.discharge_date <='] = date('Y-m-d').' 23:59:59';  
        }
         if ($this->params->pass[1] == 'excel' || $this->params->pass[0] == 'excel') {
            $result = $this->Patient->find('all',array('fields'=>array("SUM(CASE WHEN Billing.payment_category != 'corporateAdvance' AND Billing.payment_category != 'TDS' THEN Billing.amount ELSE 0 END) as patientPaid",
                "SUM(CASE WHEN Billing.payment_category = 'TDS'  THEN Billing.amount ELSE 0 END) as TDSPAid",
                "SUM( CASE WHEN Billing.payment_category = 'corporateAdvance' THEN Billing.amount ELSE 0 END) as advacnePAid",
                //"SUM( CASE WHEN PatientCard.type = 'Corporate Advance' THEN PatientCard.amount ELSE 0 END) as advacneCardPAid",
                'SUM(Billing.discount_amount) as total_discount', 'Billing.payment_category','Patient.id','Patient.admission_type' ,'Patient.patient_id',
                'Patient.admission_id', 'Patient.discharge_date',  'Patient.is_discharge', 'Patient.lookup_name', 'Patient.form_received_on', 'Patient.person_id','Patient.corporate_status',
                'FinalBilling.amount_pending', 'FinalBilling.total_amount', 'PatientDocument.id', 'PatientDocument.filename','FinalBilling.dr_claim_date','TariffStandard.name','FinalBilling.id, FinalBilling.use_duplicate_sales','FinalBilling.expected_amount','FinalBilling.is_bill_finalize','FinalBilling.claim_status','FinalBilling.dr_claim_date','FinalBilling.bill_uploading_date','Patient.five_day_reminder','Patient.twelve_day_reminder','Patient.twelve_day_noc_taken','Patient.five_day_noc_taken','FinalBilling.bill_prepared_by','FinalBilling.billing_link','FinalBilling.nmi','FinalBilling.nmi_date','FinalBilling.nmi_answered','FinalBilling.bill_submitted_by','FinalBilling.hospital_invoice_amount','FinalBilling.referral_letter','FinalBilling.reason_for_delay','User.first_name','User.last_name','UserAlias.first_name','UserAlias.last_name','Patient.tariff_standard_id'),'conditions'=>$conditions1,'group' => array('Patient.id'),
            'order' => array('Billing.id desc')));
            // debug($result);exit;
         }else{
           $result = $this->Patient->find('all',array('fields'=>array("SUM(CASE WHEN Billing.payment_category != 'corporateAdvance' AND Billing.payment_category != 'TDS' THEN Billing.amount ELSE 0 END) as patientPaid",
                "SUM(CASE WHEN Billing.payment_category = 'TDS'  THEN Billing.amount ELSE 0 END) as TDSPAid",
                "SUM( CASE WHEN Billing.payment_category = 'corporateAdvance' THEN Billing.amount ELSE 0 END) as advacnePAid",
                //"SUM( CASE WHEN PatientCard.type = 'Corporate Advance' THEN PatientCard.amount ELSE 0 END) as advacneCardPAid",
                'SUM(Billing.discount_amount) as total_discount', 'Billing.payment_category','Patient.id','Patient.admission_type' ,'Patient.patient_id',
                'Patient.admission_id', 'Patient.discharge_date',  'Patient.is_discharge', 'Patient.lookup_name', 'Patient.form_received_on', 'Patient.person_id','Patient.corporate_status',
                'FinalBilling.amount_pending', 'FinalBilling.total_amount', 'PatientDocument.id', 'PatientDocument.filename','FinalBilling.dr_claim_date','TariffStandard.name','FinalBilling.id, FinalBilling.use_duplicate_sales','FinalBilling.expected_amount','FinalBilling.is_bill_finalize','FinalBilling.claim_status','FinalBilling.dr_claim_date','FinalBilling.bill_uploading_date','Patient.five_day_reminder','Patient.twelve_day_reminder','Patient.twelve_day_noc_taken','Patient.five_day_noc_taken','FinalBilling.bill_prepared_by','FinalBilling.billing_link','FinalBilling.nmi','FinalBilling.nmi_date','FinalBilling.nmi_answered','FinalBilling.bill_submitted_by','FinalBilling.hospital_invoice_amount','FinalBilling.referral_letter','FinalBilling.reason_for_delay','User.first_name','User.last_name','UserAlias.first_name','UserAlias.last_name','Patient.tariff_standard_id'),'conditions'=>$conditions1,'group' => array('Patient.id'),
            'order' => array('Billing.id desc')));
         }
        


    foreach ($result as $key => $value) {
        
        $data = $this->Billing->getPatientTotalBill($value['Patient']['id'],$value['Patient']['admission_type']);
        $result[$key][0]['total_amount'] = $data;
    }
   
        //for patient card paid
        /*$patientIDS = array();
        foreach ($result as $corporateKey => $coporateVal) {
            $patientIDS[] = $coporateVal['Patient']['person_id'];
        }
        $cardConditionArray['PatientCard.person_id'] = $patientIDS;
        $cardConditionArray['PatientCard.type'] = 'Corporate Advance';
        $this->PatientCard->virtualFields = array(
            'card_advance_total' => 'SUM(amount)'
        );
        $patientCardData = $this->PatientCard->find('list', array('conditions' => $cardConditionArray, 'fields' => array('PatientCard.person_id', 'PatientCard.card_advance_total')));*/

        //debug($result);
        //calculate TDS amount  
        /* foreach ($result as $corporateKey => $coporateVal){
          $patientIDS[] = $coporateVal['Patient']['id'] ;
          }
          $TDSConditionArray['Billing.patient_id'] = $patientIDS;
          $TDSConditionArray['Billing.payment_category'] ='TDS' ;
          $this->Billing->virtualFields = array(
          'tds_total' => 'SUM(amount)'
          );
          $patientCondArray['Billing.patient_id'] = $patientIDS;
          $patientCondArray['Billing.payment_category NOT '] = array('corporateAdvance','TDS');

          $TDSData = $this->Billing->find('list',array('conditions'=>$TDSConditionArray,'fields'=>array('Billing.patient_id','tds_total'),'group'=>array('Billing.patient_id')));

          $this->Billing->virtualFields = array(
          'patient_total' => 'COALESCE(SUM(amount),0)+COALESCE(SUM(discount_amount),0)'
          );
          $paidByPatient = $this->Billing->find('list',array('conditions'=>$patientCondArray,'fields'=>array('Billing.patient_id','patient_total'),'group'=>array('Billing.patient_id')));
         */
        $this->set(array('results' => $result, 'patientCardData' => $patientCardData/* ,'paidByPatient'=>$paidByPatient */));

        $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'), 'conditions' => array('TariffStandard.is_deleted' => 0, /* 'TariffStandard.code_name IS NOT NULL', */'TariffStandard.location_id' => $this->Session->read('locationid'), 'TariffStandard.name NOT' => 'Private'),'order'=>array('TariffStandard.name')));
        $this->set('tariffData', $tariffData);

        $this->set('tariffStandardID', $this->params->query['tariff_standard_id']);
        if ($this->request->isAjax()) {
            $this->layout = 'ajax';
            $this->render('ajax_other_outstanding_report');
        }
        if ($this->params->pass[1] == 'excel' || $this->params->pass[0] == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_other_corporate_xls', false);
        }
    }

    //function to update claims collected from corporates 
    /*
     * @Author Pankaj W
     */
    public function updatePackageAmount($patient_id, $tariff_standard_id) {
        $this->layout = "ajax";
        $this->autoRender = false;
        $this->loadModel('Billing');
        $this->loadModel('FinalBilling');
        if ($this->request->data['corporateClaims']) {
            //$this->FinalBilling->id = $id;							//$id holds the patient's id
            //$this->FinalBilling->save($this->request->data['corporateClaims']);		//update the extension_status of patient
            //insert into billing table as a corporate advance
            if ($this->request->data['corporateClaims']['bill_uploading_date']) {
                $this->request->data['corporateClaims']['bill_uploading_date'] = $this->DateFormat->formatDate2STD($this->request->data['corporateClaims']['bill_uploading_date'], Configure::read('date_format'));
            }

            if ($this->request->data['corporateClaims']['patient_id'] && !empty($this->request->data['corporateClaims']['cmp_amt_paid'])) { //update actual amount received from company
                $isSaved=$this->Billing->save($billingData = array(
                    'amount' => $this->request->data['corporateClaims']['cmp_amt_paid'],
                    'payment_category' => 'CorporateAdvance',
                    'remark' => $this->request->data['corporateClaims']['remark'],
                    'bill_number' => $this->request->data['corporateClaims']['bill_number'],
                    'date' => $this->request->data['corporateClaims']['bill_uploading_date'],
                    'discount_amount' => $this->request->data['corporateClaims']['other_deduction'],
                    'patient_id' => $this->request->data['corporateClaims']['patient_id'],
                    'mode_of_payment' => 'Cash',
                    'discount_type' => 'amount',
                    'location_id' => $this->Session->read('locationid')
                ));
                $billingDataDetails['Billing'] = $billingData;
                //$this->Billing->addPartialPaymentJV($billingDataDetails, $patient_id);
                $this->Billing->id = '';
            }

            if ($this->request->data['corporateClaims']['patient_id'] && !empty($this->request->data['corporateClaims']['tds'])) { //update deducted TDS
                $this->Billing->save(array(
                    'amount' => $this->request->data['corporateClaims']['tds'],
                    'payment_category' => 'TDS',
                    'remark' => $this->request->data['corporateClaims']['remark'],
                    'bill_number' => $this->request->data['corporateClaims']['bill_number'],
                    'date' => $this->request->data['corporateClaims']['bill_uploading_date'],
                    'patient_id' => $this->request->data['corporateClaims']['patient_id'],
                    'location_id' => $this->Session->read('locationid')
                        //'mode_of_payment'=>'cash', this amount is not actully come to hospital but still to close patient legder will update TDS As a advance
                ));
                $this->Billing->id = '';
            }

            $isUpdate = $this->FinalBilling->updateAll(array('date'=>"'".date('Y-m-d H:i:s')."'",'amount_paid'=>"'".$this->request->data['corporateClaims']['cmp_amt_paid']."'",'other_deduction'=>"'".$this->request->data['corporateClaims']['other_deduction']."'",'tds'=>"'".$this->request->data['corporateClaims']['tds']."'"),
                    array('FinalBilling.patient_id'=>$this->request->data['corporateClaims']['patient_id']));

            //$this->admin_other_outstanding_report($tariff_standard_id);
            //$this->redirect(array('controller' => 'corporates', 'action' => 'other_outstanding_report', 'admin' => true));
        }
        if($isSaved){
            return true;
        }
        //exit;
    }

    /*
     * ajax screen for corporate payment 
     */

    function corporate_advance_payment($tariff_standard_id = null, $patient_id = null) {
        //$this->layout = 'ajax' ; 
        $this->loadModel('Billing');
        $this->loadModel('Patient');
        $patientData = $this->Patient->find('first', array('conditions' => array('Patient.id' => $patient_id), 'fields' => array('Patient.lookup_name')));

        $this->Patient->bindModel(array('belongsTo' => array(
                'Billing' => array('foreignKey' => false, 'conditions' => array('Billing.Patient_id=Patient.id', 'Billing.is_deleted' => '0')),
                'FinalBilling' => array('foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id')))));

        $advanceData = $this->Patient->find('all', array('conditions' => array('Patient.id' => $patient_id,
            /* 'Billing.payment_category'=>array('CorporateAdvance','TDS') */            ),
            'fields' => array('FinalBilling.total_amount','FinalBilling.hospital_invoice_amount', 'Billing.id', 'Billing.amount', 'Billing.date', 'Billing.discount', 'Billing.payment_category', 'Billing.bill_number', 'Billing.remark'),
            'order' => array('Billing.date')));
        
        foreach ($advanceData as $key => $value) {
            if ($value['Billing']['payment_category'] == 'CorporateAdvance' || $value['Billing']['payment_category'] == 'TDS') {//payment is done by the corproates
                $resetAdvanceArray[$value['Billing']['date']][] = $value['Billing'];
                $corporatePaidAmt += $value['Billing']['amount'];
                $discountGivenAlready += $value['Billing']['discount_amount'];
            } else {//payment done by the patient
                $patientPaidAmt += $value['Billing']['amount'] + $value['Billing']['discount_amount'];
                ;
            }
            $totalAmount = ($value['FinalBilling']['hospital_invoice_amount'])?$value['FinalBilling']['hospital_invoice_amount']:$value['FinalBilling']['total_amount'];
        }


        $this->set(array('patient_id' => $patient_id, 'tariff_standard_id' => $tariff_standard_id, 'advanceData' => $resetAdvanceArray,
            'patient' => $patientData, 'patientPaidAmt' => $patientPaidAmt, 'corporatePaidAmt' => $corporatePaidAmt, 'totalAmount' => $totalAmount, 'discountGiven' => $discountGivenAlready));
    }

    public function corporateAdvanceDelete($recID = null) {
        $this->loadModel('Billing');
        $billingData = $this->Billing->find('first', array('fields' => array('patient_id', 'date'), 'conditions' => array('Billing.id' => $recID)));
        //$this->Billing->save(array('id'=>$recID,'is_deleted'=>1));
        $this->Billing->updateAll(array('is_deleted' => '1'), array('patient_id' => $billingData['Billing']['patient_id'], 'date' => $billingData['Billing']['date']));
        exit;
    }

    function generate_super_bill() {
        $this->layout = 'advance';
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'CorporateSuperBill', 'Account');
        $tariffStandard = $this->TariffStandard->find('list', array('fields' => array('TariffStandard.id', 'TariffStandard.name'),
            'conditions' => array('TariffStandard.is_deleted' => '0')));
        $this->set('tariffStandard', $tariffStandard);
        $this->Patient->unBindModel(array('hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));
        $this->Patient->bindModel(array('belongsTo' => array(
                'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id')),
                )));
        $pvtTariffId = $this->TariffStandard->getPrivateTariffID();
        $this->set('pvtTariffId', $pvtTariffId);
        $this->Patient->primaryKey = 'person_id';
        $this->Patient->bindModel(array('belongsTo' => array(
                'Account' => array('type' => 'INNER', 'foreignKey' => false, 'conditions' => array('Account.system_user_id=Patient.person_id')),
                'FinalBilling' => array('type' => 'LEFT', 'foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id')),
                'Billing' => array('foreignKey' => false, 'conditions' => array('Patient.id=Billing.patient_id', 'Billing.is_deleted=0')),),
                /* 'hasMany'=>array(
                  'PatientCard'=>array( 'foreignKey'   => 'person_id'),
                  ) */                ), false);
        //debug($pvtTariffId);
        $conditions1 = array('Patient.is_deleted' => 0, 'Patient.is_discharge' => 1, 'Patient.is_hidden_from_report' => 0, 'Patient.tariff_standard_id NOT' => $pvtTariffId);
        if (!empty($this->request->query)) {
            if (!empty($this->request->query['lookup_name'])) {
                $adId = explode('-', $this->request->query['lookup_name']);
                $splittedIDS = explode("(", $adId[1]);
                $uid = trim($splittedIDS[0]);
                $conditions2['Patient.admission_id LIKE'] = $uid;
            }
            $this->paginate = array(
                'limit' => Configure::read('number_of_rows'),
                'fields' => array("SUM(CASE WHEN Billing.payment_category != 'corporateAdvance' AND Billing.payment_category != 'TDS' THEN Billing.amount ELSE 0 END) as patientPaid",
                    "SUM(CASE WHEN Billing.payment_category = 'TDS'  THEN Billing.amount ELSE 0 END) as TDSPAid",
                    "SUM( CASE WHEN Billing.payment_category = 'corporateAdvance' THEN Billing.amount ELSE 0 END) as advacnePAid",
                    //"SUM( CASE WHEN PatientCard.type = 'Corporate Advance' THEN PatientCard.amount ELSE 0 END) as advacneCardPAid",
                    'SUM(Billing.paid_to_patient) as total_refund', 'Account.card_balance',
                    'SUM(Billing.discount_amount) as total_discount', 'Billing.payment_category', 'Patient.patient_id', 'Patient.person_id', 'Patient.tariff_standard_id',
                    'Patient.tariff_standard_id', 'Patient.admission_id', 'Patient.discharge_date', 'Patient.id', 'Patient.is_discharge', 'Patient.lookup_name', 'Patient.form_received_on','Patient.corporate_status',
                    'FinalBilling.amount_pending', 'FinalBilling.discount', 'FinalBilling.bill_uploading_date', 'FinalBilling.total_amount', 'PatientDocument.id', 'PatientDocument.filename'),
                'conditions' => array($conditions1, $conditions2, 'Account.user_type' => 'Patient'),
                'group' => array('Patient.id'),
                'order' => array('Patient.is_hidden_from_report ASC', 'Patient.form_received_on DESC'));
            $result = $this->paginate('Patient', null, array('fields' => array('count(distinct(Billing.patient_id)) as count', 'Billing.payment_category')));
            $person_id = $result[0]['Patient']['person_id'];
            $this->set('results', $result);
 

            //Iterate patient array to fetch all added services
            $patientIDS = array();
            foreach ($result as $key => $value) {
                $patientIDS[] = $value['Patient']['id'];
            }
            if ($patientIDS)
                $patientData = $this->Patient->patientServices($patientIDS);
            $this->set('patientData', $patientData);

            if (!empty($person_id)) {
                $data = $this->CorporateSuperBill->find('all', array('conditions' => array('CorporateSuperBill.person_id' => $person_id, 'CorporateSuperBill.is_deleted' => '0')));
                if (!empty($data)) {
                    $patientSelected = array();
                    foreach ($data as $key => $val) {
                        $patientSelected = array_merge(explode("|", $val['CorporateSuperBill']['patient_id']), $patientSelected);
                    }
                    $this->set('patientSelected', $patientSelected);
                }
            }
        }

        //save data
        if (!empty($this->request->data)) {

           # debug($this->request->data);exit;
            $tariffName = $tariffStandard[$this->request->data['Patient']['tariff_standard_id']];

            $tariffName = $tariffStandard[$this->request->data['Patient']['tariff_standard_id']];

            $tariffName = explode(' ', $tariffName);
            $tCount = count($tariffName);
            if ($tCount > 1) {
                foreach ($tariffName as $name) {
                    $tName.=$name[0];
                }
            } else {
                $tName = $tariffName['0'];
            }

            $tariffName = $tariffStandard[$this->request->data['Patient']['tariff_standard_id']];

            $tariffName = explode(' ', $tariffName);
            $tCount = count($tariffName);
            if ($tCount > 1) {
                foreach ($tariffName as $name) {
                    $tName.=$name[0];
                }
            } else {
                $tName = $tariffName['0'];
            }



            $this->request->data['super_bill_no'] = $this->CorporateSuperBill->generateSuperBillNo($tName); //generate super bill no
            //debug($this->request->data);exit;
            //to create pipe format of patient's ids
            foreach ($this->request->data['Patient']['selected'] as $key => $val):
                if ($val != 0) {
                    $selectedPatient[] = $key;
                }
            endforeach;
            //order case for bill number from finalbilling -- pooja
            $order = "(CASE Patient.admission_type
							WHEN 'IPD' THEN 1
							WHEN 'OPD' THEN 2
							WHEN 'LAB' THEN 3
							WHEN 'RAD' THEN 4
							ELSE 100 END) ASC , Patient.id DESC";

            $this->FinalBilling->bindModel(array(
                'belongsTo' => array('Patient' => array('foreignKey' => false, 'conditions' => array('Patient.id=FinalBilling.patient_id')))));

            $billno = $this->FinalBilling->find('first', array('fields' => array('Patient.id', 'Patient.admission_type', 'FinalBilling.id',
                    'FinalBilling.bill_number'),
                'conditions' => array('FinalBilling.patient_id' => $selectedPatient),
                'order' => array($order)));

            $this->request->data['patient_bill_no'] = $billno['FinalBilling']['bill_number'];
            $this->request->data['person_id'] = $this->request->data['Patient']['person_id'];
            $this->request->data['patient_type'] = $this->request->data['Patient']['patient_type'];
            $this->request->data['patient_id'] = implode("|", $selectedPatient);
            $this->request->data['tariff_standard_id'] = $this->request->data['Patient']['tariff_standard_id'];
            $this->request->data['total_amount'] = $this->request->data['Patient']['total_amount'];
          //  $this->request->data['approved_amount'] = $this->request->data['Patient']['approved_amount'];
            $this->request->data['created_time'] = date("Y-m-d H:i:s");
            $this->request->data['date'] = $this->DateFormat->formatDate2STD($this->request->data['Patient']['date'], Configure::read('date_format'));
            $this->request->data['created_by'] = $this->Auth->user('id');
            $lastId = $this->CorporateSuperBill->saveData($this->request->data);
			 
            if (!empty($lastId)) {
                //$updateServiceBill = $this->updateServiceBill($this->request->data['services'],$lastId);
                //$updateLaboratory = $this->updateLaboratory($this->request->data['laboratory'],$lastId);
                //$updateRadiology = $this->updateRadiology($this->request->data['radiology'],$lastId);
                //$updateConsultant = $this->updateConsultant($this->request->data['consultantBilling'],$lastId);
                //$updateWardPatientServices = $this->updateWardPatientServices($this->request->data['wardService'],$lastId);
                //$updatePharmacy = $this->updatePharmacy($this->request->data['pharmacy'],$lastId);
                //$updateOTPharmacy = $this->updateOTPharmacy($this->request->data['otPharmacy'],$lastId);
                $this->Session->setFlash(__('Bill No: ' . $this->request->data['super_bill_no'] . ' generated successfully', false), 'default', array('class' => 'stillSuccess', 'id' => 'stillFlashMessage'), 'still');
                $this->redirect(array('action' => 'generate_super_bill'));
            }
        }
    }

    //function to update corporateSuperBillNo in Service Bills
    public function updateServiceBill($services, $lastId) {
        $this->uses = array('ServiceBill');
        if (!empty($services)) {
            foreach ($services as $patientId => $tariffListId):
                foreach ($tariffListId as $id => $val):
                    if ($val != 0) {
                        $updateCorporateBillNo = $lastId;
                    } else {
                        $updateCorporateBillNo = "0";
                    }
                    $this->ServiceBill->updateAll(array('ServiceBill.corporate_super_bill_id' => $updateCorporateBillNo), array('ServiceBill.tariff_list_id' => $id, 'ServiceBill.patient_id' => $patientId));
                endforeach;
            endforeach;
            return true;
        }
    }

    //function to update corporateSuperBillNo in Laboratory Test Order
    public function updateLaboratory($laboratory, $lastId) {
        $this->uses = array('LaboratoryTestOrder');
        if (!empty($laboratory)) {
            foreach ($laboratory as $patientId => $tariffListId):
                foreach ($tariffListId as $id => $val):
                    if ($val != 0) {
                        $updateCorporateBillNo = $lastId;
                    } else {
                        $updateCorporateBillNo = "NULL";
                    }
                    $this->LaboratoryTestOrder->updateAll(array('LaboratoryTestOrder.corporate_super_bill_id' => $updateCorporateBillNo), array('LaboratoryTestOrder.laboratory_id' => $id, 'LaboratoryTestOrder.patient_id' => $patientId));
                endforeach;
            endforeach;
            return true;
        }
    }

    //function to update corporateSuperBillNo in Radiology Test Order
    public function updateRadiology($radiology, $lastId) {
        $this->uses = array('RadiologyTestOrder');
        if (!empty($radiology)) {
            foreach ($radiology as $patientId => $tariffListId):
                foreach ($tariffListId as $id => $val):
                    if ($val != 0) {
                        $updateCorporateBillNo = $lastId;
                    } else {
                        $updateCorporateBillNo = "NULL";
                    }
                    $this->RadiologyTestOrder->updateAll(array('RadiologyTestOrder.corporate_super_bill_id' => $updateCorporateBillNo), array('RadiologyTestOrder.radiology_id' => $id, 'RadiologyTestOrder.patient_id' => $patientId));
                endforeach;
            endforeach;
            return true;
        }
    }

    //function to update corporateSuperBillNo in Consultant Biling
    public function updateConsultant($consultantBilling, $lastId) {
        $this->uses = array('ConsultantBilling');
        if (!empty($consultantBilling)) {
            foreach ($consultantBilling as $patientId => $tariffListId):
                foreach ($tariffListId as $id => $val):
                    if ($val != 0) {
                        $updateCorporateBillNo = $lastId;
                    } else {
                        $updateCorporateBillNo = "NULL";
                    }
                    $this->ConsultantBilling->updateAll(array('ConsultantBilling.corporate_super_bill_id' => $updateCorporateBillNo), array('ConsultantBilling.tariff_list_id' => $id, 'ConsultantBilling.patient_id' => $patientId));
                endforeach;
            endforeach;
            return true;
        }
    }

    //function to update corporateSuperBillNo in Ward Patient Services
    public function updateWardPatientServices($wardService, $lastId) {
        $this->uses = array('WardPatientService');
        if (!empty($wardService)) {
            foreach ($wardService as $patientId => $tariffListId):
                foreach ($tariffListId as $id => $val):
                    if ($val != 0) {
                        $updateCorporateBillNo = $lastId;
                    } else {
                        $updateCorporateBillNo = "NULL";
                    }
                    $this->WardPatientService->updateAll(array('WardPatientService.corporate_super_bill_id' => $updateCorporateBillNo), array('WardPatientService.patient_id' => $patientId));
                endforeach;
            endforeach;
            return true;
        }
    }

    //function to update corporateSuperBillNo in Pharmacy
    public function updatePharmacy($pharmacy, $lastId) {
        $this->uses = array('PharmacySalesBill');
        if (!empty($pharmacy)) {
            foreach ($pharmacy as $patientId => $tariffListId):
                foreach ($tariffListId as $id => $val):
                    if ($val != 0) {
                        $updateCorporateBillNo = $lastId;
                    } else {
                        $updateCorporateBillNo = "NULL";
                    }
                    $this->PharmacySalesBill->updateAll(array('PharmacySalesBill.corporate_super_bill_id' => $updateCorporateBillNo), array('PharmacySalesBill.patient_id' => $patientId));
                endforeach;
            endforeach;
            return true;
        }
    }

    //function to update corporateSuperBillNo in OT Pharmacy
    public function updateOTPharmacy($otPharmacy, $lastId) {
        $this->uses = array('OtPharmacySalesBill');
        if (!empty($otPharmacy)) {
            foreach ($otPharmacy as $patientId => $tariffListId):
                foreach ($tariffListId as $id => $val):
                    if ($val != 0) {
                        $updateCorporateBillNo = $lastId;
                    } else {
                        $updateCorporateBillNo = "NULL";
                    }
                    $this->OtPharmacySalesBill->updateAll(array('OtPharmacySalesBill.corporate_super_bill_id' => $updateCorporateBillNo), array('OtPharmacySalesBill.patient_id' => $patientId));
                endforeach;
            endforeach;
            return true;
        }
    }

    public function corporate_super_bill_list() {
        $this->layout = 'advance';
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'CorporateSuperBill', 'Account', 'TariffStandard');
        $pvtTariffId = $this->TariffStandard->getPrivateTariffID();
        $this->set('pvtTariffId', $pvtTariffId);
        if (!empty($this->request->query)) {
            $conditions = array();

            if (!empty($this->request->query['super_bill_no'])) {
                $conditions = array("CorporateSuperBill.super_bill_no" => $this->request->query['super_bill_no']);
            }

            if (!empty($this->request->query['person_id'])) {
                $conditions = array("CorporateSuperBill.person_id" => $this->request->query['person_id']);
            }
            if ($conditions) {
                $this->CorporateSuperBill->bindModel(array(
                    'belongsTo' => array(
                        'CorporateSuperBillList' => array(
                            'foreignKey' => false,
                            'fields' => array('SUM(CorporateSuperBillList.received_amount) as total_received'),
                            'conditions' => array('CorporateSuperBillList.is_deleted' => '0',
                                'CorporateSuperBillList.corporate_super_bill_id = CorporateSuperBill.id')),
                        'Person' => array(
                            'foreignKey' => 'person_id',
                            'type' => 'INNER',
                            'fields' => array('Person.id', 'CONCAT (Person.first_name," ",Person.last_name) as lookup_name')
                        ),
                        'TariffStandard' => array(
                            'foreignKey' => false,
                            'type' => 'INNER',
                            'fields' => array('TariffStandard.id', 'TariffStandard.name'),
                            'conditions' => array('CorporateSuperBill.tariff_standard_id=TariffStandard.id')))));
                $resultData = $this->CorporateSuperBill->find('all', array(
                    'conditions' => array('CorporateSuperBill.is_deleted' => 0,
                        /* 'CorporateSuperBill.bill_settled_date'=>NULL, */
                        $conditions),
                    'group' => array('CorporateSuperBill.id')));
                $this->set('results', $resultData);
                //Card Balance
                $cardBalance = $this->Account->find('first', array('fields' => array('Account.id', 'Account.card_balance'),
                    'conditions' => array('Account.system_user_id' => $resultData['0']['Person']['id'],
                        'user_type' => 'Patient')));
                $this->set('cardAdvance', $cardBalance);
            }
        }
    }

    //autocomplete to get the super bill number by swapnil - 08.07.2015
    public function getSuperBillNoAuto() {
        $this->uses = array('CorporateSuperBill');
        $this->layout = false;
        $this->autoRender = false;
        $searchKey = $this->params->query['term'];
        $data = $this->CorporateSuperBill->find('list', array(
            'fields' => array('CorporateSuperBill.id', 'CorporateSuperBill.super_bill_no'),
            'conditions' => array('CorporateSuperBill.is_deleted' => 0, 'CorporateSuperBill.super_bill_no LIKE' => "%" . $searchKey . "%"),
            'limit' => Configure::read('number_of_rows')));
        echo json_encode($data);
        exit;
    }

    public function receiveCorporateAmount($id) {
        $this->layout = 'advance_ajax';
        $this->uses = array('CorporateSuperBill', 'Person', 'CorporateSuperBillList');
        if (!empty($id)) {
            $this->CorporateSuperBill->bindModel(array(
                'belongsTo' => array(
                    'Person' => array(
                        'foreignKey' => 'person_id',
                        'fields' => array('Person.id', 'CONCAT (Person.first_name," ",Person.last_name) as lookup_name')
                )),
                'hasMany' => array(
                    'CorporateSuperBillList' => array(
                        'foreignKey' => 'corporate_super_bill_id',
                        'conditions' => array('CorporateSuperBillList.is_deleted' => '0')
                    )
                    )));
            $data = $this->CorporateSuperBill->find('first', array('conditions' => array('CorporateSuperBill.is_deleted' => 0, 'CorporateSuperBill.id' => $id)));
            foreach ($data['CorporateSuperBillList'] as $key => $val) {
                $data['CorporateSuperBill']['total_received'] += $val['received_amount'];
            }
            $this->set('result', $data);
        }
    }

    function updateCorporatePaymentReceived() {
        $this->layout = false;
        $this->autoRender = false;
        $this->uses = array('CorporateSuperBillList', 'CorporateSuperBill');
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['CorporateSuperBill']['corporate_super_bill_id'])) {
                $this->request->data['CorporateSuperBill']['created_time'] = date("Y-m-d H:i:s");
                $this->request->data['CorporateSuperBill']['created_by'] = $this->Auth->user('id');
                $this->CorporateSuperBillList->save($this->request->data['CorporateSuperBill']);
                $corporate = $this->CorporateSuperBill->find('first', array('conditions' => array('CorporateSuperBill.id' => $this->request->data['CorporateSuperBill']['corporate_super_bill_id'])));
                $recAmt = $corporate['CorporateSuperBill']['received_amount'] + $this->request->data['CorporateSuperBill']['received_amount'];
                $this->CorporateSuperBill->updateAll(array('received_amount' => "'$recAmt'"), array('CorporateSuperBill.id' => $corporate['CorporateSuperBill']['id']));
                return $this->redirect(array('action' => 'receiveCorporateAmount'));
            }
        }
    }

    //function to delete Corporate super Bill
    function corporateSuperBillDelete($id) {
        $this->uses = array('CorporateSuperBill', 'Patient');
        $data = $this->CorporateSuperBill->find('first', array('conditions' => array('CorporateSuperBill.id' => $id)));
        $pId = explode("|", $data['CorporateSuperBill']['patient_id']);
        if ($this->CorporateSuperBill->updateAll(array('CorporateSuperBill.is_deleted' => '1'), array('CorporateSuperBill.id' => $id))) {
            if ($this->Patient->updateAll(array('Patient.is_hidden_from_report' => '0'), array('Patient.id' => $pId))) {
                $this->Session->setFlash(__('The bill has been deleted successfully', true));
            }
        } else {
            $this->Session->setFlash(__('The bill could not be deleted, please try again'), true, array('class' => 'error'));
        }
        return $this->redirect(array('action' => 'corporate_super_bill_list'));
    }

    function corporateReceivedAmountDelete($id, $superBillID) {
        $this->uses = array('CorporateSuperBillList', 'CorporateSuperBill');
        $this->layout = false;
        $this->autoRender = false;
        if (!empty($id)) {
            $this->CorporateSuperBillList->updateAll(array('CorporateSuperBillList.is_deleted' => '1'), array('CorporateSuperBillList.id' => $id));

            $amt = $this->CorporateSuperBillList->find('first', array('conditions' => array('CorporateSuperBillList.id' => $id)));

            $corporate = $this->CorporateSuperBill->find('first', array('conditions' => array('CorporateSuperBill.id' => $superBillID)));

            $recAmt = $corporate['CorporateSuperBill']['received_amount'] - $amt['CorporateSuperBillList']['received_amount'];

            $this->CorporateSuperBill->updateAll(array('received_amount' => "'$recAmt'"), array('CorporateSuperBill.id' => $corporate['CorporateSuperBill']['id']));
        }
        $this->Session->setFlash(__('The bill has been deleted successfully'), true);
        $this->redirect($this->referer());
    }

    public function updatePatientType() {
        $this->loadModel('CorporateSuperBill');
        $this->CorporateSuperBill->updatePatientType($this->request->data['superBillId'], $this->request->data['patient_type']);
        exit;
    }

    public function updateApprovedAmt() {
        $this->loadModel('CorporateSuperBill');
        $this->CorporateSuperBill->updateApprovedAmt($this->request->data['superBillId'], $this->request->data['approved_amount']);
        exit;
    }

    function ConsultClub($consultArray) {

        foreach ($consultArray as $ckey => $consult) {

            $conSult[$consult['doctor_id']]['name'] = $consult['name'];
            if (!$conSult[$consult['doctor_id']]['from'])
                $conSult[$consult['doctor_id']]['from'] = $consult['date'];
            $conSult[$consult['doctor_id']]['tariff_list_id'] = $consult['tariff_list_id'];
            $conSult[$consult['doctor_id']]['cghs'] = $consult['cghs'];
            $conSult[$consult['doctor_id']]['rate'] = $consult['amount'];
            $conSult[$consult['doctor_id']]['no_of_times'] = $conSult[$consult['doctor_id']]['no_of_times'] + $consult['no_of_times'];
            $conSult[$consult['doctor_id']]['amount'] = $conSult[$consult['doctor_id']]['amount'] + $consult['amount'];
            $conSult[$consult['doctor_id']]['discount'] = $conSult[$consult['doctor_id']]['discount'] + $consult['discount'];
            $conSult[$consult['doctor_id']]['paid_amount'] = $conSult[$consult['doctor_id']]['paid_amount'] + $consult['paid_amount'];
            $conSult[$consult['doctor_id']]['patient_id'] = $consult['patient_id'];
            $conSult[$consult['doctor_id']]['to'] = $consult['date'];
        }
        return $conSult;
    }

    //*********************getExcel*******************************

    public function getExcel($billId = null/*$billData*/, $tariffId = null) {
        $this->autoRender = false;
        //$this->uses = array('Patient','TariffStandard','CorporateSuperBill');
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'CorporateSuperBill', 'Account', 'TariffStandard', 'TariffStdData');

        $billData = $this->CorporateSuperBill->find('first', array('conditions' => array('id' => $billId)));
        $patientId = $billData['CorporateSuperBill']['patient_id'];//$patient_id;
        //get tariff std id by patient id
        $tariffId = $this->TariffStandard->getTariffIDByPatientId($patientId);

        //get tariff std name by tariff std id
        $tariffName = $this->TariffStandard->getTariffStandardName($tariffId);
         switch ($tariffName) {
            case "WCL";
                $this->getWclExcel($patientId/*$billId*/, $tariffId); //done
                break;
            case "BSNL":
                $this->getBSNLExcel($patientId/*$billId*/, $tariffId);
                break;
            case "BHEL":
                $this->getBHELExcel($patientId/*$billId*/, $tariffId);
                break;
            case "MPKAY":
                $this->getMPKAYExcel($patientId/*$billId*/, $tariffId);
                break;
            case "MML":
                $this->getMMLExcel($patientId/*$billId*/, $tariffId);
                break;
            case "ECHS":
                $this->getECHSExcel($patientId/*$billId*/, $tariffId);
            default:
        }
        
        $this->PhpExcel->createWorksheet()->setDefaultFont('Times New Roman', 12); //to set the font and size
        // Create a first sheet, representing Product data
        $this->PhpExcel->setActiveSheetIndex(0);
        $this->PhpExcel->getActiveSheet()->setTitle('CGHS BILL'); //to set the worksheet title
        //$patientId='1';

        $data = $this->companyExcelReport($patientId/*$billId*/, $tariffId);
        $admisionDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['form_received_on'], Configure::read('date_format'), false);
        $dischargeDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['discharge_date'], Configure::read('date_format'), false);

        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "BILL", "", "", ""));

        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A:F')->getAlignment()->applyFromArray(
        		array(
        				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        				'rotation' => 0,
        				'wrap' => true
        		)
        );
        $this->PhpExcel->addTableRow(array("", "", "", "DATE:-  $dischargeDate", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "BILL NO", $data['billBo'], "", "", ""));
        //$this->PhpExcel->addTableRow(array("","BILL NO",$data['tariffStdData']['CorporateSuperBill']['patiend_bill_no'],"","",""));
        $this->PhpExcel->addTableRow(array("", "REGISTRATION NO:", $data['tariffStdData']['Patient']['admission_id'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NAME OF PATIENT: ", strtoupper($data['tariffStdData']['Patient']['lookup_name']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "AGE", $data['tariffStdData']['Patient']['age'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "SEX", strtoupper($data['tariffStdData']['Patient']['sex']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NAME OF CGHS BENEFICIARY", $data['tariffStdData']['Patient']['name_of_ip'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "RELATION WITH CGHS EMPLOYEE", $data['tariffStdData']['Patient']['relation_to_employee'], "", "", ""));

        $this->PhpExcel->addTableRow(array("", "EMPLOYEE ADDRESS", $data['tariffStdData']['Patient']['address1'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DESIGNATION", $data['tariffStdData']['Patient']['designation'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "CONTACT NO.", $data['tariffStdData']['Patient']['mobile_phone'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DIAGNOSIS", $data['tariffStdData']['Patient']['diagnosis_txt'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "CATEGORY", $data['tariffStdData']['Patient']['diagnosis_txt'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF ADMISSION ", $admisionDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF DISCHARGE", $dischargeDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $productsHead = array(
            array('label' => __(' Sr.no '), 'filter' => true),
            //array('label' =>  __('CGHS MOA Sr.No.' )),
            array('label' => __(' ITEM '), 'filter' => true, 'width' => 30, 'wrap' => true),
            array('label' => __(' CGHS NABH CODE No. '), 'width' => 20, 'wrap' => true),
            array('label' => __('CGHS NABH RATE '), 'width' => 10, 'wrap' => true),
            array('label' => __(' QTY '), 'width' => 10, 'wrap' => true),
            array('label' => __(' AMOUNT '), 'width' => 10, 'wrap' => true)
        );

        // add heading with different font and bold text
        $this->PhpExcel->addTableHeader($productsHead, array('name' => 'Cambria', 'bold' => true));

        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A21:F21')->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );


        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->mergeCells('A18:B18');
        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
        ));

        $this->PhpExcel->addTableRow(array("Conservative Treatment", "", "", "", ""));
        foreach ($data['conservative'] as $cons) {
           $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));

            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }

        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );

        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);

       $this->PhpExcel->addTableRow(array($count, "Consultation Charges", "", "", "", ""));

        //debug($data);exit;
        // BOF  Consultation For Inpatient
        if ($data['consultantArray']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            //$this->PhpExcel->addTableRow(array($count,"Consultation for Inpatient","2","","",""));
            $count = $count + 1;
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
            		array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            				'rotation' => 0,
            				'wrap' => true
            		)
            );
            $this->PhpExcel->addTableRow(array($count, "Consultation for Inpatients", "2", "", "", ""));
            foreach ($data['consultantArray'] as $consultKey => $consultVal) {
                
                $this->PhpExcel->addTableRow(array("", $consultVal['name'], "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $consultVal['from'] . " to " . $consultVal['to'], "", $consultVal['rate'], $consultVal['no_of_times'], $consultVal['amount']));
            }
        }$count = $count + 1;
        // EOF Consultation For Inpatient
        // BOF Accomodation For Ward
        if ($data['wardArray']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);

            foreach ($data['wardArray'] as $wardKey => $wardVal) {//debug($wardVal);exit;
                if ($wardVal['name']) {
                    $this->PhpExcel->addTableRow(array($count, "Accomodation For " . $data['wardName'] . " Ward", "", "", "", ""));
                 
                    foreach ($data['conservative'] as $conKey => $conVal) {
                        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                                array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'rotation' => 0,
                                    'wrap' => true
                                )
                        );
                        $wardAmt = $wardVal['amount'] * $conVal['days'];
                        $start = $this->DateFormat->formatDate2Local($conVal['start'], Configure::read('date_format'), false);
                        $end = $this->DateFormat->formatDate2Local($conVal['end'], Configure::read('date_format'), false);
                        $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $wardVal['amount'], $conVal['days'], $wardAmt));
                    }
                }
            }
            if ($data['wardIcu']){
                $count = $count + 1;
            //foreach($data['wardIcu'] as $wardKey =>$wardVal){

            $icuWardDays = count($data['wardIcu']);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Accomodation For ICU", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
                    )
            );
            $wardAmt = $data['wardIcu'][0]['amount'] * $icuWardDays;
            $start = $this->DateFormat->formatDate2Local($data['wardIcu'][0]['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($data['wardIcu'][$icuWardDays - 1]['end'], Configure::read('date_format'), false);
            $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $data['wardIcu'][0]['amount'], $icuWardDays, $wardAmt));

            //}
            }
            $count = $count + 1;
        }
        // EOF Accomodation For Ward
        if ($data['consCharges']) {
            foreach ($data['consCharges'] as $docNurse) {
                $perDayDoc = 0;
                $perDayNurse = 0;
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array($count, "Doctor Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Doctor']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Doctor']['amount']));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array($count, "Nurse Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Nurse']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Nurse']['amount']));
                $count++;
            }
        } 

        // BOF Pathology
        if ($data['total']['Laboratory']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Pathology Charges", "", $data['total']['Laboratory'], "1", $data['total']['Laboratory']));
            $count = $count + 1;
            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pathology Break-up", "", "", "", ""));
        }
        // EOF Pathology
        //BOF Medicene
        if ($data['total']['Pharmacy']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Medicine Charges", "", $data['total']['Pharmacy'], "1", $data['total']['Pharmacy']));

            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pharmacy Statement with Bills", "", "", "", ""));
            $count = $count + 1;
        }
        // EOF Medicene
        // BOF Services
        if ($data['serviceArray']) {
            foreach ($data['serviceArray'] as $serClubKey => $serClubVal) {
                foreach ($serClubVal as $keyName => $val) {
                    $resetArray[$serClubKey][$val['tariff_list_id']][] = $val;
                }
            }
            $returnArray = array();
            /*foreach ($resetArray[$serClubKey] as $key => $value) {
                foreach ($value as $retKey => $retVal) {

                    $returnArray[$key]['name'] = $retVal['name'];
                    $returnArray[$key]['rate'] = $retVal['amount'];
                    $returnArray[$key]['no_of_times']+= $retVal['no_of_times'];
                    $returnArray[$key]['amount']+=$retVal['amount'] * $retVal['no_of_times'];
                    $returnArray[$key]['cghs_code'] = $retVal['cghs'];
                }
            }*/
            foreach ($resetArray as $key => $value) {
            	foreach ($value as $retKey => $retVal) {
            		foreach($retVal as $val){
            			$returnArray[$retKey]['name'] = $val['name'];
            			$returnArray[$retKey]['rate'] = $val['amount'];
            			$returnArray[$retKey]['no_of_times']+= $val['no_of_times'];
            			$returnArray[$retKey]['amount']+=$val['amount'] * $val['no_of_times'];
            			$returnArray[$retKey]['cghs_code'] = $val['CGHS'];
            		}
            	}
            }
            foreach ($returnArray as $serviceKey => $serviceVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $serviceTotal = $serviceVal['rate'] * $serviceVal['no_of_times'];
                $this->PhpExcel->addTableRow(array($count, $serviceVal['name'], $serviceVal['cghs_code'], $serviceVal['rate'], $serviceVal['no_of_times'], $serviceTotal));
                $count++;
            }
        }

        //exit;
        // EOF Services
        // BOF Radiology
        if ($data['radArray']) {
            foreach ($data['radArray'] as $radKey => $radVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array($count, $radVal['name'], $radVal['cghs_code'], $radVal['amount'], $radVal['no_of_times'], $radVal['amount'] * $radVal['no_of_times']));
                $count++;
            }
        }
        // EOF Radiology
        //debug($data['surgeryArray']);exit;
        // BOF Surgery
        if ($data['surgeryArray']['fromDate']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", " Surgical Treatment( " . $data['surgeryArray']['fromDate'] . " To " . $data['surgeryArray'][to] . ")", "", "", "", ""));
            $serialCharArray = array('a)', 'b)', 'c)', 'd)', 'e)', 'f)', 'g)', 'h)', 'i)');
            $corporateStatus=Configure::read('corporateStatus');
            foreach ($data['surgeryArray'] as $surKey => $surVal) {
                foreach ($surVal as $skey => $surgeryList) {
                		foreach($surgeryList as $key=>$surgery){
                /*$data['superbillData']['CorporateSuperBill']['patient_type']*/
                	
                	$surAmt=$surgery['amount'];
                	$this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                			array(
                					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                					'rotation' => 0,
                					'wrap' => true
                			)
                	);
                	$this->PhpExcel->getActiveSheet()->getStyle("F" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                			array(
                					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                					'rotation' => 0,
                					'wrap' => true
                			)
                	);
                    if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'general') {
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per CGHS Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per CGHS Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] - $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per CGHS Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'shared') {//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'Semi-Special' || $data['superbillData']['CorporateSuperBill']['patient_type'] == 'Semi-Private'
						//For semi private original surgery amt for any no of surgeries -- Pooja 22/03/16                 	
                    	if ($key == 1) {                    		
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "1", $surAmt));
							
                            /*$dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per CGHS Guideline", $surgery['tenPer'], "1", $dedAmt));*/
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "1", $surAmt));
                           /* $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per CGHS Guideline", $surgery['fiftyPer'], "1", $dedAmt));*/
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'special') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'Special' || $data['superbillData']['CorporateSuperBill']['patient_type'] == 'Private'
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "", ""));
                            $dedAmt = $surgery['amount'] + $surgery['15Per'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 15% more as per CGHS Guideline", $surgery['15Per'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per CGHS Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] + $surgery['15Per'];
                            $this->PhpExcel->addTableRow(array("", "", " 15% More as per CGHS Guideline", $surgery['15Per'], "1", $dedAmt));
                        }
                    }
                    $count++;
                }
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array("", "Operated On dt." . $skey, "", "", "", ""));
              }//eof inner foreach
              
            }//eof outer foreach

			
        }
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $row = $this->PhpExcel->_row - 1;
        $totalAmount = "=SUM(F1:F" . $row . ")";
        /* $countRow= $this->PhpExcel->_row+1;
          //debug($countRow); exit; */
        $totalCellBlock = "F" . $countRow;
        $totalTextBlock = "B" . $countRow;
        $totalTextBlock = "C" . $countRow;

        $totalTextBlock = "E" . $countRow;

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        /* $this->PhpExcel->getActiveSheet()->setCellValue($totalTextBlock,"TOTAL BILL AMOUNT" );
          $this->PhpExcel->getActiveSheet()->setCellValue($totalCellBlock,$totalAmount ); */



        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("B" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("F" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->addTableRow(array("", "TOTAL BILL AMOUNT", "", "", "", "$totalAmount"));



        //$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row+7)->getFont()->setBold(true);
        //$this->PhpExcel->addTableRow(array("","Operated On dt.".$data['surgeryArray']['from'],"","","",""));


        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", " Bill Manager ", " Cashier  ", " Med.Supdt ", " Authorised Signatory "));




        // close table and output
        $this->PhpExcel->addTableFooter()->output('CGHS BILL.xlsx'); //Store Location List (file name)
    }

    //**********WclEcxel*******************
    public function getWclExcel($billId = null, $tariffId = null) {

        $this->autoRender = false;

        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'CorporateSuperBill', 'Account', 'TariffStandard');

        $this->PhpExcel->createWorksheet()->setDefaultFont('Times New Roman', 12); //to set the font and size
        // Create a first sheet, representing Product data
        $this->PhpExcel->setActiveSheetIndex(0);
        $this->PhpExcel->getActiveSheet()->setTitle('WCL BILL'); //to set the worksheet title
        //$patientId='1';
        $romanArray = array('i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'ix', 'x');

        $data = $this->companyExcelReport($billId, $tariffId);

        $admisionDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['form_received_on'], Configure::read('date_format'), false);
        $dischargeDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['discharge_date'], Configure::read('date_format'), false);

        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "BILL", "", "", ""));
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "WCL WANI NORTH AREA", "", "", ""));
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "", "DATE:-  $dischargeDate", "", "", "", ""));

        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A:G')->getAlignment()->applyFromArray(
        		array(
        				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        				'rotation' => 0,
        				'wrap' => true
        		)
        );        
        $this->PhpExcel->addTableRow(array("", "BILL NO", $data['billBo'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "REGISTRATION NO", $data['tariffStdData']['Patient']['admission_id'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NAME OF PATIENT ", strtoupper($data['tariffStdData']['Patient']['lookup_name']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "AGE", $data['tariffStdData']['Patient']['age'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "SEX", strtoupper($data['tariffStdData']['Patient']['sex']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NAME OF WCL BENEFICIARY", $data['tariffStdData']['Patient']['name_of_ip'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "RELATION WITH WCL EMPLOYEE", $data['tariffStdData']['Patient']['relation_to_employee'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "UNIT NAME / MINE ", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NEIS CODE NUMBER	", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "AEIS CODE NUMBER", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "EMPLOYEE ADDRESS", $data['tariffStdData']['Patient']['address1'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DESIGNATION", $data['tariffStdData']['Patient']['designation'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "CONTACT NO.", $data['tariffStdData']['Patient']['mobile_phone'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DIAGNOSIS", $data['tariffStdData']['Patient']['diagnosis_txt'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF ADMISSION ", $admisionDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF DISCHARGE", $dischargeDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $productsHead = array(
            array('label' => __(' Sr.no '), 'filter' => true),
            array('label' => __(' ITEM '), 'width' => 30, 'wrap' => true),
            array('label' => __(' WCL NABH Code No. '),'width' => 15, 'wrap' => true),
            array('label' => __(' WCL NABH Rate '),'width' => 10, 'wrap' => true),
            array('label' => __(' Qty '),'width' => 10, 'wrap' => true),
            array('label' => __(' AmountMOUNT '),'width' => 10, 'wrap' => true),
            array('label' => __(' Total Amount '),'width' => 10, 'wrap' => true)
        );

        // add heading with different font and bold text
        $this->PhpExcel->addTableHeader($productsHead, array('name' => 'Cambria', 'bold' => true));

        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A21:G21')->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );


        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setSize(16);


        $this->PhpExcel->getActiveSheet()->mergeCells('A22:B22');
        $this->PhpExcel->getActiveSheet()->getStyle('A' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
        ));
        $this->PhpExcel->addTableRow(array("Conservative Treatment", "", "", "", ""));
        foreach ($data['conservative'] as $cons) {
            $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));
            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }

        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );


        // BOF  Consultation For Inpatient
        if ($data['consultantArray']) {
            $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);

            $this->PhpExcel->addTableRow(array($count, " Consultation Charges", "", "", "", ""));

            //$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
            //$this->PhpExcel->addTableRow(array($count,"Consultation for C","2","","",""));
            $consultantTotal = 0;
            $co = 0;
            foreach ($data['consultantArray'] as $consultKey => $consultVal) {
                //$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "$romanArray[$co])  Consultation for Inpatients", "2", "", "", ""));
                $this->PhpExcel->addTableRow(array("", $consultVal['name'], "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $consultantTotal += $consultVal['amount'];
                $this->PhpExcel->addTableRow(array("", "Dt " . $consultVal['from'] . " to " . $consultVal['to'], "", $consultVal['rate'], $consultVal['no_of_times'], $consultVal['amount']));
                $co++;
            }
            $count = $count + 1;


            //sub total
            $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $firstCell="D".$this->PhpExcel->_row;
            $lastCell="F".$this->PhpExcel->_row;
            $this->PhpExcel->getActiveSheet()->mergeCells("$firstCell:$lastCell");
            $this->PhpExcel->getActiveSheet()->getStyle('D' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
            		array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            				'rotation' => 0,
            				'wrap' => true
            		)
            );
            $this->PhpExcel->addTableRow(array("", "", "", "Sub Total:-", "", "", $consultantTotal));
        }
        $accomodationTotal = 0;
        // EOF Consultation For Inpatient
        // BOF Accomodation For Ward

        if ($data['wardArray']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, "Accomodation Charges", "", "", "", ""));
            $r = 0;
            foreach ($data['wardArray'] as $wardKey => $wardVal) {
                if ($wardVal['name']) {
                    $this->PhpExcel->addTableRow(array(" ", "$romanArray[$r] )  Accomodation For " . $data['wardName'] . " Ward", "", "", "", ""));
                    foreach ($data['conservative'] as $conKey => $conVal) {
                        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                                array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'rotation' => 0,
                                    'wrap' => true
                                )
                        );
                        $wardAmt = $wardVal['amount'] * $conVal['days'];
                        $start = $this->DateFormat->formatDate2Local($conVal['start'], Configure::read('date_format'), false);
                        $end = $this->DateFormat->formatDate2Local($conVal['end'], Configure::read('date_format'), false);
                        $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $data['amount'], $conVal['days'], $wardAmt));
                        $accomodationTotal +=$wardAmt;
                    }
                }
                $r++;
            }

            //if($data['wardIcu'])
            //$count=$count+1; 
            foreach ($data['wardIcu'] as $wardKey => $wardVal) {
                $this->PhpExcel->addTableRow(array(" ", "$romanArray[$r] ) Accomodation For " . $wardVal['name'], "", "", "", ""));

                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                //	$accomodationTotal += $wardAmt=$wardVal['amount']*$wardVal['days'];
                $start = $this->DateFormat->formatDate2Local($wardVal['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($wardVal['end'], Configure::read('date_format'), false);
                $wardAmt = $wardVal['amount'] * $wardVal['days'];
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $wardVal['amount'], $wardVal['days'], $wardAmt));
                $accomodationTotal +=$wardAmt;
            }
            $count = $count + 1;
            $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $firstCell="D".$this->PhpExcel->_row;
            $lastCell="F".$this->PhpExcel->_row;
            $this->PhpExcel->getActiveSheet()->mergeCells("$firstCell:$lastCell");
            
            $this->PhpExcel->getActiveSheet()->getStyle('D' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
            		array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            				'rotation' => 0,
            				'wrap' => true
            		)
            );
            $this->PhpExcel->addTableRow(array("", "", "", "Sub Total:-", "", "", $accomodationTotal));
        }

        // EOF Accomodation For Ward
        if ($data['consCharges']) {
            foreach ($data['consCharges'] as $docNurse) {
                $perDayDoc = 0;
                $perDayNurse = 0;
                $consChargesTotal = 0;
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setSize(14);
                $this->PhpExcel->addTableRow(array($count, "Doctor Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Doctor']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Doctor']['amount']));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array("", "Nurse Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Nurse']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $consChargesTotal +=$docNurse['Nurse']['amount'];
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Nurse']['amount']));
                $count++;
            }

            $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $firstCell="D".$this->PhpExcel->_row;
            $lastCell="F".$this->PhpExcel->_row;
            $this->PhpExcel->getActiveSheet()->mergeCells("$firstCell:$lastCell");
            $this->PhpExcel->getActiveSheet()->getStyle('D' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
            		array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            				'rotation' => 0,
            				'wrap' => true
            		)
            );
            $this->PhpExcel->addTableRow(array("", "", "", "Sub Total:-", "", "", $consChargesTotal));
        }


        // BOF Pathology
        if ($data['total']['Laboratory']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, "Pathology Charges", "", $data['total']['Laboratory'], "1", $data['total']['Laboratory']));
            $count = $count + 1;
            $pathologyTotal = 0;
            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $pathologyTotal += $data['total']['Laboratory'];
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pathology Break-up", "", "", "", ""));
        }
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setSize(14);
        $firstCell="D".$this->PhpExcel->_row;
        $lastCell="F".$this->PhpExcel->_row;
        $this->PhpExcel->getActiveSheet()->mergeCells("$firstCell:$lastCell");
        $this->PhpExcel->getActiveSheet()->getStyle('D' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
        		array(
        				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        				'rotation' => 0,
        				'wrap' => true
        		)
        );
        $this->PhpExcel->addTableRow(array("", "", "", "Sub Total:-", "", "", $pathologyTotal));
        // EOF Pathology
        //BOF Medicene
        if ($data['total']['Pharmacy']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, "Medicine Charges", "", round($data['total']['Pharmacy']), "1", round($data['total']['Pharmacy'])));

            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $tenPerAmt=$this->getPerCharge(round($data['total']['Pharmacy']),'10');//get 10% amount of pharmacy bill
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            
            $this->PhpExcel->addTableRow(array("", "10% less as per WCL guidelines", "", "", "", "$tenPerAmt",""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);            
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pharmacy Statement with Bills", "", "", "", ""));
            $count = $count + 1;            
            $medicineTotal =$data['total']['Pharmacy']-round($tenPerAmt);//deduct 10% pharmacy bill from actual pharmacy bill amt
        }
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setSize(14);
        
        $firstCell="D".$this->PhpExcel->_row;
        $lastCell="F".$this->PhpExcel->_row;
        $this->PhpExcel->getActiveSheet()->mergeCells("$firstCell:$lastCell");
        $this->PhpExcel->getActiveSheet()->getStyle('D' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
        		array(
        				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        				'rotation' => 0,
        				'wrap' => true
        		)
        );
        $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setSize(14);
        
        $this->PhpExcel->addTableRow(array("", "", "", "Sub Total:-", "", "", round($medicineTotal)));
        // EOF Medicene
        ///debug($data['serviceArray']);exit;
        // BOF Services
        $corporateStatus=Configure::read('corporateStatus');
        if ($data['serviceArray']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, " Any Other Expenses", "", "", "", ""));
			foreach ($data['serviceArray'] as $serClubKey => $serClubVal) {
                foreach ($serClubVal as $keyName => $val) {
                    $resetArray[$serClubKey][$val['tariff_list_id']][] = $val;
                }
            }
            $returnArray = array();
            $ser = 0;
            foreach ($resetArray as $key => $value) {
                foreach ($value as $retKey => $retVal) {
                	foreach($retVal as $val){
	                    $returnArray[$retKey]['name'] = $val['name'];
	                    $returnArray[$retKey]['rate'] = $val['amount'];
	                    $returnArray[$retKey]['no_of_times']+= $val['no_of_times'];
	                    $returnArray[$retKey]['amount']+=$val['amount'] * $val['no_of_times'];
	                    $returnArray[$retKey]['cghs_code'] = $val['CGHS'];
                	}
                }
            }
             $servicesTotal = 0;
            foreach ($returnArray as $serviceKey => $serviceVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));


                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $serviceTotal = $serviceVal['amount'];
                //$servicesTotal+=$serviceTotal;
                $this->PhpExcel->addTableRow(array('', "$romanArray[$ser] )  " . $serviceVal['name'], $serviceVal['cghs_code'], $serviceVal['rate'], $serviceVal['no_of_times'], $serviceTotal));
                $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setSize(14);
                $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setSize(14);
                $firstCell="D".$this->PhpExcel->_row;
                $lastCell="F".$this->PhpExcel->_row;
                $this->PhpExcel->getActiveSheet()->mergeCells("$firstCell:$lastCell");
                $this->PhpExcel->getActiveSheet()->getStyle('D' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                		array(
                				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                				'rotation' => 0,
                				'wrap' => true
                		)
                );
                $this->PhpExcel->addTableRow(array("", "", "", "Sub Total:-", "", "", $serviceTotal));
            }
        }$count++;


        //exit;
        // EOF Services
        // BOF Radiology(mril)
        if ($data['radArray']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array("$count", "Radiology Charges "));
            $radioloagyTotal = 0;
            $ra = 0;
            foreach ($data['radArray'] as $radKey => $radVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $radioloagyTotal +=$radVal['amount'] * $radVal['no_of_times'];
                //debug($radioloagyTotal);exit;
                $this->PhpExcel->addTableRow(array('', "$romanArray[$ra])  " . $radVal['name'], $radVal['cghs_code'], $radVal['amount'], $radVal['no_of_times'], $radVal['amount'] * $radVal['no_of_times']));
                $ra++;
            }
            $count++;
            $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $firstCell="D".$this->PhpExcel->_row;
            $lastCell="F".$this->PhpExcel->_row;
            $this->PhpExcel->getActiveSheet()->mergeCells("$firstCell:$lastCell");
            $this->PhpExcel->getActiveSheet()->getStyle('D' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
            		array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            				'rotation' => 0,
            				'wrap' => true
            		)
            );
            $this->PhpExcel->addTableRow(array("", "", "", "Sub Total:-", "", "", $radioloagyTotal));
        }
        // EOF Radiology
        //debug($data['surgeryArray']);exit;
        // BOF Surgery
        if ($data['surgeryArray']['fromDate']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, " Surgical Treatment( " . $data['surgeryArray']['fromDate'] . " To " . $data['surgeryArray'][to] . ")", "", "", "", ""));
            $corporateStatus=Configure::read('corporateStatus');
            $serialCharArray = array('a)', 'b)', 'c)', 'd)', 'e)', 'f)', 'g)', 'h)', 'i)');
            foreach ($data['surgeryArray'] as $surKey => $surVal) {
                foreach ($surVal as $skey => $surgeryList) {
                	foreach($surgeryList as $key=>$surgery){
                	if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'general') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'General'
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per WCL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per WCL Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] - $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per WCL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'shared') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'Semi-Special'
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per WCL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per WCL Guideline", $surgery['fiftyPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'special') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'Special'
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] + $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 15% more as per WCL Guideline", $surgery['15Per'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per WCL Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] + $surgery['15Per'];
                            $this->PhpExcel->addTableRow(array("", "", " 15% More as per WCL Guideline", $surgery['15Per'], "1", $dedAmt));
                        }
                    }
                    $surgeryTotal +=$dedAmt;
                }
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array("", "Operated On dt." . $skey, "", "", "", ""));
                }

                //debug($surgeryTotal);exit;
                $count++;
            }
            //debug($surgeryTotal);exit;


            $this->PhpExcel->getActiveSheet()->getStyle('D' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
            		array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            				'rotation' => 0,
            				'wrap' => true
            		)
            );

            $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $firstCell="D".$this->PhpExcel->_row;
            $lastCell="F".$this->PhpExcel->_row;
            $this->PhpExcel->getActiveSheet()->mergeCells("$firstCell:$lastCell");
            
            $this->PhpExcel->addTableRow(array("", "", "", "Sub Total:-", "", "", $surgeryTotal));
        }
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $row = $this->PhpExcel->_row - 1;
        $totalAmount = "=SUM(G1:G" . $row . ")";
        /* $countRow= $this->PhpExcel->_row+1;
          //debug($countRow); exit; */
        $totalCellBlock = "F" . $countRow;
        $totalTextBlock = "G" . $countRow;
        $totalTextBlock = "C" . $countRow;

        $totalTextBlock = "E" . $countRow;

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("G" . $this->PhpExcel->_row)->getFont()->setSize(14);
        $firstCell="D".$this->PhpExcel->_row;
        $lastCell="E".$this->PhpExcel->_row;
        $this->PhpExcel->getActiveSheet()->mergeCells("$firstCell:$lastCell");
        $this->PhpExcel->addTableRow(array("", "", "", "GRAND TOTAL", "", "", $totalAmount));
        
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", " Bill Manager ", " Cashier  ", " Med.Supdt ", " Authorised Signatory "));


		 // close table and output
        $this->PhpExcel->addTableFooter()->output('WCL BILL'); //Store Location List (file name)
    }

    //************MPKAY Excel*****************************

    public function getMPKAYExcel($billId = null, $tariffId = null) {

        $this->autoRender = false;

        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'CorporateSuperBill', 'Account', 'TariffStandard');

        $this->PhpExcel->createWorksheet()->setDefaultFont('Times New Roman', 12); //to set the font and size
        // Create a first sheet, representing Product data
        $this->PhpExcel->setActiveSheetIndex(0);
        $this->PhpExcel->getActiveSheet()->setTitle('BSNL BILL'); //to set the worksheet title
        //$patientId='1';

        $data = $this->companyExcelReport($billId, $tariffId);
        //$data=$this->corporate_super_bill_list($pvtTariffId,$billId,$tariffId);


        $admisionDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['form_received_on'], Configure::read('date_format'), false);
        $dischargeDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['discharge_date'], Configure::read('date_format'), false);

        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "BILL", "", "", ""));

        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A:F')->getAlignment()->applyFromArray(
        		array(
        				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        				'rotation' => 0,
        				'wrap' => true
        		)
        );
        $this->PhpExcel->addTableRow(array("", "", "", "DATE:-  $dischargeDate", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "BILL NO", $data['billBo'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "REGISTRATION NO", $data['tariffStdData']['Patient']['admission_id'], "", "", ""));

        $this->PhpExcel->addTableRow(array("", "NAME OF PATIENT ", strtoupper($data['tariffStdData']['Patient']['lookup_name']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "AGE", $data['tariffStdData']['Patient']['age'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "SEX", strtoupper($data['tariffStdData']['Patient']['sex']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NAME OF THE MAIN MEMBER", $data['tariffStdData']['Patient']['name_of_ip'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DESIGNATION", $data['tariffStdData']['Patient']['designation'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "RELATION WITH MAIN MEMBER", $data['tariffStdData']['Patient']['relation_to_employee'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "CONTACT NO.", $data['tariffStdData']['Patient']['mobile_phone'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "GPF NUMBER / EMPLOYEE CODE", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "PATIENT UHID NO.", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "UNIT NAME", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "BASIC SALARY", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF ADMISSION ", $admisionDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF DISCHARGE", $dischargeDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DIAGNOSIS", $data['tariffStdData']['Patient']['diagnosis_txt'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $productsHead = array(
            array('label' => __(' Sr.no '), 'filter' => true,'wrap' => true),
            array('label' => __(' ITEM '), 'filter' => true, 'width' => 30, 'wrap' => true),
            array('label' => __(' MPKAY NABH Code No. '), 'width' => 15, 'wrap' => true),
            array('label' => __(' MPKAY NABH Rate '), 'width' => 15, 'wrap' => true),
            array('label' => __(' Qty '), 'width' => 10, 'wrap' => true),
            array('label' => __(' Amount '), 'width' => 10, 'wrap' => true)
        );
        // add heading with different font and bold text
        $this->PhpExcel->addTableHeader($productsHead, array('name' => 'Cambria', 'bold' => true));

        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A21:F21')->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );

        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        
        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
        ));
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setSize(14);
        $this->PhpExcel->addTableRow(array("Conservative Treatment", "", "", "", ""));
        $this->PhpExcel->getActiveSheet()->mergeCells('A21:B21');
        foreach ($data['conservative'] as $cons) {
            $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));
            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }

        /* $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
      $this->PhpExcel->addTableRow(array($count, " Consultation Charges", "", "", "", ""));
        foreach ($data['conservative'] as $cons) {
            $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));
            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }*/
        $count=$count+1;
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );

        //debug($data);exit;
        // BOF  Consultation For Inpatient
        if ($data['consultantArray']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );                
            
            $this->PhpExcel->addTableRow(array("$count", "Consultation for Inpatients", "2", "", "", ""));
            $count = $count + 1;
            foreach ($data['consultantArray'] as $consultKey => $consultVal) {
                
                $this->PhpExcel->addTableRow(array("", $consultVal['name'], "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $consultVal['from'] . " to " . $consultVal['to'], "", $consultVal['rate'], $consultVal['no_of_times'], $consultVal['amount']));
            }
        }
        // EOF Consultation For Inpatient
        // BOF Accomodation For Ward
        if ($data['wardArray']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, "Accomodation Charges", "", "", "", ""));
            $r = 0;
            foreach ($data['wardArray'] as $wardKey => $wardVal) {
                if ($wardVal['name']) {
                    $this->PhpExcel->addTableRow(array(" ", "Accomodation For " . $wardVal['name'] . " Ward", "", "", "", ""));
                    foreach ($data['conservative'] as $conKey => $conVal) {
                        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                                array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'rotation' => 0,
                                    'wrap' => true
                                )
                        );
                        $wardAmt = $wardVal['amount'] * $conVal['days'];
                        $start = $this->DateFormat->formatDate2Local($conVal['start'], Configure::read('date_format'), false);
                        $end = $this->DateFormat->formatDate2Local($conVal['end'], Configure::read('date_format'), false);
                        $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $wardVal['amount'], $conVal['days'], $wardAmt));
                        $accomodationTotal +=$wardAmt;
                    }
                }
                $r++;
            }

            //if($data['wardIcu'])
            //$count=$count+1; 
            foreach ($data['wardIcu'] as $wardKey => $wardVal) {
                $this->PhpExcel->addTableRow(array(" ", " Accomodation For " . $wardVal['name'], "", "", "", ""));

                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                //	$accomodationTotal += $wardAmt=$wardVal['amount']*$wardVal['days'];
                $start = $this->DateFormat->formatDate2Local($wardVal['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($wardVal['end'], Configure::read('date_format'), false);
                $wardAmt = $wardVal['amount'] * $wardVal['days'];
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $wardVal['amount'], $wardVal['days'], $wardAmt));
                $accomodationTotal +=$wardAmt;
            }
            $count = $count + 1;
            
        }
        // EOF Accomodation For Ward
        if ($data['consCharges']) {
            foreach ($data['consCharges'] as $docNurse) {
                $perDayDoc = 0;
                $perDayNurse = 0;
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array($count, "Doctor Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Doctor']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Doctor']['amount']));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array("", "Nurse Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Nurse']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Nurse']['amount']));
                $count++;
            }
        }

        // BOF Pathology
        if ($data['total']['Laboratory']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Pathology Charges", "", $data['total']['Laboratory'], "1", $data['total']['Laboratory']));
            $count = $count + 1;
            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pathology Break-up", "", "", "", ""));
        }
        // EOF Pathology
        //BOF Medicene
        if ($data['total']['Pharmacy']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Medicine Charges", "", $data['total']['Pharmacy'], "1", $data['total']['Pharmacy']));

            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pharmacy Statement with Bills", "", "", "", ""));
            $count = $count + 1;
        }
        // EOF Medicene
        // BOF Services
        if ($data['serviceArray']) {
            foreach ($data['serviceArray'] as $serClubKey => $serClubVal) {
                foreach ($serClubVal as $keyName => $val) {
                    $resetArray[$serClubKey][$val['tariff_list_id']][] = $val;
                }
            }
            $returnArray = array();
            /*foreach ($resetArray[$serClubKey] as $key => $value) {
                foreach ($value as $retKey => $retVal) {

                    $returnArray[$key]['name'] = $retVal['name'];
                    $returnArray[$key]['rate'] = $retVal['amount'];
                    $returnArray[$key]['no_of_times']+= $retVal['no_of_times'];
                    $returnArray[$key]['amount']+=$retVal['amount'] * $retVal['no_of_times'];
                    $returnArray[$key]['cghs_code'] = $retVal['cghs'];
                }
            }*/
            foreach ($resetArray as $key => $value) {
            	foreach ($value as $retKey => $retVal) {
            		foreach($retVal as $val){
            			$returnArray[$retKey]['name'] = $val['name'];
            			$returnArray[$retKey]['rate'] = $val['amount'];
            			$returnArray[$retKey]['no_of_times']+= $val['no_of_times'];
            			$returnArray[$retKey]['amount']+=$val['amount'] * $val['no_of_times'];
            			$returnArray[$retKey]['cghs_code'] = $val['CGHS'];
            		}
            	}
            }
            foreach ($returnArray as $serviceKey => $serviceVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $serviceTotal = $serviceVal['rate'] * $serviceVal['no_of_times'];
                $this->PhpExcel->addTableRow(array($count, $serviceVal['name'], $serviceVal['cghs_code'], $serviceVal['rate'], $serviceVal['no_of_times'], $serviceTotal));
                $count++;
            }
        }

        //exit;
        // EOF Services
        // BOF Radiology
        if ($data['radArray']) {
            foreach ($data['radArray'] as $radKey => $radVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array($count, $radVal['name'], $radVal['cghs_code'], $radVal['amount'], $radVal['no_of_times'], $radVal['amount'] * $radVal['no_of_times']));
                $count++;
            }
        }
        // EOF Radiology
        // BOF Surgery
        if ($data['surgeryArray']['fromDate']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, " Surgical Treatment( " . $data['surgeryArray']['fromDate'] . " To " . $data['surgeryArray'][to] . ")", "", "", "", ""));

            $serialCharArray = array('a)', 'b)', 'c)', 'd)', 'e)', 'f)', 'g)', 'h)', 'i)');
            $corporateStatus=Configure::Read('corporateStatus');
            foreach ($data['surgeryArray'] as $surKey => $surVal) {
                foreach ($surVal as $skey => $surgeryList) {
                	foreach($surgeryList as $key=>$surgery){
                    if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'general') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'General'
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per MPKAY Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per MPKAY Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] - $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per MPKAY Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'shared') {
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per MPKAY Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per MPKAY Guideline", $surgery['fiftyPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'special') {
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] + $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 15% more as per MPKAY Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per MPKAY Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] + $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 15% Less as per MPKAY Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    }
                	}
                	$this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                	$this->PhpExcel->addTableRow(array("", "Operated On dt." . $skey, "", "", "", ""));
                }
                //debug($surgeryTotal);exit;
                $count++;
            }
            
        }
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $row = $this->PhpExcel->_row - 1;
        $totalAmount = "=SUM(F1:F" . $row . ")";
        /* $countRow= $this->PhpExcel->_row+1;
          //debug($countRow); exit; */
        $totalCellBlock = "F" . $countRow;
        $totalTextBlock = "B" . $countRow;
        $totalTextBlock = "C" . $countRow;

        $totalTextBlock = "E" . $countRow;

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        /* $this->PhpExcel->getActiveSheet()->setCellValue($totalTextBlock,"TOTAL BILL AMOUNT" );
          $this->PhpExcel->getActiveSheet()->setCellValue($totalCellBlock,$totalAmount ); */



        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("B" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("F" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->addTableRow(array("", "TOTAL BILL AMOUNT", "", "", "", "$totalAmount"));


        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", " Bill Manager ", " Cashier  ", " Med.Supdt ", " Authorised Signatory "));


        // close table and output
        $this->PhpExcel->addTableFooter()->output('MPKAY BILL'); //Store Location List (file name)
    }

    //*********BHELExcel**********************

    public function getBHELExcel($billId = null, $tariffId = null) {

        $this->autoRender = false;

        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'CorporateSuperBill', 'Account', 'TariffStandard');

        $this->PhpExcel->createWorksheet()->setDefaultFont('Times New Roman', 12); //to set the font and size
        // Create a first sheet, representing Product data
        $this->PhpExcel->setActiveSheetIndex(0);
        $this->PhpExcel->getActiveSheet()->setTitle('BHEL BILL'); //to set the worksheet title
        //$patientId='1';

        $data = $this->companyExcelReport($billId, $tariffId);
        //$data=$this->corporate_super_bill_list($pvtTariffId,$billId,$tariffId);


        $admisionDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['form_received_on'], Configure::read('date_format'), false);
        $dischargeDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['discharge_date'], Configure::read('date_format'), false);

        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "BILL", "", "", ""));

        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A:F')->getAlignment()->applyFromArray(
        		array(
        				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        				'rotation' => 0,
        				'wrap' => true
        		)
        );
        $this->PhpExcel->addTableRow(array("", "", "", "DATE:-  $dischargeDate", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "BILL NO", $data['billBo'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "REGISTRATION NO", $data['tariffStdData']['Patient']['admission_id'], "", "", ""));

        $this->PhpExcel->addTableRow(array("", "NAME OF PATIENT ", strtoupper($data['tariffStdData']['Patient']['lookup_name']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "AGE", $data['tariffStdData']['Patient']['age'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "SEX", strtoupper($data['tariffStdData']['Patient']['sex']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NAME OF BHEL BENEFICIARY", $data['tariffStdData']['Patient']['name_of_ip'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "RELATION WITH BHEL EMPLOYEE", $data['tariffStdData']['Patient']['relation_to_employee'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "EMPLOYEE ADDRESS", $data['tariffStdData']['Patient']['address1'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DESIGNATION", $data['tariffStdData']['Patient']['designation'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DIAGNOSIS", $data['tariffStdData']['Patient']['diagnosis_txt'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "CONTACT NO.", $data['tariffStdData']['Patient']['mobile_phone'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF ADMISSION ", $admisionDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF DISCHARGE", $dischargeDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $productsHead = array(
            array('label' => __(' Sr.no '), 'filter' => true,'wrap' => true),
            array('label' => __(' ITEM '), 'filter' => true, 'width' => 30, 'wrap' => true),
            array('label' => __(' BHEL NABH Code No. '), 'width' => 15, 'wrap' => true),
            array('label' => __(' BHEL NABH Rate '), 'width' => 15, 'wrap' => true),
            array('label' => __(' Qty '), 'width' => 10, 'wrap' => true),
            array('label' => __(' Amount '), 'width' => 10, 'wrap' => true)
        );
        // add heading with different font and bold text
        $this->PhpExcel->addTableHeader($productsHead, array('name' => 'Cambria', 'bold' => true));

        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A21:F21')->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );

        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        
        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
        ));
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setSize(14);
        $this->PhpExcel->addTableRow(array("Conservative Treatment", "", "", "", ""));
        $this->PhpExcel->getActiveSheet()->mergeCells('A18:B18');
        foreach ($data['conservative'] as $cons) {
            $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));
            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }

        /* $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
      $this->PhpExcel->addTableRow(array($count, " Consultation Charges", "", "", "", ""));
        foreach ($data['conservative'] as $cons) {
            $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));
            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }*/
        $count=$count+1;
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );

        //debug($data);exit;
        // BOF  Consultation For Inpatient
        if ($data['consultantArray']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );                
            
            $this->PhpExcel->addTableRow(array("$count", "Consultation for Inpatients", "2", "", "", ""));
            $count = $count + 1;
            foreach ($data['consultantArray'] as $consultKey => $consultVal) {
                
                $this->PhpExcel->addTableRow(array("", $consultVal['name'], "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $consultVal['from'] . " to " . $consultVal['to'], "", $consultVal['rate'], $consultVal['no_of_times'], $consultVal['amount']));
            }
        }
        // EOF Consultation For Inpatient
        // BOF Accomodation For Ward
        if ($data['wardArray']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, "Accomodation Charges", "", "", "", ""));
            $r = 0;
            foreach ($data['wardArray'] as $wardKey => $wardVal) {
                if ($wardVal['name']) {
                    $this->PhpExcel->addTableRow(array(" ", "Accomodation For " . $wardVal['name'] . " Ward", "", "", "", ""));
                    foreach ($data['conservative'] as $conKey => $conVal) {
                        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                                array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'rotation' => 0,
                                    'wrap' => true
                                )
                        );
                        $wardAmt = $wardVal['amount'] * $conVal['days'];
                        $start = $this->DateFormat->formatDate2Local($conVal['start'], Configure::read('date_format'), false);
                        $end = $this->DateFormat->formatDate2Local($conVal['end'], Configure::read('date_format'), false);
                        $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $wardVal['amount'], $conVal['days'], $wardAmt));
                        $accomodationTotal +=$wardAmt;
                    }
                }
                $r++;
            }

            //if($data['wardIcu'])
            //$count=$count+1; 
            foreach ($data['wardIcu'] as $wardKey => $wardVal) {
                $this->PhpExcel->addTableRow(array(" ", " Accomodation For " . $wardVal['name'], "", "", "", ""));

                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                //	$accomodationTotal += $wardAmt=$wardVal['amount']*$wardVal['days'];
                $start = $this->DateFormat->formatDate2Local($wardVal['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($wardVal['end'], Configure::read('date_format'), false);
                $wardAmt = $wardVal['amount'] * $wardVal['days'];
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $wardVal['amount'], $wardVal['days'], $wardAmt));
                $accomodationTotal +=$wardAmt;
            }
            $count = $count + 1;
            
        }
        // EOF Accomodation For Ward
        if ($data['consCharges']) {
            foreach ($data['consCharges'] as $docNurse) {
                $perDayDoc = 0;
                $perDayNurse = 0;
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array($count, "Doctor Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Doctor']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Doctor']['amount']));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array("", "Nurse Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Nurse']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Nurse']['amount']));
                $count++;
            }
        }

        // BOF Pathology
        if ($data['total']['Laboratory']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Pathology Charges", "", $data['total']['Laboratory'], "1", $data['total']['Laboratory']));
            $count = $count + 1;
            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pathology Break-up", "", "", "", ""));
        }
        // EOF Pathology
        //BOF Medicene
        if ($data['total']['Pharmacy']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Medicine Charges", "", $data['total']['Pharmacy'], "1", $data['total']['Pharmacy']));

            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pharmacy Statement with Bills", "", "", "", ""));
            $count = $count + 1;
        }
        // EOF Medicene
        // BOF Services
        if ($data['serviceArray']) {
            foreach ($data['serviceArray'] as $serClubKey => $serClubVal) {
                foreach ($serClubVal as $keyName => $val) {
                    $resetArray[$serClubKey][$val['tariff_list_id']][] = $val;
                }
            }
            $returnArray = array();
           /* foreach ($resetArray[$serClubKey] as $key => $value) {
                foreach ($value as $retKey => $retVal) {

                    $returnArray[$key]['name'] = $retVal['name'];
                    $returnArray[$key]['rate'] = $retVal['amount'];
                    $returnArray[$key]['no_of_times']+= $retVal['no_of_times'];
                    $returnArray[$key]['amount']+=$retVal['amount'] * $retVal['no_of_times'];
                    $returnArray[$key]['cghs_code'] = $retVal['cghs'];
                }
            }*/
            foreach ($resetArray as $key => $value) {
            	foreach ($value as $retKey => $retVal) {
            		foreach($retVal as $val){
            			$returnArray[$retKey]['name'] = $val['name'];
            			$returnArray[$retKey]['rate'] = $val['amount'];
            			$returnArray[$retKey]['no_of_times']+= $val['no_of_times'];
            			$returnArray[$retKey]['amount']+=$val['amount'] * $val['no_of_times'];
            			$returnArray[$retKey]['cghs_code'] = $val['CGHS'];
            		}
            	}
            }
            foreach ($returnArray as $serviceKey => $serviceVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $serviceTotal = $serviceVal['rate'] * $serviceVal['no_of_times'];
                $this->PhpExcel->addTableRow(array($count, $serviceVal['name'], $serviceVal['cghs_code'], $serviceVal['rate'], $serviceVal['no_of_times'], $serviceTotal));
                $count++;
            }
        }

        //exit;
        // EOF Services
        // BOF Radiology
        if ($data['radArray']) {
            foreach ($data['radArray'] as $radKey => $radVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array($count, $radVal['name'], $radVal['cghs_code'], $radVal['amount'], $radVal['no_of_times'], $radVal['amount'] * $radVal['no_of_times']));
                $count++;
            }
        }
        // EOF Radiology
        // BOF Surgery
        if ($data['surgeryArray']['fromDate']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, " Surgical Treatment( " . $data['surgeryArray']['fromDate'] . " To " . $data['surgeryArray'][to] . ")", "", "", "", ""));

            $serialCharArray = array('a)', 'b)', 'c)', 'd)', 'e)', 'f)', 'g)', 'h)', 'i)');
            $corporateStatus=Configure::Read('corporateStatus');
            foreach ($data['surgeryArray'] as $surKey => $surVal) {
                foreach ($surVal as $skey => $surgeryList) {
                	foreach($surgeryList as $key=>$surgery){
                    if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'general') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'General'
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per BHEL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per BHEL Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] - $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per BHEL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'shared') {
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per BHEL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per BHEL Guideline", $surgery['fiftyPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'special') {
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] + $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 15% more as per BHEL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per BHEL Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] + $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 15% Less as per BHEL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    }
                	}
                	$this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                	$this->PhpExcel->addTableRow(array("", "Operated On dt." . $skey, "", "", "", ""));
                }
                //debug($surgeryTotal);exit;
                $count++;
            }
            
        }
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $row = $this->PhpExcel->_row - 1;
        $totalAmount = "=SUM(F1:F" . $row . ")";
        /* $countRow= $this->PhpExcel->_row+1;
          //debug($countRow); exit; */
        $totalCellBlock = "F" . $countRow;
        $totalTextBlock = "B" . $countRow;
        $totalTextBlock = "C" . $countRow;

        $totalTextBlock = "E" . $countRow;

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        /* $this->PhpExcel->getActiveSheet()->setCellValue($totalTextBlock,"TOTAL BILL AMOUNT" );
          $this->PhpExcel->getActiveSheet()->setCellValue($totalCellBlock,$totalAmount ); */



        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("B" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("F" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->addTableRow(array("", "TOTAL BILL AMOUNT", "", "", "", "$totalAmount"));


        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", " Bill Manager ", " Cashier  ", " Med.Supdt ", " Authorised Signatory "));


        // close table and output
        $this->PhpExcel->addTableFooter()->output('BHEL BILL'); //Store Location List (file name)
    }

    //************ECHS*****************
    public function getECHSExcel($billId = null, $tariffId = null) {

        $this->autoRender = false;
        //$this->uses = array('Patient');
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'CorporateSuperBill', 'Account', 'TariffStandard');

        $this->PhpExcel->createWorksheet()->setDefaultFont('Times New Roman', 12); //to set the font and size
        // Create a first sheet, representing Product data
        $this->PhpExcel->setActiveSheetIndex(0);
        $this->PhpExcel->getActiveSheet()->setTitle('ECHS BILL'); //to set the worksheet title
        //$patientId='1';

        $data = $this->companyExcelReport($billId, $tariffId);
        $admisionDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['form_received_on'], Configure::read('date_format'), false);
        $dischargeDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['discharge_date'], Configure::read('date_format'), false);

        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "BILL", "", "", ""));

        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "", "DATE:-  $dischargeDate", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "BILL NO", $data['billBo'], "", "", ""));
        //$this->PhpExcel->addTableRow(array("","BILL NO",$data['tariffStdData']['CorporateSuperBill']['patiend_bill_no'],"","",""));
        $this->PhpExcel->addTableRow(array("", "REGISTRATION NO:", $data['tariffStdData']['Patient']['admission_id'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NAME OF PATIENT: ", strtoupper($data['tariffStdData']['Patient']['lookup_name']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "AGE", $data['tariffStdData']['Patient']['age'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "SEX", strtoupper($data['tariffStdData']['Patient']['sex']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NAME OF CGHS BENEFICIARY", $data['tariffStdData']['Patient']['name_of_ip'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "RELATION WITH CGHS EMPLOYEE", $data['tariffStdData']['Patient']['relation_to_employee'], "", "", ""));

        $this->PhpExcel->addTableRow(array("", "EMPLOYEE ADDRESS", $data['tariffStdData']['Patient']['address1'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DESIGNATION", $data['tariffStdData']['Patient']['designation'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "CONTACT NO.", $data['tariffStdData']['Patient']['mobile_phone'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DIAGNOSIS", $data['tariffStdData']['Patient']['diagnosis_txt'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF ADMISSION ", $admisionDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF DISCHARGE", $dischargeDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $productsHead = array(
            array('label' => __(' Sr.no '), 'filter' => true),
            //array('label' =>  __('CGHS MOA Sr.No.' )),
            array('label' => __(' ITEM '), 'filter' => true, 'width' => 50, 'wrap' => true),
            array('label' => __(' CGHS NABH CODE No. ')),
            array('label' => __('CGHS NABH RATE ')),
            array('label' => __(' QTY ')),
            array('label' => __(' AMOUNT '))
        );

        // add heading with different font and bold text
        $this->PhpExcel->addTableHeader($productsHead, array('name' => 'Cambria', 'bold' => true));

        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A21:F21')->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );


        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->mergeCells('A18:B18');
        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
        ));

        $this->PhpExcel->addTableRow(array("Conservative Treatment", "", "", "", ""));
        foreach ($data['conservative'] as $cons) {
            $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));

            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }

        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );

        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);

        $this->PhpExcel->addTableRow(array($count, "Consultation Charges", "", "", "", ""));

        //debug($data);exit;
        // BOF  Consultation For Inpatient
        if ($data['consultantArray']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            //$this->PhpExcel->addTableRow(array($count,"Consultation for Inpatient","2","","",""));
            $count = $count + 1;
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
            		array(
            				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            				'rotation' => 0,
            				'wrap' => true
            		)
            );
            $this->PhpExcel->addTableRow(array($count, "Consultation for Inpatients", "2", "", "", ""));
            foreach ($data['consultantArray'] as $consultKey => $consultVal) {
                
                $this->PhpExcel->addTableRow(array("", $consultVal['name'], "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $consultVal['from'] . " to " . $consultVal['to'], "", $consultVal['rate'], $consultVal['no_of_times'], $consultVal['amount']));
            }
        }$count = $count + 1;
        // EOF Consultation For Inpatient
        // BOF Accomodation For Ward
        if ($data['wardArray']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);

            foreach ($data['wardArray'] as $wardKey => $wardVal) {
                if ($wardVal['name']) {
                    $this->PhpExcel->addTableRow(array($count, "Accomodation For " . $data['wardAmt']['wardName'] . " Ward", "", "", "", ""));
                    foreach ($data['conservative'] as $conKey => $conVal) {
                        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                                array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'rotation' => 0,
                                    'wrap' => true
                                )
                        );
                        $wardAmt = $data['wardAmt']['amount'] * $conVal['days'];
                        $start = $this->DateFormat->formatDate2Local($conVal['start'], Configure::read('date_format'), false);
                        $end = $this->DateFormat->formatDate2Local($conVal['end'], Configure::read('date_format'), false);
                        $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $data['wardAmt']['amount'], $conVal['days'], $wardAmt));
                    }
                }
            }
            if ($data['wardIcu']){
                $count = $count + 1;
            //foreach($data['wardIcu'] as $wardKey =>$wardVal){

            $icuWardDays = count($data['wardIcu']);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Accomodation For ICU", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
                    )
            );
            $wardAmt = $data['wardIcu'][0]['amount'] * $icuWardDays;
            $start = $this->DateFormat->formatDate2Local($data['wardIcu'][0]['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($data['wardIcu'][$icuWardDays - 1]['end'], Configure::read('date_format'), false);
            $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $data['wardIcu'][0]['amount'], $icuWardDays, $wardAmt));

            //}
            }
            $count = $count + 1;
        }
        // EOF Accomodation For Ward
        if ($data['consCharges']) {
            foreach ($data['consCharges'] as $docNurse) {
                $perDayDoc = 0;
                $perDayNurse = 0;
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array($count, "Doctor Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Doctor']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Doctor']['amount']));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array($count, "Nurse Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Nurse']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Nurse']['amount']));
                $count++;
            }
        }

        // BOF Pathology
        if ($data['total']['Laboratory']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Pathology Charges", "", $data['total']['Laboratory'], "1", $data['total']['Laboratory']));
            $count = $count + 1;
            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pathology Break-up", "", "", "", ""));
        }
        // EOF Pathology
        //BOF Medicene
        if ($data['total']['Pharmacy']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Medicine Charges", "", $data['total']['Pharmacy'], "1", $data['total']['Pharmacy']));

            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pharmacy Statement with Bills", "", "", "", ""));
            $count = $count + 1;
        }
        // EOF Medicene
        // BOF Services
        if ($data['serviceArray']) {
            foreach ($data['serviceArray'] as $serClubKey => $serClubVal) {
                foreach ($serClubVal as $keyName => $val) {
                    $resetArray[$serClubKey][$val['tariff_list_id']][] = $val;
                }
            }
            $returnArray = array();
            /*foreach ($resetArray[$serClubKey] as $key => $value) {
                foreach ($value as $retKey => $retVal) {

                    $returnArray[$key]['name'] = $retVal['name'];
                    $returnArray[$key]['rate'] = $retVal['amount'];
                    $returnArray[$key]['no_of_times']+= $retVal['no_of_times'];
                    $returnArray[$key]['amount']+=$retVal['amount'] * $retVal['no_of_times'];
                    $returnArray[$key]['cghs_code'] = $retVal['cghs'];
                }
            }*/
            foreach ($resetArray as $key => $value) {
            	foreach ($value as $retKey => $retVal) {
            		foreach($retVal as $val){
            			$returnArray[$retKey]['name'] = $val['name'];
            			$returnArray[$retKey]['rate'] = $val['amount'];
            			$returnArray[$retKey]['no_of_times']+= $val['no_of_times'];
            			$returnArray[$retKey]['amount']+=$val['amount'] * $val['no_of_times'];
            			$returnArray[$retKey]['cghs_code'] = $val['CGHS'];
            		}
            	}
            }
            foreach ($returnArray as $serviceKey => $serviceVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $serviceTotal = $serviceVal['rate'] * $serviceVal['no_of_times'];
                $this->PhpExcel->addTableRow(array($count, $serviceVal['name'], $serviceVal['cghs_code'], $serviceVal['rate'], $serviceVal['no_of_times'], $serviceTotal));
                $count++;
            }
        }

        //exit;
        // EOF Services
        // BOF Radiology
        if ($data['radArray']) {
            foreach ($data['radArray'] as $radKey => $radVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array($count, $radVal['name'], $radVal['cghs_code'], $radVal['amount'], $radVal['no_of_times'], $radVal['amount'] * $radVal['no_of_times']));
                $count++;
            }
        }
        // EOF Radiology
        //debug($data['surgeryArray']);exit;
        // BOF Surgery
        if ($data['surgeryArray']['fromDate']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", " Surgical Treatment( " . $data['surgeryArray']['fromDate'] . " To " . $data['surgeryArray'][to] . ")", "", "", "", ""));
            $serialCharArray = array('a)', 'b)', 'c)', 'd)', 'e)', 'f)', 'g)', 'h)', 'i)');
            $corporateStatus=Configure::read('corporateStatus');
            foreach ($data['surgeryArray'] as $surKey => $surVal) {
                foreach ($surVal as $skey => $surgeryList) {
                		foreach($surgeryList as $key=>$surgery){
                /*$data['superbillData']['CorporateSuperBill']['patient_type']*/
                	
                	$surAmt=$surgery['amount'];
                	$this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                			array(
                					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                					'rotation' => 0,
                					'wrap' => true
                			)
                	);
                	$this->PhpExcel->getActiveSheet()->getStyle("F" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                			array(
                					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                					'rotation' => 0,
                					'wrap' => true
                			)
                	);
                    if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'general') {
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per ECHS Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per ECHS Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] - $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per ECHS Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'shared') {//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'Semi-Special' || $data['superbillData']['CorporateSuperBill']['patient_type'] == 'Semi-Private'
						//For semi private original surgery amt for any no of surgeries -- Pooja 22/03/16                 	
                    	if ($key == 1) {                    		
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "1", $surAmt));
							
                            /*$dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per CGHS Guideline", $surgery['tenPer'], "1", $dedAmt));*/
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "1", $surAmt));
                           /* $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per CGHS Guideline", $surgery['fiftyPer'], "1", $dedAmt));*/
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'special') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'Special' || $data['superbillData']['CorporateSuperBill']['patient_type'] == 'Private'
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "", ""));
                            $dedAmt = $surgery['amount'] + $surgery['15Per'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 15% more as per ECHS Guideline", $surgery['15Per'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surAmt, "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per ECHS Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] + $surgery['15Per'];
                            $this->PhpExcel->addTableRow(array("", "", " 15% More as per ECHS Guideline", $surgery['15Per'], "1", $dedAmt));
                        }
                    }
                    $count++;
                }
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array("", "Operated On dt." . $skey, "", "", "", ""));
              }//eof inner foreach
              
            }//eof outer foreach

			
        }
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $row = $this->PhpExcel->_row - 1;
        $totalAmount = "=SUM(F1:F" . $row . ")";
        /* $countRow= $this->PhpExcel->_row+1;
          //debug($countRow); exit; */
        $totalCellBlock = "F" . $countRow;
        $totalTextBlock = "B" . $countRow;
        $totalTextBlock = "C" . $countRow;

        $totalTextBlock = "E" . $countRow;

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        /* $this->PhpExcel->getActiveSheet()->setCellValue($totalTextBlock,"TOTAL BILL AMOUNT" );
          $this->PhpExcel->getActiveSheet()->setCellValue($totalCellBlock,$totalAmount ); */



        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("B" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("F" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->addTableRow(array("", "TOTAL BILL AMOUNT", "", "", "", "$totalAmount"));



        //$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row+7)->getFont()->setBold(true);
        //$this->PhpExcel->addTableRow(array("","Operated On dt.".$data['surgeryArray']['from'],"","","",""));


        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", " Bill Manager ", " Cashier  ", " Med.Supdt ", " Authorised Signatory "));

		// close table and output
        $this->PhpExcel->addTableFooter()->output('ECHS BILL'); //Store Location List (file name)
    }

    //********************************MahindraMahindraLtdExcel**************
    public function getMMLExcel($billId = null, $tariffId = null) {

        $this->autoRender = false;

        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'CorporateSuperBill', 'Account', 'TariffStandard');

        $this->PhpExcel->createWorksheet()->setDefaultFont('Times New Roman', 12); //to set the font and size
        // Create a first sheet, representing Product data
        $this->PhpExcel->setActiveSheetIndex(0);
        $this->PhpExcel->getActiveSheet()->setTitle('Mahindra & Mahindra Ltd BILL'); //to set the worksheet title
        //$patientId='1';

        $data = $this->companyExcelReport($billId, $tariffId);
        //$data=$this->corporate_super_bill_list($pvtTariffId,$billId,$tariffId);


        $admisionDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['form_received_on'], Configure::read('date_format'), false);
        $dischargeDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['discharge_date'], Configure::read('date_format'), false);

        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "BILL", "", "", ""));

        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A:F')->getAlignment()->applyFromArray(
        		array(
        				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        				'rotation' => 0,
        				'wrap' => true
        		)
        );
        $this->PhpExcel->addTableRow(array("", "", "", "DATE:-  $dischargeDate", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "BILL NO", $data['billBo'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "REGISTRATION NO", $data['tariffStdData']['Patient']['admission_id'], "", "", ""));

        $this->PhpExcel->addTableRow(array("", "NAME OF PATIENT ", strtoupper($data['tariffStdData']['Patient']['lookup_name']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "AGE", $data['tariffStdData']['Patient']['age'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "SEX", strtoupper($data['tariffStdData']['Patient']['sex']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NAME OF MAHINDRA AND MAHINDRA Ltd BENEFICIARY", $data['tariffStdData']['Patient']['name_of_ip'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "RELATION WITH MAHINDRA AND MAHINDRA Ltd EMPLOYEE", $data['tariffStdData']['Patient']['relation_to_employee'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "EMPLOYEE ADDRESS", $data['tariffStdData']['Patient']['address1'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DESIGNATION", $data['tariffStdData']['Patient']['designation'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DIAGNOSIS", $data['tariffStdData']['Patient']['diagnosis_txt'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "CONTACT NO.", $data['tariffStdData']['Patient']['mobile_phone'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF ADMISSION ", $admisionDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF DISCHARGE", $dischargeDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $productsHead = array(
            array('label' => __(' Sr.no '), 'filter' => true,'wrap' => true),
            array('label' => __(' ITEM '), 'filter' => true, 'width' => 30, 'wrap' => true),
            array('label' => __(' MML NABH Code No. '), 'width' => 15, 'wrap' => true),
            array('label' => __(' MML NABH Rate '), 'width' => 15, 'wrap' => true),
            array('label' => __(' Qty '), 'width' => 10, 'wrap' => true),
            array('label' => __(' Amount '), 'width' => 10, 'wrap' => true)
        );
        // add heading with different font and bold text
        $this->PhpExcel->addTableHeader($productsHead, array('name' => 'Cambria', 'bold' => true));

        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A21:F21')->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );

        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        
        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
        ));
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setSize(14);
        $this->PhpExcel->addTableRow(array("Conservative Treatment", "", "", "", ""));
        $this->PhpExcel->getActiveSheet()->mergeCells('A18:B18');
        foreach ($data['conservative'] as $cons) {
            $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));
            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }

        /* $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
      $this->PhpExcel->addTableRow(array($count, " Consultation Charges", "", "", "", ""));
        foreach ($data['conservative'] as $cons) {
            $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));
            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }*/
        $count=$count+1;
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );

        //debug($data);exit;
        // BOF  Consultation For Inpatient
        if ($data['consultantArray']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );                
            
            $this->PhpExcel->addTableRow(array("$count", "Consultation for Inpatients", "2", "", "", ""));
            $count = $count + 1;
            foreach ($data['consultantArray'] as $consultKey => $consultVal) {
                
                $this->PhpExcel->addTableRow(array("", $consultVal['name'], "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $consultVal['from'] . " to " . $consultVal['to'], "", $consultVal['rate'], $consultVal['no_of_times'], $consultVal['amount']));
            }
        }
        // EOF Consultation For Inpatient
        // BOF Accomodation For Ward
        if ($data['wardArray']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, "Accomodation Charges", "", "", "", ""));
            $r = 0;
            foreach ($data['wardArray'] as $wardKey => $wardVal) {
                if ($wardVal['name']) {
                    $this->PhpExcel->addTableRow(array(" ", "Accomodation For " . $wardVal['name'] . " Ward", "", "", "", ""));
                    foreach ($data['conservative'] as $conKey => $conVal) {
                        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                                array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'rotation' => 0,
                                    'wrap' => true
                                )
                        );
                        $wardAmt = $wardVal['amount'] * $conVal['days'];
                        $start = $this->DateFormat->formatDate2Local($conVal['start'], Configure::read('date_format'), false);
                        $end = $this->DateFormat->formatDate2Local($conVal['end'], Configure::read('date_format'), false);
                        $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $wardVal['amount'], $conVal['days'], $wardAmt));
                        $accomodationTotal +=$wardAmt;
                    }
                }
                $r++;
            }

            //if($data['wardIcu'])
            //$count=$count+1; 
            foreach ($data['wardIcu'] as $wardKey => $wardVal) {
                $this->PhpExcel->addTableRow(array(" ", " Accomodation For " . $wardVal['name'], "", "", "", ""));

                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                //	$accomodationTotal += $wardAmt=$wardVal['amount']*$wardVal['days'];
                $start = $this->DateFormat->formatDate2Local($wardVal['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($wardVal['end'], Configure::read('date_format'), false);
                $wardAmt = $wardVal['amount'] * $wardVal['days'];
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $wardVal['amount'], $wardVal['days'], $wardAmt));
                $accomodationTotal +=$wardAmt;
            }
            $count = $count + 1;
            
        }
        // EOF Accomodation For Ward
        if ($data['consCharges']) {
            foreach ($data['consCharges'] as $docNurse) {
                $perDayDoc = 0;
                $perDayNurse = 0;
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array($count, "Doctor Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Doctor']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Doctor']['amount']));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array("", "Nurse Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Nurse']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Nurse']['amount']));
                $count++;
            }
        }

        // BOF Pathology
        if ($data['total']['Laboratory']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Pathology Charges", "", $data['total']['Laboratory'], "1", $data['total']['Laboratory']));
            $count = $count + 1;
            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pathology Break-up", "", "", "", ""));
        }
        // EOF Pathology
        //BOF Medicene
        if ($data['total']['Pharmacy']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Medicine Charges", "", $data['total']['Pharmacy'], "1", $data['total']['Pharmacy']));

            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pharmacy Statement with Bills", "", "", "", ""));
            $count = $count + 1;
        }
        // EOF Medicene
        // BOF Services
        if ($data['serviceArray']) {
            foreach ($data['serviceArray'] as $serClubKey => $serClubVal) {
                foreach ($serClubVal as $keyName => $val) {
                    $resetArray[$serClubKey][$val['tariff_list_id']][] = $val;
                }
            }
            $returnArray = array();
           /* foreach ($resetArray[$serClubKey] as $key => $value) {
                foreach ($value as $retKey => $retVal) {

                    $returnArray[$key]['name'] = $retVal['name'];
                    $returnArray[$key]['rate'] = $retVal['amount'];
                    $returnArray[$key]['no_of_times']+= $retVal['no_of_times'];
                    $returnArray[$key]['amount']+=$retVal['amount'] * $retVal['no_of_times'];
                    $returnArray[$key]['cghs_code'] = $retVal['cghs'];
                }
            }*/
            foreach ($resetArray as $key => $value) {
            	foreach ($value as $retKey => $retVal) {
            		foreach($retVal as $val){
            			$returnArray[$retKey]['name'] = $val['name'];
            			$returnArray[$retKey]['rate'] = $val['amount'];
            			$returnArray[$retKey]['no_of_times']+= $val['no_of_times'];
            			$returnArray[$retKey]['amount']+=$val['amount'] * $val['no_of_times'];
            			$returnArray[$retKey]['cghs_code'] = $val['CGHS'];
            		}
            	}
            }
            foreach ($returnArray as $serviceKey => $serviceVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $serviceTotal = $serviceVal['rate'] * $serviceVal['no_of_times'];
                $this->PhpExcel->addTableRow(array($count, $serviceVal['name'], $serviceVal['cghs_code'], $serviceVal['rate'], $serviceVal['no_of_times'], $serviceTotal));
                $count++;
            }
        }

        //exit;
        // EOF Services
        // BOF Radiology
        if ($data['radArray']) {
            foreach ($data['radArray'] as $radKey => $radVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array($count, $radVal['name'], $radVal['cghs_code'], $radVal['amount'], $radVal['no_of_times'], $radVal['amount'] * $radVal['no_of_times']));
                $count++;
            }
        }
        // EOF Radiology
        // BOF Surgery
        if ($data['surgeryArray']['fromDate']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, " Surgical Treatment( " . $data['surgeryArray']['fromDate'] . " To " . $data['surgeryArray'][to] . ")", "", "", "", ""));

            $serialCharArray = array('a)', 'b)', 'c)', 'd)', 'e)', 'f)', 'g)', 'h)', 'i)');
            $corporateStatus=Configure::Read('corporateStatus');
            foreach ($data['surgeryArray'] as $surKey => $surVal) {
                foreach ($surVal as $skey => $surgeryList) {
                	foreach($surgeryList as $key=>$surgery){
                    if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'general') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'General'
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per ECHS Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per ECHS Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] - $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per RBI Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'shared') {
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per ECHS Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per ECHS Guideline", $surgery['fiftyPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'special') {
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] + $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 15% more as per ECHS Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per ECHS Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] + $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 15% Less as per RBI Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    }
                	}
                	$this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                	$this->PhpExcel->addTableRow(array("", "Operated On dt." . $skey, "", "", "", ""));
                }
                //debug($surgeryTotal);exit;
                $count++;
            }
            
        }
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $row = $this->PhpExcel->_row - 1;
        $totalAmount = "=SUM(F1:F" . $row . ")";
        /* $countRow= $this->PhpExcel->_row+1;
          //debug($countRow); exit; */
        $totalCellBlock = "F" . $countRow;
        $totalTextBlock = "B" . $countRow;
        $totalTextBlock = "C" . $countRow;

        $totalTextBlock = "E" . $countRow;

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        /* $this->PhpExcel->getActiveSheet()->setCellValue($totalTextBlock,"TOTAL BILL AMOUNT" );
          $this->PhpExcel->getActiveSheet()->setCellValue($totalCellBlock,$totalAmount ); */



        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("B" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("F" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->addTableRow(array("", "TOTAL BILL AMOUNT", "", "", "", "$totalAmount"));


        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", " Bill Manager ", " Cashier  ", " Med.Supdt ", " Authorised Signatory "));


        // close table and output
        $this->PhpExcel->addTableFooter()->output('MML BILL'); //Store Location List (file name)
    }

    //****************************R.G.J.A.Y**************
    public function getRGJAYExcel($billId = null, $tariffId = null) {

        $this->autoRender = false;
        //$this->uses = array('Patient');
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'CorporateSuperBill', 'Account', 'TariffStandard');

        $this->PhpExcel->createWorksheet()->setDefaultFont('Times New Roman', 12); //to set the font and size
        // Create a first sheet, representing Product data
        $this->PhpExcel->setActiveSheetIndex(0);
        $this->PhpExcel->getActiveSheet()->setTitle('R.G.J.A.Y BILL'); //to set the worksheet title
        //$patientId='1';
        $data = $this->companyExcelReport($billId, $tariffId);
        //debug($data);exit;

        $admisionDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['form_received_on'], Configure::read('date_format'), false);
        $dischargeDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['discharge_date'], Configure::read('date_format'), false);
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "R.G.J.A.Y BILL", "", "", ""));
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "", "DATE:-  $dischargeDate", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "BILL NO", $data['billBo'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "REGISTRATION NO", $data['tariffStdData']['Patient']['admission_id'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "PATIENT NAME", strtoupper($data['tariffStdData']['Patient']['lookup_name']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "AGE", $data['tariffStdData']['Patient']['age'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "SEX", strtoupper($data['tariffStdData']['Patient']['sex']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NAME OF R.G.J.A.Y BENEFICIARY", $data['tariffStdData']['Patient']['name_of_ip'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "RELATION WITH R.G.J.A.Y BENEFICIARY", $data['tariffStdData']['Patient']['relation_to_employee'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "EMPLOYEE ADDRESS", $data['tariffStdData']['Patient']['address1'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "CONTACT NO.", $data['tariffStdData']['Patient']['mobile_phone'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DESIGNATION", $data['tariffStdData']['Patient']['designation'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DIAGNOSIS", $data['tariffStdData']['Patient']['diagnosis_txt'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF ADMISSION", $admisionDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF DISCHARGE", $dischargeDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        // define table cells
        $productsHead = array(
            array('label' => __('Sr.no'), 'filter' => true),
            array('label' => __('ITEM'), 'filter' => true, 'width' => 50, 'wrap' => true),
            array('label' => __('R.G.J.A.Y NABH CODE No.')),
            array('label' => __('R.G.J.A.Y NABH RATE')),
            array('label' => __('QTY')),
            array('label' => __('AMOUNT'))
        );

        // add heading with different font and bold text
        $this->PhpExcel->addTableHeader($productsHead, array('name' => 'Cambria', 'bold' => true));

        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A21:F21')->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );

        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->mergeCells('A18:B18');
        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
        ));
        $this->PhpExcel->addTableRow(array("Conservative Treatment", "", "", "", ""));
        foreach ($data['conservative'] as $cons) {
            $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));
            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }

        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );
        $count = 1; //debug($data);exit;
        // BOF  Consultation For Inpatient
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", " Consultation Charges", "", "", "", ""));

        if ($data['consultantArray']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            //$this->PhpExcel->addTableRow(array($count,"Consultation for Inpatient","2","","",""));
            $count = $count + 1;
            foreach ($data['consultantArray'] as $consultKey => $consultVal) {
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Consultation for inpatients", "2", "", "", ""));
                $this->PhpExcel->addTableRow(array("", $consultVal['name'], "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $consultVal['from'] . " to " . $consultVal['to'], "", $consultVal['rate'], $consultVal['no_of_times'], $consultVal['amount']));
            }
        }
        // EOF Consultation For Inpatient
        // BOF Accomodation For Wardl
        if ($data['wardArray']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);

            foreach ($data['wardArray'] as $wardKey => $wardVal) {

                if ($wardVal['name']) {
                    $this->PhpExcel->addTableRow(array($count, "Accomodation For " . $data['wardAmt']['wardName'] . " Ward", "", "", "", ""));

                    foreach ($data['conservative'] as $conKey => $conVal) {
                        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                                array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'rotation' => 0,
                                    'wrap' => true
                                )
                        );
                        $wardAmt = $data['wardAmt']['amount'] * $conVal['days'];
                        $start = $this->DateFormat->formatDate2Local($conVal['start'], Configure::read('date_format'), false);
                        $end = $this->DateFormat->formatDate2Local($conVal['end'], Configure::read('date_format'), false);
                        $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $data['wardAmt']['amount'], $conVal['days'], $wardAmt));
                    }
                }
            }
            if ($data['wardIcu'])
                $count = $count + 1;
            foreach ($data['wardIcu'] as $wardKey => $wardVal) {
                $this->PhpExcel->addTableRow(array($count, "Accomodation For " . $wardVal['name'], "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $wardAmt = $wardVal['amount'] * $wardVal['days'];
                $start = $this->DateFormat->formatDate2Local($wardVal['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($wardVal['end'], Configure::read('date_format'), false);
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $wardVal['amount'], $wardVal['days'], $wardAmt));
            }
            $count = $count + 1;
        }
        // EOF Accomodation For Ward
        if ($data['consCharges']) {
            foreach ($data['consCharges'] as $docNurse) {
                $perDayDoc = 0;
                $perDayNurse = 0;
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array($count, "Doctor Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Doctor']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Doctor']['amount']));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array("", "Nurse Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Nurse']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Nurse']['amount']));
                $count++;
            }
        }

        // BOF Pathology
        if ($data['total']['Laboratory']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Pathology Charges", "", $data['total']['Laboratory'], "1", $data['total']['Laboratory']));
            $count = $count + 1;
            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pathology Break-up", "", "", "", ""));
        }
        // EOF Pathology
        //BOF Medicene
        if ($data['total']['Pharmacy']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Medicine Charges", "", $data['total']['Pharmacy'], "1", $data['total']['Pharmacy']));

            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pharmacy Statement with Bills", "", "", "", ""));
            $count = $count + 1;
        }
        // EOF Medicene
        // BOF Services
        if ($data['serviceArray']) {
            //debug($data['serviceArray']);exit;
            foreach ($data['serviceArray'] as $serClubKey => $serClubVal) {
                foreach ($serClubVal as $keyName => $val) {
                    $resetArray[$serClubKey][$val['tariff_list_id']][] = $val;
                }
            }
            $returnArray = array();
           /* foreach ($resetArray[$serClubKey] as $key => $value) {
                foreach ($value as $retKey => $retVal) {

                    $returnArray[$key]['name'] = $retVal['name'];
                    $returnArray[$key]['rate'] = $retVal['amount'];
                    $returnArray[$key]['no_of_times']+= $retVal['no_of_times'];
                    $returnArray[$key]['amount']+=$retVal['amount'] * $retVal['no_of_times'];
                    $returnArray[$key]['echs_code'] = $retVal['ECHS'];
                }
            } */
            foreach ($resetArray as $key => $value) {
            	foreach ($value as $retKey => $retVal) {
            		foreach($retVal as $val){
            			$returnArray[$retKey]['name'] = $val['name'];
            			$returnArray[$retKey]['rate'] = $val['amount'];
            			$returnArray[$retKey]['no_of_times']+= $val['no_of_times'];
            			$returnArray[$retKey]['amount']+=$val['amount'] * $val['no_of_times'];
            			$returnArray[$retKey]['cghs_code'] = $val['CGHS'];
            		}
            	}
            }
            foreach ($returnArray as $serviceKey => $serviceVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $serviceTotal = $serviceVal['rate'] * $serviceVal['no_of_times'];
                $this->PhpExcel->addTableRow(array($count, $serviceVal['name'], $serviceVal['cghs_code'], $serviceVal['rate'], $serviceVal['no_of_times'], $serviceTotal));
                $count++;
            }
        }

        //exit;
        // EOF Services
        // BOF Radiology
        if ($data['radArray']) {
            //debug($data['radArray']);exit;
            foreach ($data['radArray'] as $radKey => $radVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array($count, $radVal['name'], $radVal['rgjay_code'], $radVal['amount'], $radVal['no_of_times'], $radVal['amount'] * $radVal['no_of_times']));

                $count++;
            }
        }
        // EOF Radiology
        // BOF Surgery
        if ($data['surgeryArray']['from']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, " Surgical Treatment( " . $data['surgeryArray']['from'] . " To " . $data['surgeryArray'][to] . ")", "", "", "", ""));

            $serialCharArray = array('a)', 'b)', 'c)', 'd)', 'e)', 'f)', 'g)', 'h)', 'i)');
            $corporateStatus=Configure::read('corporateStatus');
            foreach ($data['surgeryArray'] as $surKey => $surVal) {
                foreach ($surVal as $key => $surgery) {
                    if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'general') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'General'
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['rgjay'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per R.G.J.A.Y Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['rgjay'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per R.G.J.A.Y Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] - $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per R.G.J.A.Y Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'shared') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'Semi-Special' || $data['superbillData']['CorporateSuperBill']['patient_type'] == 'Semi-Private'
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['rgjay'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per R.G.J.A.Y Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['rgjay'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per R.G.J.A.Y Guideline", $surgery['fiftyPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'special') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'Special' || $data['superbillData']['CorporateSuperBill']['patient_type'] == 'Private'

                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['rgjay'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] + $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 15% more as per R.G.J.A.Y Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['rgjay'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per R.G.J.A.Y Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] + $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 15% Less as per R.G.J.A.Y Guideline", $surgery['tenPer'], "1", $dedAmt));
                            //debug($dedAmt);exit;
                        }
                    }/* else  //for private
                      {
                      $this->PhpExcel->addTableRow(array("",$serialCharArray[$key-1]." ".$surgery['name'],$surgery['echs'],$surgery['amount'],"",""));
                      $this->PhpExcel->getActiveSheet()->getStyle("C".$this->PhpExcel->_row)->getFont()->setBold(true);
                      $dedAmt=$surgery['amount'];
                      $this->PhpExcel->addTableRow(array("","","","","1",$dedAmt));
                      } */
                }


                $count++;
            }

            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Operated On dt." . $data['surgeryArray']['from'], "", "", "", ""));
        }
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $row = $this->PhpExcel->_row - 1;
        $totalAmount = "=SUM(F1:F" . $row . ")";
        /* $countRow= $this->PhpExcel->_row+1;
          //debug($countRow); exit; */
        $totalCellBlock = "F" . $countRow;
        $totalTextBlock = "B" . $countRow;
        $totalTextBlock = "C" . $countRow;

        $totalTextBlock = "E" . $countRow;

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        /* $this->PhpExcel->getActiveSheet()->setCellValue($totalTextBlock,"TOTAL BILL AMOUNT" );
          $this->PhpExcel->getActiveSheet()->setCellValue($totalCellBlock,$totalAmount ); */



        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("B" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("F" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->addTableRow(array("", "TOTAL BILL AMOUNT", "", "", "", "$totalAmount"));



        //$this->PhpExcel->getActiveSheet()->getStyle("B".$this->PhpExcel->_row+7)->getFont()->setBold(true);
        //$this->PhpExcel->addTableRow(array("","Operated On dt.".$data['surgeryArray']['from'],"","","",""));


        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", " Bill Manager ", " Cashier  ", " Med.Supdt ", " Authorised Signatory "));


        // close table and output
        $this->PhpExcel->addTableFooter()->output('R.G.J.A.Y BILL');
    }

    //Store Location List (file name)
    //**********************BSNL*************************
    public function getBSNLExcel($billId = null, $tariffId = null) {

        $this->autoRender = false;

        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'CorporateSuperBill', 'Account', 'TariffStandard');

        $this->PhpExcel->createWorksheet()->setDefaultFont('Times New Roman', 12); //to set the font and size
        // Create a first sheet, representing Product data
        $this->PhpExcel->setActiveSheetIndex(0);
        $this->PhpExcel->getActiveSheet()->setTitle('BSNL BILL'); //to set the worksheet title
        //$patientId='1';

        $data = $this->companyExcelReport($billId, $tariffId);
        //$data=$this->corporate_super_bill_list($pvtTariffId,$billId,$tariffId);


        $admisionDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['form_received_on'], Configure::read('date_format'), false);
        $dischargeDate = $this->DateFormat->formatDate2Local($data['tariffStdData']['Patient']['discharge_date'], Configure::read('date_format'), false);

        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", "BILL", "", "", ""));

        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A:F')->getAlignment()->applyFromArray(
        		array(
        				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        				'rotation' => 0,
        				'wrap' => true
        		)
        );
        $this->PhpExcel->addTableRow(array("", "", "", "DATE:-  $dischargeDate", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "BILL NO", $data['billBo'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "REGISTRATION NO", $data['tariffStdData']['Patient']['admission_id'], "", "", ""));

        $this->PhpExcel->addTableRow(array("", "NAME OF PATIENT ", strtoupper($data['tariffStdData']['Patient']['lookup_name']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "AGE", $data['tariffStdData']['Patient']['age'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "SEX", strtoupper($data['tariffStdData']['Patient']['sex']), "", "", ""));
        $this->PhpExcel->addTableRow(array("", "NAME OF BSNL BENEFICIARY", $data['tariffStdData']['Patient']['name_of_ip'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "RELATION WITH BSNL EMPLOYEE", $data['tariffStdData']['Patient']['relation_to_employee'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "EMPLOYEE ADDRESS", $data['tariffStdData']['Patient']['address1'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DESIGNATION", $data['tariffStdData']['Patient']['designation'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DIAGNOSIS", $data['tariffStdData']['Patient']['diagnosis_txt'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "CONTACT NO.", $data['tariffStdData']['Patient']['mobile_phone'], "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF ADMISSION ", $admisionDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "DATE OF DISCHARGE", $dischargeDate, "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $productsHead = array(
            array('label' => __(' Sr.no '), 'filter' => true,'wrap' => true),
            array('label' => __(' ITEM '), 'filter' => true, 'width' => 30, 'wrap' => true),
            array('label' => __(' BSNL NABH Code No. '), 'width' => 15, 'wrap' => true),
            array('label' => __(' BSNL NABH Rate '), 'width' => 15, 'wrap' => true),
            array('label' => __(' Qty '), 'width' => 10, 'wrap' => true),
            array('label' => __(' Amount '), 'width' => 10, 'wrap' => true)
        );
        // add heading with different font and bold text
        $this->PhpExcel->addTableHeader($productsHead, array('name' => 'Cambria', 'bold' => true));

        // for align header text center
        $this->PhpExcel->getActiveSheet()->getStyle('A21:F21')->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );

        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        
        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
        ));
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setSize(14);
        $this->PhpExcel->addTableRow(array("Conservative Treatment", "", "", "", ""));
        $this->PhpExcel->getActiveSheet()->mergeCells('A18:B18');
        foreach ($data['conservative'] as $cons) {
            $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));
            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }

        /* $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );
        $this->PhpExcel->getActiveSheet()->getStyle("A" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
      $this->PhpExcel->addTableRow(array($count, " Consultation Charges", "", "", "", ""));
        foreach ($data['conservative'] as $cons) {
            $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
            $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
            $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                    array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'rotation' => 0,
                        'wrap' => true
            ));
            $this->PhpExcel->addTableRow(array("", "(" . $start . " To " . $end . " )", "", "", "", ""));
        }*/
        $count=$count+1;
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'rotation' => 0,
                    'wrap' => true
                )
        );

        //debug($data);exit;
        // BOF  Consultation For Inpatient
        if ($data['consultantArray']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );                
            
            $this->PhpExcel->addTableRow(array("$count", "Consultation for Inpatients", "2", "", "", ""));
            $count = $count + 1;
            foreach ($data['consultantArray'] as $consultKey => $consultVal) {
                
                $this->PhpExcel->addTableRow(array("", $consultVal['name'], "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $consultVal['from'] . " to " . $consultVal['to'], "", $consultVal['rate'], $consultVal['no_of_times'], $consultVal['amount']));
            }
        }
        // EOF Consultation For Inpatient
        // BOF Accomodation For Ward
        if ($data['wardArray']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, "Accomodation Charges", "", "", "", ""));
            $r = 0;
            foreach ($data['wardArray'] as $wardKey => $wardVal) {
                if ($wardVal['name']) {
                    $this->PhpExcel->addTableRow(array(" ", "Accomodation For " . $wardVal['name'] . " Ward", "", "", "", ""));
                    foreach ($data['conservative'] as $conKey => $conVal) {
                        $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                                array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                    'rotation' => 0,
                                    'wrap' => true
                                )
                        );
                        $wardAmt = $wardVal['amount'] * $conVal['days'];
                        $start = $this->DateFormat->formatDate2Local($conVal['start'], Configure::read('date_format'), false);
                        $end = $this->DateFormat->formatDate2Local($conVal['end'], Configure::read('date_format'), false);
                        $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $wardVal['amount'], $conVal['days'], $wardAmt));
                        $accomodationTotal +=$wardAmt;
                    }
                }
                $r++;
            }

            //if($data['wardIcu'])
            //$count=$count+1; 
            foreach ($data['wardIcu'] as $wardKey => $wardVal) {
                $this->PhpExcel->addTableRow(array(" ", " Accomodation For " . $wardVal['name'], "", "", "", ""));

                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                //	$accomodationTotal += $wardAmt=$wardVal['amount']*$wardVal['days'];
                $start = $this->DateFormat->formatDate2Local($wardVal['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($wardVal['end'], Configure::read('date_format'), false);
                $wardAmt = $wardVal['amount'] * $wardVal['days'];
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " to " . $end, "", $wardVal['amount'], $wardVal['days'], $wardAmt));
                $accomodationTotal +=$wardAmt;
            }
            $count = $count + 1;
            
        }
        // EOF Accomodation For Ward
        if ($data['consCharges']) {
            foreach ($data['consCharges'] as $docNurse) {
                $perDayDoc = 0;
                $perDayNurse = 0;
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array($count, "Doctor Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Doctor']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Doctor']['amount']));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->addTableRow(array("", "Nurse Charges", "", "", "", ""));
                $perDayDoc = $docNurse['Nurse']['amount'] / $docNurse['days'];
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array("", "Dt " . $docNurse['start'] . " to " . $docNurse['end'], "", $perDayDoc, $docNurse['days'], $docNurse['Nurse']['amount']));
                $count++;
            }
        }

        // BOF Pathology
        if ($data['total']['Laboratory']) {
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Pathology Charges", "", $data['total']['Laboratory'], "1", $data['total']['Laboratory']));
            $count = $count + 1;
            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pathology Break-up", "", "", "", ""));
        }
        // EOF Pathology
        //BOF Medicene
        if ($data['total']['Pharmacy']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array($count, "Medicine Charges", "", $data['total']['Pharmacy'], "1", $data['total']['Pharmacy']));

            foreach ($data['conservative'] as $cons) {
                $start = $this->DateFormat->formatDate2Local($cons['start'], Configure::read('date_format'), false);
                $end = $this->DateFormat->formatDate2Local($cons['end'], Configure::read('date_format'), false);
                $this->PhpExcel->getActiveSheet()->getStyle('B' . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                ));
                $this->PhpExcel->addTableRow(array("", "Dt " . $start . " To " . $end, "", "", "", ""));
            }
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->addTableRow(array("", "Note:Attached Pharmacy Statement with Bills", "", "", "", ""));
            $count = $count + 1;
        }
        // EOF Medicene
        // BOF Services
        if ($data['serviceArray']) {
            foreach ($data['serviceArray'] as $serClubKey => $serClubVal) {
                foreach ($serClubVal as $keyName => $val) {
                    $resetArray[$serClubKey][$val['tariff_list_id']][] = $val;
                }
            }
            $returnArray = array();
            /*foreach ($resetArray[$serClubKey] as $key => $value) {
                foreach ($value as $retKey => $retVal) {

                    $returnArray[$key]['name'] = $retVal['name'];
                    $returnArray[$key]['rate'] = $retVal['amount'];
                    $returnArray[$key]['no_of_times']+= $retVal['no_of_times'];
                    $returnArray[$key]['amount']+=$retVal['amount'] * $retVal['no_of_times'];
                    $returnArray[$key]['cghs_code'] = $retVal['cghs'];
                }
            }*/
            foreach ($resetArray as $key => $value) {
            	foreach ($value as $retKey => $retVal) {
            		foreach($retVal as $val){
            			$returnArray[$retKey]['name'] = $val['name'];
            			$returnArray[$retKey]['rate'] = $val['amount'];
            			$returnArray[$retKey]['no_of_times']+= $val['no_of_times'];
            			$returnArray[$retKey]['amount']+=$val['amount'] * $val['no_of_times'];
            			$returnArray[$retKey]['cghs_code'] = $val['CGHS'];
            		}
            	}
            }
            foreach ($returnArray as $serviceKey => $serviceVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $serviceTotal = $serviceVal['rate'] * $serviceVal['no_of_times'];
                $this->PhpExcel->addTableRow(array($count, $serviceVal['name'], $serviceVal['cghs_code'], $serviceVal['rate'], $serviceVal['no_of_times'], $serviceTotal));
                $count++;
            }
        }

        //exit;
        // EOF Services
        // BOF Radiology
        if ($data['radArray']) {
            foreach ($data['radArray'] as $radKey => $radVal) {
                $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
                $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                            'rotation' => 0,
                            'wrap' => true
                        )
                );
                $this->PhpExcel->addTableRow(array($count, $radVal['name'], $radVal['cghs_code'], $radVal['amount'], $radVal['no_of_times'], $radVal['amount'] * $radVal['no_of_times']));
                $count++;
            }
        }
        // EOF Radiology
        // BOF Surgery
        if ($data['surgeryArray']['fromDate']) {
            $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
            $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setSize(14);
            $this->PhpExcel->addTableRow(array($count, " Surgical Treatment( " . $data['surgeryArray']['fromDate'] . " To " . $data['surgeryArray'][to] . ")", "", "", "", ""));

            $serialCharArray = array('a)', 'b)', 'c)', 'd)', 'e)', 'f)', 'g)', 'h)', 'i)');
            $corporateStatus=Configure::Read('corporateStatus');
            foreach ($data['surgeryArray'] as $surKey => $surVal) {
                foreach ($surVal as $skey => $surgeryList) {
                	foreach($surgeryList as $key=>$surgery){
                    if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'general') {
                    	//$data['superbillData']['CorporateSuperBill']['patient_type'] == 'General'
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per BSNL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per BSNL Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] - $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per BSNL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'shared') {
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] - $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 10% Less as per BSNL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per BSNL Guideline", $surgery['fiftyPer'], "1", $dedAmt));
                        }
                    } else if (strtolower($corporateStatus[$data['tariffStdData']['Patient']['corporate_status']]) == 'special') {
                        if ($key == 1) {
                            $this->PhpExcel->addTableRow(array($count, $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $dedAmt = $surgery['amount'] + $surgery['tenPer'];
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 15% more as per BSNL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        } else {
                            $this->PhpExcel->addTableRow(array("", $serialCharArray[$key - 1] . " " . $surgery['name'], $surgery['cghs'], $surgery['amount'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $this->PhpExcel->addTableRow(array("", "", " 50% Less as per BSNL Guideline", $surgery['fiftyPer'], "", ""));
                            $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
                            $dedAmt = $surgery['amount'] - $surgery['fiftyPer'] + $surgery['tenPer'];
                            $this->PhpExcel->addTableRow(array("", "", " 15% Less as per BSNL Guideline", $surgery['tenPer'], "1", $dedAmt));
                        }
                    }
                	}
                	$this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
                	$this->PhpExcel->addTableRow(array("", "Operated On dt." . $skey, "", "", "", ""));
                }
                //debug($surgeryTotal);exit;
                $count++;
            }
            
        }
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $row = $this->PhpExcel->_row - 1;
        $totalAmount = "=SUM(F1:F" . $row . ")";
        /* $countRow= $this->PhpExcel->_row+1;
          //debug($countRow); exit; */
        $totalCellBlock = "F" . $countRow;
        $totalTextBlock = "B" . $countRow;
        $totalTextBlock = "C" . $countRow;

        $totalTextBlock = "E" . $countRow;

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("B" . $this->PhpExcel->_row)->getFont()->setBold(true);
        /* $this->PhpExcel->getActiveSheet()->setCellValue($totalTextBlock,"TOTAL BILL AMOUNT" );
          $this->PhpExcel->getActiveSheet()->setCellValue($totalCellBlock,$totalAmount ); */



        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("B" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle()->getFont("F" . $this->PhpExcel->_row)->setBold(true);
        $this->PhpExcel->addTableRow(array("", "TOTAL BILL AMOUNT", "", "", "", "$totalAmount"));


        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));
        $this->PhpExcel->addTableRow(array("", "", "", "", "", ""));

        $this->PhpExcel->getActiveSheet()->getStyle($totalCellBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle($totalTextBlock)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("C" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->getActiveSheet()->getStyle("D" . $this->PhpExcel->_row)->getFont()->setBold(true);
        $this->PhpExcel->addTableRow(array("", "", " Bill Manager ", " Cashier  ", " Med.Supdt ", " Authorised Signatory "));


        // close table and output
        $this->PhpExcel->addTableFooter()->output('BSNL BILL'); //Store Location List (file name)
    }

    //************companyExcelReport**************************************		
    public function companyExcelReport($patientId = NULL, $corporate = NULL) {
    	 //$this->autoRender = false;
        //$this->uses=array('ServiceCategory','Patient','Billing','User');
        $this->uses = array('Patient', 'Billing', 'User', 'ServiceBill', 'LaboratoryTestOrder', 'RadiologyTestOrder', 'WardPatientService', 'ConsultantBilling',
            'CorporateSuperBill', 'Patient', 'ServiceCategory', 'Account', 'PharmacySalesBill', 'OtPharmacySalesBill', 'InventoryPharmacySalesReturn',
            'OtPharmacySalesReturn', 'CorporateSuperBillList', 'PatientCard', 'WardPatient', 'Person', 'FinalBilling', 'OptAppointment');
        $corporateStatus=Configure::Read('corporateStatus');
        if (!empty($patientId)) {
        	/*$this->CorporateSuperBill->bindModel(array(
        			'belongsTo'=>array(
        					'Patient'=>array('type'=>'Inner','foreignKey'=>'patient_id'))));*/
           /* $superbillData = $this->CorporateSuperBill->find('first', array(
            		'fields'=>array(/*'Patient.corporate_status',*//*'CorporateSuperBill.*'),
            		/*'conditions' => array('CorporateSuperBill.id' => $superBillId)));
            $patientIds = explode('|', $superbillData['CorporateSuperBill']['patient_id']);*/
        	$PatientData=$this->Patient->find('first',array('conditions'=>array('id'=>$patientId)));
        	$patientIds=$patientId; //Now superbill id contains patient id
            if (strtolower($corporateStatus[$PatientData['Patient']['corporate_status']]) == 'General') {
                $wardAmt = $this->WardPatientService->getWardTypeCharges('General Ward', $PatientData['Patient']['tariff_standard_id']);
            } else if (strtolower($corporateStatus[$PatientData['Patient']['corporate_status']])== 'shared' /*'Semi-Private'*/) {
                $wardAmt = $this->WardPatientService->getWardTypeCharges('Twin-Sharing', $PatientData['Patient']['tariff_standard_id']);
            } else if (strtolower($corporateStatus[$PatientData['Patient']['corporate_status']]) == 'special') {
                $wardAmt = $this->WardPatientService->getWardTypeCharges('Special Ward', $PatientData['Patient']['tariff_standard_id']);
            }
            $wardcharge['amount'] = $wardAmt;
            $wardcharge['wardName'] = $corporateStatus[$PatientData['Patient']['corporate_status']];
           // $billBo = $PatientData['Patient']['patient_bill_no'];
            if (!$billBo) {
                $order = "(CASE Patient.admission_type
				 		WHEN 'IPD' THEN 1
						WHEN 'OPD' THEN 2
						WHEN 'LAB' THEN 3
						WHEN 'RAD' THEN 4
						ELSE 100 END) ASC";
                $this->FinalBilling->bindModel(array(
                    'belongsTo' => array('Patient' => array('foreignKey' => false, 'conditions' => array('Patient.id=FinalBilling.patient_id')))));
                $billBo = $this->FinalBilling->find('first', array('fields' => array('Patient.id', 'Patient.admission_type', 'FinalBilling.id',
                        'FinalBilling.bill_number'),
                    'conditions' => array('FinalBilling.patient_id' => $patientIds),
                    'order' => array($order)));
				 $billBo = $billBo['FinalBilling']['bill_number'];
                //$this->CorporateSuperBill->updateAll(array('CorporateSuperBill.patient_bill_no' => "'$billBo'"), array('CorporateSuperBill.id' => $superBillId));
            }

            $this->set(array('billData' => $billBo));
            $tariffStdData = $this->Patient->find('first', array('fields' => array('id', 'tariff_standard_id', 'is_discharge', 'mobile_phone', 'designation', 'diagnosis_txt',
                    'treatment_type', 'admission_type', 'is_packaged', 'person_id', 'form_received_on', 'age', 'sex', 'lookup_name', 'patient_id',
                    'discharge_date', 'admission_id', 'consultant_id', 'doctor_id', 'address1', 'relation_to_employee', 'name_of_ip','corporate_status'),
                'conditions' => array('id' => $patientIds),
                'order' => array('Patient.id DESC')));

            $this->Person->bindModel(array(
                'belongsTo' => array('State' => array('foreignKey' => false, 'conditions' => array('State.id=Person.state')))));
            $personData = $this->Person->find('first', array('conditions' => array('Person.id' => $PatientData['Patient']['person_id'])));

            $address = '';
            if ($personData['Person']['plot_no']) {
                $address.=ucwords(strtolower($personData['Person']['plot_no'])) . ', ';
            }
            if ($personData['Person']['landmark']) {
                $address.=ucwords($personData['Person']['landmark']) . ', ';
            }
            if ($personData['Person']['city']) {
                $address.=ucwords($personData['Person']['city']) . ', ';
            }
            if ($personData['Person']['district']) {
                $address.=ucwords($personData['Person']['district']) . ', ';
            }
            if ($personData['Person']['state']) {
                $address.=ucwords($personData['State']['name']) . '- ';
            }
            if ($personData['Person']['pin_code']) {
                $address.=$personData['Person']['pin_code'];
            }

            $mobile = $personData['Person']['mobile'];
            $this->set(array('mobile' => $mobile, 'address' => $address));
            //debug($address);exit;
            $serviceCategory = $this->ServiceCategory->find("list", array('fields' => array('id', 'name'),
                "conditions" => array("ServiceCategory.is_deleted" => 0, /* "ServiceCategory.is_view"=>1, */
                    /* "ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'), */
                    "ServiceCategory.location_id" => array($this->Session->read('locationid'), '0')),
                    /* 'order' => array('ServiceCategory.name' => 'asc') */                    ));
            $serviceCategoryName = $this->ServiceCategory->find("list", array('fields' => array('id', 'alias'),
                "conditions" => array("ServiceCategory.is_deleted" => 0, /* "ServiceCategory.is_view"=>1, */
                    /* "ServiceCategory.service_type"=>array($tariffStdData['Patient']['admission_type'],'Both'), */
                    "ServiceCategory.location_id" => array($this->Session->read('locationid'), '0')),
                    /* 'order' => array('ServiceCategory.name' => 'asc') */                    ));
            $this->set('serviceCategoryName', $serviceCategoryName);
            if ($tariffStdData['Patient']['consultant_id']) {
                $consultant = $this->User->find('first', array('fields' => array('first_name', 'last_name'),
                    'conditions' => array('User.id' => $tariffStdData['Patient']['consultant_id'])));
            } else {
                $consultant = $this->User->find('first', array('fields' => array('first_name', 'last_name'),
                    'conditions' => array('User.id' => $tariffStdData['Patient']['doctor_id'])));
            }
            $this->set('consultant', $consultant);

            $serviceBillData = $this->ServiceBill->getServices(array('ServiceBill.patient_id' => $patientIds));

            $labData = $this->LaboratoryTestOrder->getLaboratories(array('LaboratoryTestOrder.patient_id' => $patientIds));

            $radData = $this->RadiologyTestOrder->getRadiologies(array('RadiologyTestOrder.patient_id' => $patientIds));

            $wardserviceBillData = $this->WardPatientService->getWardServices(array('WardPatientService.patient_id' => $patientIds), '');

            $treatingConsultantData = $this->ConsultantBilling->getDdetail($patientIds, '');

            $externalConsultantData = $this->ConsultantBilling->getCdetail($patientIds, '');

            $pharmacyData = $this->PharmacySalesBill->getPatientPharmacyCharges($patientIds, '');

            $otPharmacyData = $this->OtPharmacySalesBill->getPatientOtPharmacyCharges($patientIds, '');

            $surgeryData = $this->OptAppointment->getSurgeryServices(array('OptAppointment.patient_id' => $patientIds), $PatientData['Patient']['tariff_standard_id']);
			
            $conservative = $this->OptAppointment->calConservative($wardserviceBillData, $patientIds);
            //$this->generateFinalBill($patientIds);
            $i = 0;
            foreach ($treatingConsultantData as $Ckey => $cBilling) {
                foreach ($cBilling as $CBillKey => $consultantBillingDta) {
                    foreach ($consultantBillingDta as $conKey => $consultantBilling) {
                        foreach ($consultantBilling as $singleKey => $service) {
                            $patientArray['patient_id'] = $service['ConsultantBilling']['patient_id'];
                            $encounterAmt = ($service['ConsultantBilling']['amount']) - $service['ConsultantBilling']['paid_amount'] - $service['ConsultantBilling']['discount'];
                            if ($encounterAmt <= 0) {
                                $encounterAmt = 0;
                            }
                            $patientArray['totalAmount'] = $patientArray['totalAmount'] + $encounterAmt;
                            $consultantArray[$i]['table_id'] = $service['ConsultantBilling']['id'];
                            $consultantArray[$i]['doctor_id'] = $service['ConsultantBilling']['doctor_id'];
                            $consultantArray[$i]['name'] = $service['TariffList']['name'] . '(' . $service['DoctorProfile']['first_name'] . ' ' . $service['DoctorProfile']['last_name'] . ')';
                            $consultantArray[$i]['tariff_list_id'] = $service['TariffList']['id'];
                            $consultantArray[$i]['no_of_times'] = $service['TariffList']['apply_in_a_day'];
                            $consultantArray[$i]['cghs'] = $service['TariffList']['cghs_code'];
                            $consultantArray[$i]['amount'] = $service['ConsultantBilling']['amount'];
                            $consultantArray[$i]['discount'] = $service['ConsultantBilling']['discount'];
                            $consultantArray[$i]['paid_amount'] = $service['ConsultantBilling']['paid_amount'];
                            $consultantArray[$i]['patient_id'] = $service['ConsultantBilling']['patient_id'];
                            $date = $this->DateFormat->formatDate2Local($service['ConsultantBilling']['date'], Configure::read('date_format'), false);
                            $consultantArray[$i]['date'] = $date;
                            $i++;
                            $encounterAmt = 0;
                            $total[Configure::read('Consultant')] = $total[Configure::read('Consultant')] + $service['ConsultantBilling']['amount'];
                            $discount[Configure::read('Consultant')] = $discount[Configure::read('Consultant')] + $service['ConsultantBilling']['discount'];
                            $paid[Configure::read('Consultant')] = $paid[Configure::read('Consultant')] + $service['ConsultantBilling']['paid_amount'];
                        }
                    }
                }
            }
            /*             * ****************************************************************************************************************************** */
            /**
             * Array of External  Consultant
             * Patient id as 1st key consultantid as 2nd key and increamental key => details
             */
            foreach ($externalConsultantData as $Ckey => $cBilling) {
                foreach ($cBilling as $CBillKey => $consultantBillingDta) {
                    foreach ($consultantBillingDta as $conKey => $consultantBilling) {
                        foreach ($consultantBilling as $singleKey => $service) {
                            $patientArray['patient_id'] = $service['ConsultantBilling']['patient_id'];
                            $encounterAmt = ($service['ConsultantBilling']['amount']) - $service['ConsultantBilling']['paid_amount'] - $service['ConsultantBilling']['discount'];
                            if ($encounterAmt <= 0) {
                                $encounterAmt = 0;
                            }
                            $patientArray['totalAmount'] = $patientArray['totalAmount'] + $encounterAmt;
                            $consultantArray[$i]['table_id'] = $service['ConsultantBilling']['id'];
                            $consultantArray[$i]['doctor_id'] = $service['ConsultantBilling']['consultant_id'];
                            $consultantArray[$i]['name'] = $service['TariffList']['name'] . '(' . $service['Consultant']['first_name'] . ' ' . $service['Consultant']['last_name'] . ')';
                            $consultantArray[$i]['tariff_list_id'] = $service['TariffList']['id'];
                            $consultantArray[$i]['cghs'] = $service['TariffList']['cghs_code'];
                            $consultantArray[$i]['amount'] = $service['ConsultantBilling']['amount'];
                            $consultantArray[$i]['discount'] = $service['ConsultantBilling']['discount'];
                            $consultantArray[$i]['paid_amount'] = $service['ConsultantBilling']['paid_amount'];
                            $consultantArray[$i]['patient_id'] = $service['ConsultantBilling']['patient_id'];
                            $date = $this->DateFormat->formatDate2Local($service['ConsultantBilling']['date'], Configure::read('date_format'), false);
                            $consultantArray[$i]['date'] = $date;
                            $i++;
                            $encounterAmt = 0;
                            $total[Configure::read('Consultant')] = $total[Configure::read('Consultant')] + $service['ConsultantBilling']['amount'];
                            $discount[Configure::read('Consultant')] = $discount[Configure::read('Consultant')] + $service['ConsultantBilling']['discount'];
                            $paid[Configure::read('Consultant')] = $paid[Configure::read('Consultant')] + $service['ConsultantBilling']['paid_amount'];
                        }
                    }
                }
            }
            /*             * **************************************************************************************************************************** */
            /**
             * Array of servicebill services
             * Patient id as 1st key service_id (radio button service category id) as 2nd key and increamental key => details
             */
            $i = 1;
            foreach ($serviceBillData as $service) {
                $patientArray['patient_id'] = $service['ServiceBill']['patient_id'];
                $encounterAmt = ($service['ServiceBill']['amount'] * $service['ServiceBill']['no_of_times']) - $service['ServiceBill']['paid_amount'] - $service['ServiceBill']['discount'];
                if ($encounterAmt <= 0) {
                    $encounterAmt = 0;
                }
                $patientArray['totalAmount'] = $patientArray['totalAmount'] + $encounterAmt;
                if (strtolower($serviceCategory[$service['TariffList']['service_category_id']]) == strtolower(Configure::read('surgeryservices'))) {
                    $service['ServiceBill']['service_id'] = $service['TariffList']['service_category_id'];
                } else if (strtolower($serviceCategory[$service['TariffList']['service_category_id']]) == strtolower('OPERATION THEATER CHARGE')) {
                    $service['ServiceBill']['service_id'] = $service['TariffList']['service_category_id'];
                }
                $serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['table_id'] = $service['ServiceBill']['id'];
                $serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['service_id'] = $service['ServiceBill']['service_id'];
                $serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['name'] = $service['TariffList']['name'];
                $serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['tariff_list_id'] = $service['TariffList']['id'];
                $serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['cghs'] = $service['TariffList']['cghs_code'];
                $serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['amount'] = $service['ServiceBill']['amount'];
                $serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['no_of_times'] = $service['ServiceBill']['no_of_times'];
                $serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['discount'] = $service['ServiceBill']['discount'];
                $serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['paid_amount'] = $service['ServiceBill']['paid_amount'];
                $serviceArray[$serviceCategory[$service['ServiceBill']['service_id']]][$i]['patient_id'] = $service['ServiceBill']['patient_id'];
                $serviceCatData[$service['ServiceBill']['service_id']] = $service['ServiceBill']['amount'];
                $i++;
                $encounterAmt = 0;
                $total[$serviceCategory[$service['ServiceBill']['service_id']]] = $total[$serviceCategory[$service['ServiceBill']['service_id']]] + $service['ServiceBill']['amount'] * $service['ServiceBill']['no_of_times'];
                $discount[$serviceCategory[$service['ServiceBill']['service_id']]] = $discount[$serviceCategory[$service['ServiceBill']['service_id']]] + $service['ServiceBill']['discount'];
                $paid[$serviceCategory[$service['ServiceBill']['service_id']]] = $paid[$serviceCategory[$service['ServiceBill']['service_id']]] + $service['ServiceBill']['paid_amount'];
            }
            $this->set('serviceCatData', $serviceCatData);
            /*             * ************************************************************************************************************************** */
            /**
             * Array of laboratory services
             * Patient id as 1st key , labid as 2nd key and increamental key => details
             */
            foreach ($labData as $service) {
                $patientArray['patient_id'] = $service['LaboratoryTestOrder']['patient_id'];
                $encounterAmt = ($service['LaboratoryTestOrder']['amount']) - $service['LaboratoryTestOrder']['paid_amount'] - $service['LaboratoryTestOrder']['discount'];
                if ($encounterAmt <= 0) {
                    $encounterAmt = 0;
                }
                $patientArray['totalAmount'] = $patientArray['totalAmount'] + $encounterAmt;
                $labArray[$i]['table_id'] = $service['LaboratoryTestOrder']['id'];
                $labArray[$i]['name'] = $service['Laboratory']['name'];
                $labArray[$i]['laboratory_id'] = $service['LaboratoryTestOrder']['laboratory_id'];
                $labArray[$i]['tariff_list_id'] = $service['Laboratory']['tariff_list_id'];
                $labArray[$i]['cghs_code'] = $service['TariffList']['cghs_code'];
                $labArray[$i]['amount'] = $service['LaboratoryTestOrder']['amount'];
                $labArray[$i]['discount'] = $service['LaboratoryTestOrder']['discount'];
                $labArray[$i]['paid_amount'] = $service['LaboratoryTestOrder']['paid_amount'];
                $labArray[$i]['patient_id'] = $service['LaboratoryTestOrder']['patient_id'];
                $i++;
                $encounterAmt = 0;
                $total[Configure::read('laboratoryservices')] = $total[Configure::read('laboratoryservices')] + $service['LaboratoryTestOrder']['amount'];
                $discount[Configure::read('laboratoryservices')] = $discount[Configure::read('laboratoryservices')] + $service['LaboratoryTestOrder']['discount'];
                $paid[Configure::read('laboratoryservices')] = $paid[Configure::read('laboratoryservices')] + $service['LaboratoryTestOrder']['paid_amount'];
            }
            /*             * ***************************************************************************************************************************** */
            /**
             * Array of Radiology services
             * Patient id as 1st key,radiology_id as 2nd key and increamental key => details
             */
            foreach ($radData as $service) {
                $patientArray['patient_id'] = $service['RadiologyTestOrder']['patient_id'];
                $encounterAmt = ($service['RadiologyTestOrder']['amount']) - $service['RadiologyTestOrder']['paid_amount'] - $service['RadiologyTestOrder']['discount'];
                if ($encounterAmt <= 0) {
                    $encounterAmt = 0;
                }
                $patientArray['totalAmount'] = $patientArray['totalAmount'] + $encounterAmt;
                $radArray[$i]['table_id'] = $service['RadiologyTestOrder']['id'];
                $radArray[$i]['radiology_id'] = $service['RadiologyTestOrder']['radiology_id'];
                $radArray[$i]['name'] = $service['Radiology']['name'];
                $radArray[$i]['tariff_list_id'] = $service['Radiology']['tariff_list_id'];
                $radArray[$i]['cghs_code'] = $service['TariffList']['cghs_code'];
                $radArray[$i]['no_of_times'] = $service['TariffList']['apply_in_a_day'];
                $radArray[$i]['amount'] = $service['RadiologyTestOrder']['amount'];
                $radArray[$i]['discount'] = $service['RadiologyTestOrder']['discount'];
                $radArray[$i]['paid_amount'] = $service['RadiologyTestOrder']['paid_amount'];
                $radArray[$i]['patient_id'] = $service['RadiologyTestOrder']['patient_id'];
                $i++;
                $encounterAmt = 0;
                $total[Configure::read('radiologyservices')] = $total[Configure::read('radiologyservices')] + $service['RadiologyTestOrder']['amount'];
                $discount[Configure::read('radiologyservices')] = $discount[Configure::read('radiologyservices')] + $service['RadiologyTestOrder']['discount'];
                $paid[Configure::read('radiologyservices')] = $paid[Configure::read('radiologyservices')] + $service['RadiologyTestOrder']['paid_amount'];
            }

            /*             * ***************************************************************************************************************************** */
            /**
             * Room tariff data
             * combined room charge encounterwise
             * PatientId as 1st key , TariffList id as 2nd key=>details
             */
            foreach ($wardserviceBillData as $service) {
                $patientArray['patient_id'] = $service['WardPatientService']['patient_id'];
                $encounterAmt = ($service['WardPatientService']['amount']) - $service['WardPatientService']['paid_amount'] - $service['WardPatientService']['discount'];
                if ($encounterAmt <= 0) {
                    $encounterAmt = 0;
                }
                $patientArray['totalAmount'] = $patientArray['totalAmount'] + $encounterAmt;
                $wardArray[$service['WardPatientService']['id']]['table_id'][] = $service['WardPatientService']['id'];
                $wardArray[$service['WardPatientService']['id']]['name'] = $service['TariffList']['name'];
                $wardArray[$service['WardPatientService']['id']]['tariff_list_id'] = $service['TariffList']['id'];
                $wardArray[$service['WardPatientService']['id']]['cghs'] = $service['TariffList']['cghs_code'];
                if (!$wardArray[$service['WardPatientService']['id']]['inTime'])
                    $wardArray[$service['WardPatientService']['id']]['inTime'] = $service['WardPatientService']['date'];
                $wardArray[$service['WardPatientService']['id']]['outTime'] = $service['WardPatientService']['date'];
                $wardArray[$service['WardPatientService']['id']]['amount'] = $wardArray[$service['WardPatientService']['tariff_list_id']]['amount'] + $service['WardPatientService']['amount'];
                $wardArray[$service['WardPatientService']['id']]['discount'] = $wardArray[$service['WardPatientService']['tariff_list_id']]['discount'] + $service['WardPatientService']['discount'];
                $wardArray[$service['WardPatientService']['id']]['paid_amount'] = $wardArray[$service['WardPatientService']['tariff_list_id']]['paid_amount'] + $service['WardPatientService']['paid_amount'];
                $wardArray[$service['WardPatientService']['id']]['patient_id'] = $service['WardPatientService']['patient_id'];
                $total[Configure::read('RoomTariff')] = $total[Configure::read('RoomTariff')] + $service['WardPatientService']['amount'];
                $discount[Configure::read('RoomTariff')] = $discount[Configure::read('RoomTariff')] + $service['WardPatientService']['discount'];
                $paid[Configure::read('RoomTariff')] = $paid[Configure::read('RoomTariff')] + $service['WardPatientService']['paid_amount'];
                $encounterAmt = 0;
                $i++;
            }



            foreach ($pharmacyData as $patKey => $phar) {
                $patientArray['patient_id'] = $patKey;

                $totalPhar = $phar['total'] - $phar['return'];
                $paidPhar = $phar['paid_amount'] - $phar['returnPaid'];
                $discountPhar = $phar['discount'] - $phar['returnDiscount'];
                $encounterAmt = $totalPhar - $paidPhar - $discountPhar;
                if ($encounterAmt <= 0) {
                    $encounterAmt = 0;
                }
                $patientArray['totalAmount'] = $patientArray['totalAmount'] + $encounterAmt;
                //$pharArray['pharmacy']['table_id'][]=$service['WardPatientService']['id'];
                $pharArray['pharmacy']['name'] = 'Pharmacy';
                //$pharArray['pharmacy']['tariff_list_id']=$service['TariffList']['id'];
                $pharArray['pharmacy']['amount'] = $pharArray['pharmacy']['amount'] + $totalPhar;
                $pharArray['pharmacy']['discount'] = $pharArray['pharmacy']['discount'] + $discountPhar;
                $pharArray['pharmacy']['paid_amount'] = $pharArray['pharmacy']['paid_amount'] + $paidPhar;
                $pharArray['pharmacy']['patient_id'] = $patKey;

                $encounterAmt = 0;
                $i++;
                $total[Configure::read('Pharmacy')] = $total[Configure::read('Pharmacy')] + $totalPhar;
                $discount[Configure::read('Pharmacy')] = $discount[Configure::read('Pharmacy')] + $discountPhar;
                $paid[Configure::read('Pharmacy')] = $paid[Configure::read('Pharmacy')] + $paidPhar;
            }

            foreach ($otPharmacyData as $patKey => $otPhar) {
                $patientArray['patient_id'] = $patKey;

                $totalOtPhar = $otPhar['total'] - $otPhar['return'];
                $paidOtPhar = $otPhar['paid_amount'] - $otPhar['returnPaid'];
                $discountOtPhar = $otPhar['discount'] - $otPhar['returnDiscount'];
                $encounterAmt = $totalOtPhar - $paidOtPhar - $discountOtPhar;
                if ($encounterAmt <= 0) {
                    $encounterAmt = 0;
                }
                $patientArray['totalAmount'] = $patientArray['totalAmount'] + $encounterAmt;
                //$pharArray['pharmacy']['table_id'][]=$service['WardPatientService']['id'];
                $otpharArray['otpharmacy']['name'] = 'Ot Pharmacy';
                //$pharArray['pharmacy']['tariff_list_id']=$service['TariffList']['id'];
                $otpharArray['otpharmacy']['amount'] = $otpharArray['otpharmacy']['amount'] + $totalOtPhar;
                $otpharArray['otpharmacy']['discount'] = $otpharArray['otpharmacy']['discount'] + $discountOtPhar;
                $otpharArray['otpharmacy']['paid_amount'] = $otpharArray['otpharmacy']['paid_amount'] + $paidOtPhar;
                $otpharArray['otpharmacy']['patient_id'] = $patKey;
                $encounterAmt = 0;
                $i++;
                $total[Configure::read('OtPharmacy')] = $total[Configure::read('OtPharmacy')] + $totalOtPhar;
                $discount[Configure::read('OtPharmacy')] = $discount[Configure::read('OtPharmacy')] + $discountOtPhar;
                $paid[Configure::read('OtPharmacy')] = $paid[Configure::read('OtPharmacy')] + $paidOtPhar;
            }
            /*             * ***************************************************************************************************************************** */
            /* $this->set(array('patientData'=>$patientData,'consultantArray'=>$consultantArray,'serviceArray'=>$serviceArray,
              'labArray'=>$labArray,'radArray'=>$radArray,'wardArray'=>$wardArray,'otpharArray'=>$otpharArray,'pharArray'=>$pharArray,
              'patientArray'=>$patientArray,'superbillData'=>$superbillData,
              'total'=>$total,'discount'=>$discount,'paid'=>$paid)); */

            $con = $this->ConsultClub($consultantArray);

            $surCount = 1;
			$coporateStatus=Configure::read('corporateStatus');// new coporate status -- pooja 19/03/16
			 
			 foreach ($surgeryData as $surgery) {	
			 	
			 	$surgeryArray['from'] = $this->DateFormat->formatDate2Local($surgery['OptAppointment']['starttime'], Configure::read('date_format'), false);
			 	if(empty($surgeryArray['fromDate']))//set from date from first surgery one time
			 		$surgeryArray['fromDate']=$surgeryArray['from'];
			 	
			 	if(empty($surgeryArray['prev_from']))
			 		$surgeryArray['prev_from']=$surgeryArray['from']; 
			 	
			 	//for comparing same day surgery
			 	if(($surgeryArray['prev_from'])!=($surgeryArray['from'])){
			 		$surCount = 1; // initialize surgery count for next date
			 		$surgeryArray['prev_from']=$surgeryArray['from'];
			 	}
			 		
			 	$surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['from']=$surgeryArray['from'];
			 	$surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['name'] = $surgery['Surgery']['name'];
                $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['cghs'] = $surgery['TariffList']['cghs_code'];
                $surAmt = round($surgery['OptAppointment']['ot_charges'] + $surgery['OptAppointment']['surgery_cost'] + $surgery['OptAppointment']['anaesthesia_cost']);
                $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['amount'] = $surAmt;
                
				$unitday=$surgery['TariffAmount']['unit_days']?$surgery['TariffAmount']['unit_days']:'1';
                $end = date('Y-m-d H:i:s', strtotime($surgery['OptAppointment']['starttime'] . " +" . $unitday . " days"));				
                $surgeryArray['to'] = $this->DateFormat->formatDate2Local($end, Configure::read('date_format'), false);

                if (/*$superbillData['CorporateSuperBill']['patient_type'] == 'General'*/ strtolower($coporateStatus[$surgery['Patient']['corporate_status']])=='general') {
                    if ($surCount == 1) {
                        $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['tenPer'] =round($this->getPerCharge($surAmt, '10'));
                    } else {
                        $fityAmt = $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['fiftyPer'] = round($this->getPerCharge($surAmt, '50'));
                        $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['tenPer'] =round( $this->getPerCharge($fityAmt, '10'));
                        $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['15Per']=round($this->getPerCharge($fityAmt,'15'));
                    }
                } else if (/*$superbillData['CorporateSuperBill']['patient_type'] == 'Semi-Special'*/strtolower($coporateStatus[$surgery['Patient']['corporate_status']])=='shared') {
                    if ($surCount == 1) {
                        $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['tenPer'] = round($this->getPerCharge($surAmt, '10'));
                    } else {
                        $fityAmt = $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['fiftyPer'] = round($this->getPerCharge($surAmt, '50'));
                        $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['tenPer']=round($this->getPerCharge($fityAmt,'10'));
                        $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['15Per']=round($this->getPerCharge($fityAmt,'15'));
                    }
                } else if (/*$superbillData['CorporateSuperBill']['patient_type'] == 'Special'*/strtolower($coporateStatus[$surgery['Patient']['corporate_status']])=='special') {
                    if ($surCount == 1) {
                        $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['tenPer'] = round($this->getPerCharge($surAmt, '10'));
                        $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['15Per'] = round($this->getPerCharge($surAmt, '15'));//for cghs/echs private patients
                    } else {
                        $fityAmt = $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['fiftyPer'] = round($this->getPerCharge($surAmt, '50'));
                        $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['tenPer']=round($this->getPerCharge($fityAmt,'10'));
                        $surgeryArray['Surgery'][$surgeryArray['from']][$surCount]['15Per'] = round($this->getPerCharge($fityAmt, '15'));
                    }
                }
                $surCount++;
            }   
             
            
            $i = 0;
            foreach ($conservative['Conservative'] as $key => $cons) {
                $date1 = new DateTime($cons['start']);
                $date2 = new DateTime($cons['end']);
                $interval = $date1->diff($date2);
                $days[] = $interval->d + 1;
                //$consCharges[$i]=$this->Patient->getConsCharges($patientIds,$interval->d+1);
                //$consCharges[$i]['start']=$this->DateFormat->formatDate2Local($cons['start'],Configure::read('date_format'),false);
                //$consCharges[$i]['end']=$this->DateFormat->formatDate2Local($cons['end'],Configure::read('date_format'),false);
                $conservative['Conservative'][$key]['days'] = $interval->d + 1;
                $i++;
            }

            return array('patientData' => $patientData, 'consultantArray' => $con, 'serviceArray' => $serviceArray, 'conservative' => $conservative['Conservative'],
                'labArray' => $labArray, 'radArray' => $radArray, 'wardArray' => $conservative['Ward'], 'otpharArray' => $otpharArray, 'pharArray' => $pharArray,
                'patientArray' => $patientArray, 'superbillData' => $superbillData, 'surgeryArray' => $surgeryArray, 'consCharges' => $consCharges, 'wardIcu' => $conservative['wardIcu'],
                'total' => $total, 'discount' => $discount, 'paid' => $paid, 'tariffStdData' => $tariffStdData, 'serviceCategory' => $serviceCategory, 'billBo' => $billBo,
                'wardAmt' => $wardcharge);


            $this->set('tariffStdData', $tariffStdData);
            $this->set('serviceCategory', $serviceCategory);
        }

        /* if(strtolower($corporate)=='cghs'){
          $this->layout=false;
          $this->render('cghs_xls');
          }else if(strtolower($corporate)=='ongc'){
          $this->layout=false;
          $this->render('ongc_xls');
          }else if(strtolower($corporate)=='reliance'){
          $this->layout=false;
          $this->render('ril_xls');
          }else if(strtolower($corporate)=='heavy water plant'){
          $this->layout=false;
          $this->render('heavy_water_plant_xls');
          }else if(strtolower($corporate)=='maa yojna'){
          $this->layout=false;
          $this->render('maa_yojna_xls');
          }else if(strtolower($corporate)=='iocl'){
          $this->layout=false;
          $this->render('iocl_xls');
          }else if(strtolower($corporate)=='esic'){
          $this->layout=false;
          $this->render('esic_xls');
          }else{
          $this->layout=false;
          //$this->render('cghs_xls');

          } */
    }

    /* @param unknown_type $amount
     * @param unknown_type $per
     * @param unknown_type $inc
     * @param unknown_type $dec
     * @return number
     * Pooja Gupta
     */

    public function getPerCharge($amount, $per) {
        $charge = ($amount * $per) / 100;
        return $charge;
    }

    //function to get all remark of patient by Swapnil - 09.11.2015
    public function getRemarkForCorporateReport($patientID, $corporateHead) {
        $this->layout = "advance_ajax";
        $this->autoRender = false;
        $this->loadModel('Patient');
        $this->loadModel('User');
        $result = $this->Patient->find('first', array('fields' => array('Patient.corporate_remark', 'Patient.is_dr_chk'), 'conditions' => array('Patient.id' => $patientID)));
        $returnData = unserialize($result['Patient']['corporate_remark']);
        $userList = $this->User->getUsers();

        foreach ($returnData as $key => $val) {
            $returnData[$key] = $val;
            $returnData[$key]['user_id'] = $userList[$returnData[$key]['user_id']];
        }
        $this->set('patient_id', $patientID);
        $this->set('returnData', $returnData);
        $this->set('fileIsNotSubmitted', $result['Patient']['is_dr_chk']);
        $this->set('corporateHead', $corporateHead);
        $this->render('get_remark_for_corporate_report');
    }

    //function to add corporate remark by Swapnil - 09.11.2015
    public function addRemarkForCorporate() {
        $this->layout = false;
        $this->autoRender = false;
        $this->loadModel('Patient');
        $patientID = $this->request->data['Corporate']['patient_id'];
        $result = $this->Patient->find('first', array('fields' => array('Patient.corporate_remark'), 'conditions' => array('Patient.id' => $patientID)));
        $remarks = unserialize($result['Patient']['corporate_remark']);
        $saveData = array();
        $save[0]['user_id'] = $this->Session->read('userid');
        $save[0]['create_time'] = date("Y-m-d H:i:s");
        $save[0]['remark'] = $this->request->data['Corporate']['remark'];

        if (!empty($this->request->data['Corporate']['upload_document']['name']) && $this->request->data['Corporate']['upload_document']['name'] != null) {
            $file = $this->request->data['Corporate']['upload_document'];
            $uploadFolder = "uploads/Documents";
            $uploadPath = WWW_ROOT . $uploadFolder;
            $fileName = $file['name'];
            if (file_exists($uploadPath . '/' . $fileName)) {
                $fileName = date('His') . $fileName;
            }
            $full_file_path = $uploadPath . '/' . $fileName;
            if (move_uploaded_file($file['tmp_name'], $full_file_path)) {
                $save[0]['file_name'] = $fileName;
            }
        }
        if (is_array($remarks)) {
            $resultdata = serialize(array_merge($remarks, $save));
        } else {
            $resultdata = serialize($save);
        }
        $this->Patient->id = $patientID;
        $this->Patient->saveField('corporate_remark', $resultdata);
        echo "<script> parent.$.fancybox.close();  </script>";
    }

    //function corporate patient search autocomplete on suspense account by Swapnil - 14.11.2015
    public function patientSearch($tariffStdId) {
        $this->uses = array('Patient', 'FinalBilling', 'Billing');
        $this->autoRender = false;
        $this->layout = false;
        $searchKey = $this->params->query['term'];
        $this->Patient->bindModel(array('belongsTo' => array(
                'FinalBilling' => array(
                    'type' => 'INNER',
                    'foreignKey' => false,
                    'conditions' => array('FinalBilling.patient_id = Patient.id')
                )
                )));
        $array = array('4', '16', '27');    //if not CGHS,ECHS,Raymond
        if (!(in_array($tariffStdId, $array))) {
            $cond['Patient.admission_type'] = "IPD";
        }
        $patientData = $this->Patient->find('all', array(
            'fields' => array('Patient.id', 'Patient.lookup_name', 'FinalBilling.id', 'FinalBilling.hospital_invoice_amount', 'FinalBilling.tds', 'FinalBilling.discount'), 'conditions' => array('Patient.is_deleted' => '0',
                'Patient.tariff_standard_id' => $tariffStdId, 'Patient.is_discharge' => '1', $cond,
                'Patient.lookup_name LIKE' => $searchKey . "%", 'Patient.is_hidden_from_report' => '0'),
            'order' => array('Patient.id' => 'DESC')));
        foreach ($patientData as $key => $value) {
            if($tariffStdId=="25"){
                $paidAmount = 0;
            }else{
                $paidAmount = $this->Billing->getPatientPaidAmount($value['Patient']['id']);
            }
            $returnArr[] = array(
                'id' => $value['Patient']['id'],
                'final_billing_id' => $value['FinalBilling']['id'],
                'name' => $value['Patient']['lookup_name'],
                'value' => $value['Patient']['lookup_name'],
                'hospital_invoice' => $value['FinalBilling']['hospital_invoice_amount'] ? $value['FinalBilling']['hospital_invoice_amount'] : '0',
                'advance_received' => $paidAmount ? $paidAmount : '0',
                'tds' => $value['FinalBilling']['tds'] ? $value['FinalBilling']['tds'] : '0',
                'discount' => $value['FinalBilling']['discount'] ? $value['FinalBilling']['discount'] : '0'
            );
        }
        echo json_encode($returnArr);
        exit;
    }

    //function to set the flag is the patient document is not submitted for corporated patient
    // '1' => not submitted
    // '2' => submitted
    public function documentIsNotSubmitted($patientId, $val) {
        $this->layout = false;
        $this->autoRender = false;
        $this->uses = array('Patient');
        $this->Patient->id = $patientId;
        $this->Patient->saveField('is_dr_chk', $val);
        return true;
    } 
    
    //set expected amount for corporate patient 
    public function setExpectedAmount(){
    	$this->autoRender = false ; 
    	$this->layout = 'ajax' ;    	         
    	/*if($this->request->data['expected_amount']){
    		$this->uses  = array('FinalBilling');
            $this->FinalBilling->updateAll(array('expected_amount'=>$this->request->data['expected_amount'],
                ),
    				array('FinalBilling.patient_id'=>$this->request->data['patient_id']));
    		$this->Session->setFlash('Expected amount updated.','default',array('class'=>'message')) ; 
    	}*/
    	
    	if($this->request->data['finalize'] != ''){
    		$this->uses  = array('FinalBilling');
            $date=$this->DateFormat->formatDate2STD($this->request->data['bill_uploading_date'],Configure::read('date_format'));//date('Y-m-d H:i:s');   
    		

            $isUpdate = $this->FinalBilling->updateAll(array('is_bill_finalize'=>"'".$this->request->data['finalize']."'",'bill_uploading_date'=>"'".$date."'",'hospital_invoice_amount'=>"'".$this->request->data['bill_amount']."'",'expected_amount'=>"'".$this->request->data['expected_amount']."'",'bill_prepared_by'=>"'".$this->request->data['bill_prepared_by']."'",'reason_for_delay'=>"'".$this->request->data['reason_for_delay']."'"),
                    array('FinalBilling.patient_id'=>$this->request->data['patient_id']));

            if($isUpdate){
                $this->Session->setFlash('Bill Finalized Succesfully.','default',array('class'=>'message')) ; 
            }else{
                $this->Session->setFlash('Something Went Wrong! Please Try again.','default',array('class'=>'error')) ; 
            }
    		
    	}
    }
    
    /* RGJAY INCOME REPORT
     * BY Mrunal
     * DT:29.03.2016
     */
    public function rgjay_income_report(){
    	$this->layout = 'advance' ;
    	$this->uses = array('Patient','ServiceBill','ServiceCategory','TariffList','TariffStandard','Billing');
    	
    	//$this->Patient->fetch_rgjay_patient());
    	
    	$locationId = $this->Session->read('locationid');
    	$rgjayTarifId = $this->TariffStandard->getRGJAYTariffID($locationId);
    	$rgayPackage = Configure::read('RGJAY Package') ;  
    	$rgjayPackageGroupId = $this->ServiceCategory->getServiceGroupId($rgayPackage,$locationId);
    	$packgeArray = array();
    	
    	$this->ServiceBill->bindModel(array(
    			'belongsTo' => array(
    					'Patient' =>array('type'=>'inner','foreignKey'=>'patient_id'),
    					'TariffList' =>array('type'=>'inner','foreignKey'=>false, 'conditions' => array('TariffList.id=ServiceBill.tariff_list_id')),
    			)),false);
    			
    	if(!empty($this->request->query)) {
    		if (!empty($this->request->query['patient_name'])) {
    			$conditions['Patient.lookup_name like'] = '%'.$this->request->query['patient_name'].'%'; 
    		}
            if (!empty($this->request->query['from_date'])) {
                $from = $this->DateFormat->formatDate2STD($this->request->query['from_date'], Configure::read('date_format')) . " 00:00:00";
            }
            if (!empty($this->request->query['to_date'])) {
                $to = $this->DateFormat->formatDate2STD($this->request->query['to_date'], Configure::read('date_format')) . " 23:59:59";
            }
            if (!empty($this->request->query['package_name'])) {
            	$conditions['TariffList.name'] = $this->request->query['package_name'];
            }
            

            if ($to)
                $conditions['ServiceBill.date <='] = $to;
            if ($from)
                $conditions['ServiceBill.date >='] = $from;
         }else{
         	$conditions['ServiceBill.date <='] = date("Y-m-d", strtotime("last day of previous month"))." 23:59:59";
        	$conditions['ServiceBill.date >='] = date("Y-m-d", strtotime("first day of previous month"))." 00:00:00";
        }
        
        $conditions['Patient.is_deleted']=0;
       	$conditions['Patient.tariff_standard_id']=$rgjayTarifId;
       
        $serviceCond['ServiceBill.service_id']=$rgjayPackageGroupId;
        $serviceCond['ServiceBill.is_deleted']=0; 
    	
    	$servicesDataOnlyImages = $this->ServiceBill->find('all',array(
    			'fields'=>array('Patient.lookup_name','Patient.id','Patient.admission_id','Patient.is_discharge','ServiceBill.patient_id','ServiceBill.date','ServiceBill.amount','TariffList.name'),
    			'conditions'=>array($serviceCond,$conditions),
    			'order'=>array('Patient.id DESC'),
    			'group'=>array('ServiceBill.tariff_list_id') 
    	));
    	//debug($servicesDataOnlyImages);
    	 foreach($servicesDataOnlyImages as $package){
    	 	$packgeArray[$package['ServiceBill']['patient_id']]['id'] = $package['Patient']['id'];
    	 	$packgeArray[$package['ServiceBill']['patient_id']]['admission_id'] = $package['Patient']['admission_id'];
    		$packgeArray[$package['ServiceBill']['patient_id']]['patient_name'] = $package['Patient']['lookup_name'];
    		$packgeArray[$package['ServiceBill']['patient_id']]['is_discharge'] = $package['Patient']['is_discharge'];
    		$packgeArray[$package['ServiceBill']['patient_id']]['package_name'][] = $package['TariffList']['name'];
    		$packgeArray[$package['ServiceBill']['patient_id']]['package_cost'][] = $package['ServiceBill']['amount'];
    		$packgeArray[$package['ServiceBill']['patient_id']]['rgjay_package'] = $this->ServiceBill->getRgjayPackageAmount($package['ServiceBill']['patient_id']);
    		$packgeArray[$package['ServiceBill']['patient_id']]['total_amount'] = $this->Billing->getPatientTotalBill($package['Patient']['id'],'IPD');
    	} 
    		
    	$this->set('packgeArray',$packgeArray);
    	$this->set('servicesDataOnlyImages',$servicesDataOnlyImages);
    	
    }//END of rgjay_income_report
    

    //set bill submitted flag for corporate patient 
    public function setBillSubmit(){
        $this->autoRender = false ; 
        $this->layout = 'ajax' ;
        if($this->request->data['bill_submit_date']){
            $this->uses  = array('FinalBilling');
            $date=$this->DateFormat->formatDate2STD($this->request->data['bill_submit_date'],Configure::Read('date_format'));
            $status = Configure::Read('bill_submit_status');
            $bill_submitted_by = $this->request->data['bill_submitted_by'] ; 
            $this->FinalBilling->updateAll(array('dr_claim_date'=>"'$date'",'claim_status'=>"'$status'",'bill_submitted_by'=>"'$bill_submitted_by'"),
                    array('FinalBilling.patient_id'=>$this->request->data['patient_id']));
            $this->Session->setFlash('Bill Submitted.','default',array('class'=>'message')) ; 
        }       
        
    }



    /*********************************************WCL report month wise************************************************************/
    public function admin_wcl_report_monthwise($type = NULL) {
        $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing','Account','CorporateSublocation');
        $this->layout = 'advance';
      //  $patientStatusConfig = Configure::read('onDischargeStatus');
        $tariffID = $this->TariffStandard->getTariffStandardID("WCL");
       
        $this->set('subLocations',$this->CorporateSublocation->getCorporateSublocationList($tariffID));
        $this->Patient->unBindModel(array(
            'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

        $this->Patient->bindModel(array(
                'belongsTo' => array(
                    'PatientDocument' => array('foreignKey' => false,
                            'conditions' => array('PatientDocument.patient_id=Patient.id')),
                    'FinalBilling' => array('type' => 'INNER', 'foreignKey' => false,
                            'conditions' => array('FinalBilling.Patient_id=Patient.id'),
                            'fields' => array('FinalBilling.id', 'FinalBilling.other_deduction', 'FinalBilling.paid_to_patient',
                                    'FinalBilling.discount', 'FinalBilling.bill_uploading_date', 'FinalBilling.amount_paid',
                                    'FinalBilling.bill_number', 'FinalBilling.tds', 'FinalBilling.package_amount')
                            )
                        )), false);

        $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'),
                'conditions' => array('TariffStandard.is_deleted' => 0,'TariffStandard.location_id' => $this->Session->read('locationid'))));
        $this->set('tariffData', $tariffData);
        $this->set('banks', $this->Account->getBankNameList());
       /* if(empty($this->request->query)){
            $statusCondition['Patient.claim_status'] = $patientStatusConfig['File Submitted'];
            $status = $patientStatusConfig['File Submitted'];
        }*/
      
        $conditions1 = array('Patient.tariff_standard_id' => $tariffID, 'Patient.admission_type' => 'IPD', 'Patient.is_discharge' => '1',
         'Patient.is_deleted' => 0,
                'Patient.is_hidden_from_report' => 0, 'Patient.location_id' => $this->Session->read('locationid')/*,$statusCondition*/);
        $date = date('Y-m');
        $conditions1['DATE_FORMAT(Patient.form_received_on,"%Y-%m")']= $date;

        if (!empty($this->request->query)) {
            unset($conditions1['Patient.is_hidden_from_report']);
            if (!empty($this->request->query['lookup_name'])) {
                $conditions1['Patient.lookup_name'] = $this->request->query['lookup_name'];
            }
            if( !empty($this->request->query['year']['year'] &&  $this->request->query['month']['month'])){
                $year = $this->request->query['year']['year'];
                $month = $this->request->query['month']['month'];
                $date = date($year."-".$month);

                $conditions1['DATE_FORMAT(Patient.form_received_on,"%Y-%m")']= $date;
            }

            if (!empty($this->request->query['status'])){
                $conditions1['Patient.status'] = $patientStatusConfig[$this->request->query['status']];
                $status = $patientStatusConfig[$this->request->query['status']];
            }
            
            if (!empty($this->request->query['sub_location'])){
                $conditions1['Patient.corporate_sublocation_id'] = $this->request->query['sub_location'];
                $subLocationId = $this->request->query['sub_location'];
            }
        }
        $fields = array('Patient.id', 'Patient.lookup_name', 'Patient.admission_type', 'Patient.form_received_on', 'FinalBilling.bill_uploading_date', 'FinalBilling.other_deduction',
            'Patient.form_received_on', 'FinalBilling.hospital_invoice_amount', 'FinalBilling.cmp_amt_paid', 'FinalBilling.cmp_paid_date', 'FinalBilling.tds', 'FinalBilling.bill_number', 'FinalBilling.amount_paid',
            'Patient.discharge_date', 'FinalBilling.total_amount', 'FinalBilling.amount_paid', 'FinalBilling.amount_pending', 'FinalBilling.other_deduction_modified',
            'Patient.is_hidden_from_report', 'FinalBilling.id', 'Patient.remark', 'FinalBilling.package_amount', 'PatientDocument.id', 'PatientDocument.filename','Patient.corporate_sublocation_id','Patient.name_of_ip','Patient.relation_to_employee');
        
        if ($type != 'excel') {
            $this->paginate = array(
                'limit' => 10,
                'order' => array('Patient.form_received_on' => 'asc'),
                'fields' => $fields,
                'conditions' => $conditions1);
            $result = $this->paginate('Patient');
        } else {
            $result = $this->Patient->find('all', array('fields' => $fields, 'conditions' => $conditions1,
                    'order' => array('Patient.form_received_on' => 'asc')));
        }
        //get total invoice amount and paid
        $totalData = $this->getTotalInvoiceAndPaidAmnt($tariffID, 'IPD');
        $suspenseDetails = $this->getCorporateSuspenseAmount($tariffID);
        $this->set(array('totalInvoice' => $totalData['totalInvoice'], 'totalAdvancePaid' => $totalData['totalPaid'],
            'suspenseDetails' => $suspenseDetails['suspenseDetails'], 'suspenseAmount' => $suspenseDetails['totalSuspenseAmount']));
    
        //to get the total payment of that patient by Swapnil - 04.11.2015
        foreach ($result as $key => $val) {
            $totalVal[$val['Patient']['id']] = $this->Billing->getPatientTotalBill($val['Patient']['id'],$val['Patient']['admission_type']);
            $totalPaid[$val['Patient']['id']] = $this->Billing->getPatientPaidAmount($val['Patient']['id']);
        }
        $this->set(compact(array('totalPaid', 'totalDiscount','status','subLocationId')));
        $this->set(array('totalAmount' => $totalVal));
        $this->set('results', $result);
        if ($type == 'excel') {
            $this->autoRender = false;
            $this->layout = false;
            $this->render('admin_wcl_xls_monthwise', false);
        }
    }


    /*     * ***********************************BSNL Report swati********************************************************* */

     public function saveNocDetail(){
        $this->autoRender = false ; 
        $this->layout = 'ajax' ;                 
      #  debug($this->request->data);exit;
        //if($this->request->data['five_day_noc_taken'] != ''){
            $this->uses  = array('Patient');
          
            $isUpdate = $this->Patient->updateAll(array('five_day_reminder'=>"'".$this->request->data['five_day_reminder']."'",'twelve_day_reminder'=>"'".$this->request->data['twelve_day_reminder']."'",'five_day_noc_taken'=>"'".$this->request->data['five_day_noc_taken']."'",'twelve_day_noc_taken'=>"'".$this->request->data['twelve_day_noc_taken']."'"),
                    array('Patient.id'=>$this->request->data['patient_id']));

            if($isUpdate){
                $this->Session->setFlash('NOC Details Saved Succesfully.','default',array('class'=>'message')) ; 
            }else{
                $this->Session->setFlash('Something Went Wrong! Please Try again.','default',array('class'=>'error')) ; 
            }
            
       // }
    }

     public function saveNmiDetail(){
        $this->autoRender = false ; 
        $this->layout = 'ajax' ;                 
      #  debug($this->request->data);exit;
        if($this->request->data['nmi_answered'] != ''){
            $this->uses  = array('FinalBilling');
            $date=$this->DateFormat->formatDate2STD($this->request->data['nmi_date'],Configure::read('date_format'));//date('Y-m-d H:i:s');   
            $isUpdate = $this->FinalBilling->updateAll(array('nmi'=>"'".$this->request->data['nmi']."'",'nmi_date'=>"'".$date."'",'nmi_answered'=>"'".$this->request->data['nmi_answered']."'"),
                    array('FinalBilling.patient_id'=>$this->request->data['patient_id']));

            if($isUpdate){
                $this->Session->setFlash('NMI Details Saved Succesfully.','default',array('class'=>'message')) ; 
            }else{
                $this->Session->setFlash('Something Went Wrong! Please Try again.','default',array('class'=>'error')) ; 
            }
            
        }
    }

    public function addBillLink($patientId) {
        $this->uses = array('Person');
        $this->layout='ajax';
        if($this->request->data){
        
           # debug($this->request->data);exit;
              if ($this->request->data['Coprporates'] ['referral_letter']['name']) {
                    $imgName = explode ( '.', $this->request->data['Coprporates'] ['referral_letter']['name'] );
                    if (! isset ( $imgName [1] )) {
                        $imagename = "ReferralLetter_" . $imgName [0] . mktime () . '.' . $imgName [0];
                    } else {
                        $imagename = "ReferralLetter_" . $imgName [0] . mktime () . '.' . $imgName [1];
                    }
                    $folderName = 'referral_letter' ;
                    /*if(!file_exists(WWW_ROOT.$folderName)) {
                        mkdir(WWW_ROOT.$folderName,0777,true); //set true for recursive directory creation
                    }

                    if (! empty ( $this->request->data['Coprporates'] ['referral_letter']['name'] )) {
                        $path = WWW_ROOT . 'uploads/referral_letter/' . trim($imagename);
                        move_uploaded_file ($this->request->data['Coprporates'] ['referral_letter']['tmp_name'], $path );
                    }*/

                $requiredArray1  = array('data' =>array('PatientDocumentDetail'=>array('referral_letter'=>$this->request->data['Coprporates'] ['referral_letter'])));
                $showError1 = $this->ImageUpload->uploadFile($requiredArray1,'referral_letter','uploads/referral_letter',$imagename);

              
            }else{
                $imagename = $this->request->data['Coprporates'] ['referral_letter_old'] ; 
            }


                $billingLink = $this->request->data['Coprporates'] ['billing_link'] ; 

                $isUpdate = $this->Person->updateAll(array('billing_link'=>"'".$billingLink."'",'referral_letter'=>"'".$imagename."'"),
                        array('Person.id'=>$patientId));

                if($isUpdate){
                    $this->Session->setFlash('Bill Link Saved Succesfully.','default',array('class'=>'message')) ; 
                }else{
                    $this->Session->setFlash('Something Went Wrong! Please Try again.','default',array('class'=>'error')) ; 
                }

        }
       exit;     
    }
    
    
     public function admin_corporate_patient($typeId = NULL) {
    $this->layout = 'advance';

    $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'PatientCard');
    $this->Patient->unBindModel(array(
        'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')
    ));

    $this->Patient->bindModel(array('belongsTo' => array(
        'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id')),
    )));

    $this->Patient->bindModel(array('belongsTo' => array(
        'PatientCard' => array('foreignKey' => false, 'conditions' => array('PatientCard.person_id=Patient.person_id')),
        'FinalBilling' => array('type' => 'LEFT', 'foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id')),
        'Billing' => array('foreignKey' => false, 'conditions' => array('Patient.id=Billing.patient_id', 'Billing.is_deleted=0')),
        'TariffStandard' => array('foreignKey' => false, 'conditions' => array('TariffStandard.id=Patient.tariff_standard_id')),
        'User' => array('foreignKey' => false, 'conditions' => array('FinalBilling.bill_prepared_by=User.id')),
        "UserAlias" => array('className' => 'User', "foreignKey" => false, 'conditions' => array('FinalBilling.bill_submitted_by=UserAlias.id')),
    )), false);

    $conditions1 = array(
        'Patient.is_deleted' => 0,
        // 'Patient.is_discharge' => 1,
        'Patient.is_hidden_from_report' => 0,
        'Patient.location_id' => $this->Session->read('locationid')
    );

    if (!empty($this->request->query)) {
        if (!empty($this->request->query['patient_id'])) {
            $conditions1['Patient.id'] = $this->request->query['patient_id'];
        }
        if (!empty($this->request->query['from'])) {
            $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
        }
        if (!empty($this->request->query['to'])) {
            $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
        }
        if ($from) {
            $conditions1['Patient.create_time >='] = $from;
            $conditions1['Patient.create_time >='] = $from;
        }
        if ($to) {
            $conditions1['Patient.create_time <='] = $to;
        }
        $conditions1['Patient.tariff_standard_id !='] = '7';

        if ($this->request->query['bill_options'] == 'not prepared') {
            $conditions1['Finalbilling.is_bill_finalize'] = array('0', NULL);
        } else if ($this->request->query['bill_options'] == 'not submitted') {
            $conditions1['Finalbilling.is_bill_finalize'] = '1';
            $conditions1['Finalbilling.claim_status'] = NULL;
            $conditions1['Finalbilling.dr_claim_date'] = NULL;
        }

        if ($this->params->query['tariff_standard_id']) {
            $conditions1['Patient.tariff_standard_id'] = $this->params->query['tariff_standard_id'];
        }

        if ($this->params->query['admission_type']) {
            $conditions1['Patient.admission_type'] = $this->params->query['admission_type'];
        }
    } 
    else {
        // Default condition to show data of the current day if no search query is present
        $conditions1['Patient.create_time >='] = date('Y-m-d') . ' 00:00:00';
        $conditions1['Patient.create_time <='] = date('Y-m-d') . ' 23:59:59';
        $conditions1['Patient.tariff_standard_id !='] = '7';

    }

    // Remaining code unchanged...
    $result = $this->Patient->find('all', array(
        'fields' => array(
            "SUM(CASE WHEN Billing.payment_category != 'corporateAdvance' AND Billing.payment_category != 'TDS' THEN Billing.amount ELSE 0 END) as patientPaid",
            "SUM(CASE WHEN Billing.payment_category = 'TDS'  THEN Billing.amount ELSE 0 END) as TDSPAid",
            "SUM( CASE WHEN Billing.payment_category = 'corporateAdvance' THEN Billing.amount ELSE 0 END) as advacnePAid",
            'SUM(Billing.discount_amount) as total_discount', 
            'Billing.payment_category', 'Patient.id', 'Patient.admission_type',
            'Patient.patient_id', 'Patient.admission_id', 'Patient.discharge_date', 'Patient.is_discharge',
            'Patient.lookup_name', 'Patient.form_received_on', 'Patient.person_id', 'Patient.corporate_status',
            'FinalBilling.amount_pending', 'FinalBilling.total_amount', 'PatientDocument.id', 'PatientDocument.filename',
            'FinalBilling.dr_claim_date', 'TariffStandard.name', 'FinalBilling.id, FinalBilling.use_duplicate_sales',
            'FinalBilling.expected_amount', 'FinalBilling.is_bill_finalize', 'FinalBilling.claim_status',
            'FinalBilling.dr_claim_date', 'FinalBilling.bill_uploading_date', 'Patient.five_day_reminder',
            'Patient.twelve_day_reminder', 'Patient.twelve_day_noc_taken', 'Patient.five_day_noc_taken',
            'FinalBilling.bill_prepared_by', 'FinalBilling.billing_link', 'FinalBilling.nmi',
            'FinalBilling.nmi_date', 'FinalBilling.nmi_answered', 'FinalBilling.bill_submitted_by',
            'FinalBilling.hospital_invoice_amount', 'FinalBilling.referral_letter', 'FinalBilling.reason_for_delay',
            'User.first_name', 'User.last_name', 'UserAlias.first_name', 'UserAlias.last_name', 'Patient.tariff_standard_id'
        ),
        'conditions' => $conditions1,
        'group' => array('Patient.id'),
        'order' => array('Billing.id desc')
    ));

$totalPatients = $this->Patient->find('count', array(
    'conditions' => $conditions1,
    'group' => array('Patient.id') // Same group condition as used in find('all')
));
$this->set('totalPatients', $totalPatients);
// Debug total patient count

    foreach ($result as $key => $value) {
        $data = $this->Billing->getPatientTotalBill($value['Patient']['id'], $value['Patient']['admission_type']);
        $result[$key][0]['total_amount'] = $data;
    }

    $this->set(array('results' => $result));

    $tariffData = $this->TariffStandard->find('list', array(
        'fields' => array('id', 'name'),
        'conditions' => array(
            'TariffStandard.is_deleted' => 0,
            'TariffStandard.location_id' => $this->Session->read('locationid'),
            'TariffStandard.name NOT' => 'Private'
        ),
        'order' => array('TariffStandard.name')
    ));
    $this->set('tariffData', $tariffData);

    $this->set('tariffStandardID', $this->params->query['tariff_standard_id']);

    if ($this->request->isAjax()) {
        $this->layout = 'ajax';
        $this->render('ajax_other_outstanding_report');
    }
    if ($this->params->pass[1] == 'excel' || $this->params->pass[0] == 'excel') {
        $this->autoRender = false;
        $this->layout = false;
        $this->render('admin_other_corporate_xls', false);
    }
}


public function admin_corporate_vice_patient() {
    $this->layout = 'advance';

    $this->uses = array('Patient', 'TariffStandard');

    $currentYear = date('Y'); // Current year
    $conditions = array(
        'Patient.is_deleted' => 0,
        'Patient.is_hidden_from_report' => 0,
        'Patient.location_id' => $this->Session->read('locationid'),
        'YEAR(Patient.create_time)' => $currentYear // Filter only current year
    );

    // Fetch data with monthly grouping
    $monthlyPatientCounts = $this->Patient->find('all', array(
        'fields' => array(
            'TariffStandard.id', // TariffStandard ID
            'TariffStandard.name', // TariffStandard Name
            'MONTH(Patient.create_time) as month', // Month of creation
            'COUNT(Patient.id) as patient_count' // Patient count for the month
        ),
        'conditions' => $conditions,
        'joins' => array(
            array(
                'table' => 'tariff_standards', // TariffStandard table
                'alias' => 'TariffStandard',
                'type' => 'LEFT', // Left join to include all TariffStandard IDs
                'conditions' => 'Patient.tariff_standard_id = TariffStandard.id'
            )
        ),
        'group' => array('TariffStandard.id', 'MONTH(Patient.create_time)'), // Group by TariffStandard ID and month
        'order' => array('TariffStandard.id ASC', 'MONTH(Patient.create_time) ASC') // Sort by TariffStandard ID and month
    ));

    $this->set('monthlyPatientCounts', $monthlyPatientCounts);
}


public function admin_month_outstanding_report($typeId = NULL) { 
    // debug($this->request->query);
    $this->layout = 'advance';

    $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'PatientCard');
    //$tariffID=$this->TariffStandard->getTariffStandardID($typeId);
    $this->Patient->unBindModel(array(
        'hasMany' => array('PharmacySalesBill', 'InventoryPharmacySalesReturn')));

    $this->Patient->bindModel(array('belongsTo' => array(
            'PatientDocument' => array('foreignKey' => false, 'conditions' => array('PatientDocument.patient_id=Patient.id')),
            )));

    $this->Patient->bindModel(array('belongsTo' => array(
            'PatientCard' => array('foreignKey' => false, 'conditions' => array('PatientCard.person_id=Patient.person_id')),
            'FinalBilling' => array('type' => 'LEFT', 'foreignKey' => false, 'conditions' => array('FinalBilling.Patient_id=Patient.id')),
            'Billing' => array('foreignKey' => false, 'conditions' => array('Patient.id=Billing.patient_id', 'Billing.is_deleted=0')),
            'TariffStandard' => array('foreignKey' => false, 'conditions' => array('TariffStandard.id=Patient.tariff_standard_id')),
            'User'=>array('foreignKey'=>false,'conditions'=>array('FinalBilling.bill_prepared_by=User.id')),
            "UserAlias"=>array('className'=>'User',"foreignKey"=>false ,'conditions'=>array('FinalBilling.bill_submitted_by=UserAlias.id')),
            )), false);


    $conditions1 = array('Patient.is_deleted' => 0, 'Patient.is_discharge' => 1, 'Patient.is_hidden_from_report' => 0,
        'Patient.location_id' => $this->Session->read('locationid'));

    if (!empty($this->request->query)) {
        // debug($this->request->query);
        //unset($conditions1['Patient.is_hidden_from_report']);
        if (!empty($this->request->query['patient_id'])) {
            $conditions1['Patient.id'] = $this->request->query['patient_id'];
        }
        if (!empty($this->request->query['from'])) {
            $from = $this->DateFormat->formatDate2STD($this->request->query['from'], Configure::read('date_format')) . " 00:00:00";
        }
        if (!empty($this->request->query['to'])) {
            $to = $this->DateFormat->formatDate2STD($this->request->query['to'], Configure::read('date_format')) . " 23:59:59";
        }
        if ($from)
            $conditions1['Patient.discharge_date >='] = $from;
        if ($to)
            $conditions1['Patient.discharge_date <='] = $to;
            $conditions1['Patient.tariff_standard_id !='] = '7';
            // debug($conditions1);
        
//  debug($this->request->query);exit;
        if($this->request->query['bill_options']=='not prepared'){
            $conditions1['Finalbilling.is_bill_finalize'] =array('0',NULL);
            //$conditions1['Finalbilling.bill_uploading_date']=NULL;
        }else if($this->request->query['bill_options']=='not submitted'){
            $conditions1['Finalbilling.is_bill_finalize'] = '1';
            $conditions1['Finalbilling.claim_status']=NULL;
            $conditions1['Finalbilling.dr_claim_date']=NULL;
        }

        if($this->params->query['tariff_standard_id']){ 
            $conditions1['Patient.tariff_standard_id']= $this->params->query['tariff_standard_id'];
        }

        if($this->params->query['admission_type']){ 
            $conditions1['Patient.admission_type']= $this->params->query['admission_type'];
            // debug($conditions1);
        }


    }else{
       if (empty($from))
            $conditions1['Patient.discharge_date >='] = date('Y-m-d').' 00:00:00';
        if (empty($to))
            $conditions1['Patient.discharge_date <='] = date('Y-m-d').' 23:59:59';  
    }
     if ($this->params->pass[1] == 'excel' || $this->params->pass[0] == 'excel') {
        $result = $this->Patient->find('all',array('fields'=>array("SUM(CASE WHEN Billing.payment_category != 'corporateAdvance' AND Billing.payment_category != 'TDS' THEN Billing.amount ELSE 0 END) as patientPaid",
            "SUM(CASE WHEN Billing.payment_category = 'TDS'  THEN Billing.amount ELSE 0 END) as TDSPAid",
            "SUM( CASE WHEN Billing.payment_category = 'corporateAdvance' THEN Billing.amount ELSE 0 END) as advacnePAid",
            //"SUM( CASE WHEN PatientCard.type = 'Corporate Advance' THEN PatientCard.amount ELSE 0 END) as advacneCardPAid",
            'SUM(Billing.discount_amount) as total_discount', 'Billing.payment_category','Patient.id','Patient.admission_type' ,'Patient.patient_id',
            'Patient.admission_id', 'Patient.discharge_date',  'Patient.is_discharge', 'Patient.lookup_name', 'Patient.form_received_on', 'Patient.person_id','Patient.corporate_status',
            'FinalBilling.amount_pending', 'FinalBilling.total_amount', 'PatientDocument.id', 'PatientDocument.filename','FinalBilling.dr_claim_date','TariffStandard.name','FinalBilling.id, FinalBilling.use_duplicate_sales','FinalBilling.expected_amount','','FinalBilling.is_bill_finalize','FinalBilling.claim_status','FinalBilling.dr_claim_date','FinalBilling.bill_uploading_date','Patient.five_day_reminder','Patient.twelve_day_reminder','Patient.twelve_day_noc_taken','Patient.five_day_noc_taken','FinalBilling.bill_prepared_by','FinalBilling.billing_link','FinalBilling.nmi','FinalBilling.nmi_date','FinalBilling.nmi_answered','FinalBilling.bill_submitted_by','FinalBilling.hospital_invoice_amount','FinalBilling.referral_letter','FinalBilling.reason_for_delay','User.first_name','User.last_name','UserAlias.first_name','UserAlias.last_name','Patient.tariff_standard_id'),'conditions'=>$conditions1,'group' => array('Patient.id'),
        'order' => array('Billing.id desc')));
        // debug($result);exit;
     }else{
       $result = $this->Patient->find('all',array('fields'=>array("SUM(CASE WHEN Billing.payment_category != 'corporateAdvance' AND Billing.payment_category != 'TDS' THEN Billing.amount ELSE 0 END) as patientPaid",
            "SUM(CASE WHEN Billing.payment_category = 'TDS'  THEN Billing.amount ELSE 0 END) as TDSPAid",
            "SUM( CASE WHEN Billing.payment_category = 'corporateAdvance' THEN Billing.amount ELSE 0 END) as advacnePAid",
            //"SUM( CASE WHEN PatientCard.type = 'Corporate Advance' THEN PatientCard.amount ELSE 0 END) as advacneCardPAid",
            'SUM(Billing.discount_amount) as total_discount', 'Billing.payment_category','Patient.id','Patient.admission_type' ,'Patient.patient_id',
            'Patient.admission_id', 'Patient.discharge_date',  'Patient.is_discharge', 'Patient.lookup_name', 'Patient.form_received_on', 'Patient.person_id','Patient.corporate_status',
            'FinalBilling.amount_pending', 'FinalBilling.total_amount', 'PatientDocument.id', 'PatientDocument.filename','FinalBilling.dr_claim_date','TariffStandard.name','FinalBilling.bill_number','FinalBilling.id, FinalBilling.use_duplicate_sales','FinalBilling.expected_amount','FinalBilling.is_bill_finalize','FinalBilling.claim_status','FinalBilling.dr_claim_date','FinalBilling.bill_uploading_date','Patient.five_day_reminder','Patient.twelve_day_reminder','Patient.twelve_day_noc_taken','Patient.five_day_noc_taken','FinalBilling.bill_prepared_by','FinalBilling.billing_link','FinalBilling.nmi','FinalBilling.nmi_date','FinalBilling.nmi_answered','FinalBilling.bill_submitted_by','FinalBilling.hospital_invoice_amount','FinalBilling.referral_letter','FinalBilling.reason_for_delay','User.first_name','User.last_name','UserAlias.first_name','UserAlias.last_name','Patient.tariff_standard_id'),'conditions'=>$conditions1,'group' => array('Patient.id'),
        'order' => array('Billing.id desc')));
     }
    


foreach ($result as $key => $value) {
    
    $data = $this->Billing->getPatientTotalBill($value['Patient']['id'],$value['Patient']['admission_type']);
    $result[$key][0]['total_amount'] = $data;
}
    $this->set(array('results' => $result, 'patientCardData' => $patientCardData/* ,'paidByPatient'=>$paidByPatient */));

    $tariffData = $this->TariffStandard->find('list', array('fields' => array('id', 'name'), 'conditions' => array('TariffStandard.is_deleted' => 0, /* 'TariffStandard.code_name IS NOT NULL', */'TariffStandard.location_id' => $this->Session->read('locationid'), 'TariffStandard.name NOT' => 'Private'),'order'=>array('TariffStandard.name')));
    $this->set('tariffData', $tariffData);

    $this->set('tariffStandardID', $this->params->query['tariff_standard_id']);
    if ($this->request->isAjax()) {
        $this->layout = 'ajax';
        $this->render('ajax_month_outstanding_report');
    }
    if ($this->params->pass[1] == 'excel' || $this->params->pass[0] == 'excel') {
        $this->autoRender = false;
        $this->layout = false;
        $this->render('admin_month_corporate_xls', false);
    }
}

public function admin_updateReason() {
    $this->autoRender = false;
    $this->layout = 'ajax';
      $this->uses = array('Patient', 'TariffStandard', 'FinalBilling', 'Billing', 'PatientCard');
    
    if ($this->request->is('post')) {
        $billId = $this->request->data['bill_id'];
        $reason = $this->request->data['reason_for_delay'];
        
        $this->FinalBilling->id = $billId;
        if ($this->FinalBilling->saveField('reason_for_delay', $reason)) {
            echo json_encode(['status' => 'success', 'message' => 'Updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
    }
}




    
    
} 
?>