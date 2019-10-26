<?php

  // Twig
    require_once __DIR__ . '/vendor/autoload.php';

    use Twig\Extra\Intl\IntlExtension;

    $filter = new \Twig\TwigFilter('ucwords', function ($string) {
      return  mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
    });

    $loader = new \Twig\Loader\FilesystemLoader('templates/twig');
    $twig = new \Twig\Environment($loader, [
        //'cache' => 'cache',
      'debug' => true,
    ]);
    $twig->addExtension(new IntlExtension());
    $twig->addFilter($filter);
  // End Twig