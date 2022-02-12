<?php

namespace Tests\Feature\Http\Api\V1;

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class GenreControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $genre = Genre::factory(1)->create()->first();
        $genre->refresh();

        $response = $this->json('GET', route('genres.index'));
        $response
            ->assertStatus(200)
            ->assertJson([$genre->toArray()]);

        unset($genre, $response);
    }

    public function testShow()
    {
        $genre = Genre::factory(1)->create()->first();
        $genre->refresh();

        $response = $this->json('GET', route('genres.show', [$genre->id]));
        $response
            ->assertStatus(200)
            ->assertJson($genre->toArray());

        unset($genre, $response);
    }

    public function testStore()
    {
        /** Validations */
        $response = $this->json('POST', route('genres.store'), []);
        $this->assertValidationRequired($response);

        $response = $this->json('POST', route('genres.store'), [
            'name' => str_repeat('x', 101),
            'is_active' => 'a'
        ]);
        $this->assertValidationContent($response);

        /** Data */
        $response = $this->json('POST', route('genres.store'), [
            'name' => 'Genre Test'
        ]);

        $id = $response->json('id');
        $genre = Genre::find($id);

        $response
            ->assertStatus(201)
            ->assertJson($genre->toArray())
            ->assertJsonFragment([
                'is_active' => true
            ]);

        unset($response, $genre, $id);

        $response = $this->json('POST', route('genres.store'), [
            'name' => 'Genre Test',
            'is_active' => false,
        ]);

        $id = $response->json('id');
        $genre = Genre::find($id);

        $response
            ->assertStatus(201)
            ->assertJson($genre->toArray())
            ->assertJsonFragment([
                'is_active' => false,
            ]);

        unset($genre, $response, $id);
    }

    public function testUpdate()
    {
        /** Validation */
        $genre = Genre::factory(1)->create()->first();
        $id = $genre->id;

        $response = $this->json('PUT', route('genres.update', [$id]), []);
        $this->assertValidationRequired($response);

        $response = $this->json('PUT', route('genres.update', [$id]), [
            'name' => str_repeat('x', 101),
            'is_active' => 'a'
        ]);
        $this->assertValidationContent($response);

        unset($response);

        /** Data */
        $data = [
            'name' => $genre->name . ' update',
            'is_active' => !$genre->is_active
        ];

        $response = $this->json('PUT', route('genres.update', [$id]), $data);

        unset($genre);

        $genre = Genre::find($id);

        $response
            ->assertStatus(200)
            ->assertJson($genre->toArray())
            ->assertJsonFragment($data);

        $this->assertNotEquals($genre->created_at, $genre->update_at);

        unset($genre, $response, $id);
    }

    public function testDelete()
    {
        $genre = Genre::factory(1)->create()->first();

        $response = $this->json('DELETE', route('genres.destroy', [$genre->id]));

        $response
            ->assertStatus(204);

        $genre->refresh();
        $this->assertNotNull($genre->deleted_at);
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