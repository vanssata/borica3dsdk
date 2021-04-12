<?php
declare(strict_types=1);

namespace Vanssa\BoricaSDK\Request\Type;

use Vanssa\BoricaSDK\MacFieldsInterface;
use Vanssa\BoricaSDK\Request\RequestInterface;

interface RequestTypeInterface extends RequestInterface, MacFieldsInterface
{
    public function getType(): int;

    public function dataField(): array;

    public static function getRequestMandatoryProperties(): array;
}
