let nudgeButtons = document.querySelectorAll('.member--nudge')

nudgeButtons.forEach(element => {
  element.addEventListener("click", (e) => {
      document.querySelector('.blur').style.display="block"
      document.querySelector('.nudge__popup').style.display="block"
  })  
})

let sendNudgeButton = document.querySelector('.nudge__popup__send')

sendNudgeButton.addEventListener("click", (e) => {
  document.querySelector('#nudgeMessage').value = ""
  document.querySelector('.nudge__popup').style.display="none"
  document.querySelector('.nudge__complete').style.display="block"
})

let nudgeComplete = document.querySelector('.nudge__complete')

nudgeComplete.addEventListener("click", (e) => {
  document.querySelector('.blur').style.display="none"
  document.querySelector('.nudge__complete').style.display="none"
})

let blur = document.querySelector('.blur')

blur.addEventListener("click", (e) => {
  document.querySelector('.blur').style.display="none"
  document.querySelector('.nudge__popup').style.display="none"
  document.querySelector('.nudge__complete').style.display="none"
})