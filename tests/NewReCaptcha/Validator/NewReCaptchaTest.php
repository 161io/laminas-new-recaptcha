<?php
/**
 * @link      https://github.com/161io/laminas-new-recaptcha
 * @copyright (c) 161 SARL - contact(at)161.io
 * @license   MIT License
 */

namespace NewReCaptchaTest\Validator;

use Laminas\Stdlib\Parameters;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use NewReCaptcha\Validator\NewReCaptcha;

class NewReCaptchaTest extends AbstractHttpControllerTestCase
{
    protected function setUp()
    {
        $this->setApplicationConfig(include 'config/application.config.php');
        parent::setUp();
    }

    public function testIsValid1()
    {
        $container = $this->getApplicationServiceLocator();

        /** @var \NewReCaptcha\Form\Element\NewReCaptcha $element */
        $element = $container->get('FormElementManager')->get('NewReCaptcha');

        /** @var \NewReCaptcha\Validator\NewReCaptcha $validator */
        $validator = $element->getValidator();

        $this->assertInstanceOf('NewReCaptcha\Validator\NewReCaptcha', $validator);
        $this->assertIsString($validator->getIpAddress());
        $this->assertFalse($validator->isValid(null));
        $this->assertArrayHasKey(NewReCaptcha::MISSING_VALUE, $validator->getOption('messages'));
    }

    public function testIsValid2()
    {
        $container = $this->getApplicationServiceLocator();
        /** @var \Laminas\Http\Request $request */
        $request = $container->get('Request');
        $request->setMethod($request::METHOD_POST);
        $request->setPost(new Parameters([
            NewReCaptcha::NAME => time(),
        ]));

        /** @var \NewReCaptcha\Form\Element\NewReCaptcha $element */
        $element = $container->get('FormElementManager')->get('NewReCaptcha');

        /** @var \NewReCaptcha\Validator\NewReCaptcha $validator */
        $validator = $element->getValidator();

        $this->assertInstanceOf('NewReCaptcha\Validator\NewReCaptcha', $validator);
        $this->assertIsString($validator->getIpAddress());
        $this->assertFalse($validator->isValid(null));
        $this->assertArrayHasKey(NewReCaptcha::BAD_CAPTCHA, $validator->getOption('messages'));
    }
}
