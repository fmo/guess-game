<?php

namespace Guess\Infrastructure\Services;

use Symfony\Component\String\Slugger\AsciiSlugger;

class FetchLeagues implements FetchLeaguesInterface
{
    private ProviderInterface $provider;

    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function fetch(array $input = []): array
    {
        $leagues = $this->provider->getContent($input);

        $leagueArr = [];

        foreach ($leagues['api']['leagues'] as $league) {
            if (!in_array(strtolower((new AsciiSlugger())->slug($league['name'])->toString()), [
                'premier-league',
                'serie-a',
                'primera-division', /* La Liga */
                'primeira-liga', /*  Liga Portugal */
                'super-lig',
                'uefa-europa-league',
                'uefa-champions-league',
                'uefa-nations-league',
                'bundesliga-1',
                'ligue-1' /* France Ligue 1 */
            ])) {
                continue;
            }

            if (!in_array($league['country'], [
                'England',
                'Italy',
                'France',
                'Portugal',
                'Spain',
                'Turkey',
                'World',
                'Germany'
            ])) {
                continue;
            }

            $leagueArr[] = [
                'leagueApiId' => $league['league_id'],
                'name' => $league['name'],
                'logo' => $league['logo'],
                'leagueNameSlugged' => strtolower((new AsciiSlugger())->slug($league['name'])->toString())
            ];
        }

        return $leagueArr;
    }
}
