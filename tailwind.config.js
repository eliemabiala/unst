/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        'custom-blue': '#14213D',
        'custom-sky-blue': '#0284C7',
      },
      fontSize: {
        'xxs': '0.625rem', 
      },
      screens: {
        'sm-md': '825px', // Point de rupture personnalisé pour 825px
      },
    },
  },
  plugins: [],
}
