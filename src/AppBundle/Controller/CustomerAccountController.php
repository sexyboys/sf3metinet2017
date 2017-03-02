<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Controller;

use AppBundle\Forms\Types\CustomerSignUp;
use AppBundle\Forms\Types\SignIn;
use AppBundle\Models\CustomerSignUp as CustomerSignUpDto;
use AppBundle\Repositories\CustomerNotFound;
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

    public function forgottenPasswordAction(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $customer = $this->get('repositories.customers')->findByEmail($request->get('email'));
                $this->get('password_reset')->requestPasswordReset($customer);
            } catch (CustomerNotFound $e) {
//                 simply ignore and let the user think we sent an e-mail
            }
            
            return $this->redirectToRoute('public.customer.forgotten_password.confirmed');

        }

        return $this->render(
            '@App/CustomerAccount/forgottenPassword.html.twig'
        );
    }

    public function forgottenPasswordConfirmedAction(Request $request)
    {
        return $this->render(
            '@App/CustomerAccount/forgottenPasswordConfirmation.html.twig'
        );
    }

    public function resetPasswordAction(Request $request)
    {
        $token = $request->get('token');
        if ($request->isMethod('post')) {

            $plainTextPassword = $request->get('newPassword');

            $this->get('password_reset')->resetPassword($token, $plainTextPassword);

            $this->addFlash(
                'info',
                $this->get('translator')->trans(
                    'Votre mot de passe a bien été mis à jour, vous pouvez à présent vous connecter'
                )
            );

            return $this->redirectToRoute('public.customer.sign_in');
        }

        return $this->render(
            '@App/CustomerAccount/resetPassword.html.twig'
        );
    }
}
