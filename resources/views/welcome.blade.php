<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <div class="text-red-500">Recharge</div>

    <div>État du chargeur : {{ $info->state->label() }}</div>

    @if ($info->state->canRun())
        <form action="/lektrico/start" method="POST">
            @csrf
            <button>Lancer la charge</button>
        </form>
    @endif

    @if ($info->state->charging())
        <div>
            <div>Puissance de charge : {{ $info->instantPower->kWForHumans() }}</div>
            <div>Temps de recharge : {{ floor($info->chargingTimeInSeconds / 60) }}min {{ $info->chargingTimeInSeconds % 60 }}s</div>
            <div>kWh rechargés : {{ $info->sessionEnergyInKWh }}kWh</div>
        </div>

        <form action="/lektrico/stop" method="POST">
            @csrf
            <button>Stopper la charge</button>
        </form>
    @endif

    <form action="/lektrico/set_current" method="POST" x-data="{ current: {{ $info->requestedCurrent }} }">
        @csrf
        <div>
            <input x-model="current" type="range" name="current" min="6" max="32" step="1" />
        </div>
        
        <button>Sauvegarder pour <span x-text="current"></span>A</button>
    </form>

    @dump($info)
</body>
</html>