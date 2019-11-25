<?php
  session_start();

  // Get all player
    $getJsonFileContents = file_get_contents('data/players.json');
    $users = json_decode($getJsonFileContents, true);

  if (!empty($_POST) && isset($_POST['loginUser']) && isset($_POST['inputPassword'])) {
    $username = $_POST['loginUser'];
    $password = $_POST['inputPassword'];
    
    $key = array_search($username, array_column($users, 'player_name'));
    
    if ($password == $users[$key]['password']) {
      echo json_encode(['errorLogin' => false]);
      $_SESSION['userData']['userName'] = $username;
      exit;
    }
  }

  echo json_encode(['errorLogin' => true]); exit;
