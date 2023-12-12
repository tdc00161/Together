<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type_flg'=>$this->faker->numberBetween(0,2), // 플래그 (파일/이미지/지도),
            'address'=>(string)$this->faker->sentence(500), // 주소
        ];
    }
}
