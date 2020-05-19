let acceptRequest = document.querySelector('#acceptRequest')
let denyRequest = document.querySelector('#denyRequest')

let communityId
let requestId
let userId

acceptRequest.addEventListener('click', () => {
    communityId = acceptRequest.dataset.communityid
    requestId = acceptRequest.dataset.requestid
    userId = acceptRequest.dataset.userid

    // make form en maak ajax call om nudge in database te stoppen
    let formData = new FormData();
    formData.append('communityId', communityId)  
    formData.append('requestId', requestId)
    formData.append('userId', userId)

    fetch('ajax/acceptRequest.php', {
        method: 'POST',
        body: formData
        })
        .then((response) => response.json())
        .then((result) => {
            document.location.href = "index.php";
        })
        .catch((error) => {
        console.error('Error:', error);
        });

})

denyRequest.addEventListener('click', () => {
    requestId = acceptRequest.dataset.requestid

      // make form en maak ajax call om nudge in database te stoppen
      let formData = new FormData();  
      formData.append('requestId', requestId)

      fetch('ajax/denyRequest.php', {
        method: 'POST',
        body: formData
        })
        .then((response) => response.json())
        .then((result) => {
            document.location.href = "index.php";
        })
        .catch((error) => {
        console.error('Error:', error);
        });
})