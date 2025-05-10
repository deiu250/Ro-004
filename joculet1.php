<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Drag & Drop Puzzle Robocorn</title>
  <style>
    body {
      background-color: #121212;
      color: white;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .puzzle {
      display: grid;
      grid-template-columns: repeat(4, 100px);
      grid-template-rows: repeat(4, 100px);
      gap: 4px;
    }

    .piece {
      width: 100px;
      height: 100px;
      background-image: url('regionala/Regionala/VK1_5625.jpg');
      background-size: 400px 400px;
      border-radius: 6px;
      cursor: grab;
      user-select: none;
    }

    .message {
      margin-top: 20px;
      font-size: 24px;
      display: none;
      animation: pop 1s ease-out forwards;
    }

    @keyframes pop {
      from {
        transform: scale(0.5);
        opacity: 0;
      }
      to {
        transform: scale(1);
        opacity: 1;
      }
    }
  </style>
</head>
<body>

<h1>Montează robotul nostru 🧩</h1>
<div class="puzzle" id="puzzle"></div>
<div class="message" id="message">🚀 Robocorn e gata de lansare! 🚀</div>
<audio id="tic" src="tic.mp3" preload="auto"></audio>

<script>
  const puzzle = document.getElementById('puzzle');
  const message = document.getElementById('message');
  const ticSound = document.getElementById('tic');

  const total = 16;
  const positions = [...Array(total).keys()];
  const correctOrder = [...positions];

  // Fisher-Yates shuffle
  for (let i = positions.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [positions[i], positions[j]] = [positions[j], positions[i]];
  }

  const createPiece = (index, position) => {
    const div = document.createElement('div');
    div.classList.add('piece');
    div.setAttribute('draggable', true);
    div.dataset.index = index;
    div.dataset.position = position;
    div.style.backgroundPosition = 
      `${-(index % 4) * 100}px ${-Math.floor(index / 4) * 100}px`;
    return div;
  }

  positions.forEach((index, pos) => {
    const piece = createPiece(index, pos);
    puzzle.appendChild(piece);
  });

  let dragged;

  puzzle.addEventListener('dragstart', e => {
    dragged = e.target;
  });

  puzzle.addEventListener('dragover', e => {
    e.preventDefault();
  });

  puzzle.addEventListener('drop', e => {
    const target = e.target;
    if (target.classList.contains('piece') && target !== dragged) {
      const draggedIndex = dragged.dataset.index;
      const targetIndex = target.dataset.index;

      // Swap elements
      const draggedClone = dragged.cloneNode(true);
      const targetClone = target.cloneNode(true);

      puzzle.replaceChild(draggedClone, target);
      puzzle.replaceChild(targetClone, dragged);

      // Re-bind drag events
      [draggedClone, targetClone].forEach(el => {
        el.addEventListener('dragstart', ev => dragged = ev.target);
      });

      // Play tic
      ticSound.currentTime = 0;
      ticSound.play();

      // Check win
      const children = Array.from(puzzle.children);
      const currentOrder = children.map(child => parseInt(child.dataset.index));
      const isSolved = currentOrder.every((val, i) => val === correctOrder[i]);
      if (isSolved) {
        message.style.display = 'block';
      }
    }
  });
</script>

</body>
</html>
