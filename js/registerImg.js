document.querySelector('#avatar').addEventListener('change', () => {
    const file = document.querySelector('#avatar').files[0]

    if(file) {
        const reader = new FileReader()

        reader.addEventListener('load', () => {
            if(reader.result.includes('image/gif') || reader.result.includes('image/jpeg') || reader.result.includes('image/png')) {
                imgError = false
                document.querySelector('.form__avatar').setAttribute('src', reader.result)
                let splitted = document.querySelector('#avatar').value.split("C:\\fakepath\\")
                image = splitted[1]
                imgUpload = true
            } else {
                imgError = true
                imgUpload = false
            }
        })

        reader.readAsDataURL(file)
    }
})