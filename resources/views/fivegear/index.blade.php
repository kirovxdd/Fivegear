<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .text:before{
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: center;
        }
        .text{
            text-align: center;
        }
    </style>
</head>
<body>
<div class="text">
    <form action="{{route('title.info')}}" method="post">
        @csrf
        <label for="title">Для поиска информации введите название бренда</label>
        <input name="title" id="title" placeholder="Поле для бренда">
        <button type="submit">Поиск</button>
    </form>
</div>
</body>
</html>
