<?php

class PaymongoController
{
    private $secretKey;
    private $apiBaseUrl = 'https://api.paymongo.com/v1';

    public function __construct()
    {
        $this->secretKey = PAYMONGO_SECRET_KEY;
    }

    /**
     * Creates a Checkout Session in a single API call.
     * @param array $lineItems
     * @return object|null
     */
    public function createCheckoutSession(array $lineItems)
    {
        $payload = [
            'data' => [
                'attributes' => [
                    'billing' => [
                        'name' => 'GSO AOSR Requester',
                        'email' => 'requester@example.com',
                    ],
                    'payment_method_types' => ['gcash', 'paymaya', 'grab_pay'],
                    'line_items' => $lineItems,
                    'success_url' => APP_URL . '/public/payment_success.php',
                    'cancel_url' => APP_URL . '/public/pay.php',
                    'description' => 'GSO AOSR Reservation Payment'
                ]
            ]
        ];
        return $this->makeApiRequest('/checkout_sessions', 'POST', $payload);
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

    /**
     * Private helper function to handle all cURL API requests.
     */
    private function makeApiRequest(string $endpoint, string $method = 'POST', ?array $payload = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiBaseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($payload) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
        curl_setopt($ch, CURLOPT_USERPWD, $this->secretKey . ':');

        $responseBody = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) { error_log('cURL error: ' . curl_error($ch)); }
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($responseBody)->data;
        }
        
        error_log("PayMongo API failed for {$endpoint} with code {$httpCode}: {$responseBody}");
        return null;
    }
}