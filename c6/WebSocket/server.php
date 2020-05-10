<?php

// サーバが各国語で挨拶を返すサンプル


// WebSocketServerクラスライブラリのインクルード

include 'WebSocketServer.php';
include 'WebSocketClient.php';
include 'WebSocketEvent.php';
include 'IWebSocketEvent.php';
include 'WebSocketException.php';


try {

  // WebSocketServerオブジェクトのインスタンス生成

  $ws = new WebSocketServer("192.168.1.9", "8080");


  // ログ表示をOFF

  $ws->setDisplayLog (false);

  // 識別名の登録

  $ws->registerResource ('talk');


  // メッセージ受信に対するイベントハンドラの登録

  $ws->registerEvent('receivedMessage', 'talk',

      function ($client, $message) use (&$ws) {

        // クライアントから受信したメッセージ表示

        echo "受信: $message\n";

        // 受信したメッセージに応じて返信を返す

        switch ($message) {

        case "こんにちは":
          $client->sendCommand("サーバへようこそ！", 1, false);
          break;

        case "Hello":
          $client->sendCommand("Welcome to this server!", 1, false);
          break;

        default:
          $client->sendCommand('"' . $message . '" は分かりません', 1, false);
          break;

        }

      }

  );

  // サーバ起動

  $ws->serverRun(

      function () {

        printf("Running Server!\n");

      }

  );

} catch (WebSocketException $e) {

  echo $e->getMessage() . "\n";

}

?>
