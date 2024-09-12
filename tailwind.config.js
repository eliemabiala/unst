/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      fontSize: {
        'xxs': '0.625rem', // Définir une taille de police encore plus petite
      },
    },
  },
  plugins: [],
}
