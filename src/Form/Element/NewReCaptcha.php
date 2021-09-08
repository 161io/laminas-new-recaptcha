<?php
/**
 * @link      https://github.com/161io/laminas-new-recaptcha
 * @copyright (c) 161 SARL - contact(at)161.io
 * @license   MIT License
 */

namespace NewReCaptcha\Form\Element;

use Laminas\Form\ElementPrepareAwareInterface;
use Laminas\Form\Exception;
use Laminas\Form\Element;
use Laminas\Form\FormInterface;
use Laminas\Http\Request;
use Laminas\InputFilter\InputProviderInterface;
use Laminas\Validator\ValidatorInterface;
use NewReCaptcha\Validator\NewReCaptcha as NewReCaptchaValidator;

class NewReCaptcha extends Element implements InputProviderInterface, ElementPrepareAwareInterface
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'hidden',
    ];

    /**
     * Public key
     *
     * @var string
     */
    protected $siteKey;

    /**
     * Private key
     *
     * @var string
     */
    protected $secretKey;

    /**
     * Check IP
     *
     * @var bool
     */
    protected $remoteIp = true;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * reCAPTCHA options
     * - site_key: Public key (html)
     * - secret_key: Private key
     * - remote_ip: Check IP
     *
     * @param  array|\Traversable $options
     * @return self
     * @throws Exception\InvalidArgumentException
     */
    public function setOptions($options)
    {
        parent::setOptions($options);

        if (empty($options['site_key']) || empty($options['secret_key'])) {
            throw new Exception\InvalidArgumentException(
                'The options site_key and/or secret_key were not found'
            );
        }
        $this->setSiteKey($options['site_key']);
        $this->setSecretKey($options['secret_key']);
        if (isset($options['remote_ip'])) {
            $this->setRemoteIp($options['remote_ip']);
        }
        return $this;
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        if (null === $this->validator) {
            $this->validator = new NewReCaptchaValidator([
                'request'    => $this->getRequest(),
                'secret_key' => $this->getSecretKey(),
                'remote_ip'  => $this->getRemoteIp(),
            ]);
        }
        return $this->validator;
    }

    /**
     * @param  ValidatorInterface $validator
     * @return self
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * Public key (html)
     *
     * @return string
     */
    public function getSiteKey()
    {
        return $this->siteKey;
    }

    /**
     * Public key
     *
     * @param  string $siteKey
     * @return self
     */
    public function setSiteKey($siteKey)
    {
        $this->siteKey = (string) $siteKey;
        $this->setAttribute('data-sitekey', $this->siteKey); // input type="hidden"
        return $this;
    }

    /**
     * Private key
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * Private key
     *
     * @param  string $secretKey
     * @return self
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = (string) $secretKey;
        return $this;
    }

    /**
     * Check IP
     *
     * @return bool
     */
    public function getRemoteIp()
    {
        return $this->remoteIp;
    }

    /**
     * Check IP
     *
     * @param  bool $remoteIp
     * @return self
     */
    public function setRemoteIp($remoteIp)
    {
        $this->remoteIp = (bool) $remoteIp;
        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param  Request $request
     * @return self
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * Provide default input rules for this element
     *
     * @return array
     */
    public function getInputSpecification()
    {
        return [
            'name'       => $this->getName(),
            'required'   => true,
            'validators' => [
                $this->getValidator(),
            ],
        ];
    }

    /**
     * @param  FormInterface $form
     * @return mixed
     */
    public function prepareElement(FormInterface $form): void
    {
        $this->setValue('1');
    }
}
