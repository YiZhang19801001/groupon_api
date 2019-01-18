<?php

namespace Tests\Feature;

use App\Category;
use App\CategoryDescription;
use App\Option;
use App\OptionDescription;
use App\OptionValue;
use App\OptionValueDescription;
use App\Product;
use App\ProductOption;
use App\ProductOptionValue;
use App\ProductToCategory;
use Tests\TestCase;

class ProductControllerUnitTest extends TestCase
{
    /**
     * Test GET domain/api/products return full detailed product list
     *
     * @return void
     */
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
        factory(ProductOption::class)->create(['product_id' => 1, 'option_id' => 1, 'value' => '', 'required' => 1]);
        factory(ProductOption::class)->create(['product_id' => 1, 'option_id' => 2, 'value' => '', 'required' => 1]);

        factory(Option::class)->create(['type' => 'radio', 'sort_order' => 1]);
        factory(Option::class)->create(['type' => 'checkbox', 'sort_order' => 2]);

        factory(OptionDescription::class)->create(['option_id' => 1, 'language_id' => 1, 'name' => 'How sweet']);
        factory(OptionDescription::class)->create(['option_id' => 2, 'language_id' => 1, 'name' => 'Topping']);

        factory(OptionValue::class)->create(['option_id' => 1]);
        factory(OptionValue::class)->create(['option_id' => 1]);
        factory(OptionValue::class)->create(['option_id' => 2]);
        factory(OptionValue::class)->create(['option_id' => 2]);

        factory(ProductOptionValue::class)->create(['product_option_id' => 1, 'product_id' => 1, 'option_id' => 1, 'option_value_id' => 1, 'quantity' => 1, 'price' => 2.00]);
        factory(ProductOptionValue::class)->create(['product_option_id' => 1, 'product_id' => 1, 'option_id' => 1, 'option_value_id' => 2, 'quantity' => 1, 'price' => 3.00]);
        factory(ProductOptionValue::class)->create(['product_option_id' => 2, 'product_id' => 1, 'option_id' => 2, 'option_value_id' => 3, 'quantity' => 1, 'price' => 4.00]);
        factory(ProductOptionValue::class)->create(['product_option_id' => 2, 'product_id' => 1, 'option_id' => 2, 'option_value_id' => 4, 'quantity' => 1, 'price' => 5.00]);

        factory(OptionValueDescription::class)->create(['option_value_id' => 1, 'language_id' => 1, 'option_id' => 1, 'name' => 'mild']);
        factory(OptionValueDescription::class)->create(['option_value_id' => 2, 'language_id' => 1, 'option_id' => 1, 'name' => 'very sweet']);
        factory(OptionValueDescription::class)->create(['option_value_id' => 3, 'language_id' => 1, 'option_id' => 2, 'name' => 'peral']);
        factory(OptionValueDescription::class)->create(['option_value_id' => 4, 'language_id' => 1, 'option_id' => 2, 'name' => 'unknown']);

        $response = $this->json('GET', '/api/products/1', [])
            ->assertStatus(200)
            ->assertJson([
                [
                    'category_id' => 1,
                    'name' => 'category_1',
                    'products' => [
                        ['product_id' => 1, 'price' => "10.00", 'sku' => 'abc123', 'quantity' => "1", "options" => [
                            ['option_name' => 'How sweet', 'required' => '1', 'type' => 'radio', 'values' => [
                                ['name' => 'mild', 'price' => '2.00'],
                                ['name' => 'very sweet', 'price' => '3.00'],
                            ]],
                            ['option_name' => 'Topping', 'required' => '1', 'type' => 'checkbox', 'values' => [
                                ['name' => 'peral', 'price' => '4.00'],
                                ['name' => 'unknown', 'price' => '5.00'],

                            ]],
                        ]],
                        ['product_id' => 2, 'price' => "12.00", 'sku' => 'abc124', 'quantity' => "1", "options" => []],
                    ],
                ],
                [
                    'category_id' => 2,
                    'name' => 'category_2',
                    'products' => [
                        ['product_id' => 3, 'price' => "10.80", 'sku' => 'abc125', 'quantity' => "1", "options" => []],
                        ['product_id' => 4, 'price' => "12.80", 'sku' => 'abc126', 'quantity' => "1", "options" => []],
                    ],
                ],
            ])
            ->assertJsonStructure([
                '*' => ['category_id', 'name', 'products'],
            ]);

    }

    /**
     * Test POST domain/api/proructs create correct instance in database
     *
     * @return void
     */
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

    public function test_create_product_fail_without_quantity()
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
    public function test_create_product_fail_without_sku()
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
    public function test_create_product_fail_without_price()
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

    public function test_create_product_fail_with_string_price_and_quantity()
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

    public function test_create_product_fail_with_decimal_quantity()
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

    public function test_update_product_success_with_correct_input()
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

    public function test_update_prodcut_fail_with_incorrect_input_datatype()
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
