# Page Duplication Feature Guide

## Overview

The page duplication feature allows you to quickly duplicate any post or page in WordPress, including all Elementor widgets, layouts, custom fields, and taxonomies. This is especially useful for creating new pilgrimage packages based on existing templates.

## How to Use

### Duplicating a Page

1. Go to the WordPress admin dashboard
2. Navigate to **Pages** or **Pilgrimage Packages** (or any post type)
3. Hover over the page/post you want to duplicate
4. Click the **Duplicate** link that appears in the row actions
5. You'll be redirected to the edit screen of the newly created duplicate

### What Gets Duplicated

The duplication process copies:

- ✅ Post title (with " (Copy)" appended)
- ✅ Post content
- ✅ Post excerpt
- ✅ All Elementor widgets and layouts
- ✅ All Elementor settings (custom CSS, responsive settings, etc.)
- ✅ All custom meta fields (trip_length, deity, difficulty, etc.)
- ✅ Featured image
- ✅ Categories and tags
- ✅ Custom taxonomies

### What Doesn't Get Duplicated

For security and data integrity, these items are NOT copied:

- ❌ Post ID (new ID is generated)
- ❌ Publication status (always set to "draft")
- ❌ Edit locks
- ❌ Old slugs
- ❌ Author (set to current user)

## Features

### Draft Status
All duplicated pages are created as **drafts** to prevent accidental publication. You can review and edit the content before publishing.

### Title Suffix
The duplicated page title automatically gets " (Copy)" appended to distinguish it from the original.

### Elementor Compatibility
All Elementor data is preserved, so you can immediately edit the duplicated page in Elementor without rebuilding the layout.

### Error Handling
- If you don't have permission, you'll see an error message
- If the original post doesn't exist, you'll be notified
- If Elementor data is missing, you'll see a warning (but the page is still created)

## Notifications

After duplication, you'll see one of these messages:

- **Success**: "Post duplicated successfully!" (green notice)
- **Error**: "The original post could not be found." (red notice)
- **Warning**: "Post duplicated, but no Elementor data was found in the original post." (yellow notice)

## Use Cases

### Creating Similar Pilgrimage Packages
1. Duplicate an existing pilgrimage package
2. Edit the title, description, and specific details
3. Update the Elementor widgets with new content
4. Publish when ready

### Testing Page Variations
1. Duplicate a page to create a test version
2. Make experimental changes to the duplicate
3. Compare with the original
4. Keep the version you prefer

### Backing Up Before Major Changes
1. Duplicate a page before making significant edits
2. Make your changes to the original
3. If something goes wrong, you have the duplicate as backup

## Technical Details

- **Location**: `inc/page-duplication.php`
- **Permissions**: Requires `edit_posts` capability
- **Security**: Uses WordPress nonces for CSRF protection
- **Logging**: Errors are logged to PHP error log for debugging

## Troubleshooting

### "Duplicate" Link Not Showing
- Make sure you're logged in as an administrator
- Check that you have the `edit_posts` capability

### Elementor Data Not Copied
- Verify the original page was built with Elementor
- Check that Elementor is active and up to date

### Permission Denied Error
- Ensure your user account has administrator privileges
- Contact your site administrator if needed

## Support

For issues or questions about this feature, check the PHP error logs at:
- `logs/php/error.log`

All duplication errors are logged with the prefix "Page Duplication:" for easy identification.
