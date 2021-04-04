<?php
?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial;
            display: flex;
            flex-direction: column;

            align-items: center;
        }

        * {
            box-sizing: border-box;
        }

        form.example input[type=text] {
            padding: 10px;
            font-size: 17px;
            border: 1px solid grey;
            float: left;
            width: 80%;
            background: #f1f1f1;
        }

        form.example button {
            float: left;
            width: 20%;
            padding: 10px;
            background: #2196F3;
            color: white;
            font-size: 17px;
            border: 1px solid grey;
            border-left: none;
            cursor: pointer;
        }

        form.example button:hover {
            background: #0b7dda;
        }

        form.example::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
    <title></title>
</head>
<body>

<h2>Search Person</h2>

<p>Search by firstname: </p>
<form class="example" action="/search/personInfo" method="post" style="margin:auto;max-width:400px;text-align:">
    <input type="text" placeholder="Search.." name="name">
        <button type="submit" value="name"><i class="fa fa-search"></i></button>
</form>
<br>
<p>Search by lastname:</p>
<form class="example" action="/search/personInfo" method="post" style="margin:auto;max-width:400px;text-align:">
    <input type="text" placeholder="Search.." name="surname">
    <button type="submit" value="surname"><i class="fa fa-search"></i></button>
</form>
<br>
<p>Search by personal code:</p>
<form class="example" action="/search/personInfo" method="post" style="margin:auto;max-width:400px;text-align:">
    <input type="text" placeholder="Search.." name="personal_code">
    <button type="submit" value="personal_code"><i class="fa fa-search"></i></button>
</form>

</body>
</html>




