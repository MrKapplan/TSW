<?php
$mysqli = new mysqli("localhost", $_POST["user"], $_POST["password"]);
if ($mysqli->connect_errno) {
    echo "ERROR CONNECTING TO MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    $sql_query = '';
    $script = file('TSW_Database.sql');
    foreach ($script as $line) {
        if (substr($line, 0, 2) === '--' || $line === '') {
            continue;
        } else {
            $sql_query .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                $mysqli->query($sql_query) or die($mysqli->error);
                $sql_query = '';
            }
        }
    }
    $mysqli->close();
    ?>
    <p></br></br>----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----</p>
    <p>----- ----- ----- ----- ----- ----- ----- SUCCESSFUL INSTALLATION ----- ----- ----- ----- ----- ----- </p>
    <p>----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----</p>
    <?php
}
?>
