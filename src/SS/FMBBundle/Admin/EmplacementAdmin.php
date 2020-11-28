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


class EmplacementAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('id')->add('place')->add('stockscorde')->add('stockslanterne')->add('flotteur')->add('dateDeRemplissage');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id')->add('place')->add('stockscorde')->add('stockslanterne')->add('flotteur')->add('dateDeRemplissage');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')->add('place')->add('stockscorde')->add('stockspoches')->add('stockslanterne')->add('flotteur')->add('dateDeRemplissage');
    }
}