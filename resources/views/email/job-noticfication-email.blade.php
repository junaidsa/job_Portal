<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notication</title>
</head>
<body>
    <h1>Hello {{$mailData['employes']->name }}</h1>
    <p>You have a new job application for {{$mailData['job']->title}}</p>
    <p>Employee Details:</p>
    <p>Name: {{$mailData['user']->name}}</p>
    <p>Email: {{$mailData['user']->email}}</p>
    <p>Mobile: {{$mailData['user']->mobile}}</p>
</body>
</html>
