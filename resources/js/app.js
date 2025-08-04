// resources/js/app.js

require("./bootstrap");

// If you use Vue, import Vue here as well
// window.Vue = require('vue');

// Pusher/Echo real-time setup
import Echo from "laravel-echo";
window.Pusher = require("pusher-js");

// If you're using Laravel Mix and your .env has VITE_PUSHER_APP_KEY/CLUSTER,
// use import.meta.env instead of process.env.
// For older Laravel Mix projects, process.env.MIX_PUSHER_APP_KEY/CLUSTER is correct.

window.Echo = new Echo({
    broadcaster: "pusher",
    key: process.env.MIX_PUSHER_APP_KEY, // or import.meta.env.VITE_PUSHER_APP_KEY for Vite
    cluster: process.env.MIX_PUSHER_APP_CLUSTER, // or import.meta.env.VITE_PUSHER_APP_CLUSTER
    forceTLS: true,
});

// Listen for the broadcast event
window.Echo.channel("proximity").listen("ProximityChecked", (e) => {
    alert("New proximity check: Distance = " + e.log.distance + " meters!");
    // Or update your UI in real time here
});

// Optionally, if you use Vue, mount your Vue app here
// const app = new Vue({ ... });
// app.$mount('#app');
