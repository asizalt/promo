<?php

namespace App\Http\Controllers;
use App\Services\GoutteService;
use App\Services\FfmpegService;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Http\Request;
use FFMpeg\FFMpeg;
use Goutte\Client;
use Illuminate\Support\Str;
use App\Models\Audio;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class AudioController
 * @package App\Http\Controllers
 * I don't necessarily need dependency Injection but just for the sake of the example
 */
class AudioController extends ApiController
{
    protected $GoutteService;
    protected $FfmpegService;

    public function __construct(GoutteService $GoutteService, FfmpegService $ffmpegService){
        $this->FfmpegService = $ffmpegService;
        $this->GoutteService = $GoutteService;
    }

    public function promo2mp3(Request $request){



        $promo_template = Str::slug($request->get('category'));

        $audio = Audio::where('template_name',$promo_template)->first();

        if($audio)
            return response()->json(['id'=>$audio->audio_id,'mp3' => $audio->mp3]);

         $first_image =  $this->GoutteService->validateUrl($promo_template);

        if(!$first_image)
            return response()->json(['error' => 'Invalid Template Category'],404);

        list($id,$audio_url) = $this->GoutteService->getUrl($first_image);

        if($this->FfmpegService->extractMp3($audio_url,$id)){
            $audio = Audio::create([
               'audio_id' => $id,
               'template_name' => $promo_template,
                'mp3' => url("/posts/{$id}.mp3")
            ]);
            return response()->json(['id'=>$id,'mp3' => url("api/mp3/{$id}.mp3")]);
        }

        return response()->json(['error' => 'Extraction Process Faild'],404);


    }

    public function mp3(Request $request,$file_id){

        //query database for file id

        $path=storage_path().'/'.$file_id.'.mp3';

        if (!file_exists($path))
            return response()->json(['error' => 'file does not Exists'],404);

        $response = new BinaryFileResponse($path);
        BinaryFileResponse::trustXSendfileTypeHeader();

        return $response;
    }

}
