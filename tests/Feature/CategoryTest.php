<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $category = Category::create([
            'name' => 'test 1'
        ]);
        $category->refresh();

        $this->assertMatchesRegularExpression('/^[0-9A-F]{8}-[0-9A-F]{4}-[4][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i',$category->id);
        $this->assertEquals('test 1',$category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);

        $category = Category::create([
            'name' => 'test 1',
            'description' => null,
            'is_active' => false,
        ]);

        $this->assertNull($category->description);
        $this->assertFalse($category->is_active);

        $category = Category::create([
            'name' => 'test 1',
            'description' => 'description test',
            'is_active' => true,
        ]);
        $this->assertEquals('description test', $category->description);
        $this->assertTrue($category->is_active);

    }

    public function testUpdate()
    {
        $category = Category::factory(1)->create()->first();

        $data = [
            'name' => $category->name.' update',
            'description' => $category->description.' update',
            'is_active' => !$category->is_active
        ];

        $category->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value,$category->$key);
        }
        $this->assertNotEquals($category->created_at, $category->update_at);
    }

    public function testDelete()
    {
        $category = Category::factory(1)->create()->first();
        $category->delete();

        $this->assertNotNull($category->deleted_at);
    }
}
