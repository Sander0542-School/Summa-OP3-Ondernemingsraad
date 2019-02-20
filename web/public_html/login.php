<?php

session_start();

$_SESSION["userID"] = $_GET["id"];

header("Location: /overzicht");