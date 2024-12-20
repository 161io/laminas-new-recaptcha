<?php
/**
 * @link      https://github.com/161io/laminas-new-recaptcha
 * @copyright (c) 161 SARL - contact(at)161.io
 * @license   MIT License
 */

namespace NewReCaptcha\Validator;

use Laminas\Http\Client;
use Laminas\Http\PhpEnvironment\RemoteAddress;
use Laminas\Http\Request;
use Laminas\Validator\AbstractValidator;
use Laminas\Validator\Exception;

class NewReCaptcha extends AbstractValidator
{
    /**
     * @const string
     */
    public const URL_VERIFY = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Input name
     *
     * @const string
     */
    public const NAME = 'g-recaptcha-response';

    /**#@+
     * Error codes
     *
     * @const const
     */
    public const MISSING_VALUE = 'missingValue';
    public const BAD_CAPTCHA   = 'badCaptcha';
    /**#@-*/

    /**
     * Error messages
     *
     * @var array
     */
    protected $messageTemplates = [
        self::MISSING_VALUE => 'Missing captcha fields',
        self::BAD_CAPTCHA   => 'reCaptcha value is wrong',
    ];

    /**
     * @var string
     */
    protected $ipAddress;

    /**
     * Check IP
     *
     * @return bool
     */
    public function withRemoteIp()
    {
        return $this->getOption('remote_ip') && $this->getIpAddress();
    }

    /**
     * Private key
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->getOption('secret_key');
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->getOption('request');
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        if (null === $this->ipAddress) {
            $remote = new RemoteAddress();
            $this->ipAddress = $remote->getIpAddress();
        }
        return $this->ipAddress;
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  string $value
     * @return bool
     * @throws \Exception If validation of $value is impossible
     */
    public function isValid($value)
    {
        $request = $this->getRequest();
        if (!$request->getPost(static::NAME)) {
            $this->error(static::MISSING_VALUE);
            return false;
        }

        $value = $request->getPost(static::NAME);
        $siteVerify  = static::URL_VERIFY;
        $siteVerify .= '?secret=' . $this->getSecretKey();
        $siteVerify .= '&response=' . \urlencode($value);
        if ($this->withRemoteIp()) {
            $siteVerify .= '&remoteip=' . \urlencode($this->getIpAddress());
        }

        $cli = new Client($siteVerify);
        try {
            $response = $cli->send();
        } catch (\Exception $exc) {
            // Skip SSL
            $cli = new Client($siteVerify, [
                'sslverifypeer' => false,
            ]);
            $response = $cli->send();
        }

        $result = \json_decode($response->getBody(), true);
        if (isset($result['success']) && $result['success']) {
            return true;
        }
        $this->error(static::BAD_CAPTCHA);
        return false;
    }
}
