<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_menus()
    {
        // Arrange
        $menus = Menu::factory()->count(3)->create();

        

        // Act
        $response = $this->getJson('/api/menus');

        // dd($response);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(3); // Expecting 3 menus in the response
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'parent', 'depth', 'children'],
        ]);
    }

    /** @test */
    public function it_can_create_a_menu()
    {
        // Arrange
        $data = [
            'name' => 'Main Menu',
            'parentId' => null,
            'depth' => 0,
            
        ];

        // Act
        $response = $this->postJson('/api/menus', $data);

        // dd($response);

        // Assert
        $response->assertStatus(201);
        // $response->assertJson([...$data,'id'=> '', 'children'=> []]);
        $this->assertDatabaseHas('menus', ['name'=>$data['name']]); // Check that the data is in the database
    }

    /** @test */
    public function it_can_show_a_menu()
    {
        // Arrange
        $menu = Menu::factory()->create();

        // Act
        $response = $this->getJson("/api/menus/{$menu->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $menu->id,
            'name' => $menu->name,
            'parent' => $menu->parent_id,
            'depth' => $menu->depth,
        ]);
    }

    /** @test */
    public function it_can_update_a_menu()
    {
        // Arrange
        $menu = Menu::factory()->create();

        $updatedData = [
            'name' => 'Updated Menu',
            // 'parent_id' => null,
            
        ];

        // Act
        $response = $this->putJson("/api/menus/{$menu->id}", $updatedData);

        // Assert
        $response->assertStatus(200);
        // $response->assertJson($updatedData);
        $this->assertDatabaseHas('menus', ['name'=>$updatedData['name']]);
    }

    /** @test */
    public function it_can_delete_a_menu()
    {
        // Arrange
        $menu = Menu::factory()->create();

        // Act
        $response = $this->deleteJson("/api/menus/{$menu->id}");

        // Assert
        $response->assertStatus(204); // No content
        $this->assertDatabaseMissing('menus', ['id' => $menu->id]); // Check that the data is removed from the database
    }

    /** @test */
public function it_can_create_a_menu_and_a_submenu()
{
    // Arrange
    // Create a parent menu item
    $parentMenu = Menu::factory()->create([
        'name' => 'Parent Menu',
        
    ]);

    // Data for the submenu
    $submenuData = [
        'name' => 'Submenu',
        'parentId' => $parentMenu->id, // ID of the parent menu
    ];

    // Act
    // Create the submenu
    $response = $this->postJson('/api/menus', $submenuData);

    // Assert
    $response->assertStatus(201);
    // $response->assertJson($submenuData);
    $this->assertDatabaseHas('menus', ['name'=>$submenuData['name'], 'parent_id' => $parentMenu->id]);

    // Verify the parent menu
    $this->assertDatabaseHas('menus', [
        'id' => $parentMenu->id,
        'name' => 'Parent Menu',
    ]);
}

}
