<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 01/04/2016
 * Time: 00:38
 */

namespace SS\FMBBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class ProcessusAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('idProcessusParent')
            ->add('nomProcessus')
            ->add('abrevProcessus')
            ->add('phasesProcessus')
            ->add('articleDebut')
            ->add('duree', 'sonata_type_immutable_array', array(
                    'keys' => array(
                        array('jours', 'integer', array()),
                        array('mois', 'integer', array()),
                        array('annee', 'integer', array()))
                )
            )
            ->add('alerteJaune', 'sonata_type_immutable_array', array(
                    'keys' => array(
                        array('jours', 'integer', array()),
                        array('mois', 'integer', array()),
                        array('annee', 'integer', array()))
                )
            )
            ->add('alerteRouge', 'sonata_type_immutable_array', array(
                    'keys' => array(
                        array('jours', 'integer', array()),
                        array('mois', 'integer', array()),
                        array('annee', 'integer', array()))
                )
            )
            ->add('articleSortie')
            ->add('numeroDebCycle')
            ->add('limiteDuCycle')
            ->add('couleur', 'sonata_type_color_selector')
            ->add('couleurDuFond', 'sonata_type_color_selector');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id')
            ->add('idProcessusParent')
            ->add('nomProcessus')
            ->add('phasesProcessus')
            ->add('articleDebut')
            ->add('abrevProcessus')
            ->add('duree')
            ->add('alerteJaune')
            ->add('alerteRouge')
            ->add('articleSortie')
            ->add('numeroDebCycle')
            ->add('limiteDuCycle')
            ->add('couleur')
            ->add('couleurDuFond');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')
            ->add('idProcessusParent')
            ->add('nomProcessus')
            ->add('phasesProcessus')
            ->add('articleDebut')
            ->add('abrevProcessus')
            ->add('duree', 'array')
            ->add('alerteJaune', 'array')
            ->add('alerteRouge', 'array')
            ->add('articleSortie')
            ->add('numeroDebCycle')
            ->add('limiteDuCycle')
            ->add('couleur', null, array(
                'template' => 'SSFMBBundle:template:base_show_field.html.twig'
            ))
            ->add('couleurDuFond', null, array(
                'template' => 'SSFMBBundle:template:base_show_field.html.twig'
            ));
    }
}
