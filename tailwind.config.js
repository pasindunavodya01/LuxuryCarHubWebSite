/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index1.php",
    "./index.php",        
    "./src/**/*.{php,js,jsx,ts,tsx}", 
  ], 
  theme: {
    extend: {
      colors: {customGreen: '#1F2937;',
      },
    },
  },
  plugins: [],
}

