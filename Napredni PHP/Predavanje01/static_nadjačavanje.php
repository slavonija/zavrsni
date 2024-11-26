<?php
    Class OsnovnaKlasa 
    {
        // Statička funkcija, čim je static nema instance
        public static function getStaticText()
        {
            return 'Pozvano iz OsnovnaKlasa';
        }

        public static function getStaticRezultat()
        {
            // alternativno možemo koristiti OsnovnaKlasa::getStaticText();
            // return self::getStaticText();// "Pozvano iz OsnovnaKlasa", neće raditi ako getStaticText nije u OsnovnaKlasa
             return static::getStaticText(); // Nadjačana metoda. "Pozvano iz IzvedenaKlasa"

        }
    }

    Class IzvedenaKlasa extends OsnovnaKlasa
    {
        public static function getStaticText()
        // 
        {    
            return 'Pozvano iz IzvedenaKlasa';
        }
    }

    var_dump(IzvedenaKlasa::getStaticRezultat());

?>