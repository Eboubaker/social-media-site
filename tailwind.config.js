module.exports = {
  purge: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "/storage/app/framework/views/*.php",
  ],
  darkMode: 'media', // or 'media' or 'class' or false
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
      display: ['hover', 'group-hover']
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
