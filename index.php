<?php
    // クリエストを取得
    $request = $_POST;

    // コメントリストをDBより取得
    $commentlist = get_comment_list();

    // リクエストが空でない場合
    if(empty($request) === false && $request["comment"] !== "") {
        // コメント情報を設定
        $item = array(
            'date' => date('Y-n-j G:i'),
            'message' => $request["comment"]
        );

        // アイテムをDBに追加
        $inserted = insert_comment_item($item);

        // アイテムを配列の最初に追加
        if ($inserted) {
            $commentlist = array_push_first($commentlist, $item);
        }
    }

    // アイテムを配列の最初に追加
    function array_push_first($array, $item) {
        $tempArray = array($item);
        foreach ($array as $val) {
            array_push($tempArray, $val);
        }
        return $tempArray;
    }

    // コメントリストをDBより取得
    function get_comment_list() {

        // MYSQL接続
        $link = mysql_connect("localhost", "healthcare_user", "password") or
        die("Could not connect: " . mysql_error());

        // DBを指定
        $db_selected = mysql_select_db('healthcare');

        // テーブルデータ取得
        if ($link && $db_selected) {
            $query = "select *";
            $query .= " from comment";
            $query .= " order by id desc";
            $query .= " limit 1000";
            $result = mysql_query($query);
        }

        // 配列に格納
        $commentlist = array();
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            array_push($commentlist, array(
                'date' => date('Y-n-j G:i', strtotime($row[2])),
                'message' => $row[3]
            ));
        }

        // メモリを解放
        mysql_free_result($result);

        // MYSQL切断
        mysql_close($link);

        return $commentlist;
    }

    // コメントアイテムをDBへ追加
    function insert_comment_item($item) {
        // MYSQL接続
        $link = mysql_connect("localhost", "healthcare_user", "password") or
        die("Could not connect: " . mysql_error());

        // DBを指定
        $db_selected = mysql_select_db('healthcare');

        // テーブルに追加
        if ($link && $db_selected) {
            $query = "insert into comment (insert_uid, insert_date, message)";
            $query .= " value (";
            $query .= "'master'";
            $query .= ", '{$item["date"]}'";
            $query .= ", '{$item["message"]}'";
            $query .= ")";
            $result_flag = mysql_query($query);
            if (!$result_flag) {
                die('Could not insert: ' . mysql_error());
            }
        }

        // MYSQL切断
        mysql_close($link);

        return true;
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Health care Board</title>
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="css/ress.css">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="script/index.js"></script>
</head>
<body class="index">
    <header>
        <div class="content">
            <div class="top">
                <h1>Health care Board</h1>
                <button type="button" class="menu-btn"></button>
                <nav class="hide">
                    <ul>
                        <li><a href="index.php">Health care Board</a></li>
                        <li><a href="wether.php">Wether info</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <p>こんにちは！体調はどうですか？</p>
            <form name="commentfrm" action="index.php" method="post">
                <input type="text" name="comment" placeholder="体調をツイートする">
                <i class="fas fa-paper-plane"></i>
            </form>
        <div>
    </header>
    <div class="main">
        <?php if (!inserted): ?>
            <p class="alert">DBへの登録に失敗しました</p>
        <?php endif; ?>
        <div class="list">
            <!-- コメントアイテムを出力 -->
            <?php foreach($commentlist as $comment): ?>
            <div class="item">
                <div class="date"><?php echo $comment["date"]; ?></div>
                <div class="comment"><?php echo $comment["message"]; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>