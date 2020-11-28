<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Magasins;

class LoadMagasins extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $fmb = new Magasins();
        $fmb->setAbrevMagasin('FMB');
        $fmb->setLibMagasin('Ferme Marine De Bizert');
        $fmb->setActif(true);
        $fmb->setIdStock($this->getReference('stock1'));
        $fmb->setModeVente("mode");
        $manager->persist($fmb);
        $FMBMTH = new Magasins();
        $FMBMTH->setAbrevMagasin('FMBMTH');
        $FMBMTH->setLibMagasin('FMBMTH');
        $FMBMTH->setIdStock($this->getReference('stock2'));
        $FMBMTH->setActif(true);
        $FMBMTH->setModeVente("mode");
        $manager->persist($FMBMTH);
        $Marinor = new Magasins();
        $Marinor->setAbrevMagasin('Marinor');
        $Marinor->setLibMagasin('Marinor');
        $Marinor->setIdStock($this->getReference('stock3'));
        $Marinor->setActif(true);
        $Marinor->setModeVente("mode");
        $manager->persist($Marinor);

        $manager->flush();
        $this->addReference('fmb', $fmb);
        $this->addReference('FMBMTH', $FMBMTH);
        $this->addReference('Marinor', $Marinor);
    }
}