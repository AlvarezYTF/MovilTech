<?php

namespace App\Services\Printing;

use RuntimeException;

class QzSigningService
{
    public function isEnabled(): bool
    {
        return (bool) config('printing.qz.enabled', false);
    }

    public function certificate(): string
    {
        if (!$this->isEnabled()) {
            throw new RuntimeException('QZ signing is disabled.');
        }

        return trim($this->readPemFile((string) config('printing.qz.certificate_path')));
    }

    public function sign(string $payload): string
    {
        if (!$this->isEnabled()) {
            throw new RuntimeException('QZ signing is disabled.');
        }

        $privateKey = $this->loadPrivateKey();
        $signature = '';
        $algorithm = $this->resolveAlgorithm((string) config('printing.qz.signature_algorithm', 'SHA512'));

        $signed = openssl_sign($payload, $signature, $privateKey, $algorithm);
        if (!$signed) {
            throw new RuntimeException('Could not sign QZ payload. ' . $this->consumeOpenSslErrors());
        }

        return base64_encode($signature);
    }

    private function loadPrivateKey()
    {
        $keyContents = $this->readPemFile((string) config('printing.qz.private_key_path'));
        $passphrase = (string) config('printing.qz.private_key_passphrase', '');

        $privateKey = openssl_pkey_get_private($keyContents, $passphrase);
        if ($privateKey === false) {
            throw new RuntimeException('Could not load QZ private key. ' . $this->consumeOpenSslErrors());
        }

        return $privateKey;
    }

    private function readPemFile(string $path): string
    {
        $trimmedPath = trim($path);
        if ($trimmedPath === '') {
            throw new RuntimeException('QZ key/certificate path is empty.');
        }

        $resolvedPath = $this->resolvePath($trimmedPath);
        if (!is_file($resolvedPath) || !is_readable($resolvedPath)) {
            throw new RuntimeException("QZ file is not readable: {$resolvedPath}");
        }

        $contents = file_get_contents($resolvedPath);
        if ($contents === false || trim($contents) === '') {
            throw new RuntimeException("QZ file is empty: {$resolvedPath}");
        }

        return $contents;
    }

    private function resolvePath(string $path): string
    {
        if ($this->isAbsolutePath($path)) {
            return $path;
        }

        return base_path($path);
    }

    private function isAbsolutePath(string $path): bool
    {
        if (str_starts_with($path, '/') || str_starts_with($path, '\\')) {
            return true;
        }

        return (bool) preg_match('/^[A-Za-z]:[\\\\\\/]/', $path);
    }

    private function resolveAlgorithm(string $algorithm): int
    {
        return match (strtoupper(trim($algorithm))) {
            'SHA1' => OPENSSL_ALGO_SHA1,
            'SHA224' => OPENSSL_ALGO_SHA224,
            'SHA256' => OPENSSL_ALGO_SHA256,
            'SHA384' => OPENSSL_ALGO_SHA384,
            default => OPENSSL_ALGO_SHA512,
        };
    }

    private function consumeOpenSslErrors(): string
    {
        $messages = [];
        while ($message = openssl_error_string()) {
            $messages[] = $message;
        }

        if (empty($messages)) {
            return 'No additional OpenSSL error details.';
        }

        return implode(' | ', $messages);
    }
}
