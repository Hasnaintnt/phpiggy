<?php

declare(strict_types=1);

namespace Framework;

class Container{
    private array $definitions = [];

    public function addDefinition(array $newDefinitions){
        $this->definitions = array_merge($this->definitions, $newDefinitions);

        dd($newDefinitions);
    }

}