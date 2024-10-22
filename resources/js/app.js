import { HSStaticMethods } from 'preline';
import './bootstrap';
import 'preline';

document.addEventListener('livewire:navigated', () => { 
    HSStaticMethods.autoInit();
})
