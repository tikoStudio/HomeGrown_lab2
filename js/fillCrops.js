let crop1 = document.querySelector('.crop1')
let crop2 = document.querySelector('.crop2')
let crop3 = document.querySelector('.crop3')

let crop1Popup = document.querySelector('.crop1__popup')
let crop2Popup = document.querySelector('.crop2__popup')
let crop3Popup = document.querySelector('.crop3__popup')

let crop1Area = document.querySelector('#crop1')
let crop2Area = document.querySelector('#crop2')
let crop3Area = document.querySelector('#crop3')

let sendBtn = document.querySelectorAll('.crop__popup__send')

let userId
let cropname

function isEmpty(value){
    return (value == null || value.length === 0);
}

if(!isEmpty(crop1)) {
    crop1.addEventListener('click', () => {
        document.querySelector('.blur').style.display = "block"
        crop1Popup.style.display = "block"
    })
}

if(!isEmpty(crop2)){
    crop2.addEventListener('click', () => {
        document.querySelector('.blur').style.display = "block"
        crop2Popup.style.display = "block"
    })
}

if(!isEmpty(crop3)){
    crop3.addEventListener('click', () => {
        document.querySelector('.blur').style.display = "block"
        crop3Popup.style.display = "block"
    })
}

sendBtn.forEach(element => {
    element.addEventListener('click', () => {
        if(element.id == "crop1Btn") {
            cropname = crop1Area.value
            userId = element.dataset.userid1
            if(cropname == "") {
                let warning = "please fill in a crop name"
                document.querySelector('.crop1Title').innerHTML = warning
            }else {
                let warning = "crop changed"
                document.querySelector('.crop1Title').innerHTML = warning

                let formData = new FormData();
                formData.append('userId', userId)  
                formData.append('cropname', cropname)

                fetch('ajax/sendCrop1.php', {
                    method: 'POST',
                    body: formData
                    })
                    .then((response) => response.json())
                    .then((result) => {
                        document.querySelector('.blur').style.display = "none"
                        crop1Popup.style.display = "none"
                        crop1.innerHTML = cropname
                    })
                    .catch((error) => {
                    console.error('Error:', error);
                    });

            }
        }else if(element.id == "crop2Btn") {
            cropname = crop2Area.value
            userId = element.dataset.userid1

            if(cropname == "") {
                let warning = "please fill in a crop name"
                document.querySelector('.crop2Title').innerHTML = warning
            }else {
                let warning = "crop changed"
                document.querySelector('.crop2Title').innerHTML = warning

                let formData = new FormData();
                formData.append('userId', userId)  
                formData.append('cropname', cropname)

                fetch('ajax/sendCrop2.php', {
                    method: 'POST',
                    body: formData
                    })
                    .then((response) => response.json())
                    .then((result) => {
                        document.querySelector('.blur').style.display = "none"
                        crop2Popup.style.display = "none"
                        crop2.innerHTML = cropname
                    })
                    .catch((error) => {
                    console.error('Error:', error);
                    });

            }

        }else {
            cropname = crop3Area.value
            userId = element.dataset.userid1

            if(cropname == "") {
                let warning = "please fill in a crop name"
                document.querySelector('.crop3Title').innerHTML = warning
            }else {
                let warning = "crop changed"
                document.querySelector('.crop3Title').innerHTML = warning

                let formData = new FormData();
                formData.append('userId', userId)  
                formData.append('cropname', cropname)

                fetch('ajax/sendCrop3.php', {
                    method: 'POST',
                    body: formData
                    })
                    .then((response) => response.json())
                    .then((result) => {
                        document.querySelector('.blur').style.display = "none"
                        crop3Popup.style.display = "none"
                        crop3.innerHTML = cropname
                    })
                    .catch((error) => {
                    console.error('Error:', error);
                    });

            }
        }
    })
});

document.querySelector('.blur').addEventListener('click', () => {
    document.querySelector('.blur').style.display = "none"
    crop1Popup.style.display = "none"
    crop2Popup.style.display = "none"
    crop3Popup.style.display = "none"
})