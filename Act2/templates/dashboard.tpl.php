<?php
//Con esto evitamos que un usuario entre si no esta logeado
if (!isset($_SESSION['uname'])) {
    header('Location:' . BASE . 'index');
}

include 'header.tpl.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div class="container">
        <!--Select Task-->
        <h1><center>Tasks</center></h1>
        <hr>
        <br>

        <form action="<?= BASE ?>dashboard/selectd" method="post">
            You can see your tasks clicking here ➤ <input type="submit" name="ok" value="Show tasks">
        </form>
        <?php
        if (isset($_POST["ok"])) {
            if (isset($data)) {
                if (count($data) > 0) {
        ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Task ID</th>
                                <th>Task</th>
                                <th>End date</th>
                                <th>Remove</th>
                                <th>Edit</th>
                            </tr>

                        </thead>
                        <?php

                        foreach ($data as $valor) {
                            echo "<tr>";
                            foreach ($valor as $key => $value) {
                                if ($key == "id") {
                                    $idTask = $value;
                                }
                                echo "<td>" . $value . "</td>";
                            }
                            echo "<td><form action='" . BASE . "dashboard/removed' method='post'><input type='submit' value='✘'> <input type='hidden' name='idTask' value='$idTask'></form></td>";
                            echo "<td><form action='' method='post'><input type='submit' name='edit' value='✍'><input type='hidden' name='idTask' value='$idTask'></form></td>";
                            echo "</tr>";
                        }
                    } else {
                        ?>
                        <script>
                            alert("You don't have any task yet.");
                        </script>
                    <?php
                    }
                    ?>
                    </table>
                <?php
            }
        }
        if (isset($_POST['edit'])) {
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>End date</th>
                            <th>Ok</th>
                        </tr>
                    </thead>
                    <tr>
                        <form action="<?= BASE ?>dashboard/editd" method="POST">
                            <?php
                            foreach ($data as $valor) {
                                echo "<tr>";
                                foreach ($valor as $key => $value) {
                                    if ($key == "id") {
                                        $idTask = $value;
                                    }
                                    if ($_POST['idTask'] == $idTask) {
                                        echo "<input type='hidden' name='nidTask' value=$idTask>";
                                        if ($key == "due_date") {
                                            echo "<td><input type='date' name='newdate' value=$value></td>";
                                            echo "<td><input type='submit' value='✔'></td>";
                                        } else if ($key == "description") {
                                            echo "<td><input type='text' name='newdesc' value=$value></td>";
                                        }
                                    }
                                }
                                echo "</tr>";
                            }
                            ?>

                        </form>
                    </tr>
                </table>
            <?php
        }
        echo "<br><br><br><form action='' method='post'>You can add a new task clicking here ➤ <input type='submit' name='insert' value='Add task'></form>";
        if (isset($_POST['insert'])) {
            ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>End date</th>
                            <th>Ok</th>
                        </tr>
                    </thead>
                    <tr>
                        <form action="<?= BASE ?>dashboard/insertd" method="POST">
                            <td><input required type="text" name="desc"></td>
                            <td><input required type="date" name="date"></td>
                            <td><input type="submit" value="✔"></td>
                        </form>
                    </tr>
                </table>
            <?php
        }
            ?>
    </div>
</body>

<?php
include 'footer.tpl.php';
?>
