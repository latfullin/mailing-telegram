  <style>
    .error404 {
      width: 100%;
    }
    .error404__container {
      padding-top: 1rem;
      padding-bottom: 1rem;
    }
    .error404__title {
      display: block;
      margin: auto; 
      font-weight: 700;
      text-align: center;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }
    .error404__title span {
      color: #fff;
      font-size: 6rem;
      letter-spacing: 0.125rem;
      text-shadow: 1px 0 2px #bfbfbf, 0 1px 1px #e6e6e6, 0 2px 1px #d9d9d9, 0 3px 1px #cccccc, 0 4px 1px #bfbfbf, 0 5px 1px #b3b3b3, 0 6px 1px #a6a6a6, 0 7px 1px #737373, 0 8px 3px rgba(102, 102, 102, 0.4), 0 9px 5px rgba(102, 102, 102, 0.1), 0 10px 7px rgba(102, 102, 102, 0.15), 0 11px 9px rgba(102, 102, 102, 0.2), 0 12px 11px rgba(102, 102, 102, 0.25), 0 13px 15px rgba(102, 102, 102, 0.3);
      cursor: default;
      transition: all 0.1s linear;
    }
    .error404__title span:hover {
      text-shadow: 0 0 2px #595959;
      transition: all 0.1s linear;
    }
    .error404__text {
      margin: 0;
      color: #666666;
      font-size: 0.875rem;
      line-height: 1.5;
      text-align: center;
    }
    .error404__controls {
      padding-top: 1rem;
      text-align: center;
    }
    @media (min-width: 768px) {
      .error404__container {
        padding-top: 3rem;
        padding-bottom: 3rem;
      }
      .error404__title span {
        font-size: 12rem;
      }
      .error404__text {
        font-size: 1rem;
        line-height: 2;
      }
    }
  </style>
</head>
<body>
  <? include_once root("resources/components/menu/menu.php") ?>
  
  <div class="error404">
    <div class="container error404__container">
    <p class="error404__title">
      <span>4</span><span>0</span><span>4</span>
      <span>!</span>
    </p>
    <p class="error404__text"> Похоже, вы выбрали неправильный путь.
      </p>
      <p class="error404__text"> Не волнуйтесь, время от времени, это случается с каждым из нас.
        </p>
    <div class="error404__controls">
      <a href="/" class="btn -primary error404__btn">Перейти на главную</a>
    </div>
  </div>
</div>