import axios from 'axios'
import { notification } from './notification'

export default function ($element) {
  const proxy = document.querySelectorAll($element)

  proxy.forEach((e) => {
    const checkProxy = (form) => {
      form.preventDefault()
      axios
        .post('/api/proxy-check-active')
        .then((response) => notification(response.data, 'success'))
        .catch((error) => notification(error.response.data, 'error'))
    }

    e.addEventListener('submit', checkProxy)
  })
}
