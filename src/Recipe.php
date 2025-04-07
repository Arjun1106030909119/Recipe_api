<?php
class Recipe {
    private int $id;
    private string $name;
    private int $prepTime;
    private int $difficulty;
    private bool $vegetarian;

    public function __construct(string $name, int $prepTime, int $difficulty, bool $vegetarian, int $id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->prepTime = $prepTime;
        $this->setDifficulty($difficulty);
        $this->vegetarian = $vegetarian;
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrepTime(): int {
        return $this->prepTime;
    }

    public function getDifficulty(): int {
        return $this->difficulty;
    }

    public function isVegetarian(): bool {
        return $this->vegetarian;
    }

    // Setters
    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setPrepTime(int $prepTime): void {
        $this->prepTime = $prepTime;
    }

    public function setDifficulty(int $difficulty): void {
        if ($difficulty < 1 || $difficulty > 3) {
            throw new InvalidArgumentException("Difficulty must be between 1 and 3.");
        }
        $this->difficulty = $difficulty;
    }

    public function setVegetarian(bool $vegetarian): void {
        $this->vegetarian = $vegetarian;
    }

    // Convert object to array (for database handling)
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'prep_time' => $this->prepTime,
            'difficulty' => $this->difficulty,
            'vegetarian' => $this->vegetarian,
        ];
    }
}