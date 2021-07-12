<?php

namespace App\Jobs;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Audio ;


class ExtractMp3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $audio;

    protected $ffmpeg;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Audio $audio)
    {
        $this->audio = $audio;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ffmpeg = FFMpeg::create(array(
            'ffmpeg.binaries'  => env('FFMPEG','/usr/bin/ffmpeg'),
            'ffprobe.binaries' => env('FFPROBE','/usr/bin/ffprobe'),
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ));

        $audio = $this->audio;
        try{
            $advancedMedia = $ffmpeg->openAdvanced(
                array($audio->mp3_url)
            );
            $advancedMedia->map(array('0:a'),  new Mp3(),storage_path($audio->audio_id.'.mp3') )
                ->save();
            $audio->status = 1;
            $audio->save();
        }catch (\Exception $e){
            $this->failed($e);
        }

    }

    public function faild($e){
        Log::error($e);
    }

}
