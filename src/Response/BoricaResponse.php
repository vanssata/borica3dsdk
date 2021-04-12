<?php


namespace Vanssa\BoricaSDK\Response;

use Vanssa\BoricaSDK\Borica;
use Vanssa\BoricaSDK\TransactionTypeInterface;

class BoricaResponse {

    /**
     * Fields used for generating message authentication code (MAC)
     */
    const MAC_FIELDS = [
        TransactionTypeInterface::SALE => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'TIMESTAMP'
        ],
        TransactionTypeInterface::DEFERRED_AUTHORIZATION => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'ORDER',
            'TIMESTAMP'
        ],
        TransactionTypeInterface::COMPLETE_DEFERRED_AUTHORIZATION => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'ORDER',
            'TIMESTAMP'
        ],
        TransactionTypeInterface::REVERSE_DEFERRED_AUTHORIZATION => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'ORDER',
            'TIMESTAMP'
        ],
        TransactionTypeInterface::REVERSAL => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'ORDER',
            'TIMESTAMP'
        ],
        TransactionTypeInterface::STATUS_CHECK => [
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'TIMESTAMP'
        ]
    ];

    /**
     * Fields used for generating extended message authentication code (MAC)
     */
    const MAC_EXTENDED_FIELDS = [
        TransactionTypeInterface::SALE => [
            'ACTION',
            'RC',
            'APPROVAL',
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'ORDER',
            'RRN',
            'INT_REF',
            'PARES_STATUS',
            'ECI',
            'TIMESTAMP',
            'NONCE'
        ],
        TransactionTypeInterface::DEFERRED_AUTHORIZATION => [
            'ACTION',
            'RC',
            'APPROVAL',
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'ORDER',
            'RRN',
            'INT_REF',
            'PARES_STATUS',
            'ECI',
            'TIMESTAMP',
            'NONCE'
        ],
        TransactionTypeInterface::COMPLETE_DEFERRED_AUTHORIZATION => [
            'ACTION',
            'RC',
            'APPROVAL',
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'ORDER',
            'RRN',
            'INT_REF',
            'PARES_STATUS',
            'ECI',
            'TIMESTAMP',
            'NONCE'
        ],
        TransactionTypeInterface::REVERSE_DEFERRED_AUTHORIZATION => [
            'ACTION',
            'RC',
            'APPROVAL',
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'ORDER',
            'RRN',
            'INT_REF',
            'PARES_STATUS',
            'ECI',
            'TIMESTAMP',
            'NONCE'
        ],
        TransactionTypeInterface::REVERSAL => [
            'ACTION',
            'RC',
            'APPROVAL',
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'ORDER',
            'RRN',
            'INT_REF',
            'PARES_STATUS',
            'ECI',
            'TIMESTAMP',
            'NONCE'
        ],
        TransactionTypeInterface::STATUS_CHECK => [
            'ACTION',
            'RC',
            'APPROVAL',
            'TERMINAL',
            'TRTYPE',
            'AMOUNT',
            'CURRENCY',
            'ORDER',
            'RRN',
            'INT_REF',
            'PARES_STATUS',
            'ECI',
            'TIMESTAMP',
            'NONCE'
        ]
    ];

    /**
     * Response codes
     */
    const RESPONSE_CODES = [
        'bg' => [
            '-1' => 'В заявката не е попълнено задължително поле',
            '-2' => 'Заявката съдържа поле с некоректно име',
            '-3' => 'Aвторизационният хост не отговаря или форматът на отговора е неправилен',
            '-4' => 'Няма връзка с авторизационния хост',
            '-5' => 'Грешка във връзката с авторизационния хост',
            '-6' => 'Грешка в конфигурацията на APGW',
            '-7' => 'Форматът на отговора от авторизационният хост е неправилен',
            '-10' => 'Грешка в поле "Сума" в заявката',
            '-11' => 'Грешка в поле "Валута" в заявката',
            '-12' => 'Грешка в поле "Идентификатор на търговеца" в заявката',
            '-13' => 'Неправилен IP адрес на търговеца',
            '-15' => 'Грешка в поле "RRN" в заявката',
            '-16' => 'В момента се изпълнява друга транзакция на терминала',
            '-17' => 'Отказан достъп до платежния сървър (напр. грешка при проверка на P_SIGN)',
            '-19' => 'Грешка в искането за аутентикация или неуспешна аутентикация',
            '-20' => 'Разрешената разлика между времето на сървъра на търговеца и e-Gateway сървъра е надвишена',
            '-21' => 'Транзакцията вече е била изпълнена',
            '-22' => 'Транзакцията съдържа невалидни данни за аутентикация',
            '-23' => 'Невалиден контекст на транзацията',
            '-24' => 'Заявката съдържа стойности за полета, които не могат да бъдат обработени. Например валутата е различна от тази на терминала или транзакцията е по-стара от 24 часа.',
            '-25' => 'Допълнителното потвърждение на транзакцията е отказано от картодържателя',
            '-26' => 'Невалиден BIN на картата',
            '-27' => 'Невалидно име на търговеца',
            '-28' => 'Невалидно допълнително поле (например AD.CUST_BOR_ORDER_ID)',
            '-29' => 'Невалиден отговор от ACS на издателя на картата',
            '-30' => 'Транзакцията е отказана',
            '-31' => 'Транзакцията е в процес на обработка',
            '-32' => 'Дублирана отказана транзакция',
            '-33' => 'Транзакцията е в процес на аутентикация на картодържателя',
            '-40' => 'Транзакцията е в процес на обработка',
            '00' => 'Транзакцията е завършена успешно',
            '01' => 'Обърнете се към издателя на картата',
            '04' => 'Задържане на картата',
            '05' => 'Не зачитайте картата',
            '06' => 'Грешка',
            '12' => 'Невалидна транзакция',
            '13' => 'Невалидна сума',
            '14' => 'Няма такава карта',
            '15' => 'Няма такъв издател',
            '17' => 'Анулиране от клиента',
            '30' => 'Грешка на форматирането',
            '35' => 'Задържане на картата, приобретател на контакт с акцептор на карта',
            '36' => 'Задържане на картата, карта ограничена',
            '37' => 'Задържане на картата, повикване сигурност на получателя',
            '38' => 'Задържане на картата, допустимите опити за ПИН са надвишени',
            '39' => 'Няма кредитна сметка',
            '40' => 'Заявената функция не се поддържа',
            '41' => 'Задържане на картата, загубена карта',
            '42' => 'Няма универсален акаунт',
            '43' => 'Задържане на картата, открадната карта',
            '54' => 'Изтекла карта / цел',
            '55' => 'Неправилен ПИН',
            '56' => 'Няма запис за картата',
            '57' => 'Транзакцията не е разрешена на картодържателя',
            '58' => 'Транзакцията не е разрешена до терминал',
            '59' => 'Подозирана измама',
            '82' => 'Време за изчакване',
            '85' => 'Няма причина за отказ',
            '88' => 'Криптографска грешка',
            '89' => 'Неуспешно удостоверяване',
            '91' => 'Издателят или суичът не работи',
            '95' => 'Съгласуваща грешка / Удостоверяването не е намерено',
            '96' => 'Неизправност на системата',
            '1A' => 'Свържете се с Вашата банка',
            'B1' => 'Допълнителната сума не е разрешена за карти Visa (само за купувачи в САЩ)',
            'N0' => 'Принудително STIP',
            'N3' => 'Касовата услуга не е налична',
            'N4' => 'Искането за кешбек надвишава лимита на издателя',
            'N7' => 'Отказ поради грешка в CVV2',
            'P2' => 'Невалидна информация за фактуращия',
            'P5' => 'Искането за промяна / деблокиране на ПИН е отхвърлено',
            'P6' => 'Несигурен ПИН',
            'Q1' => 'Удостоверяването на картата не бе успешно',
            'R0' => 'Стоп-платежно нареждане',
            'R1' => 'Отмяна на нареждане за упълномощаване',
            'R3' => 'Отмяна на всички нареждания за авторизация',
            'FAR' => 'Препращане към емитента',
            'XD' => 'Препращане към емитента',
            'Z3' => 'Не може да се влезе онлайн'
        ],
        'en' => [
            '-1' => 'A mandatory request field is not filled in',
            '-2' => 'CGI request validation failed',
            '-3' => 'Acquirer host (TS) does not respond or wrong format of e-gateway response template file',
            '-4' => 'No connection to the acquirer host (TS)',
            '-5' => 'The acquirer host (TS) connection failed during transaction processing',
            '-6' => 'e-Gateway configuration error',
            '-7' => 'The acquirer host (TS) response is invalid, e.g. mandatory fields missing',
            '-10' => 'Error in the "Amount" request field',
            '-11' => 'Error in the "Currency" request field',
            '-12' => 'Error in the "Merchant ID" request field',
            '-13' => 'The referrer IP address (usually the merchant\'s IP) is not the one expected',
            '-15' => 'Error in the "RRN" request field',
            '-16' => 'Another transaction is being performed on the terminal',
            '-17' => 'The terminal is denied access to e-Gateway',
            '-19' => 'Error in the authentication information request or authentication failed.',
            '-20' => 'The permitted time interval (1 hour by default) between the transaction timestamp request field and the e-Gateway time was exceeded',
            '-21' => 'The transaction has already been executed',
            '-22' => 'Transaction contains invalid authentication information',
            '-23' => 'Invalid transaction context',
            '-24' => 'Transaction context data mismatch',
            '-25' => 'Transaction confirmation state was canceled by user',
            '-26' => 'Invalid action BIN',
            '-27' => 'Invalid merchant name',
            '-28' => 'Invalid incoming addendum(s)',
            '-29' => 'Invalid/duplicate authentication reference',
            '-30' => 'Transaction was declined as fraud',
            '-31' => 'Transaction already in progress',
            '-32' => 'Duplicate declined transaction',
            '-33' => 'Customer authentication by random amount or verify one-time code in progress',
            '-40' => 'Client side transaction form in progress',
            '00' => 'Transaction completed successfully',
            '01' => 'Refer to card issuer',
            '04' => 'Pick Up',
            '05' => 'Do not Honour',
            '06' => 'Error',
            '12' => 'Invalid transaction',
            '13' => 'Invalid amount',
            '14' => 'No such card',
            '15' => 'No such issuer',
            '17' => 'Customer cancellation',
            '30' => 'Format error',
            '35' => 'Pick-up, card acceptor contact acquirer',
            '36' => 'Pick up, card restricted',
            '37' => 'Pick up, call acquirer security',
            '38' => 'Pick up, Allowable PIN tries exceeded',
            '39' => 'No credit account',
            '40' => 'Requested function not supported',
            '41' => 'Pick up, lost card',
            '42' => 'No universal account',
            '43' => 'Pick up, stolen card',
            '54' => 'Expired card / target',
            '55' => 'Incorrect PIN',
            '56' => 'No card record',
            '57' => 'Transaction not permitted to cardholder',
            '58' => 'Transaction not permitted to terminal',
            '59' => 'Suspected fraud',
            '82' => 'Timeout',
            '85' => 'No reason to decline',
            '88' => 'Cryptographic failure',
            '89' => 'Authentication failure',
            '91' => 'Issuer or switch is inoperative',
            '95' => 'Reconcile error / Auth Not found',
            '96' => 'System Malfunction',
            '1A' => 'Call your bank',
            'B1' => 'Surcharge amount not permitted on Visa cards (U.S. acquirers only)',
            'N0' => 'Force STIP',
            'N3' => 'Cash service not available',
            'N4' => 'Cashback request exceeds issuer limit',
            'N7' => 'Decline for CVV2 failure',
            'P2' => 'Invalid biller information',
            'P5' => 'PIN change/unblock request declined',
            'P6' => 'Unsafe PIN',
            'Q1' => 'Card authentication failed',
            'R0' => 'Stop payment order',
            'R1' => 'Revocation of authorization order',
            'R3' => 'Revocation of all authorizations order',
            'FAR' => 'Forward to issuer',
            'XD' => 'Forward to issuer',
            'Z3' => 'Unable to go online'
        ]
    ];

    /**
     * Description: Terminal
     * Size: 8
     * Content: Echo of the request
     *
     * @var string
     */
    public $terminal;

    /**
     * Description: Transaction type
     * Size: 1-2
     * Content: Echo of the request
     *
     * @var integer
     */
    public $transactionType;

    /**
     * Description: Order
     * Size: 6
     * Content: Echo of the request
     *
     * @var string
     */
    public $order;

    /**
     * Description: Amount
     * Size: 12
     * Content: Amount of the order
     *
     * @var float
     */
    public $amount;

    /**
     * Description: Currency
     * Size: 3
     * Content: Echo of the request


     *
     * @var string
     */
    public $currency;

    /**
     * Description: Action
     * Size: 1-2
     * Contents: E-Gateway code of action:
     *              0 - successfully completed transaction;
     *              1 - duplicate transaction;
     *              2 - refused transaction;
     *              3 - transaction processing error
     *
     * @var integer
     */
    public $action;

    /**
     * Description: Completion code
     * Size: 2
     * Contents: Transaction processing response (ISO-8583, field 39)
     *
     * @var string
     */
    public $responseCode;

    /**
     * Description: Approval
     * Size: 6
     * Contents: Approval code (ISO-8583, field 38).
     *              It may be blank if not submitted by the card issuer.
     *
     * @var string
     */
    public $approval;

    /**
     * Description: Transaction reference
     * Size: 12
     * Contents: Transaction reference (ISO-8583 - 1987, field 37)
     *
     * @var string
     */
    public $retrievalReferenceNumber;

    /**
     * Description: Internal reference
     * Size: 16
     * Contents: Internal reference for e-Commerce gateway
     *
     * @var string
     */
    public $internalReference;

    /**
     * Description: Type of original transaction
     * Size: 1-2
     * Contents: Type of original transaction in response to "Status Check"
     *
     * @var integer
     */
    public $originalTransactionType;

    /**
     * Description: Text description of the completion code
     * Size: 1-255
     * Contents: Text description of the completion code
     *
     * @var string
     */
    public $statusMessage;

    /**
     * Description: Masked card number
     * Size: 16-19
     * Contents: Masked card number (eg "5100XXXXXXXX0022")
     *
     * @var string
     */
    public $cardNumber;

    /**
     * Description: Date / time
     * Size: 19
     * Contents: Date / time of the transaction in the format "YYYYMMDDHHMMSS"
     *
     * @var string
     */
    public $originalTransactionDate;

    /**
     * Description: Date / time
     * Size: 14
     * Contents: GMT / UTC response date / time in "YYYYMMDDHHMMSS" format
     *
     * @var string
     */
    public $timestamp;

    /**
     * Description: Authentication status
     * Size: 1
     * Contents: Authentication status used in the 3-D Secure scheme
     *
     * @var string
     */
    public $paresStatus;

    /**
     * Размер: 2
     * Съдържание: E-commerce индикатор (ECI)
     *
     * @var string
     */
    public $electronicCommerceIndicator;

    /**
     * Размер: 32
     * Съдържание: Ехо от заявката
     *
     * @var string
     */
    public $nonce;

    /**
     * Description: Signature
     * Size: 512
     * Contents: APGW message authentication code. It contains 256 bytes in hexadecimal format. May contain uppercase Latin letters A..F and numbers 0..9.
     *
     * @var string
     */
    public $pSign;

    /**
     * Description: Language
     * Size: 2
     * Content: Echo of the request
     *
     * @var string
     */
    public $language;

    /**
     * @var array
     */
    public $postData = [];

    /**
     * @var boolean
     */
    public $signatureIsVerified = false;

    /**
     * @param array $postData
     * @return Response|null
     */
    public static function withPost(array $postData) :? BoricaResponse {
        $instance = new self();

        $instance->transactionType = intval($postData['TRTYPE']);
        $instance->postData = $postData;

        if ($instance->transactionType == TransactionTypeInterface::SALE) {
            $instance->terminal = $postData['TERMINAL'];
            $instance->transactionType = $postData['TRTYPE'];
            $instance->order = $postData['ORDER'];
            $instance->amount = floatval($postData['AMOUNT']);
            $instance->currency = $postData['CURRENCY'];
            $instance->action = intval($postData['ACTION']);
            $instance->responseCode = $postData['RC'];
            $instance->approval = $postData['APPROVAL'];
            $instance->retrievalReferenceNumber = $postData['RRN'];
            $instance->internalReference = $postData['INT_REF'];
            $instance->statusMessage = $postData['STATUSMSG'];
            $instance->cardNumber = $postData['CARD'];
            $instance->originalTransactionDate = $postData['TRAN_DATE'];
            $instance->timestamp = $postData['TIMESTAMP'];
            $instance->paresStatus = $postData['PARES_STATUS'];
            $instance->electronicCommerceIndicator = $postData['ECI'];
            $instance->nonce = $postData['NONCE'];
            $instance->pSign = $postData['P_SIGN'];
            $instance->originalTransactionType = $postData['TRAN_TRTYPE'] ?? null;
            $instance->language = $postData['LANG'];
            // TODO: Review "MERCH_TOKEN_ID", "NEW_PARES" and "IPS_ECI" when new official documentation.

        } else {
            return null;
        }

        return $instance;
    }

    /**
     * Request was successful
     *
     * @return boolean
     */
    public function isSuccessful() : bool {
        return $this->responseCode == '00';
    }

    /**
     * @param BoricaResponse $borica
     * @return BoricaResponse
     */
    public function verify(Borica $borica,$extender_mac = true) : BoricaResponse {
        $mac_fields = $extender_mac ? self::MAC_EXTENDED_FIELDS[$this->transactionType]:self::MAC_FIELDS[$this->transactionType];

        $mac = Borica::generateMacExtended($this->postData, $mac_fields, true);

        $this->signatureIsVerified = $borica->verifySignature($mac, $this->pSign);

        return $this;
    }

    /**
     * Response code in human-readable format
     *
     * @param string $lang Language ("bg" or "en")
     * @return string
     */
    public function responseCodeDescription($lang = 'bg') : string {
        if (isset($this->responseCode) && array_key_exists($this->responseCode, $this::RESPONSE_CODES[$lang])) {
            return $this::RESPONSE_CODES[$lang][$this->responseCode];
        }

        return '';
    }

}
