<?php
session_start();
include_once "functions.php";

if (isset($_SESSION['user'])) {
    echo "You are logged in as: " . $_SESSION['user'] . ".";

print_html_header();
draw_logout_button();
print_tic_tac_toe_header_colored();

$message = "";
save_settings();

if_play_again_pressed();
if_restart_pressed();

$total_positions = $_SESSION['board_size'] * $_SESSION['board_size'];

$temp = $_SESSION['board_arr'];
$board_arr = $temp;
$temp_player_sign = $_SESSION['mover'];
$message = "Next move by: " . $temp_player_sign . ".";

if ($_SESSION['opponent'] == "machine") {
    echo "MACHINE MODE!!!<hr>";

    if ($temp_player_sign == "O" && $_SESSION['moves_done'] == 0) {

        $machines_move = machines_move();

        ++$_SESSION['moves_done'];
        $board_arr[$machines_move] = $temp_player_sign;
        $_SESSION['board_arr'] = $board_arr;

            switch_mover();
            $temp_player_sign = $_SESSION['mover'];
            $message = "Next move by: " . $temp_player_sign . ".";
            $_SESSION['move_result'] = "proceed";

    } else {

        for ($i = 1; $i <= $total_positions; $i ++) {
            $name = "number" . $i;
            if (isset($_POST[$name])) {
                ++ $_SESSION['moves_done'];
                $board_arr[$i] = $temp_player_sign;
                $_SESSION['board_arr'] = $board_arr;
                if (check_if_win()) {
                    $message = $_SESSION['mover'] . " WINS!";
                    $_SESSION['move_result'] = "win";
                    break;
                } elseif ($_SESSION['moves_done'] == $total_positions) {
                    $message = "It is a tie!";
                    $_SESSION['move_result'] = "tie";
                } else {
                    switch_mover();
                    $temp_player_sign = $_SESSION['mover'];
                    $message = "Next move by: " . $temp_player_sign . ".";
                    $_SESSION['move_result'] = "proceed";
                }
            }
        }
         
        if ($_SESSION['move_result'] == "proceed"){
            
            $machines_move = machines_move();

            ++ $_SESSION['moves_done'];
            $board_arr[$machines_move] = $temp_player_sign;
            $_SESSION['board_arr'] = $board_arr;

            if (check_if_win()) {
                $message = $_SESSION['mover'] . " WINS!";
                $_SESSION['move_result'] = "win";
            } elseif ($_SESSION['moves_done'] == $total_positions) {
                $message = "It is a tie!";
                $_SESSION['move_result'] = "tie";
            } else {
                switch_mover();
                $temp_player_sign = $_SESSION['mover'];
                $message = "Next move by: " . $temp_player_sign . ".";
                $_SESSION['move_result'] = "proceed";
            }
        }
            
            
     
        
    }
} else {

    for ($i = 1; $i <= $total_positions; $i ++) {
        $name = "number" . $i;
        if (isset($_POST[$name])) {
            ++ $_SESSION['moves_done'];
            $board_arr[$i] = $temp_player_sign;
            $_SESSION['board_arr'] = $board_arr; // new
            if (check_if_win()) {
                $message = $_SESSION['mover'] . " WINS!";
                $_SESSION['move_result'] = "win";
                break;
            } elseif ($_SESSION['moves_done'] == $total_positions) {
                $message = "It is a tie!";
                $_SESSION['move_result'] = "tie";
            } else {
                switch_mover();
                $temp_player_sign = $_SESSION['mover'];
                $message = "Next move by: " . $temp_player_sign . ".";
                $_SESSION['move_result'] = "proceed";
            }
        }
    }
}


// save stats - games started
if ($_SESSION['opponent']=="player" && $_SESSION['moves_done']==1) {
    if ($_SESSION['board_size'] == 3) {
        ++$_SESSION['player_games_3x3'];
    } elseif ($_SESSION['board_size'] == 4) {
        ++$_SESSION['player_games_4x4'];
    } elseif ($_SESSION['board_size'] == 5) {
        ++$_SESSION['player_games_5x5'];
    } else {
        echo "This should not happen";
    }
} elseif ($_SESSION['opponent']=="machine" && ($_SESSION['moves_done']==1 || $_SESSION['moves_done']==2)) {
    if ($_SESSION['board_size'] == 3) {
        ++$_SESSION['machine_games_3x3'];
    } elseif ($_SESSION['board_size'] == 4) {
        ++$_SESSION['machine_games_4x4'];
    } elseif ($_SESSION['board_size'] == 5) {
        ++$_SESSION['machine_games_5x5'];
    } else {
        echo "This should not happen";
    }
} 
    
    

echo "<p>$message</p>";

switch ($_SESSION['move_result']) {
    case "win":
        echo "case win";
        ++$_SESSION[return_win_stats_string()];
        draw_win_board();
        br();
        draw_play_again_button();
        draw_change_settings_button();
        break;

    case "tie":
        echo "case tie";
        ++$_SESSION[return_tie_stats_string()];
        draw_board();
        br();
        draw_play_again_button();
        draw_change_settings_button();
        break;

    case "proceed":
        echo "case proceed";
        draw_board();
        br();
        draw_restart_button();
        draw_change_settings_button();
        break;

    case "":
        echo "no moves done yet";
        draw_board();
        br();
        draw_change_settings_button();
        break;

    default:
        echo "Error: this should not happen!";
}


print_stats();
// trace_settings();
print_html_footer();

} else {
    header ("Location: index.php?loginerror=notloggedin");
    exit();
    
}
?>