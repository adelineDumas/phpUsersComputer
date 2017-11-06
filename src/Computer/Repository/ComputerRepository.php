<?php

namespace App\Computer\Repository;

use App\Computer\Entity\Computer;
use Doctrine\DBAL\Connection;

/**
 * Computer repository.
 */
class ComputerRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

   /**
    * Returns a collection of computers.
    *
    * @param int $limit
    *   The number of computer to return.
    * @param int $offset
    *   The number of computers to skip.
    * @param array $orderBy
    *   Optionally, the order by info, in the $column => $direction format.
    *
    * @return array A collection of computers, keyed by computer id.
    */
   public function getAll()
   {
       $queryBuilder = $this->db->createQueryBuilder();
       $queryBuilder
           ->select('u.*')
           ->from('computer', 'u');

       $statement = $queryBuilder->execute();
       $computerData = $statement->fetchAll();
       $computerEntityList = null; 
       foreach ($computerData as $CompData) {
           $computerEntityList[$CompData['id']] = new Computer($CompData['id'], $CompData['nom'], $CompData['marque'], $CompData['os'], $CompData['idUser']);
       } 
       $computerEntityList = $this->getNom($computerEntityList); 
       return $computerEntityList;
   }

    public function getNom($listComputer){

       $queryBuilder = $this->db->createQueryBuilder();
        
       $queryBuilder
          ->select('u.*')
          ->from('Users', 'u');

       $statement = $queryBuilder->execute();
        $usersData = $statement->fetchAll();

       foreach ($listComputer as $computer) {
          foreach ($usersData as $user) {
            if($computer->getIdUser() == $user['id']){
              $computer->setNomUser($user['nom'] . " " . $user['prenom']);
            }
          }
        }

       return $listComputer;
    }

   /**
    * Returns an Computer object.
    *
    * @param $id
    *   The id of the computer to return.
    *
    * @return array A collection of computers, keyed by computer id.
    */
   public function getById($id)
   {
       $queryBuilder = $this->db->createQueryBuilder();
       $queryBuilder
           ->select('u.*')
           ->from('computer', 'u')
           ->where('id = ?')
           ->setParameter(0, $id);
       $statement = $queryBuilder->execute();
       $computerData = $statement->fetchAll();

       return new Computer($computerData[0]['id'], $computerData[0]['nom'], $computerData[0]['marque'], $computerData[0]['os'], $computerData[0]['idUser']);
   }

    public function delete($id)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
          ->delete('computer')
          ->where('id = :id')
          ->setParameter(':id', $id);

        $statement = $queryBuilder->execute();
    }

    public function update($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
          ->update('computer')
          ->where('id = :id')
          ->setParameter(':id', $parameters['id']);

        if ($parameters['nom']) {
            $queryBuilder
              ->set('nom', ':nom')
              ->setParameter(':nom', $parameters['nom']);
        }

        if ($parameters['marque']) {
            $queryBuilder
            ->set('marque', ':marque')
            ->setParameter(':marque', $parameters['marque']);
        }

        if ($parameters['os']) {
            $queryBuilder
            ->set('os', ':os')
            ->setParameter(':os', $parameters['os']);
        }
        if ($parameters['idUser']) {
            $queryBuilder
            ->set('idUser', ':idUser')
            ->setParameter(':idUser', $parameters['idUser']);
        }

        $statement = $queryBuilder->execute();
    }

    public function insert($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
          ->insert('computer')
          ->values(
              array(
                'nom' => ':nom',
                'marque' => ':marque',
                'os' => ':os',
                'idUser' => ':idUser'
              )
          )
          ->setParameter(':nom', $parameters['nom'])
          ->setParameter(':marque', $parameters['marque'])
          ->setParameter(':os', $parameters['os'])
          ->setParameter(':idUser', $parameters['idUser']);
        $statement = $queryBuilder->execute();
    }
}
