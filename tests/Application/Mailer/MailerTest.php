<?php

namespace App\Tests\Application\Mailer;

use PHPUnit\Framework\TestCase;
use App\Domain\Main\Entity\User;
use App\Application\Mailer\Mailer;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Mailer\MailerInterface;

class MailerTest extends TestCase
{
    /** @var MockObject&MailerInterface */
    private $mailerInterface;

    private Mailer $mailer;

    protected function setUp(): void
    {
        $this->mailerInterface = $this->createMock(MailerInterface::class);
        $this->mailer = new Mailer($this->mailerInterface);
    }

    public function testSendSubscription(): void
    {
        $user = (new User())
            ->setEmail('example@mail.com')
            ->setUsername('username')
            ->setPassword('123456')
        ;
        $this->mailerInterface
            ->expects($this->once())
            ->method('send')
        ;
        $this->mailer->sendSubscription($user);
    }
}
