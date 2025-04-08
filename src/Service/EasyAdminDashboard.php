<?php

namespace EasyAdminFriends\EasyAdminDashboardBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EasyAdminDashboard
{
    private array $config;

    public function __construct(
        private EntityManagerInterface $em,
        private ParameterBagInterface $params
    ) {
        $this->config = $this->params->get('easy_admin_dashboard.config');
    }

    public function getDashboard(): array
    {
        $config = $this->config;
        $dashboard = $config ?? false;

        if(!empty($dashboard['blocks'])){
            foreach($dashboard['blocks'] as $key=>$block){
                $dashboard['blocks'][$key]['permissions'] = $dashboard['blocks'][$key]['permissions'] ?? ['ROLE_USER'];
                if(!empty($block['items'])){
                    foreach($block['items'] as $k=>$item){
                        if(!empty($item['query'])){
                            $count = $this->executeCustomQuery($item['class'], $item['query']);
                        }else {
                            $filter = $item['dql_filter'] ?? null;
                            $count = $this->getBlockCount($item['class'], $filter);
                        }
                        $dashboard['blocks'][$key]['items'][$k]['count'] = $count;

                        if(!empty($item['entity'])){
                            $entity = $item['entity'];
                        }else {
                            $entity = $this->guessEntityFromClass($item['class']);
                        }
                        $dashboard['blocks'][$key]['items'][$k]['entity'] = $entity;

                        $dashboard['blocks'][$key]['items'][$k]['permissions'] = $dashboard['blocks'][$key]['items'][$k]['permissions'] ?? $dashboard['blocks'][$key]['permissions'];
                    }
                }
            }
        }

        return $dashboard;
    }


    private function guessEntityFromClass($classname)
    {
        $entity_name = substr($classname, strrpos($classname, '\\') + 1);
        return (string) $entity_name;
    }

    public function getBlockCount(string $entityClass, ?string $dqlFilter = null): int
    {
        $qb = $this->em->createQueryBuilder()
            ->select('COUNT(entity)')
            ->from($entityClass, 'entity');

        if ($dqlFilter) {
            $qb->where($dqlFilter);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    private function executeCustomQuery($class, $query)
    {
        $em = $this->em;

        $repo = $em->getRepository($class);

        if(!method_exists($repo, $query)){
            throw new \ErrorException($query.' is not a valid function.');
        }

        $q = $repo->{$query}();

        $count = is_numeric($q) ? $q : count($q);

        return $count;
    }
}