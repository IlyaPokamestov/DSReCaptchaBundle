<?php
/*
* This file is part of the ReCaptcha Validator Component.
*
* (c) Ilya Pokamestov
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace DS\ReCaptchaBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * ReCaptcha Constraint.
 *
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class ReCaptchaConstraint extends Constraint
{
    /** @var string */
    public $message = 're_captcha.invalid';

    /** @return string */
    public function validatedBy()
    {
        return 're_captcha.validator';
    }
}
