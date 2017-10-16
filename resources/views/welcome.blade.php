<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Base : Team Communication Platform.</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-size: 16px;
            color: #5f6283;
            font-family: "Roboto", sans-serif;
        }

        .wrapper {
            display: flex;
            min-height: 100%;
            align-items: center;
            align-content: center;
            justify-content: center;
        }

        h1 {
            font-size: 6rem;
            font-weight: lighter;
            opacity: 0;
            animation-name: makeAnEntrance;
            animation-delay: 0s;
            animation-duration: 2s;
            animation-iteration-count: 1;
            animation-direction: normal;
            animation-fill-mode: forwards;
            animation-timing-function: ease-in-out;
        }

        @keyframes makeAnEntrance {
            0% {
                opacity: 0;
                transform: scale(0.2);
                filter: blur(100px);
            }
            100% {
                opacity: 1;
                transform: scale(1);
                filter: blur(0px);
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h1>Base</h1>
</div>
</body>
</html>
