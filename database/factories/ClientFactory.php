
<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'folder' => $this->faker->text(200),
            'address' => $this->faker->address,
            'zip_code' => 12345,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'email' => $this->faker->unique()->email,
        ];
    }
}
