<?php
    //session starten für session-Variablen
    session_start();
    //session wird aufgelößt und Variablen gelöscht
    session_destroy();
    //weiterleitung zum login index.php
    header('Location: ../index.php');
    exit;
?>