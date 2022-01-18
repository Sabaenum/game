<?php

namespace Tournament;

class Equip
{

    private static array $equip = [
        'buckler' =>[
            'block' => 2,
            'destroyed' => [
                'axe' => 3
            ]
        ],
        'armor' =>[
            'reduce' => 3,
            'damages' => 1
        ],
        'sword' => [
            'dmg' => 5
        ],
        'axe' => [
            'dmg' => 6
        ],
        'GreatSword' => [
            'dmg' => 12,
            'miss' => 3
        ]
    ];

    private static array $modification = [
        'Vicious' => [
            'addDmg' => 20,
            'count' => 2
        ],
        'Veteran' => [
            'hp' => 30,
            'multiply' => 2
        ]
    ];

    static function setModification($type)
    {
        return self::$modification[$type];
    }

    static function setEquip($type): array
    {
        return self::$equip[$type];
    }
}