<?php
declare(strict_types=1);

namespace Vanssa\BoricaSDK;


interface TransactionTypeInterface
{
    /**
     * Sale
     */
    const SALE = 1;

    /**
     * DEFERRED AUTHORIZATION
     */
    const DEFERRED_AUTHORIZATION = 12;

    /**
     * COMPLETE DEFERRED AUTHORIZATION
     */
    const COMPLETE_DEFERRED_AUTHORIZATION = 21;

    /**
     * REVERSE DEFERRED AUTHORIZATION
     */
    const REVERSE_DEFERRED_AUTHORIZATION = 22;

    /**
     * REVERSAL
     */
    const REVERSAL = 24;

    /**
     * STATUS CHECK
     */
    const STATUS_CHECK = 90;
}
