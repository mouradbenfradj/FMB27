<?php

namespace SS\FMBBundle\Controller\Menu\Statistique;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StatistiqueController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('idparc') == null) {
            $parc = $em->getRepository('SSFMBBundle:Magasins')->findAll();
            $nbfiliere = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrFiliere();
            $nbCordeP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordePreparer();
            $nbCordeHuitreP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeHuitrePreparer();
            $nbCordeMouleP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeMoulePreparer();
            $nbCordeAs = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAssemble();
            $nbCordeAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAEau();
            $nbCordeHuitreAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeHuitreAEau();
            $nbCordeMouleAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeHMoulesAEau();

            $nbCordeChausser = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeChausseeAE();
            $nbCordeAsAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAssembleAEau();
            $nbCordeES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeEnStock();
            $nbCorde = $nbCordeP + $nbCordeAe + $nbCordeES + $nbCordeAs + $nbCordeAsAe;

            $nbLanterneP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanternePreparer();
            $nbLanterneAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneAEau();
            $nbrlanterneChausser = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneChausserAEau();
            $nbLanterneES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneEnStock();
            $nbLanterne = $nbLanterneP + $nbLanterneAe + $nbLanterneES;

            $nbPocheP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPochePreparer();
            $nbPocheAsP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAssemblePreparer();
            $nbPocheAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAEau();
            $nbPocheChausserAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheChausserAEau();
            $nbPocheAsAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAssembleAEau();
            $nbPocheES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheEnStock();
            $nbPoche = $nbPocheP + $nbPocheAe + $nbPocheES;
        } else {
            $parc = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
            $nbfiliere = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrFiliereByParc($parc);
            $nbCordeP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordePreparerByParc($parc);
            $nbCordeHuitreP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeHuitrePreparerByParc($parc);
            $nbCordeMouleP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeMoulePreparerByParc($parc);
            $nbCordeAs = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAssembleByParc($parc);
            $nbCordeAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAEauByParc($parc);
            $nbCordeHuitreAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeHuitreAEauByParc($parc);
            $nbCordeMouleAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeMouleAEauByParc($parc);
            $nbCordeChausser = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeChausserAEByParc($parc);

            $nbCordeAsAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAssembleAEauByParc($parc);
            $nbCordeES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeEnStockByParc($parc);
            $nbCorde = $nbCordeP + $nbCordeAe + $nbCordeES;

            $nbLanterneP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanternePreparerByParc($parc);
            $nbLanterneAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneAEauByParc($parc);
            $nbrlanterneChausser = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneChausserAEauByParc($parc);
            $nbLanterneES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneEnStockByParc($parc);
            $nbLanterne = $nbLanterneP + $nbLanterneAe + $nbLanterneES;

            $nbPocheP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPochePreparerByParc($parc);
            $nbPocheAsP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAssemblePreparerByParc($parc);
            $nbPocheAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAEauByParc($parc);
            $nbPocheChausserAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheChausserAEauByParc($parc);
            $nbPocheAsAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAssembleAEauByParc($parc);
            $nbPocheES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheEnStockByParc($parc);
            $nbPoche = $nbPocheP + $nbPocheAe + $nbPocheES + $nbPocheAsP + $nbPocheAsAe;
        }
        return $this->render('SSFMBBundle:Default:index.html.twig',
            array(
                'entity' => $parc,
                'nbrParc' => count($parc),
                'nbrcorde' => ($nbCorde),
                'nbrcordev' => ($nbCordeES),
                'nbrCordeAs' => ($nbCordeAs),
                'nbrCordeAsAe' => ($nbCordeAsAe),
                'nbrCordeChausser' => $nbCordeChausser,
                'nbrcordep' => ($nbCordeP),
                'nbCordeHuitreP' => ($nbCordeHuitreP),
                'nbCordeMouleP' => ($nbCordeMouleP),
                'nbrcordeae' => ($nbCordeAe),
                'nbrordehuitreae' => ($nbCordeHuitreAe),
                'nbcordemouleae' => ($nbCordeMouleAe),
                'nbrlanterne' => ($nbLanterne),
                'nbrlanternev' => ($nbLanterneES),
                'nbrlanternep' => ($nbLanterneP),
                'nbrlanterneae' => ($nbLanterneAe),
                'nbrlanterneChausser' => $nbrlanterneChausser,
                'nbrpoche' => ($nbPoche),
                'nbrpochev' => ($nbPocheES),
                'nbrpochep' => ($nbPocheP),
                'nbrpocheAsp' => ($nbPocheAsP),
                'nbrpocheae' => ($nbPocheAe),
                'nbrpocheAsae' => ($nbPocheAsAe),
                'nbPocheChausserAe' => $nbPocheChausserAe,
                'nbrfiliere' => $nbfiliere
            )
        );
    }
}