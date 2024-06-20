<?php
/*
    require_once __DIR__ . '/config/config.php';

    include("database.php");

    try {
        // Creează un obiect al clasei csv
        $csvObj = new Database();
        
        // Specifică calea către fișierul CSV, numele tabelului și câmpurile (coloanele) din tabel
        $file = 'csvDB/Nominees.csv';
        $tableName = 'nominees';
        $fields = 'Last Name, First Name, Category, Project, Year, Show, Award'; // Adaugă aici numele câmpurilor din tabel, separate prin virgulă
    
        // Apelarea metodei importCSV() pentru a importa datele din fișierul CSV în baza de date
        $csvObj->importCSV($file, $tableName, $fields);
    } catch (Exception $e) {
        // Gestionarea erorilor în cazul în care apare o excepție
        echo "An error occurred: " . $e->getMessage();
    }
    /* router 
        dispetch

        folder controller
    */
?>

