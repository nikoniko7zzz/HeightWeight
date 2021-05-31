<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

</head>

<body>
  <!-- <form action="test_create.php" method="post"> -->
    <fieldset>
      <legend>テキスト</legend>
      <!-- <a href="text_read.php">一覧画面</a> -->
      <div>
        身長:<input type="text" name="height">cm
      </div>
      <div>
        体重:<input type="text" name="weight">kg
      </div>
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

  <!-- データ出力場所 一覧-->
  <table border="1" id="targetTable">
    <thead>
      <tr>
        <td>日付</td>
        <td>身長</td>
        <td>体重</td>
        <td>標準Max</td>
        <td>標準Min</td>
      </tr>
    </thead>
    <tbody>
    <tbody>
  </table>

  <!-- データ出力場所 グラフ-->
  <h1>折れ線グラフ</h1>
  <canvas id="myLineChart"></canvas>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>


  <script>
    //CSVファイルを読み込む関数getCSV()の定義-------------------------
    function getCSV() {
      const req = new XMLHttpRequest(); // HTTPでファイルを読み込むためのXMLHttpRrequestオブジェクトを生成
      req.open("get", "data/test.csv", true); // アクセスするファイルを指定
      req.send(null); // HTTPリクエストの発行

      // レスポンスが返ってきたらconvertCSVtoArray()を呼ぶ
      req.onload = function() {
        convertCSVtoArray(req.responseText); // 渡されるのは読み込んだCSVデータ
      }
    }

    // 読み込んだCSVデータを二次元配列に変換する関数convertCSVtoArray()の定義------------------------------
    function convertCSVtoArray(str) { // 読み込んだCSVデータが文字列として渡される
      let result = []; // 最終的な二次元配列を入れるための配列
      let tmp = str.split("\n"); // 改行を区切り文字として行を要素とした配列を生成

      // 各行ごとにカンマで区切った文字列を要素とした二次元配列を生成
      for (let i = 0; i < tmp.length; ++i) {
        result[i] = tmp[i].split(',');
      }

      console.log(result);






      // 表を作成しHTMLに表示する-----------------------------
      for (let i = 0; i < result.length - 1; ++i) {
        let table = document.getElementById('targetTable'); //HTMLのtableの場所
        let newRow = table.insertRow(); //newRowという変数insertRowメソッドで1行追加して格納
        for (let k = 0; k < 5; ++k) {
          let newCell = newRow.insertCell(); //insertCellメソッドでセルを作成
          let newText = document.createTextNode(result[i][k]); //createTextNodeメソッドでセルの中の文字を作成
          newCell.appendChild(newText); //作成した文字をセルに追加
        };
      }


      // result配列の中で列ごとにに格納する
      let picked_date = [];
      let picked_height = [];
      let picked_weight = [];
      let picked_tekisei_max = [];
      let picked_tekisei_min = [];

      for (let row = 0; row < result.length; ++row) {
        picked_date.push(result[row][0])
        picked_height.push(result[row][1])
        picked_weight.push(result[row][2])
        picked_tekisei_max.push(result[row][3])
        picked_tekisei_min.push(result[row][4])
      };

      // グラフをHTMLに表示する-------------------------------
      // canvas要素（ID：myChart）を取得し変数ctxに入力
      const ctx = document.getElementById("myLineChart");
      const myLineChart = new Chart(ctx, { //描画するグラフを、new Chart()によって設定
        type: 'line', //折れ線グラフ
        data: {
          // データの軸ラベル
          labels: picked_date,

          // データセット
          datasets: [{
            //折れ線グラフ
            label: '身長(cm）',
            data: picked_height,
            lineTension: 0, //直線にする
            borderColor: "rgb(255, 99, 132)",
            backgroundColor: "rgba(0,0,0,0)",
            yAxisID: 'y1'
          }, {
            label: '体重(kg）',
            data: picked_weight,
            lineTension: 0,
            borderColor: "rgb(54,162,235)",
            backgroundColor: "rgba(0,0,0,0)",
            yAxisID: 'y2'
          }]
        },
        options: {
          responsive: true,
          title: {
            display: true,
            text: '身長と体重の推移'
          },
          scales: { //軸設定
            yAxes: [{ //y軸設定
                id: 'y1', //左軸
                position: 'left',
                ticks: {
                  // borderColor: 'rgb(255, 99, 132)',
                  suggestedMax: 150,
                  suggestedMin: 130,
                  stepSize: 5,
                  callback: function(value, index, values) {
                    return value + 'cm'
                  }
                },
                scaleLabel: {
                  display: true,
                  labelString: '身長'
                }
              },
              {
                id: 'y2', //右軸
                position: 'right',
                ticks: {
                  suggestedMax: 50,
                  suggestedMin: 30,
                  stepSize: 5,
                  callback: function(value, index, values) {
                    return value + 'kg'
                  }
                },
                scaleLabel: {
                  display: true,
                  labelString: '体重'
                }
              }
            ],
          },
        }
      });













    };

    getCSV(); //最初に実行される
  </script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script> -->

</body>

</html>