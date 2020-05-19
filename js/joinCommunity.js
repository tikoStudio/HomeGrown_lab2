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
            document.querySelector('.nudge__complete__request').style.display = "block"
            document.querySelector('.blurReq').style.display = "block"
            joinBtn.style.display = "none"
            document.querySelector('.btn--chat--field').classList.add("top__container")
            document.querySelector('.join__container').style.display = "none"
        })
        .catch((error) => {
        console.error('Error:', error);
        });
})

document.querySelector('.blurReq').addEventListener('click', () => {
    document.querySelector('.nudge__complete__request').style.display = "none"
    document.querySelector('.blurReq').style.display = "none"
})

document.querySelector('.nudge__complete__request').addEventListener('click', () => {
    document.querySelector('.nudge__complete__request').style.display = "none"
    document.querySelector('.blurReq').style.display = "none"
})