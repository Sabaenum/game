<?php

namespace Tournament;

class Swordsman extends BasicPerson
{
    protected int $maxHitPoint = 100;

    public function __construct($modification = '')
    {
        $this->hitPoint = $this->maxHitPoint;
        $this->equip('sword');
        if($modification){
            $this->setModification($modification);
        }
    }

    public function engage($enemy)
    {
        $count = 0;
        while ($enemy->hitPoints() != 0 && $this->hitPoints() != 0) {
            if ($count % 2 == 0){
                $dmg = $this->getDmg($enemy);
                $enemy->hitPoint -= $dmg;
                $this->setRound();
            } else {
                $dmg = $enemy->getDmg($this);
                $this->hitPoint -= $dmg;
                $enemy->setRound();
            }
            $count++;
        }
    }



}
