<?php

namespace Tournament;

use Tournament\Interfaces\BasicPersonInterface;

Abstract class BasicPerson implements BasicPersonInterface
{
    public array $weapon = [];
    public array $armor = [];
    public array $modification;
    public int $hitPoint = 0;
    public int $round = 0;

    /**
     * @param string $equip
     */
    public function equip(string $equip)
    {

        switch ($equip) {
            case 'buckler':
            case 'armor':
                $this->armor[$equip] = Equip::setEquip($equip);
                break;
            default:
                $this->weapon = [];
                $this->weapon[$equip] = Equip::setEquip($equip);
                break;
        }
    }

    public function setModification($modification)
    {
        $this->modification[$modification] = Equip::setModification($modification);
    }

    public function hitPoints(): int
    {
        if ($this->hitPoint < 0) {
            $this->hitPoint = 0;
        }
        return $this->hitPoint;
    }

    public function getDmg($enemy)
    {
        $typeOfWeapon = $this->getTypeOfWeapon();
        $reduce = $enemy->getReduceDmg($typeOfWeapon);
        $modificationDmg = $this->getModification();
        $minusDmg = 0;
        foreach ($this->weapon as $value) {
            foreach ($this->armor as $v) {
                if(isset($v['damages'])) {
                    $minusDmg += $v['damages'];
                }
            }
            if(is_string($reduce)){
                return 0;
            }
            if(isset($modificationDmg['add'])){
                $value['dmg'] += $modificationDmg['add'];
            }
            if(isset($modificationDmg['multiply'])){
                $value['dmg'] = $value['dmg'] * $modificationDmg['multiply'];
            }
            return isset($value['miss']) && ($this->round % $value['miss'] == 0) ? 0 : $value['dmg'] - $minusDmg - $reduce;
        }
    }

    public function getTypeOfWeapon()
    {
        foreach ($this->weapon as $key => $value) {
            return $key;
        }
    }

    public function getReduceDmg($EnemyTypeOfWeapon)
    {
        $reduce = 0;
        if (!empty($this->armor)) {
            foreach ($this->armor as $key => $value) {
                if ($key == 'buckler' && $this->round % $value['block'] == 0) {
                    foreach ($value['destroyed'] as $k => $v) {
                        if ($EnemyTypeOfWeapon == $k) {
                            --$this->armor['buckler']['destroyed'][$k];
                            if ($v == 0) {
                                unset($this->armor['buckler']);
                            }
                        }
                    }
                    return 'full';
                }
                if($key == 'armor'){
                    $reduce += $value['reduce'];
                }
            }
        }
        return (int)$reduce;
    }

    public function getModification()
    {
        if(isset($this->modification)) {
            foreach ($this->modification as $key => &$value) {
                if(isset($value['addDmg'])){
                    --$this->modification[$key]['count'];
                    if($value['count'] == 0){
                        unset($this->modification[$key]);
                    }
                    return ['add' => $value['addDmg']];
                }
                if(isset($value['hp']) && ($this->maxHitPoint*$value['hp']/100) >= $this->hitPoints()){
                    return ['multiply' => $value['multiply']];
                }
            }
        }
    }

    public function setRound()
    {
        $this->round++;
    }
}