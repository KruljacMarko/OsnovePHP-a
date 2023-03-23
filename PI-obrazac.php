<p>Upisite rijec: </p>
<form action="#" method="post">
    <input type="text" name="word">
    <button>posalji</button>
</form>

<?php
//funkcija za brojanje samoglasnika
function vowelCounter($word){
    $vowels = "aeiouAEIOU";
    $counter = 0;
    foreach (str_split($word) as $char) {
        if (strpos($vowels, $char) !== false) {
            $counter ++;
        }
    }
    return $counter;
}
//funkcija za brojanje suglasnika
function conCounter($charNum, $vowNum){
    return $charNum - $vowNum;
}
//provijera je li polje prazno
if (empty($_POST['word'])) {
    echo "polje ne smije biti prazno!";
    return;
}
//brojanje slova u rijeci
$charNum = strlen($_POST['word']);
//pozivanje funkcije za brojanje samoglasnika
$vowNum = vowelCounter($_POST['word']);
//pozivanje funkcije za pozivanje suglsnika
$conNum = conCounter($charNum, $vowNum);
//dohvacanje json filea i dekodiranje
$wordsJson = file_get_contents('words.json');
$words = json_decode($wordsJson, true);
//dodavanje arraya u 2d array
$words[] = [
    'word' => $_POST['word'],
    'charNum' => $charNum,
    'conNum' => $conNum,
    'vowNum' => $vowNum
];
?>

<table border="1">
    <tr>
        <th>Rijec</th>
        <th>Broj slova</th>
        <th>Broj suglasnika</th>
        <th>Broj samoglasnika</th>
    </tr>
    <?php
    foreach ($words as $word) {
        echo '<tr>';
        echo '<td>'. $word['word'] .'</td>';
        echo '<td>'. $word['charNum'] .'</td>';
        echo '<td>'. $word['conNum'] .'</td>';
        echo '<td>'. $word['vowNum'] .'</td>';
        echo '</tr>';

    }
    ?>
</table>

<?php
//kodiranje i slanje u json file
$wordsJson = json_encode($words, JSON_PRETTY_PRINT);
file_put_contents('words.json', $wordsJson);
?>


