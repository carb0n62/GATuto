<?php
$pdo = new PDO('mysql:dbname=gatuto;host=localhost', 'gatuto', 'gatuto');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);