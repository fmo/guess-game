<?php

namespace Guess\Infrastructure\Services;

class FetchTeams implements FetchTeamsInterface
{
    private ProviderInterface $provider;

    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function fetch(array $input = []): array
    {
        $teams = $this->provider->getContent($input);

        $teamsArr = [];

        foreach ($teams['api']['teams'] as $league) {
            $teamsArr[] = [
                'name' => $league['name'],
                'logo' => $league['logo']
            ];
        }

        return $teamsArr;
    }
}
