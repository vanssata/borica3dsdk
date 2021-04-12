<?php


namespace Vanssa\BoricaSDK\Request\Type;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Vanssa\BoricaSDK\Request\AbstractRequest;

class SaleRequest extends AbstractRequest implements RequestTypeInterface
{
    protected $transactionType = 1;

    public static function getMacFields () :array {
        return
        ['TERMINAL', 'TRTYPE', 'AMOUNT', 'CURRENCY', 'TIMESTAMP'];
    }
    public static function getMacExtendedFields() :array
    {
        return ['TERMINAL', 'TRTYPE', 'AMOUNT', 'CURRENCY', 'ORDER', 'MERCHANT', 'TIMESTAMP', 'NONCE'];
    }

    public static function getRequestMandatoryProperties():array {
        return[ 'amount', 'currency', 'terminal', 'merchant', 'transactionType', 'order', 'timestamp', 'nonce', 'pSign'];
    }

    final public function dataField(): array
    {
        return [
            'AMOUNT' => $this->getAmount(),
            'CURRENCY' => $this->currency,
            'TERMINAL' => $this->terminal,
            'MERCHANT' => $this->merchant,
            'TRTYPE' => $this->transactionType,
            'ORDER' => $this->getOrder(),
            'TIMESTAMP' => $this->timestamp,
            'NONCE' => $this->nonce,
            'P_SIGN' => $this->pSign,
            'DESC' => $this->description,
            'MERCH_NAME' => $this->merchantName,
            'MERCH_URL' => $this->merchantUrl,
            'EMAIL' => $this->email,
            'COUNTRY' => $this->country,
            'MERCH_GMT' => $this->merchantTimezone,
            'LANG' => $this->language,
            'AD.CUST_BOR_ORDER_ID' => $this->adCustBorOrderId,
            'ADDENDUM' => $this->addendum,
            'BACKREF' => $this->getBackRefUrl(),
        ];
    }


    public static function resolveArrayOptions(array $options): array
    {
            $resovler = new OptionsResolver();
            $resovler->setRequired([
                "Amount",
                "Currency",
                "Order",
                "Description",
                "MerchantName",
                "MerchantUrl",
                "Merchant",
                "Terminal",
                "Email",
                "Country",
                "MerchantTimezone",
                "Timestamp",
                "Nonce",
                "OrderIdentifier",
                "Addendum",
                "BackRefUrl"
            ]);
            $resovler->setDefault('BackRefUrl', null);
            $resovler->setAllowedTypes("Amount", 'float');
            $resovler->setAllowedTypes("Currency", 'string');
            $resovler->setAllowedTypes("Order", ['int','string']);
            $resovler->setAllowedTypes("Description", 'string');
            $resovler->setAllowedTypes("MerchantName", 'string');
            $resovler->setAllowedTypes("MerchantUrl", 'string');
            $resovler->setAllowedTypes("Merchant", 'string');
            $resovler->setAllowedTypes("Terminal", 'string');
            $resovler->setAllowedTypes("Email", 'string');
            $resovler->setAllowedTypes("Country", 'string');
            $resovler->setAllowedTypes("MerchantTimezone", 'string');
            $resovler->setAllowedTypes("Timestamp", ['int','string']);
            $resovler->setAllowedTypes("Nonce", 'string');
            $resovler->setAllowedTypes("OrderIdentifier", 'string');
            $resovler->setAllowedTypes("Addendum", 'string');
            $resovler->setAllowedTypes("BackRefUrl", ['string','null']);


            return $resovler->resolve($options);
    }


    public function getType(): int
    {
        return $this->transactionType;
    }
}
