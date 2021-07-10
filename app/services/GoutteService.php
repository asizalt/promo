<?php
namespace App\services;
use Goutte\Client;


class GoutteService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function validateUrl($promo_template ){
        $crawler = $this->client->request(
            'GET', env('PROMO_URL','https://promo.com/templates').'/'.$promo_template
        );

        try {
            $first_image = $crawler->filter('.video-item__thumbnail')->attr('data-src');
        }catch (\Exception $e){
            return null;
        }

        return $first_image;

    }

    public function getUrl($first_image){

        $uri_parts = explode('/', $first_image);
        $end_uri = end($uri_parts);
        $id = substr($end_uri, 0, strpos($end_uri, '-'));

        $mp4_url = str_replace(array('collections', '--thumb-small.jpg?dv=4'),
            array('promoVideos', '/preview.mp4?dv=4'), $first_image);

        return array($id,$mp4_url);
    }


}
