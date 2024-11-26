<?php
class Utils{
    public static $test;
    // generator slučajnih stringova, ulaz je dužina koju želimo
    public static function generateRandomString(int $length): string{
        $characters = '0123456789abcdefghijklmnoprsqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, $charactersLength -1)];
        }
        return $randomString;
    }

    public function generateId(): string{
        return $this->generateRandomString(10);
    }

    public static function generirajId(int $length): string{
        // ovako se poziva static metoda
        // self za referenciranje tekuće klase, :: Scope Resolution Operator omogućava pristup statičkim članovima klase
        return self::generateRandomString(10);
    }

}
// obavezno distanciranje jer nismo definirali static metodu već običnu metodu
// ako stavimo da je klasa Utils apstraktna, neće moći biti distancirana
$utils = new Utils();
var_dump($utils->generateRandomString(10));
// static svojstvu iz klase nije moguće pristupiti
//var_dump($utils->test);
// static metodi je moguće pristupiti
echo $utils->generateId() . PHP_EOL;
// ako je ispred klase dodan abstract
// način pozivanja static metode iz klase Utils sa dvostrukom dvotočkom :: radi i ako je klasa apstraktna
echo Utils::generateRandomString(10) . PHP_EOL;

$alati = new Utils();
echo $alati->generirajId(10) . PHP_EOL;

// enumeratori kada želimo ograničiti unos na unaprijed definirane vrijednosti
enum Gender: string{
    case MA = "Мale";
    case FE = "Female";
    case OT = "Other";
}

// ovo ispiše vrijednosti enuma Gender
foreach (Gender::cases() as $gend) { 
    echo $gend->name . "\n";
}

class User{
    private string $name;
    private Gender $gender;

    public function __construct(string $name, Gender $gender){
        $this->name = $name;
        $this->gender = $gender;
    }
    
    // getter, bez njega ne radi, ovo je rješenje sa magic metodom __get
    // on se aktivira svaki puta kada pokušamo dohvatiti privatno svojstvo (čak i public)
    public function __get($name){
        return $this->$name;
    }
}


$user = new User("Mark", Gender::MA);
var_dump($user->gender);
echo $user->gender->value; // Male
