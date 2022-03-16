<?php

declare(strict_types=1);

namespace App\Application\Command\Category;

use App\Application\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCategoryCommand implements Command
{
    #[Assert\NotBlank(message: "The 'name' should not be null")] private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}