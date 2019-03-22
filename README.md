# Hack for a Cause 2018 Team Dumpster Fire

We are addressing the Trans*Ponder Community Resource Challenge

Team Members:
- Ben Pearson           ben@idxbroker.com
- Aaron Flager          aaron@idxbroker.com
- Allen McNichols       allen@idxbroker.com
- Shannon Sallaway      shannon@idxbroker.com
- Bishop Lafer          bishop@idxbroker.com
- frankie               frankie@idxbroker.com
- Seabastion Miller     seabastion.miller@gmail.com

We are using the following components:
- WordPress
- Gravity Forms
- FlyWheel Hosting
- Ultimate Member
- User Switching
- Uncode Theme
- Custom Plugin Created 
- Gravity Wiz Add Ons

## Documentation

### Activating the Plugin (Trans*Ponder Volunteer/Admin Area)
1. Copy over everything in the transponder-admin folder. This contains all the plugin code.
1. Activate plugin via Wordpress admin page > Plugins
1. Activating the plugin should have created the wp_a3t9xkcyny_providers_table table. Verify it is there.
1. Start entering data by following the Steps for Publishing a Card in the Resource Directory

### Make fields in the Submit Resource forms required or not
1. Go to Forms in the WP admin menu
1. Click on  Resource Submission and Review Form
1. Click on the little triangle on the top right part of the form
1. Check or uncheck the "Required" box
1. Click "Update" button on the right hand side

### Steps for Publishing a Card in the Resource Directory
1. Community member submits a resource through Resource Directory > Submit a Resource
1. Log in as Volunteer or Admin
1. Click on the Community Resource plugin icon to display menu options, Admin, Volunteer, and Live
1. Click on the Volunteer menu item
1. Select an entry to edit
1. Contact the Provider
1. Ask relevant questions and update the form
1. etc.

### Steps for Removing Cards
1. Log in as Volunteer or Admin
1. Go to Posts (left menu bar)
1. Filter by category
1. Click trash button on the post (card) you want to remove

### Steps for Adding a New Category (Service Type)
1. Add Service Type in forms
1. Add category in the Posts > Categories (left menu bar)
1. Edit the transponder-admin-2.php array called $translation in the get_category() method. This will translate what the Post Categories are named and the Category submitted through the form

### Steps for Deleting a Resource Submission
1. Identify the ENTRY_ID and delete all rows with that ENTRY_ID in the wp_a3t9xkcyny_gf_entry_meta table
1. Delete the row in wp_a3t9xkcyny_gf_entry with the id that is the same as the ENTRY_ID above
1. Delete the row in wp_a3t9xkcyny_providers_table with the LEAD_ID that is the same as ENTRY_ID above

### Steps for Adding a New Faith in the Drop Down Menu
1. In the transponder-admin-2.php file, Add columns to the providers_table in three methods. The columns should be in the IDENTIFIES_AS_WHAT_FAITH_17 format, where the number part is incremented from what is already there.
1. Add more checkbox items in the Gravity Form
1. Insert new columns in the providers_table in database
1. Add columns 

### Steps for Editing an Entry After it is Published
1. Go to the Live and Archived List in the plugin menu
1. Click Edit on the entry you wish to edit and make the desired changes
1. When submitting the edit, a new post (card) will be published. Be sure to delete the old one by going through Steps for Deleting a Resource Submission

### Trans*Ponder Volunteer/Admin Area Plugin Backend Structure
- The theme used is uncode in /transponder/wp-content/themes/uncode
- The plugin code is located in two places: (1) /transponder/wp-content/plugins/transponder-admin/transponder-admin.php, (2) /transponder/wp-content/plugins/transponder-admin/includes/transponder-admin-2.php
- The database tables used are wp_a3t9xkcyny_gf_entry_meta (populated by gravity forms), wp_a3t9xkcyny_gf_entry (populated by gravity forms), and wp_a3t9xkcyny_providers_table (created and updated by the Trans*Ponder Admin Plugin).

### Adding and/or Removing Columns in wp_a3t9xkcyny_providers_table
1. The creation of wp_a3t9xkcyny_providers_table upon activation of the plugin will need to be updated. This is in the function create_providers_table().
1. Adjust the add_or_update_entries_to_db() 
1. Adjust the function update_entries_in_db()

