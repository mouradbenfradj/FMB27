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


class StocksCordeAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id')->add('quantiter')->add('pret')->add('emplacement')->add('numeroSerie')->add('dateDeCreation')->add('dateDeRetirement')->add('processus');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id')->add('corde')->add('quantiter')->add('pret')->add('emplacement')->add('numeroSerie')->add('dateDeCreation')->add('dateDeRetirement')->add('processus');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')->add('corde')->add('quantiter')->add('pret')->add('emplacement')->add('numeroSerie')->add('dateDeCreation')->add('dateDeRetirement')->add('processus');
    }
}