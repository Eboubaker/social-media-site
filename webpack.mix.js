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
    })
    .purgeCss();
// google icons
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.eot", 'public/fonts');
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.ijmap", 'public/fonts');
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.svg", 'public/fonts');
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.ttf", 'public/fonts');
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.woff", 'public/fonts');
mix.copy("node_modules/material-design-icons/iconfont/MaterialIcons-Regular.woff2", 'public/fonts');
