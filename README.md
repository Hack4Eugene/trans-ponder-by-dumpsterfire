# Hack for a Cause 2018 Team Dumpster Fire

We are addressing the Trans*Ponder Community Resource Challenge

Team Members:
- Ben Pearson           ben@idxbroker.com
- Aaron Flager          aaron@idxbroker.com
- Allen McNichols       allen@idxbroker.com
- Shannon Sallaway      shannon@idxbroker.com
- Bishop Lafer          bishop@idxbroker.com
-           frankie@idxbroker.com
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

### Steps for Publishing a Card in the Resource Directory
1. Community member submits a resource
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
1. Edit the transponder-admin-2.php array called $translation in the get_category() method.

### Steps for Adding a New Faith in the Drop Down Menu
1. In the transponder-admin-2.php file, Add columns to the providers_table in three methods. The columns should be in the IDENTIFIES_AS_WHAT_FAITH_17 format, where the number part is incremented from what is already there.
1. Add more checkbox items in the Gravity Form
1. Insert new columns in the providers_table in database
1. Add columns 
