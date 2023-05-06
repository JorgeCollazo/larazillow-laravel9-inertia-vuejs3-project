/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',           // ** means "all folders inside recursively"
      './resources/js/**/*.vue',           // ** means "all folders inside recursively"
  ],
  theme: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/forms')     // Add the installed plugin
  ],
}

