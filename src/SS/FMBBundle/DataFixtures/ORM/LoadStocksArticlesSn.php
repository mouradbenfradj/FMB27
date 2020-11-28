<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Lot;
use SS\FMBBundle\Entity\StocksArticlesSn;

class LoadStocksArticlesSn extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 6;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $lot = new StocksArticlesSn('NH30', 100000, $this->getReference('stockArNH'));
        $manager->persist($lot);
        $lo = new StocksArticlesSn('NH33', 100000, $this->getReference('stockArNH'));
        $manager->persist($lo);
        $l = new StocksArticlesSn('NH32',100000,$this->getReference('stockArNH'));
        $manager->persist($l);

        $manager->flush();
        $this->addReference('lot', $lot);
        $this->addReference('lo', $lo);
        $this->addReference('l', $l);
    }
}