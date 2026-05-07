import { mkdir, writeFile } from 'node:fs/promises';
import path from 'node:path';
import sharp from 'sharp';

const source = 'src/public/images/favicon.png';
const outputDir = 'src/public/favicons';
const publicPath = '/dist/favicons';

const pngAssets = [
    ['favicon-16x16.png', 16, 16],
    ['favicon-32x32.png', 32, 32],
    ['favicon-48x48.png', 48, 48],
    ['android-chrome-36x36.png', 36, 36],
    ['android-chrome-48x48.png', 48, 48],
    ['android-chrome-72x72.png', 72, 72],
    ['android-chrome-96x96.png', 96, 96],
    ['android-chrome-144x144.png', 144, 144],
    ['android-chrome-192x192.png', 192, 192],
    ['android-chrome-256x256.png', 256, 256],
    ['android-chrome-384x384.png', 384, 384],
    ['android-chrome-512x512.png', 512, 512],
    ['apple-touch-icon-57x57.png', 57, 57],
    ['apple-touch-icon-60x60.png', 60, 60],
    ['apple-touch-icon-72x72.png', 72, 72],
    ['apple-touch-icon-76x76.png', 76, 76],
    ['apple-touch-icon-114x114.png', 114, 114],
    ['apple-touch-icon-120x120.png', 120, 120],
    ['apple-touch-icon-144x144.png', 144, 144],
    ['apple-touch-icon-152x152.png', 152, 152],
    ['apple-touch-icon-167x167.png', 167, 167],
    ['apple-touch-icon-180x180.png', 180, 180],
    ['apple-touch-icon-1024x1024.png', 1024, 1024],
    ['apple-touch-icon.png', 180, 180],
    ['apple-touch-icon-precomposed.png', 180, 180],
    ['mstile-70x70.png', 70, 70],
    ['mstile-144x144.png', 144, 144],
    ['mstile-150x150.png', 150, 150],
    ['mstile-310x150.png', 310, 150],
    ['mstile-310x310.png', 310, 310],
    ['yandex-browser-50x50.png', 50, 50],
];


const resizePng = async (width, height) => {
    const iconSize = Math.min(width, height);

    return sharp({
        create: {
            width,
            height,
            channels: 4,
            background: { r: 255, g: 255, b: 255, alpha: 0 },
        },
    })
        .composite([{
            input: await sharp(source)
                .resize(iconSize, iconSize, { fit: 'contain' })
                .png()
                .toBuffer(),
            gravity: 'center',
        }])
        .png()
        .toBuffer();
};

const createIco = async () => {
    const images = await Promise.all([16, 32, 48].map(async (size) => ({
        size,
        buffer: await resizePng(size, size),
    })));
    const headerSize = 6 + (images.length * 16);
    let offset = headerSize;
    const header = Buffer.alloc(headerSize);

    header.writeUInt16LE(0, 0);
    header.writeUInt16LE(1, 2);
    header.writeUInt16LE(images.length, 4);

    images.forEach(({ size, buffer }, index) => {
        const entryOffset = 6 + (index * 16);
        header.writeUInt8(size === 256 ? 0 : size, entryOffset);
        header.writeUInt8(size === 256 ? 0 : size, entryOffset + 1);
        header.writeUInt8(0, entryOffset + 2);
        header.writeUInt8(0, entryOffset + 3);
        header.writeUInt16LE(1, entryOffset + 4);
        header.writeUInt16LE(32, entryOffset + 6);
        header.writeUInt32LE(buffer.length, entryOffset + 8);
        header.writeUInt32LE(offset, entryOffset + 12);
        offset += buffer.length;
    });

    return Buffer.concat([header, ...images.map(({ buffer }) => buffer)]);
};

const manifest = {
    name: '',
    short_name: '',
    icons: [36, 48, 72, 96, 144, 192, 256, 384, 512].map((size) => ({
        src: `${publicPath}/android-chrome-${size}x${size}.png`,
        sizes: `${size}x${size}`,
        type: 'image/png',
    })),
    theme_color: '#fff',
    background_color: '#fff',
    display: 'standalone',
};

const browserConfig = `<?xml version="1.0" encoding="utf-8"?>
<browserconfig>
  <msapplication>
    <tile>
      <square70x70logo src="${publicPath}/mstile-70x70.png"/>
      <square150x150logo src="${publicPath}/mstile-150x150.png"/>
      <wide310x150logo src="${publicPath}/mstile-310x150.png"/>
      <square310x310logo src="${publicPath}/mstile-310x310.png"/>
      <TileColor>#fff</TileColor>
    </tile>
  </msapplication>
</browserconfig>`;

const yandexManifest = {
    version: '1.0',
    api_version: 1,
    layout: {
        logo: `${publicPath}/yandex-browser-50x50.png`,
        color: '#ffffff',
        show_title: true,
    },
};

const html = [
    `<link rel="icon" type="image/x-icon" href="${publicPath}/favicon.ico">`,
    `<link rel="icon" type="image/png" sizes="16x16" href="${publicPath}/favicon-16x16.png">`,
    `<link rel="icon" type="image/png" sizes="32x32" href="${publicPath}/favicon-32x32.png">`,
    `<link rel="icon" type="image/png" sizes="48x48" href="${publicPath}/favicon-48x48.png">`,
    `<link rel="manifest" href="${publicPath}/manifest.webmanifest">`,
    '<meta name="mobile-web-app-capable" content="yes">',
    '<meta name="theme-color" content="#fff">',
    '<meta name="application-name">',
    ...[57, 60, 72, 76, 114, 120, 144, 152, 167, 180, 1024].map((size) => (
        `<link rel="apple-touch-icon" sizes="${size}x${size}" href="${publicPath}/apple-touch-icon-${size}x${size}.png">`
    )),
    '<meta name="apple-mobile-web-app-capable" content="yes">',
    '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">',
    '<meta name="apple-mobile-web-app-title">',
    '<meta name="msapplication-TileColor" content="#fff">',
    `<meta name="msapplication-TileImage" content="${publicPath}/mstile-144x144.png">`,
    `<meta name="msapplication-config" content="${publicPath}/browserconfig.xml">`,
    `<link rel="yandex-tableau-widget" href="${publicPath}/yandex-browser-manifest.json">`,
].join('\n');

await mkdir(outputDir, { recursive: true });

for (const [name, width, height] of pngAssets) {
    await writeFile(path.join(outputDir, name), await resizePng(width, height));
}

await Promise.all([
    writeFile(path.join(outputDir, 'favicon.ico'), await createIco()),
    writeFile(path.join(outputDir, 'manifest.webmanifest'), JSON.stringify(manifest, null, 2)),
    writeFile(path.join(outputDir, 'browserconfig.xml'), browserConfig),
    writeFile(path.join(outputDir, 'yandex-browser-manifest.json'), JSON.stringify(yandexManifest, null, 2)),
    writeFile(path.join(outputDir, 'favicon.html'), html),
]);

console.log(`Generated ${pngAssets.length + 5} favicon files in ${outputDir}`);
