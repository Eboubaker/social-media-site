const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");

require("laravel-mix-purgecss");

mix.js("resources/js/app.js", "public/js")
    .vue()
    .sass("resources/sass/app.scss", "public/css")
    .options({
        notificationsOnSuccess: false,
        processCssUrls: true,
        postCss: [tailwindcss("./tailwind.config.js")],
    });

//TODO: in production use a cdn to get material-icons css library (less heavy for our server)
//
// google icons
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.eot", 'public/fonts');
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.ijmap", 'public/fonts');
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.svg", 'public/fonts');
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.ttf", 'public/fonts');
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.woff", 'public/fonts');
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.woff2", 'public/fonts');


mix.copy("node_modules/intl-tel-input/build/img/flags.png", 'public/img');
mix.copy("node_modules/intl-tel-input/build/img/flags@2x.png", 'public/img');
