<?php 

require_once './todo.php';
$todo = new Todo();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $todo->post($_POST['title'], $_POST['due_date']);
}
?>

<html>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">      

    <link rel = "stylesheet" href = "../css/style.css">

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
                <!-- <input type="text" class="form-control" name="due_date" id="due_date" required> -->
                <input type="date" class="form-control" name="due_date" required>
            </div>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
            <input class="btn btn-primary"  type="submit" name="btn" value="TODOを作成する">
        </form>


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