<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\Transcription;
use CodeIgniter\Config\Services;

class TranscriptionController extends BaseController
{
    public function __construct() {
        $session = Services::session();
        if ($session->get('is_admin_login') == NULL) {
            header('Location: '.base_url('auth/login'));
            exit();
        }
    }
    function purge_cc() {
        $transcriptionModel = new Transcription();
        $transcriptions = $transcriptionModel
        ->join('Call_log cl', "cl.Uniqueid = Transcriptions.Uniqueid", 'left')
        ->where('Transcriptions.Trans_engine',3)->where('Transcriptions.status',4)->limit(10)->findAll();

        $payments = [
            'American Express',
            'AmericanExpress',
            'Visa',
            'Master Card',
            'MasterCard',
            'AMEX'
        ];

        foreach ($transcriptions as $transcription) {
            // echo "<pre>";
            $json = json_decode($transcription['JSON_Data']); $timeend = 0; $last_participant = "";
            $transcription_text = ""; $start = 0; $end = 0; $show = true;

            if(empty($json->sentenceSegments))
            {
                continue;
            }

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