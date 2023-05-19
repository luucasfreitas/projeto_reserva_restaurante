<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirecionar para a página de login se o usuário não estiver logado
    exit;
}
// Obtendo a data de hoje
function get_data_week()
{
    require $_SERVER['DOCUMENT_ROOT'] . '/app/controller/database.php';
    $dataHoje = date('Y-m-d');

    // Obtendo a data daqui a 7 dias
    $dataLimite = date('Y-m-d', strtotime('+7 days'));

    // Criando um array com todos os dias no intervalo
    $intervaloDatas = array();
    $dataAtual = $dataHoje;
    while ($dataAtual <= $dataLimite) {
        $intervaloDatas[] = $dataAtual;
        $dataAtual = date('Y-m-d', strtotime($dataAtual . ' +1 day'));
    }

    // Consulta SQL
    $sql = "SELECT data, COUNT(*) AS quantidade FROM reservas WHERE data >= ? AND data <= ? GROUP BY data";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $dataHoje, $dataLimite);
    $stmt->execute();
    $result = $stmt->get_result();

    // Criando um array para armazenar os resultados
    $resultados = array();
    while ($row = $result->fetch_assoc()) {
        $data = $row['data'];
        $quantidade = $row['quantidade'];

        $resultados[$data] = $quantidade;
    }

    // Combinando os resultados com o intervalo de datas completo
    foreach ($intervaloDatas as $data) {
        if (!isset($resultados[$data])) {
            $resultados[$data] = 0;
        }
    }

    // Exibindo os resultados
    foreach ($resultados as $data => $quantidade) {
        echo "$quantidade, ";
    }

    $stmt->close();
    $conn->close();
}
function get_all()
{
    require $_SERVER['DOCUMENT_ROOT'] . '/app/controller/database.php';
    // Consulta SQL
    $sql = "SELECT * FROM sistema_reserva_restaurante.reservas ORDER BY data, hora_entrada, hora_saida;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    // Criando um array para armazenar os resultados
    $resultados = array();
    while ($row = $result->fetch_assoc()) {
        echo '
            <tr>
                <th scope="row">' . $row['nome_cliente'] . '</th>
                <td>' . $row['telefone'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['data'] . '</td>
                <td>' . $row['hora_entrada'] . '</td>
                <td>' . $row['hora_saida'] . '</td>
                <td>' . $row['mesas'] . '</td>
                <td>' . $row['obs'] . '</td>
            </tr>
        ';
    }

    $stmt->close();
    $conn->close();
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
                            <a class="nav-link active" href="#">
                                <span data-feather="home"></span>
                                Administrar <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reservas.php">
                                <span data-feather="file"></span>
                                Reservas
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Dia</th>
                                <th scope="col">Entrada Prevista</th>
                                <th scope="col">Saída Prevista</th>
                                <th scope="col">Observação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php get_all(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Números de reserva essa semana</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <span data-feather="calendar"></span>
                        Resumo da semana
                    </div>
                </div>
                <canvas class="my-4" id="myChart" width="750" height="380"></canvas>
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

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
        moment.locale('pt-br');

        // Defina os dados para o gráfico
        var labels = [];
        // Gerar rótulos dos dias da semana começando com o dia atual
        for (var i = 0; i < 7; i++) {
            var day = moment().add(i, 'days');
            labels.push(day.format('dddd')); // Adicione o dia da semana aos rótulos
        }

        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,

                datasets: [{
                    data: [<?php
                            get_data_week();
                            ?>],
                    lineTension: 0,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: false
                        }
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });
    </script>
</body>

</html>