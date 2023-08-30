// import './bootstrap';
import 'flowbite';
// Initialization for ES Users
import { Rating, initTE } from "tw-elements";
initTE({ Rating }, true ); // set second parameter to true if you want to use a debugger

document.addEventListener("DOMContentLoaded", function() {
    const textarea = document.getElementById('feedback');
    const counter = document.getElementById('counter');

    if (textarea && counter) {
        console.log("Textarea and counter found", textarea, counter);  // Debug line
        counter.textContent = `${textarea.value.length}/255`;

        textarea.addEventListener('input', function() {
            console.log("Input event triggered");  // Debug line
            counter.textContent = `${this.value.length}/255`;

            if (this.value.length > 255) {
                this.value = this.value.substring(0, 255);
            }
        });
    } else {
        console.log("Textarea or counter not found");  // Debug line
    }
});
require('./swiperInit');