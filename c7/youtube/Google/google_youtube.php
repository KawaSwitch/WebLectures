<?php
require '../vendor/autoload.php';
define("API_KEY","AIzaSyA2bHdmLbjeCjuMF6bYx-K02GDSkPa5dNA");
date_default_timezone_set('Asia/Tokyo');
use Google\GTrends;

    $options = [
        'hl' => 'ja-JP',
        'tz' => -540,
        'geo' => 'JP',
    ];
/** @var Google\GTrends $gt */

    $gt = new GTrends($options);

    $xml=$gt->getDailySearchTrends();
//  var_dump($xml);
//  var_dump($xml["default"]["trendingSearchesDays"][0]["trendingSearches"][0]["title"]["query"]);

    if (!$xml) {
        return "情報の取得に失敗しました。";
    }

    $keyword='';

    foreach($xml["default"]["trendingSearchesDays"][0]["trendingSearches"] as $rank) {
//      var_dump($rank["title"]["query"]);
            $keyword .= $rank["title"]["query"].',';
    }
//  var_dump($keyword);

    $arr = explode(',', $keyword);

//  var_dump($arr);

$client = new Google_Client();
$client->setApplicationName("demo");
$client->setDeveloperKey(API_KEY);

$youtube = new Google_Service_YouTube($client);

$first_keyword = $arr[0];

$params['q'] = $first_keyword;
$params['type'] = 'video';
$params['maxResults'] = 10;

$first_keyword = htmlspecialchars($first_keyword);
$videos = [];
try {
    $searchResponse = $youtube->search->listSearch('snippet', $params);
    array_map(function ($searchResult) use (&$videos) {
        $videos[] = $searchResult;
    },$searchResponse['items']);
} catch (Google_Service_Exception $e) {
    echo htmlspecialchars($e->getMessage());
    exit;
} catch (Google_Exception $e) {
    echo htmlspecialchars($e->getMessage());
    exit;
}

?>
<!doctype html>

<html lang="ja">
<head>
    <meta charset='utf-8'>
    <title>Trend Movie</title>
<link rel="stylesheet" href="http://no1s.biz/kenshu/bootstrap/bootstrap-3.3.4/css/bootstrap.css">
<link rel="stylesheet" href="http://no1s.biz/kenshu/bootstrap/bootstrap-3.3.4/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="http://no1s.biz/kenshu/bootstrap/bootstrap-3.3.4/js/bootstrap.min.js"></script>
<style>
html, body{
    background-color: #f1f1f1;
    height: 100%;
    margin: 0;
    padding: 0;
}
#container{
    height: 100%;
}
#header{
    padding: 20px;
    background-color: #fff;
}
#header form{
    width: 1200px;
    margin: 0 auto;
}
#main_box{
    margin: 0 auto;
    width: 1200px;
}
.movieBox {
    margin: 20px 0;
}
a.movieLink {
    display:block;
    overflow: auto;
    padding: 10px;
    border: 1px solid #ccc;
    background-color: #fff;
    color: #696969;
}
 
a.movieLink:hover {
    border: 1px solid #4169E1;
    color: #4169E1;
}
 
.movieBox .thums {
    float: left;
    margin-right: 10px;
    width: 120px;
}
.movieBox .description {
    float:left;
    width: 1000px;
    word-break: break-all;
}
</style>
</head>

<body>
<center>
    <h1><?php echo date("Y/m/d") . 'のトレンドワード'; ?></h1>
    <h1><?php echo $keyword ?></h1>
    <h1><?php echo '1stトレンドワードの動画一覧'; ?></h1>
</center>
<div id="container">
    <div id="main_box" class="clearfix">
    <?php 
    foreach($videos as $video) :
        echo '<div class="movieBox">';
        echo '<a class="movieLink" href="https://www.youtube.com/watch?v=' . $video['id']['videoId'] . '">';
        echo '<div class="thums">';
        echo '<img src="' . $video['snippet']['thumbnails']['default']['url']. '" />';
        echo '</div>';
        echo '<div class="description">';
        echo '<div>' . $video['snippet']['title'] . '</div>';
        echo '<div>' . $video['snippet']['description'] . '</div>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
    endforeach;
    ?>
    </div>
</div>

</body>
</html>