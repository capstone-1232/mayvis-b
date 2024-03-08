<!DOCTYPE html>
<html>
<head>
    <title>Session Information</title>
</head>
<body>
    <h1>Session Information</h1>
    <ul>
        @foreach ($sessionData as $key => $value)
            <li>{{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}</li>
        @endforeach
    </ul>
</body>
</html>
