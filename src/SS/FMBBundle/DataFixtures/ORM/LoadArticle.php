<?php
namespace SS\FMBBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SS\FMBBundle\Entity\Articles;

class LoadArticle extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $NaissainHuitre = new Articles();
        $NaissainHuitre->setLibArticle('Naissain Huitre');
        $NaissainHuitre->setLibTicket('l');
        $NaissainHuitre->setDescCourte('e');
        $NaissainHuitre->setDescLongue('e');
        $NaissainHuitre->setRefArtCateg('r');
        $NaissainHuitre->setModele('m');
        $NaissainHuitre->setPaaLastMaj(new \DateTime());
        $NaissainHuitre->setPromo(1);
        $NaissainHuitre->setValoIndice(10);
        $NaissainHuitre->setLot(true);
        $NaissainHuitre->setComposant(true);
        $NaissainHuitre->setVariante(true);
        $NaissainHuitre->setGestionSn(true);
        $NaissainHuitre->setDateDebutDispo(new \DateTime());
        $NaissainHuitre->setDateFinDispo(new \DateTime());
        $NaissainHuitre->setDispo(true);
        $NaissainHuitre->setDateCreation(new \DateTime());
        $NaissainHuitre->setDateModification(new \DateTime());
        $NaissainHuitre->setIsAchetable(true);
        $NaissainHuitre->setIsVendable(true);

        $manager->flush();

        $this->addReference('NaissainHuitre', $NaissainHuitre);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }

}