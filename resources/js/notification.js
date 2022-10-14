export function notification($response, $status = 3) {
  const $type = { 2: 'success', 3: 'neutral', 4: 'error' }

  if ($response.length > 100) {
    $response = 'Что-то пошло не так'
  }

  const firstSymbol = String($status)[0]
  const mainBlock = document.getElementsByClassName('notification')
  const newElement = document.createElement('div')

  newElement.className = `notification__${$type[firstSymbol] || 'neutral'} notification__message`

  newElement.innerHTML = $response
  mainBlock[0].append(newElement)

  setTimeout(() => (newElement.style.opacity = '0'), 1500)
  setTimeout(() => newElement.remove(), 3000)
}
