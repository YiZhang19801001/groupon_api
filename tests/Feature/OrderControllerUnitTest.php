<?php

namespace Tests\Feature;

use Tests\TestCase;

class OrderControllerUnitTest extends TestCase
{
    public function test_create_order_with_correct_input()
    {
        $payload = [
            'invoice_no' => 12345678,
            'store_id' => 1,
            'customer_id' => 1,
            'fax' => '2019-03-21',
            'payment_method' => 'alipay',
            'total' => 12.8,
            'order_items' => [
                ['product_id' => 1,
                    'price' => 12.80,
                    'quantity' => 2,
                    'total' => 25.60,
                    'options' => [
                        ['product_option_id' => 1, 'product_option_value_id' => 1], ['product_option_id' => 2, 'product_option_value_id' => 3],
                    ]],
            ],
        ];
        $response = $this->json('post', '/api/orders', $payload)
            ->assertStatus(201)
            ->assertJson([
                'order' => [
                    'invoice_no' => 12345678,
                    'store_id' => 1,
                    'customer_id' => 1,
                    'fax' => '2019-03-21',
                    'payment_method' => 'alipay',
                    'total' => '12.80',
                ],
                'order_products' => [
                    ['product_id' => 1,
                        'price' => '12.80',
                        'quantity' => 2,
                        'total' => 25.60,
                        'options' => [
                            [
                                'order_id' => 1,
                                'order_product_id' => 1,
                                'product_option_id' => 1,
                                'product_option_value_id' => 1,
                            ],
                            [
                                'order_id' => 1,
                                'order_product_id' => 1,
                                'product_option_id' => 2,
                                'product_option_value_id' => 3,
                            ],
                        ]],
                ],

            ]);
    }
}
