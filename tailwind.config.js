module.exports = {
  purge: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "/storage/app/framework/views/*.php",
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      fontSize:{
        xxsm: '.6rem'
      },
      colors: {
        logo: {
          red: "#f05454",
          black: "#222831",
          white: "#ffffff",
        },
        primary: {
          light: "#848ccf",
          hard: "#648ccf",
        },
      },
      lineHeight: {
        "12": "250px",
      },
    },
  },
  variants: {
    extend: {
      backgroundColor: ["active"],
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
