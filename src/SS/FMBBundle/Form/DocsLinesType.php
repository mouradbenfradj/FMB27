<?php

namespace SS\FMBBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocsLinesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('refArticle', 'entity', array('class' => 'SSFMBBundle:Articles', 'label' => 'article', 'attr' => array('class' => "form-control")))
            ->add('numeroSerie', 'entity', array('class' => 'SSFMBBundle:StocksArticlesSn', 'label' => 'lot', 'mapped' => false, 'attr' => array('class' => "form-control")))
            ->add('qte', 'number', array('label' => 'Densiter','attr' => array( 'class' => "form-control")))
            ->add('nombre', 'number', array('label' => 'nombre de lanterne a fabriquer', 'mapped' => false,'attr' => array( 'class' => "form-control")));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array('data_class' => 'SS\FMBBundle\Entity\DocsLines',)
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_docslines';
    }
}
