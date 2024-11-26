<?php

/* Ovdje je implementirana capcha, ostalo isto */
session_start();

class RegistrationException extends Exception {}

function generatePassword() {
    $length = 10;
    $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@$€!%*+\-?&';
    $password = '';
    $hasLowercase = false;
    $hasUppercase = false;
    $hasDigit = false;
    $hasSpecialChar = false;

    while (strlen($password) < $length) {
        $char = $charset[mt_rand(0, strlen($charset) - 1)];

        if (!$hasLowercase && ctype_lower($char)) {
            $password .= $char;
            $hasLowercase = true;
        } elseif (!$hasUppercase && ctype_upper($char)) {
            $password .= $char;
            $hasUppercase = true;
        } elseif (!$hasDigit && ctype_digit($char)) {
            $password .= $char;
            $hasDigit = true;
        } elseif (!$hasSpecialChar && strpos('@$€!%*+\-?&', $char) !== false) {
            $password .= $char;
            $hasSpecialChar = true;
        } elseif (strlen($password) < $length) {
            $password .= $char;
        }
    }

    return $password;
}

function registerUser($username, $email, $password = null) {
    $FakeMailDomains = "/\b(?:armyspy\.com|cuvox\.de|dayrep\.com|einrot\.com|
    fleckens\.hu|gustr\.com|jourrapide\.com|rhyta\.com|superrito\.com|
    teleworm\.us|mp-j\.cf|mp-j\.gq|hangxomcuatoilatotoro\.cf|musicmakes\.us|
    sikomo\.cf|moonm\.review|udoiswell\.pw|yaraon\.ga|gmxmail\.top|kwalidd\.cf|
    mahiidev\.site|hamusoku\.tk|hamusoku\.ga|reservelp\.de|kucingarong\.gq|
    zhorachu\.com|ethersports\.org|tinoza\.org|payperex2\.com|nezdiro\.org|
    ether123\.net|reftoken\.net|averdov\.com|axsup\.net|datum2\.com|
    geronra\.com|asorent\.com|ether123\.net|ququb\.com|2anom\.com|qwfox\.com|
    hvzoi\.com|fakeinbox\.info|trash-mail\.com|you-spam\.com|re-gister\.com|
    fake-box\.com|trash-me\.com|opentrash\.com|dropmail\.me|emlhub\.com|
    emltmp\.com|emlpro\.com|yomail\.info|10mail\.org|mvrht\.net|kopqi\.com|
    fxe\.us|gicua\.com|20mail\.eu|10minutemail\.co\.uk|vmani\.com|wimsg\.com|
    my10minutemail\.com|10minutesmail\.fr|10minutemail\.pro|10minutemailbox\.com|
    10minutemail\.be|guerrillamail\.biz|sharklasers\.com|guerrillamail\.info|
    grr\.la|guerrillamail\.com|guerrillamail\.de|guerrillamail\.net|
    guerrillamail\.org|guerrillamailblock\.com|pokemail\.net|spam4\.me|
    10minutemail\.nl|10minute-email\.com)\b/i";


        // Provjera korisničkog imena
        if (!preg_match('/^[\p{L}\p{N}]+$/u', $username)) {
            throw new RegistrationException("Korisničko ime može sadržavati samo slova i znamenke.");
        }
    
        // Provjera e-mail adrese
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$email) {
            throw new RegistrationException("Unesena e-mail adresa nije ispravna.");
        }
    
        // Provjera da li e-mail adresa sadrži neku od lažnih domena
        $emailDomain = substr(strrchr($email, "@"), 1);
        if (preg_match($FakeMailDomains, $emailDomain)) {
            $password = generatePassword();
            throw new RegistrationException("Molim unesite drugu e-mail adresu, ovu ne podržavamo.");
        }
    
        // Generiranje lozinke ako nije proslijeđena
        if ($password === null) {
            $password = generatePassword();
        }
    
        // Provjera lozinke
        // 1. Provjera minimalne duljine lozinke
        if (strlen($password) < 10) {
            throw new RegistrationException("Lozinka mora sadržavati najmanje 10 znakova.");
        }
    
        // 2. Provjera postojanja barem jednog malog slova
        if (!preg_match('/[a-zčćđšž]/u', $password)) {
            throw new RegistrationException("Lozinka mora sadržavati barem jedno malo slovo.");
        }
    
        // 3. Provjera postojanja barem jednog velikog slova
        if (!preg_match('/[A-ZČĆĐŠŽ]/', $password)) {
            throw new RegistrationException("Lozinka mora sadržavati barem jedno veliko slovo.");
        }
    
        // 4. Provjera postojanja barem jedne znamenke
        if (!preg_match('/\d/', $password)) {
            throw new RegistrationException("Lozinka mora sadržavati barem jednu znamenku.");
        }
    
        // 5. Provjera postojanja barem jednog posebnog znaka
        if (!preg_match('/[@$€!%#*+\-?&]/', $password)) {
            throw new RegistrationException("Lozinka mora sadržavati barem jedan poseban znak.");
        }
    
        // Provjera da li korisnik već postoji
        //$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
        //$stmt->bindParam(':username', $username);
        //$stmt->bindParam(':email', $email);
        //$stmt->execute();
        //if ($stmt->fetchColumn() > 0) {
        //    throw new RegistrationException("Korisnik s ovim korisničkim imenom ili e-mail adresom već postoji.");
        //}
    
        // Spremanje korisnika u bazu podataka
        //$stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        //$stmt->bindParam(':username', $username);
        //$stmt->bindParam(':email', $email);
        //$stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        //$stmt->execute();
    
        // Slanje e-maila za potvrdu registracije
        sendConfirmationEmail($email, $password);
    
        // Vraćanje ID-a novog korisnika
        //return $pdo->lastInsertId();
    }
    
    function sendConfirmationEmail($email, $password) {
        // Kod za slanje e-maila s generiranom lozinkom
        echo "Generirana lozinka je spremljena. "; // to je $password
    }

// Provjera da li je forma poslana
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'] ?? null;
    $captcha_code = $_POST['captcha_code'];

    // Provjera Lemin Captcha
    if (isset($_SESSION['captcha_code']) && $_SESSION['captcha_code'] === $captcha_code) {
        try {
            $newUserId = registerUser($username, $email, $password);
            echo "Uspješno ste se registrirali kao budući korisnik.";
        } catch (RegistrationException $e) {
            $usernameValue = htmlspecialchars($username);
            $emailValue = htmlspecialchars($email);
            $passwordValue = $password !== null ? $password : generatePassword();
            echo "Greška kod registracije: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "Neispravan Lemin Captcha kod.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registracija korisnika</title>
</head>
<body>
    <h1>Registracija korisnika</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Korisničko ime: <input type="text" name="username" id="username" value="<?php echo $usernameValue ?? ''; ?>" required><br><br>
        E-mail: <input type="email" name="email" id="email" value="<?php echo $emailValue ?? ''; ?>" required><br><br>
        Lozinka: <input type="password" name="password" id="password" value="<?php echo $passwordValue ?? generatePassword(); ?>" required>
        <input type="checkbox" onclick="togglePasswordVisibility()"> Prikaži lozinku<br><br>
        Lemin Captcha: <img src="leminCaptcha.php" alt="Lemin Captcha"><br>
        <input type="text" name="captcha_code" id="captcha_code" required><br><br>
        <input type="submit" name="submit" value="Pošalji">
    </form>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</body>
</html>