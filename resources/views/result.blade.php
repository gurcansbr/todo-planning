<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Toplam Görev Sayısı</th>
                            <th>Tamamlanan Görev Sayısı</th>
                            <th>Tamamlanma Süresi(Hafta)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $results['task_count'] }}</td>
                            <td>{{ $results['completed_task_count'] }}</td>
                            <td>{{ $results['completed_time'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($results['devTasks'] as $key => $devTask)
        <div class="card mt-5 {{ $loop->last ? "mb-5" : "" }}">
            <div class="card-body">
                <p>
                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#dev{{ $key }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                        {{ 'DEV'. $key }}
                    </a>
                    DEV{{ $key }} için görev listesi
                </p>
                <div class="collapse" id="dev{{ $key }}">
                    <div class="card card-body">
                        <ul>
                            @foreach ($devTask as $task)
                                <li>Görev Adı: {{ $task['name'] }} | Görev Seviyesi: {{ $task['level'] }} | Görev Süresi: {{ $task['duration'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>
</html>