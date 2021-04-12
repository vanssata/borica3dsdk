<?php
declare(strict_types=1);


namespace Vanssa\BoricaSDK\Request;

use Vanssa\BoricaSDK\Request\Type\RequestTypeInterface;

interface RequestFactoryInterface
{
    public static function create(string $type): RequestTypeInterface;

    public static function createRequestWhitTypeAndData(string $type,array $borica_options, array $data):? RequestTypeInterface;

}
