<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CecyFood</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="manifest" href="/manifest.json">

    <script>
        setTimeout(() => {
            window.location.href =
                "auth/login.php";
        }, 3000);
    </script>
</head>

<body class="splash">

    <div class="logo-container">

        <div class="logo-paceholder">
            <img
                src="assets/img/logo.jpeg"
                class="logo-app"
                alt="logo">
        </div>

        <h1>CecyFood</h1>

        <p>
            Tu cafeteria escolar en tu app
        </p>
        <div class="loader"></div>
    </div>

</body>

</html>