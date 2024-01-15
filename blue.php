<?php

echo "Hola Php desde 0 \n";

echo "Strings Variables tipo Texto: ". "\n";

$pepe = "Cadena de texto \n";

echo gettype ($pepe).  "\n";

echo $pepe;

echo "Int: ". "\n";


$tilin = 6;

echo $tilin . "\n";

echo gettype($tilin) . "\n";

echo "Entero: ". "\n";


$entero = 4;

echo $entero . "\n";

echo $entero + $tilin;

echo gettype ($entero);

echo "Decimal: ". "\n";

$decimal = 9.2;
echo $decimal;

echo $decimal + $tilin + $entero . "\n";

$bool = true;

echo  $bool . "\n";

$lol = $decimal + $tilin. "\n";

echo "el resultado de estos datos es : $tilin + $decimal : "    . +$lol, "\n" ;

echo "Constantes : ". "\n";


//Constantes 

const kiki = "Hola este es un valor constante" . "\n";

echo kiki . "\n";

// Listas 

echo "Listas: ". "\n";


$array = [$tilin, $decimal, $entero, $bool];

echo gettype ($array) . "\n";

echo $array[0] . "\n";
echo $array[3] . "\n";

array_push( $array, $lol). "\n";


print_r($array). "\n";

echo "Diccionario: ". "\n";

// Diccionario  


$dic = array( "eppepepe" => $pepe, "ddfdfdf" => $lol, "fdffdfdf" => $bool);

print_r($dic);

// set  


$array = [$tilin, $decimal, $entero, $bool];

echo gettype ($array) . "\n";

echo $array[0] . "\n";
echo $array[3] . "\n";

array_push( $array, $lol). "\n";
array_push( $array, $tilin). "\n";
array_push( $array, $tilin). "\n";
print_r (array_unique($array));

//Flujos  de Datos ForEach

for ($index = 1; $index <= 5; $index ++ ) {
    echo $index . "\n";
}

// for each que lea los datos 
echo "ForEach" . "\n";

foreach ($array as $data )

echo $data . "\n";

echo "Bucle While" . "\n";

// while Bucle  
$index = 0;
while ($index <= sizeof($array) -1 ) {
    echo $array[$index] ."\n";
    $index++;

}


// Estructuras de Control 
$entero = 60;
$tilin = "ola";

if ($entero == 60 && $tilin == "ola")  {
    echo "el numero es menor que 30 : $entero y el string es : $tilin  \n"; 
}

    elseif  ($entero == 60 && $tilin == "ola" ) {
        echo " Felicidades el dato es $entero \n";
    }


 else  {
    echo "el numero no es mayor  que 30 y  el numero es $entero \n" ;
} 

// Funciones 

function letters() {
    echo "A B C D E F " . "\n";
}

letters();

// Clases 

Class MyClass  {
public $name; 
public $age;  
public $id; 

function __construct($name, $age, $id)
{
    $this->name = $name;
    $this->age = $age;
    $this->id = $id;


}
}

$miclase =  new MyClass("Andres", 17, 1);
print_r($miclase);

