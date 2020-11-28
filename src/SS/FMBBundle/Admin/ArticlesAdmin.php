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


class ArticlesAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('libArticle')->add('libTicket')->add('descCourte')->add('descLongue')->add('refArtCateg')->add('modele')->add('paaLastMaj')->add('promo')->add('valoIndice')->add('lot')->add('composant')->add('variante')->add('gestionSn')->add('dateDebutDispo')->add('dateFinDispo')->add('dispo')->add('dateCreation')->add('dateModification')->add('isAchetable')->add('isVendable');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('refArticle')->add('libArticle');

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('refArticle')->add('libArticle');

    }
}