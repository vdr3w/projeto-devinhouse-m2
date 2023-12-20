<!DOCTYPE html>
<html>
<head>
    <title>LISTA DE TREINOS</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .workout-item {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px 0;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .workout-info {
            font-weight: bold;
            color: #333;
        }
        .workout-details {
            color: #555;
        }
        .workout-details strong {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Treinos do Estudante {{$student->name}}</h1>
        @foreach ($workouts as $workout)
            <div class="workout-item">
                <div class="workout-info">Dia: {{ $workout->day }}</div>
                <div class="workout-details"><strong>Descrição do Exercício:</strong> {{ $workout->exercise->description }}</div>
                <div class="workout-details"><strong>Repetições:</strong> {{ $workout->repetitions }}</div>
                <div class="workout-details"><strong>Peso:</strong> {{ $workout->weight }} Kg</div>
                <div class="workout-details"><strong>Duração:</strong> {{ $workout->time }}</div>
                <div class="workout-details"><strong>Séries:</strong> {{ $workout->repetitions }}</div>
                <div class="workout-details"><strong>Observações:</strong> {{ $workout->observations }}</div>
                <div class="workout-details"><strong>Tempo de Descanso:</strong> {{ $workout->break_time }} segundos</div>
            </div>
        @endforeach
    </div>
</body>
</html>
