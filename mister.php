<?php
  //https://www.csvjson.com/csv2json
  //https://phptest-ginodev.codeanyapp.com/mister.php

  require_once('mister/v1/mister_part1.html');

  //https://www.codewall.co.uk/how-to-read-json-file-using-php-examples/
  // Get the contents of the JSON file 
  $strJsonFileContents = file_get_contents("mister/data/my-team.json");
  // Convert to array 
  $my_team = json_decode($strJsonFileContents, true);

  //https://www.php.net/manual/es/function.array-multisort.php
  $my_team_sorted = $my_team;
  foreach ($my_team_sorted as $key => $player) {
      $col_points[$key] = $player['points'];
      $col_value[$key] = $player['value'];
      $col_clause[$key] = $player['clause'];
  }
  array_multisort($col_points, SORT_DESC, $my_team_sorted);

  // print my team
  require_once('mister/v1/mister_part2.html');  
  echo '<h2>My team</h2>';
  print_team_table($my_team);

  //https://www.php.net/manual/es/function.array-multisort.php
  foreach ($my_team as $key => $player) {
      $col_points[$key] = $player['points'];
      $col_value[$key] = $player['value'];
      $col_clause[$key] = $player['clause'];
  }
  array_multisort($col_points, SORT_DESC, $my_team);
  echo '<h2>My team (sorted by points)</h2>';
  print_team_table($my_team);


  // other teams
  $strJsonFileContents = file_get_contents("mister/data/teams.json");
  // Convert to array 
  $array = json_decode($strJsonFileContents, true);

  echo '<h2>All players</h2>';
  foreach ($array as $idx => $player) {
    //$player['idx'] = $idx;
    //print_player($player);    
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

  foreach ($players['pt'] as $clave => $fila) {
      $col_points[$clave] = $fila['points'];
  }
  array_multisort($col_points, SORT_DESC, $players['pt']);
  echo '<h2>Players by positions: PT</h2>';
  print_team_table($players['pt']);
  unset($col_points);

  foreach ($players['df'] as $clave => $fila) {
      $col_points[$clave] = $fila['points'];
  }
  array_multisort($col_points, SORT_DESC, $players['df']);
  echo '<h2>Players by positions: DF</h2>';
  print_team_table($players['df']);
  unset($col_points);

  foreach ($players['mc'] as $clave => $fila) {
      $col_points[$clave] = $fila['points'];
  }
  array_multisort($col_points, SORT_DESC, $players['mc']);
  echo '<h2>Players by positions: MC</h2>';
  print_team_table($players['mc']);
  unset($col_points);

  foreach ($players['dl'] as $clave => $fila) {
      $col_points[$clave] = $fila['points'];
  }
  array_multisort($col_points, SORT_DESC, $players['dl']);
  echo '<h2>Players by positions: DL</h2>';
  print_team_table($players['dl']);


  require_once('mister/v1/mister_part3.html');

  function print_player($player) {
    $owner = '<span class="badge badge-info">'.$player['owner'].'</span>';
    
    $points = '<span class="badge badge-secondary">'.$player['points'].'</span>';
    
    switch ($player['position']) {
      case 'pt':
        $badge_position = '<span class="badge badge-warning">PT</span>';
        break;
      case 'df':
        $badge_position = '<span class="badge badge-primary">DF</span>';
        break;
      case 'mc':
        $badge_position = '<span class="badge badge-success">MC</span>';
        break;
      case 'dl':
        $badge_position = '<span class="badge badge-danger">DL</span>';
        break;
      default:
        $badge_position = '';
        break;
    }
    
    $value = number_format($player['value'], 0, '', '.');
    $clause = number_format($player['clause'], 0, '', '.');    
    
    echo ($player['idx']+1) . ' # ' . 
      $owner . ' # ' .
      $player['player_name'] . ' # ' . 
      $points . ' # ' .
      $badge_position . ' # ' . 
      $value . ' # ' . 
      $clause . '<br/>';
  }

  function print_team_table($players) {
    echo '
    <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Owner</th>
        <th scope="col">PLayer Name</th>
        <th scope="col">Points</th>
        <th scope="col">Position</th>
        <th scope="col">Value</th>
        <th scope="col">Clause</th>
      </tr>
    </thead>
    <tbody>';

    foreach ($players as $idx => $player) {
      $owner = '<span class="badge badge-info">'.$player['owner'].'</span>';

      $points = '<span class="badge badge-secondary">'.$player['points'].'</span>';

      switch ($player['position']) {
        case 'pt':
          $badge_position = '<span class="badge badge-warning">PT</span>';
          break;
        case 'df':
          $badge_position = '<span class="badge badge-primary">DF</span>';
          break;
        case 'mc':
          $badge_position = '<span class="badge badge-success">MC</span>';
          break;
        case 'dl':
          $badge_position = '<span class="badge badge-danger">DL</span>';
          break;
        default:
          $badge_position = '';
          break;
      }

      $value = number_format($player['value'], 0, '', '.');
      $clause = number_format($player['clause'], 0, '', '.');  

      echo '<tr>
        <th scope="row">'.($idx+1).'</th>
        <td>'.$owner.'</td>
        <td>'.$player['player_name'].'</td>
        <td>'.$points.'</td>
        <td>'.$badge_position.'</td>
        <td>'.$value.'</td>
        <td>'.$clause.'</td>
      </tr>';
    }

    echo '</tbody></table>';
  }
