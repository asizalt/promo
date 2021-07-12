<?php
namespace App\services;
use FFMpeg\Format\Audio\Mp3;
use FFMpeg\FFMpeg;

class FfmpegService
{
    protected $ffmpeg;

    public function __construct()
    {
        $this->ffmpeg = FFMpeg::create(array(
            'ffmpeg.binaries'  => env('FFMPEG','/usr/bin/ffmpeg'),
            'ffprobe.binaries' => env('FFPROBE','/usr/bin/ffprobe'),
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ));
    }

    public function extractMp3($url,$id){
        try{
        $advancedMedia = $this->ffmpeg->openAdvanced(
            array($url)
        );
        $advancedMedia->map(array('0:a'),  new Mp3(),storage_path($id.'.mp3') )
            ->save();
    }catch (\Exception $e){
        return false;
    }
        return true;

    }




}
