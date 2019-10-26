<?php
  session_start();
  
  require_once __DIR__ . '/misterAutoload.php';

  // Get all player
    $getJsonFileContents = file_get_contents('data/players.json');
    $users = json_decode($getJsonFileContents, true);

  if (!empty($_POST) && isset($_POST['loginUser']) && isset($_POST['inputPassword'])) {
    $username = $_POST['loginUser'];
    $password = $_POST['inputPassword'];
    
    $key = array_search($username, array_column($users, 'player_name'));
    
    if ($password != $users[$key]['password']) {
      echo $twig->render('login.html', ['errorLogin' => true, 'users' => $users]);
    } else {
      $_SESSION['userData']['userName'] = $username;
      
      header("location: index.php");
      exit;
    }
  } else {    
    echo $twig->render('login.html', ['users' => $users]);
  }


    