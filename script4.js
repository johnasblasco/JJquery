$(document).ready(function() {
    let draggableObjects;
    let dropPoints;
    const startButton = $("#start");
    const result = $("#result");
    const controls = $(".controls-container");
    const dragContainer = $(".draggable-objects");
    const dropContainer = $(".drop-points");
    const timer = $("#timer");
    const scoreDisplay = $("#score"); 
    const data = [
        "bat", "bee", "cat", "cow", "crab", "dog",
        "elephant", "fish", "fox", "hen", "koala", "lion",
        "monkey", "owl", "pig", "sheep", "snail",
        "squirrel", "turtle", "whale", 
    ];

    let count = 0;
    let timeLeft = 40;
    let timerInterval;
    let score = 180; 


    const randomValueGenerator = () => {
        return data[Math.floor(Math.random() * data.length)];
    };

    const stopGame = () => {
        controls.removeClass("hide");
        startButton.removeClass("hide");
        startButton.text("Level 5");
        startButton.off("click").on("click", function() {
            window.location.href = "game5.php";
        });
    };

    //This are the drag and drop functions
const drop = (event, ui) => {
    const draggedElementData = ui.draggable.attr("id");
    const droppableElementData = $(event.target).attr("data-id");
    if (draggedElementData === droppableElementData) {
        $(event.target).addClass("dropped");
        ui.draggable.draggable("disable");
        ui.draggable.remove(); 
        $(event.target).empty();
        $(event.target).append(`<img src="animals/${draggedElementData}.png">`);
        $(event.target).css("background-color", "#9effa8");

        count += 1;

        // Increment score by 10 for each correct answer
        score += 10;
        scoreDisplay.text(score); // Update the score display

        // Send AJAX request to update score in XML file
        $.ajax({
            url: 'update_score.php', // Path to your PHP script to update score
            method: 'POST',
            data: { score: score },
            success: function(response) {
                console.log('Score updated successfully.');
            },
            error: function(xhr, status, error) {
                console.error('Error updating score:', error);
            }
        });
    } else {
        // Add red color if dropped on the wrong container
        $(event.target).css("background-color", "#ff6961"); // Red color
        setTimeout(() => {
            $(event.target).css("background-color", ""); // Reset color after 1 second
        }, 1000);
    }

    if (count === 10) {
        result.text("Good job!");
        stopGame();
    }
};

    const creator = () => {
        dragContainer.empty();
        dropContainer.empty();
        let randomData = [];

        for (let i = 1; i <= 10; i++) {
            let randomValue = randomValueGenerator();
            if (!randomData.includes(randomValue)) {
                randomData.push(randomValue);
            } else {
                i -= 1;
            }
        }

        for (let i of randomData) {
            const anmlDiv = $("<div>", {
                class: "draggable-image",
                draggable: true,
                id: i
            }).html(`<img src="animals/${i}.png">`);
            dragContainer.append(anmlDiv);
        }

        randomData = randomData.sort(() => 0.5 - Math.random());
        for (let i of randomData) {
            const animalsDiv = $("<div>", {
                class: "animals",
                "data-id": i
            }).html(`${i.charAt(0).toUpperCase() + i.slice(1).replace("-", "")}`);
            dropContainer.append(animalsDiv);
        }

        draggableObjects = $(".draggable-image");
        dropPoints = $(".animals");
    };

    const startTimer = () => {
        timerInterval = setInterval(() => {
            timeLeft -= 1;
            timer.text(`Time Left: ${timeLeft}s`);

            if (timeLeft === 0) {
                clearInterval(timerInterval);
                timer.text("Time's Up!");
                controls.removeClass("hide");
                startButton.text("Retry");
                startButton.removeClass("hide");
                startButton.off("click").on("click", function() {
                    location.reload();
                });
            }
        }, 1000);
    };

    const resetTimer = () => {
        clearInterval(timerInterval);
        timeLeft = 40;
        timer.text(`Time Left: ${timeLeft}s`);
    };

    startButton.on("click", function() {
        controls.addClass("hide");
        resetTimer();
        startTimer();
        creator();
        count = 0;

        draggableObjects.draggable({
            zIndex: 100,
            start: function(event, ui) {
                $(this).css("z-index", 101);
            }
        });

        dropPoints.droppable({
            accept: ".draggable-image",
            drop: drop
        });
    });
});
