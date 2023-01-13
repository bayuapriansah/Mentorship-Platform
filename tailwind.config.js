/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'dark-blue' : '#000F8A',
        'darker-blue' : '#000864',
        'light-brown' : '#DEAA51',
        'grey' : '#838383',
        'light-blue' : '#A4AADC',
        'light-black' : '#2C2C2C',
        'lighter-blue' : '#C8CEFC',
        'lightest-blue' : '#E4E7FF',
        'blue-light' : '#98A1FF',
        'light-grey' : '#D9D9D9',
        'lightest-grey': '#B9C0F4',
        'red-alert': '#F4D2D5',
        'ligt-black' : '#1E1E1E'
      },
      fontSize: {
        sm: '0.938rem',
        base: '1rem',
        xl: '1.25rem',
        '2xl': '1.563rem',
        '3xl': '2.25rem',
        '4xl': '2.875rem',
        '5xl': '3.052rem',
      },
      lineHeight: {
        'extra-loose': '2.5',
        '11': '2.875rem',
      }
    },
  },
  plugins: [],
}
