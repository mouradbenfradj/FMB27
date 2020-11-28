<?php

namespace SS\FMBBundle\Interfaces;


interface AssemblageInterface
{
    public function compareCordePocheAssemble($obj1, $obj2);

    public function tableauPoche($listePoche, $listPoche);

    public function comparePochePocheAssemble($obj1, $obj2);
}