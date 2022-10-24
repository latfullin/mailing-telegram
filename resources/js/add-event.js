export function addShowForm($class, $classOpen) {
  const item = document.querySelector($class)
  if (!item) {
    return
  }
  let hash = []

  const popup = () => {
    hash.filter((className) => className === item.value) == 0 ? hash.push(item.value) : ''

    hash.forEach((element) => {
      element == item.value ? '' : closedPopup(element)
    })
    openPopup(item.value)
  }

  const closedPopup = ($element) => {
    document.querySelectorAll(`.${$element}`).forEach((e) => {
      e.classList.remove($classOpen)
      e.style.order = '2'
    })
  }

  const openPopup = ($element) => {
    document.querySelectorAll(`.${$element}`).forEach((e) => {
      e.classList.add($classOpen)
      e.style.order = '1'
    })
  }

  item.addEventListener('input', popup)
  popup()
}
