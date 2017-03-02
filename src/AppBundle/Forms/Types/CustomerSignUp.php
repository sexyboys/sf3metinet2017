<?php

namespace AppBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Boris Guéry <guery.b@gmail.com>
 */
class CustomerSignUp extends AbstractType
{
    public function getParent()
    {
        return GenericSignUp::class;
    }
}
