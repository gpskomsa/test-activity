<?php

namespace App\Method;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Required;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Activity;

class ActivityPutMethod implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface
{
    protected $doctrine = null;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function apply(array $params = null)
    {
        $entityManager = $this->doctrine->getManager();

        $activity = new Activity();
        $activity->setUrl($params['url']);
        $activity->setDate(new \DateTime($params['date']));

        $entityManager->persist($activity);
        $entityManager->flush();

        return $params;
    }

    public function getParamsConstraint() : Constraint
    {
        return new Collection(['fields' => [
            'url' => new Required([
                new Url()
            ]),
            'date' => new Required([
                new DateTime()
            ]),
        ]]);
    }
}