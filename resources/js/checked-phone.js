import axios from 'axios'

export default function checkItPhones($phones) {
  const forms = document.querySelectorAll($phones)

  forms.forEach((form) => {
    const check = (e) => {
      e.preventDefault()
      axios.post('/api/check-it-phones', new FormData(form)).then((e) => console.log(e))
    }

    form.addEventListener('submit', check)
  })
}
