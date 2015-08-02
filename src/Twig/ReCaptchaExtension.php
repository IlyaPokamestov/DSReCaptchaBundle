<?php

/*
 * This file is part of the ReCaptcha Bundle.
 *
 * (c) Ilya Pokamestov <dario_swain@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace DS\ReCaptchaBundle\Twig;

use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\Intl\Locale\Locale;

class ReCaptchaExtension extends \Twig_Extension
{
    /** @var  string */
    protected $jsApiUrl;
    /** @var  string */
    protected $publicKey;
    /** @var  string */
    protected $locale;
    /** @var  string */
    protected $fieldPattern = <<<EOD
<div class="g-recaptcha" data-sitekey="%s"></div>
<script src="%s?hl=%s" async defer></script>
EOD;

    public function __construct($jsApiUrl, $publicKey, $locale = null)
    {
        if (null === $jsApiUrl) {
            throw new InvalidConfigurationException('The parameters "js_api_url" must be configured.');
        }

        if (null === $publicKey) {
            throw new InvalidConfigurationException('The parameters "public_key" must be configured.');
        }

        if (null === $locale) {
            $this->locale = Locale::getDefault();
        } else {
            $this->locale = $locale;
        }

        $this->publicKey = $publicKey;
        $this->jsApiUrl = $jsApiUrl;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                're_captcha_field',
                array($this, 'reCaptchaField'),
                array('is_safe' => array('html'))
            )
        );
    }

    public function reCaptchaField()
    {
        return sprintf($this->fieldPattern, $this->publicKey, $this->jsApiUrl, $this->locale);
    }

    public function getName()
    {
        return 're-captcha';
    }
}