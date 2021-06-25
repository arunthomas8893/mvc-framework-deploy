<?php
namespace App\Models\Common;
class CryptedValues {

    private $encrypt_method = "AES-256-CBC";
    private $secret_key = 'dasdfanfq9843nceronoi';
    private $secret_iv = 'sadfkvbqiwunb24jff8r09';
    private $salt_otp='csdfas543tgvaetg';
    public function createPassword(string $rawPassword): string {
        return password_hash($rawPassword, PASSWORD_DEFAULT);
    }

    public function verifyPassword(string $rawPassword, string $hashedPassword): bool {
        return password_verify($rawPassword, $hashedPassword);
    }

    /**
     * returns array with indices 'code' and 'hash'
     * @return array
     */
    public function createOTP(): array {
        $otpCode = rand(55555, 999999999);
        
        $otpHash = $this->encryptData($otpCode);
        return array(
            'code' => $otpCode,
            'hash' => $otpHash
        );
    }

    public function checkOTP($otpCode, $otpHash): bool {

        if ($otpCode == $this->decryptData($otpHash)) {
            return true;
        } else {
            return false; 
        }
    }

    public function createFormAuthenticationToken(): string {
        
    }

    public function checkFormAuthenticationToken(string $tokenHash): bool {
        
    }

    public function encryptData($string) {

        $output = false;
        $encrypt_method = $this->encrypt_method;
        $secret_key = $this->secret_iv;
        $secret_iv = $this->secret_key;

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);

        return $output;
    }

    public function decryptData($string) {

        $output = false;
        $encrypt_method = $this->encrypt_method;
        $secret_key = $this->secret_iv;
        $secret_iv = $this->secret_key;

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }

}
