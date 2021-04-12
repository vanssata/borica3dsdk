<?php
declare(strict_types=1);
namespace Vanssa\BoricaSDK;


interface BoricaFactoryInterface
{
    public static function create(): Borica;
    public static function createWhitData(array $options): Borica;
}
