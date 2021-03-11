<?php

namespace Guess\Infrastructure\Doctrine\DateHelpers;

use DateInterval;
use DateTime;
use DateTimeImmutable;

trait DateTrait
{
    public function startingDayOfGivenWeek(DateTimeImmutable $gameTime): string
    {
        $targetDate = new DateTime();
        $targetDate->setISODate(
            $gameTime->format('Y'), $gameTime->format('W')
        );

        return $targetDate->format("Y-m-d" . " 00:00:00");
    }

    public function endingDayOfGivenWeek(DateTimeImmutable $gameTime): string
    {
        $targetDate = new DateTime();
        $targetDate->setISODate(
            $gameTime->format('Y'), $gameTime->format('W')
        );

        return $targetDate
            ->add(DateInterval::createFromDateString('+6 days'))
            ->format("Y-m-d" . " 23:59:59");

    }
}
