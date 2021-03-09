module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      color:{
        logo:{
          red:'#',
          dark:'#',
          white:'#'
        }
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
};
