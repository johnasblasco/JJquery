$(document).ready(function() {
    let draggableObjects;
    let dropPoints;
    const startButton = $("#start");
    const result = $("#result");
    const controls = $(".controls-container");
    const dragContainer = $(".draggable-objects");
    const dropContainer = $(".drop-points");
    const timer = $("#timer"); // Select the timer div
    const data = [
        "one", "two", "three", "four", "five",
        "six", "seven", "eight", "nine",
    ];

    let count = 0;
    let timeLeft = 30;
    let timerInterval;

    // Timer function
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
                    location.reload(); // Reload the page to retry
                });
            }
        }, 1000);
    };

    // Reset timer function
    const resetTimer = () => {
        clearInterval(timerInterval);
        timeLeft = 30;
        timer.text(`Time Left: ${timeLeft}s`);
    };

    // This are the drag and drop functions
    const drop = (event, ui) => {
        const draggedElementData = ui.draggable.attr("id");
        const droppableElementData = $(event.target).attr("data-id");
        if (draggedElementData === droppableElementData) {
            $(event.target).addClass("dropped");
            ui.draggable.hide();
            ui.draggable.draggable("disable");
            $(event.target).empty();
            $(event.target).append(`<img src="numbers/${draggedElementData}.png">`);
            $(event.target).css("background-color", "#9effa8");

            count += 1;

            // Update score by adding 10 points for each correct answer
            const currentScore = parseInt($("#score").text());
            const updatedScore = currentScore + 10;
            $("#score").text(updatedScore);

            // Send AJAX request to update score in XML file
            $.ajax({
                url: 'update_score.php',
                method: 'POST',
                data: { score: updatedScore },
                success: function(response) {
                    // Handle success response if needed
                    console.log('Score updated successfully.');
                },
                error: function(xhr, status, error) {
                    // Handle error if needed
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

        if (count === 5) {
            result.text("Great!");
            clearInterval(timerInterval); // Stop the timer
            controls.removeClass("hide");
            startButton.text("Level 2");
            startButton.removeClass("hide");
            startButton.off("click").on("click", function() {
                window.location.href = "game2.php";
            });
        }
    };

    const creator = () => {
        dragContainer.empty();
        dropContainer.empty();
        let randomData = [];

        for (let i = 1; i <= 5; i++) {
            let randomValue = randomValueGenerator();
            if (!randomData.includes(randomValue)) {
                randomData.push(randomValue);
            } else {
                i -= 1;
            }
        }

        for (let i of randomData) {
            const flagDiv = $("<div>", {
                class: "draggable-image",
                draggable: true,
                id: i
            }).html(`<img src="numbers/${i}.png">`);
            dragContainer.append(flagDiv);
        }

        randomData = randomData.sort(() => 0.5 - Math.random());
        for (let i of randomData) {
            const countryDiv = $("<div>", {
                class: "num",
                "data-id": i
            }).html(`${i.charAt(0).toUpperCase() + i.slice(1).replace("-", "")}`);
            dropContainer.append(countryDiv);
        }

        draggableObjects = $(".draggable-image"); // Update draggable objects
        dropPoints = $(".num"); // Update drop points
    };

    const randomValueGenerator = () => {
        return data[Math.floor(Math.random() * data.length)];
    };

    startButton.on("click", function() {
        controls.addClass("hide");
        resetTimer(); // Reset the timer before starting
        startTimer(); // Start the timer
        creator(); // Moved this here to ensure draggable objects and drop points are created after starting the timer
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
