<?php 

require_once './todo.php';
$todo = new Todo();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["method"]) && $_POST["method"] === "DELETE") {
        $todo->delete();
    } else {
        $todo->post($_POST['title'], $_POST['due_date']);
    }

    // ブラウザのリロード対策
    $redirect_url = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect_url");
    exit;
}

// $todo_list = $todo->getList();
// var_dump($todo_list);
?>

<html>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link crossorigin="anonymous" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
    <link rel = "stylesheet" href = "css/style.css">

    <!-- <body style = "background: linear-gradient(-45deg, rgba(246, 255, 0, .8), rgba(255, 0, 161, .8)),
    url(images/bg-cherrybrossam.jpg);
    background-size: cover;">

    <head> -->

    <body class = "fuchidori">

        <style type="text/css">
        body,td,th {font-family:"ほのかアンティーク角","ＭＳ Ｐゴシック", "Osaka", "ヒラギノ角ゴ Pro W3";font-size:14px;color: #00f;  text-stroke: 1px #000;
        }
        </style>
        </head>

        <head><title>TODO App</title></head>

        <h1>TODO App<h1>

        <h2>TODO作成</h2>
        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
            <div class="form-group">
                <label for="title">タスク名</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="タスク名" required>
            </div>
            <div class="form-group">
                <label for="due_date">期限</label>
                <input type="text" class="form-control" name="due_date" id="due_date" required>
            </div>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
            <input class="btn btn-primary"  type="submit" name="btn" value="TODOを作成する">
        </form>

        <hr>

        <h2 class="text-muted py-3">やること一覧</h2>

        <?php
        $todo_list = $todo->getList();
        ?>
        <table class="table">
            <thead>
            <tr>
                <th>タイトル</th>
                <th>期限</th>
                <th>状態</th>
                <th>更新</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($todo_list as $todo) {
                ?>
                <tr>
                    <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
                        <td><?=$todo['title']; ?></td>
                        <td><?=$todo['due_date']; ?></td>
                        <td class="label">
                            <label>
                                <select name="status" class="form-control">
                                    <?php
                                    foreach (Todo::STATUS as $key => $label) {
                                        $is_selected = $key === $todo["status"] ? "selected": "";
                                        echo "<option value='$key' $is_selected>$label</option>";
                                    }
                                    ?>
                                </select>
                            </label>
                        </td>
                        <td>
                            <input type="hidden" name="method" value="UPDATE">
                            <input type="hidden" name="todo_id" value="<?=$todo["id"]; ?>">
                            <button class="btn btn-primary" type="submit">変更</button>
                        </td>
                    </form>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>


        <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
            <input type="hidden" name="method" value="DELETE">
            <button class="btn btn-danger" type="submit">全削除</button>
        </form>

        <!-- JS, Popper.js, and jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
                integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
        </script>
        <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
        </script>
        <script>
        flatpickr(document.getElementById('due_date'), {
            locale: 'ja',
            dateFormat: "Y/m/d",
            minDate: new Date()
        });
        </script>
    </body>
</html>