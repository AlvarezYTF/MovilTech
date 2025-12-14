<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FactusApiService
{
    private string $baseUrl;
    private string $clientId;
    private string $clientSecret;
    private string $username;
    private string $password;
    private string $tokenEndpoint;

    public function __construct()
    {
        $this->baseUrl = config('factus.api_url');
        $this->clientId = config('factus.client_id');
        $this->clientSecret = config('factus.client_secret');
        $this->username = config('factus.username');
        $this->password = config('factus.password');
        $this->tokenEndpoint = '/oauth/token';
    }

    public function getAuthToken(): string
    {
        $tokenData = Cache::get('factus_token_data');
        
        if ($tokenData && isset($tokenData['access_token'])) {
            $expiresAt = $tokenData['expires_at'] ?? null;
            
            if ($expiresAt && now()->lt($expiresAt)) {
                return $tokenData['access_token'];
            }
            
            if (isset($tokenData['refresh_token'])) {
                try {
                    return $this->refreshAccessToken($tokenData['refresh_token']);
                } catch (\Exception $e) {
                    Log::warning('Error al renovar token con refresh_token, obteniendo nuevo token', [
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        return $this->requestNewAccessToken();
    }

    private function requestNewAccessToken(): string
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->asForm()->post("{$this->baseUrl}{$this->tokenEndpoint}", [
            'grant_type' => 'password',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $this->username,
            'password' => $this->password,
        ]);

        if (!$response->successful()) {
            throw new \Exception('Error al autenticar con Factus OAuth2: ' . $response->body());
        }

        $data = $response->json();
        $accessToken = $data['access_token'] ?? null;
        $refreshToken = $data['refresh_token'] ?? null;
        $expiresIn = $data['expires_in'] ?? 600;
        $tokenType = $data['token_type'] ?? 'Bearer';

        if (!$accessToken) {
            throw new \Exception('No se recibió access_token de Factus');
        }

        $expiresAt = now()->addSeconds($expiresIn - 60);

        $tokenData = [
            'access_token' => $accessToken,
            'token_type' => $tokenType,
            'expires_at' => $expiresAt,
            'expires_in' => $expiresIn,
        ];

        if ($refreshToken) {
            $tokenData['refresh_token'] = $refreshToken;
        }

        Cache::put('factus_token_data', $tokenData, now()->addSeconds($expiresIn));

        Log::info('Nuevo token de acceso obtenido de Factus', [
            'expires_at' => $expiresAt->toIso8601String(),
            'expires_in' => $expiresIn,
            'token_type' => $tokenType,
            'has_refresh_token' => !empty($refreshToken),
        ]);

        return $accessToken;
    }

    private function refreshAccessToken(string $refreshToken): string
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->asForm()->post("{$this->baseUrl}{$this->tokenEndpoint}", [
            'grant_type' => 'refresh_token',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $refreshToken,
        ]);

        if (!$response->successful()) {
            throw new \Exception('Error al renovar token con Factus OAuth2: ' . $response->body());
        }

        $data = $response->json();
        $accessToken = $data['access_token'] ?? null;
        $newRefreshToken = $data['refresh_token'] ?? $refreshToken;
        $expiresIn = $data['expires_in'] ?? 600;
        $tokenType = $data['token_type'] ?? 'Bearer';

        if (!$accessToken) {
            throw new \Exception('No se recibió access_token al renovar token');
        }

        $expiresAt = now()->addSeconds($expiresIn - 60);

        $tokenData = [
            'access_token' => $accessToken,
            'token_type' => $tokenType,
            'refresh_token' => $newRefreshToken,
            'expires_at' => $expiresAt,
            'expires_in' => $expiresIn,
        ];

        Cache::put('factus_token_data', $tokenData, now()->addSeconds($expiresIn));

        Log::info('Token de acceso renovado usando refresh_token', [
            'expires_at' => $expiresAt->toIso8601String(),
            'expires_in' => $expiresIn,
            'token_type' => $tokenType,
            'has_new_refresh_token' => ($newRefreshToken !== $refreshToken),
        ]);

        return $accessToken;
    }

    public function get(string $endpoint, array $params = []): array
    {
        $token = $this->getAuthToken();

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json',
        ])->get("{$this->baseUrl}{$endpoint}", $params);

        if (!$response->successful()) {
            if ($response->status() === 401) {
                Log::warning('Token expirado en GET request, renovando token', ['endpoint' => $endpoint]);
                Cache::forget('factus_token_data');
                $token = $this->getAuthToken();
                
                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$token}",
                    'Accept' => 'application/json',
                ])->get("{$this->baseUrl}{$endpoint}", $params);
                
                if (!$response->successful()) {
                    throw new \Exception("Error en GET {$endpoint} después de renovar token: " . $response->body());
                }
            } else {
                throw new \Exception("Error en GET {$endpoint}: " . $response->body());
            }
        }

        return $response->json();
    }

    public function post(string $endpoint, array $data): array
    {
        $token = $this->getAuthToken();

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post("{$this->baseUrl}{$endpoint}", $data);

        if (!$response->successful()) {
            if ($response->status() === 401) {
                Log::warning('Token expirado en POST request, renovando token', ['endpoint' => $endpoint]);
                Cache::forget('factus_token_data');
                $token = $this->getAuthToken();
                
                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$token}",
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->post("{$this->baseUrl}{$endpoint}", $data);
                
                if (!$response->successful()) {
                    $errorBody = $response->body();
                    Log::error("Error en POST {$endpoint} después de renovar token", [
                        'status' => $response->status(),
                        'body' => $errorBody,
                        'data_sent' => $data,
                    ]);
                    throw new \Exception("Error en POST {$endpoint} después de renovar token: {$errorBody}");
                }
            } else {
                $errorBody = $response->body();
                Log::error("Error en POST {$endpoint}", [
                    'status' => $response->status(),
                    'body' => $errorBody,
                    'data_sent' => $data,
                ]);
                throw new \Exception("Error en POST {$endpoint}: {$errorBody}");
            }
        }

        return $response->json();
    }
}
