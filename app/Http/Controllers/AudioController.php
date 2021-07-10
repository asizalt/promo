<?php

namespace App\Http\Controllers;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
//use GuzzleHttp\Client as GuzzleClient;
use FFMpeg\FFMpeg;
use FFMpeg\Format\FormatInterface;
use Goutte\Client;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;
//use ProtoneMedia\LaravelFFMpeg\Filesystem\Media;
//use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\FFMpeg\CopyFormat;
class AudioController extends ApiController
{

    public function promo2mp3(Request $request){

        $promo_template = $request->get('promo_template');

        //query db if url is there and file is there.

        $goutteClient = new Client();
        $crawler = $goutteClient->request(
            'GET', env('PROMO_URL','https://promo.com/templates/').'/'.$promo_template
        );

        $first_image = $crawler->filter('.video-item__thumbnail')->attr('data-src');

        $uri_parts = explode('/', $first_image);
        $end_uri = end($uri_parts);
        $id = substr($end_uri, 0, strpos($end_uri, '-'));

        $mp4_url = str_replace(array('collections', '--thumb-small.jpg?dv=4'),
            array('promoVideos', '/preview.mp4?dv=4'), $first_image);


        try{
            $ffmpeg = FFMpeg::create(array(
                'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
                'ffprobe.binaries' => '/usr/bin/ffprobe',
                'timeout'          => 3600, // The timeout for the underlying process
                'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
            ));
            $advancedMedia = $ffmpeg->openAdvanced(
                array('https://ak02-video-cdn.slidely.com/promoVideos/videos/5e/3a/5e3a8a2b91fbb372d44236b3/preview.mp4?dv=4')
            );
            $advancedMedia->map(array('0:a'),  new Mp3(),storage_path('output.mp3') )
                ->save();
    }catch (\Exception $e){
            dd($e);
        }


        dd('finished');

    }

    public function mp3(Request $request,$file_id){

        $path=storage_path().'/output.mp3';
        $response = new BinaryFileResponse($path);
        BinaryFileResponse::trustXSendfileTypeHeader();

        return $response;
    }

}
