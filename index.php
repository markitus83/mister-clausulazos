<?php  
  session_start();

  require_once __DIR__ . '/misterAutoload.php';

  if (date_default_timezone_get()) {
      //echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';
  }

  if (ini_get('date.timezone')) {
    echo 'date.timezone: ' . ini_get('date.timezone');
    print_r(date('l jS \of F Y h:i:s A'));
  }

  // User login
  if (!isset($_SESSION['userData']['userName'])) {
    header("location:login.php");
    exit;
  } else {
    $username = $_SESSION['userData']['userName'];
    $myTeam = getTeamByUser($username);
  }




  // Get all player
  $getJsonFileContents = file_get_contents('data/players.json');
  $users = json_decode($getJsonFileContents, true);

  // Select user team by form
//   $username = '';
//   if (!empty($_POST) && isset($_POST['selectUser']) && $_POST['selectUser'] != 'no_user') {
//     $username = $_POST['selectUser'];
//     $myTeam = getTeamByUser($_POST['selectUser']);
//   } else {
//     echo $twig->render('index.html', 
//       [
//         'username' => $username,
//         'users' => $users,
//       ]
//     );
//     die;
//   }

  // My team
  //$getJsonFileContents = file_get_contents('data/my-team.json');
  //$myTeam = json_decode($getJsonFileContents, true);

  $myTeamSorted = $myTeam;
  foreach ($myTeamSorted as $key => $player) {
      $colPoints[$key] = $player['points'];
      $colValue[$key] = $player['value'];
      $colClause[$key] = $player['clause'];
  }
  array_multisort($colPoints, SORT_DESC, $myTeamSorted);

  // All other teams
  $getJsonFileContents = file_get_contents("data/all-teams.json");
  $teams = json_decode($getJsonFileContents, true);

  $allPlayers = removePlayersByUser($teams, $username);

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

  // Functions
  function getTeamByUser($username) {
      $getJsonFileContents = file_get_contents("data/all-teams.json");
      $allTeams = json_decode($getJsonFileContents, true);
    
      $keys = array_keys(array_column($allTeams, 'owner'), $username);
      $userTeam = [];
      foreach ($keys as $key) {
        $userTeam[] = $allTeams[$key];
      }
      
      return $userTeam;
  }

  function removePlayersByUser($teams, $username) {
    if (empty($username)) {
      return $teams;
    }
    
    $allPlayers = [];
    foreach ($teams as $player) {
      if ($player['owner'] == $username) {
        continue;
      } else {
        $allPlayers[] = $player;
      }
    }
    return $allPlayers;
  }

  function getMaldiniAdvices($myTeam, $allPlayers) {
    $pointsPt = $pointsDf = $pointsMc = $pointsDl = 0;
    $avgPt = $avgDf = $avgMc = $avgDl = 0;
    $numPt = $numDf = $numMc = $numDl = 0;
    foreach ($myTeam as $player) {
      switch ($player['position']) {
      case 'pt':
        $pointsPt += $player['points'];
        $numPt++;
        break;
      case 'df':
        $pointsDf += $player['points'];
        $numDf++;
        break;
      case 'mc':
        $pointsMc += $player['points'];
        $numMc++;
        break;
      case 'dl':
        $pointsDl += $player['points'];
        $numDl++;
        break;
      }
    }
    
    $avgPt = floor($pointsPt / $numPt);
    $avgDf = floor($pointsDf / $numDf);
    $avgMc = floor($pointsMc / $numMc);
    $avgDl = floor($pointsDl / $numDl);
    
    foreach ($allPlayers as $player) {
      switch ($player['position']) {
        case 'pt':          
          if ($player['points'] >= $avgPt) {
            $advice['pt'][] = $player;
          }               
        break;
        case 'df':
          if ($player['points'] >= $avgDf) {
            $advice['df'][] = $player;
          }
        break;
        case 'mc':
          if ($player['points'] >= $avgMc) {
            $advice['mc'][] = $player;
          } 
        break;
        case 'dl':
          if ($player['points'] >= $avgDl) {
            $advice['dl'][] = $player;
          }
        break;
      }
    }
    
    if (empty($advice['pt'])) {
      $advicePt = [];  
    } else {
      $adviceNumber = (count($advice['pt']) >= 4) ? 4 : count($advice['pt']);
      $pt = array_rand($advice['pt'], $adviceNumber);
      for ($i = 0; $i < $adviceNumber; $i++) {
        $advicePt[] = $advice['pt'][$pt[$i]];
      } 
    }

    if (empty($advice['df'])) {
      $adviceDf = [];  
    } else {
      $adviceNumber = (count($advice['df']) >= 4) ? 4 : count($advice['df']);
      $df = array_rand($advice['df'], $adviceNumber);
      for ($i = 0; $i < $adviceNumber; $i++) {
        $adviceDf[] = $advice['df'][$df[$i]];
      } 
    }
    
    if (empty($advice['mc'])) {
      $adviceMc = [];  
    } else {
      $adviceNumber = (count($advice['mc']) >= 4) ? 4 : count($advice['ptmc']);
      $mc = array_rand($advice['mc'], $adviceNumber);
      for ($i = 0; $i < $adviceNumber; $i++) {
        $adviceMc[] = $advice['mc'][$mc[$i]];
      } 
    }
    
    if (empty($advice['dl'])) {
      $adviceDl = [];  
    } else {
      $adviceNumber = (count($advice['dl']) >= 4) ? 4 : count($advice['dl']);
      $dl = array_rand($advice['dl'], $adviceNumber);
      for ($i = 0; $i < $adviceNumber; $i++) {
        $adviceDl[] = $advice['dl'][$dl[$i]];
      } 
    }
    
    return ['advicePt' => $advicePt, 'adviceDf' =>$adviceDf, 'adviceMc' => $adviceMc, 'adviceDl' =>$adviceDl];
    
  }

  // Send to view
  echo $twig->render('index.html', 
    [
      'username' => $username,
      'users' => $users,
      'myTeam' => $myTeam,
      'countMyTeam' => count($myTeam),
      'myTeamSorted' => $myTeamSorted,
      'goalkeeper' => $players['pt'],
      'defender' => $players['df'],
      'midfielder' => $players['mc'],
      'forward' => $players['dl'],
      'maldiniAdvice' => getMaldiniAdvices($myTeam, $allPlayers),
    ]
  );