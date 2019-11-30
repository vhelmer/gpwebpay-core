<?php declare(strict_types=1);

namespace Pixidos\GPWebPay\Data;

use Pixidos\GPWebPay\Enum;
use Pixidos\GPWebPay\Enum\Param;
use Pixidos\GPWebPay\Exceptions\InvalidArgumentException;
use Pixidos\GPWebPay\Param\DepositFlag;
use Pixidos\GPWebPay\Param\Digest;
use Pixidos\GPWebPay\Param\IParam;
use Pixidos\GPWebPay\Param\MerchantNumber;
use UnexpectedValueException;

/**
 * Class Request
 * @package Pixidos\GPWebPay
 * @author Ondra Votava <ondra.votava@pixidos.com>
 */
class Request implements IRequest
{
    /**
     * @deprecated  use Param::MERCHANTNUMBER constan will be removed in next major version
     */
    public const MERCHANTNUMBER = 'MERCHANTNUMBER';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const OPERATION = 'OPERATION';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const ORDERNUMBER = 'ORDERNUMBER';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const AMOUNT = 'AMOUNT';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const CURRENCY = 'CURRENCY';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const DEPOSITFLAG = 'DEPOSITFLAG';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const MERORDERNUM = 'MERORDERNUM';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const URL = 'URL';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const DESCRIPTION = 'DESCRIPTION';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const MD = 'MD';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const USERPARAM_1 = 'USERPARAM1';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const FASTPAYID = 'FASTPAYID';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const PAYMETHOD = 'PAYMETHOD';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const DISABLEPAYMETHOD = 'DISABLEPAYMETHOD';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const PAYMETHODS = 'PAYMETHODS';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const EMAIL = 'EMAIL';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const REFERENCENUMBER = 'REFERENCENUMBER';
    /**
     * @deprecated use Param::OPERATION constan will be removed in next major version
     */
    public const ADDINFO = 'ADDINFO';


    /**
     *
     * @var array DIGEST_PARAMS_KEYS
     */
    private const DIGEST_PARAMS_KEYS = [
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
    ];
    /**
     * @var  IOperation $operation
     */
    private $operation;
    /**
     * @var string|null $url
     */
    /**
     * @var array $params
     */
    private $params;
    /**
     * @var string
     */
    private $url;

    /**
     * @param IOperation            $operation
     * @param string|MerchantNumber $merchantNumber
     * @param int|DepositFlag       $depositFlag
     * @param string                $url
     *
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function __construct(IOperation $operation, $merchantNumber, $depositFlag, string $url)
    {
        $this->operation = $operation;
        $this->url = $url;

        if (!($merchantNumber instanceof MerchantNumber)) {
            trigger_error(
                sprintf(
                    'Use scalar value instead of %s is depracated and support will be removed in next major version',
                    MerchantNumber::class
                ),
                E_USER_DEPRECATED
            );
            $merchantNumber = new MerchantNumber($merchantNumber);
        }
        if (!($depositFlag instanceof DepositFlag)) {
            trigger_error(
                sprintf(
                    'Use scalar value instead of %s is depracated and support will be removed in next major version',
                    DepositFlag::class
                ),
                E_USER_DEPRECATED
            );
            $depositFlag = new DepositFlag(new Enum\DepositFlag($depositFlag));
        }

        $this->setParam($merchantNumber);
        $this->setParam($depositFlag);

        $this->setParams();

    }

    /**
     * Method only for ISinger
     *
     * @param string $digest
     *
     * @throws InvalidArgumentException
     * @internal
     *
     * @deprecated use setParam(new Digest($digest))
     */
    public function setDigest(string $digest): void
    {
        trigger_error(
            sprintf('%s is depracated. Use %s::setParam(new Digest($digest))', __METHOD__, __CLASS__),
            E_USER_DEPRECATED
        );
        $this->setParam(new Digest($digest));
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return array
     */
    public function getDigestParams(): array
    {
        return array_intersect_key($this->params, array_flip(self::DIGEST_PARAMS_KEYS));
    }

    /**
     * @param IParam $param
     */
    public function setParam(IParam $param): void
    {
        $this->params[$param->getParamName()] = (string)$param;
    }

    public function getRequestUrl(bool $asPost = false): string
    {
        if ($asPost) {
            return $this->url;
        }

        return $this->url . '?' . http_build_query($this->getParams());
    }


    /**
     * Sets params to array
     */
    private function setParams(): void
    {
        foreach ($this->operation->getParams() as $param) {
            $this->setParam($param);
        }
    }
}