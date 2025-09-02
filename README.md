# OWC Multisite theme

This WordPress multisite theme contains 20+ building blocks and an easy to use theme editor which allows you to create numerous unique websites. 

**Examples**\
https://www.tramkade.nl/ \
https://www.tomdenbosch.nl/ \
https://www.ombudscommissiegemeentes-hertogenbosch.nl/ \
https://www.rekenkamershertogenbosch.nl/


This WordPress multisite theme is developed for Gemeente 's-hertogenbosch and provided to the OWC by Stuurlui. Please contact us via support@stuurlui.nl or 
+31 (0)30 227 4000 when you run into issues or you have any questions.

This theme requires two paid plugins (Advanced Custom Fields PRO and FacetWP) to work properly.

## Getting started
- Create a WordPress Multisite on your local machine or webserver.
- Install the required plugins.

## Required plugins
This theme requires Advanced Custom Fields PRO to work.\
Download ACF PRO https://www.advancedcustomfields.com/pro/ 

This theme uses FacetWP for filters and post type overviews. 
FacetWP https://facetwp.com/pricing/

### Optional plugins
- Gravity Forms https://www.gravityforms.com/pricing/
- FacetWP map facet (only used for maps)

## Next steps
Network activate the plugins.\
Network activate this theme.\
Download/Clone this repo. Or download latest release .zip.  And unpack it in your themes directory. Make sure the theme is called 'owc-multisite-theme'.\
Navigate to the subsite and activate the 'owc-multisite-theme' theme.

## Default pages 
NOTE: When you've activated the theme before the required plugins then you'll need to set some default pages manually.
Otherwise the pages Home, Search and 404 not found should be generated automatically.
Otherwise, navigate in wp-admin to:\
STUURLUI Global and select a default page for search and 404\

### Google Fonts API KEY
- This this theme also requires a Google Fonts API key so you can select the font's you want to use whithin your website.\
https://developers.google.com/fonts/docs/developer_api

## Styling
Go to: 
STUURLUI Global > Website styling > Type typography = Enter a Google Fonts API key\
STUURLUI Global > Website styling = configure your website styling\
STUURLUI Global > Website styling > Theme logo = website logo

## Language
Unpack the language-pack.zip into your wp-content/languages folder for Dutch translations


## Code editing
To make code changes to this theme open the theme directory in a code editor like VScode. Run the next command to install the required node modules.
```
npm install
```
All the compiled and minified styling and front-end scripts can be found in the assets folder. The source files are in the source folder. To make changes you can edit the files in the source folder.
```
cd source
```
To apply the changes run 
```
gulp b-default
``` 
This will regenerate all the assets files.
You can also run SCSS and JS separately. Run 
``` 
gulp --task
```
to see all available tasks.


