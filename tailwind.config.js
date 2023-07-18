/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'disable',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        'dark-blue' : '#000F8A',
        'darker-blue' : '#000864',
        'light-brown' : '#DEAA51',
        'dark-brown' : '#B57E1D',
        'grey' : '#838383',
        'light-blue' : '#A4AADC',
        'light-black' : '#2C2C2C',
        'lighter-blue' : '#C8CEFC',
        'lightest-blue' : '#E4E7FF',
        'blue-light' : '#98A1FF',
        'light-grey' : '#D9D9D9',
        'lightest-grey': '#B9C0F4',
        'profile-grey': '#F8F8F8',
        'red-alert': '#F4D2D5',
        'ligt-black' : '#1E1E1E',
        'light-green': '#1CD22E',
        'lighter-green': '#D4F9CB',
        'dark-yellow': '#CB9713',
        'dark-red': '#B52809'
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
  variants: {
    extend: {
      display: ['responsive']
    }
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
