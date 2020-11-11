<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class StatService{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getCountHotel()
    {
        $query = $this->manager->createQuery('
            SELECT COUNT(h) AS total 
            FROM App\Entity\Hotel h');

        return $query->getSingleScalarResult();
    }

    public function getCount()
    {
        $query = $this->manager->createQuery('
            SELECT COUNT(p) AS total 
            FROM App\Entity\Participant p');

        return $query->getSingleScalarResult();
    }
    public function getCountCountry(string $country)
    {
        $query = $this->manager->createQuery('
            SELECT COUNT(p) AS total 
            FROM App\Entity\Participant p
            WHERE p.country = '.$country);

        return $query->getSingleScalarResult();
    }

    public function getCountGender(string $gender)
    {
        $query = $this->manager->createQuery('
            SELECT COUNT(p) AS total 
            FROM App\Entity\Participant p
            WHERE p.gender = '.$gender);

        return $query->getSingleScalarResult();
    }

    public function getCountCategory(string $category)
    {
        $query = $this->manager->createQuery('
            SELECT COUNT(p) AS total 
            FROM App\Entity\Participant p
            WHERE p.country = '.$category);

        return $query->getSingleScalarResult();
    }

    public function getCountCategoryGender(string $category, string $gender)
    {
        $query = $this->manager->createQuery('
            SELECT COUNT(p) AS total 
            FROM App\Entity\Participant p
            WHERE p.category = '.$category.'
            AND p.gender = '. $gender );

        return $query->getSingleScalarResult();
    }

    public function getCountCountryGender(string $country, string  $gender)
    {
        $query = $this->manager->createQuery('
            SELECT COUNT(p) AS total 
            FROM App\Entity\Participant p
            WHERE p.country = '.$country.'
            AND p.gender = '. $gender);

        return $query->getSingleScalarResult();
    }

    public function getCountCategoryCountryGender(string $category,string $country, string  $gender)
    {
        $query = $this->manager->createQuery('
            SELECT COUNT(p) AS total 
            FROM App\Entity\Participant p
            WHERE p.country = '.$country.'
            AND p.gender = '. $gender.'
            AND p.category = '. $category);

        return $query->getSingleScalarResult();
    }

    public function getCountCategoryCountry(string $category,string $country)
    {
        $query = $this->manager->createQuery('
            SELECT COUNT(p) AS total 
            FROM App\Entity\Participant p
            WHERE p.country = '.$country.'
            AND p.category = '. $category);

        return $query->getSingleScalarResult();
    }

}