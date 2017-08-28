<?php

namespace AppBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository implements UserLoaderInterface
{
	public function loadUserByUsername($username)
	{
		return $this->createQueryBuilder('u')
			->where('u.username = :username OR u.email = :email')
			->setParameter('username', $username)
			->setParameter('email', $username)
			->getQuery()
			->getOneOrNullResult();
	}

	/**
	 * Get users that have comments in the given topic id
	 * @param $topicId
	 * @return array
	 */
	public function getUsersByTopic($topicId)
	{
		$query = $this->createQueryBuilder('u')
			->leftJoin('u.comments', 'c')
			->where('c.topicId = :topicId')
		    ->orderBy('c.createdAt', 'ASC')
			->setParameter('topicId', $topicId)
		    ->getQuery();

		return $query->getResult();
	}
}
