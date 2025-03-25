document.addEventListener("DOMcontenctLoaded", function() {
let flippedCards = [];
let matchedPairs = 0;


document.querySelectorAll (".card").forEach(card => {
    card.addEventListener("click", function() {
        if(Flippedcards.length < 2 && !this.classList.contains("flipped")) {
            this.classList.add("Flipped");
            this.querySelector("img").classList.remove("hidden");
            Flippedcards.push (this);

            if (flippedCards.length === 2) {
                setTimeout (checkMatch, 1000);
            }
    
        }
    });
});

function checkMatch () {
    let (card1, card2) = flippedCards;
    let img1 = card1.querySelector ("img").scr;
    let img2 = card2.querySelector ("img").scr;

    if (img1 === img2) {
        matchedPairs++;
        if (matchedPairs === 6){
            alert ("Gefeliciteerd! Je hebt een pokemon verzameld!");
         }
    } else {
        
        card1.classList.remove("Flipped");
        card1.querySelector("img").classList.add("hidden");
        card2.classList.remove("Flipped");
        card2.querySelector("img").classList.add("hidden");

    }

          Flippedcards = [];
     }

});
