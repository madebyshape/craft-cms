/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme');

export default {
  content: [
    './templates/**/*.{twig,html,js}',
    './src/**/*.{css,js}'
  ],
  theme: {
    screens: {
      'xs': '375px',
      ...defaultTheme.screens,
      '3xl': '1600px',
      '4xl': '1920px'
    },
    extend: {
      colors: {
        brands: {
          facebook: '#1877f2',
          twitter: '#1da1f2',
          x: '#14171a',
          instagram: '#405de6',
          linkedin: '#0a66c2',
          youtube: '#ff0000',
          vimeo: '#1ab7ea',
          pinterest: '#e60023',
          tiktok: '#ff0050',
        }
      },
      fontSize: {
        'xs':   '0.75rem',  // 12
        'sm':   '0.875rem', // 14
        'base': '1rem',     // 16
        'md':   '1.063rem', // 17
        'lg':   '1.125rem', // 18
        'xl':   '1.25rem',  // 20
        '2xl':  '1.5rem',   // 24
        '3xl':  '1.875rem', // 30
        '4xl':  '2.25rem',  // 36
        '5xl':  '3rem',     // 40
        '6xl':  '3.75rem',  // 60
        '7xl':  '4.5rem',   // 72
        '8xl':  '6rem',     // 96
        '9xl':  '8rem',     // 128
      },
      fontFamily: {
        'sans-primary': [
          ...defaultTheme.fontFamily.sans
        ],
        'serif-primary': [
          ...defaultTheme.fontFamily.serif
        ]
      },
    },
  },
  plugins: [
    require('@tailwindcss/aspect-ratio'),
  ],
}