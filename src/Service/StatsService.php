<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class StatService{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getCountCountry(string $country)
    {
        $query = $this->manager->createQuery('
            SELECT COUNT(p) AS total 
            FROM App\Entity\Participant p
            JOIN p.country c
            WHERE c.name = '.$country);

        return $query->getSingleScalarResult();
    }

}