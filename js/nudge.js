let nudgeButtons = document.querySelectorAll('.member--nudge')
let userId1
let userId2
let text


nudgeButtons.forEach(element => {
  element.addEventListener("click", (e) => {
      document.querySelector('.blur').style.display="block"
      document.querySelector('.nudge__popup').style.display="block"
      userId1 = element.dataset.userid1
      userId2 = element.dataset.userid2
  })  
})

let sendNudgeButton = document.querySelector('.nudge__popup__send')

sendNudgeButton.addEventListener("click", (e) => {
  text = document.querySelector('#nudgeMessage').value
  document.querySelector('#nudgeMessage').value = ""
  document.querySelector('.nudge__popup').style.display="none"
  document.querySelector('.nudge__complete').style.display="block"
  console.log(userId1)
  console.log(userId2)
  console.log(text)
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