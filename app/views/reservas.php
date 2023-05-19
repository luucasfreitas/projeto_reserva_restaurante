<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirecionar para a página de login se o usuário não estiver logado
    exit;
}

?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sistema de reservas de mesas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="assets/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Sistema de reservas de mesas</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
            <a class="nav-link" href="../controller/logout.php">Sair</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="home.php">
                                <span data-feather="home"></span>
                                Administrar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="book"></span>
                                Reservas<span class="sr-only">(current)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2 mb-5">Reservar mesa</h1>
                    <form method="post" id="form_reserva" action="<?php echo '../controller/reservas.php'; ?>">
                        <div class="form-group">
                            <label for="nome">Nome do Cliente:</label>
                            <input type="text" class="form-control" id="nome" placeholder="Insira o nome do cliente." name="nome_cliente" required>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone:</label>
                            <input type="number" class="form-control" id="telefone" placeholder="Insira o telefone de contato do cliente." name="telefone" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="Insira o email de contato do cliente." name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="data">Data:</label>
                            <input type="date" class="form-control" id="data" name="data" required>
                        </div>
                        <div class="form-group">
                            <label for="hora_entrada">Horário de entrada:</label>
                            <input type="time" class="form-control" id="hora_entrada" aria-describedby="horarios_ent" name="hora_entrada" required>
                            <small id="horarios_ent" class="form-text text-muted">Lembrando que o horário de reservas permitidas de segunda à sábado são de 18:00h até as 23:59h.</small>
                        </div>
                        <div class="form-group">
                            <label for="hora_saida">Horário de saída:</label>
                            <input type="time" class="form-control" id="hora_saida" aria-describedby="horario_saida" name="hora_saida" required>
                            <small id="horario_saida" class="form-text text-muted">Lembrando que o horário de reservas permitidas de segunda à sábado são de 18:00h até as 23:59h.</small>
                        </div>
                        <div class="form-group">
                            <label for="quantidade">Quantidade de mesas</label>
                            <input type="number" class="form-control" id="quantidade" aria-describedby="mesas_disponiveis" name="quantidade" placeholder="Insira o quanto de mesas serão necessária." required>
                            <small id="mesas_disponiveis" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="obs">Observações</label>
                            <textarea class="form-control" id="obs" name="obs" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment/locale/pt-br.js"></script>
    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace()
    </script>
    <script>
        const dataInput = document.getElementById('data');
        const formulario = document.getElementById('form_reserva');
        const horaInput = document.getElementById('hora_entrada');
        const horaOutput = document.getElementById('hora_saida');
        const qtdMesas = document.getElementById('quantidade');
        dataInput.addEventListener('change', verifica_qtd_mesas);
        horaInput.addEventListener('change', verifica_qtd_mesas);
        horaOutput.addEventListener('change', verifica_qtd_mesas);
        qtdMesas.addEventListener('change', verifica_qtd_mesas);



        // Valida a quantidade de mesas para eviatr conflito
        function verifica_qtd_mesas() {
            const qtd_mesas = document.getElementById('mesas_disponiveis');
            var data = document.getElementById('data').value;
            var horaEntrada = document.getElementById('hora_entrada').value;
            var horaSaida = document.getElementById('hora_saida').value;
            var mesas = document.getElementById('quantidade').value;
            if (mesas > 15) {
                alert('Insira um valor válido para quantidade de mesas');
                return;
            } else {
                var formData = new FormData();
                formData.append('data', data);
                formData.append('hora_entrada', horaEntrada);
                formData.append('hora_saida', horaSaida);

                fetch('../controller/qtd_mesas.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        var numRegistros = parseInt(data);
                        if (numRegistros < 1) {
                            alert('Não há vaga nos horários escolhidos')
                            numRegistros = 0;
                        }
                        qtd_mesas.innerHTML = `Apenas ${numRegistros} mesas disponíveis nesse dia.`;
                        console.log(numRegistros); // ou faça o que desejar com o número de registros retornado
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    });
            }

        }


        formulario.addEventListener('submit', function(event) {
            event.preventDefault(); // Impede o envio automático do formulário
            // Validar os campos do formulário
            const dataSelecionada = new Date(dataInput.value);
            const diaSemana = dataSelecionada.getDay();
            const formData = new FormData(formulario);

            if (diaSemana != 6) {
                if (horaInput.value < '18:00' || horaInput.value > '23:59') {
                    alert('Horário de entrada inválido, por favor selecione entre 18:00h e 23:59h');
                    return;
                } else if (horaOutput.value < '18:00' || horaOutput.value > '23:59') {
                    alert('Horário de saída inválido, por favor selecione entre 18:00h e 23:59h');
                    return;
                } else if (horaOutput.value < horaInput.value) {
                    alert('Horário de saída inválido, por favor selecione um horário mais que o horário de entrada.');
                    return;
                }
                envia_form(formulario);

            } else {
                envia_form(formulario);
            }

            function envia_form(formulario_reservas) {
                fetch('../controller/reservas.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            alert('Reserva feita com sucesso!');

                            formulario.reset(); // Limpa o formulário
                        } else {
                            throw new Error('Ocorreu um erro ao enviar o formulário.');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ocorreu um erro ao enviar o formulário. Por favor, tente novamente.');
                    });
            }
        });
    </script>
</body>

</html>