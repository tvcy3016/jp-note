<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SupabaseAuthService
{
    public function signUp(string $email, string $password): array
    {
        $response = $this->request()
            ->post($this->buildUrl('/auth/v1/signup'), [
                'email' => $email,
                'password' => $password,
            ]);

        return $this->parseResponse($response);
    }

    public function signIn(string $email, string $password): array
    {
        $response = $this->request()
            ->post($this->buildUrl('/auth/v1/token?grant_type=password'), [
                'email' => $email,
                'password' => $password,
            ]);

        return $this->parseResponse($response);
    }

    public function signOut(string $accessToken): void
    {
        $this->request($accessToken)
            ->post($this->buildUrl('/auth/v1/logout'));
    }

    private function request(?string $accessToken = null)
    {
        $anonKey = config('services.supabase.anon_key');

        return Http::withHeaders([
            'apikey' => $anonKey,
            'Authorization' => 'Bearer '.($accessToken ?: $anonKey),
        ]);
    }

    private function buildUrl(string $path): string
    {
        return rtrim(config('services.supabase.url'), '/').$path;
    }

    private function parseResponse(Response $response): array
    {
        if ($response->failed()) {
            $payload = $response->json();
            $message = $payload['error_description']
                ?? $payload['msg']
                ?? $payload['message']
                ?? 'Supabase authentication failed.';

            throw new RuntimeException($message);
        }

        return $response->json() ?? [];
    }
}
