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

    public function get_category($promo_template){

        $crawler = $this->client->request(
            'GET', env('PROMO_URL','https://promo.com/templates')
        );

        try {
            $name = $crawler->filter("a:contains($promo_template)")->attr('href');
        }catch (\Exception $e){
            return null;
        }

        $uri_parts = explode('/', $name);

        $id = substr($uri_parts[2], 0, strpos($uri_parts[2], '?'));

       return $id;
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

        $mp4_url = str_replace(array('collections', '--thumb-small.jpg'),
            array('promoVideos', '/preview.mp4'), $first_image);

        return array($id,$mp4_url);
    }


}
