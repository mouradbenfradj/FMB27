<?php

namespace SS\FMBBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * StocksLanternesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StocksLanternesRepository extends EntityRepository
{
    public function getLanternePreparer($stocksArticlesSn, $lanterne)
    {
        $qb = $this->createQueryBuilder('l');
        $qb->where('l.pret = false')
            ->andWhere('l.emplacement IS NULL')
            ->join('l.article', 's')
            ->addSelect('s')
            ->andwhere('s.refStockArticle = ?1')
            ->setParameter(1, $stocksArticlesSn->getRefStockArticle())
            ->andWhere('s.numeroSerie = ?2')
            ->setParameter(2, $stocksArticlesSn->getNumeroSerie())
            ->andWhere('l.lanterne = ?3')
            ->setParameter(3, $lanterne)
            ->orderBy('l.dateDeCreation', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function getLanternePreparerYellowWarning($parc)
    {
        $qb = $this->createQueryBuilder('stlanterne')
            ->select('lanterne.nomLanterne')
            ->addSelect('article.libArticle')
            ->addSelect('stocksarticlessn.numeroSerie')
            ->addSelect('stlanterne.dateDeCreation')
            ->addSelect('SUM(poche.quantite) as quantiter')
            ->join('stlanterne.article', 'stocksarticlessn')
            ->join('stlanterne.lanterne', 'lanterne')
            ->join('stocksarticlessn.refStockArticle', 'stocksarticle')
            ->join('stocksarticle.refArticle', 'article')
            ->join('stlanterne.poches', 'poche')
            ->where('lanterne.parc = :parc')
            ->andWhere('stlanterne.dateDeCreation = :date')
            ->andWhere('stlanterne.pret = :pret')
            ->andWhere('stlanterne.emplacement IS NULL')
            ->setParameter('date', new \DateTime(Date('Y-m-d')))
            ->setParameter('pret', false)
            ->setParameter('parc', $parc)
            ->groupBy('stlanterne.id');;
        return $qb->getQuery()->getResult();
    }

    public function getLanternePreparerRedWarning($parc)
    {
        $qb = $this->createQueryBuilder('stlanterne')
            ->select('lanterne.nomLanterne')
            ->addSelect('article.libArticle')
            ->addSelect('stocksarticlessn.numeroSerie')
            ->addSelect('stlanterne.dateDeCreation')
            ->addSelect('SUM(poche.quantite) as quantiter')
            ->join('stlanterne.article', 'stocksarticlessn')
            ->join('stlanterne.lanterne', 'lanterne')
            ->join('stocksarticlessn.refStockArticle', 'stocksarticle')
            ->join('stocksarticle.refArticle', 'article')
            ->join('stlanterne.poches', 'poche')
            ->where('lanterne.parc = :parc')
            ->andWhere('stlanterne.dateDeCreation < :date')
            ->andWhere('stlanterne.emplacement IS NULL')
            ->andWhere('stlanterne.pret = :pret')
            ->setParameter('date', new \DateTime(Date('Y-m-d')))
            ->setParameter('pret', false)
            ->setParameter('parc', $parc)
            ->groupBy('stlanterne.id');
        return $qb->getQuery()->getResult();
    }
}
