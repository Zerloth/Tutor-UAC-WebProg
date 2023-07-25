<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tictactoe | Sky Universe</title>
    @vite(['resources/js/app.js', 'resources/js/tictactoe.js', 'resources/css/tictactoe.css'])
</head>

<body>
    <div class="board" id="board">
        <div id="cell1" class="cell" data-cell></div>
        <div id="cell2" class="cell" data-cell></div>
        <div id="cell3" class="cell" data-cell></div>
        <div id="cell4" class="cell" data-cell></div>
        <div id="cell5" class="cell" data-cell></div>
        <div id="cell6" class="cell" data-cell></div>
        <div id="cell7" class="cell" data-cell></div>
        <div id="cell8" class="cell" data-cell></div>
        <div id="cell9" class="cell" data-cell></div>
    </div>
    <div class="winning-message" id="winningMessage">
        <div data-winning-message-text></div>
        <button id="restartButton">Restart</button>
    </div>

    <script>
        var dating_code = "{{ $dating_code }}"
        var symbol = "{{ $symbol }}"
    </script>
</body>

</html>
