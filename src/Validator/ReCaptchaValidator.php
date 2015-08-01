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

use DS\Library\ReCaptcha\Http\Driver\DriverInterface;
use DS\Library\ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

/**
 * ReCaptcha Validator.
 *
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class ReCaptchaValidator extends ConstraintValidator
{
    /** @var Request */
    protected $request;
    /** @var  ReCaptcha */
    protected $reCaptcha;

    /**
     * @param Request $request
     * @param ReCaptcha $reCaptcha
     */
    public function __construct(Request $request, ReCaptcha $reCaptcha)
    {
        $this->request = $request;
        $this->reCaptcha = $reCaptcha;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!($constraint instanceof ReCaptchaConstraint)) {
            throw new InvalidArgumentException('Use ReCaptchaConstraint for ReCaptchaValidator.');
        }

        if ($this->request->get('g-recaptcha-response', false)) {
            $this->reCaptcha->setClientIp($this->request->getClientIp())
                ->setGReCaptchaResponse($this->request->get('g-recaptcha-response', false));
            $response = $this->reCaptcha->buildRequest()->send();
            if (!$response->isSuccess()) {
                $this->context->addViolation($constraint->message);
            } else {
                $this->request->request->remove('g-recaptcha-response');
            }
        } else {
            $this->context->addViolation($constraint->message);
        }
    }
}
