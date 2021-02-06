# Metabox Admin Map Reller Wordpress

## webpack.dev.js

- Modify the proxy field by the development url
<pre>
    plugins: [
        new BrowserSyncPlugin({
            proxy: 'http://localhost:8888/tiendaubicacion/', //Modify url input
            files: [
                './**/*.php',
                './src-js/*'
            ],
            port: 3000
        })
    ]
</pre>


## Running
1. Clone this repository in your plugins folder
1. Activate the plugin

## Post Installation
1. The name of the plugin class is `Base_Plugin`, change the class name with your desired class name.
1. Replace the PHP namespace `App` with your desired name.
1. Replace `baseplugin` or `BASEPLUGIN` reference in files.
1. Run `npm install`
1. To start developing, run `npm run dev`
1. For production build, run `npm run build`

## About
Made by [Tareq Hasan](https://github.com/tareq1988) from [weDevs](https://wedevs.com).
*Found anything that can be improved? You are welcome to contribute.*
