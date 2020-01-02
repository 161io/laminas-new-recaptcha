<?php
/**
 * @link      https://github.com/161io/laminas-new-recaptcha
 * @copyright (c) 161 SARL - contact(at)161.io
 * @license   MIT License
 */

namespace NewReCaptcha\Form\Element\Service;

use Psr\Container\ContainerInterface;
use NewReCaptcha\Form\Element\NewReCaptcha;

class NewReCaptchaFactory
{
    /**
     * @param  ContainerInterface $container
     * @return NewReCaptcha
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('Config');

        $element = new NewReCaptcha();
        if (isset($config['new_recaptcha'])) {
            $configCaptcha = $config['new_recaptcha'];
            if (!empty($configCaptcha['site_key']) && !empty($configCaptcha['secret_key'])) {
                $element->setSiteKey($configCaptcha['site_key']);
                $element->setSecretKey($configCaptcha['secret_key']);
            }
            if (isset($configCaptcha['remote_ip'])) {
                $element->setRemoteIp($configCaptcha['remote_ip']);
            }
        }
        $element->setRequest($container->get('Request'));
        return $element;
    }
}
