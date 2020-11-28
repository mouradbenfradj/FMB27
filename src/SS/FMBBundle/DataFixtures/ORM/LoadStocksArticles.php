<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\StocksArticles;

class LoadStocksArticles extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $stockArNH = new StocksArticles();
        $stockArNH->setRefArticle($this->getReference('NaissainHuitre'));
        $stockArNH->setQte(10000000);
        $stockArNH->setRefStockArticle('00001');
        $stockArNH->setIdStock($this->getReference('stock1'));
        $manager->persist($stockArNH);
        $manager->flush();
        $this->addReference('stockArNH', $stockArNH);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }

}