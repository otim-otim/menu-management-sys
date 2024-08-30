<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'parent_id' => null, // For now, we can leave this null; we'll handle parent-child relationships later
            'depth' => 1, // Default to 1 for top-level items
        ];
    }

    /**
     * Indicate that the menu item has a parent.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withParent(Menu $parent)
    {
        return $this->state(function (array $attributes) use ($parent) {
            return [
                'parent_id' => $parent->id,
                'depth' => $parent->depth + 1, // Increase depth by 1
            ];
        });
    }
}
