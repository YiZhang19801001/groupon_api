<?php

namespace Tests\Feature;

use App\Category;
use App\CategoryDescription;
use App\Option;
use App\OptionDescription;
use App\OptionValue;
use App\OptionValueDescription;
use App\Product;
use App\ProductDescription;
use App\ProductOption;
use App\ProductOptionValue;
use App\ProductToCategory;
use Tests\TestCase;

class ProductControllerUnitTest extends TestCase
{

    public function test_get_all_products()
    {

        $this->createSampleProductsWithDetails();

        $response = $this->json('GET', '/api/products/1', [])
            ->assertStatus(200)
            ->assertJson([
                [
                    'category_id' => 1,
                    'name' => 'category_1',
                    'products' => [
                        ['product_id' => 1, 'name' => 'rice', 'price' => "10.00", 'sku' => 'abc123', 'quantity' => "1", "options" => [
                            ['option_name' => 'How sweet', 'required' => '1', 'type' => 'radio', 'values' => [
                                ['name' => 'mild', 'price' => '2.00'],
                                ['name' => 'very sweet', 'price' => '3.00'],
                            ]],
                            ['option_name' => 'Topping', 'required' => '1', 'type' => 'checkbox', 'values' => [
                                ['name' => 'peral', 'price' => '4.00'],
                                ['name' => 'unknown', 'price' => '5.00'],

                            ]],
                        ]],
                        ['product_id' => 2, 'name' => 'noodle', 'price' => "12.00", 'sku' => 'abc124', 'quantity' => "1", "options" => []],
                    ],
                ],
                [
                    'category_id' => 2,
                    'name' => 'category_2',
                    'products' => [
                        ['product_id' => 3, 'name' => 'pizza', 'price' => "10.80", 'sku' => 'abc125', 'quantity' => "1", "options" => []],
                        ['product_id' => 4, 'name' => 'burger', 'price' => "12.80", 'sku' => 'abc126', 'quantity' => "1", "options" => []],
                    ],
                ],
            ])
            ->assertJsonStructure([
                '*' => ['category_id', 'name', 'products'],
            ]);

    }
    public function test_create_product_success_with_correct_input()
    {
        Category::create();
        $payload = [
            'category_id' => 1,
            'product' => [
                'price' => '12', 'sku' => 'abc123', 'quantity' => 999,
            ],
            'descriptions' => [['name' => 'rice', 'language_id' => 1], ['name' => '米饭', 'language_id' => 2]],
            'options' => [[
                'option_id' => 'new',
                'required' => 1,
                'value' => '',
                'type' => 'checkbox',
                'descriptions' => [['name' => 'size', 'language_id' => 1]],
                'values' => [
                    [
                        'option_value_id' => 'new',
                        'price' => '3.00',
                        'quantity' => 1,
                        'descriptions' => [
                            ['name' => 'large', 'language_id' => 1],
                        ],
                    ],
                    [
                        'option_value_id' => 'new',
                        'price' => '1.00',
                        'quantity' => 1,
                        'descriptions' => [
                            ['name' => 'small', 'language_id' => 1],
                        ],
                    ],
                ],
            ]],
        ];
        $response = $this->json('post', '/api/products', $payload)
            ->assertStatus(201)
            ->assertJson([
                'category_id' => '1',
                'product' => [
                    'price' => '12.00', 'sku' => 'abc123', 'quantity' => '999',
                ],
                'descriptions' => [['name' => 'rice', 'language_id' => '1'], ['name' => '米饭', 'language_id' => '2']],
                'options' => [[
                    'required' => '1',
                    'type' => 'checkbox',
                    'descriptions' => [['name' => 'size', 'language_id' => '1']],
                    'values' => [
                        [
                            'price' => '3.00',
                            'descriptions' => [
                                ['name' => 'large'],
                            ],
                        ],
                        [
                            'price' => '1.00',
                            'descriptions' => [
                                ['name' => 'small'],
                            ],
                        ],
                    ],
                ]],
            ]);
    }

    public function test_create_product_fail_by_category_not_found()
    {
        factory(Category::class)->create();
        $payload = [
            'category_id' => 3,
            'product' => [
                'price' => '12', 'sku' => 'abc123', 'quantity' => 999,
            ],
            'descriptions' => [['name' => 'rice', 'language_id' => 1], ['name' => '米饭', 'language_id' => 2]],
            'options' => [[
                'option_id' => 'new',
                'required' => 1,
                'value' => '',
                'type' => 'checkbox',
                'descriptions' => [['name' => 'size', 'language_id' => 1]],
                'values' => [
                    [
                        'option_value_id' => 'new',
                        'price' => '3.00',
                        'quantity' => 1,
                        'descriptions' => [
                            ['name' => 'large', 'language_id' => 1],
                        ],
                    ],
                    [
                        'option_value_id' => 'new',
                        'price' => '1.00',
                        'quantity' => 1,
                        'descriptions' => [
                            ['name' => 'small', 'language_id' => 1],
                        ],
                    ],
                ],
            ]],
        ];

        $response = $this->json('post', '/api/products', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => [
                'category' => ['The category is not found.'],
            ]]);

    }
    public function test_create_product_fail_by_sku_duplicate()
    {
        factory(Category::class)->create();
        factory(Product::class)->create([
            'price' => 12.8,
            'sku' => 'abc123',
            'quantity' => 1,
        ]);
        $payload = [
            'category_id' => 1,
            'product' => [
                'price' => '12', 'sku' => 'abc123', 'quantity' => 999,
            ],
            'descriptions' => [['name' => 'rice', 'language_id' => 1], ['name' => '米饭', 'language_id' => 2]],
            'options' => [[
                'option_id' => 'new',
                'required' => 1,
                'value' => '',
                'type' => 'checkbox',
                'descriptions' => [['name' => 'size', 'language_id' => 1]],
                'values' => [
                    [
                        'option_value_id' => 'new',
                        'price' => '3.00',
                        'quantity' => 1,
                        'descriptions' => [
                            ['name' => 'large', 'language_id' => 1],
                        ],
                    ],
                    [
                        'option_value_id' => 'new',
                        'price' => '1.00',
                        'quantity' => 1,
                        'descriptions' => [
                            ['name' => 'small', 'language_id' => 1],
                        ],
                    ],
                ],
            ]],
        ];

        $response = $this->json('post', '/api/products', $payload)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'product.sku' => ['The product sku is duplicate in database.'],
                ],
            ]);
    }

    public function test_create_product_fail_without_product_detail()
    {
        Category::create();
        $payload = [
            'category_id' => 1,
            'product' => [],
        ];

        $response = $this->json('post', '/api/products', $payload)
            ->assertStatus(422)
            ->assertJson(['errors' => [
                'product.price' => ['The product.price field is required.'],
                'product.sku' => ['The product.sku field is required.'],
                'product.quantity' => ['The product.quantity field is required.'],
            ]]);

    }

    public function test_update_product_success_with_correct_input()
    {
        $this->createSampleProductsWithDetails();

        $payload = [
            'category_id' => 1,
            'product' => [
                'product_id' => 1, 'price' => '2', 'sku' => 'abc124', 'quantity' => 999,
            ],
            'descriptions' => [['name' => 'fried rice', 'language_id' => 1], ['name' => '炒饭', 'language_id' => 2]],
            'options' => [[
                'product_option_id' => 1,
                'option_id' => '1',
                'required' => 1,
                'value' => '',
                'type' => 'checkbox',
                'descriptions' => [['name' => 'size', 'language_id' => 1]],
                'values' => [
                    [
                        'product_option_value_id' => 1,
                        'option_value_id' => '1',
                        'price' => '3.00',
                        'quantity' => 1,
                        'descriptions' => [
                            ['name' => 'large', 'language_id' => 1],
                            ['name' => '大份', 'language_id' => 2],
                        ],
                    ],
                    [
                        'product_option_value_id' => 2,
                        'option_value_id' => '2',
                        'price' => '1.00',
                        'quantity' => 1,
                        'descriptions' => [
                            ['name' => 'small', 'language_id' => 1],
                            ['name' => '小份', 'language_id' => 2],
                        ],
                    ],
                ],
            ]],
        ];

        $response = $this->json('put', '/api/products/1', $payload)
            ->assertStatus(200)
            ->assertJson([
                'category_id' => 1,
                'product' => [
                    'price' => '2.00', 'sku' => 'abc124', 'quantity' => 999,
                ],
                'descriptions' => [['name' => 'fried rice', 'language_id' => 1], ['name' => '炒饭', 'language_id' => 2]],
                'options' => [[
                    'required' => 1,
                    'type' => 'checkbox',
                    'descriptions' => [['name' => 'size', 'language_id' => 1]],
                    'values' => [
                        [
                            'price' => '3.00',
                            'descriptions' => [
                                ['name' => 'large'],
                                ['name' => '大份', 'language_id' => 2],

                            ],
                        ],
                        [
                            'price' => '1.00',
                            'descriptions' => [
                                ['name' => 'small'],
                                ['name' => '小份', 'language_id' => 2],

                            ],
                        ],
                    ],
                ]],
            ]);
    }

    public function test_update_prodcut_fail_with_incorrect_input_datatype()
    {
        factory(Product::class)->create([
            'price' => ' 12.2',
            'quantity' => 12,
            'sku' => 'abc124',
        ]);

        $payload = ['price' => 'abc', 'quantity' => 99.9];

        $response = $this->json('put', '/api/products/abc', $payload)
            ->assertStatus(422)
            ->assertJson(
                [
                    'errors' => [
                        'category' => ['The category is not found.'],
                        'product_id' => ['The product id field is required.'],
                    ],
                ]
            );

    }

    public function test_show_single_product_according_to_product_id()
    {
        // $this->createSampleProductsWithDetails();
        factory(Product::class)->create([
            'price' => 10,
            'sku' => 'abc123',
            'quantity' => 1,
        ]);
        factory(ProductDescription::class)->create([
            'product_id' => 1, 'language_id' => 1, 'name' => 'rice',
        ]);
        factory(ProductDescription::class)->create([
            'product_id' => 1, 'language_id' => 2, 'name' => '米饭',
        ]);
        factory(Category::class)->create();
        factory(CategoryDescription::class)->create(['category_id' => 1, 'name' => 'category_1', 'language_id' => 1]);
        factory(CategoryDescription::class)->create(['category_id' => 1, 'name' => '主食', 'language_id' => 2]);
        factory(ProductToCategory::class)->create(['category_id' => 1, 'product_id' => 1]);

        $response = $this->json('GET', '/api/product/1', [])
            ->assertStatus(200)
            ->assertJson(
                [
                    'product' => ['product_id' => "1", 'price' => "10.00", 'sku' => 'abc123', 'quantity' => "1"],
                    'category_id' => "1",
                    'descriptions' => [
                        ['language_id' => "1", 'name' => 'rice'],
                        ['language_id' => "2", "name" => "米饭"],
                    ],

                ]
            );
    }

    public function createSampleProductsWithDetails()
    {

        factory(Product::class)->create([
            'price' => 10,
            'sku' => 'abc123',
            'quantity' => 1,
        ]);
        factory(ProductDescription::class)->create([
            'product_id' => 1, 'language_id' => 1, 'name' => 'rice',
        ]);
        factory(Product::class)->create([
            'price' => 12,
            'sku' => 'abc124',
            'quantity' => 1,
        ]);
        factory(ProductDescription::class)->create([
            'product_id' => 2, 'language_id' => 1, 'name' => 'noodle',
        ]);
        factory(Product::class)->create([
            'price' => 10.8,
            'sku' => 'abc125',
            'quantity' => 1,
        ]);
        factory(ProductDescription::class)->create([
            'product_id' => 3, 'language_id' => 1, 'name' => 'pizza',
        ]);

        factory(Product::class)->create([
            'price' => 12.8,
            'sku' => 'abc126',
            'quantity' => 1,
        ]);
        factory(ProductDescription::class)->create([
            'product_id' => 4, 'language_id' => 1, 'name' => 'burger',
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

    }

}
