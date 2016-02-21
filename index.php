<?php

require_once 'config.php';

if (!extension_loaded('mysqli')) {
    die('Extention mysqli is not loaded. Cannot proceed.');
}

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_errno) {
    die (
        "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error
    );
}

$mysqli->query('SET NAMES utf8');

$insertQuery = "
    INSERT INTO
        ".$dbtable." (
        `name`,
        `phone`,
        `email`,
        `address`,
        `company`,
        `position`,
        `hobby`,
        `card`,
        `birthdate`,
        `site`,
        `sex`
        )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
";

if (!($stmt = $mysqli->prepare($insertQuery))) {
    echo 'Prepare failed: ' . $mysqli->errno . ' ' . $mysqli->error;
}

/*
  columnName => [rowtype1, rowtype2, rowtype3,]
*/
$rowMapping = [
    'name'        => [13, 14, 0],
    'phone'       => [2, 2, 6],
    'email'       => [12, 13, 1],
    'address'     => [7, 8, 8],
    'company'     => [10, 11, 3],
    'position'    => [6, 7, null],
    'hobby'       => [4, 6, 12],
    'card'        => [11, 12, 4],
    'birthdate'   => [null, null, 2],
    'site'        => [9, 10, null],
    'sex'         => [null, null, 14],
];

$inputFilename = 'test_data.csv';

$fileHandle = fopen($inputFilename, 'r');

if (!$fileHandle) {
    die('Have problem with opening file ' . $inputFilename);
}

// use prepared statements for multiple inserts
if (!($stmt->bind_param(
    'sssssssssss',
    $name,
    $phone,
    $email,
    $address,
    $company,
    $position,
    $hobby,
    $card,
    $birthdate,
    $site,
    $sex
))) {
    echo 'Bind failed: ' . $mysqli->errno . ' ' . $mysqli->error;
}

$count = 0;
while (($lineParts = fgetcsv($fileHandle, 4096, ',')) !== false) {

    // var_dump($lineParts);

    $rowType = isset($rowType) ? $rowType : null;
    $keyPart = $lineParts[4];

    switch ($keyPart) {
        case 'hobby':
            // set row type 1
            $rowType = 0;
            continue 2;

        case 'post':
            // set row type 2
            $rowType = 1;
            continue 2;

        case 'icard':
            // set row type 3
            $rowType = 2;
            continue 2;
    }

    // var_dump($rowType);

    foreach ($rowMapping as $columnName => $value) {

        if (!is_null($indexNumber = $value[$rowType])) {
            $indexNumber;
            $$columnName = $lineParts[$indexNumber];
        } else {
            $$columnName = null;
        }
    }

/*    if ($count > 10) {
        break;
    }*/
    $count++;

    if (!$stmt->execute()) {
        echo 'Execute failed: ' . $mysqli->errno . ' ' . $mysqli->error;
    }
}

$stmt->close();
$mysqli->close();
fclose($fileHandle);
