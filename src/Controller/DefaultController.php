<?php

namespace EasyAdminFriends\EasyAdminDashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $this->config = $this->container->getParameter('easyadmindashboard');
        $dashboard = $this->config ? $this->config : false;

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
                    }
                }
            }
        }

        return $this->render('EasyAdminDashboardBundle:Default:index.html.twig', array(
            'dashboard' => $dashboard
        ));
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
