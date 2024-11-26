<?php

// int|string
//42    --> 42          // točan tip
//"42"  --> "42"        // točan tip
new ObjectWithToString --> "Rezultat  __toString()"
                      // object nikada nije kompatiblian s int, vrati na string
42.0  --> 42          // float kompatibilno s int
42.1  --> 42          // float kompatibilno s int
1e100 --> "1.0E+100"  // float prevelik za int type, povlačenje ka to string
INF   --> "INF"       // float prevelik za int type, povlačenje ka to string
true  --> 1           // bool kompatibilno s int
[]    --> TypeError   // array nije kompatibilan s int ili string

// int|float|bool
"45"    --> 45        // int numeric string
"45.0"  --> 45.0      // float numeric string

"45X"   --> true      // not numeric string, povlačenje ka to bool
""      --> false     // not numeric string, povlačenje ka to bool
"X"     --> true      // not numeric string, povlačenje ka to bool
[]      --> TypeError // array not kompatibilno s int, float or bool

?>