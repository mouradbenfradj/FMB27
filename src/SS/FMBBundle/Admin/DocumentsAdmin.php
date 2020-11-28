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


class DocumentsAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('refDoc')->add('codeAffaire')->add('nomContact')->add('adresseContact')->add('codePostalContact')->add('villeContact')->add('appTarifs')->add('description')->add('dateCreationDoc')->add('codeFile')->add('idPaysContact')->add('refAdrContact')->add('refContact')->add('idEtatDoc')->add('idTypeDoc');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('refDoc')->add('codeAffaire')->add('nomContact')->add('adresseContact')->add('codePostalContact')->add('villeContact')->add('appTarifs')->add('description')->add('dateCreationDoc')->add('codeFile')->add('idPaysContact')->add('refAdrContact')->add('refContact')->add('idEtatDoc')->add('idTypeDoc');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('refDoc')->add('codeAffaire')->add('nomContact')->add('adresseContact')->add('codePostalContact')->add('villeContact')->add('appTarifs')->add('description')->add('dateCreationDoc')->add('codeFile')->add('idPaysContact')->add('refAdrContact')->add('refContact')->add('idEtatDoc')->add('idTypeDoc');
    }
}
