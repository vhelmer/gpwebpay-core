<?php declare(strict_types=1);

/**
 * This file is part of the Pixidos package.
 *
 *  (c) Ondra Votava <ondra@votava.it>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */

namespace Pixidos\GPWebPay\Param;

use Pixidos\GPWebPay\Data\Response;
use Pixidos\GPWebPay\Enum\Param;

final class DigestParams
{
    /**
     *
     * @var array DIGEST_PARAMS_KEYS
     */
    public const DIGEST_PARAMS_KEYS = [
        Param::MERCHANTNUMBER,
        Param::OPERATION,
        Param::ORDERNUMBER,
        Param::AMOUNT,
        Param::CURRENCY,
        Param::DEPOSITFLAG,
        Param::MERORDERNUM,
        Param::RESPONSE_URL,
        Param::DESCRIPTION,
        Param::MD,
        Param::USERPARAM,
        Param::FASTPAYID,
        Param::PAYMETHOD,
        Param::DISABLEPAYMETHOD,
        Param::PAYMETHODS,
        Param::EMAIL,
        Param::REFERENCENUMBER,
        Param::ADDINFO,
        Param::TOKEN,
        Response::RESULTTEXT,
        Response::SRCODE,
        Response::PRCODE,
        Response::EXPIRY,
        Response::ACSRES,
        Response::ACCODE,
        Response::DAYTOCAPTURE,
        Response::TOKENREGSTATUS,
    ];

    /**
     * @param array $params
     * @return array
     */
    public static function getDigestParams(array $params): array
    {
        return array_intersect_key($params, array_flip(self::DIGEST_PARAMS_KEYS));
    }
}