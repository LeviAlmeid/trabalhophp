<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta</title>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/estilo.css">


</head>

<body>
    <div class="container">

        <br>
        <button> <a href="javascript: history.back()">Voltar </a> </button>
        <h2>
            <center>CONSULTA</center>
        </h2>

        <form action="consultanome.php" method="GET" onSubmit="selecao(this); return false;">
            <div class="form-group">
                <label for="funcionario">Por funcionário:</label>
                <select class="form-control w-50" id="nome" name="nome" placeholder="Funcionario Mês:">
                    <?php

                    $conn = new mysqli("localhost", "root", "", "dbempresa");


                    if ($conn->connect_error) {
                        die("Conexão falhou: " . $conn->connect_error);
                    }


                    $sql = "SELECT nome FROM tbfuncmes";
                    $result = $conn->query($sql);



                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['nome'] . "'>" . $row['nome'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhum funcionário encontrado</option>";
                    }
                    $conn->close();
                    ?>
                </select>
            </div>

            <button class="btn btn-primary btn-sm" type="submit">Consulta Funcionário</button>
            <br><br>

        </form>
        <form action="consultamesano.php" method="GET" onSubmit="selecao2(this); return false;">
            <div class="form-group">
                <label for="mes">Mês:</label>
                <select class="form-control w-50" id="mes" name="mes" >
                <option value="Escolha um Mes">
                                <<< Escolha um Mes>>>
                            </option>
                    <option value="January">Janeiro</option>
                    <option value="February">Fevereiro</option>
                    <option value="March">Março</option>
                    <option value="April">Abril</option>
                    <option value="May">Maio</option>
                    <option value="June">Junho</option>
                    <option value="July">Julho</option>
                    <option value="August">Agosto</option>
                    <option value="September">Setembro</option>
                    <option value="October">Outubro</option>
                    <option value="November">Novembro</option>
                    <option value="December">Dezembro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ano">Ano:</label>
                <select class="form-control w-50" id="ano" name="ano">
                <option value="Escolha um Ano">
                                <<< Escolha um Ano>>>
                            </option>
                </select>
            </div>


            <button class="btn btn-primary btn-sm" type="submit">Consulta Mês/Ano</button>

        </form>
    </div>
</body>

<script>
                const anoSelect = document.getElementById('ano');
                for (let ano = 2020; ano <= 2030; ano++) {
                    const option = document.createElement('option');
                    option.value = ano;
                    option.textContent = ano;
                    anoSelect.appendChild(option);
                };

                function selecao2(frm) {
                    var mes = document.getElementById("mes").value;
                    var ano = document.getElementById("ano").value;


                    if (mes == "Escolha um Mes") {
                        alert('Escolha um Mes');
                        document.getElementById("mes").focus();
                        return false;
                    }
                    else if (ano == "Escolha um Ano") {
                        alert('Escolha um Ano');
                        document.getElementById("ano").focus();
                        return false;
                    }
                    frm.submit();
                }

                function selecao(frm) {
                    var func = document.getElementById("nome").value;


                    if (func == "Escolha um Funcionário") {
                        alert('Escolha o Funcionário');
                        document.getElementById("func").focus();
                        return false;
                    }
                    frm.submit();
                }

            </script>

</html>