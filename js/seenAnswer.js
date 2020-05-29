let continuebtn = document.querySelector('.nudge__popup__send')

continuebtn.addEventListener('click', (e) => {
    id = continuebtn.dataset.requestid
    let formData = new FormData()
    formData.append('id', id) 

    fetch('ajax/seeAnswer.php', {
        method: 'POST',
        body: formData
        })
        .then((response) => response.json())
        .then((result) => {
          document.querySelector('.blur').style.display = "none"
          document.querySelector('.nudge__popup__request').style.display="none"
          document.location.href = "index.php";
        })
        .catch((error) => {
        console.error('Error:', error);
        });
})