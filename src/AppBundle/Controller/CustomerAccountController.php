<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Controller;

use AppBundle\Forms\Types\CustomerSignUp;
use AppBundle\Forms\Types\SignIn;
use AppBundle\Models\CustomerSignUp as CustomerSignUpDto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class CustomerAccountController extends Controller
{
    public function signInAction(Request $request)
    {
        $form = $this->createForm(SignIn::class);

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@App/CustomerAccount/signIn.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error,
            'signInForm' => $form->createView(),
        ]);
    }

    public function signUpAction(Request $request)
    {
        $form = $this->createForm(CustomerSignUp::class, new CustomerSignUpDto());

        if ($request->isMethod('post')) {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $signUp = $form->getData();

                $this->get('sign_up')->signUpCustomer($signUp);

                $customer = $this->get('repositories.customers')
                    ->loadUserByUsername($signUp->email)
                ;

                $token = new UsernamePasswordToken($customer, null, 'customers', ['ROLE_CUSTOMER']);
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_customer', serialize($token));

                return new RedirectResponse('/');
            }
        }

        return $this->render(
            '@App/CustomerAccount/signUp.html.twig',
            ['signUpForm' => $form->createView()]
        );
    }
}
