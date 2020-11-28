<?php

namespace SS\FMBBundle\Form;

use Doctrine\ORM\EntityRepository;
use SS\FMBBundle\Entity\Magasins;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManager;

class PreparationPocheType extends AbstractType
{
    protected $em;
    protected $processus;

    function __construct(EntityManager $em, array $processus)
    {
        $this->em = $em;
        $this->processus = $processus;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', 'text', array('label' => 'Date de la Préparation des Poches', 'attr' => array('class' => 'form-control', 'placeholder' => "dd/mm/yyyy", 'id' => "datepicker")));
        $builder->add('refArticle', 'entity', array('class' => 'SSFMBBundle:Articles',
            'query_builder' => function (EntityRepository $er) {
                $req = $er->createQueryBuilder('a');
                foreach ($this->processus as $pro) {
                    $req->orWhere("a.libArticle LIKE '%" . $pro->getArticleSortie() . "%'");
                }
                return $req;
            }, 'label' => 'article', 'attr' => array('class' => "form-control")))
            ->add('numeroSerie', 'entity', array('class' => 'SSFMBBundle:StocksArticlesSn', 'label' => 'lot', 'mapped' => false, 'attr' => array('class' => "form-control")))
            ->add('qte', 'number', array('label' => 'Densiter', 'attr' => array('class' => "form-control")))
            ->add('nombre', 'number', array('label' => 'nombre de Poche a fabriquer', 'mapped' => false));
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, Magasins $parc = null)
    {
        $dt = $form->get('date');
        $form->remove('date');
        $form->add('Parc', 'entity', array(
                'label' => 'choix du parc ',
                'data' => $parc,
                'class' => 'SSFMBBundle:Magasins',
                'mapped' => false,
                'attr' => array('class' => "form-control"))
        );
        // Cities are empty, unless we actually supplied a province
        $stocks = array();
        $poches = array();
        if ($parc) {
            // Fetch the cities from specified province
            $repo2 = $this->em->getRepository('SSFMBBundle:PochesBS');
            $stocks = $parc->getIdStock();
            $poches = $repo2->findByParc($parc);
        }
        // Add the city element
        $form->add('libStock', 'entity', array(
            'label' => 'Le stock qui contient vos articles',
            'empty_value' => '-- Selectionne le parc en premier lieu --',
            'class' => 'SSFMBBundle:Stocks',
            'choices' => array($stocks),
            'attr' => array('class' => "form-control")
        ));
        $form->add('nomPoche', 'entity', array(
            'label' => 'choix du Poche',
            'empty_value' => '-- Selectionne le parc en premier lieu --',
            'class' => 'SSFMBBundle:PochesBS',
            'property' => 'id',
            'choices' => $poches,
            'attr' => array('class' => "form-control")
        ));
        $form->add('quantiterEnStock', 'number', array(
            'label' => 'nombre de Poche non utilisé en stock',
            'mapped' => false,
            'attr' => array('class' => "form-control", 'readonly' => "", 'value' => "Readonly value")
        ));
        $form->add($dt);
    }

    function onPreSetData(FormEvent $event)
    {

        $form = $event->getForm();
        $data = $event->getData();
        $parc = $data ? $data->getParc() : null;
        $this->addElements($form, $parc);
    }

    function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        // Note that the data is not yet hydrated into the entity.
        $parc = $this->em->getRepository('SSFMBBundle:Magasins')->find($data['Parc']);

        $this->addElements($form, $parc);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ss_fmbbundle_preparationpoche';
    }
}