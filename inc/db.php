<?php
try {
    $db = new PDO('sqlite:' . __DIR__ . '/journal.db');

    // Attribute setup
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // TODO: set more attributes

    // Errors
} catch (Exception $e) {
    $e->getMessage();
    die();
}
