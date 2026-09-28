<?php

function quantidadeCaracteres($texto)
{

    $caracteres = preg_split("//u", $texto, -1, PREG_SPLIT_NO_EMPTY);

    $quantidade = count($caracteres);

    return $quantidade;

}

function quantidadePalavras($texto)
{

    $quantidade = str_word_count($texto);

    return $quantidade;

}

function quantidadeFrases($texto)
{

    $quantidade = preg_split('/[,.?!]+/', $texto, -1, PREG_SPLIT_NO_EMPTY);

    $tamanho = count($quantidade);

    return $tamanho;

}

function limparSepararDiminuirTexto($texto)
{

    $palavras = explode(" ", $texto);
    $quantidade = count($palavras);

    for ($i = 0; $i < $quantidade; $i++) {

        $limpo = preg_replace('/[^\p{L}0-9]/u', '', $palavras[$i]);

        $baixo[$i] = mb_strtolower($limpo, 'UTF-8');

    }

    return $baixo;
}

function palavraLonga($texto)
{

    $tamanho = quantidadePalavras($texto);

    $palavras = limparSepararDiminuirTexto($texto);

    $maiorPalavra = $palavras[0];

    for ($i = 0; $i < $tamanho; $i++) {
        if (mb_strlen($maiorPalavra) < mb_strlen($palavras[$i])) {
            $maiorPalavra = $palavras[$i];
        }
    }

    return $maiorPalavra;

}

function palavraCurta($texto)
{

    $tamanho = quantidadePalavras($texto);
    $palavras = limparSepararDiminuirTexto($texto);

    $menorPalavra = $palavras[0];

    for ($i = 0; $i < $tamanho; $i++) {

        if (mb_strlen($menorPalavra) > mb_strlen($palavras[$i])) {

            $menorPalavra = $palavras[$i];

        }
    }

    return $menorPalavra;
}

function tirarEspacos($texto)
{

    $arrumado = preg_replace('/\s+/', ' ', $texto);

    return $arrumado;
}

function formatarTexto($texto)
{

    $formatado = ucwords($texto);

    return $formatado;

}

function quantidadeRepetidas($texto)
{

    $texto = limparSepararDiminuirTexto($texto);

    $contagem = array_count_values($texto);

    $maior = 0;

    foreach ($contagem as $palavra => $quantidade) {

        if ($quantidade > $maior) {
            $maior = $quantidade;
            $maiorPalavra = $palavra;
        }

    }

    return [
        "palavra repetida" => $maiorPalavra,
        "quantidade" => $maior
    ];
}

function maisRepetidas($texto)
{

    $texto = limparSepararDiminuirTexto($texto);

    $contagem = array_count_values($texto);

    $palavras = [];
    $quantidades = [];

    $i = 0;

    foreach ($contagem as $palavra => $quantidade) {

        $palavras[$i] = $palavra;
        $quantidades[$i] = $quantidade;

        $i++;
    }

    $tamanho = count($palavras);

    for ($j = 0; $j < $tamanho - 1; $j++) {

        for ($i = 0; $i < $tamanho - 1; $i++) {

            if ($quantidades[$i] < $quantidades[$i + 1]) {

                $temp = $quantidades[$i];
                $temp2 = $palavras[$i];

                $quantidades[$i] = $quantidades[$i + 1];
                $palavras[$i] = $palavras[$i + 1];

                $quantidades[$i + 1] = $temp;
                $palavras[$i + 1] = $temp2;
            }
        }
    }

    return [
        "primeira palavra" => $palavras[0],
        "quantidade primeira palavra" => $quantidades[0],

        "segunda palavra" => $palavras[1],
        "quantidade segunda palavra" => $quantidades[1],

        "terceira palavra" => $palavras[2],
        "quantidade terceira palavra" => $quantidades[2],

        "quarta palavra" => $palavras[3],
        "quantidade quarta palavra" => $quantidades[3],

        "quinta palavra" => $palavras[4],
        "quantidade quinta palavra" => $quantidades[4]
    ];
}

function processarTexto($texto)
{

    $caracteres = quantidadeCaracteres($texto);

    $palavras = quantidadePalavras($texto);

    $frases = quantidadeFrases($texto);

    $longa = palavraLonga($texto);

    $curta = palavraCurta($texto);

    $semEspacos = tirarEspacos($texto);

    $formatado = formatarTexto($texto);

    $maisRepetida = quantidadeRepetidas($texto);

    $cincoRepetidas = maisRepetidas($texto);

    return [
        "quantidade caracteres" => $caracteres,
        "quantidade palavras" => $palavras,
        "quantidade frases" => $frases,
        "palavra longa" => $longa,
        "palavra curta" => $curta,
        "sem espacos duplicados" => $semEspacos,
        "formatado" => $formatado,
        "palavra mais repetida" => $maisRepetida,
        "mais repetidas" => $cincoRepetidas,
    ];

}

$texto = "Meu Deus meu senhor, me ajuda por favor! É na escola, no trabalho, na faculdade, só fico nesse";

$resultado = processarTexto($texto);

echo "Quantidade de caracteres: " . $resultado["quantidade caracteres"] . "<br>";
echo "Quantidade de palavras: " . $resultado["quantidade palavras"] . "<br>";
echo "Quantidade de frases: " . $resultado["quantidade frases"] . "<br>";
echo "Palavra mais longa: " . $resultado["palavra longa"] . "<br>";
echo "Palavra mais curta: " . $resultado["palavra curta"] . "<br>";
echo "Texto formatado: " . $resultado["formatado"] . "<br>";
echo "Palavra que mais se repete: ";
echo "<table>";
echo "<tr>";
echo "<th>Palavra</th>";
echo "<th>Vezes</th>";
echo "<tr>";
echo "<td>" . $resultado["palavra mais repetida"]["palavra repetida"] . "</td>";
echo "<td>" . $resultado["palavra mais repetida"]["quantidade"] . "</td>";
echo "</tr>";
echo "</table>";
echo "Cinco palavra que mais se repetem: ";
echo "<table>";
echo "<tr>";
echo "<th>Palavras</th>";
echo "<th>Vezes</th>";
echo "</tr>";
echo "<tr>";
echo "<td>" . $resultado["mais repetidas"]["primeira palavra"] . "</td>";
echo "<td>" . $resultado["mais repetidas"]["quantidade primeira palavra"] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>" . $resultado["mais repetidas"]["segunda palavra"] . "</td>";
echo "<td>" . $resultado["mais repetidas"]["quantidade segunda palavra"] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>" . $resultado["mais repetidas"]["terceira palavra"] . "</td>";
echo "<td>" . $resultado["mais repetidas"]["quantidade terceira palavra"] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>" . $resultado["mais repetidas"]["quarta palavra"] . "</td>";
echo "<td>" . $resultado["mais repetidas"]["quantidade quarta palavra"] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>" . $resultado["mais repetidas"]["quinta palavra"] . "</td>";
echo "<td>" . $resultado["mais repetidas"]["quantidade quinta palavra"] . "</td>";
echo "</tr>";
echo "</table>";


?>