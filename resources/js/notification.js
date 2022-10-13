export function notification($response, $type = 'neutral') {
  if ($response.length > 100) {
    $response = 'Что-то пошло не так'
  }

  const mainBlock = document.getElementsByClassName('notification')
  const newElement = document.createElement('div')

  newElement.className = `notification__${$type} notification__message`

  newElement.innerHTML = $response
  mainBlock[0].append(newElement)

  setTimeout(() => (newElement.style.opacity = '0'), 1500)
  setTimeout(() => newElement.remove(), 3000)
}
