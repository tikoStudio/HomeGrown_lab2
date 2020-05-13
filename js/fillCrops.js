let crop1 = document.querySelector('.crop1')
let crop2 = document.querySelector('.crop2')
let crop3 = document.querySelector('.crop3')


function isEmpty(value){
    return (value == null || value.length === 0);
}

if(!isEmpty(crop1)) {
    crop1.addEventListener('click', () => {
        console.log("crop1")
    })
}

if(!isEmpty(crop2)){
    crop2.addEventListener('click', () => {
        console.log("crop2")
    })
}

if(!isEmpty(crop3)){
    crop3.addEventListener('click', () => {
        console.log("crop3")
    })
}


