<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>MemoGame</title>
  <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
  font-family: Arial, sans-serif;
  text-align: center;
  background: #222;
  color: #fff;
}

h1 {
  margin: 20px 0;
}

.game-board {
  display: grid;
  grid-template-columns: repeat(4, 100px);
  gap: 10px;
  justify-content: center;
  margin: 20px auto;
}

.card {
  width: 100px;
  height: 100px;
  background: #444;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 40px;
  cursor: pointer;
  transition: background 0.3s;
}

.card.revealed, .card.matched {
  background: #00b894;
  color: #fff;
}

</style>
<body>
  <h1>Memory Game</h1>
  <div class="game-board" id="game-board"></div>
  <p id="status"></p>

  <script src="script.js"></script>
</body>
</html>
<script>
    const board = document.getElementById("game-board");
const status = document.getElementById("status");

const emojis = ['🍎', '🍌', '🍒', '🍇', '🍓', '🍍', '🥝', '🍉'];
let cards = [...emojis, ...emojis]; // Dublăm perechile
cards = cards.sort(() => 0.5 - Math.random()); // Amestecă

let firstCard = null;
let secondCard = null;
let lock = false;
let matches = 0;

cards.forEach((emoji, index) => {
  const card = document.createElement("div");
  card.className = "card";
  card.dataset.emoji = emoji;
  card.dataset.index = index;

  card.addEventListener("click", () => {
    if (lock || card.classList.contains("revealed") || card.classList.contains("matched")) return;

    card.textContent = emoji;
    card.classList.add("revealed");

    if (!firstCard) {
      firstCard = card;
    } else {
      secondCard = card;
      lock = true;

      if (firstCard.dataset.emoji === secondCard.dataset.emoji) {
        firstCard.classList.add("matched");
        secondCard.classList.add("matched");
        matches += 1;
        if (matches === emojis.length) {
          status.textContent = "🎉 Gata! Ai găsit toate perechile!";
        }
        resetTurn();
      } else {
        setTimeout(() => {
          firstCard.textContent = "";
          secondCard.textContent = "";
          firstCard.classList.remove("revealed");
          secondCard.classList.remove("revealed");
          resetTurn();
        }, 800);
      }
    }
  });

  board.appendChild(card);
});

function resetTurn() {
  [firstCard, secondCard] = [null, null];
  lock = false;
}

</script>
