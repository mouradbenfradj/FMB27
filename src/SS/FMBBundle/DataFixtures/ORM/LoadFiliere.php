<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Filiere;
use SS\FMBBundle\Entity\Segment;

class LoadFiliere extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $F1 = new Filiere();
        $F1->setNomFiliere("f1");
        $segment = new Segment();
        $segment->setNomSegment('A');
        $segment->setLongeur(100);
        $segmentb = new Segment();
        $segmentb->setNomSegment('B');
        $segmentb->setLongeur(150);
        $F1->addSegment($segment);
        $F1->addSegment($segmentb);
        $F1->setParc($this->getReference('fmb'));
        $manager->persist($F1);

        $manager->flush();
        $this->addReference('F1', $F1);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 8;
    }

}