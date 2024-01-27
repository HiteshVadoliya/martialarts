<?php

namespace App\Controllers\Cron;

use App\Controllers\BaseController;
use App\Models\Admin\CallLog;
use App\Models\Admin\Campaign;
use App\Models\Admin\Question;
use App\Models\Admin\User;
use CodeIgniter\Files\File;
use CodeIgniter\Config\Services;

class CallLogController extends BaseController
{
    public function import_store() {
        $inputDir = FCPATH.'files/';
        $processedDir = FCPATH.'files/processed/';
        $recordingDir = FCPATH.'recordings/';
        
        // Get a list of .txt files in the input directory
        $files = glob($inputDir . '*.txt');
        
        if (empty($files)) {
            return $this->response->setStatusCode(422)->setJSON([
                'errors' => "No .txt files found in the input directory.\n"
            ]);
        } 

        $db = \Config\Database::connect();

        // Load the file helper
        helper('file');

          // Start a database transaction
          $db->transStart();
        try {

            $total = [
                'total' => 0,
                'insert' => 0,
                'update' => 0,
                'user' => 0,
                'campaign' => 0
            ];
            foreach ($files as $file) {
                // Read the uploaded file
                $data = file_get_contents($file);

                $path = explode('/', $file);
                $filename = end($path);
                
                // Split the file content into an array of rows
                $rows = explode("\n", $data);
    
                
                // Iterate through the rows and insert data into the database
                foreach ($rows as $i => $row) {
                    $columns = explode("\t", $row);

                    if($i == 0)
                    {
                        continue;
                    }

                    if(empty($columns[49]) || !is_numeric($columns[3]))
                    {
                        continue;
                    }

                    
                    $Agent = $columns[3] ?? "";
                    $full_name = $columns[4] ?? "";
                    $Call_Date = $columns[0] ?? "";
                    $Campaign = $columns[5] ?? "";
                    $Recording_location = $columns[46] ?? "";
                    $Uniqueid = $columns[49];
                    $Status_name = $columns[43] ?? "";
                    $company = 1;
                    
                    

                    if($Recording_location == "")
                    {
                        $Recording_location = "NOTFOUND";   
                    }else{
                        $recording_path = explode('/', $Recording_location);
                        $recording_filename = end($recording_path);

                        $rfiles = glob($recordingDir ."*/". $recording_filename);
                        
                        if(count($rfiles) > 0)
                        {
                            $Recording_location = $rfiles[0];   

                        }else{
                            $Recording_location = "NOTFOUND";   
                        }
                    }

                    
                    $campaignModel = new Campaign();
                    $dataCampaign = $campaignModel->where('Camp_id',$Campaign)->get();
                    
                    if($dataCampaign->getRow() == NULL)
                    {
                        $campaignModelInsert = new Campaign();
                        $campaignModelInsert->save([
                            'Camp_id' => $Campaign,
                            'Camp_Name' => $Campaign,
                            'Client_id' => 1
                        ]);
                        $total['campaign'] += 1;
                    }

                    $callLogModel = new CallLog();
                    $dataCallLog = $callLogModel->where('Uniqueid',$Uniqueid)->get();

                    $userModel = new User();
                    $dataUser = $userModel->where('user_id',$Agent)->get();
                    
                    if($dataUser->getRow() == NULL)
                    {
                        $userModelInsert = new User();
                        $userModelInsert->save([
                            'user_id' => $Agent,
                            'user_role_id' => '2',
                            'fname' => $full_name,
                            'username' => $Agent,
                            'password' => password_hash($Agent, PASSWORD_BCRYPT)
                        ]);
                        $total['user'] += 1;
                    }
                    
                    if($dataCallLog->getRow() == NULL)
                    {
                        $clInsertModel = new CallLog();
                        $dataInsert = [
                            'Agent' => $Agent,
                            'Call_date' => $Call_Date,
                            'Campaign' => $Campaign,
                            'Recording' => $Recording_location,
                            'Uniqueid' => $Uniqueid,
                            'Dispo' => $Status_name,
                            'company' => $company,
                        ];
                        $clInsertModel->save($dataInsert);

                        $total['insert'] += 1;
                    }else{
                        $clUpdateModel = new CallLog();
                        $data = [
                            'Agent' => $Agent,
                            'Call_date' => $Call_Date,
                            'Campaign' => $Campaign,
                            'Recording' => $Recording_location,
                            'Dispo' => $Status_name,
                            'company' => $company,
                        ];
                        $clUpdateModel->update($Uniqueid,$data);
                        $total['update'] += 1;
                    }
                }
                $fileHelper = new \CodeIgniter\Files\File($file);
                $fileHelper->move($processedDir);
                
                $db->transCommit();

            }
            return $this->response->setJSON(['message' => 'Call Log saved successfully','data' => $total]);
        } catch (\Throwable $th) {
            throw $th;
            $db->transRollback();
        }


    }
}
