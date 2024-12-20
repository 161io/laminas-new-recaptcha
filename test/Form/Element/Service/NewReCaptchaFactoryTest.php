<?php
/**
 * @link      https://github.com/161io/laminas-new-recaptcha
 * @copyright (c) 161 SARL - contact(at)161.io
 * @license   MIT License
 */

declare(strict_types=1);

namespace NewReCaptchaTest\Form\Element\Service;

use Laminas\Http\Request;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use NewReCaptcha\Form\Element\NewReCaptcha;
use NewReCaptcha\Validator\NewReCaptcha as NewReCaptchaValidator;

class NewReCaptchaFactoryTest extends AbstractHttpControllerTestCase
{
    protected function setUp(): void
    {
        $this->setApplicationConfig(include 'config/application.config.php');
        parent::setUp();
    }

    public function testCreateService(): void
    {
        $container = $this->getApplicationServiceLocator();

        /** @var NewReCaptcha $element */
        $element = $container->get('FormElementManager')->get(NewReCaptcha::class);
        $this->assertInstanceOf(NewReCaptcha::class, $element);
        $this->assertInstanceOf(NewReCaptchaValidator::class, $element->getValidator());
        $this->assertInstanceOf(Request::class, $element->getRequest());
    }

    public function testCreateServiceByAlias(): void
    {
        $container = $this->getApplicationServiceLocator();

        /** @var NewReCaptcha $element */
        $element = $container->get('FormElementManager')->get('NewReCaptcha');
        $this->assertInstanceOf(NewReCaptcha::class, $element);
        $this->assertInstanceOf(NewReCaptchaValidator::class, $element->getValidator());
        $this->assertInstanceOf(Request::class, $element->getRequest());
    }
}
