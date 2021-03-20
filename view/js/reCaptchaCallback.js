/*!
 * @link      https://github.com/161io/laminas-new-recaptcha
 * @copyright (c) 161 SARL - contact(at)161.io
 * @license   MIT License
 */

(function(window, document, $, undefined) {
    'use strict';

    /**
     * Transform INPUT type="hidden" on DIV reCAPTCHA
     */
    window.reCaptchaCallback = function() {
        if(!$('[data-sitekey]').length) { return; }

        var $head = $('head');
        if(!$head.data('recaptcha')) {
            $head
                .data('recaptcha', true)
                .append('<script src="//www.google.com/recaptcha/api.js?onload=reCaptchaCallback&render=explicit"></script>');
            return;
        }

        $('input[data-sitekey]').each(function() {
            var $input = $(this);
            if($input.data('recaptcha')) { return; }
            $input.data('recaptcha', true);

            var $div = $('<div class="g-recaptcha"></div>');
            $div.insertAfter($input);
            grecaptcha.render($div[0], {
                'sitekey': $input.attr('data-sitekey'),
            });
        });
    };

    $(function() {
        reCaptchaCallback();
    });

})(window, document, jQuery);
