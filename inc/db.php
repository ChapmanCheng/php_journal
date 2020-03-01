<?php
try {
    $db = new PDO('sqlite:' . __DIR__ . '\journal.db');

    // Attribute setup
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // TODO: set more attributes

    // Errors
} catch (Exception $e) {
    $e->getMessage();
    die();
}
