# Trans*ponder WordPress Plugin Development Branch

### Objectives:
1. Accept public submissions for resources (no registration required)
..1. Google reCaptcha and anti-spam honey pot enabled
2. Route these submissions based on if they are a provider or not
3. Send a notification to volunteers so they are aware of new resource submissions
..1. Notification email will have a link that will take them directly to the submitted form for review
4. Provide additional fields to our volunteer to reach out to the provider for a followup
..1. Need to populate the form with as much information as we can from the public submissions
5. Volunteer will then determine if this submission meets the minimum requirements to be posted
..1. If it doesn't we can store the submission in the database
..2. If it does we need to notify an Admin to give the final verdict
..3. Notification will have a link that will allow the Admin to go straight to the review
6. Form is populated with the information provided from both the community and our volunteer
7. Admin will be able to add additional information
8. If the submission meets the minimum requirements for posting then the Admin can approve and post the submission
..1. The posted submission will go into a custom post type that only displays the following
...1. The title that was entered by the Admin
...2. The comments left by the community reporter
...3. Then tagged by Service Provider
..2. If the submission does not meet these requirements it is then stored in the database

Completion: 78%

Outstanding Issues:
1. Need to get fields from forms and dump to a custom table for storage
2. Need to remove submissions from review sections after they have been processed
3. Styling and adjustments to be more pleasing to work with
4. Create an archives page to show providers by tag
5. Pull in more information when creating the published post