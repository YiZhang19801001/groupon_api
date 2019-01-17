<?php

namespace Tests\Feature;

use App\Category;
use App\CategoryDescription;
use App\Product;
use App\ProductToCategory;
use Tests\TestCase;

class ProductControllerUnitTest extends TestCase
{
    public function test_get_all_products()
    {

        factory(Product::class)->create([
            'price' => 10,
            'sku' => 'abc123',
            'quantity' => 1,
        ]);
        factory(Product::class)->create([
            'price' => 12,
            'sku' => 'abc124',
            'quantity' => 1,
        ]);
        factory(Product::class)->create([
            'price' => 10.8,
            'sku' => 'abc125',
            'quantity' => 1,
        ]);
        factory(Product::class)->create([
            'price' => 12.8,
            'sku' => 'abc126',
            'quantity' => 1,
        ]);
        factory(Category::class)->create();
        factory(Category::class)->create();

        factory(CategoryDescription::class)->create(['category_id' => 1, 'name' => 'category_1', 'language_id' => 1]);
        factory(CategoryDescription::class)->create(['category_id' => 2, 'name' => 'category_2', 'language_id' => 1]);
        factory(ProductToCategory::class)->create(['category_id' => 1, 'product_id' => 1]);
        factory(ProductToCategory::class)->create(['category_id' => 1, 'product_id' => 2]);
        factory(ProductToCategory::class)->create(['category_id' => 2, 'product_id' => 3]);
        factory(ProductToCategory::class)->create(['category_id' => 2, 'product_id' => 4]);
        // factory(ProductOption::class)->create(['product_id' => 1]);

        $response = $this->json('GET', '/api/products', [])
            ->assertStatus(200)
            ->assertJson([
                [
                    'category_id' => 1,
                    'name' => 'category_1',
                    'products' => [
                        ['product_id' => 1, 'price' => "10.00", 'sku' => 'abc123', 'quantity' => "1"],
                        ['product_id' => 2, 'price' => "12.00", 'sku' => 'abc124', 'quantity' => "1"],
                    ],
                ],
                [
                    'category_id' => 2,
                    'name' => 'category_2',
                    'products' => [
                        ['product_id' => 3, 'price' => "10.80", 'sku' => 'abc125', 'quantity' => "1"],
                        ['product_id' => 4, 'price' => "12.80", 'sku' => 'abc126', 'quantity' => "1"],
                    ],
                ],
            ])
            ->assertJsonStructure([
                '*' => ['category_id', 'name', 'products'],
            ]);

    }

    public function test_create_product_success_with_correct_input()
    {

        $payload = [
            'price' => '12',
            'sku' => 'abc124',
            'quantity' => 1,
        ];
        $response = $this->json('post', '/api/products', $payload)
            ->assertStatus(201)
            ->assertJson(['product_id' => '1', 'price' => '12.00', 'sku' => 'abc124', 'quantity' => '1']);

    }

    public function test_create_product_fail_without_quantity(Type $var = null)
    {
        $payload = [
            'price' => 12,
            'sku' => 'abc124',
        ];

        $response = $this->json('post', '/api/products', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => [
                'quantity' => ['The quantity field is required.'],
            ]]);

    }
    public function test_create_product_fail_without_sku(Type $var = null)
    {
        $payload = [
            'price' => 12,
            'quantity' => 1,
        ];

        $response = $this->json('post', '/api/products', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => [
                'sku' => ['The sku field is required.'],
            ]]);

    }
    public function test_create_product_fail_without_price(Type $var = null)
    {
        $payload = [
            'quantity' => 1,
            'sku' => 'abc124',
        ];

        $response = $this->json('post', '/api/products', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => [
                'price' => ['The price field is required.'],
            ]]);

    }

    public function test_create_product_fail_with_string_price_and_quantity(Type $var = null)
    {
        $payload = [
            'price' => 'abc',
            'quantity' => 'abc',
            'sku' => 'abc124',
        ];

        $response = $this->json('post', '/api/products', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => [
                'price' => ['The price must be a number.'],
                'quantity' => ['The quantity must be an integer.'],
            ]]);

    }

    public function test_create_product_fail_with_decimal_quantity(Type $var = null)
    {
        $payload = [
            'price' => '   12.2',
            'quantity' => 12.2,
            'sku' => 'abc124',
        ];

        $response = $this->json('post', '/api/products', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => [
                'quantity' => ['The quantity must be an integer.'],
            ]]);
    }

    public function test_update_product_success_with_correct_input(Type $var = null)
    {
        factory(Product::class)->create([
            'price' => ' 12.2',
            'quantity' => 12,
            'sku' => 'abc124',
        ]);

        $payload = ['price' => 14.8, 'quantity' => 99];

        $response = $this->json('put', '/api/products/1', $payload)
            ->assertStatus(200)
            ->assertJson(
                ['product_id' => '1', 'price' => '14.80', 'quantity' => '99', 'sku' => 'abc124']
            );
    }

    public function test_update_prodcut_fail_with_incorrect_input_datatype(Type $var = null)
    {
        factory(Product::class)->create([
            'price' => ' 12.2',
            'quantity' => 12,
            'sku' => 'abc124',
        ]);

        $payload = ['price' => 'abc', 'quantity' => 99.9];

        $response = $this->json('put', '/api/products/1', $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'errors' => [
                        'price' => ['The price must be a number.'],
                        'quantity' => ['The quantity must be an integer.'],
                    ],
                ]
            );

    }

}
