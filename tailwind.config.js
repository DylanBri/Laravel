const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');
const customColors = colors;
customColors.transparent = 'transparent';
customColors.current = '#34d399';
customColors.indigo = colors.coolGray;
customColors.gray = colors.coolGray;
// customColors.green = colors.indigo;

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/css/**/*.css',
        './Modules/**/Resources/views/**/*.blade.php',
    ],

    theme: {
        colors: customColors,
        minWidth: {
            '3/4': '75%',
            '2/3': '66%',
            '1/2': '50%',
            '1/3': '33%',
            '1/4': '25%',
          },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },
    
    corePlugins: {
        gradientColorStops: ['active'],
    },

    plugins: [require('@tailwindcss/forms')({
        strategy: 'class',
    }), require('@tailwindcss/typography')],
};
