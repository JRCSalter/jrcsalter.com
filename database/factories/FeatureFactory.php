<?php

namespace Database\Factories;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feature>
 */
class FeatureFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $label = 'stand_alone';
    $labelValue = fake()->boolean();
    $title = fake()->unique()->word();
    if ( ! $labelValue )
    {
      $label = 'from';
      $labelValue = fake()->word();
    }

    $file = fopen( 'storage/app/public/features/' . $title . '.txt' , 'w' );
    fwrite( $file, fake()->paragraph( 10 ) );

    return [
      'title' => $title,
      'file'  => 'storage/features/' . $title . '.txt',
      $label  => $labelValue,
      'slug'  => fake()->unique()->word()
    ];
  }
}
