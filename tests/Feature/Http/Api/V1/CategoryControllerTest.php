<?php

namespace Tests\Feature\Http\Api\V1;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $category = Category::factory(1)->create()->first();
        $category->refresh();

        $response = $this->json('GET',route('categories.index'));
        $response
            ->assertStatus(200)
            ->assertJson([$category->toArray()]);

        unset($category, $response);
    }

    public function testShow()
    {
        $category = Category::factory(1)->create()->first();
        $category->refresh();

        $response = $this->json('GET', route('categories.show',[$category->id]));
        $response
            ->assertStatus(200)
            ->assertJson($category->toArray());

        unset($category, $response);
    }

    public function testStore()
    {
        /** Validations */
        $response = $this->json('POST', route('categories.store'),[]);
        $this->assertValidationRequired($response);

        $response = $this->json('POST', route('categories.store'), [
            'name' => str_repeat('x', 101),
            'is_active' => 'a'
        ]);
        $this->assertValidationContent($response);

        /** Data */
        $response = $this->json('POST', route('categories.store'), [
            'name' => 'Category Test'
        ]);

        $id = $response->json('id');
        $category = Category::find($id);

        $response
            ->assertStatus(201)
            ->assertJson($category->toArray())
            ->assertJsonFragment([
                'description' => null,
                'is_active' => true
            ]);

        unset($response, $category, $id);

        $response = $this->json('POST', route('categories.store'), [
            'name' => 'Category Test',
            'description' => 'Category description test',
            'is_active' => false,
        ]);

        $id = $response->json('id');
        $category = Category::find($id);

        $response
            ->assertStatus(201)
            ->assertJson($category->toArray())
            ->assertJsonFragment([
                'description' => 'Category description test',
                'is_active' => false,
            ]);

        unset($category, $response, $id);
    }

    public function testUpdate()
    {
        /** Validation */
        $category = Category::factory(1)->create()->first();
        $id = $category->id;

        $response = $this->json('PUT', route('categories.update', [$id]), []);
        $this->assertValidationRequired($response);

        $response = $this->json('PUT', route('categories.update', [$id]), [
            'name' => str_repeat('x', 101),
            'is_active' => 'a'
        ]);
        $this->assertValidationContent($response);

        unset($response);

        /** Data */
        $data = [
            'name' => $category->name . ' update',
            'description' => (is_null($category->description) ? ('Category') : ($category->description)) . ' update',
            'is_active' => !$category->is_active
        ];

        $response = $this->json('PUT', route('categories.update',[$id]), $data);

        unset($category);

        $category = Category::find($id);

        $response
            ->assertStatus(200)
            ->assertJson($category->toArray())
            ->assertJsonFragment($data);

        $this->assertNotEquals($category->created_at, $category->update_at);

        unset($category, $response, $id);
    }

    public function testDelete()
    {
        $category = Category::factory(1)->create()->first();

        $response = $this->json('DELETE', route('categories.destroy', [$category->id]));

        $response
            ->assertStatus(204);

        $category->refresh();
        $this->assertNotNull($category->deleted_at);
    }

    protected function assertValidationRequired(TestResponse $response)
    {
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonMissingValidationErrors(['is_active'])
            ->assertJsonFragment([
                trans_choice('validation.required', 1, ['attribute' => 'name'])
            ]);
    }

    protected function assertValidationContent(TestResponse $response)
    {
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'is_active'])
            ->assertJsonFragment([
                trans_choice('validation.max.string', 1, ['attribute' => 'name', 'max' => 100])
            ])
            ->assertJsonFragment([
                trans_choice('validation.boolean', 1, ['attribute' => 'is active'])
            ]);
    }
}
