<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\CallLog;
use App\Models\Admin\Campaign;
use App\Models\Admin\GlobalSetting;
use App\Models\Admin\Question;
use App\Models\Admin\Transcription;
use App\Models\Admin\User;
use CodeIgniter\Files\File;
use CodeIgniter\Config\Services;

class CallLogController extends BaseController
{
    public function __construct() {
        $session = Services::session();
        if ($session->get('is_admin_login') == NULL) {
            header('Location: '.base_url('auth/login'));
            exit();
        }
    }

    public function upload()
    {
        $data['pg_title'] = 'Upload Purge CC Data';
        
        return view('admin/call_log/upload', $data);
    }

    function upload_store() {
        $file = $this->request->getFile('file');

        if (! $this->validate([
            'file' => "uploaded[file]|mime_in[file,audio/mpeg,audio/wav,audio/mp3,application/x-font-gdos]"
        ])) {
            return $this->response->setStatusCode(422)->setJSON([
                'errors' => $this->validator->getErrors(),
                'message' => "Please upload audio file"
            ]);
        }

        $recordingDir = FCPATH.'recordings/';
        $file = $this->request->getFile('file');
        $file->move($recordingDir);


        // Create a new CampaignModel instance
        $callLogModel = new CallLog();

        $Uniqueid = chr(rand(65,90)).gettimeofday(true);
        // Assuming you have form data, you can validate and save it
        $data = [
            'Uniqueid' => $Uniqueid,
            'Dispo' => "SPCCD",
            'Company' => "2",
            'Recording' => "recordings/".$file->getName()
        ];

        $callLogModel->save($data);

        $trans_id = $this->setTranscription('9b3f950c-4d24-40fb-8bb6-270372af612b',"https://augmentedqa.com/staging/recordings/20080605-061443_THEO1.mp3",$Uniqueid);
        $this->checkStatus('9b3f950c-4d24-40fb-8bb6-270372af612b',$trans_id);
        return $this->response->setJSON(['message' => 'Data saved successfully']);
    }

    public function import()
    {
        $data['pg_title'] = 'Augmented QA Call Log Import';
        
        return view('admin/call_log/import', $data);
    }

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
                            $Recording_location = str_replace(FCPATH,"",$rfiles[0]);   
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

                    //update import
                    $userModel = new User();
                    $dataUser = $userModel->where('phonesys_id',$Agent)->get();
                    if($dataUser->getRow() == NULL)
                    {
                        $userModelInsert = new User();
                        $userModelInsert->save([
                            'phonesys_id' => $Agent,
                            'user_role_pid' => '4',
                            'fname' => $full_name,
                            'username' => $Agent,
                            'password' => password_hash($Agent, PASSWORD_BCRYPT),
                            'is_active' => 1
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

    function setTranscription( $token, $audio_file,$Uniqueid )
    {
        
        /* Get interactionIdentifier */

        $metadata = [
        "type" => "audio", 
        "languageTag" => "en-US", 
        "vertical" => "default", 
        "audioTranscriptionMode" => "highAccuracy", 
        "downloadUri" => $audio_file, 
        "includeAiResults" => true 
        ];

        // "https://violaviznedu.com/Conference.wav"

        $metadata_json = json_encode($metadata);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.elevateai.com/v1/interactions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $metadata_json );

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'X-Api-Token: '.$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            $cron_1_result = curl_error($ch);
        } 

        curl_close($ch);	
        $cron_1_result = json_decode($result, true);

        if(isset($cron_1_result) && !empty($cron_1_result)) {
            $interactionIdentifier = $cron_1_result['interactionIdentifier'];
        }
    
        if( $interactionIdentifier != '' )  {        
            $transcriptionModel = new Transcription();
            $dat_transcription = [
                'Transaction_id' => $interactionIdentifier,
                'Trans_engine' => "2",
                'Status' => 1,
                'AI_Score' => 0,
                'Uniqueid' => $Uniqueid,
                'Text' => ''
            ];
            $status = $transcriptionModel->save($dat_transcription);

            $getId = $transcriptionModel->getInsertID();

            return $getId;

        }
    }
    function checkStatus( $token, $trans_id )
    {

        $dataTranscription = new Transcription();
        $data = $dataTranscription->where('Trans_id',$trans_id)->first();
        $interctionIdentifier = $data['Transaction_id'];
        
        /* Get Status */

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.elevateai.com/v1/interactions/'.$interctionIdentifier.'/status',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept-Encoding: gzip, deflate, br',
            'X-API-Token: '.$token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $result = json_decode($response, true);
        
        $process = "0";
        if($result['status'] == "declared")
        {
            $this->checkStatus($token,$trans_id);
        }

        if($result['status'] == "processed")
        {
            $this->updateTranscription($token,$interctionIdentifier);
            $process = "1";
        }
        if($process == "0")
        {
            $this->checkStatus($token,$trans_id);
        }
        die();
    }


    function updateTranscription( $token, $interctionIdentifier )
    {

        /* Get Audi to Text List */

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.elevateai.com/v1/interactions/'.$interctionIdentifier.'/transcripts/punctuated',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'X-API-Token: '.$token,
            'Content-Type: application/json',
            'Accept-Encoding: gzip, deflate, br'
        ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
        }

        curl_close($curl);

        $result = json_decode($response, true);

        $scroe_participant = array();
        if(isset($cron_3_result) && !empty($cron_3_result)) {

            $speech = $cron_3_result['sentenceSegments'];
            $speech_text = $speech_text_display = '';
            $previouse_participant = false;
            $participant_pre = '';
            if(isset($speech) && !empty($speech)) {
            foreach ($speech as $s_key => $s_value) {

                $scroe_participant[$s_value['participant']][$s_key] = $s_value['score'];            

                $speech_text = $s_value['phrase'];
                
                $startTimeOffset = date("i:s", $s_value['startTimeOffset'] / 1000);

                // $speech_text_display .= $s_value['participant']." (".$startTimeOffset.") = ".$s_value['phrase'].PHP_EOL;

                $participant = $s_value['participant'];

                if( $s_value['participant'] == $participant_pre) {
                $previouse_participant = true;
                } else {
                $previouse_participant = false;
                }
                if($previouse_participant) {
                $speech_text_display .= $s_value['phrase'].PHP_EOL;
                } else {
                $speech_text_display .= $startTimeOffset." : ".$participant." = ".$s_value['phrase'].PHP_EOL;
                $participant_pre = $s_value['participant'];
                }
            }
            }

            
            $AI_Speech_Quality = $AI_Speech_Quality_save = array();

            if(isset($scroe_participant) && !empty($scroe_participant)) {
            foreach($scroe_participant as $a_key => $sarray) {
                $avg = $this->calculateAveragePercentage( $sarray );
                $AI_Speech_Quality['participant'] = $a_key;
                $AI_Speech_Quality['score'] = $avg;
                $AI_Speech_Quality_save[] = $AI_Speech_Quality;
            }
            
            }
            $AI_Speech_Quality_json = json_encode($AI_Speech_Quality_save);
            $Text =  addslashes($speech_text_display);
            $json_data = json_encode($cron_3_result);

            $transcriptionModel = new Transcription();
            $data = $transcriptionModel->where('Transaction_id',$interctionIdentifier)->first();
            $transcriptionModel->update($data['Trans_id'],[
                'Status' => 3,
                'JSON_Data' => $json_data,
                'AI_Speech_Quality' => $AI_Speech_Quality_json,
                'Text' => $Text
            ]);

            $data = $transcriptionModel->where('Transaction_id',$interctionIdentifier)->first();
            $this->purgeCCAudio($data);
        }

    }

    function calculateAveragePercentage($array) {
        // Calculate the sum of all values in the array
        $sum = array_sum($array);
        
        // Count the number of elements in the array
        $count = count($array);
        
        // Calculate the average in percentage
        $averagePercentage = ($sum / $count) * 100;
        
        return $averagePercentage;
      }

      function purgeCCAudio($transcription){

        $payments = [
            'American Express',
            'AmericanExpress',
            'Visa',
            'Master Card',
            'MasterCard',
            'AMEX'
        ];

        $json = json_decode($transcription['JSON_Data']); $timeend = 0; $last_participant = "";
        $transcription_text = ""; $start = 0; $end = 0; $show = true;
        $transcriptionModel = new Transcription();

        if(isset($json->sentenceSegments))
        {
            $timestart = 0;
            $timeend = 0;

            $endTime = 0;
            foreach ($json->sentenceSegments as $text) {
                $starttime = $text->startTimeOffset;
                $endtime = $text->endTimeOffset;

                foreach ($payments as $word) {
                    if (strpos(strtolower($text->phrase), strtolower($word)) !== false) {
                        $start = $text->startTimeOffset;
                        $show = false;
                        $timestart = $starttime;
                    }
                }
                if (strpos(strtolower($text->phrase), strtolower("expiration")) !== false) {
                    $end = $text->startTimeOffset;
                    $show = true;
                    $timeend = $endtime;
                }

                $phrase = $text->phrase;
                
                if($show)
                {
                    $transcription_text .= $text->participant."($starttime-$endtime) = $phrase".PHP_EOL;
                }

                $endTime = ($endtime/1000);
            }

            if($timestart > 0 AND $transcription['Recording'] != "NOTFOUND")
            {
                // Path to the input audio file
                $inputFilePath = FCPATH.$transcription['Recording'];

                $temp_id = $transcription['Trans_id'];

                // Path to the output cropped audio file
                $outputFilePath_before = FCPATH.'recordings/temp/'.$temp_id.'crop1.mp3';
                $outputFilePath_after = FCPATH.'recordings/temp/'.$temp_id.'crop2.mp3';

                // Start time in seconds (trim from this point)
                $startTime1 = 0;
                // End time in seconds (trim until this point)
                $endTime1 = ($timestart/1000);

                // Calculate the duration for trimming
                $duration1 = $endTime1 - $startTime1;

                // Build the ffmpeg command
                $ffmpegCommand = "ffmpeg -y -i {$inputFilePath} -ss {$startTime1} -t {$duration1} -acodec copy {$outputFilePath_before}";

                // Execute the ffmpeg command
                exec($ffmpegCommand, $output, $returnCode);

                $startTime2 = ($timeend/1000);
                $endTime2 = ($timestart/1000);
                $duration2 = $endTime-$startTime2;

                $ffmpegCommand2 = "ffmpeg -y -i {$inputFilePath} -ss {$startTime2} -t {$duration2} -acodec copy {$outputFilePath_after}";
                
                exec($ffmpegCommand2, $output, $returnCode);

                // Path to the output combined audio file
                $outputFilePath = FCPATH.$transcription['Recording'];

                // Build the FFmpeg command
                $ffmpegCommand = "ffmpeg -y -i $outputFilePath_before -i $outputFilePath_after -filter_complex \"[0:a][1:a]concat=n=2:v=0:a=1[aout]\" -map [aout] $outputFilePath";

                // Execute the FFmpeg command
                exec($ffmpegCommand, $output, $resultCode);

                // Check for errors
                if ($resultCode === 0) {
                    echo $transcription['Trans_id'].'Audio file cropped successfully!';
                    unlink($outputFilePath_before);
                    unlink($outputFilePath_after);

                    $transcriptionModel->update($transcription['Trans_id'],array(
                        'status' => 5,
                        'Text' => $transcription_text
                    ));

                } else {
                    echo $transcription['Trans_id'].">".'Error cropping audio file. Check the FFmpeg command and try again.';
                }
            }
        }
        
      }
      
}
