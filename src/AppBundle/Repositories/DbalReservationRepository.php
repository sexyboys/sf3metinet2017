<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Repositories;

use AppBundle\Models\Reservation;
use Doctrine\DBAL\Connection;

class DbalReservationRepository implements ReservationRepository
{
    private $dbal;

    public function __construct(Connection $connection)
    {
        $this->dbal = $connection;
    }

    public function save(Reservation $reservation)
    {
        $query =<<<SQL
INSERT INTO `reservations` 
  (
   `id`, 
   `serializedReservation`
   ) VALUES (
    :id, 
    :serializedReservation
  )
  ON DUPLICATE KEY 
    UPDATE 
      serializedReservation = :serializedReservation
    ;
SQL;

        $stmt = $this->dbal->prepare($query);
        $stmt->execute([
            'id' => $reservation->getId(),
            'serializedReservation' => serialize($reservation),
        ]);
    }

    public function findAll()
    {
        $stmt = $this->dbal->prepare('SELECT * FROM reservations');
        $stmt->execute();

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $reservations = [];

        foreach ($rows as $row) {
            $reservations[] = unserialize($row['serializedReservation']);
        }

        return $reservations;
    }
}
