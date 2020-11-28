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


class StocksArticlesAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('idStock')->add('refArticle')->add('qte')->add(
            'stocksArticlesSn',
            'sonata_type_collection',
            array(
                'required' => true,
                'by_reference' => false,
            ),
            array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'id',
            )
        );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('refStockArticle')->add('idStock')->add('refArticle')->add('qte');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('refStockArticle')->add('idStock')->add('refArticle')->add('qte');
    }
}