<?php
function get_access() {
    require_once 'database_handler.php';
    $sql = "SELECT * FROM access_levels";
    $result = $connection->query($sql);
    if (!$result) {
        trigger_error('Invalid query: ' . $connection->error);
    }
    if ($result->num_rows > 0) {
        echo '<SELECT name="access_level_id">';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['access_level_id'].'"'; 
            if (isset($_SESSION['selected_access'])) {
                if ($_SESSION['selected_access'] == $row['access_level_id']) {
                    echo 'selected';
                }
            }
            echo '>'.$row['description'].'</option>';
        }
        echo '</select>';
    }
}