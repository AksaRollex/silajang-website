<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Error</title>
    <style>
        :root {
            font-size: 16px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0px;
            padding: 0px;
        }

        .heading * {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 100%;
        }

        table.main td,
        table.main th {
            border: 2px solid black;
        }

        table.main th {
            text-align: center;
        }

        .checkbox {
            width: 1rem;
            height: 1rem;
            border: 1px solid black;
            display: inline-flex;
        }

        .checkbox.check {
            align-items: center;
            justify-content: center;
        }

        .italic * {
            font-style: italic;
        }

        .ttd {
            width: 150px;
            height: 100px;
            object-fit: contain;
        }

        ul.check {
            list-style: none;
        }

        ul.check li:before {
            content: '✓';
        }

        footer.tte {
            position: fixed;
            bottom: -2rem;
            left: 0px;
            right: 0px;
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>{{ $response['error'] }}</h1>

</body>

</html>
