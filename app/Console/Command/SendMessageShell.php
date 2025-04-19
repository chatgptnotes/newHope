<?php
App::uses('HttpSocket', 'Network/Http');

class SendMessageShell extends AppShell {
    public function main() {
        // WhatsApp API Details
        $apiUrl = "https://public.doubletick.io/whatsapp/message/template";
        $apiKey = "key_8sc9MP6JpQ";

        // Message Payload
        $payload = [
            "messages" => [
                [
                    "to" => "+917387737062", // Replace with recipient's number
                    "content" => [
                        "templateName" => "hope_daily_money_collection", // Template name
                        "language" => "en", // Language
                        "templateData" => [
                            "body" => [
                                "placeholders" => ["Dr. Murli", "500", "500", "500"] // Dynamic placeholders
                            ]
                        ]
                    ]
                ]
            ]
        ];

        // Send API Request
        $http = new HttpSocket();
        $response = $http->post($apiUrl, json_encode($payload), [
            'header' => [
                'Content-Type' => 'application/json',
                'Authorization' => $apiKey
            ]
        ]);

        // Log Response
        if ($response->isOk()) {
            $this->out("Message sent successfully: " . $response->body());
        } else {
            $this->out("Failed to send message: " . $response->body());
        }
    }
}
