
function handleButton(onFirstClick){
  var button = document.getElementById('leaderboardToggle');
  var leaderboard = document.getElementById('leaderboard');
  var isFirstly = true, isLoad = false;

  button.addEventListener('click', function () {
    if(isLoad) return false;

    if(isFirstly && onFirstClick){
      isFirstly = false;
      isLoad = true;
      return onFirstClick(()=>{ leaderboard.style.display = ""; isLoad = false});
    }

    if (leaderboard.style.display == "") {
      leaderboard.style.display = "none";
    } else {
      leaderboard.style.display = "";
    }
  });

}

export default handleButton;
