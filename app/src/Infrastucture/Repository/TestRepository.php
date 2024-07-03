<?php

namespace App\Infrastucture\Repository;

use App\Domain\Entity\Test;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Test>
 */
class TestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Test::class);
    }

    public function getById(int $id): Test
    {
        $test = $this->findOneBy([
            'id' => $id,
        ]);
        if(!$test){
            throw new \Exception('Тест не найден');
        }

        return $test;
    }

    public function save(Test $test): void
    {
        $this->getEntityManager()->persist($test);
        $this->getEntityManager()->flush();
    }
}
