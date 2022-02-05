<?php

namespace App\Domain\Main\Entity;

class User
{
    use IdentifierTrait;

    private string $username;

    private string $email;

    private string $password;

    /**
     * An array of Pokemons.
     *
     * @var Pokemon[]
     */
    private $pokemons = [];

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Pokemon[]
     */
    public function getPokemons()
    {
        return $this->pokemons;
    }

    public function addPokemon(Pokemon $pokemon): self
    {
        if (!in_array($pokemon, $this->pokemons, true)) {
            $this->pokemons[] = $pokemon;
            $pokemon->setTrainer($this);
        }

        return $this;
    }

    public function removePokemon(Pokemon $pokemon): self
    {
        if (($key = array_search($pokemon, $this->pokemons, true)) !== false) {
            unset($this->pokemons[$key]);
            // set the owning side to null (unless already changed)
            if ($pokemon->getTrainer() === $this) {
                $pokemon->setTrainer(null);
            }
        }

        return $this;
    }
}
