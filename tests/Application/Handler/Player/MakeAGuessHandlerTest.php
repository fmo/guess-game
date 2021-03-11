<?php

namespace Guess\Tests\Application\Handler\Player;

use DateTimeImmutable;
use Exception;
use Guess\Application\Handler\Player\MakeAGuessHandler;
use Guess\Domain\Game\Game;
use Guess\Domain\Player\Player;
use Guess\Domain\Team\Team;
use Guess\Memory\Repository\GameRepository;
use Guess\Memory\Repository\PlayerRepository;
use PHPUnit\Framework\TestCase;

class MakeAGuessHandlerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testMakeAGuess()
    {
        $this->expectException(Exception::class);

        $player = new Player();
        $player->setUsername('fmo');

        $game = new Game();
        $game->setId(333);
        $game->setGameTime(new DateTimeImmutable('tomorrow'));
        $game->setHomeTeam((new Team())->setName('Liverpool'));
        $game->setAwayTeam((new Team())->setName('Arsenal'));

        $playerRepository = new PlayerRepository();
        $playerRepository->save($player);

        $gameRepository = new GameRepository();
        $gameRepository->save($game);

        $makeAGuess = new MakeAGuessHandler($playerRepository, $gameRepository);
        $makeAGuess->handle([
            'username' => 'fmo',
            'gameId' => 333,
            'guess' => '4-4'
        ]);

        $makeAGuess->handle([
            'username' => 'fmo',
            'gameId' => 323,
            'guess' => '4-4'
        ]);

        $this->assertEquals('4-4', $player->getGuess($game)->getGuess());
    }
}
