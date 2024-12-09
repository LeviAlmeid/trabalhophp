<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário do Mês</title>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/estilo.css">

    <script>
        function Carrega(campo) {
            if (campo.files && campo.files[0]) {
                var file = new FileReader();
                file.onload = function (e) {
                    document.getElementById("ganhador").src = e.target.result;
                };
                file.readAsDataURL(campo.files[0]);
            }
        }

        function selecao(frm) {
            var func = document.getElementById("func").value;
            var valor = document.getElementById("valor").value;

            if (func == "Escolha um Funcionário") {
                alert('Escolha o Funcionário');
                document.getElementById("func").focus();
                return false;
            }
            if (valor == "") {
                alert('Escolha o valor');
                return false;
            }

            frm.submit();
        }

        function mascara(o, f) {
            v_obj = o
            v_fun = f
            setTimeout("execmascara()", 1)
        }

        function execmascara() {
            v_obj.value = v_fun(v_obj.value)
        }

        function moeda(v) {
            v = v.replace(/\D/g, ""); // permite digitar apenas numero
            v = v.replace(/(\d{1})(\d{1,2})$/, "$1.$2"); // coloca virgula antes dos ultimos 2 digitos
            return v;
        }

        function carregarDadosFuncionario() {
            const mes = document.getElementById("mes").value;
            const ano = document.getElementById("ano").value;

            if (mes && ano) {
                fetch('get_funcionario.php?mes=' + mes + '&ano=' + ano)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.nome) {
                            document.getElementById('func').value = data.nome;
                            document.getElementById('valor').value = data.vrvenda;
                            document.getElementById('ganhador').src = data.caminhoimg; // Supondo que a URL da foto esteja no campo 'caminhoimg'
                            document.getElementById('fotoContainer').style.display = 'block'; // Mostra o container da foto e valor
                            document.getElementById('enviar').disabled = false; // Habilita o botão de editar
                        } else {
                            // Se não houver dados, limpa os campos e desabilita o botão
                            document.getElementById('func').value = "Escolha um Funcionário";
                            document.getElementById('valor').value = '';
                            document.getElementById('ganhador').src = 'img/moldura.png'; // Imagem padrão
                            document.getElementById('fotoContainer').style.display = 'none'; // Esconde o container da foto e valor
                            document.getElementById('enviar').disabled = true; // Desabilita o botão de editar
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    });
            } else {
                document.getElementById('func').value = "Escolha um Funcionário";
                document.getElementById('valor').value = '';
                document.getElementById('ganhador').src = 'img/moldura.png'; // Imagem padrão
                document.getElementById('fotoContainer').style.display = 'none'; // Esconde o container da foto e valor
                document.getElementById('enviar').disabled = true; // Desabilita o botão de editar
            }
        }
    </script>

</head>

<body>
    <div class="container">
        <br>
        <button><a href="javascript: history.back()">Voltar</a></button>
        <h2>EDITAR FUNCIONÁRIO DO MÊS</h2>
        <br>

        <form method="POST" id="form1" name="form1" action="editar_ganhador.php" enctype="multipart/form-data"
            onSubmit="selecao(this); return false;">

            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <center>
                        <img src="img/moldura.png" name="ganhador" id="ganhador" class="img-fluid" alt="Ganhador"
                            width="60%" height="60%">
                        <br>
                        <div class="file-field input-field col s8" id="fotoContainer" style="display: none;">
                            <div class="btn btn-primary btn-sm">
                                <input type="file" name="foto" id="foto" accept=".png,.jpg" class="form-control"
                                    onchange="Carrega(this)">
                            </div>
                        </div>
                    </center>
                    <br>
                </div>

                <div class="col-lg-7 mx-auto">
                    <div class="form-group">
                        <b>Escolha o Mês:</b>
                        <select class="form-control w-50" id="mes" name="mes" required="required"
                            onchange="carregarDadosFuncionario()">
                            <option value="">
                                <<< Escolha um Mês>>>
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
                        <br><br>

                        <b>Escolha o Ano:</b>
                        <select class="form-control w-50" id="ano" name="ano" required="required"
                            onchange="carregarDadosFuncionario()">
                            <option value="">
                                <<< Escolha um Ano>>>
                            </option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>
                        <br><br>

                        <b>Escolha o Funcionário do Mês:</b>
                        <select class="form-control w-50" id="func" name="func" required="required">
                            <option value="Escolha um Funcionário">
                                <<< Escolha um Funcionário>>>
                            </option>
                            <option value="Ana Andrade">Ana Andrade</option>
                            <option value="Bruna Costa">Bruna Costa</option>
                            <option value="Carlos Montreal">Carlos Montreal</option>
                            <option value="João Freitas">João Freitas</option>
                            <option value="Paulo Santos">Paulo Santos</option>
                            <option value="Rita Passaros">Rita Passaros</option>
                        </select>
                        <br><br>

                        <div class="form-text">
                            <b>Digite o valor de Vendas do Mês:</b>
                            <input type="text" class="form-control w-25" id="valor" name="valor"
                                placeholder="Valor Vendas" required="required" onkeypress="mascara(this, moeda)"
                                maxlength="10">
                        </div>

                        <br><br>

                        <button class="btn btn-primary btn-xl" id="enviar" name="enviar" type="submit" disabled>Salvar
                            Alterações</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>