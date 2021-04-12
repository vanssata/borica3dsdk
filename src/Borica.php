<?php
declare(strict_types=1);


namespace Vanssa\BoricaSDK;

use Vanssa\BoricaSDK\Exception\SignatureException;

class Borica
{
    public const API_URL = [
        'development' => 'https://3dsgate-dev.borica.bg/cgi-bin/cgi_link',
        'production' => 'https://3dsgate.borica.bg/cgi-bin/cgi_link'
    ];

    public const MAC_MOD = [
        'extended' => 'extended',
        'simple' => 'simple',

    ];

    /**
     * @var boolean
     */
    protected $sandboxMode = false;

    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var string
     */
    protected $privateKey;

    /**
     * @var string
     */
    protected $privateKeyPassword;

    /**
     * @var string
     */
    protected $certificate;

    /**
     * @var string
     */
    protected $mac_mode;


    /**
     * @param boolean $sandbox Sandbox mode
     * @return Borica
     */
    public function setSandboxMode(bool $sandbox): Borica
    {
        $this->sandboxMode = $sandbox;
        return $this;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->sandboxMode ? self::API_URL['development'] : self::API_URL['production'];
    }

    /**
     * @param string $filePath Absolute file path to private key (e.g. /home/username/public_html/certificates/borica.pem)
     * @return Borica
     */
    public function setPrivateKeyFromFile(string $filePath, $form_file = false): Borica
    {

        $this->privateKey = 'file://' . $filePath;

        return $this;
    }

    /**
     * @param string $privateKey Private Key string
     * @return Borica
     */
    public function setPrivateKeyFromString(string $privateKey): Borica
    {

        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * @param string $password Private key password
     * @return Borica
     */
    public function setPrivateKeyPassword(string $password): Borica
    {
        $this->privateKeyPassword = $password;

        return $this;
    }

    /**
     * @param string $filePath Absolute file path to certificate (e.g. /home/username/public_html/certificates/borica.cer)
     * @return Borica
     */
    public function setCertificateFromFile(string $filePath): Borica
    {
        $this->certificate = 'file://' . $filePath;

        return $this;
    }

    /**
     * @param string $certificate Certificate string
     * @return Borica
     */
    public function setCertificateFromString(string $certificate): Borica
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * @return string
     */
    public function getMacMode(): string
    {
        return $this->mac_mode;
    }

    /**
     * @param string $mac_mode
     */
    public function setMacMode(string $mac_mode): self
    {
        $this->mac_mode = $mac_mode;
        return $this;
    }



    /**
     * Generate message authentication code (MAC) for signing
     *
     * @param array $data
     * @param boolean $isResponse
     * @return string
     */
    public static function generateMac(array $data, array $macFields, bool $isResponse): string
    {

        $message = '';

        foreach ($macFields as $field) {
            $message .= mb_strlen($data[$field]) . $data[$field];
        }

        return $message;
    }

    /**
     * Generate extended message authentication code (MAC) for signing
     *
     * @param array $data
     * @param boolean $isResponse
     * @return string
     */
    public static function generateMacExtended(array $data, array $macExtendedFields, bool $isResponse): string
    {

        $message = '';

        foreach ($macExtendedFields as $field) {
            $value = (string)$data[$field];

            // When field in response is missing, use symbol `-`
            if ($isResponse && mb_strlen($value) == 0) {
                $message .= '-';
            } else {
                $message .= mb_strlen($value) . $value;
            }
        }

        return $message;
    }

    /**
     * Sign data using private key
     *
     * @param string $data
     * @return string
     */
    function signWithPrivateKey(string $data): string
    {
        // Get a private key
        $privateKey = openssl_get_privatekey($this->privateKey, $this->privateKeyPassword);
        if (!$privateKey) {
            throw new SignatureException("Cannot validate private key !!! \n 'open_ssl_error'=>" . openssl_error_string(), 500);
        }

        // Generate signature
        if (!openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
            throw new SignatureException("Cannot sing message !!! \n 'open_ssl_error'=>" . openssl_error_string(), 500);
        }

        // Free key resource
        openssl_free_key($privateKey);

        return strtoupper(bin2hex($signature));
    }

    /**
     * Verify signed data using public key
     *
     * @param string $data
     * @param string $signature
     * @return boolean
     */
    public function verifySignature(string $data, string $signature): bool
    {
        // Get a public key
        if (strpos($this->certificate, 'CERTIFICATE') !== false) {
            $publicKey = openssl_get_publickey($this->certificate);
        } else {

            $publicKey = $this->certificate;
        }

        if (!$publicKey) {
            throw new SignatureException("Cannot validate private key !!! \n 'open_ssl_error'=>" . openssl_error_string(), 500);

        }

        // Verify signature
        $result = openssl_verify($data, hex2bin($signature), $publicKey, OPENSSL_ALGO_SHA256);

        if ($result !== 1) {
            throw new SignatureException(openssl_error_string());
        }
        if ($result == 0) {
            throw new SignatureException("Cannot sing message !!! \n 'open_ssl_error'=>" . openssl_error_string(), 500);
        } else {
            if (strpos($this->certificate, 'CERTIFICATE') !== false) {

                if (PHP_MAJOR_VERSION < 8) {
                    openssl_free_key($publicKey);
                }
            }
        }


        return true;
    }

}
