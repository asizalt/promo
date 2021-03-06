<?php

namespace App\Http\Controllers;
use App\Jobs\ExtractMp3;
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

    public function promo2mp3(Request $request,GoutteService $GoutteService){

        $promo_template = ($request->get('category'));

        $audio = Audio::where('template_name',$promo_template)
            ->where('status',1)
            ->latest()->first();

        if($audio)
            return response()->json(['id'=>$audio->audio_id,'mp3' => $audio->mp3]);

        $category = $GoutteService->get_category($promo_template);

        if(!$category)
            return response()->json(['error' => 'no such Category'],404);


         $first_image =  $GoutteService->validateUrl($category);

        if(!$first_image)
            return response()->json(['error' => 'Invalid Template Category'],404);

        list($id,$audio_url) = $GoutteService->getUrl($first_image);

        $AudioModel = Audio::create([
            "audio_id" => $id,
            "template_name" => $promo_template,
            'mp3_url' => $audio_url,
            'mp3' => url("/api/mp3/{$id}.mp3")
        ]);


        ExtractMp3::dispatch($AudioModel);

        return response()->json(['id'=>$id,'mp3' => url("api/mp3/{$id}.mp3")]);



    }

    public function mp3(Request $request,$file_id){

        $path=storage_path().'/'.$file_id.'.mp3';

        if (!file_exists($path))
            return response()->json(['error' => 'file does not Exists'],404);

        $response = new BinaryFileResponse($path);
        BinaryFileResponse::trustXSendfileTypeHeader();

        return $response;
    }

}
