<?php

/**
 *  Controller : persons
 *  Use : AEDV- UID_patients
 *  @created by :pankaj wanjari
 *  @created on :07 Dec 2011
 *  functions : add,edit,view,search of UID_patient
 *ic
 **/
class MarketTeamController extends AppController
{

    public $name = 'MarketTeam';
    public $helpers = array('Html', 'Form');
    public $components = array('RequestHandler', 'Email', 'ImageUpload', 'DateFormat', 'QRCode', 'GibberishAES');

    // public function beforeFilter() {
    // 	$this->Auth->allow('certificate','certificate_form','quickReg','getStateCity','getAgeFromDob','generateQrCode','emergencyReg','emergency_reg','patient_registration','generate_qr','typeformreg');
    // }
    // Controller Code Example:
    public function initializeDatabase()
    {
        $userSession = $this->Session->read('Auth.User');
        $userDatabase = $this->Session->read('db_name');
        return $userDatabase;
    }

    public function index()
    {
        $this->layout='advance';
        $this->uses = array('MarketingTeam', 'State', 'Account', 'TariffList', 'Billing', 'User', 'Person', 'Location', 'ServiceBill', 'CouponTransaction');
        $conditions = array('MarketingTeam.is_deleted' => 0);
        $this->set('marketingTeams', $this->MarketingTeam->find('all', array(
            'conditions' => $conditions,
            'order' => array('MarketingTeam.id' => 'DESC')
        )));
    }

    public function add()
    {
        $this->uses = array('MarketingTeam', 'State', 'Account', 'TariffList', 'Billing', 'User', 'Person', 'Location', 'ServiceBill', 'CouponTransaction');
        if ($this->request->is('post')) {
            $this->MarketingTeam->create();
    
            // Handle file upload
            if (!empty($this->request->data['MarketingTeam']['photo']['name'])) {
                $photo = $this->request->data['MarketingTeam']['photo'];
                $filePath = 'path_to_your_upload_folder/' . $photo['name'];
                move_uploaded_file($photo['tmp_name'], $filePath);
                $this->request->data['MarketingTeam']['photo'] = $filePath;
            }
    
            // Save the data
            if ($this->MarketingTeam->save($this->request->data)) {
                $this->Session->setFlash('Team member added.');
                return $this->redirect(array('action' => 'index'));
            }
        }
    }


    public function edit($id = null)
    {
        $this->uses = array('MarketingTeam', 'State', 'Account', 'TariffList', 'Billing', 'User', 'Person', 'Location', 'ServiceBill', 'CouponTransaction');
        if (!$id) throw new NotFoundException(__('Invalid ID'));
        $team = $this->MarketingTeam->findById($id);
        if (!$team) throw new NotFoundException(__('Member not found'));
    
        if ($this->request->is(array('post', 'put'))) {
            // Handle file upload for editing
            if (!empty($this->request->data['MarketingTeam']['photo']['name'])) {
                $photo = $this->request->data['MarketingTeam']['photo'];
                $filePath = 'path_to_your_upload_folder/' . $photo['name'];
                move_uploaded_file($photo['tmp_name'], $filePath);
                $this->request->data['MarketingTeam']['photo'] = $filePath;
            }
    
            $this->MarketingTeam->id = $id;
            if ($this->MarketingTeam->save($this->request->data)) {
                $this->Session->setFlash('Updated successfully.');
                return $this->redirect(array('action' => 'index'));
            }
        }
    
        $this->request->data = $team;
    }

    public function delete($id = null)
    {
        $this->uses = array('MarketingTeam', 'State', 'Account', 'TariffList', 'Billing', 'User', 'Person', 'Location', 'ServiceBill', 'CouponTransaction');

        if (!$id) throw new NotFoundException(__('Invalid ID'));
        if ($this->request->is('post') || $this->request->is('put')) {
            // Soft delete
            $this->MarketingTeam->id = $id;
            if ($this->MarketingTeam->saveField('is_deleted', 1)) {
                $this->Session->setFlash('Member deleted (soft delete).');
            }
            return $this->redirect(array('action' => 'index'));
        }
    }

    public function view($id = null)
    {
        $this->layout = false;
        $this->uses = array('MarketingTeam', 'State', 'Referal', 'TariffList', 'Billing', 'User', 'Person', 'Location', 'ServiceBill', 'CouponTransaction');
     
        if (!$id) throw new NotFoundException(__('Invalid ID'));
        $team = $this->MarketingTeam->findById($id);
        if (!$team) throw new NotFoundException(__('Member not found'));
        $this->set('team', $team);
        //fetch leads data
        $database = $this->initializeDatabase();
        $this->Referal->useDbConfig = $database;
        $leads = $this->Referal->find('all', [
            'conditions' => ['Referal.marketing_agent_id' => $id]
        ]);
     
        // $leads = $this->Referal->find('all', [
        //     'conditions' => ['Referal.marketing_agent_id' => $id],
        //     'joins' => [
        //         [
        //             'table' => 'consultants',
        //             'alias' => 'Consultant',
        //             'type' => 'LEFT', // Change INNER to LEFT for including non-matching rows
        //             'conditions' => 'Referal.agent_id = Consultant.id'
        //         ]
        //     ],
        //     'fields' => ['Referal.*', 'Consultant.first_name', 'Consultant.last_name', 'Consultant.id']
        // ]);
        
        $this->set('leads', $leads);

        
    }

    public function getLeads() {
        $this->uses = array('MarketingTeam', 'Referal', 'Account', 'TariffList', 'Billing', 'User', 'Person', 'Location', 'ServiceBill', 'CouponTransaction');
        $this->autoRender = false;
        $this->loadModel('Referal');
        // $marketing_team_id = $this->request->query('marketingTeamId');
      
        $leads = $this->Referal->find('all', [
            'conditions' => ['Referal.marketing_agent_id' => 1]
        ]);
    
        $data = [];       
        foreach ($leads as $lead) {
            $data[] = [
                'id' => $lead['Referal']['id'],
                'name' => $lead['Referal']['name'],
                'agent_id' => $lead['Referal']['agent_id'],
                'mobile' => $lead['Referal']['mobile'], 
                'status' => $lead['Referal']['status'], 
                'action' => '<button class="btn btn-info btn-sm">View</button>'
            ];
        }
    
        // Return JSON response
        $recordsTotal = count($data);  
        $recordsFiltered = count($data); 
    
        echo json_encode([
            'draw' => 1,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }
    
    
  
    
    
    public function marketing_dashboard()
    {
        $this->uses = array('MarketingTeam', 'State', 'Account', 'TariffList', 'Billing', 'User', 'Person', 'Location', 'ServiceBill', 'CouponTransaction');
        App::import('Vendor', 'DrmhopeDB');
        $database = $this->initializeDatabase();

        $market_team  = $this->MarketingTeam->find('all', array(
            'fields' => array('MarketingTeam.*'),
            'order' => array('MarketingTeam.id' => 'desc')
        ));

        debug($market_team);
        exit;
    }

    public function leads_upload() {
        $this->autoRender = false;
    
        if ($this->request->is('post')) {
            $this->loadModel('Referal');
            $file = $this->request->data['Consultant']['excel_file'];
    
            // Check if file is uploaded
            if ($file['error'] !== 0) {
                $this->Session->setFlash(__('Please upload a valid file.'), 'default', array('class' => 'error'));
                return $this->redirect($this->referer());
            }
    
            // Validate file extension
            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, ['xls', 'csv'])) {
                $this->Session->setFlash(__('Only .xls and .csv files are allowed.'), 'default', array('class' => 'error'));
                return $this->redirect($this->referer());
            }
    
            // Path to save the uploaded file
            $path = WWW_ROOT . 'uploads/import/' . $file['name'];
            move_uploaded_file($file['tmp_name'], $path);
            chmod($path, 0777);
    
            $referals = [];
    
            // Process .csv file
            if ($fileExtension === 'csv') {
                if (($handle = fopen($path, 'r')) !== false) {
                    $row = 0;
                    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                        $row++;
                        if ($row === 1) {
                            // Skip the header row
                            continue;
                        }
                        $referals[] = [
                            'Referal' => [
                                'name' => $data[0],         // Column 1: Name
                                'mobile' => $data[1],       // Column 2: Mobile
                                'created_time' => $data[2], // Column 3: Created Time
                                'agent_id' => $data[3],     // Column 4: Agent ID
                            ]
                        ];
                    }
                    fclose($handle);
                }
            }
    
            // Process .xls file
            elseif ($fileExtension === 'xls') {
                App::import('Vendor', 'reader'); // Assuming 'reader.php' is in Vendor folder
                $data = new Spreadsheet_Excel_Reader();
                $data->setOutputEncoding('CP1251');
                $data->read($path);
    
                for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
                    $referals[] = [
                        'Referal' => [
                            'name' => $data->sheets[0]['cells'][$i][1],        // Column A: Name
                            'mobile' => $data->sheets[0]['cells'][$i][2],      // Column B: Mobile
                            'created_time' => $data->sheets[0]['cells'][$i][3],// Column C: Created Time
                            'agent_id' => $data->sheets[0]['cells'][$i][4],    // Column D: Agent ID
                        ]
                    ];
                }
            }
    
            // Save data to database
            if ($this->Referal->saveAll($referals)) {
                unlink($path); // Delete the uploaded file
                $this->Session->setFlash(__('Leads uploaded successfully.'), 'default', array('class' => 'success'));
                return $this->redirect($this->referer());
            } else {
                unlink($path); // Delete the uploaded file
                $this->Session->setFlash(__('Error occurred while saving data. Please check your file.'), 'default', array('class' => 'error'));
                return $this->redirect($this->referer());
            }
        }
    
        $this->Session->setFlash(__('No data found to process.'), 'default', array('class' => 'error'));
        return $this->redirect($this->referer());
    }

}
