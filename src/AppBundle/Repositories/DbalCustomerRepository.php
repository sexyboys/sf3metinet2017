<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Repositories;

use AppBundle\Models\Customer;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class DbalCustomerRepository implements CustomerRepository, UserProviderInterface
{
    private $dbal;

    public function __construct(Connection $connection)
    {
        $this->dbal = $connection;
    }

    public function save(Customer $customer)
    {
        $query =<<<SQL
INSERT INTO `customers` 
  (
   `id`,
   `serializedCustomer`,
   `username`,
   `passwordResetToken`
   ) VALUES (
    :id, 
    :serializedCustomer,
    :username,
    :passwordResetToken
  )
  ON DUPLICATE KEY 
    UPDATE 
      serializedCustomer = :serializedCustomer,
      username = :username,
      passwordResetToken = :passwordResetToken
    ;
SQL;

        $stmt = $this->dbal->prepare($query);
        $stmt->execute([
            'id' => $customer->getId(),
            'serializedCustomer' => serialize($customer),
            'username' => $customer->getUsername(),
            'passwordResetToken' => $customer->getPasswordResetToken(),
        ]);
    }

    public function findById($customerId): Customer
    {
        $stmt = $this->dbal->prepare('SELECT * FROM customers WHERE id = :id LIMIT 1;');
        $stmt->execute(['id' => $customerId]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($rows) < 1) {

            throw new CustomerNotFound(sprintf('Customer #%s not found', $customerId));
        }

        return unserialize($rows[0]['serializedCustomer']);
    }

    public function findByEmail($email): Customer
    {
        $stmt = $this->dbal->prepare('SELECT * FROM customers WHERE username = :username LIMIT 1;');
        $stmt->execute(['username' => $email]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($rows) < 1) {

            throw new CustomerNotFound(sprintf('Customer #%s not found', $email));
        }

        return unserialize($rows[0]['serializedCustomer']);
    }

    public function findByPasswordResetToken($token): Customer
    {
        $stmt = $this->dbal->prepare('SELECT * FROM customers WHERE passwordResetToken = :passwordResetToken LIMIT 1;');
        $stmt->execute(['passwordResetToken' => $token]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($rows) < 1) {

            throw new CustomerNotFound(sprintf('Customer #%s not found', $token));
        }

        return unserialize($rows[0]['serializedCustomer']);
    }

    public function loadUserByUsername($username)
    {
        $stmt = $this->dbal->prepare('SELECT * FROM customers WHERE username = :username LIMIT 1;');
        $stmt->execute(['username' => $username]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($rows) < 1) {

            throw new UsernameNotFoundException();
        }

        return unserialize($rows[0]['serializedCustomer']);
    }

    public function supportsClass($class)
    {
        return (Customer::class === $class);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {

            throw new UnsupportedUserException();
        }

        return $this->loadUserByUsername($user->getUsername());
    }
}
