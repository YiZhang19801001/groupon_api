<?php

namespace Tests\Feature;

use App\Category;
use App\CategoryDescription;
use Tests\TestCase;

class CategoryControllerUnitTest extends TestCase
{
    public function test_create_category_success_with_correct_input()
    {

        $payload = [
            'name' => 'food',
            'language_id' => '1',
        ];
        $response = $this->json('post', '/api/categories', $payload)
            ->assertStatus(201)
            ->assertJson(['category_id' => '1', 'name' => 'food']);

    }
    public function test_create_category_fail_by_missing_attributes()
    {
        $payload = [

        ];

        $response = $this->json('post', '/api/categories', $payload)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => ['The name field is required.'],
                    'language_id' => ['The language id field is required.'],
                ],
            ]);

    }
    public function test_create_category_fail_by_duplicate_category_name_and_language_id()
    {
        $category = Category::create();
        $categoryDescription = CategoryDescription::create(['category_id' => 1, 'name' => 'food', 'language_id' => 1]);

        $payload = [
            'name' => 'food',
            'language_id' => 1,
        ];

        $response = $this->json('post', '/api/categories', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => ['message' => "This category is already exists"]]);

    }
    public function test_create_category_fail_by_language_id_not_a_number()
    {
        $payload = [
            'name' => 'food',
            'language_id' => 'abc',
        ];

        $response = $this->json('post', '/api/categories', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => ['language_id' => ["The language id must be an integer."]]]);

    }

    public function test_update_category_success_by_correct_request_input()
    {
        $category = Category::create();
        $categoryDescription = CategoryDescription::create(['language_id' => 1, 'category_id' => 1, 'name' => 'food']);
        $payload = [

            'name' => 'drink',
            'language_id' => 1,
        ];

        $response = $this->json('put', '/api/categories/1', $payload)
            ->assertStatus(200)
            ->assertJson(['category_id' => 1, 'name' => 'drink']);
    }

    public function test_update_category_fail_by_incorrect_request_input_datatype()
    {
        $category = Category::create();
        $categoryDescription = CategoryDescription::create(['language_id' => 1, 'category_id' => 1, 'name' => 'food']);
        $payload = [

            'name' => 'drink',
            'language_id' => 'abc',
        ];

        $response = $this->json('put', '/api/categories/1', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => ['language_id' => ['The language id must be an integer.']]]);
    }

    public function test_update_category_fail_by_category_not_found()
    {
        $category = Category::create();
        $categoryDescription = CategoryDescription::create(['language_id' => 1, 'category_id' => 1, 'name' => 'food']);
        $payload = [
            'name' => 'drink',
            'language_id' => 1,
        ];

        $response = $this->json('put', '/api/categories/2', $payload)
            ->assertStatus(400)
            ->assertJson(['errors' => ['Messages' => 'This category can not be found.']]);

    }

}
