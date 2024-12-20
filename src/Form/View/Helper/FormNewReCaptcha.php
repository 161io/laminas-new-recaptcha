<?php
/**
 * @link      https://github.com/161io/laminas-new-recaptcha
 * @copyright (c) 161 SARL - contact(at)161.io
 * @license   MIT License
 */

namespace NewReCaptcha\Form\View\Helper;

use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\FormHidden;
use Laminas\View\Helper\AbstractHelper;
use NewReCaptcha\Form\Element\NewReCaptcha;

use function in_array;

/**
 * Helper: $this->formNewReCaptcha()
 * @see FormHidden
 */
class FormNewReCaptcha extends AbstractHelper
{
    /**
     * @const string
     */
    public const URL_API_JS = 'https://www.google.com/recaptcha/api.js';

    /**
     * The color theme of the widget
     *
     * @var string
     */
    protected $theme = null;

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  NewReCaptcha|ElementInterface $element
     * @param  bool $withApiJs
     * @param  string $theme 'light' or 'dark'
     * @return string|$this
     */
    public function __invoke(?ElementInterface $element = null, $withApiJs = true, $theme = null)
    {
        if ($withApiJs) {
            $this->appendApiJs();
        }

        if (!$element || !$element instanceof NewReCaptcha) {
            return $this;
        }
        if ($theme) {
            $this->setTheme($theme);
        }
        return $this->render($element);
    }

    /**
     * @param  NewReCaptcha $newReCaptcha
     * @return string
     */
    public function render(ElementInterface $newReCaptcha)
    {
        /** @var FormHidden $url */
        $formHidden = $this->view->plugin('formHidden');
        $html  = $formHidden($newReCaptcha);
        $html .= '<div class="g-recaptcha"';
        $html .= ' data-sitekey="' . $newReCaptcha->getSiteKey() . '"';
        if ($this->theme) {
            $html .= ' data-theme="' . $this->theme . '"';
        }
        $html .= '>';
        if (!$newReCaptcha->getSiteKey()) {
            $html .= '<code>data-sitekey</code> was empty.';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * @return $this
     */
    public function appendApiJs()
    {
        $this->view->plugin('headScript')->appendFile(static::URL_API_JS);
        return $this;
    }

    /**
     * The color theme of the widget
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * The color theme of the widget
     *
     * @param  string $theme
     * @return $this
     */
    public function setTheme($theme = null)
    {
        if (!in_array($theme, ['light', 'dark'])) {
            $theme = null;
        }
        $this->theme = $theme;
        return $this;
    }
}
