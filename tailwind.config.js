const defaultTheme = require('tailwindcss/defaultTheme');
const alpha = { 100: 'FF', 90: 'E6', 80: 'CC', 70: 'B3', 60: '99', 50: '80', 40: '66', 30: '4D', 20: '33', 10: '1A' };

module.exports = {
  theme: {
    extend: {
      colors: {
        primary: {
          100: '#F0F2FD',
          200: '#D9DFFA',
          300: '#C2CBF7',
          400: '#94A5F0',
          500: '#667EEA',
          600: '#5C71D3',
          700: '#3D4C8C',
          800: '#2E3969',
          900: '#1F2646'
        },
        secondary: {
          100: '#EBF7F7',
          200: '#CDECEA',
          300: '#AFE0DE',
          400: '#74C9C5',
          500: '#38B2AC',
          600: '#32A09B',
          700: '#226B67',
          800: '#19504D',
          900: '#113534'
        },          
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
      // Plugins
      textStyles: theme => ({
        richText: {
          fontSize: theme('fontSize.base')[0],
          lineHeight: theme('fontSize.base')[1],
          'h1, h2, h3, h4, h5, h6': {
            marginBottom: theme('spacing.4')
          },
          'h1': {
            fontSize: theme('fontSize.3xl')[0],
            lineHeight: theme('fontSize.3xl')[1]
          },
          'h2': {
            fontSize: theme('fontSize.2xl')[0],
            lineHeight: theme('fontSize.2xl')[1]
          },
          'h3': {
            fontSize: theme('fontSize.xl')[0],
            lineHeight: theme('fontSize.xl')[1]
          },
          'h4': {
            fontSize: theme('fontSize.lg')[0],
            lineHeight: theme('fontSize.lg')[1]
          },
          'h5': {
            fontSize: theme('fontSize.md')[0],
            lineHeight: theme('fontSize.md')[1]
          },
          'h6': {
            fontSize: theme('fontSize.base')[0],
            lineHeight: theme('fontSize.base')[1]
          },
          'ul,ol': {
            listStylePosition: 'inside',
            marginBottom: theme('spacing.4')
          },
          'ul': {
            listStyleType: 'disc',
          },
          'ol': {
            listStyleType: 'decimal',
          },
          'a': {
            textDecoration: 'underline',
            color: theme('colors.primary.500'),
            '&:hover': {
              color: theme('colors.primary.600')
            }
          },
          'b, strong': {
            fontWeight: theme('fontWeight.bold'),
          },
          'i, em': {
            fontStyle: 'italic',
          }
        }
      }),
      animations: {},
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
    textColor: ['responsive', 'hover', 'focus', 'group-hover'],
    backgroundColor: ['responsive', 'hover', 'focus', 'group-hover'],
    opacity: ['responsive', 'hover', 'group-hover'],
    translate: ['responsive', 'hover', 'group-hover'],
    scale: ['responsive', 'hover', 'group-hover'],
    animations: ['responsive', 'hover', 'group-hover']
  },
  plugins: [
    require('tailwindcss-typography')({ componentPrefix: '' }),
    require('tailwindcss-aspect-ratio')(),
    require('tailwindcss-animations')
  ],
  purge: []
}
