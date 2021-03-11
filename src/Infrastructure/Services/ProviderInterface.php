<?php

namespace Guess\Infrastructure\Services;

interface ProviderInterface
{
    public function getContent(array $criteria);
}
