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

