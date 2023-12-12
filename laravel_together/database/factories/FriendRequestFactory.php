<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FriendRequest>
 */
class FriendRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years');
        $enum = ['pending', 'accepted', 'rejected'];
        $rand = $this->faker->numberBetween(0,2);
        return [
            'from_user_email'=>(string)$this->faker->randomNumber(2), // 친구 요청 보낸 유저 이메일
            'to_user_email'=>(string)$this->faker->randomNumber(2), // 친구 요청 받는 유저 이메일
            'status'=> $enum[$rand], // 현재 친구 상태 [대기중/ 수락됌/ 거절됌 -> 기본값 : 대기중]
            'created_at' => $date, //생성일
            'updated_at' => $date, //수정일
        ];
    }
}
