<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подписка на рассылку</title>
</head>
<body>
    <form action="{{ route('subscription.subscribe') }}" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Подписаться</button>
    </form>
</body>
</html>