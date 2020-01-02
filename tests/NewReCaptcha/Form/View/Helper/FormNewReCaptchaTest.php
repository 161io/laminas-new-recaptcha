<?php
/**
 * @link      https://github.com/161io/laminas-new-recaptcha
 * @copyright (c) 161 SARL - contact(at)161.io
 * @license   MIT License
 */

namespace NewReCaptchaTest\Form\View\Helper;

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use NewReCaptcha\Form\View\Helper\FormNewReCaptcha;

class FormNewReCaptchaTest extends AbstractHttpControllerTestCase
{
    protected function setUp()
    {
        $this->setApplicationConfig(include 'config/application.config.php');
        parent::setUp();
    }

    public function testCreateService()
    {
        $container = $this->getApplicationServiceLocator();

        /** @var FormNewReCaptcha $helper */
        $helper = $container->get('ViewHelperManager')->get('FormNewReCaptcha');
        $this->assertInstanceOf(FormNewReCaptcha::class, $helper);
    }

    public function testAppendApiJs()
    {
        $container = $this->getApplicationServiceLocator();

        /** @var FormNewReCaptcha $helper */
        $helper = $container->get('ViewHelperManager')->get('FormNewReCaptcha');
        $helper->appendApiJs();
    }

    public function testGetSetTheme()
    {
        $container = $this->getApplicationServiceLocator();

        /** @var FormNewReCaptcha $helper */
        $helper = $container->get('ViewHelperManager')->get('FormNewReCaptcha');
        $this->assertNull($helper->getTheme());

        $helper->setTheme('toto');
        $this->assertNull($helper->getTheme());

        $helper->setTheme('dark');
        $this->assertEquals('dark', $helper->getTheme());

        $helper->setTheme('light');
        $this->assertEquals('light', $helper->getTheme());
    }
}
