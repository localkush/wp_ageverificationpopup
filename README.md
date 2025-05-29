# Age Verification Popup for WordPress & Elementor

**Version 1.1.0** - A comprehensive age verification popup plugin that integrates seamlessly with Elementor. Features advanced popup control, robust click handling, and a polished user experience.

## 🚀 What's New in v1.1.0

### Major Improvements
- **🎯 Precise Popup Control**: Added Elementor Popup ID setting for exact popup targeting
- **🛡️ Advanced Click Protection**: Implemented multi-layer event delegation to solve click interception issues  
- **💥 Nuclear Popup Closing**: Comprehensive 6-method popup closing system that always works
- **🔍 Smart Popup Prevention**: Verified users see no popup flash - completely blocked at source
- **🧪 Advanced Debugging**: Extensive console logging with emoji indicators for easy troubleshooting

### Technical Enhancements
- **Event Delegation**: Document-level click handling bypasses Elementor overlay issues
- **Multiple Event Listeners**: Capturing + bubbling phases with native JavaScript fallbacks
- **CSS Z-Index Fixes**: Automatic styling to ensure buttons are always clickable  
- **Popup Watcher**: MutationObserver detects and immediately closes popups for verified users
- **Cookie Management**: Enhanced verification persistence with private browsing detection

## 📋 Features

### Core Functionality
- ✅ **Age Verification**: Configurable minimum age requirement (default: 18)
- ✅ **Date Input**: Clean, accessible HTML5 date picker
- ✅ **Cookie Persistence**: Remembers verification for specified duration
- ✅ **Redirect Options**: Success and failure URL redirects
- ✅ **HTML Support**: Rich text messages with safe HTML tags

### Elementor Integration
- ✅ **Native Widget**: Dedicated Elementor widget with full editor support
- ✅ **Popup ID Control**: Specify exact Elementor popup ID for precise targeting
- ✅ **Live Preview**: Real-time preview in Elementor editor
- ✅ **Visual Styling**: Complete control over colors, typography, spacing, and layout
- ✅ **Responsive Design**: Works perfectly on all devices

### User Experience
- ✅ **No Flash for Verified Users**: Popup prevention system eliminates unwanted popups
- ✅ **Loading States**: Visual feedback during verification process
- ✅ **Error Handling**: Clear error messages with customizable templates
- ✅ **Accessibility**: ARIA labels and keyboard navigation support
- ✅ **Button Animations**: Visual feedback on user interactions

## 🛠️ Installation

1. Upload the plugin files to `/wp-content/plugins/age-verification-popup/`
2. Activate the plugin through the WordPress 'Plugins' menu
3. Go to WordPress Admin > **Tools > Age Verification** to access settings
4. In Elementor, add the "Age Verification Popup" widget to your popup template
5. Configure your popup ID in the widget settings for precise control

## ⚙️ Configuration

### Widget Settings

#### **Core Functionality Settings**
- **Minimum Age**: Set the required age (default: 18)
- **Success Redirect URL**: Where to redirect after successful verification
- **Failure/Cancel Redirect URL**: Where to redirect on failure or cancel
- **Cookie Duration**: How long verification lasts (in days)
- **🆕 Elementor Popup ID**: Specify your popup ID for precise control

#### **Content Settings**
- **Popup Title**: Customizable heading text
- **Popup Message**: Description text with HTML support (`<br>`, `<strong>`, etc.)
- **Date Input Label**: Label for the date field
- **Button Text**: Verify button text
- **Cancel Button Text**: Cancel/exit button text

#### **Success & Error Messages**
- **Success Message**: Shown on successful verification
- **Error Message Template**: Customizable with `{age}` placeholder

#### **Display Options**
- **Show on Page Load**: Automatic popup display
- **Trigger Element Selector**: CSS selector for manual triggers

### Styling Options
- **Container**: Width, background, borders, shadows, padding
- **Typography**: Fonts, colors, sizes for all text elements
- **Spacing**: Precise control over element spacing
- **Buttons**: Complete styling for both verify and cancel buttons
- **Responsive**: All settings work across devices

## 🔧 Advanced Features

### Popup ID Configuration
For precise popup control, find your Elementor popup ID:
1. Edit your popup in Elementor
2. Look at the URL: `post=123&action=elementor` - the popup ID is 123
3. Or inspect element and find `elementor-popup-modal-123`
4. Enter this ID in the widget's "Elementor Popup ID" field

### Debug Mode
The plugin includes comprehensive debugging. Open browser console to see:
- 🚀 Plugin initialization
- 🎯 Widget discovery and setup  
- 🔍 Element detection and event binding
- 🍪 Cookie management
- 🎯 Click event handling
- 🔒 Popup closing attempts

### Cookie Management
Clear verification for testing:
```javascript
clearAgeVerification() // Run in browser console
```

## 🐛 Troubleshooting

### Common Issues

**Buttons not working?**
- Check console for event binding logs
- Ensure popup ID is set correctly in widget settings
- Verify no conflicting JavaScript

**Popup still shows for verified users?**
- Set the Elementor Popup ID in widget settings
- Check cookie value in browser dev tools
- Clear browser cache and try again

**Popup flashes before closing?**
- The popup prevention system should eliminate this
- Ensure popup ID is configured correctly
- Check console for prevention system logs

### Browser Console Debugging
Look for these key indicators:
- ✅ `User already verified, hiding popup`
- 🎯 `Using specific popup ID prevention: 123`
- 🛡️ `Popup prevention measures activated`

## 📱 Browser Support

- **Modern Browsers**: Chrome, Firefox, Safari, Edge (latest 2 versions)
- **Date Input**: HTML5 date picker with graceful fallback
- **CSS Features**: Modern CSS with fallbacks for older browsers
- **JavaScript**: ES6+ with transpilation for broader support

## 🔒 Security Features

- **Input Sanitization**: All user inputs are properly escaped
- **XSS Protection**: Safe HTML rendering with wp_kses()
- **Cookie Security**: SameSite and Secure flags when appropriate
- **Age Validation**: Client and server-side age verification

## 🎯 Use Cases

- **Adult Content Sites**: Age verification for mature content
- **Alcohol/Tobacco**: Legal age verification for related products  
- **Gaming Sites**: Age verification for age-restricted games
- **Pharmaceutical**: Age verification for certain medications
- **General Compliance**: Any site requiring age verification

## 🤝 Contributing

This plugin was developed through extensive debugging and testing to solve real-world Elementor integration challenges. The codebase includes comprehensive logging and fallback systems for maximum reliability.

## 📄 License

GPL v2 or later - https://www.gnu.org/licenses/gpl-2.0.html

## 🆕 Changelog

### Version 1.1.0 (Current)
- **🎯 NEW**: Elementor Popup ID setting for precise popup control
- **🛡️ FIXED**: Major click interception issues with Elementor overlays
- **💥 IMPROVED**: Comprehensive 6-method popup closing system  
- **🔍 ENHANCED**: Smart popup prevention for verified users (no flash)
- **🧪 ADDED**: Advanced debugging with detailed console logging
- **⚡ OPTIMIZED**: Event delegation and multi-layer click handling
- **🎨 ENHANCED**: Visual button feedback and improved UX

### Version 1.0.5
- Added HTML support for popup messages
- Fixed popup closing issues
- Improved age calculation accuracy
- Enhanced error handling

### Version 1.0.0 - 1.0.4
- Initial release with core functionality
- Elementor widget integration
- Basic styling options
- Cookie-based verification

---

**Built with ❤️ for the WordPress & Elementor community** 