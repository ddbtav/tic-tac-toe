<?php
session_start();
include_once "functions.php";

if (isset($_SESSION['user'])) {
    echo "You are logged in as: " . $_SESSION['user'] . ".";


init_stats();

print_html_header();
draw_logout_button();

$board_arr = array();

$_SESSION['board_arr'] = $board_arr;

$whos_move = random_start();

$_SESSION['mover'] = $whos_move;
$_SESSION['moves_done'] = 0;
$_SESSION['move_result'] = "";

print_tic_tac_toe_header_colored();
echo "<h2>Settings</h2>";
hr();

echo <<<_SETTINGS_TABLE
    <form method="post" action="play.php" id="settings">
        <p>Play vs</p>
        <label>Player <input type="radio" name="play_mode" value="player" checked></label>
        <label>Machine <input type="radio" name="play_mode" value="machine"></label>
        <p>Board size</p>
        <label>3x3 <input type="radio" name="board_size" value="3" checked></label>
        <label>4x4 <input type="radio" name="board_size" value="4"></label>
        <label>5x5 <input type="radio" name="board_size" value="5"></label>
        <p>Difficulty</p>
        <label>Easy <input type="radio" name="difficulty" value="easy" checked></label>
        <label>Normal <input type="radio" name="difficulty" value="normal"></label>
        <label>Hard <input type="radio" name="difficulty" value="hard"></label>
        <p><input type="submit" value="Start game">
    </form>
_SETTINGS_TABLE;

print_stats();
print_html_footer();

} else {
    header ("Location: index.php?loginerror=notloggedin");
    exit();
}
    
?>