<?php

namespace App\Repository;

use App\Entity\Application;
use App\Entity\Profile;
use App\Service\DevLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Application|null find($id, $lockMode = null, $lockVersion = null)
 * @method Application|null findOneBy(array $criteria, array $orderBy = null)
 * @method Application[]    findAll()
 * @method Application[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    public function findAllByProfile(Profile $profile): array
    {
        $conn = $this->getEntityManager()
            ->getConnection();

        $dev = new DevLog($conn, 'from ApplicationRepository');

        $stmt = $conn->prepare(
            'SELECT
                 `job_id`,
                 `profile_id`
             FROM
                 `application`
             WHERE
                 `profile_id` = ?;'
        );

        $stmt->execute([$profile->getId()]);

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }
}
