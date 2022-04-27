<?php

namespace App\Method;

use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Activity;

class ActivityGetMethod implements JsonRpcMethodInterface
{
    /**
     *
     * @var ManagerRegistry
     */
    protected $doctrine = null;
    
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function apply(array $params = null)
    {
        $repository = $this->doctrine->getRepository(Activity::class);
        $activities = $repository->getStats();

        return $activities;
    }
}