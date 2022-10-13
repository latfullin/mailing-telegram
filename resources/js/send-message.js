import axios from 'axios'

export default function (form) {
  const sendMessages = document.querySelectorAll(form)

  sendMessages.forEach((element) => {
    const fields = element.querySelectorAll('input[required]')
    const message = element.querySelector('textarea[required]')

    const validate = () => {
      let error = false
      fields.forEach((field) => {
        if (field.value.length > 30) {
          error = true
        }
      })
      if (15 >= message.value.length || message.value.length > 1300) {
        error = true
      }
      return error
    }

    const sendMessage = (e) => {
      e.preventDefault()
      if (!validate()) {
        axios
          .post('api/send-message', new FormData(element))
          .then((e) => console.log(e))
          .catch((error) => console.log(error))
      } else {
        console.log('error')
      }
    }

    element.addEventListener('submit', sendMessage)
  })
}
