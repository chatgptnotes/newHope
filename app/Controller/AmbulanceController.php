<?php
/**
 * AmbulanceController file
 *
 * PHP 5
 *
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Dinesh Tawade
 */

    class AmbulanceController extends AppController {
    
    public $name = 'Ambulance';
    public $uses = array('Ambulance'); 
    public $helpers = array('Html', 'Form', 'Js', 'DateFormat', 'General');
    public $components = array('RequestHandler', 'Email', 'Cookie', 'ImageUpload', 'QRCode', 'dateFormat', 'GibberishAES');

    
      public function index() {
           $this->layout = false;
    $this->loadModel('Ambulance');
    $ambulanceData = $this->Ambulance->find('all');
    $this->set('ambulanceData', $ambulanceData);
}

        public function ambu_form() {
    $this->layout = false;
    if ($this->request->is('post')) {
        $data = $this->request->data;
        $this->loadModel('Ambulance');
// debug($this->request->is('post'));exit;
        $ambulanceData = [
            'driver_id' => uniqid('driver_', true), 
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'ambulance_type' => $data['ambulance_type'],
            'ambulance_model' => $data['ambulance_model'],
            'number_plate' => $data['number_plate'],
            'ambulance_color' => $data['ambulance_color'],
            'mobile_number' => $data['mobile_number'],
            'email' => $data['email'],
            'admin_name' => $data['admin_name'],
            'admin_phone' => $data['admin_phone'],
            'admin_email' => $data['admin_email'],
            'vehicle_details' => $data['vehicle_details'],
            'photo' => 'photo',
            'ambulance_photo' => 'ambulance_photo',
            'aadhaar_front' => 'aadhaar_front',
            'aadhaar_back' => 'aadhaar_back',
            'license' => 'license',
            'vehicle_rc' => 'vehicle_rc'
        ];

         $allowedFileTypes = ['jpg', 'jpeg', 'png', 'pdf']; 
        $uploadPath = WWW_ROOT . 'images/driverphoto/'; 
        $fields = ['photo', 'ambulance_photo', 'aadhaar_front', 'aadhaar_back', 'license', 'vehicle_rc'];

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true); 
        }

        foreach ($fields as $field) {
            if (!empty($data[$field]['name'])) {
                $fileExtension = pathinfo($data[$field]['name'], PATHINFO_EXTENSION);
                if (in_array(strtolower($fileExtension), $allowedFileTypes)) {
                    if (is_uploaded_file($data[$field]['tmp_name'])) {
                        $newFileName = uniqid($field . '_', true) . '.' . $fileExtension;
                        $uploadFile = $uploadPath . $newFileName;

                        if (move_uploaded_file($data[$field]['tmp_name'], $uploadFile)) {
                            $ambulanceData[$field] = 'images/driverphoto/' . $newFileName;
                        } else {
                            $$this->Session->setFlash("Failed to move the uploaded file for " . $field);
                        }
                    } else {
                        $this->Session->setFlash("File upload issue for " . $field);
                    }
                } else {
                    $this->Session->setFlash("Invalid file type for " . $field . ". Allowed types: " . implode(', ', $allowedFileTypes));
                }
            }
        }
        if ($this->Ambulance->save($ambulanceData)) {
             $this->Session->setFlash('Ambulance details have been saved successfully.');
        } else {
            $this->Session->setFlash('Failed to save ambulance details.');
        }

        return $this->redirect(['action' => 'index']);
    }
}

// public function dispostion($driver_id = null) {
//     if ($this->request->is('post')) {
//         $data = $this->request->data;
//         // debug($this->request->data); 
//         // exit;  
//         $this->loadModel('Ambulance');
//         $ambulanceData = $this->Ambulance->find('all');
//         // debug($ambulanceData);exit;
//         $ambulanceData = array(
//             'Ambulance' => array(
//                 'call_assigned_to' => $data['call_assigned_to'],
//                 'call_timestamp' => $data['call_timestamp'],
//                 'disposition' => $data['disposition'],
//                 'sub_disposition' => $data['sub_disposition'],
//                 'outcome' => $data['outcome'],
//                 'follow_up_date' => $data['follow_up_date'],
//                 'follow_up_action' => $data['follow_up_action'],
//                 'remark' => $data['remark'],
//             )
//         );
// //  debug($ambulanceData);exit;
//         if ($this->Ambulance->save($ambulanceData)) {
//             $this->Session->setFlash('Disposition saved successfully.');
//             $this->redirect(array('action' => 'index'));
//         } else {
//             $this->Session->setFlash('Unable to save disposition.');
//         }
//     }
// }

public function dispostion($driver_id = null) {
    // Step 1: Check if driver_id exists
    if (!$driver_id) {
        throw new NotFoundException(__('Invalid Driver'));
    }

    // Step 2: Find the driver data by driver_id
    $ambulance = $this->Ambulance->findByDriverId($driver_id);
    
    if (!$ambulance) {
        throw new NotFoundException(__('Driver not found'));
    }

    // Step 3: Check if form is submitted
    if ($this->request->is('post')) {
        // Get submitted data
        $data = $this->request->data;

        // Update the ambulance data with disposition info
        $ambulance['Ambulance']['call_assigned_to'] = $data['call_assigned_to'];
        $ambulance['Ambulance']['call_timestamp'] = $data['call_timestamp'];
        $ambulance['Ambulance']['disposition'] = $data['disposition'];
        $ambulance['Ambulance']['sub_disposition'] = $data['sub_disposition'];
        $ambulance['Ambulance']['outcome'] = $data['outcome'];
        $ambulance['Ambulance']['follow_up_date'] = $data['follow_up_date'];
        $ambulance['Ambulance']['follow_up_action'] = $data['follow_up_action'];
        $ambulance['Ambulance']['remark'] = $data['remark'];
        
        // Save the updated data
        if ($this->Ambulance->save($ambulance)) {
            $this->Session->setFlash('Disposition saved successfully.');
            $this->redirect(['action' => 'index']);
        } else {
            $this->Session->setFlash('Unable to save disposition.');
        }
    }

    // Pass the ambulance data to the view for display
    $this->set('ambulance', $ambulance);
}

// public function dispostion($driver_id = null) {
//     // Step 1: Check if driver_id exists
//     if (!$driver_id) {
//         throw new NotFoundException(__('Invalid Driver'));
//     }

//     // Step 2: Find the driver data by driver_id
//     $ambulance = $this->Ambulance->findByDriverId($driver_id);
    
//     if (!$ambulance) {
//         throw new NotFoundException(__('Driver not found'));
//     }

//     // Step 3: Check if form is submitted
//     if ($this->request->is('post')) {
//         // Get submitted data
//         $data = $this->request->data;

//         // Update the ambulance data with disposition info
//         $ambulance['Ambulance']['call_assigned_to'] = $data['call_assigned_to'];
//         $ambulance['Ambulance']['call_timestamp'] = $data['call_timestamp'];
//         $ambulance['Ambulance']['disposition'] = $data['disposition'];
//         $ambulance['Ambulance']['sub_disposition'] = $data['sub_disposition'];
//         $ambulance['Ambulance']['outcome'] = $data['outcome'];
//         $ambulance['Ambulance']['follow_up_date'] = $data['follow_up_date'];
//         $ambulance['Ambulance']['follow_up_action'] = $data['follow_up_action'];
//         $ambulance['Ambulance']['remark'] = $data['remark'];
        
//         // Save the updated data
//         if ($this->Ambulance->save($ambulance)) {
//             $this->Session->setFlash('Disposition saved successfully.');
//             $this->redirect(['action' => 'index']);
//         } else {
//             $this->Session->setFlash('Unable to save disposition.');
//         }
//     }

//     // Pass the ambulance data to the view for display
//     $this->set('ambulance', $ambulance);
// }

      
public function driver_profile($driver_id = null) {
    if (!$driver_id) {
        $this->Session->setFlash('Invalid driver ID');
        return $this->redirect(['action' => 'index']);
    }

    $this->loadModel('Ambulance');
    $ambulanceData = $this->Ambulance->findByDriverId($driver_id);
    if (!$ambulanceData) {
        $this->Session->setFlash('Driver not found.');
        return $this->redirect(['action' => 'index']);
    }

    $this->set('ambulanceData', $ambulanceData);
}


}