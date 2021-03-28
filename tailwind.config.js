module.exports = {
    purge: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue"
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                logo: {
                    red: "#f05454",
                    black: "#222831",
                    white: "#ffffff"
                }
            },
            lineHeight: {
                "12": "250px"
            }
        }
    },
    variants: {
        extend: {}
    },
    plugins: []
};
