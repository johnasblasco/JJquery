<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FunQuest</title>
  
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <link rel="stylesheet" href="game.css" />
  </head>
  <body>
    <div class="container">
      <div id="timer"></div>
      <div id="score">0</div>
      <h3>Level 1</h3><br>
      <h3>Drag & Drop the Numbers According to their Corresponding Terms</h3>
      <div class="draggable-objects"></div>
      <div class="drop-points"></div>
    </div>
    <div class="controls-container">
      <p id="result"></p>
      <button id="start">Start!</button>
    </div>
    <div class="bck-container">
        <a href="home.php" class="back-button">Back</a>
    </div>

    <!--Jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- Script -->
    <script src="script.js"></script>
  </body>
</html>