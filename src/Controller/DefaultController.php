<?php

namespace EasyAdminFriends\EasyAdminDashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function getLayoutTemplate()
    {
        $config = $this->getParameter('easy_admin_dashboard');
        $dashboard = $config ?? false;

        if(!empty($dashboard['layout'])){
            $layoutTemplatePath = $dashboard['layout'];
        }else{
            $layoutTemplatePath = '@EasyAdmin/page/content.html.twig';
        }

        return $layoutTemplatePath;
    }

    public function generateDashboardValues()
    {
        $config = $this->getParameter('easy_admin_dashboard');
        $dashboard = $config ?? false;

        if(!empty($dashboard['blocks'])){
            foreach($dashboard['blocks'] as $key=>$block){
                if(!empty($block['items'])){
                    foreach($block['items'] as $k=>$item){
                        if(!empty($item['query'])){
                            $count = $this->executeCustomQuery($item['class'], $item['query']);
                        }else {
                            $count = $this->getBlockCount($item['class'], !empty($item['dql_filter']) ? $item['dql_filter'] : false);
                        }
                        $dashboard['blocks'][$key]['items'][$k]['count'] = $count;

                        if(!empty($item['entity'])){
                            $entity = $item['entity'];
                        }else {
                            $entity = $this->guessEntityFromClass($item['class']);
                        }
                        $dashboard['blocks'][$key]['items'][$k]['entity'] = $entity;
                        $dashboard['blocks'][$key]['items'][$k]['permissions'] = $dashboard['blocks'][$key]['items'][$k]['permissions'] ?? ['ROLE_USER'];
                    }
                }
                $dashboard['blocks'][$key]['permissions'] = $dashboard['blocks'][$key]['permissions'] ?? ['ROLE_USER'];
            }
        }

        return $dashboard;
    }

    private function guessEntityFromClass($classname)
    {
        $entity_name = substr($classname, strrpos($classname, '\\') + 1);
        return (string) $entity_name;
    }

    private function getBlockCount($class, $dql_filter)
    {
        $this->em = $this->getDoctrine()->getManagerForClass($class);

        $qb = $this->em->createQueryBuilder('entity');
        $qb->select('count(entity.id)');
        $qb->from($class, 'entity');

        if($dql_filter){
            $qb->where($dql_filter);
        }

        $count = $qb->getQuery()->getSingleScalarResult();

        return $count;
    }

    private function executeCustomQuery($class, $query)
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository($class);

        if(!method_exists($repo, $query)){
            throw new \ErrorException($query.' is not a valid function.');
        }

        $q = $repo->{$query}();

        $count = is_numeric($q) ? $q : count($q);

        return $count;
    }
}
