<?php

namespace App\Method;

use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Type;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;

use App\Entity\Activity;

class ActivityGetMethod implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface
{
    /**
     *
     * @var ManagerRegistry
     */
    protected $doctrine = null;

    /**
     *
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     *
     * @param array $params
     * @return array
     */
    public function apply(array $params = null)
    {
        $repository = $this->doctrine->getRepository(Activity::class);
        $activities = $repository->getStats($params['page'] ?? 1);

        return $activities;
    }

    /**
     *
     * @return Constraint
     */
    public function getParamsConstraint() : Constraint
    {
        return new Collection(['fields' => [
            'page' => new Optional([
                new Type('int')
            ]),
        ]]);
    }
}