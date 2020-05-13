let sendNudgeButton = document.querySelector('.nudge__popup__send')
let userId1
let userId2
let text

sendNudgeButton.addEventListener("click", (e) => {
    document.querySelector('.blur').style.display="block"
    text = document.querySelector('#nudgeMessage').value
    userId1 = sendNudgeButton.dataset.userid1
    userId2 = sendNudgeButton.dataset.userid2
  
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
        document.querySelector('.nudge__complete').style.display="block"
        console.log(formData.get('text'))
      })
      .catch((error) => {
      console.error('Error:', error);
      });
  })

  document.querySelector('.blur').addEventListener('click', () => {
    document.querySelector('.blur').style.display="none"
    document.querySelector('.nudge__complete').style.display = "none"
  })

  document.querySelector('.nudge__complete').addEventListener('click', () => {
    document.querySelector('.blur').style.display="none"
    document.querySelector('.nudge__complete').style.display = "none"
  })