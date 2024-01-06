<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectRequest>
 */
class ProjectRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = ProjectRequest::class;

    public function definition()
    {
        return [
            'invite_token' => Str::random(32),
            'from_user_id'=>User::Factory(),
        ];
    }
}
