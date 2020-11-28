<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 16/09/2016
 * Time: 17:06
 */

namespace SS\FMBBundle\Menu;


use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $sc = $this->container->get('security.context');
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navigation-menu');
        $menu->addChild('Statistique');
        $menu->addChild('suivi filières');
        if ($sc->isGranted('ROLE_SUPER_ADMIN')) {
            $menu->addChild('Operation');
        }
        $menu->addChild('planing de travaille');
        $menu->addChild('Processus');
        $menu->addChild('Outil');
        $menu['Outil']->addChild('Historique des operations');
        $menu['Outil']->addChild('Prévision des sorties');

        if ($sc->isGranted('ROLE_SUPER_ADMIN')) {
            $menu['Operation']->addChild('Préparation');
            $menu['Operation']->addChild('Assemblage');
            $menu['Operation']->addChild('MAE lanterne');
            $menu['Operation']->addChild('MAE corde');
            $menu['Operation']->addChild('MAE Poche');
            $menu['Operation']->addChild('MAE Assemblage');
            $menu['Operation']->addChild('chaussage');
            $menu['Operation']->addChild('Retrait Transfert');
            $menu['Operation']->addChild('Retrait AW lanterne');
            $menu['Operation']->addChild('Retrait AW corde');
            $menu['Operation']->addChild('Traitement Comercial');
            $menu['Operation']['Préparation']->addChild('preparer lanterne', array('route' => 'ssfmb_preparationlanterne'));
            $menu['Operation']['Préparation']->addChild('preparer corde', array('route' => 'ssfmb_preparationcorde'));
            $menu['Operation']['Préparation']->addChild('preparer poche', array('route' => 'ssfmb_preparationpoche'));
            $menu['Operation']['Assemblage']->addChild('Poche a corde', array('route' => 'ssfmb_assemblage'));
            $menu['Outil']['Prévision des sorties']->addChild('tableau', array('route' => 'previsionFuture'));
            $menu['Outil']['Prévision des sorties']->addChild('courbe', array('route' => 'previsionFutureCourbe'));
        }
        //   $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($parcs) {
            foreach ($parcs as $parc) {
                $menu['Statistique']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_statistique',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['suivi filières']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_suivi',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                if ($sc->isGranted('ROLE_SUPER_ADMIN')) {
                    $menu['Operation']['chaussage']->addChild($parc->getAbrevMagasin(), array(
                        'route' => 'ssfmb_chaussement',
                        'routeParameters' => array('idparc' => $parc->getIdMagasin())
                    ));

                    $menu['Operation']["MAE lanterne"]->addChild($parc->getAbrevMagasin(), array(
                        'route' => 'ssfmb_misaaeaulanterne',
                        'routeParameters' => array('idparc' => $parc->getIdMagasin())
                    ));
                    $menu['Operation']['Retrait AW lanterne']->addChild($parc->getAbrevMagasin(), array(
                        'route' => 'ssfmb_retraitLanterne',
                        'routeParameters' => array('idparc' => $parc->getIdMagasin())
                    ));
                    $menu['Operation']['Retrait AW lanterne']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
                    $menu['Operation']["MAE corde"]->addChild($parc->getAbrevMagasin(), array(
                        'route' => 'ssfmb_misaaeaucorde',
                        'routeParameters' => array('idparc' => $parc->getIdMagasin())
                    ));
                    $menu['Operation']["MAE Assemblage"]->addChild($parc->getAbrevMagasin(), array(
                        'route' => 'ssfmb_assemblagemiseaeauformulaire',
                        'routeParameters' => array('idparc' => $parc->getIdMagasin())
                    ));
                    $menu['Operation']["MAE Poche"]->addChild($parc->getAbrevMagasin(), array(
                        'route' => 'ssfmb_misaaeaupoche',
                        'routeParameters' => array('idparc' => $parc->getIdMagasin())
                    ));
                    $menu['Operation']['Retrait AW corde']->addChild($parc->getAbrevMagasin(), array(
                        'route' => 'ssfmb_retraitcorde',
                        'routeParameters' => array('idparc' => $parc->getIdMagasin())
                    ));
                    $menu['Operation']['Retrait AW corde']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
                    $menu['Operation']['Traitement Comercial']->addChild($parc->getAbrevMagasin(), array(
                        'route' => 'traitementcomerciale',
                        'routeParameters' => array('idparc' => $parc->getIdMagasin())
                    ));
                }
                $menu['planing de travaille']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_planingdetravaille',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['Processus']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_processusgrocissement',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                if ($sc->isGranted('ROLE_SUPER_ADMIN')) {
                    $menu['Operation']['Retrait Transfert']->addChild($parc->getAbrevMagasin(), array(
                        'route' => 'ssfmb_transfert',
                        'routeParameters' => array('idparc' => $parc->getIdMagasin())
                    ));
                }

            }

        }

        $menu['Statistique']->setAttribute('class', 'has-submenu')->setUri("/")->setChildrenAttribute('class', 'submenu');
        $menu['suivi filières']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        if ($sc->isGranted('ROLE_SUPER_ADMIN')) {
            $menu['Operation']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        }
        $menu['planing de travaille']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        $menu['Processus']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        $menu['Outil']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        $menu['Outil']['Historique des operations']->setAttribute('class', 'has-submenu')->setUri("/historiqueOperation")->setChildrenAttribute('class', 'submenu');
        $menu['Outil']['Prévision des sorties']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');


        if ($sc->isGranted('ROLE_SUPER_ADMIN')) {
            $menu['Operation']['Préparation']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
            $menu['Operation']['Assemblage']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
            $menu['Operation']['MAE lanterne']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
            $menu['Operation']['MAE corde']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
            $menu['Operation']['MAE Assemblage']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
            $menu['Operation']['MAE Poche']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
            $menu['Operation']['chaussage']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
            $menu['Operation']['Retrait Transfert']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
            $menu['Operation']['Retrait AW lanterne']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
            $menu['Operation']['Retrait AW corde']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
            $menu['Operation']['Traitement Comercial']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        }
        return $menu;
    }

    public function parcMAETransfertMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($parcs) {
            foreach ($parcs as $parc) {
                $menu->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_misaaeautransfert',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
            }
        }
        return $menu;
    }
}