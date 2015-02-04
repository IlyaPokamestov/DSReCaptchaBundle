ReCAPTCHA ver.2 for Symfony2 applications
================================================

You can find full documentation about Google reCAPTCHA API v2 [here](http://developers.google.com/recaptcha/intro).

Installation
------------

You can install this package with [Composer](http://getcomposer.org/).
Add next lines to your composer.json file:

``` json
{
    "require": {
        "dario_swain/ds-recaptcha-bundle":                 "dev-master"
    }
}
```

Add bundle to your AppKernel.php:

``` php
<?php
...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            ...
            new DS\ReCaptchaBundle\ReCaptchaBundle(),
        );

        ...
    }
}

```


Usage Example
-------------

Add to your config.yml:

``` yaml
re_captcha:
    public_key: #YOUR_PUBLIC_KEY#
    private_key: #YOUR_PRIVATE_KEY#
    locale: "%locale%"
```

After this you can add reCAPTCHA type to your custom form:

``` php
<?php

namespace AcmeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('message', 'textarea')
            /** In type add your form alias **/
			->add('captcha', 'ds_re_captcha', array('mapped' => false))
			->add('send', 'submit');
    }
}

```

Next step, you need to add form_theme to your form view, it seems like that:

```twig
{% extends 'AcmeBundle::layout.html.twig' %}
{% form_theme form 'ReCaptchaBundle::form_div_layout.html.twig' %}
{% block content %}
    {{ form_start(form) }}
    {{ form_widget(form) }}
    {{ form_end(form) }}
{% endblock %}
```

Copyright
---------

Copyright (c) 2015 Ilya Pokamestov <dario_swain@yahoo.com>.