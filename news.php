<?php
/*
    news.php
    Daniel Shupe
    CSIS 410
    This file pulls news updates from the news table of the database and displays them to the user.
*/
    require 'header.php';
    display_header("Orange Ninja Productions - News","This is the News page for the Orange Ninja Productions website","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>  
<?php
    //  retrieve news entries from database
    require 'database_handler.php';
    $sql = "SELECT news_id, post_title, post_content, post_date, accounts.first_name, accounts.last_name FROM 
    news INNER JOIN accounts ON news.account_id = accounts.account_id ORDER BY post_date DESC";
    $result = $connection->query($sql);
    if (!$result) {
        trigger_error('Invalid query: ' . $connection->error);
    }
    if ($result->num_rows > 0) {
        print "<div class=\"article\">";
            while ($row = $result->fetch_assoc()) {
                print "{$row['post_title']}<br />by " . $row['first_name'] . " " . $row['last_name'] . " on " . $row['post_date'] . " <br />";
                print "<p>" . $row['post_content'] . "</p>";
                if ($_SESSION['access'] == "Publisher" || $_SESSION['access'] == "Admin") {
                    echo '<div class="manage"><form action="content_manage.php" method="post">';
                    echo '<input type="hidden" name="record" value="'.$row['news_id'].'" />';
                    echo '<input type="hidden" name="table" value="news" />';
                    echo '<input type="hidden" name="title" value="'.$row['post_title'].'" />';
                    echo '<input type="hidden" name="post" value="'.$row['post_content'].'" />';
                    echo '<input type="submit" name="edit'.$row['news_id'].'" value="Edit" />';
                    if ($_SESSION['access'] == "Admin") {
                        echo '<input type="hidden" name="record" value="'.$row['news_id'].'" />';
                        echo '<input type="hidden" name="table" value="news" />';                    
                        echo '<input type="submit" name="delete'.$row['news_id'].'" value="Delete" />';
                    }
                    echo '</form></div>';    
                }
                echo '<hr />';
            }
        //}
        $connection->close();
        if (isset($_SESSION['access'])) {
            if ($_SESSION['access'] == "Publisher" || $_SESSION['access'] == "Admin") {
                echo '<div class="manage"><form action="content_manage.php" method="post">';
                echo '<input type="hidden" name="table" value="news" />';
                echo '<input type="submit" name="new" value="New" />';
                echo '</form></div>';    
            }
        }
        print "</div>";
    }
?>
<div class="footer">
<?php
    display_footer("news.php");
?>
</div>
</body>
</html>