<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == "POST" && ($_SESSION['access'] == "Publisher" || $_SESSION['access'] == "Admin")) {
        $edit_str = 'edit'.$_POST['record'];
        if (isset($_POST[$edit_str]) && $_POST['table'] == 'news') {
            $_SESSION['manage_type'] = 'edit';
            $_SESSION['table'] = $_POST['table'];
            $_SESSION['record'] = $_POST['record'];
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['post'] = $_POST['post'];
            header("Location: ../content_form.php");
            exit();
        }
        if (isset($_POST['update'])) {
            unset($_SESSION['manage_type']);
            unset($_SESSION['table']);
            unset($_SESSION['record']);
            unset($_SESSION['title']);
            unset($_SESSION['post']);
            $sql = "UPDATE ".$_POST['table']." SET post_title=? post_content=? WHERE ".$_POST['table']."_id=?";
            $stmt = mysqli_stmt_init($connection);
            if (!mysqli_stmt_prepare($stmt,$sql)) {

            }
            else {
                mysqli_stmt_bind_param($stmt, "ssi", $_POST['title'], $_POST['post'], $_POST['record']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                //
            }
        }
    }
?>