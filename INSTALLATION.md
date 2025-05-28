# Quick Installation Guide

## Prerequisites
- WordPress 5.0+
- Elementor 3.0.0+
- PHP 7.4+

## Installation Steps

### 1. Upload Plugin
1. Download all plugin files
2. Upload the entire folder to `/wp-content/plugins/age-verification-popup/`
3. Activate the plugin in WordPress Admin > Plugins

### 2. Configure Settings
1. Go to **WordPress Admin > Age Verification**
2. Set your minimum age (default: 18)
3. Set failure redirect URL (required)
4. Configure other settings as needed
5. Click **Save Changes**

### 3. Create Popup in Elementor
1. Go to **Elementor > Templates > Popups**
2. Click **Add New**
3. Choose a template or start from scratch
4. Add the **Age Verification Popup** widget (found in Age Verification category)
5. Customize the content and styling
6. Set display conditions (e.g., "Entire Site")
7. Publish the popup

### 4. Test the Popup
1. Visit your website in an incognito/private browser window
2. The popup should appear automatically
3. Test with different birth dates to verify functionality
4. Use the "Clear Verification Cookies" button in admin for testing

## Quick Configuration Tips

### Basic Setup (5 minutes)
- Minimum Age: 18
- Failure Redirect: https://www.google.com
- Show on Load: Yes
- Cookie Duration: 30 days

### Advanced Setup
- Customize all text content
- Style the popup to match your brand
- Set up custom redirect pages
- Configure trigger selectors for manual activation

## File Structure
```
age-verification-popup/
├── age-verification-popup.php (Main plugin file)
├── includes/
│   ├── admin-page.php
│   └── elementor-widget.php
├── assets/
│   ├── css/
│   │   ├── frontend.css
│   │   └── admin.css
│   └── js/
│       ├── frontend.js
│       └── admin.js
├── README.md
└── INSTALLATION.md
```

## Troubleshooting

**Plugin not appearing in Elementor:**
- Make sure Elementor is active and updated
- Deactivate and reactivate the plugin
- Clear Elementor cache

**Popup not showing:**
- Check popup display conditions in Elementor
- Clear browser cache and cookies
- Check browser console for JavaScript errors

**Need help?** Check the full README.md for detailed documentation and troubleshooting. 