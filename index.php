<?php

$rowTypeOneColumns = [
    'id','login','phone','age','hobby','category','position','address','date','site','company','card','email','name','color'
];
$rowTypeTwoColumns = [
    'id','login','phone','age','post','ra','hobby','position','address','date','site','company','card','email','name','color'
];
$rowTypeThreeColumns = [
    'name','email','birthdate','company','icard','orgnum','phone','phone2','address','city','zip','region','hobby','dep','sex'
];

// $needToCollect = [name, phone, email, address, company, title(wtf), hobby, card(icard), birthdate, site, sex];

// for each type of row we need to know correct index number
// i.e.
// name -- $linePart[13], $linePart[14], $linePart[0] for each type of row accordingly

/*
  [rowtype1, rowtype2, rowtype3,]
*/
$rowMapping = [
    'name'        => [13, 14, 0],
    'phone'       => [2, 2, 6],
    'email'       => [12, 13, 1],
    'address'     => [7, 8, 8],
    'company'     => [10, 11, 3],
    'title(wtf)'  => [],
    'hobby'       => [4, 6, 12],
    'card(icard)' => [11, 12, 4],
    'birthdate'   => [null, null, 2],
    'site'        => [9, 10, null],
    'sex'         => [null, null, 14],
];

// $inputFilename = 'test_data.csv';
$inputFilename = 'my_test_data.csv';

$fileHandle = fopen($inputFilename => [], 'r');

if (!$fileHandle) {
    die('Have problem with opening file ' . $inputFilename);
}

$count = 0;
while (($lineParts = fgetcsv($fileHandle, 4096, ',')) !== false) {

    var_dump($lineParts);

    $rowType = 0;
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

    if ($count > 7) {
        break;
    }
    $count++;
}

fclose($fileHandle);
