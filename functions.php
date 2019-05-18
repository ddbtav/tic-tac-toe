<?php

function draw_logout_button(){

    echo <<<_LOGOUT_BUTTON
        <form method="POST" action="index.php">
            <input type="submit" value="logout" name="submit-logout">
        </form>
        
_LOGOUT_BUTTON;

}


function draw_proceed_to_settings_button() {
    
    echo <<<_PROCEED_BUTTON
        <form method="POST" action="settings.php">
            <input type="submit" value="Play" name="submit-proceed">
        </form>
        
_PROCEED_BUTTON;
    
}


function username_exists($username)
{
    $pdo = createPdo();
    $stmt = $pdo->query('SELECT * FROM users');
    $username_exists = false;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        // echo $row['username'] . '<br>';
        // echo $row['password'] . '<br>';
        
        $usernameDb = $row['username'];
        
        if (strtoupper($username) === $usernameDb) {
            $username_exists = true;
            break;
        }
    }
    
    $pdo = null;
    return $username_exists;
}


function createPdo()
{
    require "dbaccess.php";

    $host = 'localhost';
    $user = $dbuser;
    $password = $dbpassword;
    $dbname = 'tic-tac-toe';
    // Set DSN
    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
}

function checkLoginCredentials($username, $password)
{
    $pdo = createPdo();
    $stmt = $pdo->query('SELECT * FROM users');
    $loginValid = false;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        // echo $row['username'] . '<br>';
        // echo $row['password'] . '<br>';
        
        $usernameDb = $row['username'];
        $passwordDb = $row['password'];
        
        if (strtoupper($username) === $usernameDb && $password === $passwordDb) {
            $loginValid = true;
            break;
        }
    }
    
    $pdo = null;
    return $loginValid;
}

function insertIntoTable($username,$password){
    $pdo=createPdo();
    //table must be created with autoincrement functionality
    //ALTER TABLE credentials MODIFY COLUMN id INT auto_increment
    $sql = "INSERT INTO users(id,username,password) VALUES(:id, :username, :password)";
    $stmt = $pdo->prepare($sql);
    $success=$stmt->execute(['id' => NULL, 'username' => strtoupper($username), 'password' => $password]);
    $pdo=null;
    // INSERT INTO table_name (name, group) VALUES ('my name', 'my group')
    return $success;
}


function return_tie_stats_string() {
    $tie_stats_string="";
    $tie_stats_string = $_SESSION['opponent']."_tie_".$_SESSION['board_size']."x".$_SESSION['board_size'];
    
    return $tie_stats_string;
    
}


function return_win_stats_string(){
    $win_stats_string="";
    $win_stats_string = $_SESSION['opponent']."_".strtolower($_SESSION['mover'])."_win_".$_SESSION['board_size']."x".$_SESSION['board_size'];
    
    return $win_stats_string;
}

function init_stats(){
    if (!isset($_SESSION['player_x_win_3x3'])){
        $_SESSION['player_x_win_3x3'] = 0;
    }

    if (!isset($_SESSION['player_x_win_4x4'])){
        $_SESSION['player_x_win_4x4'] = 0;
    }

    if (!isset($_SESSION['player_x_win_5x5'])){
        $_SESSION['player_x_win_5x5'] = 0;
    }

    if (!isset($_SESSION['player_o_win_3x3'])){
        $_SESSION['player_o_win_3x3'] = 0;
    }

    if (!isset($_SESSION['player_o_win_4x4'])){
        $_SESSION['player_o_win_4x4'] = 0;
    }

    if (!isset($_SESSION['player_o_win_5x5'])){
        $_SESSION['player_o_win_5x5'] = 0;
    }
    
    if (!isset($_SESSION['player_tie_3x3'])){
        $_SESSION['player_tie_3x3'] = 0;
    }

    if (!isset($_SESSION['player_tie_4x4'])){
        $_SESSION['player_tie_4x4'] = 0;
    }

    if (!isset($_SESSION['player_tie_5x5'])){
        $_SESSION['player_tie_5x5'] = 0;
    }

    if (!isset($_SESSION['player_games_3x3'])){
        $_SESSION['player_games_3x3'] = 0;
    }

    if (!isset($_SESSION['player_games_4x4'])){
        $_SESSION['player_games_4x4'] = 0;
    }

    if (!isset($_SESSION['player_games_5x5'])){
        $_SESSION['player_games_5x5'] = 0;
    }

    if (!isset($_SESSION['machine_x_win_3x3'])){
        $_SESSION['machine_x_win_3x3'] = 0;
    }

    if (!isset($_SESSION['machine_x_win_4x4'])){
        $_SESSION['machine_x_win_4x4'] = 0;
    }

    if (!isset($_SESSION['machine_x_win_5x5'])){
        $_SESSION['machine_x_win_5x5'] = 0;
    }

    if (!isset($_SESSION['machine_o_win_3x3'])){
        $_SESSION['machine_o_win_3x3'] = 0;
    }

    if (!isset($_SESSION['machine_o_win_4x4'])){
        $_SESSION['machine_o_win_4x4'] = 0;
    }

    if (!isset($_SESSION['machine_o_win_5x5'])){
        $_SESSION['machine_o_win_5x5'] = 0;
    }
    
    if (!isset($_SESSION['machine_tie_3x3'])){
        $_SESSION['machine_tie_3x3'] = 0;
    }

    if (!isset($_SESSION['machine_tie_4x4'])){
        $_SESSION['machine_tie_4x4'] = 0;
    }

    if (!isset($_SESSION['machine_tie_5x5'])){
        $_SESSION['machine_tie_5x5'] = 0;
    }

    if (!isset($_SESSION['machine_games_3x3'])){
        $_SESSION['machine_games_3x3'] = 0;
    }

    if (!isset($_SESSION['machine_games_4x4'])){
        $_SESSION['machine_games_4x4'] = 0;
    }

    if (!isset($_SESSION['machine_games_5x5'])){
        $_SESSION['machine_games_5x5'] = 0;
    }
}

function reset_stats()
{
    unset($_SESSION['player_x_win_3x3']);
    unset($_SESSION['player_x_win_4x4']);
    unset($_SESSION['player_x_win_5x5']);
    unset($_SESSION['player_o_win_3x3']);
    unset($_SESSION['player_o_win_4x4']);
    unset($_SESSION['player_o_win_5x5']);
    unset($_SESSION['player_tie_3x3']);
    unset($_SESSION['player_tie_4x4']);
    unset($_SESSION['player_tie_5x5']);
    unset($_SESSION['player_games_3x3']);
    unset($_SESSION['player_games_4x4']);
    unset($_SESSION['player_games_5x5']);
    unset($_SESSION['machine_x_win_3x3']);
    unset($_SESSION['machine_x_win_4x4']);
    unset($_SESSION['machine_x_win_5x5']);
    unset($_SESSION['machine_o_win_3x3']);
    unset($_SESSION['machine_o_win_4x4']);
    unset($_SESSION['machine_o_win_5x5']);
    unset($_SESSION['machine_tie_3x3']);
    unset($_SESSION['machine_tie_4x4']);
    unset($_SESSION['machine_tie_5x5']);
    unset($_SESSION['machine_games_3x3']);
    unset($_SESSION['machine_games_4x4']);
    unset($_SESSION['machine_games_5x5']);
}


function print_stats(){
    $player_x_win_3x3 = $_SESSION['player_x_win_3x3'];
    $player_x_win_4x4 = $_SESSION['player_x_win_4x4'];
    $player_x_win_5x5 = $_SESSION['player_x_win_5x5'];
    $player_o_win_3x3 = $_SESSION['player_o_win_3x3'];
    $player_o_win_4x4 = $_SESSION['player_o_win_4x4'];
    $player_o_win_5x5 = $_SESSION['player_o_win_5x5'];
    $player_tie_3x3 = $_SESSION['player_tie_3x3'];
    $player_tie_4x4 = $_SESSION['player_tie_4x4'];
    $player_tie_5x5 = $_SESSION['player_tie_5x5'];
    $player_games_3x3 = $_SESSION['player_games_3x3'];
    $player_games_4x4 = $_SESSION['player_games_4x4'];
    $player_games_5x5 = $_SESSION['player_games_5x5'];
    $machine_x_win_3x3 = $_SESSION['machine_x_win_3x3'];
    $machine_x_win_4x4 = $_SESSION['machine_x_win_4x4'];
    $machine_x_win_5x5 = $_SESSION['machine_x_win_5x5'];
    $machine_o_win_3x3 = $_SESSION['machine_o_win_3x3'];
    $machine_o_win_4x4 = $_SESSION['machine_o_win_4x4'];
    $machine_o_win_5x5 = $_SESSION['machine_o_win_5x5'];
    $machine_tie_3x3 = $_SESSION['machine_tie_3x3'];
    $machine_tie_4x4 = $_SESSION['machine_tie_4x4'];
    $machine_tie_5x5 = $_SESSION['machine_tie_5x5'];
    $machine_games_3x3 = $_SESSION['machine_games_3x3'];
    $machine_games_4x4 = $_SESSION['machine_games_4x4'];
    $machine_games_5x5 = $_SESSION['machine_games_5x5'];
    
    echo <<<_STATS
<p>Statistics:</p>
<p>
<table class="stats">
    <tr>
        <td>Player vs Player</td>
        <td>3x3</td>
        <td>4x4</td>
        <td>5x5</td>
    </tr>
    <tr>
        <td>X-wins</td>
        <td>$player_x_win_3x3</td>
        <td>$player_x_win_4x4</td>
        <td>$player_x_win_5x5</td>
    </tr>
    <tr>
        <td>O-wins</td>
        <td>$player_o_win_3x3</td>
        <td>$player_o_win_4x4</td>
        <td>$player_o_win_5x5</td>
    </tr>
    <tr>
        <td>Tie</td>
        <td>$player_tie_3x3</td>
        <td>$player_tie_4x4</td>
        <td>$player_tie_5x5</td>
    </tr>
    <tr>
        <td>Games started</td>
        <td>$player_games_3x3</td>
        <td>$player_games_4x4</td>
        <td>$player_games_5x5</td>
    </tr>

</table>
</p>
<p>
<table class="stats">
    <tr>
        <td>Machine vs Player</td>
        <td>3x3</td>
        <td>4x4</td>
        <td>5x5</td>
    </tr>
    <tr>
        <td>Player wins</td>
        <td>$machine_x_win_3x3</td>
        <td>$machine_x_win_4x4</td>
        <td>$machine_x_win_5x5</td>
    </tr>
    <tr>
        <td>Machine wins</td>
        <td>$machine_o_win_3x3</td>
        <td>$machine_o_win_4x4</td>
        <td>$machine_o_win_5x5</td>
    </tr>
    <tr>
        <td>Tie</td>
        <td>$machine_tie_3x3</td>
        <td>$machine_tie_4x4</td>
        <td>$machine_tie_5x5</td>
    </tr>
    <tr>
        <td>Games started</td>
        <td>$machine_games_3x3</td>
        <td>$machine_games_4x4</td>
        <td>$machine_games_5x5</td>
    </tr>

</table>
</p>


_STATS;
}


function machines_move() {
    $temp_board = $_SESSION['board_arr'];
    $temp_board_size = $_SESSION['board_size'];
    $move_limit = $temp_board_size * $temp_board_size;
    $move_candidate_is_ok = false;
    
    while (!$move_candidate_is_ok){
        $move_cand = rand(1, $move_limit);
        if (!isset($temp_board[$move_cand])) {
            $move_candidate_is_ok = true;
        }
    }
    return $move_cand;
}


function if_play_again_pressed() {
    if (isset($_POST['play_again'])) {
        // echo "Play Again pressed !!!";
        $board_arr = array();
        $_SESSION['board_arr'] = $board_arr;
        $whos_move = random_start();
        $_SESSION['mover'] = $whos_move;
        $_SESSION['moves_done'] = 0;
        $_SESSION['move_result'] = "";
    }
}

function if_restart_pressed() {
    if (isset($_POST['restart'])) {
        //echo "<hr>              RESTART pressed !!!                <hr>";
        $board_arr = array();
        $_SESSION['board_arr'] = $board_arr;
        $whos_move = random_start();
        $_SESSION['mover'] = $whos_move;
        $_SESSION['moves_done'] = 0;
        $_SESSION['move_result'] = "";
    }
}


function print_tic_tac_toe_header_colored() {
    echo "<h1><span style=\"color:green;\">Tic</span> <span style=\"color:red;\">Tac</span> <span style=\"color:blue;\">Toe</span></h1>";
    hr();
}

function print_html_header() {
    echo <<<_HTML_HEADER
<!doctype html> 
<html>
    <head>
        <title>Tic Tac Toe Game</title>
        <style>
            html {
                width: 500px;
                margin: 0px auto;
                border: 5px green dashed;
				border-radius: 10px;
                border-margin: 0px;
                padding: 0px;
                margin-top: 5px;
			}
			div#wraper {
                margin: 0px auto;
				border: 5px red dashed;
				text-align: center;
				border-radius: 10px;
                border-margin: 0px; 
                padding: 0px;
			}
            div#game_board {
                display: block;
                margin: 0px auto;
				text-align: center;
                padding: 0px;
			}
            form {
                display: inline-block;
            }
            form tr td {
                text-align: center;
                height: 50px;
                width:  50px;
                font-size: 28px;
                border: solid green 1px;
            }
            form tr td input[type=submit]{
                border: none; /*rewriting standard style, it is necessary to be able to change the size*/
                height: 50px;
                width:  50px;
                text-align: center;
                font-size: 8px;
            }
            .winning_number {
                font-size: 32px;
                color: red;
                text-decoration: underline dashed green;
                border: solid blue 2px;
            }
            table.stats {
                display: inline-block;
            }
            table.stats tr td {
                text-align: center;
                font-size: 12px;
                width: 50px;
                border: solid blue 1px;                
            }
            table.stats tr td:first-of-type {
                width: 150px;
            }
            form#settings input[type=submit]{
                border: none;
                height: 40px;
                width:  120px;
                color: red;
                background-color: #C8DCFD; <!--- #3FBF7F; -->
                text-align: center;
                font-size: 16px;
                border: solid green 2px;
                border-radius: 7px;
            }
            
        </style>
    </head>
    <body>
       <div ID="wraper">
     
_HTML_HEADER;

}

function print_html_footer() {
    echo <<<_HTML_FOOTER
        </div>
    </body>  
</html>

_HTML_FOOTER;

}

function check_if_win(){
    if ($_SESSION['board_size'] == 3){
        $cand = $_SESSION['mover'];
        $temp_board = $_SESSION['board_arr'];
        if (        (isset($temp_board[1]) && $temp_board[1] == $cand && isset($temp_board[2]) && $temp_board[2] == $cand && isset($temp_board[3]) && $temp_board[3] == $cand)      ||
                    (isset($temp_board[4]) && $temp_board[4] == $cand && isset($temp_board[5]) && $temp_board[5] == $cand && isset($temp_board[6]) && $temp_board[6] == $cand)      ||
                    (isset($temp_board[7]) && $temp_board[7] == $cand && isset($temp_board[8]) && $temp_board[8] == $cand && isset($temp_board[9]) && $temp_board[9] == $cand)   
                                                                                                                                                                                    ||
                    (isset($temp_board[1]) && $temp_board[1] == $cand && isset($temp_board[4]) && $temp_board[4] == $cand && isset($temp_board[7]) && $temp_board[7] == $cand)      ||
                    (isset($temp_board[2]) && $temp_board[2] == $cand && isset($temp_board[5]) && $temp_board[5] == $cand && isset($temp_board[8]) && $temp_board[8] == $cand)      ||
                    (isset($temp_board[3]) && $temp_board[3] == $cand && isset($temp_board[6]) && $temp_board[6] == $cand && isset($temp_board[9]) && $temp_board[9] == $cand)
                                                                                                                                                                                    ||
                    (isset($temp_board[1]) && $temp_board[1] == $cand && isset($temp_board[5]) && $temp_board[5] == $cand && isset($temp_board[9]) && $temp_board[9] == $cand)      ||
                    (isset($temp_board[3]) && $temp_board[3] == $cand && isset($temp_board[5]) && $temp_board[5] == $cand && isset($temp_board[7]) && $temp_board[7] == $cand)
           ){
            
            return true;
        }
        
    }
    
    elseif ($_SESSION['board_size'] == 4){
        $cand = $_SESSION['mover'];
        $temp_board = $_SESSION['board_arr'];
        if (        (isset($temp_board[1]) && $temp_board[1] == $cand && isset($temp_board[2]) && $temp_board[2] == $cand && isset($temp_board[3]) && $temp_board[3] == $cand && isset($temp_board[4]) && $temp_board[4] == $cand)          ||
                    (isset($temp_board[5]) && $temp_board[5] == $cand && isset($temp_board[6]) && $temp_board[6] == $cand && isset($temp_board[7]) && $temp_board[7] == $cand && isset($temp_board[8]) && $temp_board[8] == $cand)          ||
                    (isset($temp_board[9]) && $temp_board[9] == $cand && isset($temp_board[10]) && $temp_board[10] == $cand && isset($temp_board[11]) && $temp_board[11] == $cand && isset($temp_board[12]) && $temp_board[12] == $cand)    ||
                    (isset($temp_board[13]) && $temp_board[13] == $cand && isset($temp_board[14]) && $temp_board[14] == $cand && isset($temp_board[15]) && $temp_board[15] == $cand && isset($temp_board[16]) && $temp_board[16] == $cand)  
                                                                                                                                                                                                                                            ||
                    (isset($temp_board[1]) && $temp_board[1] == $cand && isset($temp_board[5]) && $temp_board[5] == $cand && isset($temp_board[9]) && $temp_board[9] == $cand && isset($temp_board[13]) && $temp_board[13] == $cand)        ||
                    (isset($temp_board[2]) && $temp_board[2] == $cand && isset($temp_board[6]) && $temp_board[6] == $cand && isset($temp_board[10]) && $temp_board[10] == $cand && isset($temp_board[14]) && $temp_board[14] == $cand)      ||
                    (isset($temp_board[3]) && $temp_board[3] == $cand && isset($temp_board[7]) && $temp_board[7] == $cand && isset($temp_board[11]) && $temp_board[11] == $cand && isset($temp_board[15]) && $temp_board[15] == $cand)      ||
                    (isset($temp_board[4]) && $temp_board[4] == $cand && isset($temp_board[8]) && $temp_board[8] == $cand && isset($temp_board[12]) && $temp_board[12] == $cand && isset($temp_board[16]) && $temp_board[16] == $cand)  
                                                                                                                                                                                                                                            ||
                    (isset($temp_board[1]) && $temp_board[1] == $cand && isset($temp_board[6]) && $temp_board[6] == $cand && isset($temp_board[11]) && $temp_board[11] == $cand && isset($temp_board[16]) && $temp_board[16] == $cand)      ||
                    (isset($temp_board[4]) && $temp_board[4] == $cand && isset($temp_board[7]) && $temp_board[7] == $cand && isset($temp_board[10]) && $temp_board[10] == $cand && isset($temp_board[13]) && $temp_board[13] == $cand) 
           ){
            
            return true;
        }
        
    }
    
    elseif ($_SESSION['board_size'] == 5){
        $cand = $_SESSION['mover'];
        $temp_board = $_SESSION['board_arr'];
        if (    (isset($temp_board[1]) && $temp_board[1] == $cand && isset($temp_board[2]) && $temp_board[2] == $cand && isset($temp_board[3]) && $temp_board[3] == $cand && isset($temp_board[4]) && $temp_board[4] == $cand && isset($temp_board[5]) && $temp_board[5] == $cand)                  ||
                (isset($temp_board[6]) && $temp_board[6] == $cand && isset($temp_board[7]) && $temp_board[7] == $cand && isset($temp_board[8]) && $temp_board[8] == $cand && isset($temp_board[9]) && $temp_board[9] == $cand && isset($temp_board[10]) && $temp_board[10] == $cand)                ||  
                (isset($temp_board[11]) && $temp_board[11] == $cand && isset($temp_board[12]) && $temp_board[12] == $cand && isset($temp_board[13]) && $temp_board[13] == $cand && isset($temp_board[14]) && $temp_board[14] == $cand && isset($temp_board[15]) && $temp_board[15] == $cand)        ||
                (isset($temp_board[16]) && $temp_board[16] == $cand && isset($temp_board[17]) && $temp_board[17] == $cand && isset($temp_board[18]) && $temp_board[18] == $cand && isset($temp_board[19]) && $temp_board[19] == $cand && isset($temp_board[20]) && $temp_board[20] == $cand)        ||  
                (isset($temp_board[21]) && $temp_board[21] == $cand && isset($temp_board[22]) && $temp_board[22] == $cand && isset($temp_board[23]) && $temp_board[23] == $cand && isset($temp_board[24]) && $temp_board[24] == $cand && isset($temp_board[25]) && $temp_board[25] == $cand)        ||
                
                (isset($temp_board[1]) && $temp_board[1] == $cand && isset($temp_board[6]) && $temp_board[6] == $cand && isset($temp_board[11]) && $temp_board[11] == $cand && isset($temp_board[16]) && $temp_board[16] == $cand && isset($temp_board[21]) && $temp_board[21] == $cand)            ||
                (isset($temp_board[2]) && $temp_board[2] == $cand && isset($temp_board[7]) && $temp_board[7] == $cand && isset($temp_board[12]) && $temp_board[12] == $cand && isset($temp_board[17]) && $temp_board[17] == $cand && isset($temp_board[22]) && $temp_board[22] == $cand)            ||
                (isset($temp_board[3]) && $temp_board[3] == $cand && isset($temp_board[8]) && $temp_board[8] == $cand && isset($temp_board[13]) && $temp_board[13] == $cand && isset($temp_board[18]) && $temp_board[18] == $cand && isset($temp_board[23]) && $temp_board[23] == $cand)            ||
                (isset($temp_board[4]) && $temp_board[4] == $cand && isset($temp_board[9]) && $temp_board[9] == $cand && isset($temp_board[14]) && $temp_board[14] == $cand && isset($temp_board[19]) && $temp_board[19] == $cand && isset($temp_board[24]) && $temp_board[24] == $cand)            ||
                (isset($temp_board[5]) && $temp_board[5] == $cand && isset($temp_board[10]) && $temp_board[10] == $cand && isset($temp_board[15]) && $temp_board[15] == $cand && isset($temp_board[20]) && $temp_board[20] == $cand && isset($temp_board[25]) && $temp_board[25] == $cand)          ||
            
                (isset($temp_board[5]) && $temp_board[5] == $cand && isset($temp_board[9]) && $temp_board[9] == $cand && isset($temp_board[13]) && $temp_board[13] == $cand && isset($temp_board[17]) && $temp_board[17] == $cand && isset($temp_board[21]) && $temp_board[21] == $cand)            ||
                (isset($temp_board[1]) && $temp_board[1] == $cand && isset($temp_board[7]) && $temp_board[7] == $cand && isset($temp_board[13]) && $temp_board[13] == $cand && isset($temp_board[19]) && $temp_board[19] == $cand && isset($temp_board[25]) && $temp_board[25] == $cand)       
            
           ){
            
            return true;
        }
        
    }
    
    return false;
}

function win_set(){
    $cand       = $_SESSION['mover'];
    $temp_board = $_SESSION['board_arr'];
    
    if ($_SESSION['board_size'] == 3){
        $win_3_sets =   array (
                            array (1,2,3),
                            array (4,5,6),
                            array (7,8,9),
                            array (1,4,7),
                            array (2,5,8),
                            array (3,6,9),
                            array (1,5,9),
                            array (3,5,7)
                        );
        for ($i=0; $i<8; $i++) {
            if (isset($temp_board[$win_3_sets[$i][0]]) && $temp_board[$win_3_sets[$i][0]] == $cand && isset($temp_board[$win_3_sets[$i][1]]) && $temp_board[$win_3_sets[$i][1]] == $cand && isset($temp_board[$win_3_sets[$i][2]]) && $temp_board[$win_3_sets[$i][2]] == $cand) {
                $winning_set = array ($win_3_sets[$i][0], $win_3_sets[$i][1], $win_3_sets[$i][2]);
                return $winning_set;
            }
        }
    }
    
    elseif ($_SESSION['board_size'] == 4){
        $win_4_sets =   array (
                            array (1,2,3,4),
                            array (5,6,7,8),
                            array (9,10,11,12),
                            array (13,14,15,16),
                            array (1,5,9,13),
                            array (2,6,10,14),
                            array (3,7,11,15),
                            array (4,8,12,16),
                            array (1,6,11,16),
                            array (4,7,10,13)
                        );
        for ($i=0; $i<10; $i++) {
            if (isset($temp_board[$win_4_sets[$i][0]]) && $temp_board[$win_4_sets[$i][0]] == $cand && isset($temp_board[$win_4_sets[$i][1]]) && $temp_board[$win_4_sets[$i][1]] == $cand && isset($temp_board[$win_4_sets[$i][2]]) && $temp_board[$win_4_sets[$i][2]] == $cand && isset($temp_board[$win_4_sets[$i][3]]) && $temp_board[$win_4_sets[$i][3]] == $cand) {
                $winning_set = array ($win_4_sets[$i][0], $win_4_sets[$i][1], $win_4_sets[$i][2], $win_4_sets[$i][3]);
                return $winning_set;
            }
        }        
    }
    
    elseif ($_SESSION['board_size'] == 5){
        $win_5_sets =   array (
                            array ( 1, 2, 3, 4, 5),
                            array ( 6, 7, 8, 9,10),
                            array (11,12,13,14,15),
                            array (16,17,18,19,20),
                            array (21,22,23,24,25),
                            array ( 1, 6,11,16,21),
                            array ( 2, 7,12,17,22),
                            array ( 3, 8,13,18,23),
                            array ( 4, 9,14,19,24),
                            array ( 5,10,15,20,25),
                            array ( 1, 7,13,19,25),
                            array ( 5, 9,13,17,21)
                        );
        for ($i=0; $i<12; $i++) {
            if (isset($temp_board[$win_5_sets[$i][0]]) && $temp_board[$win_5_sets[$i][0]] == $cand && isset($temp_board[$win_5_sets[$i][1]]) && $temp_board[$win_5_sets[$i][1]] == $cand && isset($temp_board[$win_5_sets[$i][2]]) && $temp_board[$win_5_sets[$i][2]] == $cand && isset($temp_board[$win_5_sets[$i][3]]) && $temp_board[$win_5_sets[$i][3]] == $cand && isset($temp_board[$win_5_sets[$i][4]]) && $temp_board[$win_5_sets[$i][4]] == $cand) {
                $winning_set = array ($win_5_sets[$i][0], $win_5_sets[$i][1], $win_5_sets[$i][2], $win_5_sets[$i][3], $win_5_sets[$i][4]);
                return $winning_set;
            }
        }        
    }        
    return false;
}


function switch_mover() {
    if ($_SESSION['mover'] == "X"){
        $_SESSION['mover'] = "O";
    } else {
        $_SESSION['mover'] = "X";
    }
}

function random_start(){
    $rnd = rand(1,2);
        if ($rnd == 1) {
            return "X";
        } elseif ($rnd == 2) {
            return "O";
        } else {
            return "Error: Invalid random value";
        }
    
}


function clear_session_vars(){
    $_SESSION = array();
}

function draw_play_again_button(){
    echo <<<_PLAY_AGAIN_BUTTON
        <form method="post" action="">
            <input type="submit" name="play_again" value="Play again">
        </form>

_PLAY_AGAIN_BUTTON;

}

function draw_restart_button(){
    echo <<<_RESTART_BUTTON
        <form method="post" action="">
            <input type="submit" name="restart" value="Restart">
        </form>

_RESTART_BUTTON;

}

function draw_change_settings_button(){
    echo <<<_CHANGE_SETTINGS_BUTTON
        <form method="post" action="settings.php">
            <input type="submit" name="change_settings" value="Change Settings">
        </form>

_CHANGE_SETTINGS_BUTTON;

}

function draw_win_board(){
    $winning_numbers = win_set();
    $win_set_len = count($winning_numbers);
    $size = $_SESSION['board_size'];
    $temp_board = $_SESSION['board_arr'];
    echo "<div id=\"game_board\">";
    echo "<form>";
        echo "<table>";
        for ($row=0; $row<$size; $row++){
            echo "<tr>";
            for ($col=1;$col<=$size; $col++ ){
                $value = $row * $size + $col;
                // $name = "number".$value;
                $to_be_marked = false;
                if (!empty($temp_board[$value])) {
                    $sign = $temp_board[$value];
                    for ($i = 0; $i<$win_set_len; $i++) {
                        if ($value == $winning_numbers[$i]) {
                            $to_be_marked = true;
                            // echo "<td class=\"winning_number\">$sign</td>";
                        } 
                    }
                    if ($to_be_marked) {
                        echo "<td class=\"winning_number\">$sign</td>";
                    } else {
                        echo "<td>$sign</td>";
                    }
                    //echo "<td>$sign</td>";
                } else {
                    echo "<td>-</td>";
                }
            }
            echo "</tr>";
        }
    
        echo "</table>";
    echo "</form>";
    echo "</div>";
}

function draw_board(){
    $size = $_SESSION['board_size'];
    $temp_board = $_SESSION['board_arr'];
    echo "<div id=\"game_board\">";
    echo "<form method=\"post\" action=\"play.php\">";
        echo "<table>";
        for ($row=0; $row<$size; $row++){
            echo "<tr>";
            for ($col=1;$col<=$size; $col++ ){
                $value = $row * $size + $col;
                $name = "number".$value;
                
                if (!empty($temp_board[$value])) {
                    $sign = $temp_board[$value];
                    echo "<td>$sign</td>";
                } else {
                    echo "<td><input type=\"submit\" name=\"$name\" value=\"$value\" ></td>";
                }
            }
            echo "</tr>";
        }
    
        echo "</table>";
    echo "</form>";
    echo "</div>";
}

function save_settings(){
    if (isset($_POST['play_mode']) && isset($_POST['board_size']) && isset($_POST['difficulty'])){
    $_SESSION['opponent']   = $_POST['play_mode'];
    $_SESSION['board_size'] = $_POST['board_size'];
    $_SESSION['difficulty'] = $_POST['difficulty'];
    } 
//    hr();
//    print_r($_SESSION);
//    hr();
}

function trace_settings(){
    hr();
    if (isset($_SESSION['opponent']) && isset($_SESSION['board_size']) && isset($_SESSION['difficulty'])){
        $opponent   = $_SESSION['opponent'];
        $board_size = $_SESSION['board_size'];
        $difficulty = $_SESSION['difficulty'];
        echo "Settings tracking ... Playing with: $opponent. Board: $board_size. Difficulty: $difficulty.";
    } else {
        echo "Settings not submitted yet.";
    }
    hr();
    print_r($_SESSION);
    hr();
}

function hr(){
    echo "<hr>";
}

function br(){
    echo "<br>";
}
?>