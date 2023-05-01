<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>右サイドバー</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .sidebar {
      position: fixed;
      float: right;
      top: 0;
      left: 0;
      bottom: 0;
      width: 20vw;
      background-color: #f8f9fa;
      padding: 2rem;
      overflow-y: auto;
      z-index: 1;
      border-left : 1px solid;
    }

  </style>

<body>
  <div class="sidebar">
    <h5 class="mb-3">検索</h5>
    
    
    <ul class="nav flex-column">
      <form method="get" action="">

        <li class="nav-item">
          <div class='d-flex'>
            <input type='date' class='start-form' name='s-date' id='date' value=""/>
            <p>~</p>
            <input type='date' class='end-form' name='e-date' id='date' value=""/>
          </div>
        </li>
        <li class="nav-item">
          <input type="text" name="name" placeholder="ユーザー名を入力">
        </li>
        <br>
        <li class="nav-item">
          <select name="gender">
            <option value="">性別</option>
            <option value="0">男性</option>
            <option value="1">女性</option>
          <option value="②">その他</option>
          </select>
        </li>
        <li class="nav-item">
          <div class='d-flex'>
            <input type="number" name="age" placeholder="年齢（下限）">
              <p>～</p>
            <input type="number" name="age" placeholder="年齢（上限）">
          </div>
        </li>
        <button type="submit">検索</button>
      </form>
    </ul> 
  </div>
  </div>
      
</body>
</head>