<?php
declare(strict_types=1);


namespace Vanssa\BoricaSDK\Request;


use Vanssa\BoricaSDK\Borica;

interface RequestInterface
{
    /**
     * Плащане
     */
    public const SALE = 1;

    /**
     * Първоначална авторизация
     */
    public const DEFERRED_AUTHORIZATION = 12;

    /**
     * Завършване на първоначална авторизация
     */
    public const COMPLETE_DEFERRED_AUTHORIZATION = 21;

    /**
     * Отмяна на първоначална авторизация
     */
    public const REVERSE_DEFERRED_AUTHORIZATION = 22;

    /**
     * Отмяна на плащане
     */
    public const REVERSAL = 24;

    /**
     * Проверка за статус на трансакция
     */
    public const STATUS_CHECK = 90;


    /**
     * Fields used for generating message authentication code (MAC)
     */
    public const MAC_FIELDS = [
        RequestInterface::SALE => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'TIMESTAMP'
        ],
        RequestInterface::DEFERRED_AUTHORIZATION => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'TIMESTAMP',
            'DESC'
        ],
        RequestInterface::COMPLETE_DEFERRED_AUTHORIZATION => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'TIMESTAMP',
            'DESC'
        ],
        RequestInterface::REVERSE_DEFERRED_AUTHORIZATION => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'TIMESTAMP',
            'DESC'
        ],
        RequestInterface::REVERSAL => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'TIMESTAMP',
            'DESC'
        ],
        RequestInterface::STATUS_CHECK => [
            'TERMINAL',
            'TRTYPE',
            'ORDER'
        ]
    ];

    /**
     * Fields used for generating extended message authentication code (MAC)
     */
    public const MAC_EXTENDED_FIELDS = [
        RequestInterface::SALE => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'ORDER',
            'MERCHANT',
            'TIMESTAMP',
            'NONCE'
        ],
        RequestInterface::DEFERRED_AUTHORIZATION => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'ORDER',
            'MERCHANT',
            'TIMESTAMP',
            'NONCE'
        ],
        RequestInterface::COMPLETE_DEFERRED_AUTHORIZATION => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'ORDER',
            'MERCHANT',
            'TIMESTAMP',
            'NONCE'
        ],
        RequestInterface::REVERSE_DEFERRED_AUTHORIZATION => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'ORDER',
            'MERCHANT',
            'TIMESTAMP',
            'NONCE'
        ],
        RequestInterface::REVERSAL => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'ORDER',
            'MERCHANT',
            'TIMESTAMP',
            'NONCE'
        ],
        RequestInterface::STATUS_CHECK => [
            'TERMINAL',
            'TRTYPE',
            'ORDER',
            'NONCE'
        ]
    ];

    /**
     * @param Borica $borica
     * @return RequestInterface
     */
    public function setBorica(Borica $borica): RequestInterface;

    /**
     * @return Borica
     */
    public function getBorica(): Borica;


    /**
     * @param integer $transactionType
     * @return self
     */
    public function setTransactionType(int $transactionType): RequestInterface;

    /**
     * @param float $amount
     * @return self
     */
    public function setAmount(float $amount): RequestInterface;

    /**
     * @param string $currency
     * @return self
     */
    public function setCurrency(string $currency): RequestInterface;

    /**
     * @param integer $order
     * @return self
     */
    public function setOrder(int $order): RequestInterface;

    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): RequestInterface;

    /**
     * @param string $merchantame
     * @return self
     */
    public function setMerchantName($merchantName): RequestInterface;

    /**
     * @param string $merchantUrl
     * @return self
     */
    public function setMerchantUrl(string $merchantUrl): RequestInterface;

    /**
     * @param string $merchant
     * @return self
     */
    public function setMerchant(string $merchant): RequestInterface;

    /**
     * @param string $terminal
     * @return self
     */
    public function setTerminal(string $terminal): RequestInterface;

    /**
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): RequestInterface;

    /**
     * @param string $country
     * @return self
     */
    public function setCountry(string $country): RequestInterface;

    /**
     * @param string $merchantTimezone
     * @return self
     */
    public function setMerchantTimezone(string $merchantTimezone): RequestInterface;

    /**
     * @param integer $timestamp
     * @return self
     */
    public function setTimestamp(int $timestamp): RequestInterface;

    /**
     * @param string $nonce
     * @return self
     */
    public function setNonce(string $nonce): RequestInterface;

    /**
     * @param string $pSign
     * @return self
     */
    public function setPSign(string $pSign): RequestInterface;

    /**
     * @param string $retrievalReferenceNumber
     * @return self
     */
    public function setRetrievalReferenceNumber(string $retrievalReferenceNumber): RequestInterface;

    /**
     * @param string $internalReference
     * @return self
     */
    public function setInternalReference(string $internalReference): RequestInterface;

    /**
     * @param string $mInfo
     * @return self
     */
    public function setMInfo(string $mInfo): RequestInterface;

    /**
     * @param string $orderIdentifier
     * @return self
     */
    public function setOrderIdentifier(string $orderIdentifier): RequestInterface;

    /**
     * @param string $addendum
     * @return self
     */
    public function setAddendum(string $addendum): RequestInterface;

    /**
     * @param string $originalTransactionType
     * @return self
     */
    public function setOriginalTransactionType(string $originalTransactionType): RequestInterface;

    /**
     * @param string $language
     * @return self
     */
    public function setLanguage(string $language): RequestInterface;

    /**
     * @return string
     */
    public function getAmount(): string;

    /**
     * @return string
     */
    public function getOrder(): string;

    /**
     * Render HTML form
     *
     * @return string
     */
    public function renderForm(): string;

    /**
     * Encodes special characters into HTML entities
     *
     * @param string $text
     * @return string
     */
    public static function encode(string $text): string;

    /**
     * @return boolean
     */
    public function hasErrors(): bool;

    /**
     * @return array
     */
    public function getErrors(): array;

    public function setBackRefUrl(?string $backRefUrl=null): RequestInterface;

    public function getBackRefUrl():? string;

    /**
     * @return void
     */
    public function clearErrors(): void;

    public function validate() : bool;

    public function toPostData() : array;

    public function sign($extended_fields = true): RequestInterface;


    public function setDataFromArray(array $data): RequestInterface;

    public static function resolveArrayOptions(array $data): array;

}
