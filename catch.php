<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pokéball Catch Mini-Game</title>
  <style>
    body { background-color: #f2f2f2; text-align: center; font-family: Arial, sans-serif; overflow: hidden; }
    h1 { margin-top: 20px; color: #333; }
    #game-area { position: relative; width: 800px; height: 500px; margin: 20px auto;
      background: linear-gradient(to top, #78C850 50%, #AEE1F9 50%);
      border: 4px solid #444; border-radius: 10px; overflow: hidden; cursor: crosshair; }

    .cloud { position: absolute; background: #fff; border-radius: 50%; opacity: 0.8;
      animation: moveClouds 60s linear infinite; }
    @keyframes moveClouds { 0% { left: -200px; } 100% { left: 100%; } }

    #grass { position: absolute; bottom: 0; width: 100%; height: 100px;
      background: linear-gradient(to top, #4CAF50 50%, #66BB6A 100%); border-top: 4px solid #3e7d40; z-index: 2; }
    .grass-blade { position: absolute; bottom: 0; width: 4px; height: 20px;
      background-color: #3e7d40; border-radius: 2px; animation: sway 2s infinite alternate ease-in-out; }
    @keyframes sway { 0% { transform: rotate(-5deg); } 100% { transform: rotate(5deg); } }

    .pokemon { position: absolute; width: 80px; height: 80px; background-size: cover;
      animation: move linear infinite; z-index: 3; }
    @keyframes move { 0% { left: -100px; } 100% { left: 850px; } }

    .flying { top: 50px !important; }
    .ground { bottom: 100px; }

    .pokeball { position: absolute; width: 50px; height: 50px;
      background-image: url('https://img.icons8.com/color/48/000000/pokeball-2.png');
      background-size: cover; transition: top 0.5s, left 0.5s; z-index: 10; }

    .capture-effect { position: absolute; width: 80px; height: 80px;
      background: rgba(255, 255, 255, 0.7); border-radius: 50%; animation: capture 0.5s forwards; }
    @keyframes capture { 0% { transform: scale(0.5); opacity: 1; } 100% { transform: scale(1.5); opacity: 0; } }

    #scoreboard { font-size: 20px; margin-top: 10px; color: #333; font-weight: bold; }
    #result { margin-top: 15px; font-size: 20px; color: #333; font-weight: bold; }
    #reset-btn { padding: 10px 20px; background-color: #FF8C00; color: #fff; font-size: 18px;
      border: none; cursor: pointer; border-radius: 8px; margin-top: 20px; }
    #reset-btn:hover { background-color: #e67600; }

    #win-message { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
      font-size: 80px; font-weight: bold; color: #FFCC00;
      text-shadow: -3px -3px 0 #3366CC, 3px -3px 0 #3366CC, -3px 3px 0 #3366CC,
                   3px 3px 0 #3366CC, 0px 0px 10px #3366CC;
      text-align: center; display: none; z-index: 20; }
  </style>
</head>

<body>
<h1>🎯 Klik waar je de Pokéball gooit!</h1>
<div id="scoreboard">Score: 0 | Levens: 5</div>

<div id="game-area">
  <div class="cloud" style="top: 50px; width: 120px; height: 60px;"></div>
  <div class="cloud" style="top: 100px; width: 200px; height: 80px;"></div>
  <div id="win-message">YOU WIN!</div>
  <div id="grass"></div>
</div>

<div id="result"></div>
<button id="reset-btn">🔄 Reset Game</button>

<script>
  const gameArea = document.getElementById('game-area');
  const result = document.getElementById('result');
  const resetBtn = document.getElementById('reset-btn');
  const scoreboard = document.getElementById('scoreboard');
  const winMessage = document.getElementById('win-message');
  const grass = document.getElementById('grass');

  // ✅ Gescheiden lijsten
  const flyingPokemonList = [
    'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/17.png', // Pidgeotto
    'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/41.png'  // Zubat
  ];
  const groundPokemonList = [
    'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png', // Pikachu
    'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png',  // Bulbasaur
    'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/4.png',  // Charmander
    'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/7.png',  // Squirtle
    'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/39.png'  // Jigglypuff
  ];

  let pokemons = [];
  let score = 0;
  let lives = 5;

  function vangstAnimatie(x, y) {
    const effect = document.createElement('div');
    effect.classList.add('capture-effect');
    effect.style.left = `${x}px`;
    effect.style.top = `${y}px`;
    gameArea.appendChild(effect);
    setTimeout(() => effect.remove(), 500);
  }

  function updateScore() {
    score += 10;
    updateScoreboard();
  }

  function misGegooid() {
    lives--;
    updateScoreboard();
    if (lives <= 0) {
      result.textContent = "💀 Game Over!";
      gameArea.style.pointerEvents = "none";
    }
  }

  function createGrassBlades() {
    grass.innerHTML = '';
    for (let i = 0; i < 50; i++) {
      const blade = document.createElement('div');
      blade.classList.add('grass-blade');
      blade.style.left = `${Math.random() * 800}px`;
      blade.style.height = `${15 + Math.random() * 20}px`;
      grass.appendChild(blade);
    }
  }

  function updateScoreboard() {
    scoreboard.textContent = `Score: ${score} | Levens: ${lives}`;
  }

  function spawnPokemons() {
  pokemons = [];
  const clouds = gameArea.querySelectorAll('.cloud');
  const win = document.getElementById('win-message');
  const grassEl = document.getElementById('grass');
  gameArea.innerHTML = '';
  clouds.forEach(cloud => gameArea.appendChild(cloud));
  gameArea.appendChild(win);
  gameArea.appendChild(grassEl);

  // Spawn ground Pokémon op random hoogte net boven het gras
  groundPokemonList.forEach(src => {
    const poke = document.createElement('div');
    poke.classList.add('pokemon', 'ground');
    // Willekeurige 'bottom' waarde zodat ze niet steeds exact op 100px lopen
    poke.style.bottom = `${80 + Math.random() * 40}px`; // Tussen 80 en 120
    poke.style.animationDuration = `${Math.random() * 5 + 4}s`;
    poke.style.backgroundImage = `url(${src})`;
    gameArea.appendChild(poke);
    pokemons.push(poke);
  });

  // Spawn flying Pokémon op random hoogte in de lucht
  flyingPokemonList.forEach(src => {
    const poke = document.createElement('div');
    poke.classList.add('pokemon', 'flying');
    poke.style.top = `${Math.random() * 200 + 30}px`; // Tussen 30 en 230px
    poke.style.animationDuration = `${Math.random() * 5 + 4}s`;
    poke.style.backgroundImage = `url(${src})`;
    gameArea.appendChild(poke);
    pokemons.push(poke);
  });
}

  createGrassBlades();
  spawnPokemons();
  updateScoreboard();

  gameArea.addEventListener('click', function (e) {
    const rect = gameArea.getBoundingClientRect();
    const targetX = e.clientX - rect.left - 25;
    const targetY = e.clientY - rect.top - 25;

    const pokeball = document.createElement('div');
    pokeball.classList.add('pokeball');
    pokeball.style.left = '375px';
    pokeball.style.top = '450px';
    gameArea.appendChild(pokeball);

    setTimeout(() => {
      pokeball.style.left = `${targetX}px`;
      pokeball.style.top = `${targetY}px`;
    }, 50);

    setTimeout(() => {
      const ballRect = pokeball.getBoundingClientRect();
      let hit = false;

      pokemons.forEach((poke, index) => {
        if (!poke) return;
        const pokeRect = poke.getBoundingClientRect();
        if (ballRect.left < pokeRect.right && ballRect.right > pokeRect.left &&
            ballRect.top < pokeRect.bottom && ballRect.bottom > pokeRect.top) {
          vangstAnimatie(poke.offsetLeft, poke.offsetTop);
          poke.remove();
          pokemons[index] = null;
          updateScore();
          result.textContent = "🎉 Je hebt een Pokémon gevangen!";
          hit = true;
        }
      });

      if (!hit) {
        result.textContent = "❌ Mis! -1 leven";
        misGegooid();
      }

      if (pokemons.every(p => p === null)) {
        winMessage.style.display = 'block';
        gameArea.style.pointerEvents = "none";
      }

      pokeball.remove();
    }, 600);
  });

  resetBtn.addEventListener('click', function () {
    score = 0;
    lives = 5;
    result.textContent = '';
    winMessage.style.display = 'none';
    gameArea.style.pointerEvents = "auto";
    createGrassBlades();
    spawnPokemons();
    updateScoreboard();
  });
</script>

</body>
</html>
