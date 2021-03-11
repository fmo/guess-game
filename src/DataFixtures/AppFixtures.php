<?php

namespace Guess\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Guess\Domain\League\League;
use Guess\Domain\Player\Player;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
       $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $league = (new League())->setId(1);
        $league->setName('Premier League');
        $league->setLeagueNameSlugged('premier-league');
        $league->setLeagueApiId(123);
        $league->setLogo('premier-league-logo.png');

        $manager->persist($league);

        $player = new Player();
        $player->setUsername('fmo');
        $player->setEmail('test@Test.com');
        $player->setPassword($this->encoder->encodePassword($player, '123123'));

        $manager->persist($player);

        $manager->flush();
    }
}
