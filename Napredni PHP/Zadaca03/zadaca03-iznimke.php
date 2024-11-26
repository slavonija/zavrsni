<?php
/*
* Napisati PHP skriptu koja obrađuje registraciju korisnika na web stranici.
* Registracija zahtijeva unos korisničkog imena, e-maila i lozinke. Program
* treba osigurati da korisničko ime sadrži samo alfanumeričke znakove i da
* je e-mail adresa valjana. Ako korisničko ime ili e-mail nisu valjani,
* treba baciti iznimku. Ako su podaci valjani, treba ispisati poruku o
* uspješnoj registraciji.
*/

class RegistrationException extends Exception {}

function registerUser($username, $email, $password) {
    // Provjera korisničkog imena
    // if (!preg_match('/^[\p{L}\p{N}čćđšžČĆĐŠŽ]+$/u', $username)) { // ako želimo naša slova
    if (!preg_match('/^[\p{L}\p{N}]+$/u', $username)) {
        throw new RegistrationException("Korisničko ime može sadržavati samo slova i znamenke.");
    }

    // Provjera lozinke
    $passwordErrors = [];
    if (!preg_match('/[a-z]/', $password)) {
        $passwordErrors[] = "barem jedno malo slovo";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $passwordErrors[] = "barem jedno veliko slovo";
    }
    if (!preg_match('/\d/', $password)) {
        $passwordErrors[] = "barem jednu znamenku";
    }
    if (!preg_match('/[@$€!#%*?&]/', $password)) {
        $passwordErrors[] = "barem jedan poseban znak";
    }
    if (strlen($password) < 10) {
        $passwordErrors[] = "najmanje 10 znakova";
    }
    if (!empty($passwordErrors)) {
        throw new RegistrationException("Greška kod unosa korisnika " . $username . ": Lozinka nije ispravna. Izmjenite je jer lozinka mora sadržavati " . implode(", ", $passwordErrors) . ".\n");
    }

    // Provjera e-mail adrese
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new RegistrationException("Greška kod unosa e-maila " . $email . ": Unesena e-mail adresa nije ispravna.");
    }

    // Ovdje bismo trebali spremiti korisnika u bazu podataka
    echo "Uspješna registracija korisnika: " . $username . " (" . $email . ")". "\n";
}

// Ovaj radi

try {
    registerUser("PetarPetrović", "petar.petrovic@algebra.net", "MojaŠifr@123");
} catch (RegistrationException $e) {
    echo $e->getMessage();
}

// Neispravna šifra
try {
    registerUser("branko123", "branko@primjer.com", "Popokatepetl23");
} catch (RegistrationException $e) {
    echo $e->getMessage();
}


// Neispravan mail i šifra
try {
    registerUser("dinko999", "dinkoprimjer.com", "dinkodinko");
} catch (RegistrationException $e) {
    echo $e->getMessage();
}

// Neispravan mail
try {
    registerUser("dariok", "dariokprimjer.com", "darioK#123");
} catch (RegistrationException $e) {
    echo $e->getMessage();
}
