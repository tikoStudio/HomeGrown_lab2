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

  // make form en maak ajax call om nudge in database te stoppen
  let formData = new FormData();
  formData.append('userId1', userId1)  
  formData.append('userId2', userId2)
  formData.append('text', text)
  fetch('ajax/sendNudge.php', {
    method: 'POST',
    body: formData
    })
    .then((response) => response.json())
    .then((result) => {
      document.querySelector('#nudgeMessage').value = ""
      document.querySelector('.nudge__popup').style.display="none"
      document.querySelector('.nudge__complete').style.display="block"
      //console.log(formData.get('text'))
    })
    .catch((error) => {
    console.error('Error:', error);
    });
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