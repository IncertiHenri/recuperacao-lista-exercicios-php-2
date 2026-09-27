<?php

function contarMaiusculas($senha)
{
    $contador = 0;
    $maiusculas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    $tamanho = strlen($senha);
    $separar = preg_split("//u", $senha, -1, PREG_SPLIT_NO_EMPTY);

    for ($i = 0; $i < $tamanho; $i++) {
        if (in_array($separar[$i], $maiusculas)) {
            $contador++;
        }
    }
    return $contador;
}
function contarMinusculas($senha)
{
    $contador = 0;
    $minusculas = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
    $tamanho = strlen($senha);
    $separar = preg_split("//u", $senha, -1, PREG_SPLIT_NO_EMPTY);

    for ($i = 0; $i < $tamanho; $i++) {
        if (in_array($separar[$i], $minusculas)) {
            $contador++;
        }
    }
    return $contador;
}

function contarNumeros($senha)
{
    $contador = 0;
    $numeros = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $tamanho = strlen($senha);
    $separar = preg_split("//u", $senha, -1, PREG_SPLIT_NO_EMPTY);

    for ($i = 0; $i < $tamanho; $i++) {
        if (in_array($separar[$i], $numeros)) {
            $contador++;
        }
    }
    return $contador;
}

function contarEspeciais($senha)
{
    $contador = 0;
    $especiais = array("!", "@", "#", "$", "%", "&");
    $tamanho = strlen($senha);
    $separar = preg_split("//u", $senha, -1, PREG_SPLIT_NO_EMPTY);

    for ($i = 0; $i < $tamanho; $i++) {
        if (in_array($separar[$i], $especiais)) {
            $contador++;
        }
    }
    return $contador;
}

function verificarSeguranca($senha){
    $maiusculas = contarMaiusculas($senha);
    $minusculas = contarMinusculas($senha);
    $numeros = contarNumeros($senha);
    $especiais = contarEspeciais($senha);

    if($maiusculas == 1 && $minusculas == 5 && $numeros == 1 && $especiais == 1){
        return "senha fraca";
    } else if($maiusculas == 2 && $minusculas == 0 && $numeros == 3 && $especiais == 3){
        return "senha forte";
    } else if($maiusculas == 0 && $minusculas == 0 && $numeros == 0 && $especiais == 8){
        return "senha muito forte";
    } else {
        return "senha média";
    }
}

function analisarSenha($senha)
{
    $tamanhoSenha = strlen($senha);
    $minusculas = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
    $maiusculas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    $numeros = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $especiais = array("!", "@", "#", "$", "%", "&");

    if (strlen($senha) < 8) {
        echo "Tamanho inválido, é necessário ter no mínimo 8 caracteres";
        return exit;
    } else {
        if (contarMinusculas($senha) == 0) {
            echo "Letras inválidas, é necessário ter no mínimo uma letra minúsculas";
            return exit;
        } else {
            if (contarMaiusculas($senha) == 0) {
                echo "Letras inválidas, é necessário ter no mínimo uma letra maiúsculas";
                return exit;
            } else {
                if (contarNumeros($senha) == 0) {
                    echo "Números inválidos, é necessário ter no mínimo um número";
                    return exit;
                } else {
                    if (contarEspeciais($senha) == 0) {
                        echo "Caracteres inválidos, é necessário ter no mínimo um caracter especial";
                        return exit;
                    } else {

                        return [
                            "quantidade maiusculas" => contarMaiusculas($senha),
                            "quantidade minusculas" => contarMinusculas($senha),
                            "quantidade numeros" => contarNumeros($senha),
                            "quantidade especiais" => contarEspeciais($senha),
                            "tamanho senha" => $tamanhoSenha,
                            "seguranca" => verificarSeguranca($senha)

                        ];



                    }
                }
            }
        }
    }
}

$senha = "O@iiii441";

$resultado = analisarSenha($senha);

echo "Quantidade de letras maiúsculas: " . $resultado["quantidade maiusculas"] . "<br>";
echo "Quantidade de letras minúsculas: " . $resultado["quantidade minusculas"] . "<br>";
echo "Quantidade de números: " . $resultado["quantidade numeros"] . "<br>";
echo "Quantidade de caracteres especiais: " . $resultado["quantidade especiais"] . "<br>";
echo "Tamanho da senha: " . $resultado["tamanho senha"] . "<br>";
echo "Nível de segurança: " . $resultado["seguranca"];

?>