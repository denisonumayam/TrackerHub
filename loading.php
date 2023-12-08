<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Caricamento Carta di Gioco</title>
  <style>
    body {
      color: white;
      background-color: black;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
      position: relative;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      background-image: url('imgs/loadingBack.jpg'); /* Percorso dell'immagine di sfondo */
      background-size: cover;
      background-position: center;
      opacity: 0.5; /* Opacità dell'immagine di sfondo */
    }

    .loading-container {
      text-align: center;
      position: relative;
      z-index: 1; /* Assicura che il contenuto sia sopra l'immagine di sfondo */
    }

    .spinner {
      width: 50px;
      height: 50px;
      border: 5px solid #fff;
      border-top: 5px solid transparent;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      100% {
        transform: rotate(360deg);
      }
    }
  </style>
</head>
<body>
  <div class="loading-container">
    <div class="spinner"></div>
  </div>
  
</body>
</html>


<?php header("refresh:1 , url=try.php"); ?>