<?php

declare(strict_types=1);

namespace App\Actions\Status;

class Parameter
{
    private string $name;
    private string $value;

    public function __construct(string $name, string $value) {
        $this->name = $name;
        $this->value = $value;
    }

    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "value" => $this->value
        ];
    }
}
