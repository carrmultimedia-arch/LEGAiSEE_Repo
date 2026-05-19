<?php

require_once "db.php";

if ($conn) {
    echo "DB CONNECTED SUCCESSFULLY";
} else {
    echo "DB FAILED";
}