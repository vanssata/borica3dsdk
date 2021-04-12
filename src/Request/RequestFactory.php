<?php
declare(strict_types=1);


namespace Vanssa\BoricaSDK\Request;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Vanssa\BoricaSDK\BoricaFactory;
use Vanssa\BoricaSDK\Request\Type\RequestTypeInterface;
use Vanssa\BoricaSDK\Request\Type\SaleTransaction;

class RequestFactory implements RequestFactoryInterface
{

    public static function create(string $type): RequestTypeInterface
    {
        $request = new $type;


        if (!$request instanceof RequestTypeInterface) {
            throw new \Exception("Cannot crate class: " . $type);
        }
        return $request;

    }

    public static function createRequestWhitTypeAndData(string $type, array $borica_options, array $data): ?RequestTypeInterface
    {
        try {
            $request = self::create($type);

            $borica = BoricaFactory::createWhitData($borica_options);
            $request->setBorica($borica);
            $request->setDataFromArray($data);
            return $request;

        } catch (\Exception $e) {
            throw new \Exception('Cannot find class: ' . $e->getMessage(), 2);
        }
    }

}
