<?php

namespace Tournament;

class Highlander extends BasicPerson
{
    protected int $maxHitPoint = 150;

    public function __construct($modification = '')
    {
        $this->hitPoint = $this->maxHitPoint;
        $this->equip('GreatSword');
        if($modification){
            $this->setModification($modification);
        }
    }

}