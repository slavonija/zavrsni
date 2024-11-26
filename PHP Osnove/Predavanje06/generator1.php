<?php
function generator(): Generator {
    yield 'Ovo je prvi tekst';      // yield je umjesto return
    yield 'Ovo je drugi tekst';
    yield 'Ovo je treći tekst';

}

$gen = generator();
foreach($gen as $value) {
    echo $value . '<br>';
}

?>