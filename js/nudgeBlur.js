
let blurred = document.querySelector('.blur--active')

if(blurred) {
  blurred.addEventListener("click", (e) => {
    document.querySelector('.blur--active').style.display="none"
    document.querySelector('.nudgeList').style.display="none"
    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '';
  window.history.pushState({ path: newurl }, '', newurl);
  })
}

