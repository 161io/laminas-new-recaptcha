<?php
/**
 * @link      https://github.com/161io/laminas-new-recaptcha
 * @copyright (c) 161 SARL - contact(at)161.io
 * @license   MIT License
 */

namespace NewReCaptcha;

use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'new_recaptcha' => [
        //'site_key'   => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        //'secret_key' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        //'remote_ip'  => false,
    ],
    'form_elements' => [
        'aliases' => [
            'newreraptcha' => Form\Element\NewReCaptcha::class,
            'newReCaptcha' => Form\Element\NewReCaptcha::class,
            'NewReCaptcha' => Form\Element\NewReCaptcha::class,
        ],
        'factories' => [
            Form\Element\NewReCaptcha::class => Form\Element\Service\NewReCaptchaFactory::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'formnewrecaptcha' => Form\View\Helper\FormNewReCaptcha::class,
            'formNewReCaptcha' => Form\View\Helper\FormNewReCaptcha::class,
            'FormNewReCaptcha' => Form\View\Helper\FormNewReCaptcha::class,
        ],
        'factories' => [
            Form\View\Helper\FormNewReCaptcha::class => InvokableFactory::class,
        ],
    ],
];
