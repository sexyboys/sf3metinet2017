<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Repositories;

use AppBundle\Models\ReservationRequest;
use Doctrine\DBAL\Connection;

class DbalReservationRequestRepository implements ReservationRequestRepository
{
    private $dbal;

    public function __construct(Connection $connection)
    {
        $this->dbal = $connection;
    }

    public function save(ReservationRequest $reservationRequest)
    {
        $query =<<<SQL
INSERT INTO `reservationRequests` 
  (
   `id`, 
   `serializedReservationRequest`
   ) VALUES (
    :id, 
    :serializedReservationRequest
  )
  ON DUPLICATE KEY 
    UPDATE 
      serializedReservationRequest = :serializedReservationRequest
    ;
SQL;

        $stmt = $this->dbal->prepare($query);
        $stmt->execute([
            'id' => $reservationRequest->getId(),
            'serializedReservationRequest' => serialize($reservationRequest),
        ]);
    }

    public function findById(string $reservationRequestId)
    {
        $stmt = $this->dbal->prepare('SELECT * FROM reservationRequests WHERE id = :id LIMIT 1;');
        $stmt->execute(['id' => $reservationRequestId]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (count($rows) < 1) {

            throw new \DomainException(sprintf('Reservation Request #%s not found', $reservationRequestId));
        }

        return unserialize($rows[0]['serializedReservationRequest']);
    }

    public function findAll()
    {
        $stmt = $this->dbal->prepare('SELECT * FROM reservationRequests');
        $stmt->execute();

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $reservationRequests = [];

        foreach ($rows as $row) {
            $reservationRequests[] = unserialize($row['serializedReservationRequest']);
        }

        return $reservationRequests;
    }
}
