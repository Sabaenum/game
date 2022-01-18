<?php

namespace Tournament;

class Viking extends BasicPerson
{
    protected int $maxHitPoint = 120;

    public function __construct($modification = '')
    {
        $this->hitPoint = $this->maxHitPoint;
        $this->equip('axe');
    }

}