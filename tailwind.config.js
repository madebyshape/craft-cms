const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');
const alpha = { 100: 'FF', 90: 'E6', 80: 'CC', 70: 'B3', 60: '99', 50: '80', 40: '66', 30: '4D', 20: '33', 10: '1A' };

module.exports = {
  mode: 'jit',
  theme: {
    extend: {
      colors: {
        primary: colors.indigo,
        secondary: colors.teal,   
        gray: colors.gray,       
        brands: {
          facebook: '#3b5998',
          twitter: '#55acee',
          instagram: '#3f729b',
          linkedin: '#0976b4',
          youtube: '#e52d27',
          vimeo: '#1ab7ea',
          pinterest: '#cc2127'
        }
      },
      fontSize: theme => ({
        'xs':   '0.75rem',  // 12
        'sm':   '0.875rem', // 14
        'base': '1rem',     // 16
        'md':   '1.125rem', // 18
        'lg':   '1.25rem',  // 20
        'xl':   '1.5rem',   // 24
        '2xl':  '1.875rem', // 30
        '3xl':  '2.25rem',  // 36
        '4xl':  '3rem',     // 48
        '5xl':  '3.75rem',  // 60
        '6xl':  '4.5rem',   // 72
        '7xl':  '6rem',     // 96
        '8xl':  '8rem',     // 128
        '9xl':  '10rem',    // 160
      }),
      fontFamily: {
        'sans-primary': [
          ...defaultTheme.fontFamily.sans
        ],
        'serif-primary': [
          ...defaultTheme.fontFamily.serif
        ],
        'mono-primary': [
          ...defaultTheme.fontFamily.mono
        ],
      },
      boxShadow: theme => ({
        'outline': '0 0 0 3px ' + theme('colors.primary.500') + alpha[20],
        'focus': '0 0 0 3px ' + theme('colors.primary.500') + alpha[20]
      }),
      container: {
        center: true,
        padding: {
          DEFAULT: '1rem',
          sm: '2rem',
          lg: '4rem',
          xl: '5rem'
        }
      },
      width: {
        'fit': 'fit-content'
      },
      height: {
        'screen-fix': 'calc(var(--vh, 1vh) * 100);'
      },
      inset: {
        '0': 0,
        '1/2': '50%'
      },
      transitionDuration: {
        DEFAULT: '500ms'
      },
      transitionTimingFunction: {
        DEFAULT: 'cubic-bezier(0.1, 0.6, 0.4, 1)'
      },
      transitionProperty: {
        'width': 'width'
      },
      // Plugins
      aspectRatio: {
        '1/1': [1, 1],
        '16/9': [16, 9],
        '4/3': [4, 3]
      }
    },
    screens: {
      ...defaultTheme.screens,
    }
  },
  variants: {
    extend: {
      translate: ['group-hover'],
      scale: ['group-hover'],
      backgroundColor: ['checked']
    }
  },
  plugins: [
    require('tailwindcss-aspect-ratio')(),
    require('tailwindcss-typography')({ componentPrefix: '' })
  ],
  future: {
    removeDeprecatedGapUtilities: true,
    purgeLayersByDefault: true
  }
}
