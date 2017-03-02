<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Repositories;

use AppBundle\Models\Host;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class DbalHostRepository implements HostRepository, UserProviderInterface
{
    private $dbal;

    public function __construct(Connection $connection)
    {
        $this->dbal = $connection;
    }

    public function save(Host $host)
    {
        $query =<<<SQL
INSERT INTO `hosts` 
  (
   `id`,
   `serializedHost`,
   `username`
   ) VALUES (
    :id, 
    :serializedHost,
    :username
  )
  ON DUPLICATE KEY 
    UPDATE 
      serializedHost = :serializedHost,
      username = :username
    ;
SQL;

        $stmt = $this->dbal->prepare($query);
        $stmt->execute([
            'id' => $host->getId(),
            'serializedHost' => serialize($host),
            'username' => $host->getUsername(),
        ]);
    }

    public function findById($hostId)
    {
        $stmt = $this->dbal->prepare('SELECT * FROM hosts WHERE id = :id LIMIT 1;');
        $stmt->execute(['id' => $hostId]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($rows) < 1) {

            throw new \DomainException(sprintf('Host #%s not found', $hostId));
        }

        return unserialize($rows[0]['serializedHost']);
    }

    public function loadUserByUsername($username)
    {
        $stmt = $this->dbal->prepare('SELECT * FROM hosts WHERE username = :username LIMIT 1;');
        $stmt->execute(['username' => $username]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($rows) < 1) {

            throw new UsernameNotFoundException();
        }

        return unserialize($rows[0]['serializedHost']);
    }

    public function supportsClass($class)
    {
        return (Host::class === $class);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {

            throw new UnsupportedUserException();
        }

        return $this->loadUserByUsername($user->getUsername());
    }
}
