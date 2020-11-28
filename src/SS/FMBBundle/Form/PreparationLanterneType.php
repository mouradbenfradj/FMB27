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

class PreparationLanterneType extends AbstractType
{
    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', 'text', array('label' => 'Date de la Préparation des lanternes', 'attr' => array('class' => 'form-control inputmask', 'placeholder' => "dd/mm/yyyy", 'id' => "datepicker")));
        $builder->add('refArticle', 'entity', array('class' => 'SSFMBBundle:Articles',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('a')->where('a.libArticle LIKE :articles')->setParameter('articles', 'NAISSAIN%');
            }, 'label' => 'article', 'attr' => array('class' => "form-control")))
            ->add('numeroSerie', 'entity', array('class' => 'SSFMBBundle:StocksArticlesSn', 'label' => 'lot', 'mapped' => false, 'attr' => array('class' => "form-control")))
            ->add('qte', 'number', array('label' => 'Densiter', 'attr' => array('class' => "form-control")))
            ->add('nombre', 'number', array('label' => 'nombre de lanterne a fabriquer', 'mapped' => false));
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
        $lanternes = array();
        if ($parc) {
            // Fetch the cities from specified province
            $repo2 = $this->em->getRepository('SSFMBBundle:Lanterne');
            $stocks = $parc->getIdStock();
            $lanternes = $repo2->findByParc($parc);
        }
        // Add the city element
        $form->add('libStock', 'entity', array(
            'label' => 'Le stock qui contient vos articles',
            'empty_value' => '-- Selectionne le parc en premier lieu --',
            'class' => 'SSFMBBundle:Stocks',
            'choices' => array($stocks),
            'attr' => array('class' => "form-control")
        ));
        $form->add('nomLanterne', 'entity', array(
            'label' => 'choix du lanterne',
            'empty_value' => '-- Selectionne le parc en premier lieu --',
            'class' => 'SSFMBBundle:Lanterne',
            'choices' => $lanternes,
            'attr' => array('class' => "form-control")
        ));
        $form->add('quantiterEnStock', 'number', array(
            'label' => 'nombre de lanterne non utilisé en stock',
            'mapped' => false,
            'attr' => array('class' => "form-control", 'readonly' => "true", 'value' => '0')
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
        return 'ss_fmbbundle_preparationlanterne';
    }
}