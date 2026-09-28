<?php

function quantidadeConsultas($consulta)
{

    $quantidadeConsultas = count($consulta);

    return $quantidadeConsultas;

}

function pacientesDiferentes($consulta)
{

    $pacientes = array();

    for ($i = 0; $i < count($consulta); $i++) {
        $pacientes[] = strtolower($consulta[$i]["nome paciente"]);
    }

    $pacientes = array_unique($pacientes);

    $quantidade = count($pacientes);

    return $quantidade;
}

function quantidadeConsultasEspecialidade($consulta)
{

    $quantidadeConsultas = quantidadeConsultas($consulta);
    $especialidades = array();

    for ($i = 0; $i < $quantidadeConsultas; $i++) {

        $especialidade = strtolower($consulta[$i]["especialidade"]);

        if (!in_array($especialidade, $especialidades)) {
            $especialidades[] = $especialidade;
        }
    }

    $dados = array();

    for ($i = 0; $i < count($especialidades); $i++) {

        $quantidade = 0;

        for ($j = 0; $j < $quantidadeConsultas; $j++) {

            if ($especialidades[$i] == strtolower($consulta[$j]["especialidade"])) {
                $quantidade++;
            }
        }

        $dados[] = array(
            "especialidade" => $especialidades[$i],
            "quantidade" => $quantidade
        );
    }

    return $dados;
}

function primeiroAtendimento($consulta)
{

    $quantidadeConsultas = quantidadeConsultas($consulta);

    $primeiroAtendimento = $consulta[0]["horario"];

    for ($i = 1; $i < $quantidadeConsultas; $i++) {

        if (str_replace(":", "", $consulta[$i]["horario"]) < str_replace(":", "", $primeiroAtendimento)) {

            $primeiroAtendimento = $consulta[$i]["horario"];
        }
    }

    return $primeiroAtendimento;
}

function ultimoAtendimento($consulta)
{

    $quantidadeConsultas = quantidadeConsultas($consulta);

    $ultimoAtendimento = $consulta[0]["horario"];

    for ($i = 1; $i < $quantidadeConsultas; $i++) {

        if (str_replace(":", "", $consulta[$i]["horario"]) > str_replace(":", "", $ultimoAtendimento)) {

            $ultimoAtendimento = $consulta[$i]["horario"];
        }
    }

    return $ultimoAtendimento;

}

function ordenarAgenda($consulta)
{

    $quantidadeConsultas = quantidadeConsultas($consulta);

    for ($j = 0; $j < $quantidadeConsultas - 1; $j++) {

        for ($i = 0; $i < $quantidadeConsultas - 1; $i++) {

            if (str_replace(":", "", $consulta[$i]["horario"]) > str_replace(":", "", $consulta[$i + 1]["horario"])) {

                $temp = $consulta[$i];

                $consulta[$i] = $consulta[$i + 1];

                $consulta[$i + 1] = $temp;
            }
        }
    }

    return $consulta;
}

function pesquisa($consulta, $paciente)
{

    $quantidadeConsultas = quantidadeConsultas($consulta);

    $paciente = strtolower($paciente);

    $consultaPaciente = array();

    for ($i = 0; $i < $quantidadeConsultas; $i++) {

        if ($paciente == strtolower($consulta[$i]["nome paciente"])) {

            $consultaPaciente[] = $consulta[$i];
        }
    }

    return $consultaPaciente;
}


function verificarHorario($consulta)
{

    $verificador = $consulta[0]["horario"];

    $verificador = str_replace(":", "", $verificador);

    $quantidadeConsultas = quantidadeConsultas($consulta);

    for ($i = 0; $i < $quantidadeConsultas - 1; $i++) {
        if ($consulta[$i]["horario"] == $consulta[$i + 1]["horario"]) {
            return "Existem consultas em horários iguais!";
        }
    }

    return "Não existem consultas em horários iguais!";
}

function organizarAgenda($agenda, $paciente)
{

    return [
        "quantidade consultas" => quantidadeConsultas($agenda),
        "pacientes diferentes" => pacientesDiferentes($agenda),
        "especialidades" => quantidadeConsultasEspecialidade($agenda),
        "primeiro atendimento" => primeiroAtendimento($agenda),
        "ultimo atendimento" => ultimoAtendimento($agenda),
        "ordenar agenda" => ordenarAgenda($agenda),
        "pesquisa" => pesquisa($agenda, $paciente),
        "verificar horario" => verificarHorario($agenda)
    ];

}


$agenda = array(
    ["nome paciente" => "Henrique", "especialidade" => "Ortopedista", "data" => "17/09/2026", "horario" => "10:20"],
    ["nome paciente" => "Thaís", "especialidade" => "Otorrinolaringologista", "data" => "17/09/2026", "horario" => "17:50"],
    ["nome paciente" => "Serenna", "especialidade" => "Cardiologista", "data" => "17/09/2026", "horario" => "12:10"],
    ["nome paciente" => "Annie", "especialidade" => "Nutricionista", "data" => "17/09/2026", "horario" => "09:30"],
    ["nome paciente" => "Annie", "especialidade" => "Cardiologista", "data" => "17/09/2026", "horario" => "12:30"]
);

$paciente = "Henrique";

$resultado = organizarAgenda($agenda, $paciente);

echo "Quantidade de consultas: " . $resultado["quantidade consultas"] . "<br>";
echo "<br>";
echo "Quantidade de pacientes diferentes: " . $resultado["pacientes diferentes"] . "<br>";
echo "<br>";
echo "Primeiro atendimento do dia: " . $resultado["primeiro atendimento"] . "<br>";
echo "<br>";
echo "Último atendimento do dia: " . $resultado["ultimo atendimento"] . "<br>";
echo "<br>";
echo "Pesquisa por paciente: ";
echo "<table>";
echo "<tr>";
echo "<th>Paciente</th>";
echo "<th>Especialidade</th>";
echo "<th>Data</th>";
echo "<th>Horário</th>";
echo "</tr>";
foreach ($resultado["pesquisa"] as $paciente) {
    echo "<tr>";
    echo "<td>" . $paciente["nome paciente"] . "</td>";
    echo "<td>" . $paciente["especialidade"] . "</td>";
    echo "<td>" . $paciente["data"] . "</td>";
    echo "<td>" . $paciente["horario"] . "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";
echo "Consultas ordenadas: ";
echo "<table>";
echo "<tr>";
echo "<th>Paciente</th>";
echo "<th>Especialidade</th>";
echo "<th>Data</th>";
echo "<th>Horário</th>";
echo "</tr>";
foreach ($resultado["ordenar agenda"] as $consulta) {
    echo "<tr>";
    echo "<td>" . $consulta["nome paciente"] . "</td>";
    echo "<td>" . $consulta["especialidade"] . "</td>";
    echo "<td>" . $consulta["data"] . "</td>";
    echo "<td>" . $consulta["horario"] . "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";
echo "Consultas por especialidades: ";
echo "<table>";
echo "<tr>";
echo "<th>Especialidade</th>";
echo "<th>Quantidade</th>";
echo "</tr>";
foreach ($resultado["especialidades"] as $consulta) {
    echo "<tr>";
    echo "<td>" . $consulta["especialidade"] . "</td>";
    echo "<td>" . $consulta["quantidade"] . "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>" . $resultado["verificar horario"];
?>