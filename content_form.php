<?php
/*
    content_form.php
    Daniel Shupe
    CSIS 410
*/
    require 'header.php';
    display_header("Orange Ninja Productions - Content Management","This is the home page for the Orange Ninja Productions website","candelas.css");
?>
<?php
    require 'footer.php';
    require 'menu.php';
    require 'variables.php';
    display_menu($site_nav, $dropdown_nav, "menu");
?>
<div class="manage">
<?php
    //  this function creates a list of the content types available for a dropdown
    function display_content_types() {
        require_once 'database_handler.php';
        $sql = "SELECT * FROM content_types";
            $result = $connection->query($sql);
            if (!$result) {
                trigger_error('Invalid query: ' . $connection->error);
            }
            echo '<div><label>Type: </label>';
            echo '<select name="content_type_id">';
            while ($row = $result->fetch_assoc()) {
                echo '<option value="'.$row['content_type_id'].'" ';
                if (isset($_SESSION['content_type_id'])) {
                    if ($_SESSION['content_type_id'] == $row['content_type_id']) {
                        echo 'selected';
                    }
                }
                echo '>'.$row['name'].'</option>';
            }
            echo '</select></div>';
    }
    //  only display form if user is logged in as a publisher or admin
    if ($_SESSION['logged_in'] && ($_SESSION['access'] == "Publisher" || $_SESSION['access'] == "Admin")) {
        echo '<h1>Content Management</h1>';
        //  forms for editing existing records
        if (isset($_SESSION['manage_type'])) {
            if ($_SESSION['manage_type'] == 'edit') {
                //  edit news record
                if ($_SESSION['table'] == "news") {
                    echo '<div class="manage"><form action="content_manage.php" method="post">';
                    echo '<div><label>Title: </label>';
                    echo '<input type="text" name="title" value="'.$_SESSION['title'].'" /></div>';
                    echo '<input type="hidden" name="record" value="'.$_SESSION['record'].'" />';
                    echo '<input type="hidden" name="table" value="'.$_SESSION['table'].'" />';
                    echo '<div><label>Post: </label></div>';    
                    echo '<textarea name="post" rows="16" cols="64">'.$_SESSION['post'].'</textarea>';
                    echo '<div><input type="submit" name="update" value="Update" /></div>'; 
                    echo '</form></div>';
                }
                //  edit product record
                else if ($_SESSION['table'] == "products") {
                    //  check for product errors
                    if (isset($_GET['error'])) {
                        product_errors($_GET);
                    }
                    //  display product form
                    echo '<div class="manage"><form action="content_manage.php" method="post">';
                    echo '<input type="hidden" name="record" value="'.$_SESSION['record'].'" />';
                    echo '<input type="hidden" name="table" value="'.$_SESSION['table'].'" />';
                    echo '<table><tr><td><label>Name: </label></td>';
                    echo '<td><input type="text" name="name" value="'.$_SESSION['name'].'" /></td></tr>';
                    echo '<tr><td><label>Image File: </label></td>';
                    echo '<td><input type="text" name="image" value="'.$_SESSION['image'].'" /></td></tr>';
                    echo '<tr><td><label>Price: </label></td>';
                    echo '<td><input type="text" name="price" value="'.$_SESSION['price'].'" /></td></tr></table>';
                    echo '<div><label>Short Description: </label></div>';    
                    echo '<textarea name="short_description" rows="4" cols="64">'.$_SESSION['short_description'].'</textarea>';
                    echo '<div><label>Long Description: </label></div>';
                    echo '<textarea name="long_description" rows="16" cols="64">'.$_SESSION['long_description'].'</textarea>';
                    display_content_types();
                    echo '<div><input type="submit" name="update" value="Update" /></div>'; 
                    echo '</form></div>';
                }
                //  edit account -can only change access level
                else if ($_SESSION['table'] == "accounts") {
                    echo '<div class="manage"><form action="user_manage.php" method="post">';
                    echo '<input type="hidden" name="record" value="'.$_SESSION['record'].'" />';
                    echo '<div><label>Access Level for Account: '.$_SESSION['user_edit'].'</label></div>';
                    require_once 'access_selector.php';
                    get_access();
                    echo '<div><input type="submit" name="update" value="Update" /></div>';
                    echo '</form></div>';
                }
            }
            //  forms for new record
            else if ($_SESSION['manage_type'] == 'new') {
                //  new record for news table
                if ($_SESSION['table'] == "news") {
                    echo '<div class="manage"><form action="content_manage.php" method="post">';
                    echo '<div><label>Title: </label>';
                    echo '<input type="text" name="title" /></div>';
                    echo '<input type="hidden" name="table" value="'.$_SESSION['table'].'" />';
                    echo '<div><label>Post: </label></div>';    
                    echo '<textarea name="post" rows="16" cols="64"></textarea>';
                    echo '<div><input type="submit" name="add" value="Add News Post" /></div>'; 
                    echo '</form></div>';
                }
                //  form for new product
                else if ($_SESSION['table'] == "products") {
                    //  handle errors
                    if (isset($_GET['error'])) {
                        product_errors($_GET);
                    }
                    echo '<div class="manage"><form action="content_manage.php" method="post">';
                    echo '<input type="hidden" name="table" value="'.$_SESSION['table'].'" />';
                    echo '<table><tr><td><label>Name: </label></td>';
                    echo '<td><input type="text" name="name"';
                    if (isset($_GET['name'])) {
                        echo ' value="'.$_GET['name'].'"';
                    }
                    echo ' /></td></tr>';
                    echo '<tr><td><label>Image File: </label></td>';
                    echo '<td><input type="text" name="image"';
                    if (isset($_GET['image'])) {
                        echo ' value="'.$_GET['image'].'"';
                    }
                    echo ' /></td></tr>';
                    echo '<tr><td><label>Price: </label></td>';
                    echo '<td><input type="text" name="price"';
                    if (isset($_GET['price'])) {
                        echo ' value="'.$_GET['price'].'"';
                    }
                    echo ' /></td></tr></table>';
                    echo '<div><label>Short Description: </label></div>';    
                    echo '<textarea name="short_description" rows="4" cols="64">';
                    if (isset($_GET['sd'])) {
                        echo $_GET['sd'];
                    }
                    echo '</textarea>';
                    echo '<div><label>Long Description: </label></div>';
                    echo '<textarea name="long_description" rows="16" cols="64">';
                    if (isset($_GET['ld'])) {
                        echo $_GET['ld'];
                    }
                    echo '</textarea>';
                    display_content_types();
                    echo '<div><input type="submit" name="add" value="Add Product" /></div>'; 
                    echo '</form></div>';
                }
            }
            //  form to handle deleting records
            else if ($_SESSION['manage_type'] == 'delete') {
                echo '<div class="manage"><form action="content_manage.php" method="post">';
                echo '<h2>Are you sure you wish to delete this record?</h2>';
                echo '<input type="hidden" name="table" value="'.$_SESSION['table'].'" />';
                echo '<input type="hidden" name="record" value="'.$_SESSION['record'].'" />';
                echo '<div><input type="submit" name="remove" value="Yes" />';
                echo '<input type="submit" name="no" value="No" /></div>';
                echo '</form></div>';
            }
        }
    }
    //  function to display errors in product form
    function product_errors($error) {
        if ($error['error'] == "invalidname") {
            echo '<h2>Name must be a string between 1 and 255 characters long.</h2>';
        }
        else if ($error['error'] == "invalidimage") {
            echo '<h2>Invalid image filename (must be gif, jpg, webm, or png)</h2>';
        }
        else if ($error['error'] == "invalidprice") {
            echo '<h2>Price must be a non-negative number.</h2>';
        }
        else if ($error['error'] == "invalidsd") {
            echo '<h2>Short description must be a string between 1 and 255 characters long.</h2>';
        }
        else if ($error['error'] == "invalidld") {
            echo '<h2>Long description must be a string between 1 and 65535 characters long.</h2>';
        }
    }
?>
</div>
<div class="footer">
<?php
    display_footer("content_form.php");
?>
</div>
</body>
</html>