# Elementor Setup Guide for Trip Kailash Theme

## Initial Setup Steps

### 1. Elementor Global Settings

Go to **Elementor > Settings > Style**:
- **Content Width**: Set to `100%` or `1920px`
- **Space Between Widgets**: Set to `0`
- **Page Title Selector**: Leave as default

### 2. Page Settings (For Each Page)

When editing a page in Elementor:

1. Click the **Settings icon** (gear) in the bottom left
2. Go to **Settings** tab:
   - **Page Layout**: Select "Elementor Canvas" (no header/footer from theme)
   
3. Go to **Style** tab:
   - **Content Width**: `100%`
   - **Padding**: `0px` on all sides

### 3. Section Settings (For Hero Video Section)

1. Click on the **section handle** (blue square on the left of the section)
2. Go to **Layout** tab:
   - **Content Width**: Select "Full Width"
   - **Column Gap**: "No Gap"
   - **Height**: "Fit To Screen" or "Min Height" with `100vh`
   
3. Go to **Advanced** tab:
   - **Margin**: `0px` on all sides
   - **Padding**: `0px` on all sides
   - **Z-Index**: Leave as default

### 4. Column Settings

1. Click on the **column**
2. Go to **Advanced** tab:
   - **Padding**: `0px` on all sides
   - **Margin**: `0px` on all sides

### 5. Widget Settings (Hero Video Widget)

1. Add the **Hero Video** widget
2. The widget automatically applies full-width styles
3. No additional settings needed

## Troubleshooting White Space

If you still see white space after following the above steps:

### Option 1: Regenerate Elementor CSS
1. Go to **Elementor > Tools**
2. Click **Regenerate CSS & Data**
3. Clear your browser cache (Ctrl+Shift+Delete)
4. Hard refresh the page (Ctrl+F5)

### Option 2: Check Page Template
1. In the page editor, click **Settings** (gear icon)
2. Under **Page Attributes**, ensure **Template** is set to "Elementor Canvas"

### Option 3: Inspect Element
1. Right-click on the white space
2. Select "Inspect" or "Inspect Element"
3. Look for elements with padding or margin
4. Note the class names and let us know

## Common Issues

### Issue: White space on top
**Cause**: WordPress admin bar or page padding
**Solution**: 
- The theme automatically adjusts for admin bar
- Make sure page padding is set to 0 in page settings

### Issue: White space on sides
**Cause**: Elementor container width or section padding
**Solution**:
- Set section to "Full Width" layout
- Set section padding to 0
- Set container width to 100%

### Issue: White space persists after all settings
**Cause**: Cached CSS or inline styles
**Solution**:
1. Delete the widget and re-add it
2. Regenerate Elementor CSS
3. Clear all caches (browser, WordPress, CDN)
4. Check if there's a caching plugin active

## Starting Fresh

If nothing works, here's how to start fresh:

1. **Delete the current page** or create a new one
2. **Set page template** to "Elementor Canvas"
3. **Add a new section**:
   - Layout: Full Width
   - Height: Fit To Screen
   - Padding: 0 on all sides
   - Margin: 0 on all sides
4. **Add the Hero Video widget**
5. **Configure the widget** with your content
6. **Publish** and test

## CSS Override (Last Resort)

If Elementor's inline styles are too aggressive, the theme includes an `elementor-overrides.css` file that uses `!important` to force full width. This should work automatically, but if not:

1. Check if the file is being loaded (inspect page source)
2. Make sure it's imported in `main.css`
3. Clear all caches

## Support

If you're still experiencing issues:
1. Take a screenshot showing the white space
2. Right-click the white space and inspect element
3. Share the HTML structure and CSS being applied
4. We can provide more specific fixes
