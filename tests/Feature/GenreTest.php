<?php

namespace Tests\Feature;

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'test 1'
        ]);
        $genre->refresh();

        $this->assertMatchesRegularExpression('/^[0-9A-F]{8}-[0-9A-F]{4}-[4][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $genre->id);
        $this->assertEquals('test 1', $genre->name);
        $this->assertTrue($genre->is_active);

        $genre = Genre::create([
            'name' => 'test 1',
            'is_active' => false,
        ]);

        $this->assertFalse($genre->is_active);

        $genre = Genre::create([
            'name' => 'test 1',
            'is_active' => true,
        ]);
        $this->assertTrue($genre->is_active);
    }

    public function testUpdate()
    {
        $genre = Genre::factory(1)->create()->first();

        $data = [
            'name' => $genre->name . ' update',
            'is_active' => !$genre->is_active
        ];

        $genre->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->$key);
        }
        $this->assertNotEquals($genre->created_at, $genre->update_at);
    }

    public function testDelete()
    {
        $genre = Genre::factory(1)->create()->first();
        $genre->delete();

        $this->assertNotNull($genre->deleted_at);
    }
}
