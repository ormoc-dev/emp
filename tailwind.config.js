


module.exports = {
  content: [
      "./resources/**/*.{js,jsx,ts,tsx,blade.php,vue}",
      "./node_modules/flowbite/**/*.js",
      './vendor/livewire/**/*.blade.php',
  ],
  theme: {
      extend: {
        fontFamily: {
        //  indie: ['"Indie Flower"', 'cursive'],
        },
      },
  },
  plugins: [
      require('daisyui'),
      require('flowbite/plugin')
  ], 
  daisyui: {
    themes: ["garden"],
  },

}