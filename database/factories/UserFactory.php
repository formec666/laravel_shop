<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Administrátor',
            'email' => 'tomas.formoza@gmail.com',
            'email_verified_at' => now(),
            'isAdmin'=>true,
            'password' => '$2y$10$nAfUxD1uIbRIxE84HUM1D.bJ63m.yJ4ZVvr1VJlUgA18hkiG/gA0S', // password
            'remember_token' => Str::random(10),
            'isAllowed'=>json_encode(['nevim'=>true])
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
