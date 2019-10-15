<?php
    // 送信完了フラグを設定
    $sended = false;

    // リクエストを取得
    $request = $_POST;

    // リクエストパラメータが空でない場合
    if (empty($request) === false) {
        // メッセージが入力されているか判定
        $messageFlg = (strlen($request["message"]) > 0);
        
        // メールを送信
        if ($messageFlg) {
            $sended = sendMail($request);
        }
    }

    // メール送信
    function sendMail($request) {
        // 内容を設定
        $to = "takaXXXX@email.com";
        $subject = "Health care Pageからのお問合せ";
        $message = nl2br($request["message"]);
        $message .= "\r\n";
        $message .= $request["name"];
        $message .= "(".$request["email"].")";
        $headers = "From: test@samurai.jp";
        $headers .= "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8";

        // メールを送信し、結果を返却
        return mail($to, $subject, $message, $headers);
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
<body class="contact">
    <header>
        <div class="content">
            <div class="top">
                <h1>Contact</h1>
                <button type="button" class="menu-btn"></button>
                <nav class="hide">
                    <ul>
                        <li><a href="index.php">Health care Board</a></li>
                        <li><a href="wether.php">Wether info</a></li>
                        <li><a href="contact.php"">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <p>お問合せは下記フォームよりお願いします</p>
        <div>
    </header>
    <div class="main">
        <?php
            if (empty($request) === false) {
                if ($sended) {
                    echo "<p>送信が完了しました。</p>";
                } 
                else {
                    echo "<p class=\"alert\">送信に失敗しました。</p>";
                }
            }
        ?>
        <form action="contact.php" method="post">
            <input name="name" value="<?php echo $request["name"]; ?>" type="text" placeholder="お名前" required><br>
            <input name="email" value="<?php echo $request["email"]; ?>" type="email" placeholder="メールアドレス" required><br>
            <textarea name="message" placeholder="お問合せ内容" required><?php echo $request["message"]; ?></textarea><br>
            <input type="submit" value="送信" <?php if($sended){ echo "disabled"; } ?>>
        </form>
    </div>
    <footer>
        <p>
        tel：0XX-XXXX-XXXX<br>
        mail：takaXXXX@email.com<br>
        am9:00 - pm18:00</p>
    </footer>
</body>
</html>