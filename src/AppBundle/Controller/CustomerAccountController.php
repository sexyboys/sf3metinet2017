<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Controller;

use AppBundle\Forms\Types\SignIn;
use AppBundle\Models\UserSignUp;
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
        if ($request->isMethod('post')) {
            $firstName = $request->get('firstName');
            $lastName = $request->get('lastName');
            $email = $request->get('email');
            $plainTextPassword = $request->get('password');

            $signUp = new UserSignUp($firstName, $lastName, $email, $plainTextPassword);
            $this->get('sign_up')->signUp($signUp);

            $customer = $this->get('repositories.customers')->loadUserByUsername($email);

            $token = new UsernamePasswordToken($customer, null, 'main', ['ROLE_USER']);
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            return new RedirectResponse('/');
        }

        return $this->render(
            '@App/CustomerAccount/signUp.html.twig'
        );
    }
}
