<?php

class Entity
{
    protected string $name;
    protected int $hp;
    protected int $mana;

    public function __construct(string $name, int $hp, int $mana)
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->mana = $mana;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHp(): int
    {
        return $this->hp;
    }

    public function getMana(): int
    {
        return $this->mana;
    }
}

class Player extends Entity
{
    private int $gold;

    public function __construct(string $name, int $hp, int $mana, int $gold)
    {

        parent::__construct($name, $hp, $mana);
        $this->gold = $gold;
    }

    public function getGold(): int
    {
        return $this->gold;
    }

    public function saveGame(string $filename = "game_save.csv"): void
    {
        $data = implode(";", [
            $this->name,
            $this->hp,
            $this->mana,
            $this->gold
        ]);

        file_put_contents($filename, $data);
    }

    public static function loadGame(string $filename = "game_save.csv"): ?Player
    {
        if (!file_exists($filename)) {
            return null;
        }

        $content = file_get_contents($filename);
        if (!$content) {
            return null;
        }

        [$name, $hp, $mana, $gold] = explode(";", $content);

        return new Player($name, (int)$hp, (int)$mana, (int)$gold);
    }
}

$player = new Player("Grog", 100, 50, 20);
$player->saveGame();

$loaded = Player::loadGame();

echo "<h2>Načtený hráč:</h2>";

if ($loaded) {
    echo "Jméno: {$loaded->getName()}<br>";
    echo "HP: {$loaded->getHp()}<br>";
    echo "Mana: {$loaded->getMana()}<br>";
    echo "Gold: {$loaded->getGold()}<br>";
} else {
    echo "Načtení selhalo.";
}
