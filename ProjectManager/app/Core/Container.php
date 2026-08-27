<?php

declare(strict_types=1);

namespace App\Core;

class Container
{
    private array $bindings = [];

    private array $instances = [];


    public function bind(string $abstract, callable $resolver): void
    {
        $this->bindings[$abstract] = $resolver;
    }


    public function singleton(string $abstract, callable $resolver): void
    {
        $this->bindings[$abstract] = function () use ($abstract, $resolver) {

            if (!isset($this->instances[$abstract])) {
                $this->instances[$abstract] = $resolver($this);
            }

            return $this->instances[$abstract];

        };
    }


    public function make(string $abstract): mixed
    {
        if (isset($this->bindings[$abstract])) {
            return ($this->bindings[$abstract])($this);
        }

        return new $abstract();
    }
}