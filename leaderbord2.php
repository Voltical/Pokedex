<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pokémon Leaderboard</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px; text-align: center; }
    h1 { color: #ff0000; text-shadow: 1px 1px #555; }
    table { width: 50%; margin: 0 auto; border-collapse: collapse; background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.2); border-radius: 10px; overflow: hidden; }
    th, td { padding: 15px; border-bottom: 1px solid #ddd; }
    th { background-color: #ffcb05; color: #2a75bb; font-size: 1.2em; }
    tr:nth-child(even) { background-color: #f9f9f9; }
    tr:hover { background-color: #ffeb99; }
  </style>
</head>
<body>

<h1>🏆 Pokémon Leaderboard 🏆</h1>

<table id="leaderboard">
  <thead>
    <tr><th>Rank</th><th>Trainer</th><th>Score</th></tr>
  </thead>
  <tbody></tbody>
</table>

<script>
fetch('leaderbord.php')
  .then(response => response.json())
  .then(players => {
    const tbody = document.querySelector('#leaderboard tbody');
    players.forEach((player, index) => {
      tbody.innerHTML += `<tr>
                            <td>${index + 1}</td>
                            <td>${player.name}</td>
                            <td>${player.score}</td>
                          </tr>`;
    });
  })
  .catch(err => console.error('Fout bij laden leaderboard:', err));
</script>

</body>
</html>
