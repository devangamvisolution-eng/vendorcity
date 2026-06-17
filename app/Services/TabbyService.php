<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TabbyService
{
    protected $baseUrl;
    protected $secretKey;
    protected $publicKey;

    public function __construct()
    {
        $this->baseUrl = config('tabby.base_url', 'https://api.tabby.ai/api/v2/');
        $this->secretKey = trim(config('tabby.secret_key', ''));
        $this->publicKey = trim(config('tabby.public_key', ''));
    }

    /**
     * Create a Tabby Checkout Session
     *
     * @param array $bookingData Information about the order
     * @return array|null Returns the session response or null on failure
     */
    public function createSession(array $bookingData)
    {
        $payload = [
            'payment' => [
                'amount' => number_format((float)$bookingData['total_amount'], 2, '.', ''),
                'currency' => 'AED',
                'description' => 'Booking ID: ' . $bookingData['order_id'],
                'buyer' => [
                    'phone' => $bookingData['customer_phone'] ?? '',
                    'email' => $bookingData['customer_email'] ?? '',
                    'name' => $bookingData['customer_name'] ?? '',
                ],
                'order' => [
                    'tax_amount' => number_format((float)($bookingData['tax_amount'] ?? 0), 2, '.', ''),
                    'shipping_amount' => '0.00',
                    'discount_amount' => '0.00',
                    'reference_id' => (string)$bookingData['order_id'],
                    'items' => $this->formatItems($bookingData['items'] ?? [], $bookingData['total_amount'], $bookingData['tax_amount'] ?? 0),
                ],
            ],
            'lang' => 'en',
            'merchant_code' => config('tabby.merchant_code', config('app.name')),
            'merchant_urls' => [
                'success' => route('tabby.success'),
                'cancel' => route('tabby.cancel'),
                'failure' => route('tabby.cancel'),
            ],
        ];

        try {
            $response = Http::withToken($this->publicKey)
                ->post($this->baseUrl . 'checkout', $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Tabby Create Session Failed', [
                'payload' => $payload,
                'response' => $response->body(),
                'status' => $response->status(),
                'public_key_exists' => !empty($this->publicKey)
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Tabby Exception', ['message' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Retrieve payment details from Tabby
     *
     * @param string $paymentId
     * @return array|null
     */
    public function retrievePayment(string $paymentId)
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->get($this->baseUrl . 'payments/' . $paymentId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Tabby Retrieve Payment Failed', [
                'payment_id' => $paymentId,
                'response' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Tabby Retrieve Exception', ['message' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Format line items for Tabby
     */
    private function formatItems(array $items, $totalAmount = 0, $taxAmount = 0)
    {
        $formatted = [];
        $totalCalculated = 0;

        foreach ($items as $item) {
            $unitPrice = (float)($item['price'] ?? 0);
            $qty = (int)($item['quantity'] ?? 1);
            $totalCalculated += ($unitPrice * $qty);

            $formatted[] = [
                'title' => substr($item['name'] ?? 'Service', 0, 100), // Tabby limits title length
                'quantity' => $qty,
                'unit_price' => number_format($unitPrice, 2, '.', ''),
                'category' => 'Services',
            ];
        }

        // Tabby strictly requires: sum(items.unit_price * quantity) + tax + shipping - discount == total_amount
        // If items are not passed properly, we create a single generic item.
        if (empty($formatted) || $totalCalculated <= 0) {
            $itemTotal = (float)$totalAmount - (float)$taxAmount;
            if ($itemTotal < 0) {
                $itemTotal = 0;
            }

            $formatted = [
                [
                    'title' => 'Booking Service',
                    'quantity' => 1,
                    'unit_price' => number_format($itemTotal, 2, '.', ''),
                    'category' => 'Services'
                ]
            ];
        }

        return $formatted;
    }

    /**
     * Check if a customer is eligible for Tabby based on amount and currency
     */
    public function checkEligibility(float $amount, string $currency = 'AED', array $buyer = [])
    {
        $plans = $this->getInstallmentPlans($amount, $currency, $buyer);
        return !empty($plans['installments']) || !empty($plans['pay_later']);
    }

    /**
     * Get available installment plans from Tabby API
     */
    public function getInstallmentPlans(float $amount, string $currency = 'AED', array $buyer = [])
    {
        if ($amount <= 0) return [];

        $buyerEmail = $buyer['email'] ?? 'guest@example.com';
        $buyerPhone = $buyer['phone'] ?? '+971500000000';
        $buyerName = $buyer['name'] ?? 'Guest User';

        // Include phone in cache key since different users get different limits
        $cacheKey = "tabby_plans_{$amount}_{$currency}_" . md5($buyerPhone);

        return cache()->remember($cacheKey, now()->addMinutes(10), function () use ($amount, $currency, $buyerEmail, $buyerPhone, $buyerName) {
            try {
                $payload = [
                    'payment' => [
                        'amount' => number_format($amount, 2, '.', ''),
                        'currency' => $currency,
                        'buyer' => [
                            'email' => $buyerEmail,
                            'phone' => $buyerPhone,
                            'name' => $buyerName,
                        ],
                        'order' => [
                            'reference_id' => 'eligibility_check',
                            'items' => [
                                [
                                    'title' => 'Cart Estimate',
                                    'quantity' => 1,
                                    'unit_price' => number_format($amount, 2, '.', ''),
                                    'category' => 'Services'
                                ]
                            ]
                        ]
                    ],
                    'lang' => 'en',
                    'merchant_code' => config('tabby.merchant_code', config('app.name')),
                    'merchant_urls' => [
                        'success' => url('/'),
                        'cancel' => url('/'),
                        'failure' => url('/'),
                    ],
                ];

                $response = Http::withToken($this->publicKey)
                    ->post($this->baseUrl . 'checkout', $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['configuration']['available_products'] ?? [];
                }

                Log::channel('tabby')->error('Tabby Eligibility Check Failed', [
                    'payload' => $payload,
                    'response' => $response->body()
                ]);

                return [];
            } catch (\Exception $e) {
                Log::channel('tabby')->error('Tabby Eligibility Exception', ['message' => $e->getMessage()]);
                return [];
            }
        });
    }

    /**
     * Get structured display information for the frontend UI
     */
    public function getDisplayInformation(float $amount, string $currency = 'AED', array $buyer = [])
    {
        $plans = $this->getInstallmentPlans($amount, $currency, $buyer);

        // Fail-safe logic: if API fails or times out, follow Tabby's recommendation to show default
        if (empty($plans)) {
            return [
                'eligible' => true,
                'type' => 'installments',
                'amount' => $amount,
                'currency' => $currency,
                'installment_count' => 4,
                'installment_amount' => number_format($amount / 4, 2, '.', ''),
                'service_fee' => 0,
                'is_fallback' => true,
                'display_text' => sprintf('<span class="price-wrapper"><span class="currency_dhiramnew">%s</span> %s</span> × 4', $currency, number_format($amount / 4, 2, '.', '')),
                'products' => []
            ];
        }

        if (isset($plans['installments']) && !empty($plans['installments'])) {
            $installmentsData = $plans['installments'][0]; // get the first available installment plan
            $installmentList = $installmentsData['installments'] ?? [];
            $count = count($installmentList);
            $installmentAmount = $count > 0 ? $installmentList[0]['amount'] : 0;

            $serviceFee = 0;
            if (isset($installmentsData['service_fee']) && (float)$installmentsData['service_fee'] > 0) {
                $serviceFee = (float)$installmentsData['service_fee'];
            }

            return [
                'eligible' => true,
                'type' => 'installments',
                'amount' => $amount,
                'currency' => $currency,
                'installment_count' => $count,
                'installment_amount' => $installmentAmount,
                'service_fee' => $serviceFee,
                'is_fallback' => false,
                'display_text' => sprintf('<span class="price-wrapper"><span class="currency_dhiramnew">%s</span> %s</span> × %s', $currency, number_format((float)$installmentAmount, 2, '.', ''), $count),
                'products' => $plans
            ];
        }

        if (isset($plans['pay_later']) && !empty($plans['pay_later'])) {
            return [
                'eligible' => true,
                'type' => 'pay_later',
                'amount' => $amount,
                'currency' => $currency,
                'service_fee' => $plans['pay_later'][0]['service_fee'] ?? 0,
                'is_fallback' => false,
                'display_text' => 'Pay later in 14 days',
                'products' => $plans
            ];
        }

        return ['eligible' => false];
    }

    /**
     * MOCK DATA FOR TESTING PURPOSES
     */
    private function getMockedPlans(float $amount, string $currency)
    {
        return [
            'installments' => [
                [
                    'installments' => [
                        ['amount' => number_format($amount / 4, 2, '.', '')],
                        ['amount' => number_format($amount / 4, 2, '.', '')],
                        ['amount' => number_format($amount / 4, 2, '.', '')],
                        ['amount' => number_format($amount / 4, 2, '.', '')]
                    ],
                    'service_fee' => 0
                ],
                [
                    'installments' => array_fill(0, 6, ['amount' => number_format(($amount * 1.05) / 6, 2, '.', '')]),
                    'service_fee' => number_format(($amount * 0.05) / 6, 2, '.', '')
                ],
                [
                    'installments' => array_fill(0, 8, ['amount' => number_format(($amount * 1.09) / 8, 2, '.', '')]),
                    'service_fee' => number_format(($amount * 0.09) / 8, 2, '.', '')
                ],
                [
                    'installments' => array_fill(0, 12, ['amount' => number_format(($amount * 1.17) / 12, 2, '.', '')]),
                    'service_fee' => number_format(($amount * 0.17) / 12, 2, '.', '')
                ]
            ],
            'pay_later' => [
                ['service_fee' => 0]
            ]
        ];
    }
}
