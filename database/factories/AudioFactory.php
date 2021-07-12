<?php

namespace Database\Factories;

use App\Models\Audio;
use Illuminate\Database\Eloquent\Factories\Factory;

class AudioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Audio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'audio_id' => '5c234a567a97fdd4677b2408',
            'template_name' => 'Funny',
            'mp3_url' => 'https://ak03-promo-cdn.slidely.com/promoVideos/videos/5c/23/5c234a567a97fdd4677b2408/preview.mp4?dv=1',
            'mp3' => 'http://promo.test/api/mp3/5c234a567a97fdd4677b2408.mp3',
            'status' => 1
        ];
    }
}
