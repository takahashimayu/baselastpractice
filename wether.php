 <?php
    // 都市一覧を設定
    $citylist = array(
        array( 'id' => '1850147', 'name' => '東京都　23区域'),
        array( 'id' => '1848354', 'name' => '神奈川県　横浜市'),
        array( 'id' => '1853909', 'name' => '大阪府　大阪市'),
        array( 'id' => '1856057', 'name' => '愛知県　名古屋市'),
        array( 'id' => '2128295', 'name' => '北海道　札幌市'),
        array( 'id' => '1863967', 'name' => '福岡県　福岡市'),
        array( 'id' => '1847966', 'name' => '兵庫県　明石市'),
        array( 'id' => '1859642', 'name' => '神奈川県　川崎市'),
        array( 'id' => '1857910', 'name' => '京都府　京都市'),
        array( 'id' => '6940394', 'name' => '埼玉県　さいたま市'),
        array( 'id' => '1862415', 'name' => '広島県　広島市'),
        array( 'id' => '2111149', 'name' => '宮城県　仙台市'),
        array( 'id' => '2113015', 'name' => '千葉県　千葉市'),
    );

    // リクエストを取得
    $request = $_GET;
    $cityid = (empty($request)) ? "2113015" : $request["city"];

    // 天気情報を取得
    $data = getData($cityid);
    
    // 天気情報を取得
    function getData($cityid) {
        // apiキーを取得
        $appid = "d685ccfc3667fc6ef63ea877f67bd6f2";

        // URLの設定
        $url = "api.openweathermap.org/data/2.5/forecast?id={$cityid}&appid={$appid}&units=metric";

        // 新しい cURL リソースを作成
        $ch = curl_init();

        // URL その他のオプションを適切に設定
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す
        
        // URL の内容を取得し、JSONから配列へ変換
        $response = curl_exec($ch);
        $array = json_decode($response, true);

        // cURL リソースを閉じ、システムリソースを開放
        curl_close($ch);

        return $array;
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
<body class="wether">
    <header>
        <div class="content">
            <div class="top">
                <h1>Wether info</h1>
                <button type="button" class="menu-btn"></button>
                <nav class="hide">
                    <ul>
                        <li><a href="index.php">Health care Board</a></li>
                        <li><a href="wether.php">Wether info</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <p>お天気をチェックしましょう！</p>
            <form action="wether.php" method="get" name="cityfrm">
                <select name="city" id="city">
                    <?php foreach ($citylist as $val) {
                        $optionEle = "<option value=\"{$val["id"]}\"";
                        if ($val["id"] === $cityid) {
                            $optionEle .= " selected";
                        }
                        $optionEle .= ">{$val["name"]}</option>";
                        echo $optionEle;
                    } ?>
                </select>
                <span>▼</span>
            </form>
        <div>
    </header>
    <div class="main">
        <div class="wether-content">
            <?php foreach ($data["list"] as $val) : ?>
            <div class="wether-item">
                <div class="item-header">
                    <div class="dt-txt">
                        <span id="span-date"><?php echo substr($val["dt_txt"], 0, 10); ?></span>
                        <span class="span-time"><?php echo substr($val["dt_txt"], 11, 5); ?></span>
                    </div>
                </div>
                <div class="item-main">
                    <img src="http://openweathermap.org/img/w/<?php echo $val["weather"][0]["icon"]; ?>.png"></img>
                    <div class="temp-area">
                        <div class="temp"><?php echo floor($val["main"]["temp"]); ?>℃</div>
                    </div>
                    <div class="other-main">
                        <div class="grnd-level"><span>気圧：</span><?php echo floor($val["main"]["grnd_level"]); ?>hPa</div>
                        <div class="humidity"><span>湿度：</span><?php echo $val["main"]["humidity"]; ?>%</div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>