import sendMessage from './send-message'
import proxy from './proxy'
import checkItPhones from './checked-phone'
import { addShowForm } from './add-event'

sendMessage('.send-messages')
proxy('.check-proxy')
checkItPhones('.check-phones')
addShowForm('#created-task', 'popup-open')
