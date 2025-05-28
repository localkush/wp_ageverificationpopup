# Age Verification Popup for Elementor

A powerful and customizable WordPress plugin that adds age verification functionality to your website using Elementor Pro. Perfect for websites that need to verify visitors are 18+ (or any configurable age) before allowing access.

## Features

### 🎯 Core Functionality
- **Configurable Age Verification**: Set minimum age (13-25 years)
- **Birth Date Input**: Users enter their actual birth date for verification
- **Smart Cookie Management**: Remember verification for configurable duration (1-365 days)
- **Flexible Redirects**: Configure different redirect URLs for pass/fail scenarios
- **Elementor Integration**: Full Elementor widget with extensive styling options

### 🎨 Design & Customization
- **Modern UI**: Beautiful, responsive popup design
- **Extensive Styling Options**: Colors, typography, spacing, borders, shadows
- **Mobile Responsive**: Optimized for all device sizes
- **Dark Mode Support**: Automatic dark mode detection
- **Accessibility**: WCAG compliant with keyboard navigation and screen reader support

### ⚙️ Advanced Settings
- **Multiple Trigger Options**: Show on page load or via custom CSS selector
- **Global Settings**: Configure defaults in WordPress admin
- **Widget Override**: Each widget can override global settings
- **Preview Mode**: Works seamlessly in Elementor editor
- **Developer Friendly**: Custom events and hooks for developers

## Installation

### Method 1: Upload Plugin Files
1. Download the plugin files
2. Upload the `age-verification-popup` folder to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure settings under 'Age Verification' in the admin menu

### Method 2: WordPress Admin Upload
1. Go to Plugins > Add New > Upload Plugin
2. Choose the plugin zip file and upload
3. Activate the plugin
4. Configure settings

## Requirements

- WordPress 5.0 or higher
- Elementor 3.0.0 or higher
- PHP 7.4 or higher
- Modern web browser with JavaScript enabled

## Quick Start Guide

### Step 1: Configure Global Settings
1. Go to **WordPress Admin > Age Verification**
2. Set your preferred defaults:
   - Minimum age (default: 18)
   - Success redirect URL (optional)
   - Failure redirect URL (required)
   - Cookie duration (default: 30 days)
   - Default text content

### Step 2: Create Elementor Popup
1. Go to **Elementor > Templates > Popups**
2. Create a new popup template
3. Add the **Age Verification Popup** widget
4. Customize styling and settings as needed
5. Set popup display conditions

### Step 3: Configure Widget Settings
The widget provides these configuration options:

#### Content Settings
- **Popup Title**: Main heading text
- **Popup Message**: Descriptive text explaining age requirement
- **Date Input Label**: Label for birth date field
- **Button Text**: Text for verification button
- **Cancel Button Text**: Text for cancel/under-age button

#### Behavior Settings
- **Minimum Age**: Override global setting (13-25)
- **Success Redirect**: Where to send verified users
- **Failure Redirect**: Where to send underage users
- **Cookie Duration**: How long to remember verification
- **Show on Load**: Display popup automatically
- **Trigger Selector**: CSS selector for manual trigger

#### Styling Options
- **Popup Container**: Width, background, borders, shadows, padding
- **Overlay**: Background color and blur effects
- **Typography**: Separate controls for title and message text
- **Buttons**: Colors, hover effects, borders, spacing

## Usage Examples

### Basic Age Gate
```php
// Simple 18+ verification with redirect to Google for underage users
// Configure in widget:
// - Minimum Age: 18
// - Failure Redirect: https://www.google.com
// - Show on Load: Yes
```

### Custom Age Requirement
```php
// 21+ verification for alcohol-related content
// Configure in widget:
// - Minimum Age: 21
// - Popup Title: "Age Verification Required"
// - Popup Message: "You must be 21 or older to view this content."
// - Failure Redirect: https://example.com/underage-page
```

### Manual Trigger
```php
// Show popup when user clicks a specific button
// Configure in widget:
// - Show on Load: No
// - Trigger Selector: .age-verify-trigger
// 
// Add this class to any element to trigger the popup
```

## Customization

### CSS Customization
You can override default styles using CSS:

```css
/* Customize popup appearance */
.avp-popup-content {
    border-radius: 20px !important;
    box-shadow: 0 30px 80px rgba(0,0,0,0.4) !important;
}

/* Custom button styling */
.avp-verify-btn {
    background: linear-gradient(45deg, #ff6b6b, #ee5a24) !important;
}

/* Mobile-specific adjustments */
@media (max-width: 768px) {
    .avp-popup-content {
        margin: 10px !important;
    }
}
```

### JavaScript Events
The plugin triggers custom events you can listen to:

```javascript
// Listen for successful verification
$(document).on('avp:verified', function(event, data) {
    console.log('User verified!', data.widget);
    // Custom logic here
});

// Listen for failed verification
$(document).on('avp:failed', function(event, data) {
    console.log('User failed verification', data.widget);
    // Custom logic here
});
```

### PHP Hooks
Developers can use WordPress hooks to extend functionality:

```php
// Modify verification logic
add_filter('avp_verify_age', function($is_verified, $birth_date, $minimum_age) {
    // Custom verification logic
    return $is_verified;
}, 10, 3);

// Customize redirect behavior
add_filter('avp_success_redirect', function($url, $widget_settings) {
    // Custom redirect logic
    return $url;
}, 10, 2);
```

## Troubleshooting

### Common Issues

**Popup not showing:**
- Check if Elementor is active and up to date
- Verify popup display conditions in Elementor
- Clear browser cache and cookies
- Check for JavaScript errors in browser console

**Styling issues:**
- Check for theme CSS conflicts
- Use browser developer tools to inspect elements
- Try adding `!important` to custom CSS rules
- Verify Elementor widget styling settings

**Verification not working:**
- Check browser JavaScript console for errors
- Verify AJAX functionality is working
- Clear verification cookies for testing
- Check WordPress admin settings

### Debug Mode
Enable WordPress debug mode to see detailed error messages:

```php
// Add to wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Security Considerations

- Age verification is client-side and should not be relied upon for legal compliance
- Consider server-side verification for sensitive content
- Use HTTPS for all verification-related pages
- Regularly update the plugin for security patches

## Performance

- Lightweight: ~15KB total JavaScript and CSS
- Optimized images and assets
- Minimal database queries
- Efficient cookie management
- Mobile-optimized animations

## Support

For support, feature requests, or bug reports:

1. Check the troubleshooting section above
2. Search existing issues in the support forum
3. Create a new support ticket with:
   - WordPress version
   - Elementor version
   - Plugin version
   - Detailed description of the issue
   - Steps to reproduce

## Changelog

### Version 1.0.0
- Initial release
- Elementor widget integration
- Configurable age verification
- Responsive design
- Admin settings panel
- Cookie management
- Multiple styling options

## License

This plugin is licensed under the GPL v2 or later.

## Credits

Developed with ❤️ for the WordPress community.

---

**Note**: This plugin provides client-side age verification and should not be considered legally binding. For compliance with age restriction laws, consult with legal professionals and consider additional server-side verification methods. 