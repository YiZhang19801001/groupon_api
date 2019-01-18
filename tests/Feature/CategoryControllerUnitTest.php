<?php

namespace Tests\Feature;

use App\Category;
use App\CategoryDescription;
use Tests\TestCase;

class CategoryControllerUnitTest extends TestCase
{

    /**
     * Test POST domain/api/categories create correct instance in database
     *
     * @return void
     */
    public function test_create_category_success_with_correct_input()
    {

        $payload = [
            'name' => 'food',
            'languageId' => '1',
        ];
        $response = $this->json('post', '/api/categories', $payload)
            ->assertStatus(201)
            ->assertJson(['category_id' => '1', 'name' => 'food']);

    }

    /**
     * Reject request if miss attributes in requet body
     */
    public function test_create_category_fail_by_missing_attributes()
    {
        $payload = [

        ];

        $response = $this->json('post', '/api/categories', $payload)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name' => ['The name field is required.'],
                    'languageId' => ['The language id field is required.'],
                ],
            ]);

    }
    /**
     * Create category fail - duplicate category in the database
     */
    public function test_create_category_fail_by_duplicate_category_name_and_language_id(Type $var = null)
    {
        $category = Category::create();
        $categoryDescription = CategoryDescription::create(['category_id' => 1, 'name' => 'food', 'language_id' => 1]);

        $payload = [
            'name' => 'food',
            'languageId' => 1,
        ];

        $response = $this->json('post', '/api/categories', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => ['message' => "This category is already exists"]]);

    }

    /**
     * Create category fail - languageId is string not number
     */

}
