<?php
declare(strict_types=1);

namespace Vanssa\BoricaSDK\Request;

use Vanssa\BoricaSDK\Borica;
use Vanssa\BoricaSDK\Exception\ParameterValidationException;
use Vanssa\BoricaSDK\Exception\SignatureException;

abstract class AbstractRequest implements RequestInterface
{

    /**
     * Description: Transaction type
     * Size: 1-2
     * Contents:
     *      Possible values 1, 12, 21, 22, 24, 90
     * @var integer
     */
    protected $transactionType;

    /**
     * Description: Amount
     * Size: 1-12
     * Contents:
     *      Total value of the order according to the ISO_4217 standard (https://en.wikipedia.org/wiki/ISO_4217) with a decimal point separator (eg 12.00).
     *      The amount of the order together with the decimal point.
     *      Example 10.20 If no digits are entered after the decimal separator, the amount is taken as an integer, for example 200 = 200 BGN
     *
     * @var float
     */
    protected $amount;

    /**
     * Description: Currency
     * Size: 3
     * Content:
     *      Order currency: three-letter currency code according to ISO 4217 (https://en.wikipedia.org/wiki/ISO_4217)
     *
     * @var string
     */
    protected $currency = 'BGN';

    /**
     * Description: Order number
     * Size: 6
     * Contents:
     *      Order number for the merchant, 6 digits, which must be unique for the terminal within the day (eg "000123")
     *
     * @var integer
     */
    protected $order;

    /**
     * Description: Description
     * Size: 1-50
     * Content:
     *      Description of the order.
     *      They are used to provide information on the payment page by the merchant about the cardholder.
     *      It is possible to use Cyrillic.
     *
     * @var string
     */
    protected $description;

    /**
     * Описание: URL на търговеца
     * Размер: 1-250
     * Съдържание: URL на web сайта на търговеца
     *
     * @var string
     */
    protected $merchantUrl;

    /**
     * Description: Name of the trader.
     * Size: 1-80
     * Content:
     *      Used to provide information on the payment page by the merchant about the cardholder. It is possible to use Cyrillic.
     *
     * @var string
     */
    protected $merchantName;

    /**
     * Description: Merchant ID
     * Size: 10-15
     * Contents:
     *  Merchant ID
     *
     * @var string
     */
    protected $merchant;

    /**
     * Description: Terminal ID
     * Size: 8
     * Contents:
     *      Terminal ID
     *
     * @var string
     */
    protected $terminal;

    /**
     * Size: 80
     * Contents:
     *      E-mail address for notifications.
     *      If this field is filled in, the payment server sends the result of the transaction to the specified e-mail address.
     *
     * @var string
     */
    protected $email;

    /**
     * Описание: Държава
     * * Description: Country
     * Size: 2
     * Contents:
     *      Two-letter code of the country where the merchant's store is located,
     *      according to ISO 3166-1 (https://en.wikipedia.org/wiki/ISO_3166-1).
     *      It must be provided if the merchant is located in a country other than the gateway server.
     * @var string
     */
    protected $country = 'BG';

    /**
     * Description: Time zone of the trader
     * Size: 1-5
     * Contents:
     *      Trader's time zone distance from UTC / GMT (eg +03).
     *      It must be provided if the merchant's system is located in a different area from that of the gateway server.
     * @var string
     */
    protected $merchantTimezone = '+03';

    /**
     * Description: Type of the original transaction
     * Size: 1-2
     * Content:
     *      Type of the original transaction in the "Status check" request
     *
     * @var string
     */
    protected $originalTransactionType;

    /**
     * Description: Date / time
     * Size: 14
     * Contents:
     *      UTC transaction time (GMT): YYYYMMDDHHMMSS.
     *      The difference between the time of the merchant's server and the e-Gateway server should not exceed 1 hour.
     *      Otherwise, e-Gateway will reject the transaction.
     *
     * @var string
     */
    protected $timestamp;

    /**
     * Description: nonce / salt
     * Размер: 32
     * Size: 32
     * Content:
     *      Contains 16 unpredictable random bytes, presented in hexadecimal format.
     *      May contain uppercase Latin letters A..Z and numbers 0..9. Must be unique to the terminal within the last 24 hours.
     * @var string
     */
    protected $nonce;

    /**
     * Description: Signature
     * Size: 512
     * Content:
     *      APGW message authentication code.
     *      Contains 256 bytes in hexadecimal format.
     *      May contain uppercase Latin letters A..Z and numbers 0..9.
     * @var string
     */
    protected $pSign;

    /**
     * Description: Transaction reference
     * Size: 12
     * Contents:
     *      Transaction reference (ISO-8583 -1987, field 37).
     *
     * @var string
     */
    protected $retrievalReferenceNumber;

    /**
     * Description: Internal reference
     * Size: 16
     * Contents:
     *      Internal reference for e-Commerce gateway
     * @var string
     */
    protected $internalReference;

    /**
     * Size: 0-35000
     * Contents:
     *      Optional EMV 3DS data set v.2.
     *      Must be Base64-encoded string of JSON-formatted “parameter”: “value data. Example: {"threeDSRequestorChallengeInd": "04"}
     *
     * @var string
     */
    protected $mInfo;

    /**
     * Description: Language
     * Size: 2
     * Contents:
     *      Transaction language BG,EN,RU.
     *      The default language is BG.
     *
     * @var string
     */
    protected $language = 'BG';

    /**
     * Description: Order ID
     * Size: 22
     * Content:
     *      ORDER + 16 characters.
     *      It is used for information with which the merchant and the cardholder can recognize the payment.
     *      It is transmitted through financial files. The information entered should consist of numbers and Latin letters.
     *      Used to transfer the order number to the Merchant's Bank in the financial files.
     *      The field must contain the meaning of the field ORDER - 6 digits, concatenated with a character string up to 16 characters long.
     *      The same string can be used as a character order number up to 16 characters.
     *      The field must not contain the symbol ";".
     * @var string
     */
    protected $adCustBorOrderId;

    /**
     * Description: Appendix
     * Size: 5
     * Contents:
     *      Service field with value "AD, TD". Mandatory if field "AD.CUST_BOR_ORDER_ID" is present.
     *
     * @var string
     */
    protected $addendum = 'AD,TD';

    /**
     * Description: Set Borica Instance
     *
     * @var Borica
     */
    protected $borica;

    /**
     * Validation errors in format: `property` => [`error`, ...]
     *
     * @var array
     */
    protected $errors = [];

    /**
     * @var string
     */
    private $backRefUrl;

    /**
     * @param integer $transactionType
     * @return RequestInterface
     */
    public function setTransactionType(int $transactionType): RequestInterface
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * @param float $amount
     * @return RequestInterface
     */
    public function setAmount(float $amount): RequestInterface
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param string $currency
     * @return RequestInterface
     */
    public function setCurrency(string $currency): RequestInterface
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @param integer $order
     * @return RequestInterface
     */
    public function setOrder(int $order): RequestInterface
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @param string $description
     * @return RequestInterface
     */
    public function setDescription(string $description): RequestInterface
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $merchantame
     * @return RequestInterface
     */
    public function setMerchantName($merchantName): RequestInterface
    {
        $this->merchantName = $merchantName;

        return $this;
    }

    /**
     * @param string $merchantUrl
     * @return RequestInterface
     */
    public function setMerchantUrl(string $merchantUrl): RequestInterface
    {
        $this->merchantUrl = $merchantUrl;

        return $this;
    }

    /**
     * @param string $merchant
     * @return RequestInterface
     */
    public function setMerchant(string $merchant): RequestInterface
    {
        $this->merchant = $merchant;

        return $this;
    }

    /**
     * @param string $terminal
     * @return RequestInterface
     */
    public function setTerminal(string $terminal): RequestInterface
    {
        $this->terminal = $terminal;

        return $this;
    }

    /**
     * @param string $email
     * @return RequestInterface
     */
    public function setEmail(string $email): RequestInterface
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $country
     * @return RequestInterface
     */
    public function setCountry(string $country): RequestInterface
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @param string $merchantTimezone
     * @return RequestInterface
     */
    public function setMerchantTimezone(string $merchantTimezone): RequestInterface
    {
        $this->merchantTimezone = $merchantTimezone;

        return $this;
    }

    /**
     * @param integer $timestamp
     * @return RequestInterface
     */
    public function setTimestamp(int $timestamp): RequestInterface
    {
        $this->timestamp = gmdate('YmdHis', $timestamp);

        return $this;
    }

    /**
     * @param string $nonce
     * @return RequestInterface
     */
    public function setNonce(string $nonce): RequestInterface
    {
        $this->nonce = $nonce;

        return $this;
    }

    /**
     * @param string $pSign
     * @return RequestInterface
     */
    public function setPSign(string $pSign): RequestInterface
    {
        $this->pSign = $pSign;

        return $this;
    }

    /**
     * @param string $retrievalReferenceNumber
     * @return RequestInterface
     */
    public function setRetrievalReferenceNumber(string $retrievalReferenceNumber): RequestInterface
    {
        $this->retrievalReferenceNumber = $retrievalReferenceNumber;

        return $this;
    }

    /**
     * @param string $internalReference
     * @return RequestInterface
     */
    public function setInternalReference(string $internalReference): RequestInterface
    {
        $this->internalReference = $internalReference;

        return $this;
    }

    /**
     * @param string $mInfo
     * @return RequestInterface
     */
    public function setMInfo(string $mInfo): RequestInterface
    {
        $this->mInfo = $mInfo;

        return $this;
    }

    /**
     * @param string $orderIdentifier
     * @return RequestInterface
     */
    public function setOrderIdentifier(string $orderIdentifier): RequestInterface
    {
        $this->adCustBorOrderId = str_replace(';', '-', $orderIdentifier);

        return $this;
    }

    /**
     * @param string $addendum
     * @return RequestInterface
     */
    public function setAddendum(string $addendum): RequestInterface
    {
        $this->addendum = $addendum;

        return $this;
    }

    /**
     * @param string $originalTransactionType
     * @return RequestInterface
     */
    public function setOriginalTransactionType(string $originalTransactionType): RequestInterface
    {
        $this->originalTransactionType = $originalTransactionType;

        return $this;
    }

    /**
     * @param string $language
     * @return RequestInterface
     */
    public function setLanguage(string $language): RequestInterface
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return number_format($this->amount, 2, '.', '');
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return str_pad((string)$this->order, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Render HTML form
     *
     * @return string
     */
    public function renderForm(): string
    {
        $html = '<form action="' . $this->borica->getApiUrl() . '" method="POST" id="boricaForm">';

        foreach ($this->toPostData() as $key => $value) {
            $key = (string)$key;
            $value = (string)$value;
            $html .= '<input name="' . self::encode($key) . '" value="' . self::encode($value) . '" style="width: 100%;"><br>';
        }

        $html .= '<button type="submit">Send to Borica</button></form>';

        return $html;
    }

    /**
     * Encodes special characters into HTML entities
     *
     * @param string $text
     * @return string
     */
    public static function encode(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES);
    }

    /**
     * @return boolean
     */
    public function hasErrors(): bool
    {
        return $this->errors !== [];
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return void
     */
    public function clearErrors(): void
    {
        $this->errors = [];
    }

    /**
     * @param bool $extended_fields get field based on terminal configurations
     * Generate extended MAC and use it to sign sended data
     * @return RequestInterface
     */
    public function sign($extended_fields = true): RequestInterface
    {
        if($this->borica->getMacMode() === Borica::MAC_MOD['extended']){
            $macFields = $this->getMacExtendedFields();
        }elseif ($this->borica->getMacMode() === Borica::MAC_MOD['simple']){
            $macFields = $this->getMacFields();
        }else{
            throw new SignatureException("Cannot sed MAc fields");
        }


        $mac = $this->borica::generateMacExtended($this->toPostData(), $macFields, false);
        $this->setPSign($this->borica->signWithPrivateKey($mac));

        return $this;
    }


    public function validate(): bool
    {
        $this->clearErrors();
        foreach ($this->getRequestMandatoryProperties() as $property) {
            $value = (string)$this->$property;
            if ($value === null || mb_strlen($value) === 0) {
                $this->errors[$property][] = $property . ' is required.';
            }
        }
        return !$this->hasErrors();
    }


    public function toPostData(): array
    {
        return $this->dataField();
    }

    /**
     * @return Borica
     */
    public function getBorica(): Borica
    {
        return $this->borica;
    }

    /**
     * @param Borica $borica
     * @return RequestInterface
     */
    public function setBorica(Borica $borica): RequestInterface
    {
        $this->borica = $borica;
        return $this;
    }

    public function setBackRefUrl(?string $backRefUrl = null): RequestInterface
    {

        if (null !== $backRefUrl && !filter_var($backRefUrl, FILTER_VALIDATE_URL)) {
            throw new ParameterValidationException('Backref url is not valid!');
        }
        $this->backRefUrl = $backRefUrl;
        return $this;
    }

    public function getBackRefUrl(): ?string
    {
        return $this->backRefUrl;
    }

    public function setDataFromArray(array $data): RequestInterface
    {
        if (!$this->borica instanceof Borica) {
            throw new ParameterValidationException('Borica Data is not set');
        }
        $data = static::resolveArrayOptions($data);

        foreach ($data as $field => $value) {
            $methodName = 'set' . $field;
            if (method_exists($this, 'set' . $field)) {
                $this->$methodName($value);
            }
        }
        return $this;
    }
}
