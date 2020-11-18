const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

const alpha = { 100: 'FF', 90: 'E6', 80: 'CC', 70: 'B3', 60: '99', 50: '80', 40: '66', 30: '4D', 20: '33', 10: '1A' };

module.exports = {
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
        'xs': ['0.75rem', theme('lineHeight.normal')],    // 12
        'sm': ['0.875rem', theme('lineHeight.normal')],   // 14
        'base': ['1rem', theme('lineHeight.normal')],     // 16
        'md': ['1.125rem', theme('lineHeight.normal')],   // 18
        'lg': ['1.25rem', theme('lineHeight.normal')],    // 20
        'xl': ['1.5rem', theme('lineHeight.normal')],     // 24
        '2xl': ['1.875rem', theme('lineHeight.normal')],  // 30
        '3xl': ['2.25rem', theme('lineHeight.normal')],   // 36
        '4xl': ['3rem', theme('lineHeight.normal')],      // 48
        '5xl': ['4rem', theme('lineHeight.normal')],      // 64
        '6xl': ['4.5rem', theme('lineHeight.normal')]     // 72
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
          default: '1rem',
          sm: '2rem',
          lg: '4rem',
          xl: '5rem'
        }
      },
      height: {
        'screen-fix': 'calc(var(--vh, 1vh) * 100);'
      },
      inset: {
        '0': 0,
        '1/2': '50%'
      },
      transitionDuration: {
        default: '500ms'
      },
      transitionTimingFunction: {
        default: 'cubic-bezier(0.4, 0, 0.2, 1)'
      },
      // Plugins
      typography: theme => ({
        default: {
          css: {
            a: {
              color: theme('colors.primary.500'),
              '&:hover': {
                color: theme('colors.primary.600'),
              }
            }
          }
        }
      }),
      aspectRatio: {
        'square': [1, 1],
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
      scale: ['group-hover']
    }
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('tailwindcss-typography')({ componentPrefix: '' }),
    require('tailwindcss-aspect-ratio')()
  ],
  future: {
    removeDeprecatedGapUtilities: true,
    purgeLayersByDefault: true
  }
}
