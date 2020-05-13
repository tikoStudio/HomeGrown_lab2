joinBtn = document.querySelector('.join__community')

let userId
let communityId

joinBtn.addEventListener("click", () => {
    userId = joinBtn.dataset.userid1
    communityId = joinBtn.dataset.communityid

    let formData = new FormData();
    formData.append('userId', userId) 
    formData.append('communityId', communityId) 

    fetch('ajax/joinCommunityRequest.php', {
        method: 'POST',
        body: formData
        })
        .then((response) => response.json())
        .then((result) => {
          console.log("joined")
        })
        .catch((error) => {
        console.error('Error:', error);
        });
})