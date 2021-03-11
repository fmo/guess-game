<?php

namespace Guess\Tests\Infrastructure\Command;

use Guess\Application\Handler\League\CreateLeagueHandler;
use Guess\Application\Services\FileUploaderInterface;
use Guess\Infrastructure\Command\FetchLeaguesCommand;
use Guess\Infrastructure\Services\FetchLeaguesInterface;
use Guess\Memory\Repository\LeagueRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Output\Output;

class FetchLeaguesCommandTest extends TestCase
{
    use ProphecyTrait;

    public function testLeagueCommand()
    {
        $leagueRepository = new LeagueRepository();

        $fileUploader = $this->prophesize(FileUploaderInterface::class);
        $fileUploader->upload(Argument::any(), Argument::any(), Argument::any())->shouldBeCalledTimes(3);
        $fileUploader->getImageUrl()->shouldBeCalledTimes(3)->willReturn('image.jpeg');

        $leagueHandler = new CreateLeagueHandler($leagueRepository, $fileUploader->reveal());

        $fetcherService = $this->prophesize(FetchLeaguesInterface::class);
        $fetcherService->fetch([])->shouldBeCalled()->willReturn(
            [[
                "leagueApiId" => "2816",
                "name" => "Turkish League",
                "logo" => "Turkish League Logo",
                "leagueNameSlugged" => "super-lig"
            ],
                [
                    "leagueApiId" => "2790",
                    "name" => "Premier League",
                    "logo" => "Premier Logo",
                    "leagueNameSlugged" => "premier-league"
                ],
                [
                    "leagueApiId" => "2833",
                    "name" => "La Liga",
                    "logo" => "La Liga Logo",
                    "leagueNameSlugged" => "ligue-1"
                ]]
        );

        $command = new FetchLeaguesCommand($leagueHandler, $fetcherService->reveal());

        $input = $this->prophesize(Input::class);
        $output = $this->prophesize(Output::class);

        $command->execute($input->reveal(), $output->reveal());

        $this->assertCount(3, $leagueRepository->getLeagues());
    }
}
