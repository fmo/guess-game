<?php

namespace Guess\Application\Handler\Player;

use Exception;
use Guess\Domain\Player\Player;
use Guess\Domain\Player\PlayerRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreatePlayerHandler
{
    private PlayerRepositoryInterface $playerRepository;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(
        PlayerRepositoryInterface $playerRepository,
        UserPasswordEncoderInterface $encoder
    )
    {
        $this->playerRepository = $playerRepository;
        $this->encoder = $encoder;
    }

    /**
     * @param array $playerArray
     * @throws Exception
     */
    public function handle(array $playerArray)
    {
        $player = new Player();
        $player->setUsername($playerArray['username']);
        $player->setEmail($playerArray['email']);
        $player->setAvatar($playerArray['avatar']);
        $player->setPassword(
            $this->encoder->encodePassword($player, $playerArray['password'])
        );

        try {
            $this->playerRepository->save($player);
        } catch (Exception $exception) {
            throw new Exception ('User can not be saved');
        }

    }
}
