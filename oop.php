<?php
Class Player
{
    public function __construct($name)
    {
        $this->name = $name;
        $this->alive = true;
    }
    public function calcDamage()
    {

    }
    public function receiveDamage($dmg)
    {

    }
    public string $name;
    public int $hp;
    public int $currentHp;
    public int $mp;
    public int $currentMp;
    public array $buffs;
    public array $debuffs;
    public int $agility, $strenght, $intellect;
    public int $baseDamage;
    public float $baseArmor;
    public bool $alive;
}

Class Rogue extends Player
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->agility = 5;
        $this->strenght = 3;
        $this->intellect = 2;
        $this->hp = $this->strenght * 30;
        $this->mp = $this->intellect * 30;
        $this->baseDamage = $this->agility * 3;
        $this->baseArmor = $this->agility * 1.5;
        $this->currentHp = $this->hp;
        $this->currentMp = $this->mp;
    }
    public function calcDamage()
    {
        if (mt_rand(1, 6) > 3)
        {
            echo "---$this->name MADE CRITICAL DAMAGE---\n";
            echo "<br>";
            return ($this->baseDamage * mt_rand(10, 30)) / 8;
        }
        return ($this->baseDamage * mt_rand(5, 15)) / 8;
    }
    public function receiveDamage($dmg)
    {
        $absorbedDamage = $dmg - ($this->baseArmor / 30);
        if (($this->currentHp - $absorbedDamage) < 0)
        {
            $this->currentHp = 0;
            $this->alive = false;
        }
        $this->currentHp -= $absorbedDamage;
    }
}

Class Warrior extends Player
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->strenght = 6;
        $this->agility = 3;
        $this->intellect = 1;
        $this->hp = $this->strenght * 30;
        $this->mp = $this->intellect * 30;
        $this->baseDamage = $this->strenght * 3;
        $this->baseArmor = $this->agility * 1.5;
        $this->currentHp = $this->hp;
        $this->currentMp = $this->mp;
    }
    public function calcDamage()
    {
            return ($this->baseDamage * mt_rand(5, 15)) / 8;
    }
    public function receiveDamage($dmg)
    {
        $absorbedDamage = $dmg - ($this->baseArmor / 30);
        if (($this->currentHp - $absorbedDamage) < 0)
        {
            $this->currentHp = 0;
            $this->alive = false;
        }
        $this->currentHp -= $absorbedDamage;
    }
}

Class Core
{
    public array $heroes;
    public function addHero(Player $unit)
    {
        $this->heroes[] = $unit;
    }
    public function doDuel(Player $plr1, Player $plr2) : void
    {
        $dice1 = mt_rand(1,6);
        $dice2 = mt_rand(1,6);
        if ($dice1 > $dice2)
        {
            $dmg = $plr1->calcDamage();
            $hpBeforeDamage = $plr2->currentHp;
            $plr2->receiveDamage($dmg);
            echo "$plr1->name made $dmg damage to $plr2->name";
            echo "<br>";
            echo "$hpBeforeDamage -> $plr2->currentHp";
        }
        else { $dmg = $plr2->calcDamage();
            $hpBeforeDamage = $plr1->currentHp;
            $plr1->receiveDamage($dmg);
            echo "$plr2->name made $dmg damage to $plr1->name";
            echo "<br>";
            echo "$hpBeforeDamage -> $plr1->currentHp";
        }
    }
    public function excludeHero($hero)
    {
        $exclude = array_values(array_filter($this->heroes, function ($unit) use ($hero){
            return $unit !== $hero;
        }));
        return $exclude;
    }
}


$valeera = new Rogue("Valeera");
$garosh = new Warrior("Garrosh");
$core = new Core();
$core->addHero($valeera);
$core->addHero($garosh);
$core->doDuel($valeera, $garosh);
