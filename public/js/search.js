const search1 = document.querySelector('input[placeholder="Miejscowość lub kod pocztowy"]');
const search2 = document.querySelector('input[placeholder="Promień wyszukiwań (km)"]');
const button = document.querySelector('button[class="fm-button"]');

button.addEventListener("click", function(){


    const data1 = {search1: search1.value};
    const data2 = {search2: search2.value};

    //Don't run anything if any of the values are undefined
    if(!search1.value || !search2.value ) return

    // Access the data via the object property you stored it in
    // console.log(data1.search1, data2.search2);

    fetch("/get_match", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            location: data1.search1,
            zakres: data2.search2
            })
    }).then(function (response) {
        return response.json();
    }).then(function (matches){
        matchesContainer.innerHTML = "";
        loadMatches(matches);
    })
});


function loadMatches(matches){

    matches.forEach(match =>{
        console.log(match);
        createMatch(match);
    });
}
const matchesContainer = document.querySelector(".games-near-you");

function createMatch(match){
    const template = document.querySelector("#match-template");
    const clone = template.content.cloneNode(true);

    const location = clone.querySelector(".getLocation");
    location.textContent = match.location;
    const dstc = clone.querySelector(".getDstc");
    dstc.textContent = match.round + "km";
    const league = clone.querySelector(".getLeague");
    league.textContent = match.nameC;
    const date = clone.querySelector(".getData");
    date.textContent = match.date;
    const teamA = clone.querySelector(".getTeamA");
    teamA.textContent = match.nameA;
    const teamB = clone.querySelector(".getTeamB");
    teamB.textContent = match.nameB;

    matchesContainer.appendChild(clone);
}
