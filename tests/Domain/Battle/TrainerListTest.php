<?php

namespace App\Tests\Domain\Battle;

use PHPUnit\Framework\TestCase;
use App\Domain\Main\Entity\User;
use App\Domain\Battle\Service\TrainerList;

class TrainerListTest extends TestCase
{
    public function testRandomTrainer(): void
    {
        $this->assertInstanceOf(User::class, TrainerList::randomTrainer());
    }
}
