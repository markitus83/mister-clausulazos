<?php

  // Twig
    require_once __DIR__ . '/vendor/autoload.php';

    use Twig\Extra\Intl\IntlExtension;

    $filter = new \Twig\TwigFilter('ucwords', function ($string) {
      return ucwords($string);
    });

    $loader = new \Twig\Loader\FilesystemLoader('templates/twig');
    $twig = new \Twig\Environment($loader, [
        //'cache' => 'cache',
      'debug' => true,
    ]);
    $twig->addExtension(new IntlExtension());
    $twig->addFilter($filter);
  // End Twig

  // My team
  $getJsonFileContents = file_get_contents('data/my-team.json');
  $myTeam = json_decode($getJsonFileContents, true);

  $myTeamSorted = $myTeam;
  foreach ($myTeamSorted as $key => $player) {
      $colPoints[$key] = $player['points'];
      $colValue[$key] = $player['value'];
      $colClause[$key] = $player['clause'];
  }
  array_multisort($colPoints, SORT_DESC, $myTeamSorted);

  // All other teams
  $getJsonFileContents = file_get_contents("data/teams.json");
  $teams = json_decode($getJsonFileContents, true);

  foreach ($teams as $player) {    
    switch ($player['position']) {
      case 'pt':
        $players['pt'][] = $player;
        break;
      case 'df':
        $players['df'][] = $player;
        break;
      case 'mc':
        $players['mc'][] = $player;
        break;
      case 'dl':
        $players['dl'][] = $player;
        break;
    }
  }

  unset($colPoints);
  foreach ($players['pt'] as $clave => $fila) {
      $colPoints[$clave] = $fila['points'];
  }
  array_multisort($colPoints, SORT_DESC, $players['pt']);
  unset($colPoints);

  unset($colPoints);
  foreach ($players['df'] as $clave => $fila) {
      $colPoints[$clave] = $fila['points'];
  }
  array_multisort($colPoints, SORT_DESC, $players['df']);
  unset($colPoints);

  unset($colPoints);
  foreach ($players['mc'] as $clave => $fila) {
      $colPoints[$clave] = $fila['points'];
  }
  array_multisort($colPoints, SORT_DESC, $players['mc']);
  unset($colPoints);

  unset($colPoints);
  foreach ($players['dl'] as $clave => $fila) {
      $colPoints[$clave] = $fila['points'];
  }
  array_multisort($colPoints, SORT_DESC, $players['dl']);
  unset($colPoints);


  // Send to view
  echo $twig->render('index.html', 
    [
      'myTeam' => $myTeam,
      'myTeamSorted' => $myTeamSorted,
      'goalkeeper' => $players['pt'],
      'defender' => $players['df'],
      'midfielder' => $players['mc'],
      'forward' => $players['dl'],
    ]
  );