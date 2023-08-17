<?php

session_start();
unset($_SESSION['login']);
die(header('location: /'));