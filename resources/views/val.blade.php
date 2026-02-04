<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <title>Valentine</title>

  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

  <style>
    :root {
      --pink: #ff3b7a;
      --bg: #ffeef6;
    }

    * {
      box-sizing: border-box;
      -webkit-tap-highlight-color: transparent;
    }

    body {
      margin: 0;
      min-height: 100svh;
      display: grid;
      place-items: center;
      background: var(--bg);
      font-family: system-ui, -apple-system;
    }

    canvas {
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 0;
    }

    .card {
      width: 92vw;
      max-width: 360px;
      background: #fff;
      border-radius: 22px;
      padding: 26px 20px;
      text-align: center;
      box-shadow: 0 18px 40px rgba(0,0,0,.15);
      position: relative;
      z-index: 2;
    }

    .logo-heart {
      font-size: 56px;
      margin-bottom: 10px;
      animation: pulse 1.2s infinite alternate;
    }

    @keyframes pulse {
      from { transform: scale(1); }
      to { transform: scale(1.15); }
    }

    h2 {
      font-size: 22px;
      margin-bottom: 20px;
    }

    .zone {
      position: relative;
      height: 180px;
    }

    button {
      padding: 14px 26px;
      font-size: 17px;
      border-radius: 999px;
      border: none;
      font-weight: 600;
      cursor: pointer;
    }

    #yes {
      background: var(--pink);
      color: #fff;
    }

    #no {
      position: absolute;
      background: #e5e7eb;
      left: 55%;
      top: 60%;
      transform: translate(-50%, -50%);
    }

    #afterYes,
    #final {
      display: none;
    }

    .message {
      font-size: 18px;
      margin-bottom: 14px;
    }

    textarea,
    input[type="tel"] {
      width: 100%;
      padding: 14px;
      font-size: 16px;
      border-radius: 12px;
      border: 1px solid #ddd;
      outline: none;
    }

    textarea {
      resize: none;
    }

    .send {
      margin-top: 14px;
      background: var(--pink);
      color: #fff;
      width: 100%;
    }

    .big-heart {
      font-size: 90px;
      animation: pulse 1s infinite alternate;
    }
  </style>
</head>

<body>

<canvas id="confetti"></canvas>

<div class="card">

  <div class="logo-heart">❤️</div>

  <h2>Jinal, will you be my Valentine?</h2>

  <div class="zone" id="zone">
    <button id="yes">Yes</button>
    <button id="no">No</button>
  </div>

  <div id="afterYes">
    <p class="message">
      I always wanted to say this but couldn’t.
      I was scared I might lose you.
      I don’t know where this leads, but I really like you ❤️
    </p>

    <textarea id="message" rows="5"
      placeholder="Please write here whatever you feel 🌸"></textarea>

    <input type="tel" id="phone"
      placeholder="Your mobile number 📞"
      maxlength="10"
      inputmode="numeric"
      style="margin-top:12px" />

    <button class="send" onclick="sendMessage()">Lets Give a Chance</button>
  </div>

  <div id="final">
    <div class="big-heart">❤️</div>
    <p style="font-size:20px;margin-top:10px;">
       See You Soon😊
    </p>
  </div>

</div>

<script>
  const noBtn = document.getElementById("no");
  const yesBtn = document.getElementById("yes");
  const zone = document.getElementById("zone");
  const afterYes = document.getElementById("afterYes");
  const final = document.getElementById("final");
  const canvas = document.getElementById("confetti");

  const confettiInstance = confetti.create(canvas, {
    resize: true,
    useWorker: true
  });

  function moveNoButton() {
    const z = zone.getBoundingClientRect();
    const b = noBtn.getBoundingClientRect();
    noBtn.style.left = Math.random() * (z.width - b.width) + "px";
    noBtn.style.top = Math.random() * (z.height - b.height) + "px";
  }

  noBtn.addEventListener("mouseenter", moveNoButton);
  noBtn.addEventListener("touchstart", e => {
    e.preventDefault();
    moveNoButton();
  });

  yesBtn.onclick = () => {
    zone.style.display = "none";
    afterYes.style.display = "block";
  };

  function sendMessage() {
    const message = document.getElementById("message").value.trim();
    const phone = document.getElementById("phone").value.trim();

    if (!message) {
      alert("Please write something 💬");
      return;
    }

    if (!/^\d{10}$/.test(phone)) {
      alert("Please enter a valid 10-digit mobile number 📞");
      return;
    }

    fetch("/send-number", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
      },
      body: JSON.stringify({ message, phone })
    });

    afterYes.style.display = "none";
    final.style.display = "block";
    fullScreenHearts();
  }

  function fullScreenHearts() {
    const end = Date.now() + 2500;
    (function frame() {
      confettiInstance({
        particleCount: 18,
        spread: 360,
        startVelocity: 40,
        scalar: 1.4,
        colors: ['#ff3b7a', '#ff7aa2', '#ffd6e7', '#ffffff'],
        origin: { x: Math.random(), y: Math.random() }
      });
      if (Date.now() < end) requestAnimationFrame(frame);
    })();
  }
</script>

</body>
</html>
