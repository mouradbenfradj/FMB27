<?php

namespace SS\FMBBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MagasinsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libMagasin')
            ->add('abrevMagasin')
            ->add('modeVente')
            ->add('actif')
            ->add('idMagEnseigne')
            ->add('idTarif')
            ->add('idStock')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SS\FMBBundle\Entity\Magasins'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_magasins';
    }
}
