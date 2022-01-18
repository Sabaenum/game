<?php

namespace Tournament\Interfaces;

interface BasicPersonInterface
{
    public function equip(string $equip);

    public function hitPoints();
}