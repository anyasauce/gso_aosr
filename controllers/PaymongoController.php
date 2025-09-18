<?php

class PaymongoController {

    private $secretKey;
    private $appUrl; // Your website's base URL
    private $apiBaseUrl = 'https://api.paymongo.com/v1';

    public function __construct() {
        $this->secretKey = 'sk_test_NG3NZZFEBtZJHYSjMx1spgLy';
        $this->appUrl    = 'http://localhost/gso_aosr';
    }

    /**
     * Creates a PayMongo Checkout Session.
     * @param array $lineItems The items for the checkout.
     * @param string $customerName The full name of the customer.
     * @param string $customerEmail The email of the customer.
     * @return object|null The decoded JSON response from PayMongo, or null on failure.
     */
    public function createCheckoutSession(array $lineItems, string $customerName, string $customerEmail) {
        $payload = [
            'data' => [
                'attributes' => [
                    'billing' => [
                        'name' => $customerName,
                        'email' => $customerEmail,
                    ],
                    'payment_method_types' => ['gcash', 'paymaya', 'grab_pay'],
                    'line_items' => $lineItems,
                    'success_url' => $this->appUrl . '/public/payment_success.php',
                    'cancel_url' => $this->appUrl . '/public/payment_cancel.php',
                    'description' => 'GSO AOSR Reservation Payment'
                ]
            ]
        ];
        return $this->makeApiRequest('/checkout_sessions', 'POST', $payload);
    }

    /**
     * Private helper function to handle all cURL API requests.
     */
    private function makeApiRequest(string $endpoint, string $method = 'POST', ?array $payload = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiBaseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($payload) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json', 
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->secretKey . ':');

        $responseBody = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) { 
            error_log('cURL error when connecting to PayMongo: ' . curl_error($ch)); 
            curl_close($ch);
            return null;
        }
        curl_close($ch);
        
        $responseData = json_decode($responseBody);

        if ($httpCode >= 200 && $httpCode < 300) {
            return $responseData->data ?? $responseData;
        } else {
            error_log("PayMongo API failed for {$endpoint} with code {$httpCode}: {$responseBody}");
            return $responseData;
        }
    }

    /**
     * VERIFICATION STEP: Retrieves a Checkout Session from PayMongo's server.
     * @param string $checkoutSessionId 
     * @return object|null
     */
    public function retrieveCheckoutSession(string $checkoutSessionId)
    {
        $endpoint = "/checkout_sessions/{$checkoutSessionId}";
        return $this->makeApiRequest($endpoint, 'GET');
    }
}