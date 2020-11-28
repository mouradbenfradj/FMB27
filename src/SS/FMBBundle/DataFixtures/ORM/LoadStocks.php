<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Stocks;

class LoadStocks extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $stock1 = new Stocks();
        $stock1->setLibStock('stock1');
        $stock1->setAbrevStock('st1');
        $stock1->setActif(true);
        $manager->persist($stock1);
        $stock2 = new Stocks();
        $stock2->setLibStock('stock2');
        $stock2->setAbrevStock('st2');
        $stock2->setActif(true);
        $manager->persist($stock2);
        $stock6 = new Stocks();
        $stock6->setLibStock('stockLanterne');
        $stock6->setAbrevStock('stLnterne');
        $stock6->setActif(true);
        $manager->persist($stock6);
        $stock7 = new Stocks();
        $stock7->setLibStock('stockCorde');
        $stock7->setAbrevStock('stCorde');
        $stock7->setActif(true);
        $manager->persist($stock7);
        $stock5 = new Stocks();
        $stock5->setLibStock('stockArticle');
        $stock5->setAbrevStock('stArticle');
        $stock5->setActif(true);
        $manager->persist($stock5);
        $stock3 = new Stocks();
        $stock3->setLibStock('stock1');
        $stock3->setAbrevStock('st1');
        $stock3->setActif(true);
        $manager->persist($stock3);
        $stock4 = new Stocks();
        $stock4->setLibStock('stock2');
        $stock4->setAbrevStock('st2');
        $stock4->setActif(true);
        $manager->persist($stock4);
        $manager->flush();
        $this->addReference('stock1', $stock1);
        $this->addReference('stock2', $stock2);
        $this->addReference('stock6', $stock6);
        $this->addReference('stock7', $stock7);
        $this->addReference('stock3', $stock3);
        $this->addReference('stock4', $stock4);
        $this->addReference('stock5', $stock5);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

}