import axios from 'axios'
import { notification } from './notification'

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
          .post('/api/send-message', new FormData(element))
          .then((e) => notification(e.data, e.status))
          .catch((error) => notification(error.response.data, error.response.status))
      } else {
        notification('Проверьте поля на наличие ошибок', 7)
      }
    }

    element.addEventListener('submit', sendMessage)
  })
}
