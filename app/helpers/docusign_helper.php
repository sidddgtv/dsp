<?php
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

function generateAccessToken()
{
    $CI =& get_instance();

    $jwtPayload = [
        'iss' => $CI->config->item('integration_key'),
        'sub' => $CI->config->item('user_id'),
        'aud' => $CI->config->item('api_base_url') . '/v2/oauth/token',
        'iat' => time(),
        'exp' => time() + 3600
    ];
    echo $CI->config->item('private_key_path');
    $privateKey = file_get_contents($CI->config->item('private_key_path'));
    $jwtToken = \Firebase\JWT\JWT::encode($jwtPayload, $privateKey, 'RS256');

    $client = new Client();

    $response = $client->post($CI->config->item('api_base_url') . '/oauth/token', [
        RequestOptions::HEADERS => [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json'
        ],
        RequestOptions::FORM_PARAMS => [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwtToken
        ]
    ]);

    $responseData = json_decode($response->getBody(), true);
    $accessToken = $responseData['access_token'];

    return $accessToken;
}
function createEnvelopeAndSavePDF($documentPath, $recipientEmail, $recipientName)
{
    $CI =& get_instance();

    $accessToken = generateAccessToken();

    $client = new Client();

    // Step 1: Create the envelope
    $envelopeData = [
        'status' => 'sent',
        'emailSubject' => 'Sign the document',
        'documents' => [
            [
                'documentBase64' => base64_encode(file_get_contents($documentPath)),
                'name' => 'Document.pdf',
                'fileExtension' => 'pdf',
                'documentId' => '1'
            ]
        ],
        'recipients' => [
            'signers' => [
                [
                    'email' => $recipientEmail,
                    'name' => $recipientName,
                    'recipientId' => '1',
                    'tabs' => [
                        'signHereTabs' => [
                            [
                                'documentId' => '1',
                                'pageNumber' => '1',
                                'xPosition' => '100',
                                'yPosition' => '100'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    $response = $client->post($CI->config->item('api_base_url') . '/v2.1/accounts/' . $CI->config->item('account_id') . '/envelopes', [
        RequestOptions::HEADERS => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ],
        RequestOptions::JSON => $envelopeData
    ]);

    $responseData = json_decode($response->getBody(), true);
    $envelopeID = $responseData['envelopeId'];

    // Step 2: Get the signed PDF
    $response = $client->get($CI->config->item('api_base_url') . '/v2.1/accounts/' . $CI->config->item('account_id') . '/envelopes/' . $envelopeID . '/documents/1', [
        RequestOptions::HEADERS => [
            'Authorization' => 'Bearer ' . $accessToken
        ]
    ]);

    $pdfContent = $response->getBody()->getContents();

    // Step 3: Save the signed PDF
    $savePath = 'storage';
    file_put_contents($savePath, $pdfContent);

    return $envelopeID;
}

