2020年度(R2) 1Q Web情報アーキテクチャ特論

cX: 確認課題, アルバイトプログラム  
eX: アンケートプログラム課題  
<br>

## 第1回 (4/10)
c1: データの入力  
e1: 自己紹介プログラムの作成  

## 第2回 (4/17)
c2: ファイルによるデータ永続化  
e2: c2機能のアンケートへの実装  

## 第3回 (4/24)
c3: DBによるデータ永続化, セッション管理  
e3: c3機能のアンケートへの実装  

## 第4回 (5/1)
c4とe4(MVC)は5の方でまとめて実装するので飛ばして作成していない  

c5: MVCモデル, フロントコントローラ, ログイン機能  
e5: c5機能のアンケートへの実装  

## 第5回 (5/8)
c6: WebSocket, ブロードキャスト

## 第6回 (5/15)
e6: ログイン付きチャットの実装  

## 第7回 (5/22)
c7: LOD課題基礎, OpenAPI基礎(Google Trends, YouTube)  
e7: LOD課題応用, OpenAPI応用(Google Trends)  

Google Trends, YouTubeのAPIを使う際にはライブラリのインストールが必要  
Composerとcomposer.jsonを使うと楽  

### composer.json
```
{
    "require": {
        "google/apiclient": "^2.4",
        "x-fran/g-trends": "^2.2"
    }
}
```
同ディレクトリで下記コマンドを実行  
```
composer install
```

## 第8回 (5/29)
c8: MediaCapture, Geolocation API  

## 最終課題 (6/5〆)
final: 自由課題  
・Goggleアカウントでのログイン機能  
・MediaCaptureでのアップロード機能  
実行にはgoogle/apiclientのインストールが必要  

google: Googleアカウントでのログイン機能テスト  