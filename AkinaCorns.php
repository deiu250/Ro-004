<?php include_once ("includes/vizite.php");?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" type="image/jpeg" href="includes/logo.jpg">
  <link rel="stylesheet" type="text/css" href="css/akinacorns.css">
  <title>Akinacorns</title>
</head>

<body>
  <h1>Akinacorns </h1>
  <div id="progressContainer">
  <div id="progressBar"></div>
</div>

  <div class="question" id="question"></div>

  <div class="btn-group" id="btnGroup">
    <button onclick="answer('yes')">Da</button>
    <button onclick="answer('no')">Nu</button>
  </div>

  <div class="input-group" id="inputGroup" style="display:none;">
    <select id="awardSelect" onchange="handleAwardSelection()">
      <option value="">Alege premiul...</option>
      <option value="Inspire">Inspire</option>
      <option value="Design">Design</option>
      <option value="Winning alliance">Winning alliance</option>
      <option value="Motivate">Motivate</option>
      <option value="Finalist alliance">Finalist alliance</option>
      <option value="Control">Control</option>
      <option value="Think">Think</option>
      <option value="Judges choice">Judges choice</option>
      <option value="Connect">Connect</option>
      <option value="Innovate">Innovate</option>
    </select>
    <select id="secondaryAwardSelect" style="display:none;">
      <option value="">Alege alt premiu...</option>
      <option value="Inspire">Inspire</option>
      <option value="Design">Design</option>
      <option value="Motivate">Motivate</option>
      <option value="Control">Control</option>
      <option value="Think">Think</option>
      <option value="Judges choice">Judges choice</option>
      <option value="Connect">Connect</option>
      <option value="Innovate">Innovate</option>
    </select>
    <button onclick="submitAwardAnswer()">Trimite</button>
  </div>

  <div class="input-group" id="placeInputGroup" style="display:none;">
    <input type="number" id="placeInput" placeholder="Ce loc a luat? (1, 2, 3)" min="1" />
    <button onclick="submitPlaceAnswer()">Trimite Loc</button>
  </div>

  <select id="citySelect" style="display:none;"></select>
  <button id="submitCityBtn" style="display:none;" onclick="submitCityAnswer()">Trimite oraș</button>

  <div class="result" id="result"></div>
  <button id="restartBtn" onclick="resetGame()">Reîncepe jocul</button>

  <script>
    let teams = [];
    let remainingTeams = [];
    let questions = [];
    let currentQuestion = 0;
    let selectedAward = '';
    let secondaryAward = '';
    let cities = [];

    const questionEl = document.getElementById("question");
    const resultEl = document.getElementById("result");
    const btnGroup = document.getElementById("btnGroup");
    const inputGroup = document.getElementById("inputGroup");
    const awardSelect = document.getElementById("awardSelect");
    const secondaryAwardSelect = document.getElementById("secondaryAwardSelect");
    const placeInputGroup = document.getElementById("placeInputGroup");
    const citySelect = document.getElementById("citySelect");
    const submitCityBtn = document.getElementById("submitCityBtn");

    let teamsLoaded = false;
    let questionsLoaded = false;

    fetch('includes/teams.json')
      .then(response => response.json())
      .then(data => {
        teams = data.teams;
        remainingTeams = [...teams];
        cities = [...new Set(teams.map(team => team.city))];
        teamsLoaded = true;
        if (questionsLoaded) showQuestion();
      })
      .catch(error => {
        console.error("Eroare la încărcarea echipelor:", error);
        document.getElementById("question").textContent = "Nu pot încărca datele echipelor 😢";
      });

    fetch('includes/questions.json')
      .then(response => response.json())
      .then(data => {
        questions = data;
        questionsLoaded = true;
        if (teamsLoaded) showQuestion();
      })
      .catch(error => {
        console.error("Eroare la încărcarea întrebărilor:", error);
      });

    function populateCityOptions() {
      citySelect.innerHTML = '<option value="">Alege orașul...</option>';
      cities.forEach(city => {
        const opt = document.createElement("option");
        opt.value = city;
        opt.textContent = city;
        citySelect.appendChild(opt);
      });
    }

    function showQuestion() {
      const q = questions[currentQuestion];
      if (!q) return displayResult();

      questionEl.textContent = q.text;

      btnGroup.style.display = "none";
      inputGroup.style.display = "none";
      placeInputGroup.style.display = "none";
      citySelect.style.display = "none";
      submitCityBtn.style.display = "none";

      if (q.type === "yesno") {
        btnGroup.style.display = "flex";
      } else if (q.type === "select") {
        inputGroup.style.display = "flex";
        secondaryAwardSelect.style.display = "none";
      } else if (q.type === "select-city") {
        populateCityOptions();
        citySelect.style.display = "inline-block";
        submitCityBtn.style.display = "inline-block";
      } else if (q.type === "number") {
        placeInputGroup.style.display = "flex";
      }
    }

    function answer(ans) {
      const q = questions[currentQuestion];
      remainingTeams = remainingTeams.filter(team => (ans === "yes") === (team[q.key] === q.value));
      currentQuestion++;
      showQuestion();
    }

    function submitCityAnswer() {
      const selectedCity = citySelect.value;
      if (!selectedCity) return;
      remainingTeams = remainingTeams.filter(team => team.city === selectedCity);
      currentQuestion++;
      showQuestion();
    }

    function handleAwardSelection() {
      selectedAward = awardSelect.value;
      if (selectedAward === "Winning alliance" || selectedAward === "Finalist alliance") {
        secondaryAwardSelect.style.display = "inline-block";
      } else {
        secondaryAwardSelect.style.display = "none";
      }
    }

    function submitAwardAnswer() {
      const q = questions[currentQuestion];

      if (selectedAward) {
        remainingTeams = remainingTeams.filter(team =>
          team.award === selectedAward ||
          ((selectedAward === "Winning alliance" || selectedAward === "Finalist alliance") &&
          team.award === secondaryAwardSelect.value)
        );
      }

      currentQuestion++;
      showQuestion();
    }

    function submitPlaceAnswer() {
      const place = parseInt(document.getElementById("placeInput").value);
      remainingTeams = remainingTeams.filter(team => team.place === place);
      currentQuestion++;
      showQuestion();
    }

    function displayResult() {
      if (remainingTeams.length === 1) {
        resultEl.innerHTML = `Te gândești la: <strong>${remainingTeams[0].name}</strong>!`;
      } else if (remainingTeams.length > 1) {
        resultEl.innerHTML = `Hmm... Poate e una dintre: ${remainingTeams.map(t => t.name).join(", ")}`;
      } else {
        resultEl.textContent = "N-am reușit să ghicesc... 😔";
      }
      questionEl.textContent = "Sesiune terminată!";
      btnGroup.style.display = "none";
      inputGroup.style.display = "none";
      placeInputGroup.style.display = "none";
      citySelect.style.display = "none";
      submitCityBtn.style.display = "none";
      document.getElementById("restartBtn").style.display = "inline-block";
    }

    function resetGame() {
      remainingTeams = [...teams];
      currentQuestion = 0;
      resultEl.textContent = "";
      document.getElementById("restartBtn").style.display = "none";
      showQuestion();
    }
  </script>
  <script>
    window.addEventListener("beforeunload", function () {
      navigator.sendBeacon("log_leave.php", new URLSearchParams({
        page: window.location.pathname
      }));
    });
  </script>
  
</body>
</html>
