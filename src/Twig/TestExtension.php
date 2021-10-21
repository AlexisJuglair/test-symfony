<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TestExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('firstword', [$this, 'explodeString']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('makebtn', [$this, 'makeButton']),
        ];
    }

    public function explodeString($string)
    {
        $word = explode(" ", $string);
        return $word[0];
    }

    public function makeButton($name, $type="")
    {
        switch ($type)
        {
            case "primary":
                echo "<button type='button' class='btn btn-primary'>$name</button>";
                break;

            case "primary":
                echo "<button type='button' class='btn btn-primary'>$name</button>";
                break;
            
            case "secondary":
                echo "<button type='button' class='btn btn-secondary'>$name</button>";
                break;

            case "success":
                echo "<button type='button' class='btn btn-success'>$name</button>";
                break;

            case "danger":
                echo "<button type='button' class='btn btn-danger'>$name</button>";
                break;

            case "warning":
                echo "<button type='button' class='btn btn-warning'>$name</button>";
                break;

            case "info":
                echo "<button type='button' class='btn btn-info'>$name</button>";
                break;

            case "light":
                echo "<button type='button' class='btn btn-light'>$name</button>";
                break;

            case "dark":
                echo "<button type='button' class='btn btn-dark'>$name</button>";
                break;

            default:
                echo "<button type='button' class='btn btn-link'>$name</button>";
                break;
        }
    }
}
