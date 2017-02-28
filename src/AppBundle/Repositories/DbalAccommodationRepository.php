<?php
/**
 * @author Boris Guéry <guery.b@gmail.com>
 */

namespace AppBundle\Repositories;

use AppBundle\Models\Accommodation;
use Doctrine\DBAL\Connection;

class DbalAccommodationRepository implements AccommodationRepository
{
    private $dbal;

    public function __construct(Connection $connection)
    {
        $this->dbal = $connection;
    }

    public function save(Accommodation $accommodation)
    {
        $query =<<<SQL
INSERT INTO `accommodations` 
  (
   `id`, 
   `serializedAccommodation`
   ) VALUES (
    :id, 
    :serializedAccommodation
  )
  ON DUPLICATE KEY 
    UPDATE 
      serializedAccommodation = :serializedAccommodation
    ;
SQL;

        $stmt = $this->dbal->prepare($query);
        $stmt->execute([
            'id' => $accommodation->getId(),
            'serializedAccommodation' => serialize($accommodation),
        ]);
    }

    public function findAll()
    {
        $stmt = $this->dbal->prepare('SELECT * FROM accommodations');
        $stmt->execute();

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $accommodations = [];

        foreach ($rows as $row) {
            $accommodations[] = unserialize($row['serializedAccommodation']);
        }

        return $accommodations;
    }
}
