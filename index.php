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

// $mysqli->close();

/*$rowTypeOneColumns = [
    'id','login','phone','age','hobby','category','position','address','date','site','company','card','email','name','color'
];
$rowTypeTwoColumns = [
    'id','login','phone','age','post','ra','hobby','position','address','date','site','company','card','email','name','color'
];
$rowTypeThreeColumns = [
    'name','email','birthdate','company','icard','orgnum','phone','phone2','address','city','zip','region','hobby','dep','sex'
];*/

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

// $inputFilename = 'test_data.csv';
$inputFilename = 'my_test_data.csv';

$fileHandle = fopen($inputFilename, 'r');

if (!$fileHandle) {
    die('Have problem with opening file ' . $inputFilename);
}

$count = 0;
$rowType = null;
/* TODO: skip insert into db header rows for each rowtype */
while (($lineParts = fgetcsv($fileHandle, 4096, ',')) !== false) {

    // var_dump($lineParts);

    $rowType = isset($rowType) ? $rowType : -1;
    $keyPart = $lineParts[4];

    switch ($keyPart) {
        case 'hobby':
            // set row type 1
            $rowType = 0;
            break;

        case 'post':
            // set row type 2
            $rowType = 1;
            break;

        case 'icard':
            // set row type 3
            $rowType = 2;
            break;
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

/*    $columnNamesArr = [
        'name',
        'phone',
        'email',
        'address',
        'company',
        'position',
        'hobby',
        'card',
        'birthdate',
        'site',
        'sex',
    ];

    print_r($columnNamesArr);

    var_dump(
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
    );*/

    if ($count > 10) {
        break;
    }
    $count++;

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

    if (!$stmt->execute()) {
        echo 'Execute failed: ' . $mysqli->errno . ' ' . $mysqli->error;
    }
}

$stmt->close();
$mysqli->close();
fclose($fileHandle);
