<?php

namespace SS\FMBBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StocksCordesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantiter')
            ->add('pret')
            ->add('chaussement')
            ->add('numeroSerie')
            ->add('dateDeCreation')
            ->add('dateDeMiseAEau')
            ->add('dateDeRetraitTransfert')
            ->add('dateDeMAETransfert')
            ->add('dateAssemblage')
            ->add('dateDeRetirement')
            ->add('corde')
            ->add('processus')
            ->add('emplacement')
            ->add('article')
            ->add('docLine')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SS\FMBBundle\Entity\StocksCordes'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_stockscordes';
    }
}
