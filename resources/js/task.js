import axios from 'axios'
import { notification } from './notification'

export function continueTask($task) {
  const fields = $task.querySelectorAll('input[required]')

  fields.foreach((field) => {})

  axios
    .post('/api/continue-task', new FormData())
    .then((e) => e.data)
    .catch((error) => notification(error, 'error'))
}
